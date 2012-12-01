<?php
if (isset($_SESSION['user_id']))
{	
	if (isset($_GET["kick"])) {
		$cmd = "kick ".$_GET["kick"];
		$answer = rcon($serverip, $serverport, $rconpassword, $cmd);
		
		?><script type="text/javascript">window.location = 'index.php?view=table&show=0';</script><?php
	}
	
	if (isset($_GET["ban"])) {
		$cmd = "ban ".$_GET["ban"];
		$answer = rcon($serverip, $serverport, $rconpassword, $cmd);
		
		?><script type="text/javascript">window.location = 'index.php?view=table&show=0';</script><?php
	}
	
	if (isset($_POST["say"])){
		$id = "-1"; if (isset($_GET["id"])) {$id = $_GET["id"];}
		$cmd = "Say ".$id." ".$_POST["say"];
		$answer = rcon($serverip, $serverport, $rconpassword, $cmd);
		
		?><script type="text/javascript">window.location = 'index.php';</script><?php
	}

	?><script type="text/javascript">window.location = 'index.php';</script><?php
}
else
{
	header('Location: index.php');
}
?>