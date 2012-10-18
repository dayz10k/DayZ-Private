<?
	error_reporting (E_ALL ^ E_NOTICE);
	
	$res = mysql_query($query) or die(mysql_error());
	$markers= "var markers = [";
	$k = 0;

	while ($row=mysql_fetch_array($res)) {
		$Worldspace = str_replace("[", "", $row['pos']);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = explode(",", $Worldspace);
		$name = $row['name'];
		
		include_once($path."modules\calc.php");
		$description = "<h2><a href=\"index.php?view=info&show=1&id=".$row['unique_id']."&cid=".$row['id']."\">".htmlspecialchars($name, ENT_QUOTES)." - ".$row['unique_id']."</a></h2><table><tr><td><img style=\"max-width: 100px;\" src=\"".$path."images/models/".str_replace('"', '', $row['model']).".png\"></td><td>&nbsp;</td><td style=\"vertical-align:top; \"><h2>Position:</h2>".world_pos2($Worldspace, $serverworld)."</td></tr></table>";
		$markers .= "['".htmlspecialchars($name, ENT_QUOTES)."', '".$description."', ".world_pos_y($Worldspace, $serverworld).", ".world_pos_x($Worldspace, $serverworld).", ".$k++.", '".$path."images/icons/player".($row['is_dead'] ? "_dead" : "").".png'],";
	}
	$markers .= "['Edge of map', 'Edge of Chernarus', 0.0, 0.0, 1, '".$path."images/thumbs/null.png']];";
	include ('modules/gm.php');
?>