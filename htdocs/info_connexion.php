<?php

require_once('./config/database.php');

function	bdd() {
	global $DB_NAME, $DB_DSN, $DB_USER, $DB_PASSWO;
	
	if (isset($DB_DSN) && isset($DB_USER) && isset($DB_PASSWO)) {
		try {
			return $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWO, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		catch (Exception $e) {
			die ("Tu n'as peut être pas initialisé ta base de donnée. Pour ce faire, vas sur Camagru/config/setup.php");
		}
	}
	else {
		echo "Cannot access database";
		exit ;
	}
}

// Recuperer l'ID
function	id_user($db, $login)
{
	$req = $db->prepare("SELECT ID FROM user WHERE Login = :Login");
	$req->execute(array("Login" => $login));

	$donne = $req->fetch();

	return $donne['ID'];
}

//L'ID existe t-il ?
function	ctrl_cookie($db, $id)
{
	$req = $bdd->prepare("SELECT COUNT(*) AS nb FROM user WHERE ID = :ID");
	$req->execute(array("ID" => $id));

	$donne = $req->fetch();

	if ($donne['nb'] == 1)
		return true;
	else
		return false;
}

function	email($login, $mail, $id)
{
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) {
		$passage_ligne = "\r\n";
	}
	else {
		$passage_ligne = "\n";
	}

	$subject = "Bienvenue sur Camagru";
	$message_html = "<HTML><BODY><FONT FACE='Arial, Verdana' SIZE=2>Bonjour ".$login.", et bienvenue sur Camagru.<br/>";
	$message_html .= "Ton compte a bien été créé. Pour partager de nouvelles photos avec tes amis, active ton compte en cliquant";
	$message_html .= "<a href='http://localhost:8080/Camagru/connexion.php?login=".$login."&cle=".$id."'> ici.</a></BODY></HTML>";
	
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