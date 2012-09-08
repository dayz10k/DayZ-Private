<?php

defined('DS') ? null : define('DS',DIRECTORY_SEPARATOR);
$path = "";
$sitename = "DayZ Administration";

$serverip = "127.0.0.1";
$serverport = 2302;
$hostname = "127.0.0.1";
$username = "dayz";
$password = "123456";
$rconpassword = "adminpass";
$dbName = "dayz";

$serverpath = "";
$serverexe = "arma2oaserver.exe";
$serverexepath = "";
$serverstring = " -beta=Expansion".DS."beta;Expansion".DS."beta".DS."Expansion -mod=@DayZ;@DAyZ_Blizzard; -name=Server -config=config.cfg -cfg=basic.cfg -profiles=Server -port=2302 -cpuCount=2 -maxMem=2048";
$serverconfig = "config.cfg";

$becpath = "";
$becexe = "BEC.exe";
$becstring = " -f config.cfg";

?>