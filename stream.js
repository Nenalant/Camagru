
var streaming   = false,
    video       = document.querySelector('#video'),
    cover       = document.querySelector('#cover'),
    canvas      = document.querySelector('#canvas'),
    photo       = document.querySelector('#photo'),
    startbutton = document.querySelector('#startbutton'),
    download    = document.querySelector('#btn_download'),
    publish     = document.querySelector('#publish'); 
    width = 200,
    height = 0;

navigator.getUserMedia = ( navigator.getUserMedia ||
                       navigator.webkitGetUserMedia ||
                       navigator.mozGetUserMedia ||
                       navigator.msGetUserMedia);

navigator.getUserMedia(
  { 
    video: true, 
    audio: false 
  },
  function(stream) {
    if (navigator.mozGetUserMedia) {
      video.srcObject = stream;
    } 
    else {
      var vendorURL = window.URL || window.webkitURL;
      video.src = vendorURL ? vendorURL.createObjectURL(stream) : stream;
    }
    video.play();
    var img = document.querySelector('#filta');
    video.getContext("2d").drawImage(img, 0, 0, 90, 90);
  },
  function(err) {
    console.log("An error occured! " + err);
  }
);

video.addEventListener('canplay', function(ev){
  if (!streaming) {
    height = video.videoHeight / (video.videoWidth/width);
    video.setAttribute('width', width);
    video.setAttribute('height', height);
    canvas.setAttribute('width', width);
    canvas.setAttribute('height', height);
    streaming = true;
  }
}, false);

download.addEventListener('click', function() {
  var dataDown = canvas.toDataURL('image/png');
  download.href = dataDown;
}, false);

function takepicture() {
  canvas.width = width;
  canvas.height = height;
  canvas.getContext('2d').drawImage(video, 0, 0, width, height);
  var img = document.querySelector('#filta');
  canvas.getContext("2d").drawImage(img, 0, 0, 90, 90);
  var dataURL = canvas.toDataURL('image/png');

  photo.setAttribute('src', dataURL);
}

function  loadXMLDoc(photo)
{
  var xml = new XMLHttpRequest();

  xml.onreadystatechange = function() {
    if (xml.readyState == 4) {
      if (xml.status == 200) {
        photo.innerHTML = xml.responseText;
      }
      else if (xml.status == 400) {
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
  xml.open("POST", "treat_img.php", true);
  xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xml.send("img=" + photo);
}

startbutton.addEventListener('click', function(ev){
    takepicture();
    ev.preventDefault();
}, false);

publish.addEventListener('click', function(ev, dataURL) {
    loadXMLDoc(dataURL);
    ev.preventDefault();
}, false);
