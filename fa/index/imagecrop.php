<?php
include 'database.php';
if($isAdmin)
{
	if(isset($_GET["mode"]))
	{
		$ajaxDir = "../";
		$image_url = $_GET["image_url"];
		$crop_x = $_GET["crop_x"];
		$crop_y = $_GET["crop_y"];
		$crop_w = $_GET["crop_w"];
		$crop_h = $_GET["crop_h"];
		$crop_zoom = $_GET["crop_zoom"];
		$image_w = $_GET["image_w"];
		$image_h = $_GET["image_h"];
		$id = $_GET["id"];
		$mode = $_GET["mode"];
		$lang = $_GET["lang"];
		
		// The file
		$filename = $ajaxDir.$image_url;
		
		// Content type
		//header('Content-Type: image/jpeg');
		
		$image = imagecreatefromstring(file_get_contents($filename));
		
		if($mode == 'product')
		{
			$crop_image = imagecreatetruecolor($crop_w, $crop_h);
			imagefilter($crop_image, IMG_FILTER_COLORIZE, 255, 255, 255);
			
			if($crop_x>0 && $crop_y>0)
			{
				$image_w = $crop_w;
				$image_h = $crop_h;
			
				imagecopyresampled($crop_image, $image,
						0, 0, ($crop_x/$crop_zoom), ($crop_y/$crop_zoom),
						$image_w, $image_h ,($crop_w/$crop_zoom),($crop_h/$crop_zoom));
			}
			else
			{
				$width = imagesx($image);
				$height = imagesy($image);
			
				imagecopyresampled($crop_image, $image,
						-$crop_x, -$crop_y, 0, 0,
						$image_w, $image_h ,$width,$height);
			}
			
			$query = mysql_query("SELECT picture, picture_thumb FROM `productbykk_".$lang."` WHERE id = '$id' ;",$db);
			if($row=mysql_fetch_row($query))
			{
				if(file_exists($ajaxDir.$row[0]))
					unlink($ajaxDir.$row[0]);
				if(file_exists($ajaxDir.$row[1]))
					unlink($ajaxDir.$row[1]);
			}
			
			$address_picture = "product/".$id."t464".rand(1000000,9999999).".jpg";
			imagejpeg($crop_image, $ajaxDir.$address_picture, 80);
			
			$width = imagesx($crop_image);
			$height = imagesy($crop_image);
			$new_width = 227;
			$new_height = 227;
			$crop_image2 = imagecreatetruecolor($new_width, $new_height);
			imagefilter($crop_image2, IMG_FILTER_COLORIZE, 255, 255, 255);
			imagecopyresampled($crop_image2, $crop_image,
					0, 0, 0, 0,
					$new_width, $new_height ,$width,$height);
			$address_picture2 = "product/".$id."t227".rand(1000000,9999999).".jpg";
			imagejpeg($crop_image2, $ajaxDir.$address_picture2, 90);
			
			$query = mysql_query("UPDATE `productbykk_".$lang."` SET picture = '$address_picture', picture_thumb = '$address_picture2' WHERE id = '$id' ;",$db);
			if(!$query)
				echo mysql_error();
		}
		else if($mode == 'slide')
		{
			$crop_image = imagecreatetruecolor($crop_w*2, $crop_h*2);
			imagefilter($crop_image, IMG_FILTER_COLORIZE, 255, 255, 255);
			
			if($crop_x>0 && $crop_y>0)
			{
				$image_w = $crop_w*2;
				$image_h = $crop_h*2;
			
				imagecopyresampled($crop_image, $image,
						0, 0, ($crop_x/$crop_zoom), ($crop_y/$crop_zoom),
						$image_w, $image_h ,($crop_w/$crop_zoom),($crop_h/$crop_zoom));
			}
			else
			{
				$width = imagesx($image);
				$height = imagesy($image);
			
				imagecopyresampled($crop_image, $image,
						-$crop_x*2, -$crop_y*2, 0, 0,
						$image_w*2, $image_h*2 ,$width,$height);
			}
			
			$query = mysql_query("SELECT picture, picture_thumb FROM `slidebykk_".$lang."` WHERE id = '$id' ;",$db);
			if($row=mysql_fetch_row($query))
			{
				if(file_exists($ajaxDir.$row[0]))
					unlink($ajaxDir.$row[0]);
				if(file_exists($ajaxDir.$row[1]))
					unlink($ajaxDir.$row[1]);
			}
			
			$address_picture = "slide/".$id."fix".rand(1000000,9999999).".jpg";
			imagejpeg($crop_image, $ajaxDir.$address_picture, 90);
			
			$width = imagesx($crop_image);
			$height = imagesy($crop_image);
			$new_width = 290;
			$new_height = 135;
			$crop_image2 = imagecreatetruecolor($new_width, $new_height);
			imagefilter($crop_image2, IMG_FILTER_COLORIZE, 255, 255, 255);
			imagecopyresampled($crop_image2, $crop_image,
					0, 0, 0, 0,
					$new_width, $new_height ,$width,$height);
			$address_picture2 = "slide/".$id."thumb".rand(1000000,9999999).".jpg";
			imagejpeg($crop_image2, $ajaxDir.$address_picture2, 90);
			
			$query = mysql_query("UPDATE `slidebykk_".$lang."` SET picture = '$address_picture', picture_thumb = '$address_picture2' WHERE id = '$id' ;",$db);
			if(!$query)
				echo mysql_error();
		}
		// Output
		//imagejpeg($crop_image, null, 100);
	}
	else 
	{
		$picture = $_GET["picture"];
		$width = $_GET["width"];
		$height = $_GET["height"];
		$command = $_GET["command"];
		$forcefull = $_GET["forcefull"];
		?>
		<div style="background-color: #fff;padding: 20px 40px;position: absolute;top:50%;left:50%;border-radius:5px;" class="container" >
			<span class="cancelbykk" id="crop-cancel">
			</span>
			<div style="height: <?php echo $height; ?>px;width: <?php echo $width; ?>px;" id="crop-layout">
				<div style="height: 400px;width:500px;" id="crop-image">
				</div>
			</div>
			<div style="margin: 0 auto;" id="crop-tools">
			</div>
			<script type="text/javascript">
			$(document).ready(function(){
				var crop = new cropbykk({
					image_url: '<?php echo $picture; ?>',
					<?php if($forcefull == 'yes') echo "forcefull:true," ; ?>
					dest:"index/imagecrop.php",
					optional_url: '<?php echo $command; ?>'
					});
		
				$("#crop-cancel").click(function(){
					$("#crop-overlay").animate({'opacity':'0'},300,function(){
						$(this).css({'display':'none'});
						$(this).children(".container").remove();
						delete crop;
					});
				});
	
				disableATag();
			});
			</script>
		</div>
	<?php 
	}
}
?>