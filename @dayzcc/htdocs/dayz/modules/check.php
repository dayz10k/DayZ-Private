<?php
if (isset($_SESSION['user_id']) and (strpos($_SESSION['user_permissions'], "table") !== false))
{ 
	$pagetitle = "Items check";
	mysql_query("INSERT INTO `log_tool` (`action`, `user`, `timestamp`) VALUES ('ITEMS CHECK', '{ $_SESSION['login']}', NOW())") or die(mysql_error());
	
	
		error_reporting (E_ALL ^ E_NOTICE);

		$xml = file_get_contents('/items.xml', true);
		require_once('/modules/xml2array.php');
		$items_xml = XML2Array::createArray($xml);

		$res = mysql_query("SELECT profile.name, survivor.* FROM `profile`, `survivor` AS `survivor` WHERE profile.unique_id = survivor.unique_id") or die(mysql_error());
		$number = mysql_num_rows($res);
		$rows = null;
		$itemscount = 0;
		
		if ($number == 0) { 
		  echo "<center>Not found!</center>";
		} else { 
			while ($row = mysql_fetch_array($res)) { 
				$Worldspace = str_replace("[", "", $row['pos']);
				$Worldspace = str_replace("]", "", $Worldspace);
				$Worldspace = explode(",", $Worldspace);

				$Inventory = $row['inventory'];	
				$Inventory = json_decode($Inventory);	

				$Backpack = $row['backpack'];
				$Backpack = json_decode($Backpack);

				$Unknown = array();
				
				if (array_key_exists(0, $Inventory)) { 
					if (array_key_exists(1, $Inventory)) { $Inventory = (array_merge($Inventory[0], $Inventory[1]));}
				} else { 
					if (array_key_exists(1, $Inventory)) { $Inventory = $Inventory[1];}			
				}		
				
				$bpweaponscount = count($Backpack[1][0]);
				$bpweapons = array();
				for ($m = 0; $m < $bpweaponscount; $m++) { for ($mi = 0; $mi < $Backpack[1][1][$m]; $mi++) { $bpweapons[] = $Backpack[1][0][$m];}}		
				$bpitemscount = count($Backpack[2][0]);
				$bpitems = array();
				for ($m = 0; $m < $bpitemscount; $m++) { for ($mi = 0; $mi < $Backpack[2][1][$m]; $mi++) { $bpitems[] = $Backpack[2][0][$m];}}
				
				$Backpack = (array_merge($bpweapons, $bpitems));
				$Inventory = (array_merge($Inventory, $Backpack));
									
				for ($i = 0; $i < count($Inventory); $i++) { 
					if (array_key_exists($i, $Inventory)) { 
						$curitem = $Inventory[$i];
						if (is_array($curitem)) { $curitem = $Inventory[$i][0];}
						if (!array_key_exists('s'.$curitem,$items_xml['items'])) { $Unknown[] = $curitem;}
					}
				}

				if (count($Unknown) > 0){ 
					$rows .= "<tr>
						<td>".$row['name']."</td>
						<td>".$row['unique_id']."</td>
						<td>";
						
					foreach($Unknown as $uitem => $uval) { 
						$rows .= $uval."; ";
						$itemscount++;
					}
					
					$rows .= "</td></tr>";
				}
			}
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
				<div id="table-content">
				<?php if ($itemscount > 0) { ?>
					<div id="message-red">
						<table border="0" width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td class="red-left">Warning! <?php echo $itemscount;?> unknown items found!</td>
								<td class="red-right"><a class="close-red"><img src="images/forms/icon_close_red.gif"   alt="" /></a></td>
							</tr>
						</table>
					</div>

					<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
						<tr>
							<th class="table-header-repeat line-left minwidth-1"><a href="">Player Name</a>	</th>
							<th class="table-header-repeat line-left minwidth-1"><a href="">Player UID</a></th>
							<th class="table-header-repeat line-left minwidth-1"><a href="">Unknown</a></th>
						</tr>
						<?php echo $rows; ?>				
					</table>
				<?php } else { ?>
					<div id="message-green">
						<table border="0" width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td class="green-left">No unknown items found!</td>
							<td class="green-right"><a class="close-red"><img src="images/forms/icon_close_green.gif"   alt="" /></a></td>
						</tr>
						</table>
					</div>
				<?php } ?>
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

<?php
}
else
{ 
	header('Location: index.php');
}
?>