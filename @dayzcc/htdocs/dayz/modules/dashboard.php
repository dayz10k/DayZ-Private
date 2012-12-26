<?php
if (isset($_SESSION['user_id']))
{ 
	ini_set("display_errors", 0);
	error_reporting (E_ALL ^ E_NOTICE);

	$pagetitle = "Dashboard";

	$logs = "";
	$res = mysql_query("SELECT * FROM `log_tool` ORDER BY `timestamp` DESC LIMIT 100;") or die(mysql_error());
	while ($row = mysql_fetch_array($res)) {$logs .= $row['timestamp'].' '.$row['user'].': '.$row['action'].chr(13); }
	
	$xml = file_get_contents('/quicklinks.xml', true);
	require_once('modules/xml2array.php');
	$quicklinks = XML2Array::createArray($xml);

	// GameQ Server define, fixed by Crosire to allow multiple instances
	require_once('modules/gameq.php');
	$servers = array('dayzserver' => array('armedassault2', $serverip, $serverport));
	$gq = new GameQ();
	$gq->addServers($servers);
	$gq->setOption('timeout', 200);
	$gq->setFilter('normalise');
	$gq->setFilter('sortplayers', 'gq_ping');
	$gqresults = $gq->requestData();

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
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td width="40%">
							<?php
								foreach ($gqresults as $id => $data) {
									if (!$data['gq_online']) {
										echo "<p>Server did not respond within the specified time.</p>";
									} else {
										echo "<h2>".$data['gq_hostname']."</h2>
											<h2>Address:</h2><h3>".(gethostbyname(trim(`hostname`))).":".$data['gq_port']."</h3>
											<h2>Mods:</h2><h3>".$data['gq_mod']."</h3>
											<h2>Max players:</h2><h3>".$data['gq_maxplayers']."</h3>
											<h2>Online players:</h2><h3>".$data['gq_numplayers']."</h3>";
									}
								}
							?>
						</td>
						<td width="10%">
							<?php include_once('modules/watch.php'); ?>
						</td>
						<td width="50%">
							<?php include_once('modules/say.php'); ?>
						</td>
					</tr>
				</table>
				<table border="0" width="100%" cellpadding="0" cellspacing="0" id="product-table">
					<tr>
						<th class="table-header-repeat line-left minwidth-1"><a href="">Quick links</a>	</th>
						<th class="table-header-repeat line-left minwidth-1"><a href="">Actions log</a></th>
					</tr>
					<tr>
						<td align="center" width="50%">
							<div id="quicklinks">
								<ul>
								<?php
									foreach ($quicklinks['quicklinks'] as $ql) { if ($ql != null) { ?>
										<li>
											<a href="<?php echo $ql['Link']; ?>" style="color: #000;">
												<span class="quicklink-box">
													<img src="images/icons/<?php echo $ql['Icon']; ?>" alt="<?php echo $ql['Name']; ?>" /><br />
													<strong><?php echo $ql['Name']; ?></strong>
												</span>
											</a>
										</li>
									<?php } } ?>
								</ul>
							</div>
						</td>
						<td align="center" width="50%">
							<textarea cols="68" rows="12" readonly><?php echo $logs; ?></textarea>
						</td>	
					</tr>
				</table>
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