
function    check_bd_info_inscription() {
    var xhr = getXMLHttpRequest();

    var new_login = encodeURIComponent(document.getElementById("login").value);
    var new_email = encodeURIComponent(document.getElementById("email").value);

    if (new_login == "" && new_email == "")
        return false;

    data = "new_login=" + new_login + "&new_email=" + new_email;

    xhr.open("POST", "check_info.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        var form = document.getElementById("form_creat_log");
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            if (xhr.responseText == "true") {
                alert("Changement(s) effectué(s)");
                form.submit();
                return true;
            }
            else if (xhr.responseText == "false login") {
                alert("Désolé, ce login est déjà pris.");
                return false;
            }
            else if (xhr.responseText == "false email") {
                alert("Désolé, cet email est déjà pris.");
                return false;
            }
        }
    };
    xhr.send(data);
}

function    check_bd_info() {
    var xhr = getXMLHttpRequest();

    var new_login = encodeURIComponent(document.getElementById("new_login").value);
    var new_email = encodeURIComponent(document.getElementById("new_email").value);

    if (new_login == "" && new_email == "")
        return false;

    data = "new_login=" + new_login + "&new_email=" + new_email;

    xhr.open("POST", "check_info.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        var form = document.getElementById("form_modif_login");
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            if (xhr.responseText == "true") {
                alert("Changement(s) effectué(s)");
                form.submit();
                return true;
            }
            else if (xhr.responseText == "false login") {
                alert("Désolé, ce login est déjà pris.");
                return false;
            }
            else if (xhr.responseText == "false email") {
                alert("Désolé, cet email est déjà pris.");
                return false;
            }
        }
    };
    xhr.send(data);
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