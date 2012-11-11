<?
if (isset($_SESSION['user_id']) and (strpos($_SESSION['user_permissions'],"list")!==false))
{
	$pagetitle = "Whitelist";
	
	// Thanks to deadfred666 for parts of his code!
	if (ISSET($_POST['action']))
	{
		// Add Whitelisted User
		if ($_POST['action'] == "Add") {
			$totalFields = 0;
			if (isset($_POST['name'])) { $name = $_POST['name']; $totalFields++; }
			if (isset($_POST['guid'])) { $guid = $_POST['guid']; $totalFields++; }
			if ($totalFields == 2) {
				mysql_query("INSERT INTO whitelist (`name`, `guid`, `is_whitelisted`) VALUES ('".$name."', '".$guid."', '1');") or die(mysql_error());
				print "<div>$name ($guid) was added to the whitelist!</div>";
			} else {
				echo "<div>Error: Requiered Field Missing</div>";
			}
		}
	
		// Remove Whitelist User
		if ($_POST['action'] == "On" || $_POST['action'] == "Off") {
			if (isset($_POST['id'])) {
				$id = $_POST['id'];
				if ($_POST['status'] == 0) { $status = 1; } else { $status = 0; }
				mysql_query("UPDATE `whitelist` SET `is_whitelisted` = '".$status."' WHERE `id` = '".$id."';") or die(mysql_error());
			}
		}
	}
		
	$tablerows = '';
	$res = mysql_query("select * from `whitelist`;") or die(mysql_error());
	while ($row = mysql_fetch_array($res)){
		if ($row['is_whitelisted'] == 1) {
			$button = "Off";
			$icon = "status_green.png";
		} else {
			$button = "On";
			$icon = "status_red.png";
		}
		
		$tablerows .= "<form action=\"\" method=\"POST\"><tr>
			<td align=\"center\" class=\"gear_preview\" style=\"vertical-align:middle;\"><input type=\"hidden\" name=\"id\" value=\"".$row['id']."\"><input type=\"submit\" name=\"action\" value=\"".$button."\" style=\"width: 60px\"></td>
			<td align=\"center\" class=\"gear_preview\" style=\"vertical-align:middle;\"><input type=\"hidden\" name=\"status\" value=\"".$row['is_whitelisted']."\"><img src=\"images/".$icon."\"></td>
			<td align=\"center\" class=\"gear_preview\" style=\"vertical-align:middle;\"><a href=\"\">".$row['name']."</a></td>
			<td align=\"center\" class=\"gear_preview\" style=\"vertical-align:middle;\"><a href=\"\">".$row['guid']."</a></td>
			</tr></form>";
	}

	$formhead = "";
	$formfoot = "";
?>

<div id="page-heading">
<?
	echo "<title>".$pagetitle." - ".$sitename."</title>";
	echo "<h1>".$pagetitle."</h1>";
?>
</div>
<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
	<tr>
		<th rowspan="3" class="sized"><img src="<?echo $path;?>images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
		<th class="topleft"></th>
		<td id="tbl-border-top">&nbsp;</td>
		<th class="topright"></th>
		<th rowspan="3" class="sized"><img src="<?echo $path;?>images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
	</tr>
	<tr>
		<td id="tbl-border-left"></td>
		<td>
		<!--  start content-table-inner ...................................................................... START -->
		<div id="content-table-inner">		
			<!--  start table-content  -->
			<div id="table-content">
				
				<!--  start product-table ..................................................................................... -->
				<? echo $formhead;?>	
					<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
						<thead>
							<tr>
								<th class="table-header-repeat line-left"><a href="">Action</a></th>
								<th class="table-header-repeat line-left"><a href="">Enabled</a></th>
								<th class="table-header-repeat line-left"><a href="">Name</a></th>
								<th class="table-header-repeat line-left"><a href="">GUID</a></th>
							</tr>
						</thead>
						<tbody>
							<form method="POST">
								<tr>
									<td align="center" class="gear_preview" style="vertical-align:middle;"><input type="submit" name="action" value="Add" style="width: 60px"></td>
									<td align="center" class="gear_preview" style="vertical-align:middle;"></td>
									<td align="center" class="gear_preview" style="vertical-align:middle;"><input type="text" name="name" style="width: 300px"></td>
									<td align="center" class="gear_preview" style="vertical-align:middle;"><input type="text" name="guid" style="width: 300px"></td>
								</tr>
							</form>
							<? echo $tablerows; ?>
						</tbody>
					</table>
				<? echo $formfoot;?>	
				<!--  end product-table................................... --> 
			</div>
			<!--  end content-table  -->
	
			<div class="clear"></div>

		</div>
		<!--  end content-table-inner ............................................END  -->
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
<?
}
else
{
	header('Location: index.php');
}
?>