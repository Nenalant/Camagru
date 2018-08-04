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
	$img = $_POST['img'];
	$img = str_replace('data:image/png;base64', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);

	$filter_path = $_POST['filter'];
	$filter = str_replace('http://localhost:8888/Camagru/', '', $filter_path);
	$filter = imagecreatefrompng($filter);
	// imagecopymerge($img, $filter, 0, 0, 0, 0, imagesx($img), imagesy($img), 75);

	if (!file_exists($dir)) {
		mkdir($dir);
	}
	if (!empty($data)) {
		$pic_num = num_of_pics($db);
		$pic_name = $_SESSION['login'] . "_" . $pic_num;
		add_to_db_register($db, $pic_name);
		$file = $dir . $pic_name . '.png';
		$sucess = file_put_contents($file, $data);
		print $sucess ? $file : "Unable to save this image.";
	}
	else {
		?><script type="text/javascript">
			alert("Une erreur est survenue avec l image");
		</script><?php
	}
}

?>