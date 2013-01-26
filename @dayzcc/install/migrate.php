<?php

/**
 * Tiny database migration script by Crosire
 */

chdir(dirname(__FILE__));

$args = getopt("", array("host:", "port:", "username:", "password:", "database:", "schema:"));
$path_schema = "schema";
$path_mysql = "..\\mysql\\bin\\mysql.exe";

$dbhost = (isset($args['host']) ? $args['host'] : "127.0.0.1");
$dbport = (isset($args['port']) ? $args['port'] : "3306");
$dbuser = (isset($args['username']) ? $args['username'] : "dayz");
$dbpass = (isset($args['password']) ? $args['password'] : "");
$dbname = (isset($args['database']) ? $args['database'] : "dayz_chernarus");
$schema = (isset($args['schema']) ? $args['schema'] : "Bliss");
$version = "0.00";

// Connect to the MySQL server
echo "Connecting to MySQL server on ".$dbhost." as ".$dbuser." to database ".$dbname."\n";
$link = mysql_connect($dbhost, $dbuser, $dbpass);
if (!$link) {
	echo "> Could not connect: ".(mysql_error())."\n";
	exit(1);
}
mysql_select_db($dbname, $link);
echo "> Sucessfully connected!\n\n";

// Get the last version
$res = mysql_query("SELECT `version` FROM `migration_schema_version` WHERE `name` = '".$schema."'", $link);
if (!$res) {
	echo "No existing ".$schema." schema was found!\n";
} else {
	$version = rtrim(mysql_fetch_assoc($res)['version'], "0");
	echo "Current ".$schema." version is: $version\n";
}

function get_folders() {
	global $path_schema, $schema;
	$folders = array();
	foreach(scandir($path_schema."\\".$schema."\\mysql") as $dir) {
		if (is_dir($path_schema."\\".$schema."\\mysql\\".$dir)) {
			if (preg_match("/([.0-9]{4})-?([.0-9]{4})?/", $dir, $matches)) {
				if (isset($matches[2])) { $folders[] = array($matches[2], $dir); } else { $folders[] = array($matches[1], $dir); };
			}
		}
	}
	return $folders;
}
function get_files($dir) {
	global $path_schema, $schema;
	$files = array();
	$handle = opendir($path_schema."\\".$schema."\\mysql\\".$dir);
	while (false !== ($file = readdir($handle))) {
		if (preg_match("/([0-9]+)_([_a-zA-Z0-9]*).sql/", $file)) {
			$files[] = array($file, $path_schema."\\".$schema."\\mysql\\".$dir."\\".$file);
		}
	}
	closedir($handle);
	return $files;
}

// Run migration proces
echo "\nRunning database migration ...\n";
$res = mysql_query("CREATE DATABASE IF NOT EXISTS `".$dbname."`", $link);
if (!$res) {
	echo "> Database Creation failed: ".(mysql_error())."\n";
	exit(2);
}
mysql_select_db($dbname, $link);
mysql_query("GRANT ALL PRIVILEGES ON ".$dbname.".* TO 'dayz'@'localhost' IDENTIFIED BY 'dayz'", $link);
mysql_query("GRANT ALL PRIVILEGES ON mysql.* TO 'dayz'@'localhost'", $link);

// Execute sql files in schema folder
foreach (get_folders() as $folder) {
	if ($folder[0] > $version) {
		foreach (get_files($folder[1]) as $file) {
			echo "> ".$folder[1]."\\".$file[0]."\n";
			$output = shell_exec($path_mysql." --host={$dbhost} --port={$dbport} --user={$dbuser} --password={$dbpass} {$dbname} < {$file[1]}");
		}
		$oldversion = $version;
		$version = $folder[0];
		mysql_query("INSERT INTO `migration_schema_log` (`schema_name`, `event_time`, `old_version`, `new_version`) VALUES ('".$schema."', NOW(), '".$oldversion."', '".$version."')", $link);
	}
}

// Output the new version number and exit
mysql_query("INSERT INTO `migration_schema_version` (`name`, `version`) VALUES ('".$schema."', '".$version."') ON DUPLICATE KEY UPDATE `version` = '".$version."'", $link);
mysql_close($link);

echo "> Completed ".$schema." update to version ".$version."\n";
exit;

?>