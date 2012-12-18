<?php
if (isset($_SESSION['user_id']) and (strpos($_SESSION['user_permissions'], "map") !== false))
{
	switch ($show) {
		case 0:
			$pagetitle = "Online player locations";
			break;
		case 1:
			$query = "SELECT profile.name, survivor.* FROM `profile`, `survivor` WHERE profile.unique_id = survivor.unique_id AND survivor.is_dead = '0';"; 
			$pagetitle = "Alive player locations";		
			break;
		case 2:
			$query = "SELECT profile.name, survivor.* FROM `profile`, `survivor` WHERE profile.unique_id = survivor.unique_id AND survivor.is_dead = '1';"; 
			$pagetitle = "Dead player locations";	
			break;
		case 3:
			$query = "SELECT profile.name, survivor.* FROM `profile`, `survivor` WHERE profile.unique_id = survivor.unique_id;"; 
			$pagetitle = "All player locations";	
			break;
		case 4:
			$query = "SELECT world_vehicle.vehicle_id, vehicle.class_name, instance_vehicle.* FROM `world_vehicle`, `vehicle`, `instance_vehicle` WHERE vehicle.id = world_vehicle.vehicle_id AND instance_vehicle.world_vehicle_id = world_vehicle.id AND instance_vehicle.instance_id = '".$serverinstance."' AND `damage` < '0.95';";
			$pagetitle = "Ingame vehicle locations";
			break;
		case 5:
			$query = "SELECT deployable.class_name, instance_deployable.* FROM `deployable`, `instance_deployable` WHERE deployable.id = instance_deployable.deployable_id AND instance_deployable.instance_id = '".$serverinstance."';";
			$pagetitle = "Deployable locations";
			break;
		case 6:
			$pagetitle = "Wreck locations";	
			break;
		case 7:
			$pagetitle = "All locations";	
			break;
		default:
			$pagetitle = "Online player locations";
	};
	?>
	
	<div id="page-heading">
		<title><?php echo $pagetitle." - ".$sitename ?></title>
		<h1><?php echo $pagetitle; ?></h1>
	</div>

<?php
	include ('/modules/maps/'.$show.'.php');
}
else
{
	header('Location: index.php');
}
?>