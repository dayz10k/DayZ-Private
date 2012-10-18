<?php
if (isset($_SESSION['user_id']) and (strpos($_SESSION['user_permissions'],"list")!==false))
{
	$pagetitle = "Server Log";
	$logtext = "";
	
	$handle = fopen($path_logserver, "r");
	while (!feof($handle)) {$logtext .= fgets($handle);}
	fclose ($handle);

?>
<div id="page-heading">
<?
	echo "<title>".$pagetitle." - ".$sitename."</title>";
	echo "<h1>".$pagetitle."</h1>";
?>
</div>
<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
	<tr>
		<th rowspan="3" class="sized"><img src="<?echo $path;?>images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
		<th class="topleft"></th>
		<td id="tbl-border-top">&nbsp;</td>
		<th class="topright"></th>
		<th rowspan="3" class="sized"><img src="<?echo $path;?>images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
	</tr>
	<tr>
		<td id="tbl-border-left"></td>
		<td>
		<div id="content-table-inner">	
		<!--  start content-table-inner ...................................................................... START -->
		<div id="content-text-inner">		
			<textarea id="logarea" cols="130" rows="50" align= "left"><? echo $logtext; ?></textarea>
			<script type="text/javascript" >
				var textarea = document.getElementById('logarea');
				textarea.scrollTop = textarea.scrollHeight;
			</script>
			<form action="index.php?view=log" method="post">
				<input type="submit" class="submit-login" />
			</form>
		</div>
		<!--  end content-table-inner ............................................END  -->
		</div>
		</td>
		<td id="tbl-border-right"></td>
	</tr>
	<tr>
		<th class="sized bottomleft"></th>
		<td id="tbl-border-bottom">&nbsp;</td>
		<th class="sized bottomright"></th>
	</tr>
	</table>
	<div class="clear">&nbsp;</div>
<?
}
else
{
	header('Location: index.php');
}
?> 
