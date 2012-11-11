<!--<meta http-equiv="refresh" content="10">-->
<?
	//ini_set( "display_errors", 0);
	error_reporting (E_ALL ^ E_NOTICE);

	$cmd = "players";	
	$answer = rcon($serverip,$serverport,$rconpassword,$cmd);

	if ($answer != "") {
		$k = strrpos($answer, "---");
		$l = strrpos($answer, "(");
		$out = substr($answer, $k+4, $l-$k-5);
		$array = preg_split ('/$\R?^/m', $out);
		
		//echo $answer."<br /><br />";

		$players = array();
		for ($j=0; $j<count($array); $j++){
			$players[] = "";
		}
		for ($i=0; $i < count($array); $i++)
		{
			$m = 0;
			for ($j=0; $j<5; $j++){
				$players[$i][] = "";
			}
			$pout = preg_replace('/\s+/', ' ', $array[$i]);
			for ($j=0; $j<strlen($pout); $j++){
				$char = substr($pout, $j, 1);
				if($m < 4){
					if($char != " "){
						$players[$i][$m] .= $char;
					}else{
						$m++;
					}
				} else {
					$players[$i][$m] .= $char;
				}
			}
		}
		
		$pnumber = count($players);

		$markers= "var markers = [";
		$m = 0;
		for ($i=0; $i<count($players); $i++){

			if(strlen($players[$i][4])>1){
				$k = strrpos($players[$i][4], " (Lobby)");
				$playername = str_replace(" (Lobby)", "", $players[$i][4]);
				
				$paren_num = 0;
				$chars = str_split($playername);
				$new_string = '';
				foreach($chars as $char) {
					if($char=='[') $paren_num++;
					else if($char==']') $paren_num--;
					else if($paren_num==0) $new_string .= $char;
				}
				$playername = trim($new_string);

				$search = preg_replace("/[^\w\x7F-\xFF\s]/", " ", $playername);
				$good = trim(preg_replace("/\s(\S{1,2})\s/", " ", preg_replace("[ +]", "  "," $search ")));
				$good = trim(preg_replace("/\([^\)]+\)/", "", $good));
				$good = preg_replace("[ +]", " ", $good);

				$query = "SELECT * FROM (SELECT profile.name, survivor.* FROM `profile`, `survivor` AS `survivor` WHERE profile.unique_id = survivor.unique_id) AS T WHERE `name` LIKE '%". str_replace(" ", "%' OR `name` LIKE '%", $good). "%' ORDER BY last_updated DESC LIMIT 1";
				$res = null;
				$res = mysql_query($query) or die(mysql_error());
				$dead = "";
				$inventory = "";
				$backpack = "";
				$ip = $players[$i][1];
				$ping = $players[$i][2];
				$name = $players[$i][4];
				$id = "0";
				$uid = "0";
				
				while ($row=mysql_fetch_array($res)) {
					$Worldspace = str_replace("[", "", $row['worldspace']);
					$Worldspace = str_replace("]", "", $Worldspace);
					$Worldspace = explode(",", $Worldspace);
					$x = 0;
					$y = 0;
					if(array_key_exists(1,$Worldspace)){$x = $Worldspace[1];}
					if(array_key_exists(2,$Worldspace)){$y = $Worldspace[2];}
					
					$dead = ($row['is_dead'] ? '_dead' : '');
					$inventory = substr($row['inventory'], 0, 40)."...";
					$backpack = substr($row['backpack'], 0, 40)."...";
					$id = $row['id'];
					$uid = $row['unique_id'];
					$model = $row['model'];
					$name = $row['name'];
					
					include_once($path.'modules/calc.php');
					$description = "<h2><a href=\"index.php?view=info&show=1&id=".$uid."&cid=".$id."\">".htmlspecialchars($name, ENT_QUOTES)." - ".$uid."</a></h2><table><tr><td><img style=\"max-width: 100px;\" src=\"".$path."images/models/".str_replace('"', '', $model).".png\"></td><td>&nbsp;</td><td style=\"vertical-align:top; \"><h2>Position:</h2>left: ".round(world_x($x,$serverworld))." top: ".round(world_y($y,$serverworld))."</td></tr></table>";
					$markers .= "['".htmlspecialchars($name, ENT_QUOTES)."', '".$description."', ".$x.", ".$y.", ".$m++.", '".$path."images/icons/player".$dead.".png'],";
				}				
			}
		}
		$markers .= "['Edge of map', 'Edge of map', 0.0, 0.0, 1, '".$path."images/thumbs/null.png']];";
		include ($path.'modules/gm.php');
	}
	else
	{
		echo "<div id='page-heading'><h2>BattlEye did not respond within the specified time.</h2></div>";
	}
?>