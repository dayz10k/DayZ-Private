<?php
if (isset($_SESSION['user_id']) and (strpos($_SESSION['user_permissions'], "tools") !== false))
{
	$pagetitle = "Database Tools";

	// Thanks to TorZar for parts of his code!
	
	if (isset($_GET['vehicle'])) { ?>

		<div id="dvPopup_vehicle" style="display:none; width:900px; height: 450px; border:4px solid #000000; background-color:#FFFFFF;">
			<a id="closebutton" style="float:right;" href="#" onclick="HideModalPopup('dvPopup_vehicle'); return false;"><img src="images/table/action_delete.gif" alt="" /></a><br />
			<?php include_once ('/tools/parseVehicles.php'); ?>
		</div>
		<script>ShowModalPopup('dvPopup_vehicle');</script>
		
	<?php }
	if (isset($_GET['building'])) { ?>

		<div id="dvPopup_building" style="display:none; width:900px; height: 450px; border:4px solid #000000; background-color:#FFFFFF;">
			<a id="closebutton" style="float:right;" href="#" onclick="HideModalPopup('dvPopup_building'); return false;"><img src="images/table/action_delete.gif" alt="" /></a><br />
			<?php include_once ('/tools/parseBuildings.php'); ?>
		</div>
		<script>ShowModalPopup('dvPopup_building');</script>
		
	<?php } ?>

	<div id="page-heading">
		<title><?php echo $pagetitle." - ".$sitename; ?></title>
		<h1><?php echo $pagetitle; ?></h1>
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
					<h3>This set of tools parses saved mission files created in the 3D editor. You can easily import vehicles and buildings into your database this way. Read the instructions before you start!</h3>

					<br />

					<h2>1. CREATE VEHICLES:</h2>
					<p>Adds all vehicles to 'instance_vehicle' and 'vehicle' tables to be spawned in on next restart.
					<font color="red"> Note: Create a fresh mission with only vehicles!</font></p>
					<br />
					<strong><a href="index.php?view=tools&vehicle">Import</a></strong>

					<br />
					<br />

					<h2>2. CREATE BUILDINGS:</h2>
					<p>Adds all buildings to 'instance_building' and 'building' tables to be spawned in on next restart.
					<font color="red"> Note: Create a fresh mission with only buildings!</font></p>
					<br />
					<strong><a href="index.php?view=tools&building">Import</a></strong>

					<br />
					<br />
					<br />

					<h3>INSTRUCTIONS:</h3>

					<p>Missions can be edited/created from launching DayZ with or without rMod:</p><br />
					<p>1. At the main menu press ALT + E. Select your world [World]</p><br />
					<p>2. Once you are in the 3D editor do the following:</p>
					<ul>
						<li>Place "Center (F10)" anywhere on map [Just hit OK].</li>
						<li>Place "Group (F2)" anywhere on map [Just hit OK].</li>
						<li>Place "Unit (F1)" anywhere on map [Just hit OK].</li>
						<li>Your mission can be saved now!</li>
					</ul>
					<br />
					<p>3. Find anywhere you like on the map and RIGHT CLICK -> "default camera" (takes you to 3d).</p><br />
					<p>4. Upper-Right Menu select "Vehicle (F5), double click the ground, select the vehicle/building to place, hit ok.</p><br />
					<p>5. Left click and hold yellow circle for object and drag to place. Hold SHIFT while holding left mouse button to rotate. Hold ALT while holding left mouse to raise or lower object.</p><br />
					<p>6. Hover over the object and hit DELETE to remove.</p><br />
					<p>7. Save your progress:</p>
					<ul>
						<li>Save your vehicles as "User mission" under name [Your Mission Name]</li>
						<li>Save your buildings as "User mission" under name [Your Mission Name]</li>
					</ul>
					<br />
					<p>8. Copy files to working directory:</p><br />
					<p><strong><font color="green">FOR VEHICLES:</font></strong></p>
					<p>Copy file from: "%userprofile%\Documents\ArmA 2 Other Profiles\[Profile Name]\missions\[Your Mission Name].[World]\mission.sqf"</p>
					<p>Paste it to: "~\@dayzcc\htdocs\dayz\vehicles.sqf"</p>
					<br />
					<p><strong><font color="green">FOR BUILDINGS:</font></strong></p>
					<p>Copy file from: "%userprofile%\Documents\ArmA 2 Other Profiles\[Profile Name]\missions\[Your Mission Name].[World]\mission.sqf"</p>
					<p>Paste it to: "~\@dayzcc\htdocs\dayz\buildings.sqf"</p>
					<br />
					<p>9. Press the "Import" buttons above to add the vehicles.</p>
					<br />
					<br />

					<strong>These tools were written by TorZar and Crosire.</strong>
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