<?php
	$res = mysql_query("SELECT deployable.class_name, instance_deployable.* FROM `deployable`, `instance_deployable` AS `instance_deployable` WHERE deployable.id = instance_deployable.deployable_id AND instance_deployable.id = '".$_GET["id"]."' LIMIT 1") or die(mysql_error());
	$row = mysql_fetch_assoc($res);
	
	$Worldspace = str_replace("[", "", $row['worldspace']);
	$Worldspace = str_replace("]", "", $Worldspace);
	$Worldspace = str_replace("|", ",", $Worldspace);
	$Worldspace = explode(",", $Worldspace);
	$Backpack  = $row['inventory'];
	$Backpack = str_replace("|", ",", $Backpack);
	$Backpack  = json_decode($Backpack);

	$xml = file_get_contents('/items.xml', true);
	require_once('modules/xml2array.php');
	$items_xml = XML2Array::createArray($xml);
	$xml = file_get_contents('/vehicles.xml', true);
	require_once('modules/xml2array.php');
	$vehicles_xml = XML2Array::createArray($xml);
?>

<div id="page-heading">
	<title><?php echo $row['class_name']." - ".$sitename; ?></title>
	<h1><?php echo $row['class_name']." - ".$row['id']." - Last save: ".$row['last_updated']." - Position: .".$row['worldspace']; ?></h1>
</div>

<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
	<tr>
		<th rowspan="3" class="sized"><img src="images/forms/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
		<th class="topleft"></th>
		<td id="tbl-border-top">&nbsp;</td>
		<th class="topright"></th>
		<th rowspan="3" class="sized"><img src="images/forms/side_shadowright.jpg" width="20" height="300" alt="" /></th>
	</tr>
	<tr>
		<td id="tbl-border-left"></td>
		<td>
			<div id="content-table-inner">
				<div id="table-content">
					<div id="gear_vehicle">
						<div class="gear_info">
							<img class="playermodel" src='images/vehicles/<?php echo $row['class_name']; ?>.png'/>
							<div id="gps" style="margin-left:46px;margin-top:54px">
								<div class="gpstext" style="font-size: 22px;width:60px;text-align: left;margin-left:47px;margin-top:13px">
								<?php echo round(($Worldspace[0]/100)); ?>
								</div>
								<div class="gpstext" style="font-size: 22px;width:60px;text-align: left;margin-left:47px;margin-top:34px">
								<?php echo round(($Worldspace[3]/100)); ?>
								</div>
								<div class="gpstext" style="width:120px;margin-left:13px;margin-top:61px">
								<?php
									require_once("\modules\calc.php");
									echo sprintf("%03d", round(world_x($Worldspace[1], $serverworld))).sprintf("%03d", round(world_y($Worldspace[2], $serverworld)));
								?>
								</div>							
							</div>
							<?php
								if ($row['owner_id'] != "0") { 
									$resowner = mysql_query("SELECT profile.name, survivor.* FROM `profile`, `survivor` AS `survivor` WHERE profile.unique_id = survivor.unique_id AND survivor.id = '".$row['owner_id']."' LIMIT 1");
									$owner = '';
									$ownerid = '';
									$owneruid = '';
									
									while ($rowowner = mysql_fetch_array($resowner)) { 
										$owner = $rowowner['name'];
										$ownerid = $rowowner['id'];
										$owneruid = $rowowner['unique_id'];
									}
									
									?><div class="statstext" style="width:180px;margin-left:205px;margin-top:-115px"><?php
										echo 'Owner:&nbsp;<a href="index.php?view=info&show=1&id='.$owneruid.'&cid='.$ownerid.'" style="color:blue">'.$owner.'</a>';
									?></div>
									<div class="statstext" style="width:180px;margin-left:205px;margin-top:-95px"><?php
										echo 'Owner ID:&nbsp;'.$row['owner_id'];
									?></div><?php
								}
							?>
						</div>
						<!-- Backpack -->
						<div class="vehicle_gear">	
							<div id="vehicle_inventory">	
							<?php
								$maxmagazines = 24;
								$maxweaps = 3;
								$maxbacks = 0;
								$freeslots = 0;
								$freeweaps = 0;
								$freebacks = 0;
								$BackpackName = $row['class_name'];
								
								if (array_key_exists('s'.$row['class_name'],$vehicles_xml['vehicles'])) { 
									$maxmagazines = $vehicles_xml['vehicles']['s'.$row['class_name']]['transportmaxmagazines'];
									$maxweaps = $vehicles_xml['vehicles']['s'.$row['class_name']]['transportmaxweapons'];
									$maxbacks = $vehicles_xml['vehicles']['s'.$row['class_name']]['transportmaxbackpacks'];
									$BackpackName = $vehicles_xml['vehicles']['s'.$row['class_name']]['Name'];
								}
								
								if (count($Backpack) > 0) { 
									$bpweaponscount = count($Backpack[0][0]);
									$bpweapons = array();
									for ($m = 0; $m < $bpweaponscount; $m++) { 
										for ($mi = 0; $mi<$Backpack[0][1][$m]; $mi++) { $bpweapons[] = $Backpack[0][0][$m]; }
									}							

									
									$bpitemscount = count($Backpack[1][0]);
									$bpitems = array();
									for ($m = 0; $m < $bpitemscount; $m++) { 
										for ($mi = 0; $mi < $Backpack[1][1][$m]; $mi++) { $bpitems[] = $Backpack[1][0][$m]; }
									}
									
									$bpackscount = count($Backpack[2][0]);
									$bpacks = array();
									for ($m = 0; $m < $bpackscount; $m++) { 
										for ($mi = 0; $mi < $Backpack[2][1][$m]; $mi++) { $bpacks[] = $Backpack[2][0][$m]; }
									}
									
									$Backpack = (array_merge($bpweapons, $bpacks, $bpitems));
									$freebacks = $maxbacks;
									$backpackslots = 0;
									$backpackitem = array();
									$bpweapons = array();
									
									for ($i = 0; $i < count($Backpack); $i++) { 
										if(array_key_exists('s'.$Backpack[$i], $items_xml['items'])) { 
											switch($items_xml['items']['s'.$Backpack[$i]]['Type']) { 
												case 'binocular':
													$backpackitem[] = array('image' => '<img style="max-width:43px;max-height:43px;" src="images/thumbs/'.$Backpack[$i].'.png" title="'.$Backpack[$i].'" alt="'.$Backpack[$i].'"/>', 'slots' => $items_xml['items']['s'.$Backpack[$i]]['Slots']);
													break;
												case 'rifle':
													$bpweapons[] = array('image' => '<img style="max-width:84px;max-height:84px;" src="images/thumbs/'.$Backpack[$i].'.png" title="'.$Backpack[$i].'" alt="'.$Backpack[$i].'"/>', 'slots' => $items_xml['items']['s'.$Backpack[$i]]['Slots']);
													break;
												case 'pistol':
													$bpweapons[] = array('image' => '<img style="max-width:84px;max-height:84px;" src="images/thumbs/'.$Backpack[$i].'.png" title="'.$Backpack[$i].'" alt="'.$Backpack[$i].'"/>', 'slots' => $items_xml['items']['s'.$Backpack[$i]]['Slots']);
													break;
												case 'backpack':
													$bpweapons[] = array('image' => '<img style="max-width:84px;max-height:84px;" src="images/thumbs/'.$Backpack[$i].'.png" title="'.$Backpack[$i].'" alt="'.$Backpack[$i].'"/>', 'slots' => $items_xml['items']['s'.$Backpack[$i]]['Slots']);
													$freebacks = $freebacks - 1;
													break;
												case 'heavyammo':
													$backpackitem[] = array('image' => '<img style="max-width:43px;max-height:43px;" src="images/thumbs/'.$Backpack[$i].'.png" title="'.$Backpack[$i].'" alt="'.$Backpack[$i].'"/>', 'slots' => $items_xml['items']['s'.$Backpack[$i]]['Slots']);
													break;
												case 'smallammo':
													$backpackitem[] = array('image' => '<img style="max-width:43px;max-height:43px;" src="images/thumbs/'.$Backpack[$i].'.png" title="'.$Backpack[$i].'" alt="'.$Backpack[$i].'"/>', 'slots' => $items_xml['items']['s'.$Backpack[$i]]['Slots']);
													break;
												case 'item':
													$backpackitem[] = array('image' => '<img style="max-width:43px;max-height:43px;" src="images/thumbs/'.$Backpack[$i].'.png" title="'.$Backpack[$i].'" alt="'.$Backpack[$i].'"/>', 'slots' => $items_xml['items']['s'.$Backpack[$i]]['Slots']);
													break;
												default:
													$s = '';
											}
										}
									}	
									
									$weapons = count($bpweapons);
									$magazines = $maxmagazines;
									$freeslots = $magazines;
									$freeweaps = $maxweaps;
									$jx = 1; $jy = 0; $jk = 0; $jl = 0;
									$numlines = 0;
									for ($j = 0; $j < $weapons; $j++) { 
										if ($jk > 3) { $jk = 0; $jl++; }
										echo '<div class="gear_slot" style="margin-left:'.($jx+(86*$jk)).'px;margin-top:'.($jy+(86*$jl)).'px;width:84px;height:84px;">'.$bpweapons[$j]['image'].'</div>';
										$freeweaps = $freeweaps - 1;
										$jk++;
									}
									
									if ($jl > 0) { 
										$numlines = $jl + 1;
									} elseif ($jl == 0) { 
										if ($weapons > 0) { $numlines++; }
									}

									$jx = 1; $jy = (86 * $numlines); $jk = 0; $jl = 0;
									for ($j = 0; $j < $magazines; $j++) { 
										if ($jk > 6){ $jk = 0; $jl++; }
										if ($j < count($backpackitem)) { 
											echo '<div class="gear_slot" style="margin-left:'.($jx+(49*$jk)).'px;margin-top:'.($jy+(49*$jl)).'px;width:47px;height:47px;">'.$backpackitem[$j]['image'].'</div>';
											$freeslots = $freeslots - 1;
										} else { 
											echo '<div class="gear_slot" style="margin-left:'.($jx+(49*$jk)).'px;margin-top:'.($jy+(49*$jl)).'px;width:47px;height:47px;"></div>';
										}								
										$jk++;
									}
								}						
							?>
							</div>
							<div class="backpackname">
								<?php echo 'Mags:&nbsp;'.$freeslots.'&nbsp;/&nbsp;'.$maxmagazines.'&nbsp;Weaps:&nbsp;'.$freeweaps.'&nbsp;/&nbsp;'.$maxweaps.'&nbsp;Backs:&nbsp;'.$freebacks.'&nbsp;/&nbsp;'.$maxbacks.'&nbsp;'; ?>
							</div>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</td>
		<td id="tbl-border-right"></td>
	</tr>
	<tr>
		<th class="sized bottomleft"></th>
		<td id="tbl-border-bottom">&nbsp;</td>
		<th class="sized bottomright"></th>
	</tr>
</table>
<div class="clear">&nbsp;</div>