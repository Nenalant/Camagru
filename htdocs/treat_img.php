<?php
session_start();
require_once('info_connexion.php');
$db = bdd();

function	num_of_pics($db) {
	$req = $db->prepare("SELECT COUNT(*) AS nb FROM photos WHERE login = :login");
	$req->execute(array('login' => $_SESSION['login']));
	$donne = $req->fetch();

	return $donne['nb'];
}

function	add_to_db_register($db, $pic_name) {
	try {
		$req = $db->prepare("INSERT INTO photos(src, login, img_date) VALUES(:src, :login, NOW())");
		
		$req->execute(array(
			'src' => $pic_name,
			'login' => $_SESSION['login']
		));
	}
	catch (Exception $e) {
		die ('Erreur : ' . $e->getMessage());
		return false;
	}
}

if (isset($_POST['img']) && !empty($_POST['img']) &&
	isset($_POST['filter']) && !empty($_POST['filter'])) {
	
		$dir = './img/user_img/';
		if (!file_exists('./img/tmp_pic/'))
			mkdir('./img/tmp_pic/');
		$img = $_POST['img'];

		$filter_path = $_POST['filter'];
		$filter = str_replace('http://localhost:8888/Camagru/', '', $filter_path);
		$filter = imagecreatefrompng($filter);

		if (strcmp(substr($img, 0, 14), "./img/tmp_pic/")) {
			$img = str_replace('data:image/png;base64', '', $img);
			$img = str_replace(' ', '+', $img);
			$data = base64_decode($img);
			$img_from_video = "/img/tmp_pic/new_image.png";
			$fp = fopen(__DIR__ . $img_from_video, 'a') or die("Can t open file");
			fwrite($fp, $data);
			fclose($fp);
			$data = imagecreatefrompng("." . $img_from_video);
		echo "data3 === " . $data . "\n";
		$res_img = imagecreatetruecolor(imagesx($data), imagesy($data));
		imagecopy($res_img, $data, 0, 0, 0, 0, imagesx($data), imagesy($data));
		imagecopyresized ($res_img, $filter, 200/3, 2, 0, 0, 65, 65, imagesx($filter), imagesy($filter));
		}
		else {
			$extension = pathinfo($img);
			switch ($extension['extension']) {
				case 'png':
					$data = imagecreatefrompng($img);
				case 'jpeg':
					$data = imagecreatefromjpeg($img);
				case 'jpg':
					$data = imagecreatefromjpeg($img);
			}
		$filter_final_size = 100 * imagesx($data) / (250 * imagesx($data) / imagesy($data));
		$width_r = imagesx($data) / 2 - $filter_final_size / 2;
		$res_img = imagecreatetruecolor(imagesx($data), imagesy($data));
		imagecopy($res_img, $data, 0, 0, 0, 0, imagesx($data), imagesy($data));
		imagecopyresized ($res_img, $filter, $width_r, 0, 0, 0, $filter_final_size, $filter_final_size, imagesx($filter), imagesy($filter));
		}
		$data = $res_img;

		if (!file_exists($dir)) {
			mkdir($dir);
		}
		if (!empty($data)) {
			$pic_num = num_of_pics($db);
			$pic_name = $_SESSION['login'] . "_" . $pic_num;
			add_to_db_register($db, $pic_name);
			$file = $dir . $pic_name . '.png';
			$sucess = imagepng($data, $file);
			if (file_exists("." . $img_from_video))
				unlink("." . $img_from_video);
			if (file_exists("./img/tmp_pic/tmppicname.jpg"))
				unlink("./img/tmp_pic/tmppicname.jpg");
			print $sucess ? $file : "Unable to save this image.";
		}
		else {
			?><script type="text/javascript">
				alert("Une erreur est survenue avec l image");
			</script><?php
		}
}

?>