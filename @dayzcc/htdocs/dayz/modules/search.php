<?php
if (isset($_SESSION['user_id']) and (strpos($_SESSION['user_permissions'], "table") !== false))
{ 
	if (isset($_POST['type'])) { 
		$pagetitle = "Search for ".$_POST['type'];
	} else { 
		$pagetitle = "New search";
	}
	?>

	<div id="page-heading">
		<title><?php echo $pagetitle." - ".$sitename; ?></title>
		<h1><?php echo $pagetitle; ?></h1>
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
					<?php include('modules/searchbar.php'); ?>
					<br/><?php
					if (!empty($_POST))
					{
						//echo $_POST['search']."<br />".$_POST['type'];
						error_reporting (E_ALL ^ E_NOTICE);
						
						$search = substr($_POST['search'], 0, 64);
						$search = preg_replace("/[^\w\x7F-\xFF\s]/", " ", $search);
						$search = trim(preg_replace("/\s(\S{1,2})\s/", " ", preg_replace("[ +]", "  "," $search ")));
						$search = preg_replace("[ +]", " ", $search);
						$logic = "OR";		
					?>
					
					<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
					<?php
						switch ($_POST['type']) { 
							case 'player':
								$tableheader = header_player(1, 0);
								echo $tableheader;
								$res = mysql_query("SELECT profile.name, survivor.* FROM `profile`, `survivor` WHERE profile.unique_id = survivor.unique_id AND profile.name LIKE '%". str_replace(" ", "%' OR profile.name LIKE '%", $search). "%' ORDER BY survivor.last_updated DESC") or die(mysql_error());
								$tablerows = "";
								while ($row = mysql_fetch_array($res)) { $tablerows .= row_player($row, $serverworld); }
								echo $tablerows;
								break;
							case 'playerinv':
								$tableheader = header_player(1, 0);
								echo $tableheader;
								$res = mysql_query("SELECT profile.name, survivor.* FROM `profile`, `survivor` WHERE profile.unique_id = survivor.unique_id AND survivor.inventory LIKE '%". str_replace(" ", "%' OR `backpack` LIKE '%", $search). "%'"." ORDER BY survivor.last_updated DESC") or die(mysql_error());
								$tablerows = "";
								while ($row = mysql_fetch_array($res)) { $tablerows .= row_player($row, $serverworld); }
								echo $tablerows;
								break;
							case 'vehicle':
								$tableheader = header_vehicle(4, "", 0);
								echo $tableheader;
								$res = mysql_query("SELECT world_vehicle.vehicle_id, vehicle.class_name, instance_vehicle.* FROM `world_vehicle`, `vehicle`, `instance_vehicle` WHERE vehicle.id = world_vehicle.vehicle_id AND instance_vehicle.world_vehicle_id = world_vehicle.id AND vehicle.class_name LIKE '%". str_replace(" ", "%' OR vehicle.class_name LIKE '%", $search). "%'") or die(mysql_error());
								while ($row = mysql_fetch_array($res)) { $tablerows .= row_vehicle($row, "", $serverworld); }
								echo $tablerows;
								break;
							case 'vehicleinv':
								$tableheader = header_vehicle(4, "", 0);
								echo $tableheader;
								$res = mysql_query("SELECT world_vehicle.vehicle_id, vehicle.class_name, instance_vehicle.* FROM `world_vehicle`, `vehicle`, `instance_vehicle` WHERE vehicle.id = world_vehicle.vehicle_id AND instance_vehicle.world_vehicle_id = world_vehicle.id AND instance_vehicle.inventory LIKE '%". str_replace(" ", "%' OR instance_vehicle.inventory LIKE '%", $search). "%'") or die(mysql_error());
								while ($row = mysql_fetch_array($res)) { $tablerows .= row_vehicle($row, "", $serverworld); }
								echo $tablerows;
								break;
							case 'tent':
								$tableheader = header_deployable(5, "", 0);
								echo $tableheader;
								$res = mysql_query("SELECT deployable.class_name, instance_deployable.* FROM `deployable`, `instance_deployable` WHERE deployable.id = instance_deployable.deployable_id AND deployable.class_name = 'TentStorage' AND instance_deployable.inventory LIKE '%". str_replace(" ", "%' OR instance_deployable.inventory LIKE '%", $search). "%'") or die(mysql_error());
								while ($row = mysql_fetch_array($res)) { $tablerows .= row_deployable($row, "", $serverworld); }
								echo $tablerows;
								break;
							default:
								$tableheader = header_player(1, 0);
								echo $tableheader;
								$res = mysql_query("SELECT profile.name, survivor.* FROM `profile`, `survivor` WHERE profile.unique_id = survivor.unique_id AND profile.name LIKE '%". str_replace(" ", "%' OR profile.name LIKE '%", $search). "%' ORDER BY survivor.last_updated DESC") or die(mysql_error());
								$tablerows = "";
								while ($row = mysql_fetch_array($res)) { $tablerows .= row_player($row, $serverworld); }
								echo $tablerows;
							};
					?></table><?php } ?>
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

<?php
}
else
{ 
	header('Location: index.php');
}
?>