<?
	// Thanks to user WarZ for parts of his code and TorZar for giving me ideas on howto solve a problem!
	error_reporting(E_ALL ^ E_NOTICE);

	if (file_exists($pathlogrpt))
	{
		$lines = file($pathlogrpt);
		$markers = "";
		$i = 0;
		
		$s = 0;
		foreach ($lines as $line) {
			if (strpos($line,"SERVER: VERSION") !== false) {$i = $s;}
			$s++;
		}

		$s = 0;
		foreach ($lines as $line) {
			$matches = array();
			$sectionpattern = "/((?<=[a-z]{10}\s[a-z]{2}\s\[)[0-9]{0,20}+\.+[0-9]{0,10}+\,+[0-9]{0,20}+\.+[0-9]{0,10})/x";
			
			if ($s > $i) {
				if (preg_match($sectionpattern, $line, $matches)) {
					$Worldspace = explode(",", $matches[1]);
					$x = 0; if(array_key_exists(0, $Worldspace)) {$x = $Worldspace[0];}
					$y = 0; if(array_key_exists(1, $Worldspace)) {$y = $Worldspace[1];}
	
					include_once('modules/calc.php');
					$description = "<h2>Wreck</h2><table><tr><td><img style='width: 100px;' src='images/vehicles/Crashsite.png'></td><td>&nbsp;&nbsp;&nbsp;</td><td style='vertical-align:top;'><h2>Position:</h2>Left: ".round(world_x($x, $serverworld))."<br />Top: ".round(world_y($y, $serverworld))."</td></tr></table>";
					$markers .= 'L.marker(['.$x.', '.$y.'], {icon: Wreck, title: "Wreck"}).addTo(map).bindPopup("'.$description.'"); ';
				}
			}
			$s++;
		}

		include('modules/leaf.php');
	}
	else
	{
		echo "<div id='page-heading'><h2>Log file not found</h2></div>";
	}
?>