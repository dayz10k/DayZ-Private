<?php
if (isset($_SESSION['user_id']) and (strpos($_SESSION['user_permissions'],"map")!==false))
{

	switch ($show) {
		case 0:
			$pagetitle = "Online player locations";
			break;
		case 1:
			$query = "SELECT profile.name, survivor.* FROM `profile`, `survivor` AS `survivor` WHERE profile.unique_id = survivor.unique_id AND survivor.is_dead = '0'"; 
			$pagetitle = "Alive player locations";		
			break;
		case 2:
			$query = "SELECT profile.name, survivor.* FROM `profile`, `survivor` AS `survivor` WHERE profile.unique_id = survivor.unique_id AND survivor.is_dead = '1'"; 
			$pagetitle = "Dead player locations";	
			break;
		case 3:
			$query = "SELECT profile.name, survivor.* FROM `profile`, `survivor` AS `survivor` WHERE profile.unique_id = survivor.unique_id"; 
			$pagetitle = "All player locations";	
			break;
		case 4:
			$query = "SELECT * FROM `objects` WHERE `damage` < 0.95";
			$pagetitle = "Ingame vehicle locations";	
			break;
		case 5:
			$query = "SELECT * FROM `spawns`";
			$pagetitle = "Vehicle spawn locations";	
			break;
		case 6:
			$pagetitle = "Crashsite locations";	
			break;
		case 7:
			$query = "SELECT profile.name, survivor.* FROM `profile`, `survivor` AS `survivor` WHERE profile.unique_id = survivor.unique_id"; 
			$query2 = "SELECT * FROM `objects` WHERE `damage` < 0.95";
			$pagetitle = "All locations";	
			break;
		default:
			$pagetitle = "Online players";
		};

?>
<div id="page-heading">
<?
	echo "<title>".$pagetitle." - ".$sitename."</title>";
	echo "<h1>".$pagetitle."</h1>";
?>
</div>
<?
	include ('/maps/'.$show.'.php');
}
else
{
	header('Location: index.php');
}
?> 
