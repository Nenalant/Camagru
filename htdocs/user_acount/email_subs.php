<?php
session_start();
require_once('../info_connexion.php');
$db = bdd();
$login = $_SESSION['login'];

function	sub_to_like_email($db, $login) {
	$req = $db->prepare("SELECT like_email AS like_email FROM user WHERE login = :login");
	$req->execute(array("login" => $login));
	$donne = $req->fetch();

	return $donne['like_email'];
}

function	sub_to_com_email($db, $login) {
	$req = $db->prepare("SELECT com_email AS com_email FROM user WHERE login = :login");
	$req->execute(array("login" => $login));
	$donne = $req->fetch();

	return $donne['com_email'];
}

function	unsubscribe_to_like_emails($db, $login) {
	$req = $db->prepare("UPDATE user SET like_email = :unset WHERE login = :login");
	$req->execute(array("unset" => 0,
		"login" => $login));
}

function	unsubscribe_to_com_emails($db, $login) {
	$req = $db->prepare("UPDATE user SET com_email = :unset WHERE login = :login");
	$req->execute(array("unset" => 0,
		"login" => $login));
}

function	subscribe_to_like_emails($db, $login) {
		$req = $db->prepare("UPDATE user SET like_email = :unset WHERE login = :login");
	$req->execute(array("unset" => 1,
		"login" => $login));
}

function	subscribe_to_com_emails($db, $login) {
		$req = $db->prepare("UPDATE user SET com_email = :unset WHERE login = :login");
	$req->execute(array("unset" => 1,
		"login" => $login));
}

if (isset($_POST['like_em'])) {
	$like_em = $_POST['like_em'];

	if (sub_to_like_email($db, $login) == 1)
		echo "Ne plus reçevoir";
	else if (sub_to_like_email($db, $login) == 0)
		echo "Reçevoir";
}

else if (isset($_POST['com_em'])) {
	$com_em = $_POST['com_em'];

	if (sub_to_com_email($db, $login) == 1)
		echo "Ne plus reçevoir";
	else if (sub_to_com_email($db, $login) == 0)
		echo "Reçevoir";
}

else if (isset($_GET['change'])) {
	$what_to_change = $_GET['change'];

	if ($what_to_change == "like") {
		if (sub_to_like_email($db, $login) == 1) {
			unsubscribe_to_like_emails($db, $login);
			header('Location: user_home.php');
		}
		else if (sub_to_like_email($db, $login) == 0) {
			subscribe_to_like_emails($db, $login);
			header('Location: user_home.php');
		}
	}
	else if ($what_to_change == "com") {
		if (sub_to_com_email($db, $login) == 1) {
			unsubscribe_to_com_emails($db, $login);
			header('Location: user_home.php');
		}
		else if (sub_to_com_email($db, $login) == 0) {
			subscribe_to_com_emails($db, $login);
			header('Location: user_home.php');
		}
	}
}

?>