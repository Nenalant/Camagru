
function	firstpwd() {
	var	pass1 = document.getElementById('pass1');
	var	messg = document.getElementById('confmsg');
	var img = document.createElement('IMG');
	var goodColor = "#66cc66";
    var badColor = "#ff6666";
	
	if (pass1.value.length >= 6) {
    	pass1.style.backgroundColor = goodColor;
    	messg.style.color = goodColor;
    	messg.innerHTML = null;
    	img.src = "img/website_img/checked.png";
    	img.id = "check";
    	document.getElementById("confmsg").appendChild(img);
    }
    else {
    	messg.style.color = badColor;
    	messg.innerHTML = "Trop Court !";
    }
}

function	checkpwd() {
	var	pass1 = document.getElementById('pass1');
	var	pass2 = document.getElementById('pass2');
	var	messg = document.getElementById('confmsg_2');
	var img = document.createElement('IMG');
	var goodColor = "#66cc66";
    var badColor = "#ff6666";

    if (pass1.value == pass2.value) {
    	pass2.style.backgroundColor = goodColor;
    	messg.style.color = goodColor;
    	messg.innerHTML = null;
    	img.src = "img/website_img/checked.png";
    	img.id = "check";
    	document.getElementById("confmsg_2").appendChild(img);
    }
    else {
    	messg.style.color = badColor;
    	messg.innerHTML = null;
    	img.src = "img/website_img/redcross.png";
    	img.id = "check";
    	document.getElementById("confmsg_2").appendChild(img);
    }
}

function    compare_pwd() {
    var pass1 = document.getElementById('pass1');
    var pass2 = document.getElementById('pass2');

    if (pass1.value == pass2.value) {
        return true;
    }
    else {
        alert("Les mots de passe de diffèrent.");
        return false;
    }
}