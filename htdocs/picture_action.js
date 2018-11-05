
function	sub_comm(elem) {
	var com_text = elem.elements["one_com"];
	var	pic = com_text.id;
	var xhr = getXMLHttpRequest();

	xhr.open("POST", "comment.php", true);
 	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

 	xhr.onreadystatechange = function() {
	    if (xhr.readyState == 4) {
			if (xhr.status == 200) {
				alert("Ton com a été publié !");
			}
			else if (xhr.status == 400) {
				console.log('There was an error 400');
			}
			else {
				console.log('something else other than 200 was returned');
			}
	    }
	    else {
	       // console.log('XMLHttpRequest not send.');
	    }
	};
 	xhr.send("the_com=" + com_text.value + "&pic=" + pic);
 	return (false);
}

function	comment_published() {
	alert("Votre commentaire a été publié !");
}

function	must_be_connected () {
	alert("Connectez vous pour aimer les photos");
}

function	liku_color(elem) {

	var	num = elem.id;
	var xhr = getXMLHttpRequest();
	var happy_face = document.getElementById(elem.id);
	var	happy_like = elem;

	xhr.open("POST", "like.php", true);
 	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	xhr.onreadystatechange = function() {
	    if (xhr.readyState == 4) {
			if (xhr.status == 200) {
				if (xhr.responseText == 1) {
					if (happy_like.classList.contains('happylike')) {
						happy_like.classList.remove('happylike');
						happy_like.classList.add('happy_fullike');
					}
				}
				else if (xhr.responseText == 0) {
					if (happy_like.classList.contains('happy_fullike'))
						happy_like.classList.remove('happy_fullike');
						happy_like.classList.add('happylike');
				}
			}
			else if (xhr.status == 400) {
				console.log('There was an error 400');
			}
			else {
				console.log('something else other than 200 was returned');
			}
	    }
	    else {
	       console.log('XMLHttpRequest not send.');
	    }
	};
 	xhr.send("src_for_face=" + num);
}

function	how_much_likes(elem) {

	liku_color(elem);
	var	num = elem.id;
	var num_likes = document.getElementById('num_likes' + elem.id);
	var xhr = getXMLHttpRequest();

  xhr.open("POST", "like.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	xhr.onreadystatechange = function() {
	    if (xhr.readyState == 4) {
			if (xhr.status == 200) {
				num_likes.innerHTML = xhr.responseText;
			}
			else if (xhr.status == 400) {
				console.log('There was an error 400');
			}
			else {
				console.log('something else other than 200 was returned');
			}
	    }
	    else {
	       console.log('XMLHttpRequest not send.');
	    }
	};

  xhr.send("src_picture=" + num);
}

function like_pic(elem) {
	var num_likes = document.getElementById('num_likes' + elem.id);
	var happy_like = elem;
	var add_like;

	if (happy_like.classList.contains('happylike')) {
		happy_like.classList.remove('happylike');
		happy_like.classList.add('happy_fullike');
		num_likes.innerHTML++;
		add_like = 1;
	}
	else if (happy_like.classList.contains('happy_fullike')) {
		happy_like.classList.remove('happy_fullike');
		happy_like.classList.add('happylike');
		num_likes.innerHTML--;
		add_like = 0;
	}
	load_likes(elem.id, add_like, num_likes);
}

function  load_likes(elem, add_like, num_likes) {
  var xhr = getXMLHttpRequest();

  xhr.open("POST", "like.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	xhr.onreadystatechange = function() {
	    if (xhr.readyState == 4) {
			if (xhr.status == 200) {
				num_likes.innerHTML = xhr.responseText;
				console.log("xhr response text ==" + xhr.responseText);
			}
			else if (xhr.status == 400) {
				console.log('There was an error 400');
			}
			else {
				console.log('something else other than 200 was returned');
			}
	    }
	    else {
	       console.log('XMLHttpRequest not send.');
	    }
	};

  xhr.send("src_pic=" + elem + "&add=" + add_like);
}

function getXMLHttpRequest() {
    var xhr = null;
    
    if (window.XMLHttpRequest || window.ActiveXObject) {
        if (window.ActiveXObject) {
            try {
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
            } catch(e) {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
        } else {
            xhr = new XMLHttpRequest();
        }
    } else {
        alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
        return null;
    }
    return xhr;
}
