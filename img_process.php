<?php

	$img_data = base64_decode(data);
    $img_name_tmp = password_hash($_SESSION['login'] . $_SESSION['id'], PASSWORD_DEFAULT);
    $img_name = substr($img_name_tmp, 0, 10);
    file_put_content($img_data, $img_name);

?>