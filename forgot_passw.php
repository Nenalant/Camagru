<!DOCTYPE html>
<html>
<head>
	<title>New Password</title>
	<link rel="stylesheet" type="text/css" href="index.css"></link>
</head>
<body>
	<header id="header">
	<a>
		<img src="./img/website_img/mount_logo.png" href="take_picture.html" id="logo"></img>	
		<a href="index.php"><h2>Camagru</h2></a>
	</a>
	</header>
	<h3>Entre ton adresse mail<br/><br/>et nous t'enverrons un lien pour reinitianilser ton mot de passe.
		<br/></h3>
		<div class="Form">
		<form action="edit_account.php" method="POST" class="Form">
			<input type="email" name="email" placeholder="Email" required="required" /><br/>
			<input type="submit" class="sub_button" name="submit" value="Send" /><br/>
		</form>
</body>
</html>