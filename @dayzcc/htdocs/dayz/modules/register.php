<?php
if (isset($_SESSION['user_id']) and (strpos($_SESSION['user_permissions'], "user") !== false))
{ 
	function GenerateSalt($n = 3) { 
		$key = '';
		$pattern = '1234567890abcdefghijklmnopqrstuvwxyz.,*_-=+';
		$counter = strlen($pattern)-1;
		for ($i = 0; $i < $n; $i++) { $key .= $pattern{ rand(0, $counter) }; }
		return $key;
	}

	if (empty($_POST))
	{ 
		?>
		
		<div id="page-heading">
			<h1>Registration</h1>
		</div>
		<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
			<tr>
				<th rowspan="3" class="sized"><img src="images/forms/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
				<th class="topleft"></th>
				<td id="tbl-border-top">&nbsp;</td>
				<th class="topright"></th>
				<th rowspan="3" class="sized"><img src="images/forms/side_shadowright.jpg" width="20" height="300" alt="" /></th>
			</tr>
			<tr>
				<td id="tbl-border-left"></td>
				<td>
					<div id="content-table-inner">
						<div id="table-content">
							<h2>Enter login, password and select permissions for new user</h2>
							
							<form id="regform" action="index.php?view=register">
								<table border="0" cellpadding="0" cellspacing="0"  id="id-form">
								<tr>
									<th valign="top">Login:</th>
									<td><input type="text" class="inp-form" name="login" /></td>
									<td></td>
								</tr>
								<tr>
									<th valign="top">Password:</th>
									<td><input type="text" class="inp-form" name="password" /></td>
									<td></td>
								</tr>
								<tr>
									<th valign="top">Permissions:</th>
									<td><input type="text" class="inp-form" name="permission" /></td>
									<td>&nbsp;&nbsp;(control, table, map, user, whitelist, tools, feed)</td>
									<td></td>
								</tr>
								<tr>
									<th>&nbsp;</th>
									<td valign="top">
										<input type="submit" value="" class="form-submit" />
									</td>
									<td></td>
								</tr>
								</table>
							</form>
						</div>
						
						<div id="result"></div>

						<script>
							/* attach a submit handler to the form */
							$("#regform").submit(function(event) { 
								/* stop form from submitting normally */
								event.preventDefault(); 

								/* get some values from elements on the page: */
								var $form = $( this ),
									term = $form.find( 'input[name="login"]' ).val(),
									term2 = $form.find( 'input[name="password"]' ).val(),
									term3 = $form.find( 'input[name="permission"]' ).val(),
									url = $form.attr( 'action' );
									
								var d = document.getElementById('content-table-inner'),
									olddiv = document.getElementById('table-content');
								d.removeChild(olddiv);
								
								var d = document.getElementById('dvPopup'),
									olddiv = document.getElementById('closebutton');
								d.removeChild(olddiv);

								/* Send the data using post and put the results in a div */
								$.post(url, { login: term, password: term2, permission: term3 }, function (data) { var content = $(data).find('#content'); $('#result').empty().append(content); });
							});
						</script>
						
						<div class="clear"></div>
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

	<?php
	}
	else
	{ 
		$login = (isset($_POST['login'])) ? mysql_real_escape_string($_POST['login']) : '';
		$password = (isset($_POST['password'])) ? mysql_real_escape_string($_POST['password']) : '';
		$permission = (isset($_POST['permission'])) ? mysql_real_escape_string($_POST['permission']) : '';

		$error = false;
		$errort = '';
		
		if (strlen($login) < 2)
		{ 
			$error = true;
			$errort .= 'Login must be at least 2 characters.<br />';
		}
		if (strlen($password) < 6)
		{ 
			$error = true;
			$errort .= 'Password must be at least 6 characters.<br />';
		}
		
		$rescheck = mysql_query("SELECT `id` FROM `users` WHERE `login` = '{$login}' LIMIT 1") or die(mysql_error());
		if (mysql_num_rows($rescheck) == 1) { 
			$error = true;
			$errort .= 'Login already used.<br />';
		}

		if (!$error)
		{ 
			$salt = GenerateSalt();
			$hashed_password = md5(md5($password).$salt);
			
			mysql_query("INSERT INTO `users` SET `login` = '{$login}', `password` = '{$hashed_password}', `salt` = '{$salt}', `permissions` = '{$permission }'") or die(mysql_error());
			mysql_query("INSERT INTO `log_tool` (`action`, `user`, `timestamp`) VALUES ('REGISTER USER: {$login}', '{$_SESSION['login']}', NOW())");
			
			?>

			<div id="msg">
				<div id="message-green">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="green-left">New user is succesfully registered!</td>
					<td class="green-right"><a href="#" onclick="window.location.href = 'index.php?view=admin';" class="close-green"><img src="images/forms/icon_close_green.gif" alt="" /></a></td>
				</tr>
				</table>
				</div>
			</div>

			<?php
		}
		else
		{ 
			?>
			
			<div id="msg">
				<div id="message-red">
				<table border="0" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="red-left">Error in registration process!</td>
					<td class="red-right"><a href="#" onclick="window.location.href = 'index.php?view=admin';" class="close-red"><img src="images/forms/icon_close_red.gif" alt="" /></a></td>
				</tr>
				</table>
				</div>
				<?php print $errort; ?>
			</div>
			
			<?php
		}
	}
}
else
{ 
	header('Location: index.php');
}
?>