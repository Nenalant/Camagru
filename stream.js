
var streaming   = false,
    video       = document.querySelector('#video'),
    cover       = document.querySelector('#cover'),
    canvas      = document.querySelector('#canvas'),
    photo       = document.querySelector('#photo'),
    startbutton = document.querySelector('#startbutton'),
    download    = document.querySelector('#btn_download'),
    publish     = document.querySelector('#publish'),
    import_pic  = document.querySelector('#pic_send'),
    avatar_file = document.querySelector('#fileToUpload'),
    old_pic     = document.querySelector('#old_pic'),
    down_img    = document.getElementsByName('imported_pic'),
    coco        = 0;
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
    // var img = document.querySelector('#filta');
    // video.getContext("2d").drawImage(img, 0, 0, 90, 90);
  },
  function(err) {
    console.log("Camera desactivee");
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

function  put_filter_on_cam(id) {
  var filter_img = document.getElementById('webcam_filter');
  if (filter_img.hasChildNodes()) {
    filter_img.removeChild(document.getElementsByName('filter_on_stream')[0]);}

  var href_img = "img/filters/" +  id + ".png";
  node = document.createElement('img');
  node.id = id + "Image";
  node.src = href_img;
  node.alt = id;
  node.name = "filter_on_stream";

  filter_img.appendChild(node);
}

function takepicture() {

  if (photo.hasAttribute('src'))
  {
    tmp_pic_place = document.getElementById('tmp_pic');

    if (tmp_pic_place.hasChildNodes())
    {
      console.log("1");
      if (this.tmp_id == 5)
        this.tmp_id = 5;
      else
      {
        this.tmp_id += 1;
        new_img_for_pic = document.createElement('img');
      }
      new_img_for_pic.name = "tmp_img";
      new_img_for_pic.setAttribute('src', photo.src);
      new_img_for_pic.setAttribute('id', "tmp_" + this.tmp_id);
      new_img_for_pic.setAttribute('onclick', 'photo.setAttribute("src", this.src);');

      tmp_pic_place.appendChild(new_img_for_pic);
    }
    else
    {
      this.tmp_id = 1;
      console.log("2");
      node = document.createElement('img');
      node.name = "tmp_img";
      node.setAttribute('src', photo.src);
      node.setAttribute("id", "tmp_" + this.tmp_id);
      node.setAttribute('onclick', 'photo.setAttribute("src", this.src);');

      tmp_pic_place.appendChild(node);
    }
  }
  canvas.width = width;
  canvas.height = height;
  canvas.getContext("2d").drawImage(video, 0, 0, width, height);
  var img = document.getElementsByName('filter_on_stream')[0];
  canvas.getContext("2d").drawImage(img, 56, 2, 65, 65);
  var dataURL = canvas.toDataURL('image/png');
  photo.setAttribute('src', dataURL);
}

function  loadXMLDoc(photo2) {
  var xml = new XMLHttpRequest();
  var filter = node.src;
  console.log("photo2.src == " + photo2);

  xml.open("POST", "treat_img.php", true);

  xml.onreadystatechange = function() {
    if (xml.readyState == 4) {
      if (xml.status == 200) {
        photo2.innerHTML = xml.responseText;
        console.log(xml.responseText);
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
  console.log("entering treat_img");
  xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xml.send("img=" + photo2 + "&filter=" + filter);
}

function  import_file_pic() {
    $coco = 1;
    $dir = "./img/tmp_pic/";
    $file = "tmp_imported_pic";
    avatar_file = document.querySelector('#fileToUpload');
    var parent = document.querySelector('#pic_to_take');
    var parent2 = document.querySelector("#uuu");
    var parent3 = document.querySelector('#pic_taken');
    image_instead_of_video = document.createElement('img');
    parent.removeChild(document.getElementById("video"));
    // parent2.removeChild(document.getElementById("startbutton"));
    parent3.removeChild(document.getElementById("photo"));
    image_instead_of_video.name = "imported_pic";
    image_instead_of_video.src =  "./img/tmp_pic/tmppicname.jpg";
    image_instead_of_video.id = "down_img";
    console.log("parent == " + parent);
    console.log("video == " + parent.id);
    console.log("id  == " + image_instead_of_video.id);
    console.log("src == " + image_instead_of_video.src);

    parent.appendChild(image_instead_of_video);
}

startbutton.addEventListener('click', function(ev){
  if (document.getElementsByName("filter_on_stream").length == 0) {
    alert("Selectionnez un filtre");
    return ;
  }
  else {
    takepicture();
    ev.preventDefault();
  }
}, false);

publish.addEventListener('click', function(ev) {
  // if (document.getElementsByName("filter_on_stream").length == 0) {
  //   alert("Selectionnez un filtre");
  //   return ;
  // }
  // else {
    // console.log("DOWN_IMG  ====== " + down_img);
    console.log("PHOTO  ====== " + photo);
  if (photo.src)
    var pic_img = photo.src;
  else
    var pic_img = "./img/tmp_pic/tmppicname.jpg";
  console.log("pic_img HELLO == " + pic_img);
    loadXMLDoc(pic_img);
    alert("La photo a ete publiee !");
  // }
    ev.preventDefault();
}, false);

import_pic.addEventListener('click', function(ev) {
    import_file_pic();
    ev.preventDefault();
}, false);
