<?php
session_start();
require_once('info_connexion.php');
$db = bdd();

if ($_GET['supp'] == "supp")
{
	$src_pic = str_replace(".png", "", $_GET['pic']);
	$req = $db->prepare("SELECT login AS log FROM photos WHERE src = :src_pic");
	$req->execute(array("src_pic" => $src_pic));
	$donne = $req->fetch();

	$pics_dir = './img/user_img/';

	if ($donne['log'] == $_SESSION['login']) {
		unlink($pics_dir . $_GET['pic']);
		$req = $db->prepare("DELETE FROM photos WHERE src = :src");
		$req->execute(array("src" => $src_pic));
		header('Location: index.php');
		exit ;
	}
	else
		?><script type="text/javascript">
			alert("Vous ne pouvez supprimer que vos images");
				window.location.href='index.php';
		</script><?php
}

?>