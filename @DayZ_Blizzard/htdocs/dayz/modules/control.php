<? 
if (isset($_SESSION['user_id']) and (strpos($_SESSION['user_permissions'],"control")!==false))
{
$pagetitle = "Server control";

?>
<div id="page-heading">
<?
	echo "<title>".$pagetitle." - ".$sitename."</title>";
	echo "<h1>".$pagetitle."</h1>";
	
	$servercommandString = "start \"\" /d \"".$serverpath."\" /b ".'"'.$serverexepath.'"'.$serverstring;
	$beccommandString = "start \"\" /d \"".$becpath."\" ".'"'.$becpath.'\\'.$becexe.'"'.$becstring;
	$haxcommandString = "start \"\" /d \"".$haxpath."\" ".'"'.$haxpath.'\\'.$haxexe.'"';

	$serverrunning = false;
	$becrunning = false;
	$haxrunning = false;
	
	if (isset($_GET['action'])){
		switch($_GET['action']){
			case 0:
				
				pclose(popen($servercommandString, 'r'));
				$query = "INSERT INTO `log_tool`(`action`, `user`, `timestamp`) VALUES ('START SERVER','{$_SESSION['login']}',NOW())";
				$sql2 = mysql_query($query) or die(mysql_error());
				sleep(5);
		
				break;
			case 1:
				$serverexestatus = exec('tasklist /FI "IMAGENAME eq '.$serverexe.'" /FO CSV');
				$serverexestatus = explode(",", strtolower($serverexestatus));
				$serverexestatus = $serverexestatus[0];
				$serverexestatus = str_replace('"', "", $serverexestatus);
				
				if ($serverexestatus == strtolower($serverexe)){
					$output = exec('taskkill /IM '.$serverexestatus);
					$query = "INSERT INTO `log_tool`(`action`, `user`, `timestamp`) VALUES ('STOP SERVER','{$_SESSION['login']}',NOW())";
					$sql2 = mysql_query($query) or die(mysql_error());
				}
				sleep(5);

				break;
			case 3:
				pclose(popen($beccommandString, 'r'));
				$query = "INSERT INTO `log_tool`(`action`, `user`, `timestamp`) VALUES ('START BEC','{$_SESSION['login']}',NOW())";
				$sql2 = mysql_query($query) or die(mysql_error());
				sleep(5);

				break;
			case 4:
				$becexestatus = exec('tasklist /FI "IMAGENAME eq '.$becexe.'" /FO CSV');
				$becexestatus = explode(",", strtolower($becexestatus));
				$becexestatus = $becexestatus[0];
				$becexestatus = str_replace('"', "", $becexestatus);
				
				if ($becexestatus == strtolower($becexe)){
					$output = exec('taskkill /IM '.$becexestatus);
					$query = "INSERT INTO `log_tool`(`action`, `user`, `timestamp`) VALUES ('STOP BEC','{$_SESSION['login']}',NOW())";
					$sql2 = mysql_query($query) or die(mysql_error());
				}
				sleep(5);

				break;
			case 5:
				pclose(popen($haxcommandString, 'r'));
				$query = "INSERT INTO `log_tool`(`action`, `user`, `timestamp`) VALUES ('START ANTIHAX','{$_SESSION['login']}',NOW())";
				$sql2 = mysql_query($query) or die(mysql_error());
				sleep(5);

				break;
			case 6:
				$haxexestatus = exec('tasklist /FI "IMAGENAME eq '.$haxexe.'" /FO CSV');
				$haxexestatus = explode(",", strtolower($haxexestatus));
				$haxexestatus = $haxexestatus[0];
				$haxexestatus = str_replace('"', "", $haxexestatus);
				
				if ($haxexestatus == strtolower($haxexe)){
					$output = exec('taskkill /IM '.$haxexestatus);
					$query = "INSERT INTO `log_tool`(`action`, `user`, `timestamp`) VALUES ('STOP ANTIHAX','{$_SESSION['login']}',NOW())";
					$sql2 = mysql_query($query) or die(mysql_error());
				}
				sleep(5);

				break;
			default:
				$serverexestatus = exec('tasklist /FI "IMAGENAME eq '.$serverexe.'" /FO CSV');
				$serverexestatus = explode(",", strtolower($serverexestatus));
				$serverexestatus = $serverexestatus[0];
				$serverexestatus = str_replace('"', "", $serverexestatus);
				
				if ($serverexestatus == strtolower($serverexe)){
					$output = exec('taskkill /IM '.$serverexestatus);
					$query = "INSERT INTO `log_tool`(`action`, `user`, `timestamp`) VALUES ('STOP SERVER','{$_SESSION['login']}',NOW())";
					$sql2 = mysql_query($query) or die(mysql_error());

				}
				sleep(5);

		}
	}

	$serverexestatus = exec('tasklist /FI "IMAGENAME eq '.$serverexe.'" /FO CSV');
	$serverexestatus = explode(",", strtolower($serverexestatus));
	$serverexestatus = $serverexestatus[0];
	$serverexestatus = str_replace('"', "", $serverexestatus);
	
	$becexestatus = exec('tasklist /FI "IMAGENAME eq '.$becexe.'" /FO CSV');
	$becexestatus = explode(",", strtolower($becexestatus));
	$becexestatus = $becexestatus[0];
	$becexestatus = str_replace('"', "", $becexestatus);
	
	$haxexestatus = exec('tasklist /FI "IMAGENAME eq '.$haxexe.'" /FO CSV');
	$haxexestatus = explode(",", strtolower($haxexestatus));
	$haxexestatus = $haxexestatus[0];
	$haxexestatus = str_replace('"', "", $haxexestatus);
	
	if ($serverexestatus == strtolower($serverexe)){
		$serverrunning = true;
	} else {
		$serverrunning = false;
	}
	
	if ($becexestatus == strtolower($becexe)){
		$becrunning = true;
	} else {
		$becrunning = false;
	}
	
	if ($haxexestatus == strtolower($haxexe)){
		$haxrunning = true;
	} else {
		$haxrunning = false;
	}
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
					<div class="step-no-off"><img src="<?echo $path;?>images/start.png"/></div>
					<div class="step-light-left">Start server</div>
					<div class="step-light-right">&nbsp;</div>
					<div class="step-no"><a href="index.php?view=control&action=1"><img src="<?echo $path;?>images/stop.png"/></a></div>
					<div class="step-dark-left"><a href="index.php?view=control&action=1">Stop server</a></div>
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
						<div class="step-light-left">Start BEC</div>
						<div class="step-light-right">&nbsp;</div>
						<div class="step-no"><a href="index.php?view=control&action=4"><img src="<?echo $path;?>images/stop.png"/></a></div>
						<div class="step-dark-left"><a href="index.php?view=control&action=4">Stop BEC</a></div>
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
						<div class="step-dark-left"><a href="index.php?view=control&action=3">Start BEC</a></div>
						<div class="step-dark-right">&nbsp;</div>
						<div class="step-no-off"><img src="<?echo $path;?>images/stop.png"/></div>
						<div class="step-light-left">Stop BEC</div>
						<div class="step-light-round">&nbsp;</div>
						<div class="clear"></div>
					</div>
					<!--  end step-holder -->
				<?
				}
				?>
				<? if ($haxrunning){
				?>
					<!--  hax message-green -->
					<div id="message-green">
					<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td class="green-left">DayZ AntiHax is running.</td>
						<td class="green-right"><a class="close-green"><img src="<?echo $path;?>images/table/icon_close_green.gif"   alt="" /></a></td>
					</tr>
					</table>
					</div>
					<!--  end message-green -->
					<!--  hax stop step-holder -->
					<div id="step-holder">	
						<div class="step-no-off"><img src="<?echo $path;?>images/start.png"/></div>
						<div class="step-light-left">Start AntiHax</div>
						<div class="step-light-right">&nbsp;</div>
						<div class="step-no"><a href="index.php?view=control&action=6"><img src="<?echo $path;?>images/stop.png"/></a></div>
						<div class="step-dark-left"><a href="index.php?view=control&action=6">Stop AntiHax</a></div>
						<div class="step-dark-round">&nbsp;</div>
						<div class="clear"></div>
					</div>
					<!--  end step-holder -->
				<? } else {
				?>
					<!--  hax message-yellow -->
					<div id="message-yellow">
					<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td class="yellow-left">DayZ AntiHax is not running.</td>
						<td class="yellow-right"><a class="close-yellow"><img src="<?echo $path;?>images/table/icon_close_yellow.gif"   alt="" /></a></td>
					</tr>
					</table>
					</div>
					<!--  end message-yellow -->
					<!--  hax start step-holder -->
					<div id="step-holder">	
						<div class="step-no"><a href="index.php?view=control&action=5"><img src="<?echo $path;?>images/start.png"/></a></div>
						<div class="step-dark-left"><a href="index.php?view=control&action=5">Start AntiHax</a></div>
						<div class="step-dark-right">&nbsp;</div>
						<div class="step-no-off"><img src="<?echo $path;?>images/stop.png"/></div>
						<div class="step-light-left">Stop AntiHax</div>
						<div class="step-light-round">&nbsp;</div>
						<div class="clear"></div>
					</div>
					<!--  end step-holder -->
					<!--  Code end by Crosire -->
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
					<div class="step-dark-left"><a href="index.php?view=control&action=0">Start server</a></div>
					<div class="step-dark-right">&nbsp;</div>
					<div class="step-no-off"><img src="<?echo $path;?>images/stop.png"/></div>
					<div class="step-light-left">Stop server</div>
					<div class="step-light-round">&nbsp;</div>
					<div class="clear"></div>
				</div>
				<!--  end step-holder -->
				<? if ($haxrunning){
				?>
					<!--  hax message-green -->
					<div id="message-green">
					<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td class="green-left">DayZ AntiHax is running.</td>
						<td class="green-right"><a class="close-green"><img src="<?echo $path;?>images/table/icon_close_green.gif"   alt="" /></a></td>
					</tr>
					</table>
					</div>
					<!--  end message-green -->
					<!--  hax stop step-holder -->
					<div id="step-holder">	
						<div class="step-no-off"><img src="<?echo $path;?>images/start.png"/></div>
						<div class="step-light-left">Start AntiHax</div>
						<div class="step-light-right">&nbsp;</div>
						<div class="step-no"><a href="index.php?view=control&action=6"><img src="<?echo $path;?>images/stop.png"/></a></div>
						<div class="step-dark-left"><a href="index.php?view=control&action=6">Stop AntiHax</a></div>
						<div class="step-dark-round">&nbsp;</div>
						<div class="clear"></div>
					</div>
					<!--  end step-holder -->
				<? } else {
				?>
					<!--  hax message-yellow -->
					<div id="message-yellow">
					<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td class="yellow-left">DayZ AntiHax is not running.</td>
						<td class="yellow-right"><a class="close-yellow"><img src="<?echo $path;?>images/table/icon_close_yellow.gif"   alt="" /></a></td>
					</tr>
					</table>
					</div>
					<!--  end message-yellow -->
					<!--  hax start step-holder -->
					<div id="step-holder">	
						<div class="step-no"><a href="index.php?view=control&action=5"><img src="<?echo $path;?>images/start.png"/></a></div>
						<div class="step-dark-left"><a href="index.php?view=control&action=5">Start AntiHax</a></div>
						<div class="step-dark-right">&nbsp;</div>
						<div class="step-no-off"><img src="<?echo $path;?>images/stop.png"/></div>
						<div class="step-light-left">Stop AntiHax</div>
						<div class="step-light-round">&nbsp;</div>
						<div class="clear"></div>
					</div>
					<!--  end step-holder -->
					<!--  Code end by Crosire -->
				<?
				}
				?>
			<?
			}
				$configarray = null;
				//$serverconfig = parse_ini_file($serverpath.DS.$serverconfig);
				$lines = file($serverpath.DS.$serverconfig);
				foreach ($lines as $l) {
					preg_match("/^(?P<key>\w+)\s+=\s+(?P<value>.*;)/", $l, $matches);
					if (isset($matches['key'])) {
						$configarray[$matches['key']] = htmlentities(str_replace(';', "", (str_replace('"', "", $matches['value']))));
					}
				}

				//echo $configarray['hostname'];
			?><!-- 
				<form action="index.php?view=control" method="post">
					<table id="id-form" border="0" cellpadding="0" cellspacing="0">
					<tr><th><h1>Parameter</h1></th><th><h1>Value</h1></th></tr>
					<tr><th>Server Name:</th>
					<td><input value="<? echo $configarray['hostname']; ?>" name="hostname" type="text" class="file file_1" style="display: inline; width: 300px;"/></td>
					</tr>
					<tr><th>Password:</th>
					<td><input value="<? echo $configarray['password']; ?>" name="password" type="text" class="file file_1" style="display: inline; width: 300px;"/></td>
					</tr>
					<tr><th>Admin password:</th>
					<td><input value="<? echo $configarray['passwordAdmin']; ?>" name="passwordAdmin" type="text" class="file file_1" style="display: inline; width: 300px;"/></td>
					</tr>
					<tr><th>IP reporting server:</th>
					<td><input value="<? echo $configarray['reportingIP']; ?>" name="reportingIP" type="text" class="file file_1" style="display: inline; width: 300px;"/></td>
					</tr>
					<tr><th>Log file:</th>
					<td><input value="<? echo $configarray['logFile']; ?>" name="logFile" type="text" class="file file_1" style="display: inline; width: 300px;"/></td>
					</tr>
					<tr><th>Max players:</th>
					<td><input value="<? echo $configarray['maxPlayers']; ?>" name="maxPlayers" type="text" class="file file_1" style="display: inline; width: 300px;"/></td>
					</tr>
					<tr><th>Kick duplicate:</th>
					<td><input value="<? echo $configarray['kickDuplicate']; ?>" name="kickDuplicate" type="text" class="file file_1" style="display: inline; width: 300px;"/></td>
					</tr>
					<tr><th>Verify signature:</th>
					<td><input value="<? echo $configarray['verifySignatures']; ?>" name="verifySignatures" type="text" class="file file_1" style="display: inline; width: 300px;"/></td>
					</tr>
					<tr><th>Equal mod required:</th>
					<td><input value="<? echo $configarray['equalModRequired']; ?>" name="equalModRequired" type="text" class="file file_1" style="display: inline; width: 300px;"/></td>
					</tr>
					<tr><th>Required build:</th>
					<td><input value="<? echo $configarray['requiredBuild']; ?>" name="requiredBuild" type="text" class="file file_1" style="display: inline; width: 300px;"/></td>
					</tr>
					<tr><th>Vote mission players:</th>
					<td><input value="<? echo $configarray['voteMissionPlayers']; ?>" name="voteMissionPlayers" type="text" class="file file_1" style="display: inline; width: 300px;"/></td>
					</tr>
					<tr><th>Vote threshold:</th>
					<td><input value="<? echo $configarray['voteThreshold']; ?>" name="voteThreshold" type="text" class="file file_1" style="display: inline; width: 300px;"/></td>
					</tr>
					<tr><th>Disable VoN:</th>
					<td><input value="<? echo $configarray['disableVoN']; ?>" name="disableVoN" type="text" class="file file_1" style="display: inline; width: 300px;"/></td>
					</tr>
					<tr><th>Vote threshold:</th>
					<td><input value="<? echo $configarray['voteThreshold']; ?>" name="voteThreshold" type="text" class="file file_1" style="display: inline; width: 300px;"/></td>
					</tr>
					<tr><th>VoN codec quality:</th>
					<td><input value="<? echo $configarray['vonCodecQuality']; ?>" name="vonCodecQuality" type="text" class="file file_1" style="display: inline; width: 300px;"/></td>
					</tr>
					<tr><th>Persistent:</th>
					<td><input value="<? echo $configarray['persistent']; ?>" name="persistent" type="text" class="file file_1" style="display: inline; width: 300px;"/></td>
					</tr>
					<tr><th>Time stamp format:</th>
					<td><input value="<? echo $configarray['timeStampFormat']; ?>" name="timeStampFormat" type="text" class="file file_1" style="display: inline; width: 300px;"/></td>
					</tr>
					<tr><th>BattlEye:</th>
					<td><input value="<? echo $configarray['BattlEye']; ?>" name="BattlEye" type="text" class="file file_1" style="display: inline; width: 300px;"/></td>
					</tr>
					<tr><th>MOTD interval:</th>
					<td><input value="<? echo $configarray['motdInterval']; ?>" name="motdInterval" type="text" class="file file_1" style="display: inline; width: 300px;"/></td>
					</tr>
					<tr><th>MOTD:</th>
					<td><textarea class="form-textarea" name="motd" cols="" rows="">"Private DayZ Server"</textarea></td>
					</tr>
					<tr><th>Missions:</th>
					<td><textarea class="form-textarea" name="missions" cols="" rows="">
					template = dayz_1.Chernarus;
					difficulty = "recruit";</textarea></td>
					</tr>
					<tr><th></th>
					<td>
					<input type="submit" class="submit-login"  />
					</td>
					</tr>
					</table>
				</form>-->
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