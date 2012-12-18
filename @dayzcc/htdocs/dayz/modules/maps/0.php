<!--<meta http-equiv="refresh" content="10">-->

<?php
	error_reporting (E_ALL ^ E_NOTICE);

	$cmd = "players";	
	$answer = rcon($serverip, $serverport, $rconpassword, $cmd);

	if ($answer != "") {
		$k = strrpos($answer, "---");
		$l = strrpos($answer, "(");
		$out = substr($answer, $k + 4, $l - $k - 5);
		$parray = preg_split ('/$\R?^/m', $out);

		$players = array();
		for ($j = 0; $j < count($parray); $j++) {$players[] = "";}
		for ($i = 0; $i < count($parray); $i++)
		{
			$m = 0;
			$players[$i][] = "";
			$pout = preg_replace('/\s+/', ' ', $parray[$i]);
			for ($j = 0; $j < strlen($pout); $j++) {
				$char = substr($pout, $j, 1);
				if ($m < 4) {
					if ($char != " ") {$players[$i][$m] .= $char;} else {$m++;}
				} else {
					$players[$i][$m] .= $char;
				}
			}
		}
		
		$markers = "";

		for ($i = 0; $i < count($players); $i++) {
			if (strlen($players[$i][4]) > 1){
				$playername = trim(str_replace(" (Lobby)", "", $players[$i][4]));
				$ip = $players[$i][1];
				$ping = $players[$i][2];
				
				$res = mysql_query("SELECT profile.name, survivor.* FROM `profile`, `survivor` AS `survivor` WHERE profile.unique_id = survivor.unique_id AND profile.name LIKE '".$playername."' ORDER BY survivor.last_updated DESC LIMIT 1;") or die(mysql_error());
				$markers .= markers_player($res, $serverworld);			
			}
		}

		include ('/modules/leaf.php');
	}
	else
	{
		echo "<div id='page-heading'><h2>BattlEye did not respond within the specified time.</h2></div>";
	}
?>