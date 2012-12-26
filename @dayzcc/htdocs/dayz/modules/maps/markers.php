<?php
function markers_player($res, $world) { 
	$markers = "";

	while ($row = mysql_fetch_array($res)) { 
		$Worldspace = str_replace("[", "", $row['worldspace']);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = explode(",", $Worldspace);
		$x = 0; if (array_key_exists(1, $Worldspace)) { $x = $Worldspace[1]; }
		$y = 0; if (array_key_exists(2, $Worldspace)) { $y = $Worldspace[2]; }

		require_once('modules/calc.php');
		$description = '<h2><a href="index.php?view=info&show=1&id='.$row['unique_id'].'&cid='.$row['id'].'">'.htmlspecialchars($row['name'], ENT_QUOTES).'</a></h2><table><tr><td><img style="width: 100px;" src="images/models/'.str_replace('"', '', $row['model']).'.png"></td><td>&nbsp;&nbsp;&nbsp;</td><td style="vertical-align:top;"><h2>Unique ID:</h2>'.$row['unique_id'].'<br /><br /><h2>Position:</h2>Left: '.round(world_x($x, $world)).'<br />Top: '.round(world_y($y, $world)).'</td></tr></table>';
		$markers .= "L.marker([".(world_y($y, $world) / 10).", ".(world_x($x, $world) / 10)."], { icon: Player".($row['is_dead'] ? "Dead" : "").", title: '".htmlspecialchars($row['name'], ENT_QUOTES)." (".$row['unique_id'].")' }).addTo(map).bindPopup('".$description."'); ";
	}

	return $markers;
}

function markers_vehicle($res, $world) { 
	$markers = "";

	$xml = file_get_contents('/vehicles.xml', true);
	require_once('modules/xml2array.php');
	$vehicles_xml = XML2Array::createArray($xml);

	while ($row = mysql_fetch_array($res)) { 
		$Worldspace = str_replace("[", "", $row['worldspace']);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = explode(",", $Worldspace);
		$x = 0; if (array_key_exists(1, $Worldspace)) { $x = $Worldspace[1]; }
		$y = 0; if (array_key_exists(2, $Worldspace)) { $y = $Worldspace[2]; }

		$type = $row['class_name'];
		if (array_key_exists('s'.$type, $vehicles_xml['vehicles'])) { $class = $vehicles_xml['vehicles']['s'.$type]['Type']; } else {$class = "Car"; }

		require_once('modules/calc.php');
		$description = '<h2><a href="index.php?view=info&show=4&id='.$row['id'].'">'.$type.'</a></h2><table><tr><td><img style="width: 100px;" src="images/vehicles/'.$type.'.png"\></td><td>&nbsp;&nbsp;&nbsp;</td><td style="vertical-align:top;"><h2>Position:</h2>Left: '.round(world_x($x, $world)).'<br />Top: '.round(world_y($y, $world)).'</td></tr></table>';
		$markers .= "L.marker([".(world_y($y, $world) / 10).", ".(world_x($x, $world) / 10)."], { icon: ".$class.", title: '".$type." (".$row['id'].")' }).addTo(map).bindPopup('".$description."'); ";
	};
	
	return $markers;
}

function markers_deployable($res, $world) { 
	$markers = "";

	$xml = file_get_contents('/vehicles.xml', true);
	require_once('modules/xml2array.php');
	$vehicles_xml = XML2Array::createArray($xml);

	while ($row = mysql_fetch_array($res)) { 
		$Worldspace = str_replace("[", "", $row['worldspace']);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = explode(",", $Worldspace);
		$x = 0; if (array_key_exists(1, $Worldspace)) { $x = $Worldspace[1]; }
		$y = 0; if (array_key_exists(2, $Worldspace)) { $y = $Worldspace[2]; }

		$type = $row['class_name'];
		if (array_key_exists('s'.$type, $vehicles_xml['vehicles'])) { $class = $vehicles_xml['vehicles']['s'.$type]['Type']; } else {$class = "Car"; }

		require_once('modules/calc.php');
		$description = '<h2><a href="index.php?view=info&show=5&id='.$row['id'].'">'.$type.'</a></h2><table><tr><td><img style="width: 100px;" src="images/vehicles/'.$type.'.png"\></td><td>&nbsp;&nbsp;&nbsp;</td><td style="vertical-align:top;"><h2>Position:</h2>Left: '.round(world_x($x, $world)).'<br />Top: '.round(world_y($y, $world)).'</td></tr></table>';
		$markers .= "L.marker([".(world_y($y, $world) / 10).", ".(world_x($x, $world) / 10)."], { icon: ".$class.", title: '".$type." (".$row['id'].")' }).addTo(map).bindPopup('".$description."'); ";
	};
	
	return $markers;
}
?>