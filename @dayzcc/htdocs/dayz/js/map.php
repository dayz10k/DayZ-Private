<?php
	error_reporting (0);
	defined('DS') ? null : define('DS',DIRECTORY_SEPARATOR);
	chdir("..");
	
	$markers = array();
	$callback = "";
	$id = 0;
	
	require_once("config.php");
	require_once("modules/rcon.php");
	require_once("modules/maps/markers.php");
	
	$pathserver = str_replace('.exe', "_{$serverinstance}.exe", $pathserver);

	mysql_connect($dbhost.':'.$dbport, $dbuser, $dbpass) or die;
	mysql_select_db($dbname) or die;

	if (isset($_GET['id'])) {
		$tmp = intval($_GET['id']);
		if ($tmp >= 0 && $tmp <= 7) { $id = $tmp; }
	}
	
	if (isset($_GET['callback'])) {
		$callback = $_GET['callback'];
	}

	include("modules/maps/{$id}.php");

	echo $callback.'('.(json_encode($markers)).')';
?>