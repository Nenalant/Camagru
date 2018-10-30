<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: text/plain");
require_once('./config/database.php');
require_once('info_connexion.php');
$db = bdd();

$email = (htmlentities($_POST["new_email"]));
$login = (htmlentities($_POST["new_login"]));

if (!empty($email) && !empty($login)) {
	if (email_doesnt_exist_yet($email, $db) == 0) {
		if (login_doesnt_exist_yet($login, $db) == 0) {
			echo "true";
		}
		else
			echo "false login";
	}
	else
		echo "false email";
}

else if (!empty($email) && empty($login)) {
	if (email_doesnt_exist_yet($email, $db) == 0) {
		echo "true";
	}
	else
		echo "false email";
}

else if (empty($email) && !empty($login)) {
	if (login_doesnt_exist_yet($login, $db) == 0) {
			echo "true";
	}
	else
		echo "false login";
}

function	email_doesnt_exist_yet($email, $db) {
	$req = $db->prepare("SELECT COUNT(*) AS nb FROM user WHERE email = :email");
	$req->execute(array("email" => $email));
	$donne = $req->fetch();

	if ($donne['nb'] >= 1)
		return 1;
	else
		return 0;
}

function	login_doesnt_exist_yet($login, $db) {
	$req = $db->prepare("SELECT COUNT(*) AS nb FROM user WHERE login = :login");
	$req->execute(array("login" => $login));
	$donne = $req->fetch();

	if ($donne['nb'] >= 1)
		return 1;
	else
		return 0;
}

?>