<?php

if (isset($_SESSION['user_id']) and (strpos($_SESSION['user_permissions'], "user") !== false))
{ 
	function GenerateSalt($n = 3) { 
		$key = '';
		$pattern = '1234567890abcdefghijklmnopqrstuvwxyz.,*_-=+';
		$counter = strlen($pattern)-1;
		for ($i = 0; $i < $n; $i++) { $key .= $pattern{rand(0, $counter)}; }
		return $key;
	}

	if (empty($_POST))
	{
		?>
		
		<div id="page-heading">
			<h1>Registration</h1>
		</div>

		<table id="content-table" border="0" width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<th rowspan="3"><img src="images/forms/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
				<th class="corner-topleft"></th>
				<td class="border-top">&nbsp;</td>
				<th class="corner-topright"></th>
				<th rowspan="3"><img src="images/forms/side_shadowright.jpg" width="20" height="300" alt="" /></th>
			</tr>
			<tr>
				<td class="border-left"></td>
				<td>
					<div id="content-table-inner">
						<div id="table-content">
							<form action="index.php?view=register" method="post">
								<h2>Enter login name and password for the new user:</h2>
								<input type="text" name="login" value="Username" onblur="if (this.value == '') { this.value = 'Username'; }" onfocus="if (this.value == 'Username') { this.value = ''; }" style="display: inline; padding-top: 6px; padding-bottom: 6px; padding-left: 6px; width: 200px;" />
								<input type="text" name="password" value="Password" onblur="if (this.value == '') { this.value = 'Password'; }" onfocus="if (this.value == 'Password') { this.value = ''; }" style="display: inline; padding-top: 6px; padding-bottom: 6px; padding-left: 6px; width: 200px;" />
								<br /><br />
								<h2>Select the pages the user should be allowed to view:</h2>
								<div style="border: 2px solid #ccc; width: 403px; height: 100px; padding-top: 6px; padding-left: 6px; overflow-y: scroll;">
									<input type="hidden" name="permission" />
									<input type="checkbox" name="manage" checked />&nbsp;&nbsp;&nbsp;"Manage Overview"<br />
									<input type="checkbox" name="control" checked />&nbsp;&nbsp;&nbsp;"Server Control", "Logs", "BattlEye", "Bans"<br />
									<input type="checkbox" name="table" checked />&nbsp;&nbsp;&nbsp;"Playerlist", "Vehiclelist", "Deployablelist", "Check items", "Search"<br />
									<input type="checkbox" name="map" checked />&nbsp;&nbsp;&nbsp;"Playermap", "Vehiclemap", "Deployablemap", "Wreckmap"<br />
									<input type="checkbox" name="tools" checked />&nbsp;&nbsp;&nbsp;"Vehicle import tools"<br />
									<input type="checkbox" name="feed" checked />&nbsp;&nbsp;&nbsp;"Killfeed"<br />
									<input type="checkbox" name="user" checked />&nbsp;&nbsp;&nbsp;"Accounts"<br />
								</div>
								<br />
								<input type="submit" class="submit" />
							</form>
						</div>
						<div class="clear"></div>
					</div>
				</td>
				<td class="border-right"></td>
			</tr>
			<tr>
				<th class="corner-bottomleft"></th>
				<td class="border-bottom">&nbsp;</td>
				<th class="corner-bottomright"></th>
			</tr>
		</table>

	<?php
	}
	else
	{ 
		$login = (isset($_POST['login'])) ? mysql_real_escape_string($_POST['login']) : '';
		$password = (isset($_POST['password'])) ? mysql_real_escape_string($_POST['password']) : '';
		$permissions = '';
		$error = false;
		$errort = '';
		
		if (strlen($login) < 2) { 
			$error = true;
			$errort .= 'Login must be at least 2 characters. ';
		}
		if (strlen($password) < 6) { 
			$error = true;
			$errort .= 'Password must be at least 6 characters. ';
		}
		if (mysql_num_rows(mysql_query("SELECT `id` FROM `users` WHERE `login` = '{$login}' LIMIT 1")) == 1) { 
			$error = true;
			$errort .= 'Login already used. ';
		}

		if (isset($_POST['permission'])) {
			foreach (array('manage', 'control', 'table', 'map', 'tools', 'feed', 'user') as $permission) {
				if (isset($_POST[$permission])) {
					if ($_POST[$permission] == "on") { $permissions .= $permission.", "; }
				}
			}
			$permissions = mysql_real_escape_string(substr($permissions, 0, -2));
		}

		if (!$error)
		{ 
			$salt = GenerateSalt();
			$hash = md5(md5($password).$salt);
			
			mysql_query("INSERT INTO `users` SET `login` = '{$login}', `password` = '{$hash}', `salt` = '{$salt}', `permissions` = '{$permissions}'") or die(mysql_error());
			mysql_query("INSERT INTO `log_tool` (`action`, `user`, `timestamp`) VALUES ('REGISTERED USER: {$login}', '{$_SESSION['login']}', NOW())");
			
			$delresult = '<div id="message-green">
				<table border="0" width="100%" cellpadding="0" cellspacing="0"><tr>
				<td class="green-left">User "'.$login.'" succesfully registered!</td>
				<td class="green-right"><a class="close-green"><img src="images/forms/icon_close_green.gif" alt="" /></a></td>
				</tr></table></div>';
			include('modules/users.php');
		}
		else
		{
			$delresult = '<div id="message-red">
				<table border="0" width="100%" cellpadding="0" cellspacing="0"><tr>
				<td class="red-left">Error: '.$errort.'</td>
				<td class="red-right"><a class="close-red"><img src="images/forms/icon_close_red.gif" alt="" /></a></td>
				</tr></table></div>';
			include('modules/users.php');
		}
	}
}
else
{ 
	header('Location: index.php');
}

?>