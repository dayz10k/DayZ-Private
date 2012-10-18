<?
	error_reporting (E_ALL ^ E_NOTICE);
	
	$res = mysql_query($query) or die(mysql_error());
	$markers= "var markers = [";
	$k = 0;
	
	$xml = file_get_contents('/vehicles.xml', true);
	require_once('/modules/xml2array.php');
	$vehicles_xml = XML2Array::createArray($xml);
	
	while ($row=mysql_fetch_array($res)) {
		$Worldspace = str_replace("[", "", $row['pos']);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = str_replace("|", ",", $Worldspace);
		$Worldspace = explode(",", $Worldspace);

		if(array_key_exists('s'.$row['otype'],$vehicles_xml['vehicles'])) {$class = $vehicles_xml['vehicles']['s'.$row['otype']]['Type'];} else {$class = "Car";}

		include_once($path.'modules/calc.php');
		$description = "<h2><a href=\"index.php?view=info&show=4&id=".$row['id']."\">".$row['otype']."</a></h2><table><tr><td><img style=\"max-width: 100px;\" src=\"".$path."images/vehicles/".$row['otype'].".png\"></td><td>&nbsp;</td><td style=\"vertical-align:top; \"><h2>Position:</h2>".world_pos2($Worldspace, $serverworld)."</td></tr></table>";
		$markers .= "['".$row['otype']."', '".$description."',".world_pos_y($Worldspace, $serverworld).", ".world_pos_x($Worldspace, $serverworld).", ".$k++.", '".$path."images/icons/".$class.".png'],";
	};
	$markers .= "['Edge of map', 'Edge of map', 0.0, 0.0, 1, '".$path."images/thumbs/null.png']];";
	include($path.'modules/gm.php');
?>