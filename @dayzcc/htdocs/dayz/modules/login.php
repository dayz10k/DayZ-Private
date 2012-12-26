<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php
if (isset($_SESSION['user_id']))
{ 
	header('Location: index.php');
	exit;
}

if (!empty($_POST))
{ 
	$login = (isset($_POST['login'])) ? mysql_real_escape_string($_POST['login']) : '';
	$sql = mysql_query("SELECT `salt` FROM `users` WHERE `login` = '{$login}' LIMIT 1") or die(mysql_error());

	if (mysql_num_rows($sql) == 1)
	{ 
		$row = mysql_fetch_assoc($sql);
		$salt = $row['salt'];
		$password = md5(md5($_POST['password']).$salt);
		$sql = mysql_query("SELECT `id` FROM `users` WHERE `login` = '{$login}' AND `password` = '{$password}' LIMIT 1") or die(mysql_error());

		if (mysql_num_rows($sql) == 1)
		{ 
			$row = mysql_fetch_assoc($sql);
			$_SESSION['user_id'] = $row['id'];
			$_SESSION['login'] = $login;
			$time = 86400;
			
			$sql = mysql_query("SELECT `permissions` FROM `users` WHERE `login` = '{$login}' LIMIT 1") or die(mysql_error());
			$row = mysql_fetch_assoc($sql);
			$_SESSION['user_permissions'] = $row['permissions'];
			
			if (isset($_POST['remember']))
			{ 
				setcookie('login', $login, time() + $time, "/");
				setcookie('password', $password, time() + $time, "/");
			}

			mysql_query("UPDATE `users` SET `lastlogin` = NOW() WHERE `login` = '{$login}' LIMIT 1");
			mysql_query("INSERT INTO `log_tool` (`action`, `user`, `timestamp`) VALUES ('LOGIN', '{$login}', NOW())");
			
			header('Location: index.php');
			exit;
		}
		else
		{ 
			header('Location: index.php');
		}
	}
	else
	{ 
		header('Location: index.php');
	}
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Login - <?php echo $sitename; ?></title>
	<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default" />
	<script src="js/pngFix.js" type="text/javascript"></script>
	<script type="text/javascript"> $(document).ready(function(){$(document).pngFix( ); }); </script>
</head>
<body id="login-bg"> 
	<div id="login-holder">
		<div id="logo-login">
			<a href="/"><img src="images/forms/logo.png" width="451px" height="218px" alt="" /></a>
		</div>
		<div class="clear"></div>
		<form action="index.php" method="post">
			<div id="loginbox">	
				<div id="login-inner">
					<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<th>Username</th>
						<td><input type="text" name="login" class="login-inp" /></td>
					</tr>
					<tr>
						<th>Password</th>
						<td><input type="password" name="password" value="" onfocus="this.value=''" class="login-inp" /></td>
					</tr>
					<tr>
						<th></th>
						<td valign="top"><input type="checkbox" name="remember" class="checkbox-size" id="login-check" /><label for="login-check">Remember me</label></td>
					</tr>
					<tr>
						<th></th>
						<td><input type="submit" class="submit-login" /></td>
					</tr>
					</table>
				</div>
				<div class="clear"></div>
			</div>
		</form>
	</div>
</body>
</html>