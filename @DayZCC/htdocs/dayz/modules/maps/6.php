<?
	// Thanks to user WarZ for his code!
	error_reporting(E_ALL ^ E_NOTICE);

	if (file_exists($path_logrpt))
	{
		$lines = file($path_logrpt);
		$markers = "var markers = [";
		$k = 0;
		
		foreach ($lines as $line):
			$matches = array();
			$sectionpattern = "/((?<=[a-z]{10}\s[a-z]{2}\s\[)[0-9]{0,20}+\.+[0-9]{0,10}+\,+[0-9]{0,20}+\.+[0-9]{0,10})/x";
			if (preg_match($sectionpattern, $line, $matches)):
				$currentsection = $matches[1];
				$Worldspace = explode(",", $currentsection);

				include_once($path.'modules/calc.php');
				$description = "<h2>Heli crash site</h2><table><tr><td><img style=\"max-width: 100px;\" src=\"".$path."images/vehicles/Crashsite.png\"></td><td>&nbsp;</td><td style=\"vertical-align:top; \"><h2>Position:</h2>".world_pos2_crash($Worldspace, $serverworld)."</td></tr></table>";
				$markers .= "['Crash site', '".$description."', ".world_pos_y_crash($Worldspace, $serverworld). ", ".world_pos_x_crash($Worldspace, $serverworld).", ".$k++.", '".$path."images/icons/Crashsite.png'],";
			endif;
		endforeach;

		$markers .= "['Edge of map', 'Edge of map', 0.0, 0.0, 1, '" . $path . "images/thumbs/null.png']];";
		include($path.'modules/gm.php');
	}
	else
	{
		echo "<div id='page-heading'><h2>Log file not found</h2></div>";
	}
?>