<html>
<head>
	<title>Sing Up - Camagru</title>
	<link rel="stylesheet" href="index.css" type="text/css">
	<script type="text/javascript" src="check_info_ajax.js"></script>
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
		<form onsubmit="event.preventDefault(); return check_bd_info_inscription();" action="creat_account.php" method="post" class="Form" href="index.php" id="form_creat_log">
		<h1 class="Form-title">Welcome</h1>
			<input type="text" name="login" placeholder="Login" required="required" id="login" /><br/>
			<input type="email" name="email" placeholder="Email" required="required" id="email" /><br/>
			<input type="password" name="passwd" placeholder="Password" required="required" pattern=".{6,}" /><br/>
			<input type="submit" class="sub_button" name="submit" value="Sign Up" /><br/>
			<p id="or">or <a href="login.php" class="link">Log In</a> your account</p>
		</form>
	</div>
	<div class="footer"><p id="footer_text">alanteri@42  - 2018</p></div>
</body>
</html>