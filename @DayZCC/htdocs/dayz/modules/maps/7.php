<?
	error_reporting (E_ALL ^ E_NOTICE);

	$markers= "var markers = [";
	
	$res2 = mysql_query($query2) or die(mysql_error());
	$v = 0;
	while ($row2=mysql_fetch_array($res2)) {
		$Worldspace = str_replace("[", "", $row2['pos']);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = str_replace("|", ",", $Worldspace);
		$Worldspace = explode(",", $Worldspace);

		$query3 = "SELECT * FROM `objects_classes` WHERE `classname`='".$row2['otype']."'";
		$res3 = mysql_query($query3) or die(mysql_error());
		$class = mysql_fetch_assoc($res3);		

		include_once($path."modules\calc.php");
		$description = "<h2><a href=\"index.php?view=info&show=4&id=".$row2['id']."\">".$row2['otype']."</a></h2><table><tr><td><img style=\"max-width: 100px;\" src=\"".$path."images/vehicles/".$row2['otype'].".png\"></td><td>&nbsp;</td><td style=\"vertical-align:top; \"><h2>Position:</h2>left:".world_pos2($Worldspace, $serverworld)."</td></tr></table>";
		$markers .= "['".$row2['otype']."', '".$description."',".world_pos_y($Worldspace, $serverworld).", ".world_pos_x($Worldspace, $serverworld).", ".$v++.", '".$path."images/icons/".$class['Type'].".png'],";
	};

	$res = mysql_query($query) or die(mysql_error());
	$k = 0;
	while ($row=mysql_fetch_array($res)) {
		$Worldspace = str_replace("[", "", $row['pos']);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = explode(",", $Worldspace);
		$name = $row['name'];
		
		include_once($path."modules\calc.php");
		$description = "<h2><a href=\"index.php?view=info&show=1&id=".$row['unique_id']."&cid=".$row['id']."\">".htmlspecialchars($name, ENT_QUOTES)." - ".$row['unique_id']."</a></h2><table><tr><td><img style=\"max-width: 100px;\" src=\"".$path."images/models/".str_replace('"', '', $row['model']).".png\"></td><td>&nbsp;</td><td style=\"vertical-align:top; \"><h2>Position:</h2>".world_pos2($Worldspace, $serverworld)."</td></tr></table>";
		$markers .= "['".htmlspecialchars($name, ENT_QUOTES)."', '".$description."',".world_pos_y($Worldspace, $serverworld).", ".world_pos_x($Worldspace, $serverworld).", ".$k++.", '".$path."images/icons/player".($row['is_dead'] ? "_dead" : "").".png'],";
	}
	
	if (file_exists($path_logrpt))
	{
		$lines = file($path_logrpt);
		$v = 0;
		
		foreach ($lines as $line):
			$matches = array();
			$sectionpattern = "/((?<=[a-z]{10}\s[a-z]{2}\s\[)[0-9]{0,20}+\.+[0-9]{0,10}+\,+[0-9]{0,20}+\.+[0-9]{0,10})/x";
			if (preg_match($sectionpattern, $line, $matches)):
				$currentsection = $matches[1];
				$Worldspace = explode(",", $currentsection);

				include_once($path."modules\calc.php");
				$description = "<h2>Heli crash site</h2><table><tr><td><img style=\"max-width: 100px;\" src=\"".$path."images/vehicles/Crashsite.png\"></td><td>&nbsp;</td><td style=\"vertical-align:top; \"><h2>Position:</h2>".world_pos2_crash($Worldspace, $serverworld)."</td></tr></table>";
				$markers .= "['Crash site', '".$description."', ".world_pos_y_crash($Worldspace, $serverworld). ", ".world_pos_x_crash($Worldspace, $serverworld).", ".$v++.", '".$path."images/icons/Crashsite.png'],";
			endif;
		endforeach;
	}
	
	$markers .= "['Edge of map', 'Edge of map', 0.0, 0.0, 1, '".$path."images/thumbs/null.png']];";
	include ('modules/gm.php');
?>