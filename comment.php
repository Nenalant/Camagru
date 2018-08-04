<?php
if (!isset($_SESSION))
	session_start();
require_once('info_connexion.php');
$db = bdd();

function	search_pic_coms($pic) {
	$db = bdd();
	$req = $db->prepare("SELECT login, coment FROM coments WHERE pic_name = :pic_name");
	$req->execute(array("pic_name" => $pic));
	$list = array();
	while ($donne = $req->fetch()) {
		?><strong><?php echo $donne['login']; echo "&nbsp;&nbsp;"; ?></strong><?php
		echo $donne['coment'];?></br><?php
	}
}

function	find_pic_author($db, $pic) {
	$req = $db->prepare("SELECT login AS author FROM photos WHERE src = :src");
	$req->execute(array("src" => $pic));
	$donne = $req->fetch();

	return $donne['author'];
}

function	user_sub_to_com_email($db, $login) {
	$req = $db->prepare("SELECT com_email AS com_email FROM user WHERE login = :login");
	$req->execute(array("login" => $login));
	$donne = $req->fetch();

	return $donne['com_email'];
}

function	find_author_email($db, $login) {
	$req = $db->prepare("SELECT email AS email FROM user WHERE login = :login");
	$req->execute(array("login" => $login));
	$donne = $req->fetch();

	return $donne['email'];
}

if (isset($_POST['the_com']) && isset($_POST['pic'])) {
	$comment = htmlspecialchars($_POST['the_com']);
	$pic_name = htmlspecialchars($_POST['pic']);
	$login = find_pic_author($db, $pic_name);
	$mail = find_author_email($db, $login);

	add_com_to_db($pic_name, $comment, $db);
	if (user_sub_to_com_email($db, $login) == 1)
		picture_commented_email($login, $mail, $pic_name);
}

function	add_com_to_db($pic_name, $comment, $db) {
	$req = $db->prepare("INSERT INTO coments(pic_name, login, coment, com_date) VALUES(:pic_name, :login, :coment, NOW())");
	$req->execute(array(
		"pic_name" => $pic_name,
		"login" => $_SESSION['login'],
		"coment" => $comment));
}

function	picture_commented_email($login, $mail, $pic)
{
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) {
		$passage_ligne = "\r\n";
	}
	else {
		$passage_ligne = "\n";
	}

	$subject = "Ta photo a ete commentee";
	$message_html = "<HTML><BODY><FONT FACE='Arial, Verdana' SIZE=2>Bonjour ".$login.",<br/>";
	$message_html .= "Félicitations, ta photo ".$pic." a reçu un commentaire !</BODY></HTML>";
	
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