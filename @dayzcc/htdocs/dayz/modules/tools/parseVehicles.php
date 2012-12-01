<?php
if (isset($_SESSION['user_id']))
{

/* 3D Editor Mission File Parser
 *
 * This will take your mission file and add any new vehicles to your vehicle table and all spawn points
 * to your world_vehicle table
 * Written by: Planek and Crosire
 *
 */
 
	if (file_exists("vehicles.sqf")) {
		error_reporting (E_ALL ^ E_NOTICE);
		
		$missionfile = file_get_contents("vehicles.sqf");
		$rows = explode("\n", $missionfile); array_shift($rows);
		$vehiclecount = 0;

		?>

		<div id="page-heading">
			<h1>Create vehicles</h1>
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

					<?php

					$resultIDQuery = mysql_query("SELECT `id` FROM `world_vehicle`;");
					while ($row = mysql_fetch_array($resultIDQuery, MYSQL_NUM)) {$userDataIDs[] = $row[0];}
					$id = max($userDataIDs) + 1;
						
					for ($i = 0; $i < count($rows); $i++)
					{
						$direction = 0;
						$exists = false;
						
						if (strpos($rows[$i], '_this = createVehicle [') !== false)
						{
							// Get vehicle values
							
							$strings = explode("\"", $rows[$i]);
							$firstOpenBracket = strpos($rows[$i], "[");
							$secondOpenBracket = strpos($rows[$i], "[", $firstOpenBracket + strlen("]"));
							$firstCloseBracket = strpos($rows[$i], "]");
						
							if (strpos($rows[$i + 2], '_this setDir') !== false)
							{
								$firstSpace = strpos($rows[$i + 2], " ");
								$secondSpace = strpos($rows[$i + 2], " ", $firstSpace + strlen(" "));
								$thirdSpace = strpos($rows[$i + 2], " ", $secondSpace + strlen(" "));
								$forthSpace = strpos($rows[$i + 2], " ", $thirdSpace + strlen(" "));
								$period = strpos($rows[$i + 2], ".");
								$direction = substr($rows[$i + 2], $forthSpace + 1, $period - $forthSpace - 1);
							}
						
							$pos = "[$direction,".substr($rows[$i], $secondOpenBracket, $firstCloseBracket - $secondOpenBracket + 1)."]";
							$pos = str_replace(array(' '), '', $pos);
							$newPos = explode(",", $pos);
							
							if (count($newPos) == 3)
							{
								$pos = "[$direction,".substr($rows[$i], $secondOpenBracket, $firstCloseBracket - $secondOpenBracket).",0]]";
								$pos = str_replace(array(' '), '', $pos);
							}

							// Insert to database

							$resultCheckQuery = mysql_query("SELECT * FROM `instance_vehicle`;");
							while ($row = mysql_fetch_array($resultCheckQuery)) {if ($row['worldspace'] == $pos) {$exists = true;}}

							if (!$exists) {
								$matchFound = false;
								$resultClassNameQuery = mysql_query("SELECT * FROM `vehicle`;");
								while ($row = mysql_fetch_array($resultClassNameQuery, MYSQL_ASSOC)) {if ($strings[1] == $row['class_name']) {$matchFound = true;}}

								if(!$matchFound)
								{
									//echo "Inserting new Class Name";
									mysql_query("INSERT INTO `vehicle` (`class_name`, `damage_min`, `damage_max`, `fuel_min`, `fuel_max`, `limit_min`, `limit_max`, `parts`) VALUES ('$strings[1]', '0.100', '0.700', '0.200', '0.800', '0', '100', 'motor');");
								}

								$time = date("y-m-d H:i:s", time());
								
								$resultIDQuery = mysql_query("SELECT * FROM `vehicle` WHERE `class_name` = '$strings[1]';");
								$userDataIDQuery = mysql_fetch_array($resultIDQuery, MYSQL_ASSOC);
								$vehicle_id = $userDataIDQuery['id'];
								$resultWorldQuery = mysql_query("SELECT `world_id` FROM `instance` WHERE `id` = '$serverinstance'");
								$userDataWorldQuery = mysql_fetch_array($resultWorldQuery, MYSQL_ASSOC);
								$world_id = $userDataWorldQuery['id'];
								
								mysql_query("INSERT INTO `world_vehicle` (`id`, `vehicle_id`, `world_id`, `worldspace`, `chance`) VALUES ('$id', '$vehicle_id', '$world_id', '$pos', '0');");
								mysql_query("INSERT INTO `instance_vehicle` (`world_vehicle_id`, `instance_id`, `worldspace`, `inventory`, `parts`, `fuel`, `damage`, `last_updated`, `created`) VALUES ('$id', '$serverinstance', '$pos', '[]', '[]', '1', '0', '$time', '$time');");

								$vehiclecount++;
								$id++;

								?>
								
								<tr>
									<td><?php echo $strings[1] ?></td>
									<td><?php echo $pos ?></td>
									<td><?php echo $vehicle_id ?></td>
								</tr>

							<?php
							}
						}
					}
					?>

					</table>

					<br />
					<br />

					<strong><?php echo $vehiclecount; ?></strong> new vehicles added!
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

	<?php
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