<?php
if (isset($_SESSION['user_id']) and (strpos($_SESSION['user_permissions'],"list")!==false))
{
	$pagetitle = "Kill Feed";
	
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

	$query = "SELECT * FROM `log_feed` ORDER BY `created` DESC LIMIT 250";
	$res = mysql_query($query) or die(mysql_error());
	$pnumber = mysql_num_rows($res);		

	$tableheader = '<tr>
		<th class="table-header-repeat line-left" width="25%"><a href="">Player Name</a></th>
		<th class="table-header-repeat line-left" width="10%"><a href="">Player UID</a></th>
		<th class="table-header-repeat line-left" width="10%"><a href="">Position</a></th>
		<th class="table-header-repeat line-left" width="25%"><a href="">Event</a></th>
		<th class="table-header-repeat line-left" width="30%"><a href="">Timestamp</a></th>
		</tr>';
	
	while ($row=mysql_fetch_array($res)) {
		$Worldspace = str_replace("[", "", $row['pos']);
		$Worldspace = str_replace("]", "", $Worldspace);
		$Worldspace = explode(",", $Worldspace);
		
		switch($row['code'])
		{
			case "1":
				$event = "Killed survivor";
				break;
			case "2":
				$event = "Killed bandit"; 
				break;
			case "3":
				$event = "<font color=\"#FF0000\">Died</font>"; 
				break;
			default:
				$event = "Other";
		}
		
		include_once($path.'modules/calc.php');
		$pos = world_pos($Worldspace, $serverworld);
		/*if(world_pos_x($Worldspace, $serverworld) > 100)
		{
			$pos = "<font color=#00FF00>".world_pos($Worldspace, $serverworld)." (Greenzone)</font>";
		}
		else
		{
			$pos = "<font color=#FF0000>".world_pos($Worldspace, $serverworld)." (Banditland)</font>";
		}*/
		
		$tablerows .= "<tr>
			<td align=\"center\" class=\"gear_preview\"><a href=\"\"><a href=\"index.php?view=info&show=1&id=".$row['unique_id']."&cid=".$row['id']."\">".$row['name']."</a></td>
			<td align=\"center\" class=\"gear_preview\"><a href=\"\"><a href=\"index.php?view=info&show=1&id=".$row['unique_id']."&cid=".$row['id']."\">".$row['unique_id']."</a></td>
			<td align=\"center\" class=\"gear_preview\"><a href=\"\">".$pos."</a></td>
			<td align=\"center\" class=\"gear_preview\"><a href=\"\">".$event."</a></td>
			<td align=\"center\" class=\"gear_preview\"><a href=\"\">".$row['created']."</a></td>
			</tr>";
	}
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
				<!--  start paging..................................................... -->
				<? echo $paging; ?>				
				<!--  end paging................ -->
				<br/>
				<br/>
				<!--  start product-table ..................................................................................... -->
				<? echo $formhead;?>	
					<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
						<? echo $tableheader; ?>
						<? echo $tablerows; ?>				
					</table>
				<? echo $formfoot;?>	
				<!--  end product-table................................... --> 
			</div>
			<!--  end content-table  -->
				
			<!--  start paging..................................................... -->
			<? echo $paging; ?>				
			<!--  end paging................ -->
	
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
