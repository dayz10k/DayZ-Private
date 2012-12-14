<?php
if (isset($_SESSION['user_id']))
{
	?>
	
	<div class="clear">&nbsp;</div>     
	<div id="footer">
		<div id="footer-left">
			DayZ Controlcenter Administration Panel &copy; 2012 <a href="http://www.dayzcc.tk">Crosire</a> and &copy; 2006-2012 <a href="http://www.lead-games.com">Lead Games</a>. All rights reserved.</div>
		<div class="clear">&nbsp;</div>
	</div>
	</body>
	</html>

<?php
}
else
{
	header('Location: index.php');
}
?>