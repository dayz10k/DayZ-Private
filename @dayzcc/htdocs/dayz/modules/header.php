<?php
if (isset($_SESSION['user_id']))
{
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;" />
<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default" />
<link rel="stylesheet" href="css/menu.css" />
<link rel="stylesheet" href="css/watch.css" />
<link rel="stylesheet" href="css/flexcrollstyles.css" />
<script language="javascript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>	
<script src="js/flexcroll.js" type="text/javascript"></script>
<script src="js/modalpopup.js" type="text/javascript"></script>
</head>
<body>
<div id="page-top-outer">    
<div id="page-top">
	<!-- start logo -->
	<div id="logo">
		<a href=""><img src="<?echo $path;?>images/logo.png" width="150px" height="72px" alt="" /></a>
	</div>
	<!-- end logo -->
	
	<!-- start watch -->

	<!-- end watch -->
	
	<!--  start top-search -->
	<div id="top-search">
		<? include ('searchbar.php'); ?>
	</div>
 	<!--  end top-search -->
 	<div class="clear"></div>
</div>
</div>
<div class="clear">&nbsp;</div>
<? include ('navbar.php'); ?>
<div class="clear"></div>
<div id="content-outer">
<div id="content">
<?
}
else
{
	header('Location: index.php');
}
?>