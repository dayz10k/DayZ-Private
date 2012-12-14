<?php
if (isset($_SESSION['user_id']))
{
	?>
	
	<div class="nav-outer-repeat"> 
		<div class="nav-outer"> 
				<!-- start nav-right -->
				<div id="nav-right">
					<div class="nav-divider">&nbsp;</div>
					<?php if (strpos($_SESSION['user_permissions'], "user") !== false) { ?>
						<a href="index.php?view=admin" id="logout"><img src="images/shared/nav_myaccount.gif" width="67" height="14" alt="" /></a>
					<?php } ?>
					<a href="index.php?logout" id="logout"><img src="images/shared/nav_logout.gif" width="64" height="14" alt="" /></a>
					<div class="clear">&nbsp;</div>
				</div>
				<!-- end nav-right -->

				<!--  start nav -->
				<div class="mc-nav">
					<div class="table">
						<ul class="select menutop level1">
							<li class="li-dashboard root active"><a href="index.php" style="color:#FFF;" class="dashboard item">Dashboard</a></li>
							<?php if (strpos($_SESSION['user_permissions'], "control") !== false) { ?>
								<li class="li-users parent root"><a href="index.php?view=control" style="color:#FFF;" class="class:massmail item">Control</a></li>
							<?php } ?>
							<li class="li-users parent root"><span class=" daddy item"><span>Entities & Info</span></span>
								<ul class="level2 parent-users">
									<?php if (strpos($_SESSION['user_permissions'], "table") !== false) { ?>
										<li class="li-user-manager parent"><a href="#nogo" class="class:user daddy item">Players</a>
											<ul class="level3 parent-user-manager">
												<li class="li-add-new-user"><a href="index.php?view=table&show=0" class="class:newarticle item">Online</a></li>
												<li class="li-add-new-user"><a href="index.php?view=table&show=1" class="class:newarticle item">Alive</a></li>
												<li class="li-add-new-user"><a href="index.php?view=table&show=2" class="class:newarticle item">Dead</a></li>
												<li class="li-add-new-user"><a href="index.php?view=table&show=3" class="class:newarticle item">All</a></li>
											</ul>
										</li>
										<li class="li-mass-mail-users"><a href="index.php?view=table&show=4" class="class:massmail item">Vehicles</a></li>
										<li class="li-mass-mail-users"><a href="index.php?view=table&show=5" class="class:massmail item">Deployables</a></li>
										<li class="li- separator"><span></span></li>
										<li class="li-mass-mail-users"><a href="index.php?view=check" class="class:massmail item">Check Items</a></li>
									<?php } if (strpos($_SESSION['user_permissions'], "whitelist") !== false) { ?>
										<li class="li-mass-mail-users"><a href="index.php?view=whitelist" class="class:massmail item">Whitelist</a></li>
									<?php } if (strpos($_SESSION['user_permissions'], "table") !== false) { ?>
										<li class="li- separator"><span></span></li>
										<li class="li-mass-mail-users"><a href="index.php?view=search" class="class:massmail item">Search</a></li>
									<?php } ?>
								</ul>
							</li>
							<?php if (strpos($_SESSION['user_permissions'], "map") !== false) { ?>
								<li class="li-users parent root"><span class=" daddy item"><span>Map</span></span>
									<ul class="level2 parent-users">
										<li class="li-user-manager parent"><a href="#nogo" class="class:user daddy item">Players</a>
											<ul class="level3 parent-user-manager">
												<li class="li-add-new-user"><a href="index.php?view=map&show=0" class="class:newarticle item">Online</a></li>
												<li class="li-add-new-user"><a href="index.php?view=map&show=1" class="class:newarticle item">Alive</a></li>
												<li class="li-add-new-user"><a href="index.php?view=map&show=2" class="class:newarticle item">Dead</a></li>
												<li class="li-add-new-user"><a href="index.php?view=map&show=3" class="class:newarticle item">All</a></li>
											</ul>
										</li>
										<li class="li-groups parent"><a href="#nogo" class="class:groups daddy item">Vehicles</a>
											<ul class="level3 parent-groups">
												<li class="li-add-new-group"><a href="index.php?view=map&show=4" class="class:newarticle item">Ingame</a></li>
												<li class="li-add-new-group"><a href="index.php?view=map&show=6" class="class:newarticle item">Wrecks</a></li>
											</ul>
										</li>
										<li class="li-mass-mail-users"><a href="index.php?view=map&show=5" class="class:massmail item">Deployables</a></li>
										<li class="li- separator"><span></span></li>
										<li class="li-mass-mail-users"><a href="index.php?view=map&show=7" class="class:massmail item">All</a></li>
									</ul>
								</li>
							<?php } if (strpos($_SESSION['user_permissions'], "tools") !== false) { ?>
								<li class="li-users parent root"><a href="index.php?view=tools" style="color:#FFF;" class="class:massmail item">Tools</a></li>
							<?php } ?>
						</ul>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
				<!-- stop nav -->
		</div>
		<div class="clear"></div>
	</div>

<?
}
else
{
	header('Location: index.php');
}
?>