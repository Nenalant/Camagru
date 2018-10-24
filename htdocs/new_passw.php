<!DOCTYPE html>
<html>
<head>
	<title>New Password</title>
	<link rel="stylesheet" type="text/css" href="index.css"></link>
	<script type="text/javascript" src="checkpwd.js"></script>
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
	<h3>Modification du mot de passe<br/><br/></h3>
	  <div class="Form">
		<form onsubmit="return compare_pwd()" action="edit_account.php" method="POST" class="Form">
			<input type="password" name="passwd" id="pass1" placeholder="Password" required="required" pattern=".{6,}" onkeyup="firstpwd(); return false;">
			<span id="confmsg" class="confmsg">
			</span><br/>
			<input type="password" name="passwd2" id="pass2" placeholder="Confirm Password" required="required" pattern=".{6,}" onkeyup="checkpwd(); return false;">
			<span id="confmsg_2" class="confmsg_2">
			</span><br/>
			<input type="submit" class="sub_button" name="submit" value="Send"><br/>
		</form>
	  </div>
</body>
</html>