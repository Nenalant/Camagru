<?php
session_start();
require_once('info_connexion.php');
$db = bdd();

if (isset($_POST['new_email']) AND empty($_POST['new_login']) AND isset($_SESSION['id'])) {
	$req = $db->prepare('UPDATE user SET email = :email WHERE id = :id');
	$req->execute(array(
		"email" => $_POST['new_email'],
		"id" => $_SESSION['id']));
	$_SESSION['email'] = $_POST['new_email'];
	header("location: user_home.php");
	exit ;
}

else if (empty($_POST['new_email']) AND isset($_POST['new_login']) AND isset($_SESSION['id'])) {
	$newest_login = htmlspecialchars($_POST['new_login']);
	if (strlen($newest_login) > 15)
	{
		header("location: user_home.php");
		exit ;
	}
	$req = $db->prepare('UPDATE user SET login = :login WHERE id = :id');
	$req->execute(array(
		"login" => $newest_login,
		"id" => $_SESSION['id']));
	$_SESSION['login'] = $newest_login;
	header("location: user_home.php");
	exit ;
}

else if (isset($_POST['new_email']) AND isset($_SESSION['id']) AND isset($_POST['new_login'])) {
	$newest_login = htmlspecialchars($_POST['new_login']);
	if (strlen($newest_login) > 15)
	{
		header("location: user_home.php");
		exit ;
	}
	$req = $db->prepare('UPDATE user SET login = :login, email = :email WHERE id = :id');
	$req->execute(array(
		"login" => $newest_login,
		"email" => $_POST['new_email'],
		"id" => $_SESSION['id']));
	$_SESSION['email'] = $_POST['new_email'];
	$_SESSION['login'] = $newest_login;
	echo "1";
	header("location: user_home.php");
	exit ;
}

if (isset($_POST['email'])) {
	if (($email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) == FALSE)
	{
		echo "Le format de ton email est incorrect. Inscription interrompu.";
		exit ;
	}
	else
		find_user_by_email($db, $email);
}

if (isset($_GET['action']) AND isset($_GET['login']) AND isset($_GET['token'])) {
	$req = $db->prepare("SELECT COUNT(*) AS nb, id AS id, tstime AS tstime FROM user WHERE login = :login");
	$req->execute(array("login" => $_GET['login']));
	$donnee = $req->fetch();

	if ($_GET['action'] == 'chg_pwd' AND password_verify($donnee['id'], $_GET['token'])) {
		$delta = 86400;
		if ($_SERVER["REQUEST_TIME"] - $donnee['tstime'] < $delta) {
			$_SESSION['id'] = $donnee['id'];
			header("location: new_passw.php?id=".$donnee['id']);
			exit ;
		}
		else {
			?>
			<script language="javascript">
				alert("Le token a expiré.");
				window.location.href='login.php';
			</script>
			<?php
		}
	}
}

if (isset($_POST['passwd']) AND isset($_POST['passwd2'])) {
	if (strcmp($_POST['passwd'], $_POST['passwd2']) == 0) {
		$req = $db->prepare('UPDATE user SET password = :pwd WHERE id = :id');
		$req->execute(array(
			"pwd" => password_hash($_POST['passwd'], PASSWORD_DEFAULT),
			"id" => $_SESSION['id']));
		header('Location: index.php');
		exit ;
	}
}

function	find_user_by_email($db, $email)
{
	$req = $db->prepare("SELECT COUNT(*) AS nb, login AS login, id AS id FROM user WHERE email = :email GROUP BY login, id");
	$req->execute(array("email" => $email));
	$donnee = $req->fetch();

	if ($donnee['nb'] == 1) {
		$token = creat_token($db, $donnee['id'], $email);
		send_reset_pwd_email($email, $donnee['login'], $token);
		header('Location: login.php');
		exit ;
	}
	else
		?>
		<script language="javascript">
			alert("Pas d'adresse email correspondant.");
		</script>
		<?php
}

function	creat_token($db, $id, $email) {
	$token = password_hash($id, PASSWORD_DEFAULT);
	$req = $db->prepare("UPDATE user SET token = :tok, tstime = :tst WHERE email = :email");
	$req->execute(array(
		"tok" => $token,
		"tst" => $_SERVER["REQUEST_TIME"],
		"email" => $email
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

	$subject = "Réinitialisation de mot de passe";
	$message_html = "<HTML><BODY><FONT FACE='Arial, Verdana' SIZE=2>Bonjour ".$login.",<br/>";
	$message_html .= "Si tu as bien fait une demande pour réinitialiser ton mot de passe, tu peut cliquer";
	$message_html .= "<a href='http://localhost:8080/Camagru/edit_account.php?action=chg_pwd&login=".$login."&token=".$token."'> ici.</a></BODY></HTML>";
	
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