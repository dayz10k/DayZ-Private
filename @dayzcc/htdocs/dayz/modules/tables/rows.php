<?php
function header_player($show, $order) { 
	return '<tr>
		<th class="table-header-repeat line-left" width="5%"><a href="">Status</a></th>
		<th class="table-header-repeat line-left" width="25%"><a href="index.php?view=table&show='.$show.'&sort=1&order='.$order.'">Player Name</a></th>
		<th class="table-header-repeat line-left" width="10%"><a href="index.php?view=table&show='.$show.'&sort=2&order='.$order.'">Player UID</a></th>
		<th class="table-header-repeat line-left" width="10%"><a href="index.php?view=table&show='.$show.'&sort=3&order='.$order.'">Position</a></th>
		<th class="table-header-repeat line-left" width="10%"><a href="index.php?view=table&show='.$show.'&sort=4&order='.$order.'">Health</a></th>
		<th class="table-header-repeat line-left" width="20%"><a href="index.php?view=table&show='.$show.'&sort=5&order='.$order.'">Inventory preview</a></th>
		<th class="table-header-repeat line-left" width="20%"><a href="index.php?view=table&show='.$show.'&sort=6&order='.$order.'">Backpack preview</a></th>
		</tr>';
}

function header_player_online($show) { 
	return '<tr>
		<th class="table-header-repeat line-left" width="5%"><a href="">Kick</a></th>
		<th class="table-header-repeat line-left" width="5%"><a href="">Ban</a></th>
		<th class="table-header-repeat line-left" width="20%"><a href="">Player Name</a></th>
		<th class="table-header-repeat line-left" width="10%"><a href="">Player UID</a></th>
		<th class="table-header-repeat line-left" width="10%"><a href="">Position</a></th>
		<th class="table-header-repeat line-left" width="10%"><a href="">Health</a></th>
		<th class="table-header-repeat line-left" width="20%"><a href="">Inventory preview</a></th>
		<th class="table-header-repeat line-left" width="20%"><a href="">Backpack preview</a></th>
		</tr>';
}

function header_vehicle($show, $chbox, $order) { 
	return '
		<tr>'.$chbox.'
		<th class="table-header-repeat line-left" width="5%"><a href="index.php?view=table&show='.$show.'&sort=1&order='.$order.'">ID</a></th>
		<th class="table-header-repeat line-left" width="18%"><a href="index.php?view=table&show='.$show.'&sort=2&order='.$order.'">Classname</a></th>
		<th class="table-header-repeat line-left" width="7%"><a href="index.php?view=table&show='.$show.'&sort=3&order='.$order.'">Damage</a></th>
		<th class="table-header-repeat line-left" width="10%"><a href="index.php?view=table&show='.$show.'&sort=4&order='.$order.'">Position</a></th>
		<th class="table-header-repeat line-left" width="25%"><a href="index.php?view=table&show='.$show.'&sort=5&order='.$order.'">Inventory</a></th>
		<th class="table-header-repeat line-left" width="25%"><a href="index.php?view=table&show='.$show.'&sort=6&order='.$order.'">Hitpoints</a></th>
		</tr>';
}

function header_deployable($show, $chbox, $order) { 
	return '
		<tr>'.$chbox.'
		<th class="table-header-repeat line-left" width="5%"><a href="index.php?view=table&show='.$show.'&sort=1&order='.$order.'">ID</a></th>
		<th class="table-header-repeat line-left" width="20%"><a href="index.php?view=table&show='.$show.'&sort=2&order='.$order.'">UID</a></th>
		<th class="table-header-repeat line-left" width="30%"><a href="index.php?view=table&show='.$show.'&sort=3&order='.$order.'">Classname</a></th>
		<th class="table-header-repeat line-left" width="10%"><a href="index.php?view=table&show='.$show.'&sort=4&order='.$order.'">Position</a></th>
		<th class="table-header-repeat line-left" width="25%"><a href="index.php?view=table&show='.$show.'&sort=5&order='.$order.'">Inventory</a></th>
		</tr>';
}

function row_player($row, $world) { 
	$Worldspace = str_replace("[", "", $row['worldspace']);
	$Worldspace = str_replace("]", "", $Worldspace);
	$Worldspace = explode(",", $Worldspace);
	$x = 0; if (array_key_exists(1, $Worldspace)) { $x = $Worldspace[1];}
	$y = 0; if (array_key_exists(2, $Worldspace)) { $y = $Worldspace[2];}

	$InventoryPreview = "";
	$Inventory = $row['inventory'];
	$Inventory = json_decode($Inventory);
	$limit = 6;

	if (is_array($Inventory)) { 
		if (array_key_exists(0,$Inventory)){ 
			if (array_key_exists(1, $Inventory)) { $Inventory = (array_merge($Inventory[0], $Inventory[1]));} else { $Inventory = $Inventory[0];}
		} else { 
			if (array_key_exists(1, $Inventory)) { $Inventory = $Inventory[1];}
		}
	} else { 
		$Inventory = array();
	}

	for ($i = 0; $i< $limit; $i++){ 
		if(array_key_exists($i, $Inventory)){ 
			//$InventoryPreview .= $Inventory[$i];
			$curitem = $Inventory[$i];
			$icount = "";
			if (is_array($curitem)) { $curitem = $Inventory[$i][0]; $icount = ' - '.$Inventory[$i][1].' rounds'; }
			$InventoryPreview .= '<div class="preview_gear_slot" style="margin-top:0px;width:47px;height:47px;"><img style="max-width:43px;max-height:43px;" src="images/thumbs/'.$curitem.'.png" title="'.$curitem.$icount.'" alt="'.$curitem.$icount.'"/></div>';
		} else { 
			$InventoryPreview .= '<div class="preview_gear_slot" style="margin-top:0px;width:47px;height:47px;"></div>';
		}			
	}

	$BackpackPreview = "";
	$Backpack = $row['backpack'];
	$Backpack = json_decode($Backpack);

	if (array_key_exists(0, $Backpack)){ 
		$bpweapons = array();
		$bpweapons[] = $Backpack[0];
		if(array_key_exists(1, $Backpack)){ 
			$bpweaponscount = count($Backpack[1][0]);				
			for ($m = 0; $m < $bpweaponscount; $m++) { for ($mi = 0; $mi < $Backpack[1][1][$m]; $mi++){ $bpweapons[] = $Backpack[1][0][$m];}}							
		}
		$bpitems = array();
		if(array_key_exists(1, $Backpack)){ 
			$bpitemscount = count($Backpack[2][0]);
			for ($m = 0; $m < $bpitemscount; $m++) { for ($mi = 0; $mi < $Backpack[2][1][$m]; $mi++){ $bpitems[] = $Backpack[2][0][$m];}}
		}
		$Backpack = (array_merge($bpweapons, $bpitems));
	}

	for ($i = 0; $i < $limit; $i++){ 
		if (array_key_exists($i, $Backpack)) { 
			$curitem = $Backpack[$i];
			if (is_array($curitem)) { 
				if ($i != 0) { $curitem = $Backpack[$i][0]; $icount = ' - '.$Backpack[$i][1].' rounds';}
			}
			$BackpackPreview .= '<div class="preview_gear_slot" style="margin-top:0px;width:47px;height:47px;"><img style="max-width:43px;max-height:43px;" src="images/thumbs/'.$curitem.'.png" title="'.$curitem.$icount.'" alt="'.$curitem.$icount.'"/></div>';
		} else { 
			$BackpackPreview .= '<div class="preview_gear_slot" style="margin-top:0px;width:47px;height:47px;"></div>';
		}			
	}

	$Medical = str_replace("[", "", $row['medical']);
	$Medical = str_replace("]", "", $Medical);
	$Medical = explode(",", $Medical);
	$health = $Medical[7];

	$name = "<a href=\"index.php?view=info&show=1&id=".$row['unique_id']."&cid=".$row['id']."\">".$row['name']."</a>";
	$uuid = "<a href=\"index.php?view=info&show=1&id=".$row['unique_id']."&cid=".$row['id']."\">".$row['unique_id']."</a>";
	$thealth = "<a href=\"index.php?view=info&show=1&id=".$row['unique_id']."&cid=".$row['id']."\">".$health."</a>";
	$icon = '<img src="images/icons/player'.($row['is_dead'] ? '_dead' : '').'.png" title="" alt=""/>';

	require_once('/modules/calc.php');
	$tablerow = "<tr>
		<td align=\"center\" class=\"gear_preview\">".$icon."</td>
		<td align=\"center\" class=\"gear_preview\">".$name."</td>
		<td align=\"center\" class=\"gear_preview\">".$uuid."</td>
		<td align=\"center\" class=\"gear_preview\"><a href=\"index.php?view=info&show=1&id=".$row['unique_id']."&cid=".$row['id']."\">".sprintf("%03d",round(world_x($x, $world))).sprintf("%03d",round(world_y($y, $world)))."</a></td>
		<td align=\"center\" class=\"gear_preview\">".$thealth."</td>
		<td align=\"center\" class=\"gear_preview\">".$InventoryPreview."</td>
		<td align=\"center\" class=\"gear_preview\">".$BackpackPreview."</td>
		</tr>";

	return $tablerow;
}

function row_online_player($row, $player, $world) { 
	$Worldspace = str_replace("[", "", $row['worldspace']);
	$Worldspace = str_replace("]", "", $Worldspace);
	$Worldspace = explode(",", $Worldspace);				
	$x = 0; if (array_key_exists(1,$Worldspace)) { $x = $Worldspace[1];}
	$y = 0; if (array_key_exists(2,$Worldspace)) { $y = $Worldspace[2];}

	$dead = ($row['is_dead'] ? '_dead' : '');
	$InventoryPreview = "";
	$Inventory = $row['inventory'];
	$Inventory = json_decode($Inventory);
	$limit = 6;
	$pcount = "";

	if (is_array($Inventory)) { 
		if (array_key_exists(0, $Inventory)) { 
			if (array_key_exists(1, $Inventory)) { $Inventory = (array_merge($Inventory[0], $Inventory[1]));} else { $Inventory = $Inventory[0];}
		} else { 
			if (array_key_exists(1, $Inventory)) { $Inventory = $Inventory[1];}
		}
	} else { 
		$Inventory = array();
	}

	for ($p = 0; $p < $limit; $p++){ 
		if(array_key_exists($p,$Inventory)){ 
			$curitem = $Inventory[$p];
			if (is_array($curitem)){ $curitem = $Inventory[$p][0]; $pcount = ' - '.$Inventory[$p][1].' rounds'; }
			$InventoryPreview .= '<div class="preview_gear_slot" style="margin-top:0px;width:47px;height:47px;"><img style="max-width:43px;max-height:43px;" src="images/thumbs/'.$curitem.'.png" title="'.$curitem.$pcount.'" alt="'.$curitem.$pcount.'"/></div>';
		} else { 
			$InventoryPreview .= '<div class="preview_gear_slot" style="margin-top:0px;width:47px;height:47px;"></div>';
		}			
	}

	$BackpackPreview = "";
	$Backpack = $row['backpack'];
	$Backpack = json_decode($Backpack);

	if (array_key_exists(0, $Backpack)){ 
		$bpweapons = array();
		$bpweapons[] = $Backpack[0];
		if (array_key_exists(1, $Backpack)){ 
			if (array_key_exists(0, $Backpack[1])){ 
				$bpweaponscount = count($Backpack[1][0]);				
				for ($m=0; $m<$bpweaponscount; $m++){ for ($mi = 0; $mi < $Backpack[1][1][$m]; $mi++) { $bpweapons[] = $Backpack[1][0][$m];}}	
			}							
		}
		$bpitems = array();
		if (array_key_exists(1, $Backpack)){ 
			if (array_key_exists(0, $Backpack[2])){ 
				$bpitemscount = count($Backpack[2][0]);
				for ($m = 0; $m < $bpitemscount; $m++){ for ($mi = 0; $mi < $Backpack[2][1][$m]; $mi++) { $bpitems[] = $Backpack[2][0][$m];}}
			}
		}
		$Backpack = (array_merge($bpweapons, $bpitems));
	}

	for ($p = 0; $p < $limit; $p++){ 
		if (array_key_exists($p, $Backpack)) { 
			$curitem = $Backpack[$p];
			if (is_array($curitem)) { 
				if ($p != 0) { 
					$curitem = $Backpack[$p][0];
					$pcount = ' - '.$Backpack[$p][1].' rounds';
				}
			}
			$BackpackPreview .= '<div class="preview_gear_slot" style="margin-top:0px;width:47px;height:47px;"><img style="max-width:43px;max-height:43px;" src="images/thumbs/'.$curitem.'.png" title="'.$curitem.$pcount.'" alt="'.$curitem.$pcount.'"/></div>';
		} else { 
			$BackpackPreview .= '<div class="preview_gear_slot" style="margin-top:0px;width:47px;height:47px;"></div>';
		}
	}

	$Medical = str_replace("[", "", $row['medical']);
	$Medical = str_replace("]", "", $Medical);
	$Medical = explode(",", $Medical);
	$health = $Medical[7];

	$name = "<a href=\"index.php?view=info&show=1&id=".$row['unique_id']."&cid=".$row['id']."\">".$player[4]."</a>";
	$uid = "<a href=\"index.php?view=info&show=1&id=".$row['unique_id']."&cid=".$row['id']."\">".$row["unique_id"]."</a>";
	$thealth = "<a href=\"index.php?view=info&show=1&id=".$row['unique_id']."&cid=".$row['id']."\">".$health."</a>";
	$iconkick = '<a href="index.php?view=actions&kick='.$player[0].'"><img src="images/icons/player_kick'.$dead.'.png" title="Kick '.$player[4].'" alt="Kick '.$player[4].'"/></a>';
	$iconban = '<a href="index.php?view=actions&ban='.$player[0].'"><img src="images/icons/player_ban'.$dead.'.png" title="Ban '.$player[4].'" alt="Ban '.$player[4].'"/></a>';

	require_once('/modules/calc.php');
	$tablerow = "<tr>
		<td align=\"center\" class=\"gear_preview\" style=\"vertical-align:middle;\">".$iconkick."</td>
		<td align=\"center\" class=\"gear_preview\" style=\"vertical-align:middle;\">".$iconban."</td>
		<td align=\"center\" class=\"gear_preview\" style=\"vertical-align:middle;\">".$name."</td>
		<td align=\"center\" class=\"gear_preview\">".$uid."</td>
		<td align=\"center\" class=\"gear_preview\"><a href=\"index.php?view=info&show=1&id=".$row['unique_id']."&cid=".$row['id']."\">".sprintf("%03d",round(world_x($x, $world))).sprintf("%03d",round(world_y($y, $world)))."</a></td>
		<td align=\"center\" class=\"gear_preview\"><a href=\"index.php?view=info&show=1&id=".$row['unique_id']."&cid=".$row['id']."\">".$health."</a></td>
		<td align=\"center\" class=\"gear_preview\">".$InventoryPreview."</td>
		<td align=\"center\" class=\"gear_preview\">".$BackpackPreview."</td>
		<tr>";

	return $tablerow;	
}

function row_vehicle($row, $chbox, $world) { 
	$Worldspace = str_replace("[", "", $row['worldspace']);
	$Worldspace = str_replace("]", "", $Worldspace);
	$Worldspace = explode(",", $Worldspace);
	$x = 0; if (array_key_exists(1, $Worldspace)) { $x = $Worldspace[1];}
	$y = 0; if (array_key_exists(2, $Worldspace)) { $y = $Worldspace[2];}

	$InventoryPreview = "";
	$Inventory = $row['inventory'];
	$Inventory = json_decode($Inventory);
	$limit = 6;

	if (count($Inventory) > 0) { 
		$bpweapons = array();
		if (array_key_exists(0, $Inventory)){ 
			$bpweaponscount = count($Inventory[0][0]);				
			for ($m = 0; $m < $bpweaponscount; $m++) { for ($mi = 0; $mi < $Inventory[0][1][$m]; $mi++) { $bpweapons[] = $Inventory[0][0][$m];}}							
		}

		$bpitems = array();
		if (array_key_exists(1, $Inventory)){ 
			$bpitemscount = count($Inventory[1][0]);
			for ($m = 0; $m < $bpitemscount; $m++) { for ($mi = 0; $mi < $Inventory[1][1][$m]; $mi++) { $bpitems[] = $Inventory[1][0][$m];}}
		}

		$bpacks = array();
		if (array_key_exists(2, $Inventory)){ 
			$bpackscount = count($Inventory[2][0]);
			for ($m = 0; $m < $bpackscount; $m++) { for ($mi = 0; $mi < $Inventory[2][1][$m]; $mi++) { $bpacks[] = $Inventory[2][0][$m];}}
		}

		$Inventory = (array_merge($bpweapons, $bpacks, $bpitems));
	} else { 
		$Inventory = array();
	}

	for ($i = 0; $i < $limit; $i++){ 
		if (array_key_exists($i, $Inventory)){ 
			$curitem = $Inventory[$i];
			if (is_array($curitem)){ 
				if ($i != 0) { $curitem = $Inventory[$i][0]; $icount = ' - '.$Inventory[$i][1].' rounds';}
			}
			$InventoryPreview .= '<div class="preview_gear_slot" style="margin-top:0px;width:47px;height:47px;"><img style="max-width:43px;max-height:43px;" src="images/thumbs/'.$curitem.'.png" title="'.$curitem.$icount.'" alt="'.$curitem.$icount.'"/></div>';
		} else { 
			$InventoryPreview .= '<div class="preview_gear_slot" style="margin-top:0px;width:47px;height:47px;"></div>';
		}
	}

	$HitpointsPreview = "";
	$Hitpoints = $row['parts'];
	$Hitpoints = json_decode($Hitpoints);

	if (!is_array($Hitpoints)) { $Hitpoints = array();}

	for ($i = 0; $i < $limit; $i++){ 
		if (array_key_exists($i, $Hitpoints)){ 
			$curitem = $Hitpoints[$i];
			$HitpointsPreview .= '<div class="preview_gear_slot" style="margin-top:0px;width:47px;height:47px;background-color: rgba(100, '.round((255 / 100) * (100 - ($curitem[1] * 100))).', 0, 0.8);"><img style="max-width:43px;max-height:43px;" src="images/hits/'.$curitem[0].'.png" title="'.$curitem[0].' - '.round(100 - ($curitem[1] * 100)).'%" alt="'.$curitem[0].' - '.round(100 - ($curitem[1] * 100)).'%"/></div>';
		}
	}

	require_once('/modules/calc.php');
	$tablerow = "<tr>".$chbox."
		<td align=\"center\" class=\"gear_preview\"><a href=\"index.php?view=info&show=4&id=".$row['id']."\">".$row['id']."</a></td>
		<td align=\"center\" class=\"gear_preview\"><a href=\"index.php?view=info&show=4&id=".$row['id']."\">".$row['class_name']."</a></td>			
		<td align=\"center\" class=\"gear_preview\" style=\"background-color: rgba(100, ".round((255 / 100) * (100 - ($row['damage']*100))).", 0, 0.8);\">".substr($row['damage'], 0, 6)."</td>
		<td align=\"center\" class=\"gear_preview\"><a href=\"index.php?view=info&show=4&id=".$row['id']."\">".sprintf("%03d", round(world_x($x, $world))).sprintf("%03d", round(world_y($y, $world)))."</a></td>
		<td align=\"center\" class=\"gear_preview\">".$InventoryPreview."</td>
		<td align=\"center\" class=\"gear_preview\">".$HitpointsPreview."</td>
		</tr>";

	return $tablerow;
}

function row_deployable($row, $chbox, $world) { 
	$Worldspace = str_replace("[", "", $row['worldspace']);
	$Worldspace = str_replace("]", "", $Worldspace);
	$Worldspace = explode(",", $Worldspace);
	$x = 0; if (array_key_exists(1, $Worldspace)) { $x = $Worldspace[1];}
	$y = 0; if (array_key_exists(2, $Worldspace)) { $y = $Worldspace[2];}

	$InventoryPreview = "";
	$Inventory = $row['inventory'];
	$Inventory = json_decode($Inventory);
	$limit = 6;

	if (count($Inventory) > 0) { 
		$bpweapons = array();
		if (array_key_exists(0, $Inventory)) { 
			$bpweaponscount = count($Inventory[0][0]);				
			for ($m = 0; $m < $bpweaponscount; $m++){ for ($mi = 0; $mi < $Inventory[0][1][$m]; $mi++) { $bpweapons[] = $Inventory[0][0][$m];}}							
		}

		$bpitems = array();
		if (array_key_exists(1, $Inventory)) { 
			$bpitemscount = count($Inventory[1][0]);
			for ($m = 0; $m < $bpitemscount; $m++){ for ($mi = 0; $mi < $Inventory[1][1][$m]; $mi++) { $bpitems[] = $Inventory[1][0][$m];}}
		}

		$bpacks = array();
		if (array_key_exists(2, $Inventory)) { 
			$bpackscount = count($Inventory[2][0]);
			for ($m = 0; $m < $bpackscount; $m++){ for ($mi = 0; $mi < $Inventory[2][1][$m]; $mi++) { $bpacks[] = $Inventory[2][0][$m];}}
		}

		$Inventory = (array_merge($bpweapons, $bpacks, $bpitems));
	} else { 
		$Inventory = array();
	}
	
	for ($i = 0; $i < $limit; $i++) { 
		if(array_key_exists($i, $Inventory)) { 
			$curitem = $Inventory[$i];
			if (is_array($curitem)) { 
				if ($i != 0) { $curitem = $Inventory[$i][0]; $icount = ' - '.$Inventory[$i][1].' rounds';}
			}
			$InventoryPreview .= '<div class="preview_gear_slot" style="margin-top:0px;width:47px;height:47px;"><img style="max-width:43px;max-height:43px;" src="images/thumbs/'.$curitem.'.png" title="'.$curitem.$icount.'" alt="'.$curitem.$icount.'"/></div>';
		} else { 
			$InventoryPreview .= '<div class="preview_gear_slot" style="margin-top:0px;width:47px;height:47px;"></div>';
		}
	}

	require_once('/modules/calc.php');
	$tablerow = "<tr>".$chbox."
		<td align=\"center\" class=\"gear_preview\" ><a href=\"index.php?view=info&show=5&id=".$row['id']."\">".$row['id']."</a></td>
		<td align=\"center\" class=\"gear_preview\" ><a href=\"index.php?view=info&show=5&id=".$row['id']."\">".$row['unique_id']."</a></td>
		<td align=\"center\" class=\"gear_preview\" ><a href=\"index.php?view=info&show=5&id=".$row['id']."\">".$row['class_name']."</a></td>			
		<td align=\"center\" class=\"gear_preview\" ><a href=\"index.php?view=info&show=5&id=".$row['id']."\">".sprintf("%03d", round(world_x($x, $world))).sprintf("%03d", round(world_y($y, $world)))."</a></td>
		<td align=\"center\" class=\"gear_preview\">".$InventoryPreview."</td>
		</tr>";

	return $tablerow;
}
?>