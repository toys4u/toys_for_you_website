<?
// Rainbo Design PHP Thumbnail Maker
// Copyright (C) 2005-2010 by Richard L. Trethewey - rick@rainbo.net
// All Rights Reserved
// If you use this script, I'd appreciate a link!
// http://www.rainbodesign.com/pub/

// Defaults
$thumbsize = 150;	 // Default thumbnail width.
$imagesource = 'images/default_img.jpg';	// Default image file name.
// Set to empty string for no image output on failure.
$error = '';

if (isset($_GET['width'])) { $thumbsize = $_GET['width']; }
if (isset($_GET['src'])) { $imagesource = $_GET['src']; }

$filetype = substr($imagesource,strlen($imagesource)-4,4);
$filetype = strtolower($filetype);

if (file_exists($imagesource)) {

if($filetype == ".gif") $image = @imagecreatefromgif($imagesource); 
if($filetype == ".jpg") $image = @imagecreatefromjpeg($imagesource); 
if($filetype == ".png") $image = @imagecreatefrompng($imagesource);

$imagewidth = imagesx($image);
$imageheight = imagesy($image); 

if ($imagewidth >= $thumbsize) {
$thumbwidth = $thumbsize;
$factor = $thumbsize / $imagewidth;
$thumbheight = floor($imageheight * $factor);
} else {
$thumbwidth = $imagewidth;
$thumbheight = $imageheight;
$factor = 1;
}

// Create a thumbnail-sized GD Image object
$thumb = @imagecreatetruecolor($thumbwidth,$thumbheight);

// bool imagecopyresized ( resource dst_image, resource src_image, int dst_x, int dst_y, int src_x, int src_y, int dst_w, int dst_h, int src_w, int src_h )
imagecopyresized($thumb, $image, 0, 0, 0, 0, $thumbwidth, $thumbheight, $imagewidth, $imageheight);

// Send output to user as a jpeg type, regardless of original type
header("Content-type:image/jpeg;");
imagejpeg($thumb);
imagedestroy($image);
imagedestroy($thumb);
} else {
$error = "File $imagesource Not Found";
} // endif file_exists

if ($error != '') {
header('Content-type:text/plain;');
echo($error);
exit;
} // endif $error

?>
