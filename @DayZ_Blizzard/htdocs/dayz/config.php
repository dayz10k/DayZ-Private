<?php
	defined('DS') ? null : define('DS',DIRECTORY_SEPARATOR);
	$path = ""; 				//path to the files, ex. "/admin/"

	$serverip = "127.0.0.1";  		//server host
	$serverport = 2302; 			//server port
	$rconpassword = "adminpass"; 		//rcon password

	$hostname = "127.0.0.1";  		//database host
	$username = "dayz"; 			//database user
	$password = "123456"; 			//database password
	$dbName = "dayz"; 			//database name

	$sitename = "DayZ Administration"; 	//Admin panel name

	$gamepath = "";				//path to the game
	$gameexe = "arma2oaserver.exe"; 	//server executable name
	$exepath = ""; 				//executable path

	$serverstring = " -beta=Expansion".DS."beta;Expansion".DS."beta".DS."Expansion -mod=@DayZ;@DAyZ_Blizzard; -name=Server -config=config.cfg -cfg=basic.cfg -profiles=Server -cpuCount=2 -maxMem=1578"; //server startup parametres
	$config = "config.cfg"; 		//server config file
?>