<?php
session_start();
require_once('info_connexion.php');
$db = bdd();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home - Camagru</title>
	<link rel="stylesheet" href="index.css" type="text/css">
	<script src="picture_action.js"></script>
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
					<?php if (isset($_SESSION['login'])) { ?>
					<a href="user_home.php" id="username">
					<?php } ?>
					<img src="./img/website_img/cute_user.png" id="user"/>
				</div>
				<div>
					<?php if (isset($_SESSION['login'])) echo $_SESSION['login']; else echo ""; ?></a>
				</div>
			  </div>
			  <div class="hiconetoicon">
			  	<?php if (isset($_SESSION['login'])) { ?>
				<a href="take_pic.php">
					<?php } ?>
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

		include('comment.php');
		$dir_path = 'img/user_img/';
		$pic_dir = array_reverse(scandir($dir_path));
		$page = 1;

		if (isset($_GET['page'])) {
            $page = $_GET['page'];
        }
        $nu_of_pic_per_page = 7;
        $offset = ($page-1) * $nu_of_pic_per_page;
        $req = $db->prepare("SELECT COUNT(*) FROM photos");
        $req->execute();
     	$pic_id_per_page = $req->fetch();
     	$num_of_pages = ceil($pic_id_per_page[0] / $nu_of_pic_per_page);

     	$req = $db->prepare("SELECT * FROM photos ORDER BY img_date DESC LIMIT $offset, $nu_of_pic_per_page ");
     	$req->execute();
     	
     	while ($pic = $req->fetch()) {
			$pic = $pic['src'];
			if (!strcmp($pic[0], ".") == 0 && file_exists($dir_path . $pic . ".png")) {
				$pic_name = $pic;
				$pic_png = $pic . ".png";
				$base64 = base64_encode(file_get_contents($dir_path . $pic_png));
				$src = 'data:image/png;charset=utf-8;base64,' . $base64;

				echo '<article class="cellule">
						<img class="imagenes" src="' . $src .'"/>
						<div class="hicones_pic">
						<div class="hicones2">
							<div class="">';
							if (isset($_SESSION["login"])) {
							echo  '<img id='.$pic_name.' class="happylike" src="img/website_img/happy.png" onload="how_much_likes(this)" onclick="like_pic(this)"/>
							</div>
							<div class="hiconetoicon" >
							  	<span id="num_likes'.$pic_name.'" class="num_of_likes"></span>
							</div>
							<div id="com_post">
							  <form onsubmit="return sub_comm(this)">
									<input type="text" name="one_com" id="'.$pic_name.'" placeholder="Commenter" required="" pattern="[A-Za-z0-9\s\.\?!]{1,60}" />
									<input type="submit" value="Publier" class="sub_comment"/>
									</form>
								</div>';
							}
							else {
							echo '<img id='.$pic_name.' class="happylike" src="img/website_img/happy.png" onload="how_much_likes(this)" onclick="must_be_connected()"/>
							</div>
							<div class="hiconetoicon" >
							  	<span id="num_likes'.$pic_name.'" class="num_of_likes"></span>
							</div>
							  <div id="com_post">
								<form onsubmit=must_be_connected()>
									<input type="text" name="one_com" id="one_coment'.$pic_name.'" placeholder="Connecte toi pour commenter" required="" pattern="[A-Za-z0-9]{1,15}"/>
									<input type="submit" name="sub_com" value="Publier" class="sub_comment"/>
									</form>
								</div>';
							}
							echo '<div class="">
								<ul id="menu">
									<li><a href="#"><img class="dot_selec" src="img/website_img/3dots.png"/></a>
										<ul></br>
								  		  <li><a href="supp_picture.php?supp=supp&pic='.$pic.'" id="sup_m">Supprimer</a></li>
								        </ul>
									</li>
								</ul>
							</div>
							</div>
						</div>
						';
				if ($comment_tab = search_pic_coms($pic_name)) {
					echo "</br>";
				}
					  echo '</article>';
			}
		}
		?>
		<div class="lulu">
		<ul class="pagination">
	        <li class="page-item">
	        	<a class="page-link"  href="?page=1">First</a>
	        </li>
	        <li class="<?php if($page <= 1){ echo 'disabled'; } ?>">
	            <a class="page-link" href="<?php if($page <= 1){ echo '#'; } else { echo "?page=".($page - 1); } ?>">Prev</a>
	        </li>
	        <li class="<?php if($page >= $num_of_pages){ echo 'disabled'; } ?>">
	            <a class="page-link" href="<?php if($page >= $num_of_pages){ echo '#'; } else { echo "?page=".($page + 1); } ?>">Next</a>
	        </li>
	        <li class="page-item">
	        	<a class="page-link" href="?page=<?php echo $num_of_pages; ?>">Last</a>
	        </li>
    	</ul>
    </div>
		<div class="footer"><p id="footer_text">alanteri@42  - 2018</p></div>
	</main>
</section>
</body>
</html>
