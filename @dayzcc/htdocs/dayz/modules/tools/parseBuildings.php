<?
if (isset($_SESSION['user_id']))
{

/* 3D Editor Mission File Parser
 *
 * This will take your mission file and add any new buildings to your building table
 * Written by: Planek and Crosire
 *
 */
 
 if (file_exists("buildings.sqf")) {
 
	$missionfile = file_get_contents("buildings.sqf");
	$rows = explode("\n", $missionfile); array_shift($rows);
	$vehiclecount = 0;
	
	?>

	<div id="page-heading">
		<h1>Create buildings</h1>
	</div>
	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
	<tr>
		<th rowspan="3" class="sized"><img src="images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
		<th class="topleft"></th>
		<td id="tbl-border-top">&nbsp;</td>
		<th class="topright"></th>
		<th rowspan="3" class="sized"><img src="images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
	</tr>
	<tr>
		<td id="tbl-border-left"></td>
		<td>
		<div id="content-table-inner">
		
			<table border=1px>
			<tr>
				<th>Class Name</th>
				<th>Position</th>
				<th>Vehicle ID</th>
			</tr>

			<?
			
			$resultIDQuery = mysql_query("SELECT `id` FROM building;");
			while ($row = mysql_fetch_array($resultIDQuery, MYSQL_NUM)) {$userDataIDs[] = $row[0];}
			$id = max($userDataIDs) + 1;
				
			for($i = 0; $i < count($rows); $i++)
			{
				$direction = 0;
				$exists = false;
				
				if (strpos($rows[$i], '_this = createVehicle [') !== false)
				{
					// Get values
					
					$strings = explode("\"",$rows[$i]);
					$firstOpenBracket = strpos($rows[$i], "[");
					$secondOpenBracket = strpos($rows[$i], "[", $firstOpenBracket + strlen("]"));
					$firstCloseBracket = strpos($rows[$i], "]");
				
					if (strpos($rows[$i+2], '_this setDir') !== false)
					{
						$firstSpace = strpos($rows[$i+2], " ");
						$secondSpace = strpos($rows[$i+2], " ", $firstSpace + strlen(" "));
						$thirdSpace = strpos($rows[$i+2], " ", $secondSpace + strlen(" "));
						$forthSpace = strpos($rows[$i+2], " ", $thirdSpace + strlen(" "));
						$period = strpos($rows[$i+2], ".");
						$direction = substr($rows[$i+2], $forthSpace + 1, $period - $forthSpace - 1);
					}
				
					$pos = "[$direction,".substr($rows[$i], $secondOpenBracket, $firstCloseBracket - $secondOpenBracket+1)."]";
					$pos = str_replace(array(' '), '', $pos);
					$newPos = explode(",",$pos);
					
					if (count($newPos) == 3)
					{
						$pos = "[$direction,".substr($rows[$i], $secondOpenBracket, $firstCloseBracket - $secondOpenBracket).",0]]";
						$pos = str_replace(array(' '), '', $pos);
					}

					// Insert to database
					
					$resultCheckQuery = mysql_query("SELECT * FROM `instance_building`;");
					while ($row = mysql_fetch_array($resultCheckQuery)) {if ($row['worldspace'] == $pos) {$exists = true;}}
					
					if (!$exists) {
						$resultClassNameQuery = mysql_query("SELECT * FROM `vehicle`;");
						$userDataClassNameQuery;
						$userDataVehicleIDs;
						while ($row = mysql_fetch_array($resultClassNameQuery, MYSQL_ASSOC)) {$userDataClassNameQuery[] = $row['class_name'];}
						$matchFound = 0;
						
						for($j = 0; $j < count($userDataClassNameQuery) - 1; $j++)
						{
							if ($strings[1] == $userDataClassNameQuery[$j]) {$matchFound = 1;}
						}
					
						if($matchFound == 0)
						{
							//echo "Inserting new Class Name";
							mysql_query("INSERT INTO `building` (`class_name`) VALUES ('$strings[1]');");
						}
					
						//$timeset = date_default_timezone_get(America/Indiana/Petersburg);
						$time = date("y-m-d H:i:s", time ());
						
						$resultIDQuery = mysql_query("SELECT * FROM `building` WHERE `class_name` = '$strings[1]';");
						$userDataIDQuery = mysql_fetch_array($resultIDQuery, MYSQL_ASSOC);
						$vbuilding_id = $userDataIDQuery['id'];
						
						mysql_query("INSERT INTO `instance_building` (`building_id`, `instance_id`, `worldspace`, `created`) VALUES ('$building_id', '$serverinstance', '$pos', '$time');");
						
						$vehiclecount++;
						$id++;
					?>
						
					<tr>
						<td><? echo $strings[1] ?></td>
						<td><? echo $pos ?></td>
						<td><? echo $vehicle_id ?></td>
					</tr>
					
					<?
					}
				}
			}
			
			?>
			
			</table>

			<br />
			<br />

			<strong><? echo $vehiclecount; ?></strong> new buildings added!

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
	
	<?
	}
	else
	{
		echo "<div id='page-heading'><h2>Mission file not found</h2></div>";
	}
}
else
{
	header('Location: index.php');
}
?>