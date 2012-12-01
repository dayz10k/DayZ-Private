<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php
session_start();

defined('DS') ? null : define('DS',DIRECTORY_SEPARATOR);
$sitename = "DayZ CC Administration";

include ('config.php');

mysql_connect($dbhost.':'.$dbport, $dbuser, $dbpass) or die (mysql_error());
mysql_select_db($dbname) or die (mysql_error());

if (isset($_GET['logout']))
{
	mysql_query("INSERT INTO `log_tool` (`action`, `user`, `timestamp`) VALUES ('LOGOUT', '{$_SESSION['login']}', NOW())");
	
	if (isset($_SESSION['user_id'])) {unset($_SESSION['user_id']);}
		
	setcookie('login', '', 0, "/");
	setcookie('password', '', 0, "/");
	header('Location: index.php');
	exit;
}

if (isset($_SESSION['user_id']))
{
	// Include functions
	include ('/modules/rcon.php');
	include ('/modules/tables/rows.php');
	include ('/modules/maps/markers.php');
	
	function slashes(&$el)
	{
		if (is_array($el)) {foreach($el as $k => $v) {slashes($el[$k]);}} else {$el = stripslashes($el);}
	}

	if (ini_get('magic_quotes_gpc'))
	{
		slashes($_GET);
		slashes($_POST);    
		slashes($_COOKIE);
	}

	if (isset($_GET["show"])){
		$show = $_GET["show"];
	} else {
		$show = 0;
	}
	
	$exeserver = str_replace('.exe', "_".$serverinstance.".exe", $exeserver);
	$pathserver = str_replace('.exe', "_".$serverinstance.".exe", $pathserver);
	$exebec = str_replace('.exe', "_".$serverinstance.".exe", $exebec);
	$pathbec = str_replace('.exe', "_".$serverinstance.".exe", $pathbec);

		
	// Start page-header 
	include ('/modules/header.php');
	// End page-header
	
	?>
	
	<div id="content-outer">
		<div id="content">
		<?php
			if (isset($_GET['view'])){
				include ('/modules/'.$_GET["view"].'.php');
			} else {
				include ('/modules/dashboard.php');
			}

			// Start page-footer 
			include ('/modules/footer.php');
			// End page-footer
		?>
		</div>
	</div>
	<div class="clear">&nbsp;</div>

<?php
}
else
{
	include ('modules/login.php');
}
?>