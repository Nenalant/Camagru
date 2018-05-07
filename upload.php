<?php

if (isset($_FILES['avatar'])) {
	$doc = './img/user_img/';
	$file = good_file(basename($_FILES['avatar']['name']));

	if (move_uploaded_file($_FILES['avatar']['tmp_name'], $doc . $file)) {
		echo "cool";
	}
	else {
		echo "bouuu";
	}
}

function	good_file($file) {
	$file = strtr($file,
     'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
     'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
	$file = preg_replace('/([^.a-z0-9]+)/i', '-', $file);
	$file_type_autorized = array('.png', '.jpg', '.jpeg');
	$file_type = strchr($_FILES['avatar']['name'], '.');
	$max_size = '100000';
	$file_size = filesize($_FILES['avatar']['name_tmp']);
	if ($file_size <= $max_size) {
		if (in_array($file_type, $file_type_autorized)) {
			return $file;
		}
		else {
			alert('Extensions authorized: .png, .jpg, .jpeg');
			exit();
		}
	}
	else {
		alert('Your file is too big');
		exit();
	}
}

?>