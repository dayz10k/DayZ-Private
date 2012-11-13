<?

$debug = '';

if (isset($_SESSION['user_id']))
{
	include ('/info/'.$show.'.php');
}
else
{
	header('Location: index.php');
}

?>