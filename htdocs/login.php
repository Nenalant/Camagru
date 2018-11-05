<!DOCTYPE html>
<html>
<head>
	<title>Sing Up - Camagru</title>
	<link rel="stylesheet" type="text/css" href="index.css"></link>
</head>
<body>
	<nav>
	  <div class="navbar">
		<div class="pcontent">
		  <div class="hlogo">
				<img src="./img/website_img/mount_logo.png" id="logo"/>
		  </div>
		  <div>
				<a href="index.php"><h2>Camagru</h2></a>
		  </div>
		</div>
	  </div>
	</nav>
	<div class="Form">
		<form action="connexion.php" method="POST" class="Form">
		<h1 class="Form-title">Welcome</h1>
		
			<input type="login" name="login" placeholder="Login" required="required" pattern="[A-Za-z0-9]{1,15}" oninvalid="setCustomValidity('Les caractères spéciaux ne sont pas autorisés. Maximum 15 caractères.')" oninput="setCustomValidity('')"/><br/>
			<input type="password" name="passwd" placeholder="Password" required="required" pattern=".{6,}" oninvalid="setCustomValidity('Minimum 6 caractères.')" oninput="setCustomValidity('')" autocomplete="off"/><br/>
			<input type="submit" class="sub_button" name="submit" value="Log In" /><br/>
			<p id="or">or <a href="signin.php" class="link">Create</a> your new account</br><a href="forgot_passw.php">Forgot your password ?</a></p>
		</form>
	</div>
	<div class="footer"><p id="footer_text">alanteri@42  - 2018</p></div>
</body>
</html>
