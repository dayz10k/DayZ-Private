<?
	error_reporting (E_ALL ^ E_NOTICE);
	
	$res = mysql_query($query) or die(mysql_error());
	$markers= "var markers = [";
	$k = 0;

	while ($row=mysql_fetch_array($res)) {
		$Worldspace = str_replace("[", "", $row['worldspace']);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = explode(",", $Worldspace);
		$x = 0;
		$y = 0;
		if(array_key_exists(1,$Worldspace)){$x = $Worldspace[1];}
		if(array_key_exists(2,$Worldspace)){$y = $Worldspace[2];}
		$name = $row['name'];
		
		include_once($path.'modules/calc.php');
		$description = "<h2><a href=\"index.php?view=info&show=1&id=".$row['unique_id']."&cid=".$row['id']."\">".htmlspecialchars($name, ENT_QUOTES)." - ".$row['unique_id']."</a></h2><table><tr><td><img style=\"max-width: 100px;\" src=\"".$path."images/models/".str_replace('"', '', $row['model']).".png\"></td><td>&nbsp;</td><td style=\"vertical-align:top; \"><h2>Position:</h2>left: ".round(world_x($x,$serverworld))." top: ".round(world_y($y,$serverworld))."</td></tr></table>";
		$markers .= "['".htmlspecialchars($name, ENT_QUOTES)."', '".$description."', ".$x.", ".$y.", ".$k++.", '".$path."images/icons/player".($row['is_dead'] ? "_dead" : "").".png'],";
	}
	$markers .= "['Edge of map', 'Edge of Chernarus', 0.0, 0.0, 1, '".$path."images/thumbs/null.png']];";
	include($path.'modules/gm.php');
?>