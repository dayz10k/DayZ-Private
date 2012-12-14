<?php
if (isset($_SESSION['user_id']))
{
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html;" />
	<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default" />
	<link rel="stylesheet" href="css/menu.css" />
	<link rel="stylesheet" type="text/css" href="http://cdn.leafletjs.com/leaflet-0.4/leaflet.css" />
	<script language="javascript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
	<script src="http://cdn.leafletjs.com/leaflet-0.4/leaflet.js"></script>
	<script src="js/flexcroll.js" type="text/javascript"></script>
	<script src="js/modalpopup.js" type="text/javascript"></script>
	<script src="js/map.js" type="text/javascript"></script>
</head>
<body>
	<div id="page-top-outer">    
		<div id="page-top">
			<!-- start logo -->
			<div id="logo">
				<a href=""><img src="images/login/logo.png" width="150px" height="72px" alt="" /></a>
			</div>
			<!-- end logo -->

			<!--  start top-search -->
			<div id="top-search">
				<?php include ('/modules/searchbar.php'); ?>
			</div>
			<!--  end top-search -->
			<div class="clear"></div>
		</div>
	</div>
	<div class="clear">&nbsp;</div>
	<!-- start navbar -->
	<?php include ('/modules/navbar.php'); ?>
	<!-- end navbar -->
	<div class="clear"></div>

<?php
}
else
{
	header('Location: index.php');
}
?>