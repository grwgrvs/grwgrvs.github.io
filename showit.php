<?php
header("Content-type: image/jpeg");
header("Expires: 0"); // set expiration time
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
// Size of the image we want in the end
$dir = urldecode($_GET['dir']);
$pathToOriginal  = urldecode($_GET['dir'] ."/". $_GET['image']);

list($width, $height, $type) = getimagesize($pathToOriginal);

$aspect_ratio = $width/$height;
$tnailW = $_GET['w'];
if(isset($_GET['h']))
{
	$tnailH = $_GET['h'];
}
else
{
	$tnailH = abs($tnailW/$aspect_ratio);
}
switch($type) { // Only handlers for JPG, GIF and PNG are defined as this is all the listing will show
case 1: // gif
  $source = imagecreatefromgif($pathToOriginal);
  break;
case 2: // jpg or jpeg or jpe
  $source = imagecreatefromjpeg($pathToOriginal);
  break;
case 3: // png
  $source = imagecreatefrompng($pathToOriginal);
  break;
default:
  exit -1;
}
// Create an ($tnailW x $tnailH)px empty image for our thumbnail.
$thumbnail = imagecreatetruecolor($tnailW, $tnailH);
// Copy and resize the whole 'source' image into the thumbnail
imagecopyresized($thumbnail, $source, 0, 0, 0, 0, $tnailW, $tnailH, $width, $height);

imagejpeg($thumbnail,NULL,100);
imagedestroy($source);
?>