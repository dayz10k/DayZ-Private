<?php
if (isset($_SESSION['user_id']))
{
	?>

	<form action="index.php?view=search" method="post">
		<table border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td>
					<input name="search" type="text" value="Search" onblur="if (this.value=='') { this.value='Search'; }" onfocus="if (this.value=='Search') { this.value=''; }" class="top-search-inp" />
				</td>
				<td>
					<select name="type" class="styledselect">
						<option value="player">Player</option>
						<option value="item">Player Inventory</option>
						<option value="vehicle">Vehicle</option>
						<option value="container">Vehicle Inventory</option>
					</select> 
				</td>
				<td>
					<input type="submit" class="submit-login" />
				</td>
			</tr>
		</table>
	</form>

<?php
}
else
{
	header('Location: index.php');
}
?>