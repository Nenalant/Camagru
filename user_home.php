<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home - Camagru</title>
	<link rel="stylesheet" href="index.css" type="text/css">
</head>
<body>
	<nav>
	  <div class="navbar">
		<div class="pcontent">
		  <div class="hlogo">
				<img src="./img/website_img/mount_logo.png" id="logo"/>
		  </div>
		  <div>
				<a href="index.php"><h2>Camagru</h2></a>
		  </div>
		  <div class="hicones">
			<div class="hicones2">
			  <div class="hiconetoicon">
				<div>
					<a href="account/user_home.php" id="username"><img src="./img/website_img/cute_user.png" id="user"/>
				</div>
				<div>
					<?php echo $_SESSION['login']; ?></a>
				</div>
			  </div>
			  <div class="hiconetoicon">
				<a href="take_pic.php">
				  <img src="./img/website_img/cam.png" id="cam"/>
				</a>
			  </div>
			  <div class="hiconetoicon">
				  <a href="connexion.php?deco=deco"><img src="./img/website_img/power_icon.png" id="power"/></a>
			  </div>
		  	</div>
		  </div>
		</div>
	  </div>
	</nav>
	<main>
		<div class="Form">
		  <div class="edit_form">
			Login :
			<?php echo $_SESSION['login']; ?><a class="modif">Modifier</a></br>
			Email :
			<?php echo $_SESSION['email']; ?><a class="modif">Modifier</a>
			<a href="new_passw.php" class="mdp">Modifier mon mot de passe</a>
		</div>
	  </div>
	</main>
<div class="footer"><p id="footer_text">alanteri@42  - 2018</p></div>
</body>
</html>
