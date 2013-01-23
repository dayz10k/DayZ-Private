<?php
if (isset($_SESSION['user_id']) and (strpos($_SESSION['user_permissions'], "control") !== false))
{ 
	$pagetitle = "Server Control";
	$exebec = "bec_".$serverinstance.".exe";

	if (isset($_GET['action'])) {
		switch($_GET['action']) {
			case 0:
				pclose(popen('start "" /d "'.$patharma.'" /b "'.$pathserver.'" -beta=Expansion\\beta;Expansion\\beta\\Expansion -mod='.$servermodlist.' -name=Server -config=@dayzcc_config\\'.$serverinstance.'\\config.cfg -cfg=@dayzcc_config\\'.$serverinstance.'\\basic.cfg -profiles=@dayzcc_config\\'.$serverinstance.' -port='.$serverport.' -cpuCount=2 -maxMem=2047 -noSound -exThreads=1 -noPause', 'r'));
				mysql_query("INSERT INTO `log_tool`(`action`, `user`, `timestamp`) VALUES ('START SERVER','{$_SESSION['login']}', NOW())");
				sleep(6);
				break;
			case 1:
				$output = exec('taskkill /IM '.$exeserver);
				mysql_query("INSERT INTO `log_tool` (`action`, `user`, `timestamp`) VALUES ('STOP SERVER', '{$_SESSION['login']}', NOW())");
				sleep(6);
				break;
			case 3:
				pclose(popen('start "" /d "'.$patharma.'\\@dayzcc_config\\'.$serverinstance.'\\BattlEye Extended Controls" "'.$patharma.'\\@dayzcc_config\\'.$serverinstance.'\\BattlEye Extended Controls\\'.$exebec.'" -f config.cfg', 'r'));
				mysql_query("INSERT INTO `log_tool` (`action`, `user`, `timestamp`) VALUES ('START BEC', '{$_SESSION['login']}', NOW())");
				sleep(6);
				break;
			case 4:
				$output = exec('taskkill /IM "'.$exebec.'"');
				mysql_query("INSERT INTO `log_tool` (`action`, `user`, `timestamp`) VALUES ('STOP BEC', '{$_SESSION['login']}', NOW())");
				sleep(6);
				break;
			case 5:
				$answer = rcon($serverip, $serverport, $rconpassword, "#restart");
				mysql_query("INSERT INTO `log_tool` (`action`, `user`, `timestamp`) VALUES ('RESTART SERVER', '{$_SESSION['login']}', NOW())");
				sleep(1);
				break;
			case 6:
				exec('taskkill /IM "arma2oaserver_'.$serverinstance.'.exe" /F 2>&1', $output);
				mysql_query("INSERT INTO `log_tool` (`action`, `user`, `timestamp`) VALUES ('KILLED SERVER', '{$_SESSION['login']}', NOW())");
				sleep(3);
				$outmessage = implode('&nbsp;', $output);
				break;
			default:
				sleep(1);
		}
	}

	if ((str_replace('"', "", explode(",", strtolower(exec('tasklist /FI "IMAGENAME eq '.$exeserver.'" /FO CSV')))[0])) == strtolower($exeserver)) {
		$serverrunning = true;
	} else {
		$serverrunning = false;
	}
	if ((str_replace('"', "", explode(",", strtolower(exec('tasklist /FI "IMAGENAME eq '.$exebec.'" /FO CSV')))[0])) == strtolower($exebec)) {
		$becrunning = true;
	} else {
		$becrunning = false;
	}
	
	?>
	
	<div id="page-heading">
		<?php
			echo "<title>".$pagetitle." - ".$sitename."</title>";
			echo "<h1>".$pagetitle."</h1>";
		?>
	</div>

	<table id="content-table" border="0" width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<th rowspan="3"><img src="images/forms/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
			<th class="corner-topleft"></th>
			<td class="border-top">&nbsp;</td>
			<th class="corner-topright"></th>
			<th rowspan="3"><img src="images/forms/side_shadowright.jpg" width="20" height="300" alt="" /></th>
		</tr>
		<tr>
			<td class="border-left"></td>
			<td>
			<div id="content-table-inner">	
				<div id="table-content">
					<?php if ($serverrunning) { ?>
						<div id="message-green">
						<table border="0" width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td class="green-left">Server is running.</td>
							<td class="green-right"><a class="close-green"><img src="images/forms/icon_close_green.gif"   alt="" /></a></td>
						</tr>
						</table>
						</div>
						<div id="step-holder">	
							<div class="step-no"><a href="index.php?view=control&action=5"><img src="images/icons/start.png"/></div>
							<div class="step-dark-left">Restart</div>
							<div class="step-dark-right">&nbsp;</div>
							<div class="step-no"><a href="index.php?view=control&action=1"><img src="images/icons/stop.png"/></a></div>
							<div class="step-dark-left"><a href="index.php?view=control&action=1">Stop</a></div>
							<div class="step-dark-right">&nbsp;</div>
							<div class="step-no"><a href="index.php?view=control&action=1"><img src="images/icons/stop.png"/></a></div>
							<div class="step-dark-left"><a href="index.php?view=control&action=6">Kill Process</a></div>
							<div class="step-dark-round">&nbsp;</div>
							<div class="clear"></div>
						</div>
						<?php if ($becrunning){ ?>
							<div id="message-green">
								<table border="0" width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td class="green-left">BattlEye Extended Controls is running.</td>
									<td class="green-right"><a class="close-green"><img src="images/forms/icon_close_green.gif"   alt="" /></a></td>
								</tr>
								</table>
							</div>
							<div id="step-holder">	
									<div class="step-no-off"><img src="images/icons/start.png"/></div>
									<div class="step-light-left">Start</div>
									<div class="step-light-right">&nbsp;</div>
									<div class="step-no"><a href="index.php?view=control&action=4"><img src="images/icons/stop.png"/></a></div>
									<div class="step-dark-left"><a href="index.php?view=control&action=4">Stop</a></div>
									<div class="step-dark-round">&nbsp;</div>
									<div class="clear"></div>
							</div>
						<?php } else { ?>
							<div id="message-yellow">
								<table border="0" width="100%" cellpadding="0" cellspacing="0">
								<tr>
									<td class="yellow-left">BattlEye Extended Controls is not running.</td>
									<td class="yellow-right"><a class="close-yellow"><img src="images/forms/icon_close_yellow.gif"   alt="" /></a></td>
								</tr>
								</table>
							</div>
							<div id="step-holder">	
								<div class="step-no"><a href="index.php?view=control&action=3"><img src="images/icons/start.png"/></a></div>
								<div class="step-dark-left"><a href="index.php?view=control&action=3">Start</a></div>
								<div class="step-dark-right">&nbsp;</div>
								<div class="step-no-off"><img src="images/icons/stop.png"/></div>
								<div class="step-light-left">Stop</div>
								<div class="step-light-round">&nbsp;</div>
								<div class="clear"></div>
							</div>
					<?php } } else { ?>
						<div id="message-red">
							<table border="0" width="100%" cellpadding="0" cellspacing="0">
							<tr>
								<td class="red-left">Server is stopped.<?php if (isset($outmessage)) { echo " (".$outmessage.")"; } ?></td>
								<td class="red-right"><a class="close-red"><img src="images/forms/icon_close_red.gif"   alt="" /></a></td>
							</tr>
							</table>
						</div>
						<div id="step-holder">	
							<div class="step-no"><a href="index.php?view=control&action=0"><img src="images/icons/start.png"/></a></div>
							<div class="step-dark-left"><a href="index.php?view=control&action=0">Start</a></div>
							<div class="step-dark-right">&nbsp;</div>
							<div class="step-no-off"><img src="images/icons/stop.png"/></div>
							<div class="step-light-left">Stop</div>
							<div class="step-light-round">&nbsp;</div>
							<div class="clear"></div>
						</div>
					<?php } ?>
				</div>
				<div class="clear"></div>
			</div>
			</td>
			<td class="border-right"></td>
		</tr>
		<tr>
			<th class="corner-bottomleft"></th>
			<td class="border-bottom">&nbsp;</td>
			<th class="corner-bottomright"></th>
		</tr>
	</table>
	
<?php
}
else
{ 
	header('Location: index.php');
}
?>