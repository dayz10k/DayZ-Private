<?
	error_reporting (E_ALL ^ E_NOTICE);
	
	$res = mysql_query($query) or die(mysql_error());
	$markers= "var markers = [";
	$k = 0;
	
	while ($row=mysql_fetch_array($res)) {
		$Worldspace = str_replace("[", "", $row['pos']);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = str_replace("|", ",", $Worldspace);
		$Worldspace = explode(",", $Worldspace);

		$query = "SELECT * FROM `objects_classes` WHERE `classname`='".$row['otype']."'";
		$result = mysql_query($query) or die(mysql_error());
		$class = mysql_fetch_assoc($result);		

		include_once($path."modules\calc.php");
		$description = "<h2><a href=\"index.php?view=info&show=4&id=".$row['id']."\">".$row['otype']."</a></h2><table><tr><td><img style=\"max-width: 100px;\" src=\"".$path."images/vehicles/".$row['otype'].".png\"></td><td>&nbsp;</td><td style=\"vertical-align:top; \"><h2>Position:</h2>".world_pos2($Worldspace, str_replace("dayz_", "", $database_name))."</td></tr></table>";
		$markers .= "['".$row['otype']."', '".$description."', ".world_pos_y($Worldspace, str_replace("dayz_", "", $database_name)).", ".world_pos_x($Worldspace, str_replace("dayz_", "", $database_name)).", ".$k++.", '".$path."images/icons/".$class['Type'].".png'],";
	};
	$markers .= "['Edge of map', 'Edge of map', 0.0, 0.0, 1, '".$path."images/thumbs/null.png']];";
	include ('modules/gm.php');
?>