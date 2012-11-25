<?
	error_reporting (E_ALL ^ E_NOTICE);

	$cmd = "players";
	$answer = rcon($serverip, $serverport, $rconpassword, $cmd);
	$tableheader = header_player_online($show);

	if ($answer != "") {
		$k = strrpos($answer, "---");
		$l = strrpos($answer, "(");
		$out = substr($answer, $k + 4, $l - $k - 5);
		$pnumber = substr($answer, $l + 1, 1);
		$array = preg_split ('/$\R?^/m', $out);
		
		//echo $answer."<br />";
		
		$players = array();
		for ($j = 0; $j < count($array); $j++){$players[] = "";}
		for ($i = 0; $i < count($array); $i++)
		{
			$m = 0;
			for ($j = 0; $j < 5; $j++){$players[$i][] = "";}
			$pout = preg_replace('/\s+/', ' ', $array[$i]);
			for ($j = 0; $j < strlen($pout); $j++){
				$char = substr($pout, $j, 1);
				if($m < 4){
					if($char != " ") {$players[$i][$m] .= $char;} else {$m++;}
				} else {
					$players[$i][$m] .= $char;
				}
			}
		}
		
		for ($i=0; $i<count($players); $i++){
			if(strlen($players[$i][4]) > 1){
				$k = strrpos($players[$i][4], " (Lobby)");
				$playername = str_replace(" (Lobby)", "", $players[$i][4]);
				
				//$search = substr($playername, 0, 5);
				$paren_num = 0;
				$chars = str_split($playername);
				$new_string = '';
				foreach($chars as $char) {
					if ($char == '[') $paren_num++;
					elseif($char == ']') $paren_num--;
					elseif($paren_num == 0) $new_string .= $char;
				}
				$playername = trim($new_string);

				$search = preg_replace("/[^\w\x7F-\xFF\s]/", " ", $playername);
				$good = trim(preg_replace("/\s(\S{1,2})\s/", " ", preg_replace("[ +]", "  "," $search ")));
				$good = trim(preg_replace("/\([^\)]+\)/", "", $good));
				$good = preg_replace("[ +]", " ", $good);

				$res = mysql_query("SELECT * FROM (SELECT profile.name, survivor.* FROM `profile`, `survivor` AS `survivor` WHERE profile.unique_id = survivor.unique_id) AS T WHERE `name` LIKE '%". str_replace(" ", "%' OR `name` LIKE '%", $good). "%' ORDER BY last_updated DESC LIMIT 1;") or die(mysql_error());
				$ip = $players[$i][1];
				$ping = $players[$i][2];
				$name = $players[$i][4];
				
				while ($row = mysql_fetch_array($res)) {$tablerows .= row_online_player($row, $players[$i], $serverworld);}
			}
		}
	}
	else
	{
		echo "<div id='page-heading'><h2>BattlEye did not respond within the specified time.</h2></div>";
	}

?>