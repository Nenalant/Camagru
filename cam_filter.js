
function	put_filter_on_cam(id) {
	var filter_img = document.getElementById('webcam_filter');
	if (filter_img.hasChildNodes()) {filter_img.removeChild(node);}

	var href_img = "img/filters/" +  id + ".png";
	node = document.createElement('img');
	node.id = id + "Image";
	node.src = href_img;
	node.alt = id;
	node.name = "filter_on_stream";

	filter_img.appendChild(node);
}