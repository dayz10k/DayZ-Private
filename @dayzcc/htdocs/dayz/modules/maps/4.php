<?
	error_reporting (E_ALL ^ E_NOTICE);
	
	$res = mysql_query($query) or die(mysql_error());
	$markers= "var markers = [";
	$k = 0;
	
	$xml = file_get_contents('/vehicles.xml', true);
	require_once('/modules/xml2array.php');
	$vehicles_xml = XML2Array::createArray($xml);
	
	while ($row=mysql_fetch_array($res)) {
		$Worldspace = str_replace("[", "", $row['worldspace']);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = str_replace("|", ",", $Worldspace);
		$Worldspace = explode(",", $Worldspace);
		$x = 0;
		$y = 0;
		if(array_key_exists(1,$Worldspace)){$x = $Worldspace[1];}
		if(array_key_exists(2,$Worldspace)){$y = $Worldspace[2];}
		
		$type = $row['class_name'];
		if(array_key_exists('s'.$type,$vehicles_xml['vehicles'])) {$class = $vehicles_xml['vehicles']['s'.$type]['Type'];} else {$class = "Car";}

		include_once($path.'modules/calc.php');
		$description = "<h2><a href=\"index.php?view=info&show=4&id=".$row['id']."\">".$type."</a></h2><table><tr><td><img style=\"max-width: 100px;\" src=\"".$path."images/vehicles/".$type.".png\"></td><td>&nbsp;</td><td style=\"vertical-align:top; \"><h2>Position:</h2>left: ".round(world_x($x,$serverworld))." top: ".round(world_y($y,$serverworld))."</td></tr></table>";
		$markers .= "['".$type."', '".$description."',".$x.", ".$y.", ".$k++.", '".$path."images/icons/".$class.".png'],";
	};
	$markers .= "['Edge of map', 'Edge of map', 0.0, 0.0, 1, '".$path."images/thumbs/null.png']];";
	include($path.'modules/gm.php');
?>