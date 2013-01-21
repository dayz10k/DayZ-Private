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
							<h2>Enter login, password and permissions for the new user</h2>
							
							<form action="index.php?view=register" method="post">
								<table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
									<tr>
										<td style="width: 30%"><strong>Login:</strong></th>
										<td style="width: 70%"><input type="text" name="login" style="height: 22px; padding: 6px 6px 0 6px; width: 80%;" /></td>
									</tr>
									<tr>
										<td style="width: 30%"><strong>Password:</strong></th>
										<td style="width: 70%"><input type="text" name="password" style="height: 22px; padding: 6px 6px 0 6px; width: 80%;" /></td>
									</tr>
									<tr>
										<td style="width: 30%"><strong>Permissions:</strong></th>
										<td style="width: 70%"><input type="text" name="permission" style="height: 22px; padding: 6px 6px 0 6px; width: 80%;" value="control, table, map, user, whitelist, tools, feed" /></td>
									</tr>
									<tr><td>&nbsp;</td></tr>
									<tr>
										<td>&nbsp;</th>
										<td>
											<input type="submit" value="" class="submit" />
										</td>
									</tr>
								</table>
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
		$permission = (isset($_POST['permission'])) ? mysql_real_escape_string($_POST['permission']) : '';
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

		if (!$error)
		{ 
			$salt = GenerateSalt();
			$hash = md5(md5($password).$salt);
			
			mysql_query("INSERT INTO `users` SET `login` = '{$login}', `password` = '{$hash}', `salt` = '{$salt}', `permissions` = '{$permission}'") or die(mysql_error());
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