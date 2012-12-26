<?php
if (isset($_SESSION['user_id']))
{ 
	$debug = '';
	include('modules/info/'.$show.'.php');
}
else
{ 
	header('Location: index.php');
}
?>