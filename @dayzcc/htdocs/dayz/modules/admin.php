<?php
if (isset($_SESSION['user_id']) and (strpos($_SESSION['user_permissions'],"user") !== false))
{
	$pagetitle = "Manage users";
	$delresult = "";
	
	if (isset($_POST["user"])){
		$aDoor = $_POST["user"];
		$N = count($aDoor);
		
		for($i=0; $i < $N; $i++)
		{
			$resdel = mysql_query("SELECT * FROM users WHERE id = ".$aDoor[$i]."") or die(mysql_error());
			
			while ($rowdel = mysql_fetch_array($resdel)) {
				mysql_query("INSERT INTO `log_tool`(`action`, `user`, `timestamp`) VALUES ('DELETE USER: ".$rowdel['login']."','{$_SESSION['login']}',NOW())") or die(mysql_error());
				mysql_query("DELETE FROM `users` WHERE id='".$aDoor[$i]."'") or die(mysql_error());
				
				$delresult .= '<div id="message-green">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="green-left">User '.$rowdel['login'].' successfully removed!</td>
					<td class="green-right"><a class="close-green"><img src="'.$path.'images/table/icon_close_green.gif" alt="" /></a></td>
				</tr>
				</table>
				</div>';
			}		
			//echo($aDoor[$i]);
		}
		//echo $_GET["deluser"];
	}
	
	$res = mysql_query("SELECT * FROM users ORDER BY id ASC") or die(mysql_error());
	$number = mysql_num_rows($res);
	$users = "" ;
	while ($row=mysql_fetch_array($res)) { $users .= "<tr><td align=\"center\"><input name=\"user[]\" value=\"".$row['id']."\" type=\"checkbox\"/></td><td>".$row['id']."</td><td>".$row['login']."</td><td>".$row['permissions']."</td><td>".$row['lastlogin']."</td></tr>";}

	mysql_query("INSERT INTO `log_tool`(`action`, `user`, `timestamp`) VALUES ('MANAGE USERS','{$_SESSION['login']}',NOW())") or die(mysql_error());
?>
	<div id="dvPopup" style="display:none; width:900px; height: 450px; border:4px solid #000000; background-color:#FFFFFF;">
			<a id="closebutton" style="float:right;" href="#" onclick="HideModalPopup('dvPopup'); return false;"><img src="<?echo $path;?>images/table/action_delete.gif" alt="" /></a><br />
			<? include ($path.'/modules/register.php'); ?>
	</div>

	<div id="page-heading">
		<h1><? echo $pagetitle; ?></h1>
		<h1><? echo "<title>".$pagetitle." - ".$sitename."</title>"; ?></h1>
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
		<div id="content-table-inner">
			<? echo $delresult; ?>
			<div id="related-activities">
				<div id="related-act-top">
					<img width="271" height="43" alt="" src="<?echo $path;?>images/forms/header_related_act.gif">
				</div>
				<div id="related-act-bottom">
					<div id="related-act-inner">
						<div class="left"><a href="#" onclick="ShowModalPopup('dvPopup'); return false;">
							<img width="21" height="21" alt="" src="<?echo $path;?>images/forms/icon_plus.gif"></a>
						</div>
						<div class="right">
							<h5><a href="#" onclick="ShowModalPopup('dvPopup'); return false;">Add user</a></h5>
							Add new user
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</div>	
				
			<!--  start table-content  -->
			<div id="table-content">
			<form action="index.php?view=admin" method="post">
				<table border="1" width="75%" cellpadding="0" cellspacing="0" id="product-table">
				<tr>
					<th class="table-header-repeat line-left"><a href="">Delete</a></th>
					<th class="table-header-repeat line-left" width="5%"><a href="">Id</a>	</th>
					<th class="table-header-repeat line-left minwidth-1" width="30%"><a href="">Username</a></th>
					<th class="table-header-repeat line-left minwidth-1" width="45%"><a href="">Permissions</a></th>
					<th class="table-header-repeat line-left minwidth-1" width="20%"><a href="">Last access</a></th>
				</tr>
				<? echo $users; ?>				
				</table>
				<input type="submit" class="submit-login"  />
				</div>
			</form>
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
<?
}
else
{
	header('Location: index.php');
}
?>