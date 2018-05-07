<?php
	print('ok');
session_start();
require_once('info_connexion.php');
$db = bdd();

if (isset($_POST['email'])) {
	find_user_by_email($db, $_POST['email']);
}

if (isset($_GET['action']) AND isset($_GET['login']) AND isset($_GET['token'])) {
	$req = $db->prepare("SELECT COUNT(*) AS nb, id AS id FROM user WHERE login = :login");
	$req->execute(array("login" => $_GET['login']));
	$donnee = $req->fetch();

	if ($_GET['action'] == 'chg_pwd' AND password_verify($donnee['id'], $_GET['token'])) {$delta = 86400;
	$req = $db->prepare("SELECT tstime AS tstime FROM user WHERE ")
	if ($_SERVER["REQUEST_TIME"] - $tstime < $delta) {
		header('location: new_passw.php?login='.$_GET['login'].');
		exit ;
	}	}
	else
		alert("Le token a expiré.")
}

if (isset($_POST['passwd']) AND isset($_POST['passwd2'])) {

	if (strcmp($_POST['passwd'], $_POST['passwd2']) == 0) {
		$req = $bd->prepare('UPDATE user SET password = :pwd WHERE id = :id')
		$req->execute(array(
			"pwd" => password_hash($_POST['passwd'], PASSWORD_DEFAULT),
			"id" => $_GET['id']));
	}

}

function	find_user_by_email($db, $email)
{
	$req = $db->prepare("SELECT COUNT(*) AS nb, login AS login, id AS id FROM user WHERE email = :email");
	$req->execute(array("email" => $email));
	$donnee = $req->fetch();

	if ($donnee['nb'] == 1) {
		$token = create_token($donnee[$id]);
		send_reset_pwd_email($email, $donnee['login'], $token);
		header('Location: login.php');
		exit ;
	}
}

function	creat_token($id) {
	$token = password_hash($id, PASSWORD_DEFAULT);
	$req = $db->prepare("UPDATE user SET token = :token AND tstime = :tstime WHERE email = :email");
	$req->execute(array(
		"token" => $token,
		"tstime" => $_SERVER["REQUEST_TIME"]
	));
	return $token;
}

function	send_reset_pwd_email($mail, $login, $token) {
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) {
		$passage_ligne = "\r\n";
	}
	else {
		$passage_ligne = "\n";
	}

	$subject = "Réinitialisation de ton mot de passe";
	$message_html = "<HTML><BODY><FONT FACE='Arial, Verdana' SIZE=2>Bonjour ".$login.",<br/>";
	$message_html .= "Si tu as bien fait une demande pour réinitialiser ton mot de passe, tu peut cliquer";
	$message_html .= "<a href='http://localhost:8888/Camagru/edit_account.php?action=chg_pwd&login=".$login."&token=".$token."'> ici.</a></BODY></HTML>";
	
	$boundary = "-----=".md5(rand());
	
	$header = "From: \"Camagru\"<Nenalant@macbook-pro-de-anne.local>".$passage_ligne;
	$header .= "Reply-to: \"Camagru\" <anne.c.lanteri@gmail.com>".$passage_ligne;
	$header .= "MIME-Version: 1.0".$passage_ligne;
	$header .= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;

	$message .= $passage_ligne."--".$boundary.$passage_ligne;
	$message .= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
	$message .= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message .= $passage_ligne.$message_html.$passage_ligne;
	$message .= $passage_ligne."--".$boundary."--".$passage_ligne;
	$message .= $passage_ligne."--".$boundary."--".$passage_ligne;

	mail($mail, $subject, $message, $header);	
}

?>