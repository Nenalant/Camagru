<?php

if (isset($_FILES['avatar'])) {
	$doc = './img/tmp_pic/';
	if ($_FILES['avatar']['error'] > 0)
		$erreur = "Erreur lors du transfert";
	else {
		$tmp_name = md5(uniqid(rand(), true));
		$file = good_file(basename($_FILES['avatar']['name']), $tmp_name);
		if (move_uploaded_file($_FILES['avatar']['tmp_name'], $doc . $file)) {
			echo true;
		}
		else {
			echo false;
		}
		?>
		<script language="javascript" type="text/javascript">

		</script>
		<?php
	}
}

function	good_file($file, $tmp_name) {
	$file = strtr($file,
     'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
     'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
	$file = str_replace('/([^.a-z0-9]+)/i', '-', $file);
	$file_type_autorized = array('.png', '.jpg', '.jpeg');
	$file_type = strchr($_FILES['avatar']['name'], '.');
	$max_size = '100000';
	$file_size = filesize($_FILES['avatar']['name_tmp']);
	if ($file_size <= $max_size) {
		if (in_array($file_type, $file_type_autorized)) {
			return $file;
		}
		else {
			?><script type="text/javascript">
			alert('Extensions authorized: .png, .jpg, .jpeg');
			exit();
			</script><?php
		}
	}
	else {
		?><script type="text/javascript">
		alert('Your file is too big');
		exit();
		</script><?php
	}
}

?>