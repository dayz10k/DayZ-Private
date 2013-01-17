<?php
if (isset($_SESSION['user_id']) and (strpos($_SESSION['user_permissions'], "table") !== false))
{ 
	$pnumber = 0;
	$tableheader = '';
	$tablerows = '';
	$pageNum = 1;
	$maxPage = 1;
	$rowsPerPage = 30;
	$nav = '';
	$self = 'index.php?view=table&show='.$show;
	$paging = '';

	$formhead = "";
	$formfoot = "";
	
	if (isset($_GET["show"])){ 
		$show = $_GET["show"];
	} else { 
		$show = 0;
	}

	if (isset($_GET["sort"])){ 
		$sort = $_GET["sort"];
	} else { 
		$sort = 0;
	}
	
	// Thanks to SilverShot and ChemicalBliss for the order code
	if (isset($_GET['order']))
	{ 
		$order = $_GET['order'];
		if($order == "1")
		{ 
			$ordered = "DESC";
			$order = 0;
		}
		else
		{ 
			$ordered = "ASC";
			$order = 1;
		}
	}
	else
	{ 
		$ordered = "ASC";
	}
	
	switch ($show) { 
		case 0:
			$pagetitle = "Online players";
			break;
		case 1:
			$query = "SELECT profile.name, survivor.* FROM `profile`, `survivor` WHERE profile.unique_id = survivor.unique_id AND survivor.is_dead = '0'";
			
			switch ($sort) { 
				case 1:
					$query .= " ORDER BY survivor.name $ordered";
					break;
				case 2:
					$query .= " ORDER BY survivor.unique_id` $ordered";
					break;
				case 3:
					$query .= " ORDER BY survivor.worldspace $ordered";
					break;
				case 4:
					$query .= " ORDER BY survivor.medical $ordered";
					break;
				case 5:
					$query .= " ORDER BY survivor.inventory $ordered";
					break;
				case 6:
					$query .= " ORDER BY survivor.backpack $ordered";
					break;
			};
			
			$pagetitle = "Alive players";		
			break;
		case 2:
			$query = "SELECT profile.name, survivor.* FROM `profile`, `survivor` WHERE profile.unique_id = survivor.unique_id AND survivor.is_dead = '1' AND survivor.inventory NOT LIKE '[[],[]]'";
			
			switch ($sort) { 
				case 1:
					$query .= " ORDER BY survivor.name $ordered";
					break;
				case 2:
					$query .= " ORDER BY survivor.unique_id $ordered";
					break;
				case 3:
					$query .= " ORDER BY survivor.worldspace $ordered";
					break;
				case 4:
					$query .= " ORDER BY survivor.medical $ordered";
					break;
				case 5:
					$query .= " ORDER BY survivor.inventory $ordered";
					break;
				case 6:
					$query .= " ORDER BY survivor.backpack $ordered";
					break;
			};
			
			$pagetitle = "Dead players";	
			break;
		case 3:
			$query = "SELECT profile.name, survivor.* FROM `profile`, `survivor` WHERE profile.unique_id = survivor.unique_id";
			
			switch ($sort) { 
				case 1:
					$query .= " ORDER BY survivor.name $ordered";
					break;
				case 2:
					$query .= " ORDER BY survivor.unique_id $ordered";
					break;
				case 3:
					$query .= " ORDER BY survivor.worldspace $ordered";
					break;
				case 4:
					$query .= " ORDER BY survivor.medical $ordered";
					break;
				case 5:
					$query .= " ORDER BY survivor.inventory $ordered";
					break;
				case 6:
					$query .= " ORDER BY survivor.backpack $ordered";
					break;
			};
			
			$pagetitle = "All players";	
			break;
		case 4:
			$query = "SELECT world_vehicle.vehicle_id, vehicle.class_name, instance_vehicle.* FROM `world_vehicle`, `vehicle`, `instance_vehicle` WHERE vehicle.id = world_vehicle.vehicle_id AND instance_vehicle.world_vehicle_id = world_vehicle.id AND instance_vehicle.instance_id = '".$serverinstance."' AND instance_vehicle.damage < '0.95'";
			
			switch ($sort) { 
				case 1:
					$query .= " ORDER BY `id` $ordered";
					break;
				case 2:
					$query .= " ORDER BY `class_name` $ordered";
					break;
				case 3:
					$query .= " ORDER BY `damage` $ordered";
					break;
				case 4:
					$query .= " ORDER BY `worldspace` $ordered";
					break;
				case 5:
					$query .= " ORDER BY `inventory` $ordered";
					break;
				case 6:
					$query .= " ORDER BY `parts` $ordered";
					break;
			};
			
			$pagetitle = "Ingame vehicles";	
			break;
		case 5:
			$query = "SELECT deployable.class_name, instance_deployable.* FROM `deployable`, `instance_deployable` WHERE deployable.id = instance_deployable.deployable_id AND instance_deployable.instance_id = '".$serverinstance."'";
			
			switch ($sort) { 
				case 1:
					$query .= " ORDER BY instance_deployable.id $ordered";
					break;
				case 2:
					$query .= " ORDER BY `unique_id` $ordered";
					break;
				case 3:
					$query .= " ORDER BY `class_name` $ordered";
					break;
				case 4:
					$query .= " ORDER BY `worldspace` $ordered";
					break;
				case 5:
					$query .= " ORDER BY `inventory` $ordered";
					break;
			};
			
			$pagetitle = "Ingame deployables";
			break;
		default:
			$pagetitle = "Online players";
	};
		
	include('modules/tables/'.$show.'.php');
	
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
					<div id="table-content">
						<!--  start message-blue -->
						<div id="message-blue">
							<table border="0" width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td class="blue-left"><?php echo $pagetitle.": ".$pnumber; ?>. </td>
									<td class="blue-right"><a class="close-blue"><img src="images/forms/icon_close_blue.gif"   alt="" /></a></td>
								</tr>
							</table>
						</div>
						<!--  end message-blue -->
						
						<?php echo $paging; ?>				
						<br/>
						<br/>
						<?php echo $formhead;?>	
							<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
								<?php echo $tableheader;
								echo $tablerows; ?>				
							</table>
						<?php echo $formfoot;?>	
					</div>

					<?php echo $paging; ?>
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

<?php
}
else
{ 
	header('Location: index.php');
}
?>