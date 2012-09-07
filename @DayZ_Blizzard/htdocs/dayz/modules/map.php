<?php
if (isset($_SESSION['user_id']) and (strpos($_SESSION['user_permissions'],"map")!==false))
{

	switch ($show) {
		case 0:
			$pagetitle = "Online players";
			break;
		case 1:
			$query = "SELECT * FROM survivor WHERE is_dead = 0"; 
			$pagetitle = "Alive players";		
			break;
		case 2:
			$query = "SELECT * FROM survivor WHERE is_dead = 1"; 
			$pagetitle = "Dead players";	
			break;
		case 3:
			$query = "SELECT * FROM survivor"; 
			$pagetitle = "All players";	
			break;
		case 4:
			$query = "SELECT * FROM objects";
			$pagetitle = "Ingame vehicles";	
			break;
		case 5:
			$query = "SELECT * FROM spawns";
			$pagetitle = "Vehicle spawn locations";	
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
