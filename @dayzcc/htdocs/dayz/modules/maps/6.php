<?php
	error_reporting(E_ALL ^ E_NOTICE);

	$pathlog = str_replace('.exe', '.rpt', $pathserver);

	// Thanks to user WarZ for parts of his code!
	if (file_exists($pathlog))
	{
		$lines = file($pathlog);
		$markers = '';
		$start = 0;
		$i = 0;
		
		foreach ($lines as $line) {
			if (strpos($line, "SERVER: VERSION:") !== false) {$start = $i;}
			$i++;
		}
		
		$lines = array_slice($lines, $start);

		foreach ($lines as $line) {
			$matches = array();
			$sectionpattern = "/((?<=\sat\s\[)[0-9]{0,20}+\.+[0-9]{0,10}+\,+[0-9]{0,20}+\.+[0-9]{0,10})/x"; // Only helicopter crashsites: "/((?<=[a-z]{10}\s[a-z]{2}\s\[)[0-9]{0,20}+\.+[0-9]{0,10}+\,+[0-9]{0,20}+\.+[0-9]{0,10})/x"
	
			if (preg_match($sectionpattern, $line, $matches) && !(strpos($line, "Misc_cargo_cont_net") !== false)) {
				$Worldspace = explode(",", $matches[1]);
				$x = 0; if (array_key_exists(0, $Worldspace)) {$x = $Worldspace[0];}
				$y = 0; if (array_key_exists(1, $Worldspace)) {$y = $Worldspace[1];}

				require_once('/modules/calc.php');
				$description = '<h2>Wreck</h2><table><tr><td><img style="width: 100px;" src="images/vehicles/Crashsite.png"></td><td>&nbsp;&nbsp;&nbsp;</td><td style="vertical-align:top;"><h2>Position:</h2>Left: '.round(world_x($x, $serverworld)).'<br />Top: '.round(world_y($y, $serverworld)).'</td></tr></table>';
				$markers .= "L.marker([".(world_y($y, $serverworld) / 10).", ".(world_x($x, $serverworld) / 10)."], {icon: Wreck, title: 'Wreck'}).addTo(map).bindPopup('".$description."'); ";
			}
		}

		include ('/modules/leaf.php');
	}
	else
	{
		echo "<div id='page-heading'><h2>Log file not found</h2></div>";
	}
?>