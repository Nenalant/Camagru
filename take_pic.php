<?php
session_start();
if ($_SESSION['login'] == null)
	header("location: login.php");
require_once('info_connexion.php');
$db = bdd();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Camagru</title>
	<link rel="stylesheet" type="text/css" href="index.css">
	</link>
</head>
<body
<?php
if (isset($_SESSION["tmp_for_js"]) && $_SESSION["tmp_for_js"] === true)
{
echo " onload=\"import_file_pic()\"";
$_SESSION["tmp_for_js"] = false;
}

?>
>
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
					<a href="user_acount/user_home.php" id="username"><img src="./img/website_img/cute_user.png" id="user"/>
				</div>
				<div>
					<?php if (isset($_SESSION['login'])) echo $_SESSION['login']; else echo ""; ?></a>
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
	<div class="cellule_ontakep">
	<ul id="menu">
			<strong id="text_plus_img">Mes Photos</strong>
		<li>
	<a href="#">
		<img src="./img/website_img/plus.png" id="plus_img"></a>
			<ul id="menu_i">
				<li>
				<a href="#">
<?php
		$dir_path = 'img/user_img/';
		$req = $db->prepare("SELECT * FROM photos WHERE login = :login ORDER BY img_date DESC");
		$req->execute(array("login" => $_SESSION['login']));
		
		while ($pic = $req->fetch()) {
		$pic = $pic['src'];
		if (!strcmp($pic[0], ".") == 0) {
			$pic_name = $pic;
			$pic_png = $pic . ".png";
			$base64 = base64_encode(file_get_contents($dir_path . $pic_png));
			$src = 'data:image/png;charset=utf-8;base64,' . $base64;

				echo '<img class="imagenes_takep" src="' . $src .'"/></a>';
		}
	}
?>
	</li></ul></li></ul>
	</div>
<div class="Form">
	<form id="uuu">
		<div id="cont_video">
			<div id="pic_to_take">
				<div id="down_pict"></div>
				<video id="video"></video>
				<div id="webcam_filter" class="filter_on_video"></div>
			</div>
			<div id="pic_taken">
				<input type="hidden" id="hidden" name="none"/>
				<canvas id="canvas" id="photos"></canvas>
				<canvas id='blank' style='display:none'></canvas>
				<img name="photo" id="photo" alt="">
			</div>
	  		<br>
			<div id="all_tmp" class="all_tmp">
				<div id="tmp_pic" class="filter_on_video"></div>
			</div>
		</div>
        Prend une photo</br>
    <input type="submit" id="startbutton" name="submit" value="O" />
</form>
 <form action="down2.php" method="post" enctype="multipart/form-data"></br> ou </br> Télécharge la tienne :
    </br>
        <input type="file" name="myfile" id="fileToUpload">
        <input type="submit" name="submit" id="pic_send" value="Telecharger">
    </form>
<form>
    <p>Selectionner un filtre</p>
		<ul>
			<li>
				<a href="#">
					<img id="bunny" name="bunny" src="img/filters/bunny.png" class="filters" onclick="put_filter_on_cam(this.id)">
				</a>
			</li>
			<li>
				<a href="#">
				<img id="cat" src="img/filters/cat.png" class="filters" onclick="put_filter_on_cam(this.id)">
				</a>
			</li>
			<li>
				<a href="#">
				<img id="cat_ears" src="img/filters/cat_ears.png" class="filters" onclick="put_filter_on_cam(this.id)">
				</a>
			</li>
			<li>
				<a href="#">
				<img id="dalma" src="img/filters/dalma.png" class="filters" onclick="put_filter_on_cam(this.id)">
				</a>
			</li>
			<li>
				<a href="#">
				<img id="dog" src="img/filters/dog.png" class="filters" onclick="put_filter_on_cam(this.id)">
				</a>
			</li>
			<li>
				<a href="#">
				<img id="mouse" src="img/filters/mouse.png" class="filters" onclick="put_filter_on_cam(this.id)">
				</a>
			</li>
		</ul>
    <a href="#" class="button" download="my_pic.png" id="btn_download"><img src="./img/website_img/icon.png" id="download"></a>
    <input type="submit" id="publish" name="publish" value="Publier" />
</form>
<script src="stream.js"></script>
	<div class="footer"><p id="footer_text">alanteri@42  - 2018</p></div>
</body>
</html>