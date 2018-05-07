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
<section>
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
					<a href="user_home.php" id="username"><img src="./img/website_img/cute_user.png" id="user"/>
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
		<div id="publication">
		<?php

		$dir_path = 'img/user_img/';
		$pic_dir = array_reverse(scandir($dir_path));

		foreach ($pic_dir as $pic) {
			if (!strcmp($pic[0], ".") == 0) {
				$base64 = base64_encode(file_get_contents($dir_path . $pic));
				$src = 'data:image/png;charset=utf-8;base64,' . $base64;
				echo '<article class="cellule">
						<img class="imagenes" src="' . $src .'"/>
						<div class="iconehappy">
						  <img class="happylike" src="img/website_img/happy.png"/>
						</div>
						<div class="edit">
						  <a href="#">
							<img src="./img/website_img/cross.png" class="cross"/>
						  </a>
						</div>
					  </article>';
			}
		}
		?>
		</div>
		<div class="footer"><p id="footer_text">alanteri@42  - 2018</p></div>
	</main>
</section>
</body>
</html>
