<?php
session_start();
if ($_SESSION['login'] == null)
	header("location: login.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home - Camagru</title>
	<link rel="stylesheet" href="index.css" type="text/css">
	<script src="email_subscriptions.js"></script>
</head>
<body onload="email_sub_like(); email_sub_com()">
	<nav>
	  <div class="navbar">
		<div class="pcontent">
		  <div class="hlogo">
				<img src="img/website_img/mount_logo.png" id="logo"/>
		  </div>
		  <div>
				<a href="index.php"><h2>Camagru</h2></a>
		  </div>
		  <div class="hicones">
			<div class="hicones2">
			  <div class="hiconetoicon">
				<div>
					<?php if (isset($_SESSION['login'])) { ?>
					<a id="username">
					<?php } ?>
					<img src="img/website_img/cute_user.png" id="user"/>
				</div>
				<div>
					<?php if (isset($_SESSION['login'])) echo $_SESSION['login']; else echo ""; ?></a>
				</div>
			  </div>
			  <div class="hiconetoicon">
			  	<?php if (isset($_SESSION['login'])) { ?>
				<a href="take_pic.php">
					<?php } ?>
				  <img src="img/website_img/cam.png" id="cam"/>
				</a>
			  </div>
			  <div class="hiconetoicon">
				  <a href="connexion.php?deco=deco"><img src="img/website_img/power_icon.png" id="power"/></a>
			  </div>
		  	</div>
		  </div>
		</div>
	  </div>
	</nav>
	<main>
		<div class="Form">
		  <div class="edit_form">
		  	<div class="modif_piece">
				Login :
				<?php echo $_SESSION['login']; ?>
				<a class="modif" href="user_home_modify.php">Modifier</a>
			</div></br>
			<div class="modif_piece">
				Email :
				<?php echo $_SESSION['email']; ?>
				<a class="modif" href="user_home_modify.php">Modifier</a>
			</div>
		  	<div class="modif_piece">
			<a href="new_passw.php?id=<?php echo $_SESSION['id']; ?>" class="mdp">Modifier mon mot de passe</a>
			</div>
		</br>
		<div id="like_and_com_email">
		Reçevoir un email lorsque : </br>
		  	<div class="modif_piece">
		  		Une de mes photos a été aimée
		  		<a class="modif" id="like_set_email" href="email_subs.php?change=like"></a>
		  	</div>
		  	<div class="modif_piece">
				Une de mes photos a été commentée
				<a class="modif" id="com_set_email" href="email_subs.php?change=com"></a>
			</div>
		</div>
		</div>
	  </div>
	</main>
<div class="footer"><p id="footer_text">alanteri@42  - 2018</p></div>
</body>
</html>
