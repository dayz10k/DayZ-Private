<?php
if (isset($_SESSION['user_id']))
{ 
	?>
	<head>
		<script src="js/map/chernarus.js"></script>
		<script src="js/map/namalsk.js"></script>
		<script src="js/map/lingor.js"></script>
		<script src="js/map/panthera.js"></script>
		<script src="js/map/takistan.js"></script>
		<script src="js/map/fallujah.js"></script>
		<script src="js/map/taviana.js"></script>
	</head>
	
	<div id="map" style="width:99%;height:1050px;margin:10px auto;border:2px solid #000;"></div>
	
	<script>
	<?php if (strpos($serverworld, "chernarus") !== false) { ?>
		InitChernarus();
	<?php } elseif (strpos($serverworld, "lingor") !== false) { ?>
		InitLingor();
	<?php } elseif (strpos($serverworld, "utes") !== false) { ?>
		InitUtes();
	<?php } elseif (strpos($serverworld, "panthera") !== false) { ?>
		InitPanthera();
	<?php } elseif (strpos($serverworld, "takistan") !== false) { ?>
		InitTakistan();
	<?php } elseif (strpos($serverworld, "fallujah") !== false) { ?>
		InitFallujah();
	<?php } elseif (strpos($serverworld, "celle") !== false) { ?>
		InitCelle();
	<?php } elseif (strpos($serverworld, "namalsk") !== false) { ?>
		InitNamalsk();
	<?php } elseif (strpos($serverworld, "zargabad") !== false) { ?>
		InitZargabad();
	<?php } elseif (strpos($serverworld, "tavi") !== false) { ?>
		InitTaviana();
	<?php }; ?>
	
	var Icon = L.Icon.extend({ options: { iconSize: [32, 37], iconAnchor: [16, 35] } });
	
	var Car = new Icon({ iconUrl: 'images/icons/Car.png' }),
		Bus = new Icon({ iconUrl: 'images/icons/Bus.png' }),
		ATV = new Icon({ iconUrl: 'images/icons/ATV.png' }),
		Bike = new Icon({ iconUrl: 'images/icons/Bike.png' }),
		Wreck = new Icon({ iconUrl: 'images/icons/Wreck.png' }),
		Care = new Icon({ iconUrl: 'images/icons/Care.png' }),
		Farmvehicle = new Icon({ iconUrl: 'images/icons/Farmvehicle.png' }),
		Helicopter = new Icon({ iconUrl: 'images/icons/Helicopter.png' }),
		lBoat = new Icon({ iconUrl: 'images/icons/lBoat.png' }),
		mBoat = new Icon({ iconUrl: 'images/icons/mBoat.png' }),
		sBoat = new Icon({ iconUrl: 'images/icons/sBoat.png' }),
		Motorcycle = new Icon({ iconUrl: 'images/icons/Motorcycle.png' }),
		PBX = new Icon({ iconUrl: 'images/icons/PBX.png' }),
		Truck = new Icon({ iconUrl: 'images/icons/Truck.png' }),
		Plane = new Icon({ iconUrl: 'images/icons/Plane.png' }),
		Support = new Icon({ iconUrl: 'images/icons/Truck.png' }),
		Trap = new Icon({ iconUrl: 'images/icons/Trap.png' }),
		Wire = new Icon({ iconUrl: 'images/icons/Wire.png' }),
		Tent = new Icon({ iconUrl: 'images/icons/Tent.png' }),
		Hedgehog = new Icon({ iconUrl: 'images/icons/Hedgehog.png' }),
		Sandbag = new Icon({ iconUrl: 'images/icons/Sandbag.png' }),
		Object = new Icon({ iconUrl: 'images/icons/Object.png' }),
		Player = new Icon({ iconUrl: 'images/icons/player.png' }),
		PlayerDead = new Icon({ iconUrl: 'images/icons/player_dead.png' });
	
	<?php echo $markers; ?>
	</script>

<?php
}
else
{ 
	header('Location: index.php');
}
?>