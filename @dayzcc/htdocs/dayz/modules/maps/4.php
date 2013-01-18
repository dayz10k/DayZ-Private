<?php
	error_reporting (E_ALL ^ E_NOTICE);

	$res = mysql_query("SELECT world_vehicle.vehicle_id, vehicle.class_name, instance_vehicle.* FROM `world_vehicle`, `vehicle`, `instance_vehicle` WHERE vehicle.id = world_vehicle.vehicle_id AND instance_vehicle.world_vehicle_id = world_vehicle.id AND instance_vehicle.instance_id = '".$serverinstance."' AND `damage` < '0.95'") or die(mysql_error());
	$markers = markers_vehicle($res, $serverworld);
?>