<?php

$pathlog = str_replace('.exe', '.rpt', $pathserver);
$markers = array();

if (file_exists($pathlog))
{
	$lines = file($pathlog);
	$start = 0;
	$i = 0;
	
	foreach ($lines as $line) { 
		if (strpos($line, "SERVER: VERSION:") !== false) { $start = $i; }
		$i++;
	}
	
	$lines = array_slice($lines, $start);
	$markers = markers_wreck($lines, $serverworld);
}
else
{
	$markers["error"] = "<div id='page-heading'><h2>Logfile not found.</h2></div>";
}

?>