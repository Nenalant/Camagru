<?php 
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Camagru</title>
	<link rel="stylesheet" type="text/css" href="index.css">
	</link>
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
<div class="Form">
	<form>
		<video id="video"></video>
		<input type="hidden" id="hidden" name="none"/>
		<canvas id="canvas" id="photos"></canvas>
		<img name="photo" src="http://localhost:8888/Camagru/take_pic.php" id="photo" alt="photo"></br>
    <input type="submit" id="startbutton" name="submit" value="O" />
    <a href="#" class="button" download="my_pic.png" id="btn_download"><img src="./img/website_img/icon.png" id="download"></a>
    <input type="submit" id="publish" name="publish" value="Publish" />
	</form>
	<form method="POST" action="upload.php" enctype="multipart/form-data">
		<input type="hidden" name="MAX_FILE_SIZE" value="100000">
		<input type="file" name="avatar">
		<input type="submit" name="envoyer" value="Envoyer le fichier">
	</form>
</div>
<div class="filter_gallery" >
	<?php

	$dir_path = 'img/filters/';
	$pic_dir = scandir($dir_path);

	foreach ($pic_dir as $pic) {
		if (!strcmp($pic[0], ".") == 0) {
			$base64 = base64_encode(file_get_contents($dir_path . $pic));
			$src = 'data:image/png;charset=utf-8;base64,' . $base64;
			echo '<img id="filta" src="' . $src .'"/>';
		}
	}
	?>
</div>
<script src="stream.js"></script>
	<div class="footer"><p id="footer_text">alanteri@42  - 2018</p></div>
</body>
</html>