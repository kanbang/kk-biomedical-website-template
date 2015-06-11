<?php
	session_start();	
	$img=imagecreatefromjpeg("bgkk.jpg");
	if(isset($_GET["do"]))
		$_SESSION['security_number'] = rand(10000,99999);
	$security_number = empty($_SESSION['security_number']) ? 'error' : $_SESSION['security_number'];
	$image_text=$security_number;	
	
	$blue=$red=$green=rand(75,255);
	$text_color=imagecolorallocate($img,255-$red,255-$green,255-$blue);
	$text=imagettftext($img,16,rand(-5,10),rand(10,30),rand(25,35),$text_color,"fonts/courbd.ttf",$image_text);

	header("Content-type:image/jpeg");
	header("Content-Disposition:inline ; filename=secure.jpg");	
	imagejpeg($img);
	/* and this is all.*/
?>