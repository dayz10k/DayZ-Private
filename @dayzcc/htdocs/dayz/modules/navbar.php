<?php
	if (isset($_SESSION['user_id']))
	{ 
		?>
		
		<div class="nav-outer-repeat"> 
			<div class="nav-outer">
				<div id="nav-left">
					<div style="display: table">
						<ul class="nav-top" style="display: table-cell;">
							<li class="root">
								<a href="index.php" class="item">Dashboard</a>
							</li>
							<?php if (strpos($_SESSION['user_permissions'], "control") !== false) { ?>
								<li class="root"><a href="index.php?view=manage" class="item down">Manage</a>
									<ul class="menu">
										<li><a href="index.php?view=manage" class="item">Overview</a></li>
										<li><a href="index.php?view=control" class="item">Server Control</a></li>
										<?php if (strpos($_SESSION['user_permissions'], "whitelist") !== false) { ?>
											<li><a href="index.php?view=whitelist" class="item">Whitelist</a></li>
										<?php } ?>
										<li class="nav-separator"><span></span></li>
										<li><a href="index.php?view=log&type=server" class="item down">Logs</a>
											<ul class="menu">
												<li><a href="index.php?view=log&type=server" class="item">Server</a></li>
												<li><a href="index.php?view=log&type=battleye" class="item">BattlEye</a></li>
											</ul>
										</li>
										<li><a href="index.php?view=battleye" class="item down">Battleye</a>
											<ul class="menu">
												<li><a href="index.php?view=battleye" class="item">Bans</a></li>
												<li><a href="index.php?view=battleye&filter" class="item">Filters</a></li>
											</ul>
										</li>
									</ul>
								</li>
							<?php } if (strpos($_SESSION['user_permissions'], "table") !== false) { ?>
							<li class="root"><a class="item down">Entities & Info</a>
								<ul class="menu">
									<li><a href="index.php?view=table&show=3" class="item down">Players</a>
										<ul class="menu">
											<li><a href="index.php?view=table&show=0" class="item">Online</a></li>
											<li><a href="index.php?view=table&show=1" class="item">Alive</a></li>
											<li><a href="index.php?view=table&show=2" class="item">Dead</a></li>
											<li><a href="index.php?view=table&show=3" class="item">All</a></li>
										</ul>
									</li>
									<li><a href="index.php?view=table&show=4" class="item">Vehicles</a></li>
									<li><a href="index.php?view=table&show=5" class="item">Deployables</a></li>
									<li class="nav-separator"><span></span></li>
									<li><a href="index.php?view=check" class="item">Check Items</a></li>
									<li class="nav-separator"><span></span></li>
									<li><a href="index.php?view=search" class="item">Search</a></li>
								</ul>
							</li>
							<?php } if (strpos($_SESSION['user_permissions'], "map") !== false) { ?>
								<li class="root"><a href="index.php?view=map&show=7" class="item down">Map</a>
									<ul class="menu">
										<li><a href="index.php?view=map&show=3" class="item down">Players</a>
											<ul class="menu">
												<li><a href="index.php?view=map&show=0" class="item">Online</a></li>
												<li><a href="index.php?view=map&show=1" class="item">Alive</a></li>
												<li><a href="index.php?view=map&show=2" class="item">Dead</a></li>
												<li><a href="index.php?view=map&show=3" class="item">All</a></li>
											</ul>
										</li>
										<li><a href="index.php?view=map&show=4" class="item">Vehicles</a></li>
										<li><a href="index.php?view=map&show=5" class="item">Deployables</a></li>
										<li class="nav-separator"><span></span></li>
										<li><a href="index.php?view=map&show=6" class="item">Wrecks</a></li>
										<li class="nav-separator"><span></span></li>
										<li><a href="index.php?view=map&show=7" class="item">All</a></li>
									</ul>
								</li>
							<?php } if (strpos($_SESSION['user_permissions'], "feed") !== false) { ?>
								<li class="root">
									<a href="index.php?view=feed" class="item">Feed</a>
								</li>
							<?php } if (strpos($_SESSION['user_permissions'], "tools") !== false) { ?>
								<li class="root">
									<a href="index.php?view=tools" class="item">Tools</a>
								</li>
							<?php } ?>
						</ul>
					</div>
					<div class="clear"></div>
				</div>
				<div id="nav-right">
					<div class="nav-divider">&nbsp;</div>
					<?php if (strpos($_SESSION['user_permissions'], "user") !== false) { ?>
						<a href="index.php?view=users"><img src="images/forms/nav_myaccount.gif" width="67" height="14" alt="" /></a>
					<?php } ?>
					<a href="index.php?logout"><img src="images/forms/nav_logout.gif" width="64" height="14" alt="" /></a>
					<div class="clear">&nbsp;</div>
				</div>
			</div>
		</div>

	<?
	}
	else
	{ 
		header('Location: index.php');
	}
?>