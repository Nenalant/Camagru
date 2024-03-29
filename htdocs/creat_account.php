<?php
session_start();
require_once('info_connexion.php');
$db = bdd();

if (isset($_POST['login']) AND isset($_POST['email']) AND isset($_POST['passwd'])) {
	
		$login = htmlspecialchars($_POST['login']);
		if (($email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) == FALSE)
		{
			echo "Le format de ton email est incorrect. Inscription interrompu.";
			exit ;
		}	

		if (email_doesnt_exist_yet($email, $db) == 0) {
			if (login_doesnt_exist_yet($_POST['login'], $db) == 0) {
				if (creat_session($db, $login, $email)) {
					$id = id_user($db, $login);
					email($login, $email, password_hash($id, PASSWORD_DEFAULT));
					header('Location: check_your_mails.php');
					exit ;
				}
				else {
				?>
				<script language="javascript">
					alert("Un des champs remplis est incorrect");
				</script>
				<?php
				}
			}
			else {
				?>
				<script language="javascript">
					alert("Ce login est déjà pris.");
				</script>
				<?php
			}
	}
	else {
		?>
		<script language="javascript">
			alert("Cet email est déjà pris.");
		</script>
		<?php
	}
}

function	email_doesnt_exist_yet($email, $db) {
	$req = $db->prepare("SELECT COUNT(*) AS nb FROM user WHERE email = :email");
	$req->execute(array("email" => $email));
	$donne = $req->fetch();

	if ($donne['nb'] == 1)
		return 1;
	else
		return 0;
}

function	login_doesnt_exist_yet($login, $db) {
	$req = $db->prepare("SELECT COUNT(*) AS nb FROM user WHERE login = :login");
	$req->execute(array("login" => $login));
	$donne = $req->fetch();

	if ($donne['nb'] == 1)
		return 1;
	else
		return 0;
}

function	creat_session($db, $login, $email) {
	try {
		$req = $db->prepare('INSERT INTO user(login, email, password, tstime) VALUES(:login, :email, :password, :tstime)');

		$req->execute(array(
			'login' => $login,
			'email' => $email,
			'password' => password_hash($_POST['passwd'], PASSWORD_DEFAULT),
			'tstime' => 0));

		$req->closeCursor();
		return true;
	}
	catch (Exception $e) {
		die ('Erreur : ' . $e->getMessage());
		return false;
	}
}
?>