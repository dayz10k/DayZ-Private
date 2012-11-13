<?php
if (isset($_SESSION['user_id']))
{
?>
</div>
</div>
<div class="clear">&nbsp;</div>     
<div id="footer">
	<div id="footer-left">
	DayZ Administration panel &copy; Copyright 2006-2012 <a href="http://lead-games.com">Lead Games</a> and <a href="http://dayzcc.com">Crosire</a>. All rights reserved.</div>
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