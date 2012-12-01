<?php
if (isset($_SESSION['user_id']))
{
	$debug = '';
	include ('/info/'.$show.'.php');
}
else
{
	header('Location: index.php');
}
?>