<?php
// Vincent Bessouet, DCU School of Computing, 2016
?>

<nav id="mainNav" class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainNavBar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			
			<a id='homeButton' class="navbar-brand hidden-sm hidden-md hidden-lg" href="menu.php" type='button'><i class="ionicons ion-android-home"></i> Home</a>
			
			<ul class="nav navbar-nav">
				<li><a id='homeButton' class="hidden-xs" href="menu.php" type='button'><i class="ionicons ion-android-home"></i> Home</a></li>
			</ul>
		</div>
		<div id="mainNavBar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;" >
			<ul class="nav navbar-nav navbar-right">
				<?php
				//////////
				// TODO //
				//////////
				
				if($_DEBUG || $_SESSION['user'] == null) {
					echo "
					<li><a id='registerButton' href='login.php?tab=register' type='button'><i class='ionicons ion-person-add'></i> Register</a></li>
					<li><a id='activateButton' href='activateAccount.php' type='button'><i class='ionicons ion-unlocked'></i> Activate account</a></li>
					<li><a id='loginButton' href='login.php' type='button'><span class='glyphicon glyphicon-log-in'></span> Login</a></li>
					";
				}
				else {
					if( ! $_SESSION['user']->isAdmin() ){
						echo "
						<li><a id='scoreButton' href='scores.php' type='button'>
							<i class='ionicons ion-trophy'></i> " . $_SESSION['user']->score() . " pt" . ($_SESSION['user']->score() > 1 ? 's' : '') . "
						</a></li>
						";
					}
					echo "
					<li><a id='userButton' href='#' type='button'><i class='ionicons ion-person'></i> " . $_SESSION['user']->username() . "</a></li>
					<li><a id='logoutButton' href='logout.php' type='button'><span class='glyphicon glyphicon-log-out'></span> Logout</a></li>
					";
				}
				?>
			</ul>
		</div>
	</div>
</nav>
