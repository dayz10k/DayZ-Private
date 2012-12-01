<?php
	error_reporting (E_ALL ^ E_NOTICE);

	$res = mysql_query($query) or die(mysql_error());
	$markers = markers_vehicle($res, $serverworld);

	include ('/modules/leaf.php');
?>