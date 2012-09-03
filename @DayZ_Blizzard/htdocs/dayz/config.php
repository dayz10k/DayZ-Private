<?php
	defined('DS') ? null : define('DS',DIRECTORY_SEPARATOR);
	$path = "";

	$serverip = "127.0.0.1";
	$serverport = 2302;
	$rconpassword = "adminpass";

	$hostname = "127.0.0.1";
	$username = "dayz";
	$password = "123456";
	$dbName = "dayz";

	$sitename = "DayZ Administration";

	$gamepath = "";
	$gameexe = "arma2oaserver.exe";
	$exepath = "";

	$serverstring = " -beta=Expansion".DS."beta;Expansion".DS."beta".DS."Expansion -mod=@DayZ;@DAyZ_Blizzard; -name=Server -config=config.cfg -cfg=basic.cfg -profiles=Server -port=2302 -cpuCount=2 -maxMem=2048";
	$config = "config.cfg";
?>