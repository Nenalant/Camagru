<?php

session_start();

if (isset($_POST['img']) && !empty($_POST['img'])) {

	$dir = './img/user_img/';
	$img = $_POST['img'];
	$img = str_replace('data:image/png;base64', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	if (!file_exists($dir)) {
		mkdir($dir);
	}
	$file = $dir . uniqid() . '.png';
	$sucess = file_put_contents($file, $data);
	print $sucess ? $file : "Unable to save this image.";
}

?>