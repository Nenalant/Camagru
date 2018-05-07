<?php
session_start();
require_once('info_connexion.php');
$db = bdd();

if (isset($_GET['deco'])) {
	if (session_status() == 2)
		session_destroy();
	$_SESSION['id'] = NULL;
	header('Location: login.php');
	exit ;
}

else if (isset($_GET['login']) AND isset($_GET['cle'])) {
	$req = $db->prepare("SELECT COUNT(*) AS nb, id AS id, email AS email FROM user WHERE login = :login");
	$req->execute(array("login" => $_GET['login']));
	$donne = $req->fetch();

	if ($donne['nb'] == 1 AND password_verify($donne['id'], $_GET['cle'])) {
			set_account_verified($_GET['login'], $donne['id'], $db);
			$_SESSION['email'] = $donne['email'];
			$_SESSION['id'] = id_user($db, $_GET['login']);
			$_SESSION['login'] = $_GET['login'];
			header('Location: index.php');
			exit ;
	}
	else {
		header('Location: error_connexion.php');
		exit ;
	}
}

else if (isset($_POST['login']) AND isset($_POST['passwd'])) {
	$login = htmlspecialchars($_POST['login']);
	
	if (connexion($db, $login)) {
		if (isset($_SESSION['id'])) {
			header('Location: index.php');
			exit ;
		}
	}
	else {
		header('Location: error_connexion.php');
		exit ;
	}
}

function	set_account_verified($login, $id, $db) {
	$req = $db->prepare('UPDATE user SET verified = :val WHERE id = :id AND login = :login');
	$req->execute(array(
		"val" => 1,
		"id" => $id,
		"login" => $login));
	$_SESSION['verified'] = 1;
}

function	connexion($db, $login) {
	$req = $db->prepare("SELECT COUNT(*) AS nb, password AS pass, email AS email, verified AS verif FROM user WHERE login = :login");
	$req->execute(array("login" => $login));
	$donne = $req->fetch();

	if ($donne['nb'] == 1) {
		if (password_verify($_POST['passwd'], $donne['pass'])) {
			if ($donne['verif'] == 1) {
				$_SESSION['email'] = $donne['email'];
				$_SESSION['id'] = id_user($db, $login);
				$_SESSION['login'] = $login;
				return true;
			}
			else {
				header('Location: check_your_mails.php');
				exit ;
			}
		}
		else
			return false;
	}
	else
		return false;
	$req->closeCursor();
}
?>