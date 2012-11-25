<?
if (isset($_SESSION['user_id']))
{
?>
	<div id="map" style="width:99%;height:1050px;margin:10px auto;border:2px solid #000;"></div>
	
	<script>
	<? if (strpos($serverworld, "chernarus") !== false) { ?>
		InitChernarus();
	<? } elseif (strpos($serverworld, "lingor") !== false) { ?>
		InitLingor();
	<? } elseif (strpos($serverworld, "utes") !== false) { ?>
		InitUtes();
	<? } elseif (strpos($serverworld, "panthera") !== false) { ?>
		InitPanthera();
	<? } elseif (strpos($serverworld, "takistan") !== false) { ?>
		InitTakistan();
	<? } elseif (strpos($serverworld, "fallujah") !== false) { ?>
		InitFallujah();
	<? } elseif (strpos($serverworld, "celle") !== false) { ?>
		InitCelle();
	<? } elseif (strpos($serverworld, "namalsk") !== false) { ?>
		InitNamalsk();
	<? } elseif (strpos($serverworld, "zargabad") !== false) { ?>
		InitZargabad();
	<? }; ?>
	
	var Icon = L.Icon.extend({options: {iconSize: [32, 37]}});
	
	var Car = new Icon({iconUrl: 'images/icons/Car.png'}),
		Bus = new Icon({iconUrl: 'images/icons/Bus.png'}),
		ATV = new Icon({iconUrl: 'images/icons/ATV.png'}),
		Bike = new Icon({iconUrl: 'images/icons/Bike.png'}),
		Wreck = new Icon({iconUrl: 'images/icons/Wreck.png'}),
		Farmvehicle = new Icon({iconUrl: 'images/icons/Farmvehicle.png'}),
		Helicopter = new Icon({iconUrl: 'images/icons/Helicopter.png'}),
		lBoat = new Icon({iconUrl: 'images/icons/lBoat.png'}),
		mBoat = new Icon({iconUrl: 'images/icons/mBoat.png'}),
		sBoat = new Icon({iconUrl: 'images/icons/sBoat.png'}),
		Motorcycle = new Icon({iconUrl: 'images/icons/Motorcycle.png'}),
		PBX = new Icon({iconUrl: 'images/icons/PBX.png'}),
		Truck = new Icon({iconUrl: 'images/icons/Truck.png'}),
		Trap = new Icon({iconUrl: 'images/icons/Trap.png'}),
		Wire = new Icon({iconUrl: 'images/icons/Wire.png'}),
		Tent = new Icon({iconUrl: 'images/icons/Tent.png'}),
		Hedgehog = new Icon({iconUrl: 'images/icons/Hedgehog.png'}),
		Player = new Icon({iconUrl: 'images/icons/player.png'}),
		PlayerDead = new Icon({iconUrl: 'images/icons/player_dead.png'});
	
	<? echo $markers; ?>
	</script>
<?
}
else
{
	header('Location: index.php');
}
?>