<?php
session_start();
require_once('info_connexion.php');
$db = bdd();

function	find_pic_autor($pic, $db) {
	$req = $db->prepare("SELECT login AS log FROM photos WHERE src = :src");
	$req->execute(array('src' => $pic));
	$donne = $req->fetch();

	return $donne['log'];
}

function	already_liked_or_not($pic, $liker_log, $db) {
	$req = $db->prepare("SELECT COUNT(*) AS liked FROM likes WHERE picture_src = :src AND liker_login = :l_log");
	$req->execute(array(
		'src' => $pic,
		'l_log' => $liker_log
	));
	$donne = $req->fetch();

	return $donne['liked'];
}

function	num_of_likes($pic, $db) {
	$req = $db->prepare("SELECT COUNT(*) AS num FROM likes WHERE picture_src = :src");
	$req->execute(array('src' => $pic));
	$donne = $req->fetch();

	return $donne['num'];
}

function	find_pic_author($db, $pic) {
	$req = $db->prepare("SELECT login AS author FROM photos WHERE src = :src");
	$req->execute(array("src" => $pic));
	$donne = $req->fetch();

	return $donne['author'];
}

function	find_author_email($db, $login) {
	$req = $db->prepare("SELECT email AS email FROM user WHERE login = :login");
	$req->execute(array("login" => $login));
	$donne = $req->fetch();

	return $donne['email'];
}

function	user_sub_to_like_email($db, $login) {
	$req = $db->prepare("SELECT like_email AS like_email FROM user WHERE login = :login");
	$req->execute(array("login" => $login));
	$donne = $req->fetch();

	return $donne['like_email'];
}

function	send_pic_liked_email($db, $pic) {
	$login = find_pic_author($db, $pic);
	$mail = find_author_email($db, $login);

	if (user_sub_to_like_email($db, $login) == 1)
		picture_liked_email($login, $mail, $pic);
}

if (isset($_POST['src_pic']) && isset($_POST['add'])) {
	$pic = $_POST['src_pic'];
	$liker_login = $_SESSION['login'];
	$pic_login = find_pic_autor($pic, $db);
	$pic_already_liked = already_liked_or_not($pic, $liker_login, $db);

	if ($pic_already_liked == 0) {
		$req = $db->prepare("INSERT INTO likes(picture_src, liker_login) VALUES(:src, :log)");
		$req->execute(array(
			'src' => $pic,
			'log' => $liker_login
		));
		send_pic_liked_email($db, $pic);
	}
	else if ($pic_already_liked == 1) {
		$req = $db->prepare("DELETE FROM likes WHERE picture_src = :src AND liker_login = :l_log");
		$req->execute(array(
			'src' => $pic,
			'l_log' => $liker_login
		));
	}
	$num = num_of_likes($pic, $db);
	echo $num;
}

else if (isset($_POST['src_picture'])) {
	$pic = $_POST['src_picture'];

	$num = num_of_likes($pic, $db);
	echo $num;
}

else if (isset($_POST['src_for_face'])) {
	$pic = $_POST['src_for_face'];
	$liker_login = $_SESSION['login'];

	$face = already_liked_or_not($pic, $liker_login, $db);
	echo $face;
}

function	picture_liked_email($login, $mail, $pic)
{
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) {
		$passage_ligne = "\r\n";
	}
	else {
		$passage_ligne = "\n";
	}

	$subject = "Ta photo a ete like";
	$message_html = "<HTML><BODY><FONT FACE='Arial, Verdana' SIZE=2>Bonjour ".$login.",<br/>";
	$message_html .= "Félicitations, ta photo ".$pic." a reçu un j'aime !</BODY></HTML>";
	
	$boundary = "-----=".md5(rand());
	
	$header = "From: \"Camagru\"<Nenalant@macbook-pro-de-anne.local>".$passage_ligne;
	$header .= "Reply-to: \"Camagru\" <anne.c.lanteri@gmail.com>".$passage_ligne;
	$header .= "MIME-Version: 1.0".$passage_ligne;
	$header .= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;

	$message = $passage_ligne."--".$boundary.$passage_ligne;
	$message .= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
	$message .= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message .= $passage_ligne.$message_html.$passage_ligne;
	$message .= $passage_ligne."--".$boundary."--".$passage_ligne;
	$message .= $passage_ligne."--".$boundary."--".$passage_ligne;

	mail($mail, $subject, $message, $header);
}

?>