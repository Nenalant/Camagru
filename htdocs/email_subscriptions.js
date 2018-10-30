
function	email_sub_like() {
	like_butt = document.getElementById("like_set_email");
	var	xhr = getXMLHttpRequest();

	xhr.open("POST", "email_subs.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	xhr.onreadystatechange = function() {
	    if (xhr.readyState == 4) {
			if (xhr.status == 200) {
				like_butt.textContent = xhr.responseText;
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
  	xhr.send("like_em=" + like_butt);
}

function	email_sub_com() {
	com_butt = document.getElementById("com_set_email");
	var	xhr = getXMLHttpRequest();

	xhr.open("POST", "email_subs.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	xhr.onreadystatechange = function() {
	    if (xhr.readyState == 4) {
			if (xhr.status == 200) {
				com_butt.textContent = xhr.responseText;
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
  	xhr.send("com_em=" + com_butt);
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