<? 
if (isset($_SESSION['user_id']) and (strpos($_SESSION['user_permissions'],"control")!==false))
{
$pagetitle = "Server control";

?>
<div id="page-heading">
<?
	echo "<title>".$pagetitle." - ".$sitename."</title>";
	echo "<h1>".$pagetitle."</h1>";

	$commandString_server = "start \"\" /d \"".$path_arma."\" /b ".'"'.$path_server.'"'.$exe_server_string;
	$commandString_bec = "start \"\" /d \"".$path_bec."\" ".'"'.$path_bec.'\\'.$exe_bec.'"'.$exe_bec_string;

	$serverrunning = false;
	$becrunning = false;
	
	if (isset($_GET['action'])){
		switch($_GET['action']){
			case 0:
				pclose(popen($commandString_server, 'r'));
				$query = "INSERT INTO `log_tool`(`action`, `user`, `timestamp`) VALUES ('START SERVER','{$_SESSION['login']}',NOW())";
				$sql2 = mysql_query($query) or die(mysql_error());
				sleep(8);
		
				break;
			case 1:
				$serverexestatus = exec('tasklist /FI "IMAGENAME eq '.$exe_server.'" /FO CSV');
				$serverexestatus = explode(",", strtolower($serverexestatus));
				$serverexestatus = $serverexestatus[0];
				$serverexestatus = str_replace('"', "", $serverexestatus);
				
				if ($serverexestatus == strtolower($exe_server)){
					$output = exec('taskkill /IM '.$serverexestatus);
					$query = "INSERT INTO `log_tool`(`action`, `user`, `timestamp`) VALUES ('STOP SERVER','{$_SESSION['login']}',NOW())";
					$sql2 = mysql_query($query) or die(mysql_error());
				}
				sleep(8);

				break;
			case 3:
				pclose(popen($commandString_bec, 'r'));
				$query = "INSERT INTO `log_tool`(`action`, `user`, `timestamp`) VALUES ('START BEC','{$_SESSION['login']}',NOW())";
				$sql2 = mysql_query($query) or die(mysql_error());
				sleep(8);

				break;
			case 4:
				$becexestatus = exec('tasklist /FI "IMAGENAME eq '.$exe_bec.'" /FO CSV');
				$becexestatus = explode(",", strtolower($becexestatus));
				$becexestatus = $becexestatus[0];
				$becexestatus = str_replace('"', "", $becexestatus);
				
				if ($becexestatus == strtolower($exe_bec)){
					$output = exec('taskkill /IM '.$becexestatus);
					$query = "INSERT INTO `log_tool`(`action`, `user`, `timestamp`) VALUES ('STOP BEC','{$_SESSION['login']}',NOW())";
					$sql2 = mysql_query($query) or die(mysql_error());
				}
				sleep(8);

				break;
			case 5:
				$cmd = "#restart";
				$answer = rcon($serverip,$serverport,$rconpassword,$cmd);
				$query = "INSERT INTO `log_tool`(`action`, `user`, `timestamp`) VALUES ('RESTART SERVER','{$_SESSION['login']}',NOW())";
				$sql2 = mysql_query($query) or die(mysql_error());
				sleep(1);
		
				break;
			default:
				$serverexestatus = exec('tasklist /FI "IMAGENAME eq '.$exe_server.'" /FO CSV');
				$serverexestatus = explode(",", strtolower($serverexestatus));
				$serverexestatus = $serverexestatus[0];
				$serverexestatus = str_replace('"', "", $serverexestatus);
				
				if ($serverexestatus == strtolower($exe_server)){
					$output = exec('taskkill /IM '.$serverexestatus);
					$query = "INSERT INTO `log_tool`(`action`, `user`, `timestamp`) VALUES ('STOP SERVER','{$_SESSION['login']}',NOW())";
					$sql2 = mysql_query($query) or die(mysql_error());

				}
				sleep(8);

		}
	}

	$serverexestatus = exec('tasklist /FI "IMAGENAME eq '.$exe_server.'" /FO CSV');
	$serverexestatus = explode(",", strtolower($serverexestatus));
	$serverexestatus = $serverexestatus[0];
	$serverexestatus = str_replace('"', "", $serverexestatus);
	
	$becexestatus = exec('tasklist /FI "IMAGENAME eq '.$exe_bec.'" /FO CSV');
	$becexestatus = explode(",", strtolower($becexestatus));
	$becexestatus = $becexestatus[0];
	$becexestatus = str_replace('"', "", $becexestatus);
	
	if ($serverexestatus == strtolower($exe_server)){$serverrunning = true;} else {$serverrunning = false;}
	if ($becexestatus == strtolower($exe_bec)){$becrunning = true;} else {$becrunning = false;}
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
			<?
			if ($serverrunning){
			?>
				<!--  start message-green -->
				<div id="message-green">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="green-left">Server is running.</td>
					<td class="green-right"><a class="close-green"><img src="<?echo $path;?>images/table/icon_close_green.gif"   alt="" /></a></td>
				</tr>
				</table>
				</div>
				<!--  end message-green -->
				<!--  start step-holder -->
				<div id="step-holder">	
					<div class="step-no"><a href="index.php?view=control&action=5"><img src="<?echo $path;?>images/start.png"/></div>
					<div class="step-dark-left">Restart</div>
					<div class="step-dark-right">&nbsp;</div>
					<div class="step-no"><a href="index.php?view=control&action=1"><img src="<?echo $path;?>images/stop.png"/></a></div>
					<div class="step-dark-left"><a href="index.php?view=control&action=1">Stop</a></div>
					<div class="step-dark-round">&nbsp;</div>
					<div class="clear"></div>
				</div>
				<!--  end step-holder -->
				
				<!--  Code by Crosire -->
				<? if ($becrunning){
				?>
					<!--  bec message-green -->
					<div id="message-green">
					<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td class="green-left">BattlEye Extended Controls is running.</td>
						<td class="green-right"><a class="close-green"><img src="<?echo $path;?>images/table/icon_close_green.gif"   alt="" /></a></td>
					</tr>
					</table>
					</div>
					<!--  end message-green -->
					<!--  bec stop step-holder -->
					<div id="step-holder">	
						<div class="step-no-off"><img src="<?echo $path;?>images/start.png"/></div>
						<div class="step-light-left">Start</div>
						<div class="step-light-right">&nbsp;</div>
						<div class="step-no"><a href="index.php?view=control&action=4"><img src="<?echo $path;?>images/stop.png"/></a></div>
						<div class="step-dark-left"><a href="index.php?view=control&action=4">Stop</a></div>
						<div class="step-dark-round">&nbsp;</div>
						<div class="clear"></div>
					</div>
					<!--  end step-holder -->
				<? } else {
				?>
					<!--  bec message-yellow -->
					<div id="message-yellow">
					<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td class="yellow-left">BattlEye Extended Controls is not running.</td>
						<td class="yellow-right"><a class="close-yellow"><img src="<?echo $path;?>images/table/icon_close_yellow.gif"   alt="" /></a></td>
					</tr>
					</table>
					</div>
					<!--  end message-yellow -->
					<!--  bec start step-holder -->
					<div id="step-holder">	
						<div class="step-no"><a href="index.php?view=control&action=3"><img src="<?echo $path;?>images/start.png"/></a></div>
						<div class="step-dark-left"><a href="index.php?view=control&action=3">Start</a></div>
						<div class="step-dark-right">&nbsp;</div>
						<div class="step-no-off"><img src="<?echo $path;?>images/stop.png"/></div>
						<div class="step-light-left">Stop</div>
						<div class="step-light-round">&nbsp;</div>
						<div class="clear"></div>
					</div>
					<!--  end step-holder -->
				<?
				}
				?>
			<? } else {
			?>
				<!--  start message-red -->
				<div id="message-red">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="red-left">Server is stopped.</td>
					<td class="red-right"><a class="close-red"><img src="<?echo $path;?>images/table/icon_close_red.gif"   alt="" /></a></td>
				</tr>
				</table>
				</div>
				<!--  end message-red -->
				<!--  start step-holder -->
				<div id="step-holder">	
					<div class="step-no"><a href="index.php?view=control&action=0"><img src="<?echo $path;?>images/start.png"/></a></div>
					<div class="step-dark-left"><a href="index.php?view=control&action=0">Start</a></div>
					<div class="step-dark-right">&nbsp;</div>
					<div class="step-no-off"><img src="<?echo $path;?>images/stop.png"/></div>
					<div class="step-light-left">Stop</div>
					<div class="step-light-round">&nbsp;</div>
					<div class="clear"></div>
				</div>
				<!--  end step-holder -->
				<?
			}
			?>
			
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