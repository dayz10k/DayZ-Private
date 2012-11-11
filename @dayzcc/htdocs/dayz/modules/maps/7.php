<?
	error_reporting (E_ALL ^ E_NOTICE);

	$res3 = mysql_query($query3) or die(mysql_error());
	$res2 = mysql_query($query2) or die(mysql_error());
	$res = mysql_query($query) or die(mysql_error());
	$markers= "var markers = [";
	$k = 0;
	$v = 0;
	
	$xml = file_get_contents('/vehicles.xml', true);
	require_once('/modules/xml2array.php');
	$vehicles_xml = XML2Array::createArray($xml);
	
	while ($row3=mysql_fetch_array($res3)) {
		$Worldspace = str_replace("[", "", $row3['worldspace']);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = str_replace("|", ",", $Worldspace);
		$Worldspace = explode(",", $Worldspace);
		$x = 0;
		$y = 0;
		if(array_key_exists(1,$Worldspace)){$x = $Worldspace[1];}
		if(array_key_exists(2,$Worldspace)){$y = $Worldspace[2];}
		
		$type = $row3['class_name'];
		if(array_key_exists('s'.$type,$vehicles_xml['vehicles'])) {$class = $vehicles_xml['vehicles']['s'.$type]['Type'];} else {$class = "Car";}

		include_once($path.'modules/calc.php');
		$description = "<h2><a href=\"index.php?view=info&show=5&id=".$row3['unique_id']."\">".$type."</a></h2><table><tr><td><img style=\"max-width: 100px;\" src=\"".$path."images/vehicles/".$type.".png\"></td><td>&nbsp;</td><td style=\"vertical-align:top; \"><h2>Position:</h2>left: ".round(world_x($x,$serverworld))." top: ".round(world_y($y,$serverworld))."</td></tr></table>";
		$markers .= "['".$type."', '".$description."',".$x.", ".$y.", ".$k++.", '".$path."images/icons/".$class.".png'],";
	};
	
	while ($row2=mysql_fetch_array($res2)) {
		$Worldspace = str_replace("[", "", $row2['worldspace']);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = str_replace("|", ",", $Worldspace);
		$Worldspace = explode(",", $Worldspace);
		$x = 0;
		$y = 0;
		if(array_key_exists(1,$Worldspace)){$x = $Worldspace[1];}
		if(array_key_exists(2,$Worldspace)){$y = $Worldspace[2];}
		
		$type = $row2['class_name'];
		if(array_key_exists('s'.$type,$vehicles_xml['vehicles'])) {$class = $vehicles_xml['vehicles']['s'.$type]['Type'];} else {$class = "Car";}

		include_once($path.'modules/calc.php');
		$description = "<h2><a href=\"index.php?view=info&show=4&id=".$row2['id']."\">".$type."</a></h2><table><tr><td><img style=\"max-width: 100px;\" src=\"".$path."images/vehicles/".$type.".png\"></td><td>&nbsp;</td><td style=\"vertical-align:top; \"><h2>Position:</h2>left: ".round(world_x($x,$serverworld))." top: ".round(world_y($y,$serverworld))."</td></tr></table>";
		$markers .= "['".$type."', '".$description."',".$x.", ".$y.", ".$v++.", '".$path."images/icons/".$class.".png'],";
	};

	while ($row=mysql_fetch_array($res)) {
		$Worldspace = str_replace("[", "", $row['worldspace']);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = explode(",", $Worldspace);
		$x = 0;
		$y = 0;
		if(array_key_exists(1,$Worldspace)){$x = $Worldspace[1];}
		if(array_key_exists(2,$Worldspace)){$y = $Worldspace[2];}
		$name = $row['name'];
		
		include_once($path."modules/calc.php");
		$description = "<h2><a href=\"index.php?view=info&show=1&id=".$row['unique_id']."&cid=".$row['id']."\">".htmlspecialchars($name, ENT_QUOTES)." - ".$row['unique_id']."</a></h2><table><tr><td><img style=\"max-width: 100px;\" src=\"".$path."images/models/".str_replace('"', '', $row['model']).".png\"></td><td>&nbsp;</td><td style=\"vertical-align:top; \"><h2>Position:</h2>left: ".round(world_x($x,$serverworld))." top: ".round(world_y($y,$serverworld))."</td></tr></table>";
		$markers .= "['".htmlspecialchars($name, ENT_QUOTES)."', '".$description."',".$x.", ".$y.", ".$k++.", '".$path."images/icons/player".($row['is_dead'] ? "_dead" : "").".png'],";
	}
	
	$markers .= "['Edge of map', 'Edge of map', 0.0, 0.0, 1, '".$path."images/thumbs/null.png']];";
	include($path.'modules/gm.php');
?>