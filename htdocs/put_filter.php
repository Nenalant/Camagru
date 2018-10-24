<?php

$tattoo = imagecreatefrompng('./img/filters/cat_ears.png');
$pic = imagecreatefrompng('./img/user_img/index.png');

$right_marge = 10;
$bottom_marge = 10;
list($srcWidth, $srcHeight) = getimagesize($pic);
$sx = imagesx($tattoo);
$sy = imagesy($tattoo);

imagecopy($pic, $tattoo, imagesx($pic) - $sx - $right_marge, imagesy($pic) - $sy - $bottom_marge, 0, 0, imagesx($tattoo), imagesy($tattoo));

header('Content-type: image/png');
imagesavealpha($pic, true);
imagepng($pic);
imagedestroy($pic);

?>