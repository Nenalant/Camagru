<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home - Camagru</title>
	<link rel="stylesheet" href="index.css" type="text/css">
	<script type="text/javascript" src="check_info_ajax.js"></script>
</head>
<body>
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
					<a href="user_home.php" id="username">
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
		<form onsubmit="event.preventDefault();return check_bd_info();" action="edit_account.php" method="post" id="form_modif_login">
		  <div class="edit_form_user">
			<div class="modif_piece">
				Login : <input name="new_login" id="new_login" type="text" placeholder="<?php echo $_SESSION['login']; ?>" />
			</div></br>
			<div class="modif_piece">
				Email : <input name="new_email" id="new_email" type="email" placeholder="<?php echo $_SESSION['email']; ?>" />
			</div>
		  	<div class="modif_piece">
			<a href="new_passw.php?id=<?php echo $_SESSION['id']; ?>" class="mdp">Modifier mon mot de passe</a>
			<input type="submit" class="sub_button" name="mod_mail" value="Enregistrer" />
			</div>
		  </div>
	  	</form>
	  </div>
	</main>
<div class="footer"><p id="footer_text">alanteri@42  - 2018</p></div>
</body>
</html>
