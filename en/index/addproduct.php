<?php
include 'database.php';
if($isAdmin)
{
	if($_GET["mode"] == 'add')
	{
		include 'jdf.php';
		
		$ajaxDir="../";
		
		$name = $_POST["product_name"];
		$name = mysql_real_escape_string($name);
		
		$p_note = $_POST["p_note"];
		$p_note = mysql_real_escape_string($p_note);
		
		$linkto_lang = $_POST["linkto_lang"];
		$linkto = $_POST["linkto"];
		$linkid = $_POST["linkid"];
		$linktext = $_POST["linktext"];
		if($linkto == '4')
			$linkid = $_POST["linkaddress"];
		if($linkto == '0')
			$linktext = '';
		$linkto = $linkto_lang."|".$linkto;
			
		$linkto2_lang = $_POST["linkto2_lang"];
		$linkto2 = $_POST["linkto2"];
		$linkid2 = $_POST["linkid2"];
		$linktext2 = $_POST["linktext2"];
		if($linkto2 == '4')
			$linkid2 = $_POST["linkaddress2"];
		if($linkto2 == '0')
			$linktext2 = '';
		$linkto2 = $linkto2_lang."|".$linkto2;
		
		$picture=$_FILES["picture"]["name"];
		$tmp_file=$_FILES["picture"]["tmp_name"];
		$type=$_FILES["picture"]["type"];
		
		$category = $_POST["category"];
		if($category == 'other')
		{
			$category = $_POST["category_name"];
			$category = setCategory($category);
			$category_picture = '';
		}
		else
		{
			$category = explode("|bykk|", $category);
			$category_picture = $category[1];
			$category = $category[0];
			$category = setCategory($category);
		}
		
		$sub_category = $_POST["sub_category"];
		if($sub_category == 'other')
		{
			$sub_category = $_POST["sub_category_name"];
			$sub_category = setCategory($sub_category);
			$sub_category_picture = '';
		}
		else
		{
			$sub_category = explode("|bykk|", $sub_category);
			$sub_category_picture = $sub_category[1];
			$sub_category = $sub_category[0];
			$sub_category = setCategory($sub_category);
		}
		
		$showto = $_POST["showto"];
		
		$attachment=$_FILES["attachment"]["name"];
		$attachment_file=$_FILES["attachment"]["tmp_name"];
		$attachment_type=$_FILES["attachment"]["type"];
		
		$index1_name = $_POST["index1_name"];
		$index1 = $_POST["index1"];
		if (get_magic_quotes_gpc()) $index1 = stripslashes($index1);
		$index1 = htmlspecialchars($index1, ENT_QUOTES,"UTF-8");
		
		$index2_name = $_POST["index2_name"];
		$index2 = $_POST["index2"];
		if (get_magic_quotes_gpc()) $index2 = stripslashes($index2);
		$index2 = htmlspecialchars($index2, ENT_QUOTES,"UTF-8");
		
		$index3_name = $_POST["index3_name"];
		$index3 = $_POST["index3"];
		if (get_magic_quotes_gpc()) $index3 = stripslashes($index3);
		$index3 = htmlspecialchars($index3, ENT_QUOTES,"UTF-8");
		
		$index4_name = $_POST["index4_name"];
		$index4 = $_POST["index4"];
		if (get_magic_quotes_gpc()) $index4 = stripslashes($index4);
		$index4 = htmlspecialchars($index4, ENT_QUOTES,"UTF-8");
		
		$query = mysql_query("SELECT id FROM productbykk_".$sitelang." ORDER BY id  DESC ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
			
		if( $rows=mysql_fetch_row($query) )
			$id = $rows[0] + 1;
		else
			$id = 1000;
		
		$address_picture = '';
		$thumb_name = '';
		$thumb_name2 = '';
		$original_picture = '';
		if($type == "image/jpeg" || $type == "image/png" || $type == "image/gif" )
		{
			$picture=explode(' ',$picture);
			$picture=implode('',$picture);
			$address_picture= "product/".$id.rand(1000000,9999999).".jpg";
			move_uploaded_file($tmp_file, $ajaxDir.$address_picture);
		
		
			//$image_name = $address_picture;    // Full path and image name with extension
			$thumb_name = "product/".$id."t227".rand(1000000,9999999).".jpg";	// Generated thumbnail name without extension
		
			$image = imagecreatefromstring(file_get_contents($ajaxDir.$address_picture));
		
			$filename = $ajaxDir.$thumb_name;
		
			$thumb_width = 227;
			$thumb_height = 227;
		
			$width = imagesx($image);
			$height = imagesy($image);
		
			$original_aspect = $width / $height;
			$thumb_aspect = $thumb_width / $thumb_height;
		
			if ( $original_aspect >= $thumb_aspect )
			{
				// If image is wider than thumbnail (in aspect ratio sense)
				$new_height = $thumb_height;
				$new_width = $width / ($height / $thumb_height);
			}
			else
			{
				// If the thumbnail is wider than the image
				$new_width = $thumb_width;
				$new_height = $height / ($width / $thumb_width);
			}
		
			$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
		
			// Resize and crop
			imagecopyresampled($thumb,
					$image,
					0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
					0 - ($new_height - $thumb_height) / 2, // Center the image vertically
					0, 0,
					$new_width, $new_height,
					$width, $height);
			imagejpeg($thumb, $filename, 90);
				
			$thumb_name2 = "product/".$id."t464".rand(1000000,9999999).".jpg";   // Generated thumbnail name without extension
				
			$image = imagecreatefromstring(file_get_contents($ajaxDir.$address_picture));
				
			$filename = $ajaxDir.$thumb_name2;
				
			$thumb_width = 464;
			$thumb_height = 464;
				
			$width = imagesx($image);
			$height = imagesy($image);
				
			$original_aspect = $width / $height;
			$thumb_aspect = $thumb_width / $thumb_height;
				
			if ( $original_aspect >= $thumb_aspect )
			{
				// If image is wider than thumbnail (in aspect ratio sense)
				$new_height = $thumb_height;
				$new_width = $width / ($height / $thumb_height);
			}
			else
			{
				// If the thumbnail is wider than the image
				$new_width = $thumb_width;
				$new_height = $height / ($width / $thumb_width);
			}
				
			$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
				
			// Resize and crop
			imagecopyresampled($thumb,
					$image,
					0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
					0 - ($new_height - $thumb_height) / 2, // Center the image vertically
					0, 0,
					$new_width, $new_height,
					$width, $height);
			imagejpeg($thumb, $filename, 80);
				
			//unlink($ajaxDir.$address_picture);
			$original_picture = $address_picture;
		}
		
		if(is_array($_FILES['other_pictures']))
		{
			$other_pictures_t9060 = '';
			$other_pictures_t485 = '';
			$file_ary = reArrayFiles($_FILES['other_pictures']);
			foreach ($file_ary as $file)
			{
				$address_pictures = '';
				$thumb_names = '';
				$pictures = $file["name"];
				$types=$file["type"];
				$tmp_files=$file["tmp_name"];
				if($types == "image/jpeg" || $types == "image/png" || $types == "image/gif" )
				{
					$pictures=explode(' ',$pictures);
					$pictures=implode('',$pictures);
					$address_pictures= $id.rand(1000000,9999999).".jpg";
					move_uploaded_file($tmp_files, $ajaxDir."product/".$address_pictures);
				  
				  
					//$image_name = $address_picture;    // Full path and image name with extension
					$thumb_names = "t".$id.rand(1000000,9999999).".jpg";   // Generated thumbnail name without extension
				  
					$image = imagecreatefromstring(file_get_contents($ajaxDir."product/".$address_pictures));
				  
					$filename = $ajaxDir."product/".$thumb_names;
				  
					$thumb_width = 90;
					$thumb_height = 60;
				  
					$width = imagesx($image);
					$height = imagesy($image);
				  
					$original_aspect = $width / $height;
					$thumb_aspect = $thumb_width / $thumb_height;
				  
					if ( $original_aspect >= $thumb_aspect )
					{
						// If image is wider than thumbnail (in aspect ratio sense)
						$new_height = $thumb_height;
						$new_width = $width / ($height / $thumb_height);
					}
					else
					{
						// If the thumbnail is wider than the image
						$new_width = $thumb_width;
						$new_height = $height / ($width / $thumb_width);
					}
				  
					$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
				  
					// Resize and crop
					imagecopyresampled($thumb,
							$image,
							0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
							0 - ($new_height - $thumb_height) / 2, // Center the image vertically
							0, 0,
							$new_width, $new_height,
							$width, $height);
					imagejpeg($thumb, $filename, 80);
					//////////
					$other_pictures_t9060 = $other_pictures_t9060.$thumb_names."|";
					//////////
					$thumb_names = "lt".$id.rand(1000000,9999999).".jpg";   // Generated thumbnail name without extension
				  
					$image = imagecreatefromstring(file_get_contents($ajaxDir."product/".$address_pictures));
				  
					$filename = $ajaxDir."product/".$thumb_names;
					 
					$thumb_width = 485;
					$thumb_height = 485;
					 
					$width = imagesx($image);
					$height = imagesy($image);
					 
					$original_aspect = $width / $height;
					$thumb_aspect = $thumb_width / $thumb_height;
					 
					if ( $original_aspect >= $thumb_aspect )
					{
						$new_height = $thumb_width/$original_aspect;
						$new_width = $thumb_width;
					}
					else
					{
						$new_height = $thumb_height;
						$new_width = $thumb_height*$original_aspect;
					}
					 
					$thumb = imagecreatetruecolor($new_width,$new_height);
					 
					// Resize and crop
					imagecopyresampled($thumb,
							$image,
							0, 0,
							0, 0,
							$new_width, $new_height,
							$width, $height);
					imagejpeg($thumb, $filename, 80);
					/////////
					$other_pictures_t485 = $other_pictures_t485.$thumb_names."|";
					/////////
					unlink($ajaxDir."product/".$address_pictures);
				}
			}
		}
		
		$whocandl = $_POST["whocandl"];
		$address_attachments = '';
		if(is_array($_FILES['attachments']))
		{
			$file_ary = reArrayFiles($_FILES['attachments']);
			foreach ($file_ary as $file)
			{
				$attach = '';
				$attachment = $file["name"];
				$attachment_type=$file["type"];
				$attachment_file=$file["tmp_name"];
				if($attachment != '' && $attachment_type != 'php' && $attachment_type != 'asp' && $attachment_type != 'aspx')
				{
					$attachment=explode(' ',$attachment);
					$attachment=implode('',$attachment);
					$attach= $id."dl".$attachment;
					if(!move_uploaded_file($attachment_file, $ajaxDir."product/attachment/".$attach))
					{
						if(file_exists($ajaxDir."product/attachment/".$attach))
							unlink($ajaxDir."product/attachment/".$attach);
					}
					else
					{
						$address_attachments = $address_attachments.$attach."|";
					}
				}
			}
		}
		
		if(strlen($index1_name)>=2)
		{
			$address_index1="product/".$id."index1.dtx" ;
			$index1=explode(chr(13),$index1);
			$f=fopen($ajaxDir.$address_index1 , "w");
			foreach($index1 as $buf )
			{
				fputs($f , $buf);
			}
			fclose($f);
		}
		
		if(strlen($index2_name)>=2)
		{
			$address_index2="product/".$id."index2.dtx" ;
			$index2=explode(chr(13),$index2);
			$f=fopen($ajaxDir.$address_index2 , "w");
			foreach($index2 as $buf )
			{
				fputs($f , $buf);
			}
			fclose($f);
		}
		
		if(strlen($index3_name)>=2)
		{
			$address_index3="product/".$id."index3.dtx" ;
			$index3=explode(chr(13),$index3);
			$f=fopen($ajaxDir.$address_index3 , "w");
			foreach($index3 as $buf )
			{
				fputs($f , $buf);
			}
			fclose($f);
		}
		
		if(strlen($index4_name)>=2)
		{
			$address_index4="product/".$id."index4.dtx" ;
			$index4=explode(chr(13),$index4);
			$f=fopen($ajaxDir.$address_index4 , "w");
			foreach($index4 as $buf )
			{
				fputs($f , $buf);
			}
			fclose($f);
		}
		
		$date = date("F d, Y");
		$time = date("G:i");
		$jdate = jdate("j F Y");
		$jtime = jdate("G:i");
		
		$sql = "INSERT INTO `productbykk_".$sitelang."` (`id`, `name`, `p_note`, `category`, `category_picture`, `sub_category`, `sub_category_picture`, 
		`original_picture`, `picture`, `picture_thumb`,`other_pictures`, `other_pictures_thumb`, `index1_name`, `index1`, `index2_name`, 
		`index2`, `index3_name`, `index3`, `index4_name`, `index4`, `attachments`, `whocandl`, `linkto`, `linkid`, `linktext`, `linkto2`, 
		`linkid2`, `linktext2`, `highlight`, `showto`, `date`, `time`, `jdate`, `jtime`, `state`)
		VALUES ('$id', '$name', '$p_note', '$category', '$category_picture', '$sub_category', '$sub_category_picture', '$original_picture', 
		'$thumb_name2', '$thumb_name', '$other_pictures_t485', '$other_pictures_t9060', '$index1_name', '$address_index1', '$index2_name', 
		'$address_index2', '$index3_name', '$address_index3', '$index4_name', '$address_index4' , '$address_attachments', '$whocandl', '$linkto', '$linkid', '$linktext', '$linkto2', 
		'$linkid2', '$linktext2', '0', '$showto' , '$date' , '$time', '$jdate' , '$jtime', '1');";
		
		$result = mysql_query($sql, $db);
		if($result == false )
			echo mysql_error();
		else
		{
			?>
			<img alt="correct" src="../images/correct.png" style="float: left;position: relative;height: 60px;"/>
			<div style="font-size: 15px;color: #333;padding: 20px 5px;font-weight: bold;float:left;">Product Added</div>
			<script>
			setTimeout(function(){
				gotoPage('full',500,'index/product.php');
			},1000);
			</script>
			<?php
			$category_picture=$_FILES["category_picture"]["name"];
			$category_file=$_FILES["category_picture"]["tmp_name"];
			$category_type=$_FILES["category_picture"]["type"];
			
			if($category_type == "image/jpeg" || $category_type == "image/png" || $category_type == "image/gif" )
			{
				$category_picture=explode(' ',$category_picture);
				$category_picture=implode('',$category_picture);
				$address_category_picture= "product/".$id.rand(1000000,9999999).".jpg";
				move_uploaded_file($category_file, $ajaxDir.$address_category_picture);
				
				$thumb_names = "product/category/category".$id.rand(1000000,9999999).".jpg";   // Generated thumbnail name without extension
				$image = imagecreatefromstring(file_get_contents($ajaxDir.$address_category_picture));
				$filename = $ajaxDir.$thumb_names;
				
				$thumb_width = 140;
				$thumb_height = 140;
				
				$width = imagesx($image);
				$height = imagesy($image);
				
				$original_aspect = $width / $height;
				$thumb_aspect = $thumb_width / $thumb_height;
				
				if ( $original_aspect >= $thumb_aspect )
				{
					$new_height = $thumb_width/$original_aspect;
					$new_width = $thumb_width;
				}
				else
				{
					$new_height = $thumb_height;
					$new_width = $thumb_height*$original_aspect;
				}
				
				$thumb = imagecreatetruecolor($new_width,$new_height);
				
				// Resize and crop
				imagecopyresampled($thumb,
						$image,
						0, 0,
						0, 0,
						$new_width, $new_height,
						$width, $height);
				imagejpeg($thumb, $filename, 80);
				
				unlink($ajaxDir.$address_category_picture);
				
				$address_category_picture = $thumb_names;
				
				$query = mysql_query("UPDATE `productbykk_".$sitelang."` SET category_picture = '$address_category_picture' WHERE category = '$category' ;",$db);
				if(!$query)
					echo mysql_error();
			}
			
			$sub_category_picture=$_FILES["sub_category_picture"]["name"];
			$sub_category_file=$_FILES["sub_category_picture"]["tmp_name"];
			$sub_category_type=$_FILES["sub_category_picture"]["type"];
				
			if($sub_category_type == "image/jpeg" || $sub_category_type == "image/png" || $sub_category_type == "image/gif" )
			{
				$sub_category_picture=explode(' ',$sub_category_picture);
				$sub_category_picture=implode('',$sub_category_picture);
				$address_sub_category_picture= "product/".$id.rand(1000000,9999999).".jpg";
				move_uploaded_file($sub_category_file, $ajaxDir.$address_sub_category_picture);
			
				$thumb_names = "product/category/sub_category".$id.rand(1000000,9999999).".jpg";   // Generated thumbnail name without extension
				$image = imagecreatefromstring(file_get_contents($ajaxDir.$address_sub_category_picture));
				$filename = $ajaxDir.$thumb_names;
			
				$thumb_width = 140;
				$thumb_height = 140;
			
				$width = imagesx($image);
				$height = imagesy($image);
			
				$original_aspect = $width / $height;
				$thumb_aspect = $thumb_width / $thumb_height;
			
				if ( $original_aspect >= $thumb_aspect )
				{
					$new_height = $thumb_width/$original_aspect;
					$new_width = $thumb_width;
				}
				else
				{
					$new_height = $thumb_height;
					$new_width = $thumb_height*$original_aspect;
				}
			
				$thumb = imagecreatetruecolor($new_width,$new_height);
			
				// Resize and crop
				imagecopyresampled($thumb,
						$image,
						0, 0,
						0, 0,
						$new_width, $new_height,
						$width, $height);
				imagejpeg($thumb, $filename, 80);
			
				unlink($ajaxDir.$address_sub_category_picture);
			
				$address_sub_category_picture = $thumb_names;
			
				$query = mysql_query("UPDATE `productbykk_".$sitelang."` SET sub_category_picture = '$address_sub_category_picture' WHERE sub_category = '$sub_category' ;",$db);
				if(!$query)
					echo mysql_error();
			}
		}
		
	}
	else if($_GET["mode"] == 'edit' || $_GET["mode"] == 'applyedit')
	{
		?>
		<div style="opacity:0;width: 100%;height: 100%;" id="index-loader">
		<?php
		if($_GET["mode"] == 'applyedit')
		{
			include 'jdf.php';
			
			$ajaxDir="../";
			
			$id = $_POST["id"];
			
			$name = $_POST["product_name"];
			$name = mysql_real_escape_string($name);
			
			$p_note = $_POST["p_note"];
			$p_note = mysql_real_escape_string($p_note);
			
			$linkto_lang = $_POST["linkto_lang"];
			$linkto = $_POST["linkto"];
			$linkid = $_POST["linkid"];
			$linktext = $_POST["linktext"];
			if($linkto == '4')
				$linkid = $_POST["linkaddress"];
			if($linkto == '0')
				$linktext = '';
			$linkto = $linkto_lang."|".$linkto;
				
			$linkto2_lang = $_POST["linkto2_lang"];
			$linkto2 = $_POST["linkto2"];
			$linkid2 = $_POST["linkid2"];
			$linktext2 = $_POST["linktext2"];
			if($linkto2 == '4')
				$linkid2 = $_POST["linkaddress2"];
			if($linkto2 == '0')
				$linktext2 = '';
			$linkto2 = $linkto2_lang."|".$linkto2;
			
			$picture=$_FILES["picture"]["name"];
			$tmp_file=$_FILES["picture"]["tmp_name"];
			$type=$_FILES["picture"]["type"];
			$default_original_picture = $_POST["default_original_picture"];
			$default_picture = $_POST["default_picture"];
			$default_picture_thumb = $_POST["default_picture_thumb"];
			
			$category = $_POST["category"];
			if($category == 'other')
			{
				$category = $_POST["category_name"];
				$category = setCategory($category);
				$category_picture = '';
			}
			else
			{
				$category = explode("|bykk|", $category);
				$category_picture = $category[1];
				$category = $category[0];
				$category = setCategory($category);
			}
			
			$sub_category = $_POST["sub_category"];
			if($sub_category == 'other')
			{
				$sub_category = $_POST["sub_category_name"];
				$sub_category = setCategory($sub_category);
				$sub_category_picture = '';
			}
			else
			{
				$sub_category = explode("|bykk|", $sub_category);
				$sub_category_picture = $sub_category[1];
				$sub_category = $sub_category[0];
				$sub_category = setCategory($sub_category);
			}
				
			$showto = $_POST["showto"];
			
			$attachment=$_FILES["attachment"]["name"];
			$attachment_file=$_FILES["attachment"]["tmp_name"];
			$attachment_type=$_FILES["attachment"]["type"];
			
			$index1_name = $_POST["index1_name"];
			$index1 = $_POST["index1"];
			if (get_magic_quotes_gpc()) $index1 = stripslashes($index1);
			$index1 = htmlspecialchars($index1, ENT_QUOTES,"UTF-8");
			
			$index2_name = $_POST["index2_name"];
			$index2 = $_POST["index2"];
			if (get_magic_quotes_gpc()) $index2 = stripslashes($index2);
			$index2 = htmlspecialchars($index2, ENT_QUOTES,"UTF-8");
			
			$index3_name = $_POST["index3_name"];
			$index3 = $_POST["index3"];
			if (get_magic_quotes_gpc()) $index3 = stripslashes($index3);
			$index3 = htmlspecialchars($index3, ENT_QUOTES,"UTF-8");
			
			$index4_name = $_POST["index4_name"];
			$index4 = $_POST["index4"];
			if (get_magic_quotes_gpc()) $index4 = stripslashes($index4);
			$index4 = htmlspecialchars($index4, ENT_QUOTES,"UTF-8");
			
			$picture_to_delete = $_POST["picture_to_delete"];
			$other_pictures = $_POST["default_other_pictures"];
			$other_pictures_thumb = $_POST["default_other_pictures_thumb"];
			
			
			if($_POST["delete_picture"])
			{
				if($default_picture != '')
					unlink($ajaxDir.$default_picture);
				if($default_picture_thumb != '')
					unlink($ajaxDir.$default_picture_thumb);
				if($default_original_picture != '')
					unlink($ajaxDir.$default_original_picture);
				$address_picture = '';
				$thumb_name = '';
				$thumb_name2 = '';
				$original_picture = '';
			}
			else
			{
				$thumb_name2 = $default_picture;
				$thumb_name = $default_picture_thumb;
				$original_picture = $default_original_picture;
			}
			if($picture != '')
			{
				if($type == "image/jpeg" || $type == "image/png" || $type == "image/gif" )
				{
					$picture=explode(' ',$picture);
					$picture=implode('',$picture);
					$address_picture= "product/".$id.rand(1000000,9999999).".jpg";
					move_uploaded_file($tmp_file, $ajaxDir.$address_picture);
				
				
					//$image_name = $address_picture;    // Full path and image name with extension
					$thumb_name = "product/".$id."t227".rand(1000000,9999999).".jpg";   // Generated thumbnail name without extension
				
					$image = imagecreatefromstring(file_get_contents($ajaxDir.$address_picture));
				
					$filename = $ajaxDir.$thumb_name;
				
					$thumb_width = 227;
					$thumb_height = 227;
				
					$width = imagesx($image);
					$height = imagesy($image);
				
					$original_aspect = $width / $height;
					$thumb_aspect = $thumb_width / $thumb_height;
				
					if ( $original_aspect >= $thumb_aspect )
					{
						// If image is wider than thumbnail (in aspect ratio sense)
						$new_height = $thumb_height;
						$new_width = $width / ($height / $thumb_height);
					}
					else
					{
						// If the thumbnail is wider than the image
						$new_width = $thumb_width;
						$new_height = $height / ($width / $thumb_width);
					}
				
					$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
				
					// Resize and crop
					imagecopyresampled($thumb,
							$image,
							0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
							0 - ($new_height - $thumb_height) / 2, // Center the image vertically
							0, 0,
							$new_width, $new_height,
							$width, $height);
					imagejpeg($thumb, $filename, 90);
				
					$thumb_name2 = "product/".$id."t464".rand(1000000,9999999).".jpg";   // Generated thumbnail name without extension
				
					$image = imagecreatefromstring(file_get_contents($ajaxDir.$address_picture));
				
					$filename = $ajaxDir.$thumb_name2;
				
					$thumb_width = 464;
					$thumb_height = 464;
				
					$width = imagesx($image);
					$height = imagesy($image);
				
					$original_aspect = $width / $height;
					$thumb_aspect = $thumb_width / $thumb_height;
				
					if ( $original_aspect >= $thumb_aspect )
					{
						// If image is wider than thumbnail (in aspect ratio sense)
						$new_height = $thumb_height;
						$new_width = $width / ($height / $thumb_height);
					}
					else
					{
						// If the thumbnail is wider than the image
						$new_width = $thumb_width;
						$new_height = $height / ($width / $thumb_width);
					}
				
					$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
				
					// Resize and crop
					imagecopyresampled($thumb,
							$image,
							0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
							0 - ($new_height - $thumb_height) / 2, // Center the image vertically
							0, 0,
							$new_width, $new_height,
							$width, $height);
					imagejpeg($thumb, $filename, 80);
				
					//unlink($ajaxDir.$address_picture);
					$original_picture = $address_picture;
				}
			}
			
			if(strlen($index1_name)>=2)
			{
				$address_index1="product/".$id."index1.dtx" ;
				$index1=explode(chr(13),$index1);
				$f=fopen($ajaxDir.$address_index1 , "w");
				foreach($index1 as $buf )
				{
					fputs($f , $buf);
				}
				fclose($f);
			}
			
			if(strlen($index2_name)>=2)
			{
				$address_index2="product/".$id."index2.dtx" ;
				$index2=explode(chr(13),$index2);
				$f=fopen($ajaxDir.$address_index2 , "w");
				foreach($index2 as $buf )
				{
					fputs($f , $buf);
				}
				fclose($f);
			}
			
			if(strlen($index3_name)>=2)
			{
				$address_index3="product/".$id."index3.dtx" ;
				$index3=explode(chr(13),$index3);
				$f=fopen($ajaxDir.$address_index3 , "w");
				foreach($index3 as $buf )
				{
					fputs($f , $buf);
				}
				fclose($f);
			}
			
			if(strlen($index4_name)>=2)
			{
				$address_index4="product/".$id."index4.dtx" ;
				$index4=explode(chr(13),$index4);
				$f=fopen($ajaxDir.$address_index4 , "w");
				foreach($index4 as $buf )
				{
					fputs($f , $buf);
				}
				fclose($f);
			}
			
			if($picture_to_delete != '')
			{
				$picToDeleteThumb = '';
				$picToSaveThumb = '';
				$picToDelete = '';
				$picToSave = '';
				$picture_to_delete = explode("|", $picture_to_delete);
				$other_pictures = explode("|", $other_pictures);
				$other_pictures_thumb = explode("|",$other_pictures_thumb);
				$dcheck = false;
			
				foreach ($other_pictures_thumb as $toCheck)
				{
					foreach ($picture_to_delete as $toDelete)
					{
						$dcheck = false;
							
						if($toCheck == $toDelete && strlen($toCheck) > 4 && strlen($toDelete) > 4)
						{
							$picToDeleteThumb = $picToDeleteThumb.$toCheck."|";
							$picToDelete = $picToDelete."l".$toCheck."|";
							$dcheck=true;
							break;
						}
					}
					if(!$dcheck)
					{
						if(strlen($toCheck) > 4)
						{
							$picToSaveThumb = $picToSaveThumb.$toCheck."|";
							$picToSave = $picToSave."l".$toCheck."|";
						}
					}
				}
				foreach (explode("|", $picToDeleteThumb) as $del)
				{
					if(strlen($del) > 4)
						if(file_exists($ajaxDir."product/".$del))
						unlink($ajaxDir."product/".$del);
				}
				foreach (explode("|", $picToDelete) as $del)
				{
					if(strlen($del) > 4)
						if(file_exists($ajaxDir."product/".$del))
						unlink($ajaxDir."product/".$del);
				}
			
				$other_pictures = $picToSave;
				$other_pictures_thumb = $picToSaveThumb;
			
			}
				
			$other_pictures_t9060 = $other_pictures_thumb;
			$other_pictures_t485 = $other_pictures;
			
			if(is_array($_FILES['other_pictures']))
			{
				$other_pictures_t9060 = '';
				$other_pictures_t485 = '';
				$file_ary = reArrayFiles($_FILES['other_pictures']);
				foreach ($file_ary as $file)
				{
					$address_pictures = '';
					$thumb_names = '';
					$pictures = $file["name"];
					$types=$file["type"];
					$tmp_files=$file["tmp_name"];
					if($types == "image/jpeg" || $types == "image/png" || $types == "image/gif" )
					{
						$pictures=explode(' ',$pictures);
						$pictures=implode('',$pictures);
						$address_pictures= $id.rand(1000000,9999999).".jpg";
						move_uploaded_file($tmp_files, $ajaxDir."product/".$address_pictures);
			
			
						//$image_name = $address_picture;    // Full path and image name with extension
						$thumb_names = "t".$id.rand(1000000,9999999).".jpg";   // Generated thumbnail name without extension
			
						$image = imagecreatefromstring(file_get_contents($ajaxDir."product/".$address_pictures));
			
						$filename = $ajaxDir."product/".$thumb_names;
			
						$thumb_width = 90;
						$thumb_height = 60;
			
						$width = imagesx($image);
						$height = imagesy($image);
			
						$original_aspect = $width / $height;
						$thumb_aspect = $thumb_width / $thumb_height;
			
						if ( $original_aspect >= $thumb_aspect )
						{
							// If image is wider than thumbnail (in aspect ratio sense)
							$new_height = $thumb_height;
							$new_width = $width / ($height / $thumb_height);
						}
						else
						{
							// If the thumbnail is wider than the image
							$new_width = $thumb_width;
							$new_height = $height / ($width / $thumb_width);
						}
			
						$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
			
						// Resize and crop
						imagecopyresampled($thumb,
								$image,
								0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
								0 - ($new_height - $thumb_height) / 2, // Center the image vertically
								0, 0,
								$new_width, $new_height,
								$width, $height);
						imagejpeg($thumb, $filename, 80);
						//////////
						$other_pictures_t9060 = $other_pictures_t9060.$thumb_names."|";
						//////////
						$thumb_names = "lt".$id.rand(1000000,9999999).".jpg";   // Generated thumbnail name without extension
			
						$image = imagecreatefromstring(file_get_contents($ajaxDir."product/".$address_pictures));
			
						$filename = $ajaxDir."product/".$thumb_names;
			
						$thumb_width = 485;
						$thumb_height = 485;
			
						$width = imagesx($image);
						$height = imagesy($image);
			
						$original_aspect = $width / $height;
						$thumb_aspect = $thumb_width / $thumb_height;
			
						if ( $original_aspect >= $thumb_aspect )
						{
							$new_height = $thumb_width/$original_aspect;
							$new_width = $thumb_width;
						}
						else
						{
							$new_height = $thumb_height;
							$new_width = $thumb_height*$original_aspect;
						}
			
						$thumb = imagecreatetruecolor($new_width,$new_height);
			
						// Resize and crop
						imagecopyresampled($thumb,
								$image,
								0, 0,
								0, 0,
								$new_width, $new_height,
								$width, $height);
						imagejpeg($thumb, $filename, 80);
						/////////
						$other_pictures_t485 = $other_pictures_t485.$thumb_names."|";
						/////////
						unlink($ajaxDir."product/".$address_pictures);
					}
				}
			}
			
			$attachment_to_delete = $_POST["attachment_to_delete"];
			$default_attachment = $_POST["default_attachments"];
			
			if($attachment_to_delete != '')
			{
				$attachToDelete = '';
				$attachToSave = '';
				$attachment_to_delete = explode("|", $attachment_to_delete);
				$default_attachment = explode("|", $default_attachment);
				$dcheck = false;
					
				foreach ($default_attachment as $toCheck)
				{
					foreach ($attachment_to_delete as $toDelete)
					{
						$dcheck = false;
							
						if($toCheck == $toDelete && strlen($toCheck) > 4 && strlen($toDelete) > 4)
						{
							$attachToDelete = $attachToDelete.$toCheck."|";
							$dcheck=true;
							break;
						}
					}
					if(!$dcheck)
					{
						if(strlen($toCheck) > 4)
						{
							$attachToSave = $attachToSave.$toCheck."|";
						}
					}
				}
				foreach (explode("|", $attachToDelete) as $del)
				{
					if(strlen($del) > 4)
						if(file_exists($ajaxDir."product/attachment/".$del))
						unlink($ajaxDir."product/attachment/".$del);
				}
					
				$default_attachment = $attachToSave;			
			}
			
			$whocandl = $_POST["whocandl"];
			$address_attachments = $default_attachment;
			if(is_array($_FILES['attachments']))
			{
				$file_ary = reArrayFiles($_FILES['attachments']);
				foreach ($file_ary as $file)
				{
					$attach = '';
					$attachment = $file["name"];
					$attachment_type=$file["type"];
					$attachment_file=$file["tmp_name"];
					if($attachment != '' && $attachment_type != 'php' && $attachment_type != 'asp' && $attachment_type != 'aspx')
					{
						$attachment=explode(' ',$attachment);
						$attachment=implode('',$attachment);
						$attach= $id."dl".$attachment;
						if(!move_uploaded_file($attachment_file, $ajaxDir."product/attachment/".$attach))
						{
							if(file_exists($ajaxDir."product/attachment/".$attach))
								unlink($ajaxDir."product/attachment/".$attach);
						}
						else
						{
							$address_attachments = $address_attachments.$attach."|";
						}
					}
				}
			}
			
			$sql = "UPDATE `productbykk_".$sitelang."` SET `name` = '$name', `p_note` = '$p_note', `category` = '$category', `category_picture` = '$category_picture', 
			`sub_category` = '$sub_category', `sub_category_picture` = '$sub_category_picture', `original_picture` = '$original_picture', 
			`picture` = '$thumb_name2', `picture_thumb` = '$thumb_name', `other_pictures` = '$other_pictures_t485', `other_pictures_thumb` = '$other_pictures_t9060',
			`index1_name` = '$index1_name', `index1` = '$address_index1', `index2_name` = '$index2_name', `index2` = '$address_index2',
			`index3_name` = '$index3_name', `index3` = '$address_index3', `index4_name` = '$index4_name', `index4` = '$address_index4',
			`attachments` = '$address_attachments', `whocandl` = '$whocandl', `linkto` = '$linkto' , `linkid` = '$linkid' , `linktext` = '$linktext' ,
			`linkto2` = '$linkto2' , `linkid2` = '$linkid2' , `linktext2` = '$linktext2' , `showto` = '$showto' WHERE id = '$id' ;";
			
			$query = mysql_query($sql,$db);
			if($query)
			{
				?>
				<div id="success_dialog" style="display: block;opacity:1;top: 40%;height: 60px;">
					<img alt="correct" src="../images/correct.png" style="float: left;position: relative;height: 60px;"/>
					<div style="font-size: 15px;color: #333;padding: 20px 5px;font-weight: bold;float:left;">Changes Applied!</div>
				</div>
				<script type="text/javascript">
				$("#success_dialog").click(function(){
						$(this).remove();
					});
				setTimeout(function () {
					$("#success_dialog").animate({'opacity':'0.0'},300,function(){
						$("#success_dialog").remove();
					});
				},2000);
				</script>
				<?php
				
				$category_picture=$_FILES["category_picture"]["name"];
				$category_file=$_FILES["category_picture"]["tmp_name"];
				$category_type=$_FILES["category_picture"]["type"];
					
				if($category_type == "image/jpeg" || $category_type == "image/png" || $category_type == "image/gif" )
				{
					$category_picture=explode(' ',$category_picture);
					$category_picture=implode('',$category_picture);
					$address_category_picture= "product/".$id.rand(1000000,9999999).".jpg";
					move_uploaded_file($category_file, $ajaxDir.$address_category_picture);
				
					$thumb_names = "product/category/category".$id.rand(1000000,9999999).".jpg";   // Generated thumbnail name without extension
					$image = imagecreatefromstring(file_get_contents($ajaxDir.$address_category_picture));
					$filename = $ajaxDir.$thumb_names;
				
					$thumb_width = 140;
					$thumb_height = 140;
				
					$width = imagesx($image);
					$height = imagesy($image);
				
					$original_aspect = $width / $height;
					$thumb_aspect = $thumb_width / $thumb_height;
				
					if ( $original_aspect >= $thumb_aspect )
					{
						$new_height = $thumb_width/$original_aspect;
						$new_width = $thumb_width;
					}
					else
					{
						$new_height = $thumb_height;
						$new_width = $thumb_height*$original_aspect;
					}
				
					$thumb = imagecreatetruecolor($new_width,$new_height);
				
					// Resize and crop
					imagecopyresampled($thumb,
							$image,
							0, 0,
							0, 0,
							$new_width, $new_height,
							$width, $height);
					imagejpeg($thumb, $filename, 80);
				
					unlink($ajaxDir.$address_category_picture);
				
					$address_category_picture = $thumb_names;
				
					$query = mysql_query("UPDATE `productbykk_".$sitelang."` SET category_picture = '$address_category_picture' WHERE category = '$category' ;",$db);
					if(!$query)
						echo mysql_error();
				}
					
				$sub_category_picture=$_FILES["sub_category_picture"]["name"];
				$sub_category_file=$_FILES["sub_category_picture"]["tmp_name"];
				$sub_category_type=$_FILES["sub_category_picture"]["type"];
				
				if($sub_category_type == "image/jpeg" || $sub_category_type == "image/png" || $sub_category_type == "image/gif" )
				{
					$sub_category_picture=explode(' ',$sub_category_picture);
					$sub_category_picture=implode('',$sub_category_picture);
					$address_sub_category_picture= "product/".$id.rand(1000000,9999999).".jpg";
					move_uploaded_file($sub_category_file, $ajaxDir.$address_sub_category_picture);
						
					$thumb_names = "product/category/sub_category".$id.rand(1000000,9999999).".jpg";   // Generated thumbnail name without extension
					$image = imagecreatefromstring(file_get_contents($ajaxDir.$address_sub_category_picture));
					$filename = $ajaxDir.$thumb_names;
						
					$thumb_width = 140;
					$thumb_height = 140;
						
					$width = imagesx($image);
					$height = imagesy($image);
						
					$original_aspect = $width / $height;
					$thumb_aspect = $thumb_width / $thumb_height;
						
					if ( $original_aspect >= $thumb_aspect )
					{
						$new_height = $thumb_width/$original_aspect;
						$new_width = $thumb_width;
					}
					else
					{
						$new_height = $thumb_height;
						$new_width = $thumb_height*$original_aspect;
					}
						
					$thumb = imagecreatetruecolor($new_width,$new_height);
						
					// Resize and crop
					imagecopyresampled($thumb,
							$image,
							0, 0,
							0, 0,
							$new_width, $new_height,
							$width, $height);
					imagejpeg($thumb, $filename, 80);
						
					unlink($ajaxDir.$address_sub_category_picture);
						
					$address_sub_category_picture = $thumb_names;
						
					$query = mysql_query("UPDATE `productbykk_".$sitelang."` SET sub_category_picture = '$address_sub_category_picture' WHERE category = '$category' AND sub_category = '$sub_category' ;",$db);
					if(!$query)
						echo mysql_error();
				}
			}
			else
				echo mysql_error();
		}
		
		
		
		if(isset($_GET['id']))
			$id = $_GET['id'];
		else
			$id = $_POST['id'];
			
		$query = mysql_query("SELECT * FROM productbykk_".$sitelang." WHERE state = 1 AND id = '$id' ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		if($prow=mysql_fetch_row($query))
		{
		?>
		<div id="delete_dialogP" title="Delete Product" style="display: none;">
		<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are You Sure?
		</div>
		<script type="text/javascript">
		var deletePID=0;
		
		function deleteProduct(pid)
		{
			deletePID = pid;
			$("#delete_dialogP").dialog("open");
		}

		$(function() {
			$("#delete_dialogP").dialog({
				autoOpen: false,
				resizable: false,
				height:120,
				modal: true,
				buttons: {
					"Yes": function() {
						$.get('index/addproduct.php?mode=delete&id='+deletePID,function()
						{
							gotoPage('full',500,'index/product.php');
						});
						$( this ).dialog( "close" );
					},
					"Cancel": function() {
						$( this ).dialog( "close" );
					}
				}
			});
		});
		
		$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=addproduct&id=<?php echo $id; ?>', function() {
			$("#page-nav").animate({'opacity':'1'}, 300);
			});
		
		$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
		"<div class='btn add' onclick='addProduct();' title='Add Product' ></div><div class='btn change' onclick='editProduct(<?php echo $id; ?>);' title='Edit this!' ></div><div class='btn delete' onclick='deleteProduct(<?php echo $id; ?>);' title='Delete product' ></div>"
		).animate({'opacity':'1'},300);
		var delPic = '', delAttach = '';
		function deletePicture(id)
		{
			var myObject = $(id).parent('span').parent('div');
			myObject.animate({'opacity':'0.0'},300,function (){
				delPic = delPic + myObject.attr('data') + '|';
				$('#picture_to_delete').val(delPic);
				myObject.animate({'width':'0px'},300,function (){
					myObject.remove();
				});
			});
		}
		function deleteAttachment(id)
		{
			var myObject = $(id).parent('span').parent('div');
			myObject.animate({'opacity':'0.0'},300,function (){
				delAttach = delAttach + myObject.attr('data') + '|';
				$('#attachment_to_delete').val(delAttach);
				myObject.animate({'height':'0px'},100,function (){
					myObject.remove();
				});
			});
		}
		function linklist(mode)
		{
			$('#linkidajax').load('index/slidepnlist.php?ajax=1&slink=&slang='+$("#linkto_lang").val()+'&smode='+mode,function(){
				//$("select,input").uniform();
				});
			if(mode != '0')
			{
				$("#linktext_container").slideDown(300);
				
			}
			else
			{
				$("#linktext_container").slideUp(300);
			}
				
		}
		function linklist2(mode)
		{
			$('#linkidajax2').load('index/slidepnlist.php?ajax=1&slink=2&slang='+$("#linkto2_lang").val()+'&smode='+mode,function(){
				//$("select,input").uniform();
				});
			if(mode != '0')
			{
				$("#linktext_container2").slideDown(300);
				
			}
			else
			{
				$("#linktext_container2").slideUp(300);
			}
				
		}
		function subcheck(category,subcategory)
		{
			var encodeCategory = encodeURIComponent(category);
			var encodeSubcategory = encodeURIComponent(subcategory);
			$('#sub_category_ajax').load('index/productsubcategory.php?ajax=1&psclang=en&selectedcategory='+encodeCategory+'&selectedsubcategory='+encodeSubcategory);
			$("#sub_category_img").attr("src","../images/cnoimage.jpg");
			if(category == 'other')
			{
				$("#category_img").attr("src","../images/cnoimage.jpg");
			}
			else
			{
				var category_img = category.split("|bykk|");
				category_img = category_img[1];
				if(category_img.length < 3)
					$("#category_img").attr("src","../images/cnoimage.jpg");
				else
					$("#category_img").attr("src",category_img);
			}
		}
		function subCategoryImg(subcategory)
		{
			if(subcategory == 'other')
			{
				$("#sub_category_img").attr("src","../images/cnoimage.jpg");
			}
			else
			{
				var category_img = subcategory.split("|bykk|");
				category_img = category_img[1];
				if(category_img.length < 3)
					$("#sub_category_img").attr("src","../images/cnoimage.jpg");
				else
					$("#sub_category_img").attr("src",category_img);
			}
		}
		function cropProductImage(id,picture_url)
		{
			var cropCommand = "";
			cropCommand = "&mode=product&lang=en&id="+id;
			cropCommand = encodeURIComponent(cropCommand);
			$("#crop-overlay").load('index/imagecrop.php?picture='+encodeURIComponent(picture_url)+'&width=464&height=464&command='+cropCommand,function(){
				$("#crop-overlay").css({'display':'block'}).animate({'opacity':'1'},300);
				var ccropWidth = $("#crop-overlay .container").outerWidth();
				var ccropHeight = $("#crop-overlay .container").outerHeight();
				$("#crop-overlay .container").css({'margin-left':-(ccropWidth/2)+'px','margin-top':-(ccropHeight/2)+'px'});
				
			});
		}
		</script>
		<div style="width: 100%;height: 100%;overflow: hidden;" id="addproduct-container">
			<div class="div-title">EDIT PRODUCT</div>
			<form action="index/addproduct.php?mode=applyedit" method="POST" enctype="multipart/form-data" id="addproduct_form" >
				<input type="hidden" name="id" value="<?php echo $prow[0]; ?>">
				<div class="div-row">
					<div class="input-div" >
						<div class="lable" ><span class="red" >*</span>Name</div>
						<input type="text" class="textbykk" id="product_name" name="product_name" style="width: 400px;" value="<?php echo $prow[1];?>" >
					</div>
					<div class="input-div" >
						<div class="lable" ><span class="red" >*</span>Note</div>
						<input type="text" class="textbykk" id="p_note" name="p_note" style="width: 400px;" value="<?php echo $prow[2];?>" >
					</div>
				</div>
				<div class="div-row">
					<div class="input-div">
						<div class="lable" ><span class="red" >*</span>Picture (main)</div>
						<input type="file" class="textbykk" id="picture" name="picture" style="width: 400px;" >
						<input type="hidden" name="default_original_picture" value="<?php echo $prow[7]; ?>">
						<input type="hidden" name="default_picture" value="<?php echo $prow[8]; ?>">
						<input type="hidden" name="default_picture_thumb" value="<?php echo $prow[9]; ?>">
					</div>
					<?php 
					if($prow[9] != '')
					{
						?>
						<div style="position: relative;float: left;margin-left: 25px;" id="main-picture">
							<img src="<?php echo $prow[9]; ?>" style="height:60px;float:right;box-shadow:0 1px 3px rgba(0,0,0,0.5);" />
							<span style="z-index:299;position: absolute;float: left;bottom:0px;right:0px;left:0;background-color: rgba(0,0,0,0.6);color:#fff;padding: 1px 5px;font-size: 10px;vertical-align: middle;"><input type="checkbox" name="delete_picture" style="margin: 1px;float: left;" ><span style="float: left;margin-bottom: 3px;">DEL</span></span>
							<span id="cropimage" style="z-index:299;position: absolute;float: left;top:0px;right:0px;left:0;background-color: rgba(255,255,255,0.5);color:#fff;text-align: center;height: 41px;opacity:0;display: none;"><img src="../images/cropimage.png" style="margin: 3px;cursor: pointer;" title="crop image" onclick="cropProductImage(<?php echo $prow[0];?>,'<?php echo $prow[7]; ?>');"></span>
						</div>
						<?php 
					}
					?>
				</div>
				<div class="div-row">
					<div class="input-div" style="width: 80%;" >
						<div class="lable" >Other Pictures (you can select more than 1 file)</div>
						<input type="file" class="textbykk" name="other_pictures[]" style="width: 400px;" multiple="multiple" >
						<input type="hidden" name="default_other_pictures" value="<?php echo $prow[10]; ?>">
						<input type="hidden" name="default_other_pictures_thumb" value="<?php echo $prow[11]; ?>">
						<input type="hidden" name="picture_to_delete" id="picture_to_delete" value="" >
					</div>
				</div>
				<?php 
				if(strlen($prow[11]) > 4)
				{
					$other_pictures_thumb = $prow[11];
					$other_pictures_thumb = explode("|", $other_pictures_thumb);
					$num = count($other_pictures_thumb);
				?>
				<div class="div-row" style="width: 85%;margin: 0 6.5% 0 6.3%;">
					<div id="other_pictures_container" style="height:<?php echo (floor($num/11)+1)*57; ?>px;" >
					<?php
					$other_pictures_thumb = $prow[11];
					$other_pictures_thumb = explode("|", $other_pictures_thumb);
					$i=0;
					foreach($other_pictures_thumb as $pictures)
					{
						if(strlen($pictures) > 3)
						{
						?>
						<div data="<?php echo $pictures; ?>" >
							<span><div id="<?php echo $pictures; ?>" onclick="deletePicture(this);"></div></span>
							<img src="<?php echo "product/".$pictures; ?>" >
						</div>
						<?php 
						}
					}
					?>
					</div>
				</div>
				<?php 
				}
				?>
				<div class="div-row">
					<div class="input-div" style="width: 412px;" >
						<div class="lable" ><span class="red" >*</span>Catgeory</div>
						<select class="textbykk" id="category" name="category" onchange="subcheck(this.value,'');" >
							<option  ></option>
							<?php 
							$pid = $_GET["pid"];
							$query = mysql_query("SELECT category, category_picture FROM productbykk_".$sitelang." WHERE state = 1  ORDER BY category ASC ; ", $db);
							if (!$query)
								die("Error reading query: ".mysql_error());
								
							$category = "";
							while($row=mysql_fetch_row($query))
								{
								if($category != $row[0] )
									{
										echo "
										<option value='".$row[0]."|bykk|".$row[1]."' "; 
										if($prow[3] == $row[0])
											echo " selected = 'selected'";
										echo " >".getCategory($row[0])."</option>";
										$category = $row[0];
									}
								}
							?>
							<option value="other" >Other...</option>
						</select>
						<input type="text" class="textbykk" id="category_name" name="category_name" >
					</div>
					<div class="input-div" >
						<div class="lable" >Category Picture</div>
						<input type="file" class="textbykk" id="category_picture" name="category_picture" style="width: 250px;" >
					</div>
					<?php 
					if($prow[4] != '')
					{
						?>
						<div style="position: relative;float: right;margin-right: 10px;">
							<img src="<?php echo $prow[4]; ?>" style="height:60px;float:right;box-shadow:0 1px 3px rgba(0,0,0,0.5);" id="category_img" />
						</div>
						<?php 
					}
					?>
				</div>
				<div class="div-row">
					<div class="input-div" style="width: 412px;"  id="sub_category_ajax" >
						<?php 
						$selectedcategory = $prow[3];
						$selectedsubcategory = $prow[5];
						$psclang = "en";
						include 'productsubcategory.php';
						?>
					</div>
					<div class="input-div" >
						<div class="lable" >Sub-category Picture</div>
						<input type="file" class="textbykk" id="sub_category_picture" name="sub_category_picture" style="width: 250px;" >
					</div>
					<?php 
					if($prow[6] != '')
					{
						?>
						<div style="position: relative;float: right;margin-right: 10px;">
							<img src="<?php echo $prow[6]; ?>" style="height:60px;float:right;box-shadow:0 1px 3px rgba(0,0,0,0.5);" id="sub_category_img" />
						</div>
						<?php 
					}
					?>
				</div>
				<div class="div-row">
					<div class="input-div" style="width: 80%;" >
						<div class="lable" ><span class="red" >*</span>Show to</div>
						<select class="textbykk" name="showto" id="showto" style="width: 412px;" >
							<option value="1" <?php if($prow[29] == 1) echo "selected";?> >All</option>
							<option value="2" <?php if($prow[29] == 2) echo "selected";?> >Users</option>
							<option value="3" <?php if($prow[29] == 3) echo "selected";?> >Level 1 users</option>
							<option value="4" <?php if($prow[29] == 4) echo "selected";?> >Level 2 users</option>
							<option value="5" <?php if($prow[29] == 5) echo "selected";?> >Level 3 users</option>
							<option value="0" <?php if($prow[29] == 0) echo "selected";?> >Just admins</option>
						</select>
					</div>
				</div>
				<div class="div-row">
					<div class="input-div" >
						<div class="lable" ><span class="red" >*</span>Link to #1</div>
						<select class="textbykk" id="linkto_lang" name="linkto_lang" style="width: 100px;margin-right: 5px;" >
						<?php 
							$linkto_lang = explode("|", $prow[22]);
							$linkto = $linkto_lang[1];
							$linkto_lang = $linkto_lang[0];
						?>
							<option value="fa" <?php if($linkto_lang == "fa") echo "selected";?> >Farsi</option>
							<option value="en" <?php if($linkto_lang == "en") echo "selected";?> >English</option>
							<option value="de" <?php if($linkto_lang == "de") echo "selected";?> >Germany</option>
						</select>
						<select class="textbykk" id="linkto" name="linkto" onchange="linklist(this.value);" style="width: 302px;" >
							<option value="0" <?php if($linkto == "0") echo "selected";?> >Nothing</option>
							<option value="1" <?php if($linkto == "1") echo "selected";?> >Products</option>
							<option value="2" <?php if($linkto == "2") echo "selected";?> >News/Article</option>
							<option value="3" <?php if($linkto == "3") echo "selected";?> >Gallery</option>
							<option value="4" <?php if($linkto == "4") echo "selected";?> >Web Address</option>
							<option value="5" <?php if($linkto == "5") echo "selected";?> >Customized Forms</option>
						</select>
					</div>
					<div class="input-div" id="linkidajax" >
						<?php 
						$select = explode("|", $prow[22]);
						$selectedMode = $select[1];
						$selectedID = $prow[26];
						$selectedLang = $select[0];
						$selectedLink = '';
						include 'slidepnlist.php';
						?>
					</div>
				</div>
				<div class="div-row" id="linktext_container" style="<?php if($linkto == '0') echo 'display:none;'; ?>width: 80%;overflow: hidden;min-height: 0;" >
					<div class="input-div" >
						<div class="lable" >Link text</div>
						<input class="textbykk" type="text" id="linktext" name="linktext" style="width: 400px;" value="<?php echo $prow[24]; ?>">
					</div>
				</div>
				<div class="div-row">
					<div class="input-div" >
						<div class="lable" ><span class="red" >*</span>Link to #2</div>
						<select class="textbykk" id="linkto2_lang" name="linkto2_lang" style="width: 100px;margin-right: 5px;" >
						<?php 
							$linkto2_lang = explode("|", $prow[25]);
							$linkto2 = $linkto2_lang[1];
							$linkto2_lang = $linkto2_lang[0];
						?>
							<option value="fa" <?php if($linkto2_lang == "fa") echo "selected";?> >Farsi</option>
							<option value="en" <?php if($linkto2_lang == "en") echo "selected";?> >English</option>
							<option value="de" <?php if($linkto2_lang == "de") echo "selected";?> >Germany</option>
						</select>
						<select class="textbykk" id="linkto2" name="linkto2" onchange="linklist2(this.value);" style="width: 302px;" >
							<option value="0" <?php if($linkto2 == "0") echo "selected";?> >Nothing</option>
							<option value="1" <?php if($linkto2 == "1") echo "selected";?> >Products</option>
							<option value="2" <?php if($linkto2 == "2") echo "selected";?> >News/Article</option>
							<option value="3" <?php if($linkto2 == "3") echo "selected";?> >Gallery</option>
							<option value="4" <?php if($linkto2 == "4") echo "selected";?> >Web Address</option>
							<option value="5" <?php if($linkto2 == "5") echo "selected";?> >Customized Forms</option>
						</select>
					</div>
					<div class="input-div" id="linkidajax2" >
						<?php 
						$select = explode("|", $prow[25]);
						$selectedMode = $select[1];
						$selectedID = $prow[26];
						$selectedLang = $select[0];
						$selectedLink = '2';
						include 'slidepnlist.php';
						?>
					</div>
				</div>
				<div class="div-row" id="linktext_container2" style="<?php if($linkto2 == '0') echo 'display:none;'; ?>width: 80%;overflow: hidden;min-height: 0;" >
					<div class="input-div" >
						<div class="lable" >Link text</div>
						<input class="textbykk" type="text" id="linktext2" name="linktext2" style="width: 400px;" value="<?php echo $prow[27]; ?>" >
					</div>
				</div>
				<div class="div-row" >
					<div class="input-div" >
						<div class="lable" >Attachments (you can select more than 1 file)</div>
						<input type="file" class="textbykk" id="attachments" name="attachments[]" style="width: 400px;" multiple="multiple">
						<input type="hidden" name="default_attachments" value="<?php echo $prow[20]; ?>">
						<input type="hidden" name="attachment_to_delete" id="attachment_to_delete" value="" >
					</div>
					<div class="input-div" >
						<div class="lable" >Who can download attachments?</div>
						<select class="textbykk" name="whocandl" id="whocandl" style="width: 412px;" >
							<option value="1" <?php if($prow[21] == 1) echo "selected";?> >All</option>
							<option value="2" <?php if($prow[21] == 2) echo "selected";?> >Users</option>
							<option value="3" <?php if($prow[21] == 3) echo "selected";?> >Level 1 users</option>
							<option value="4" <?php if($prow[21] == 4) echo "selected";?> >Level 2 users</option>
							<option value="5" <?php if($prow[21] == 5) echo "selected";?> >Level 3 users</option>
							<option value="0" <?php if($prow[21] == 0) echo "selected";?> >Just admins</option>
						</select>
					</div>
				</div>
				<?php 
				if(strlen($prow[20]) > 4)
				{
					//echo $prow[20];
					$attachments = $prow[20];
					$attachments = explode("|", $attachments);
					$num = count($attachments);
				?>
				<div class="div-row" style="width: 85%;margin: 0 6.5% 0 6.3%;">
					<div id="attachments_container"  >
					<?php
					$attachments = $prow[20];
					$attachments = explode("|", $attachments);
					$i=0;
					foreach($attachments as $attachment)
					{
						if(strlen($attachment) > 3)
						{
						?>
						<div data="<?php echo $attachment; ?>" class="white">
							<span><div id="<?php echo $attachment; ?>" onclick="deleteAttachment(this);"></div></span>
							<font><?php echo $attachment; ?></font>
						</div>
						<?php 
						}
					}
					?>
					</div>
				</div>
				<?php 
				}
				?>
				<div class="div-row" style="margin: 0 5% 0 5%;">
					<div id="ftabs">
						<ul>
							<li><a href="#ftabs-1">Section 1</a></li>
							<li><a href="#ftabs-2">Section 2</a></li>
							<li><a href="#ftabs-3">Section 3</a></li>
							<li><a href="#ftabs-4">Section 4</a></li>
						</ul>
						<div id="ftabs-1" style="padding: 5px;height: 205px;">
							<div class="input-div" style="height: 40px;margin: 0;padding: 2px;">
								<div class="lable" style="font-size: 11px;" >Section 1 title</div>
								<input class="textbykk" type="text" id="index1_name" name="index1_name" value="<?php echo $prow[12]; ?>" >
							</div>
							<div style="padding: 0;margin: 0;width: 100%;float: right;">
								<textarea name="index1" id="index1" ><?php
								if(strlen($prow[12]) >= 2)
								{
									$check = false;
									$f = fopen("../".$prow[13], "r");
									if($f===false)
										echo "'".$prow[13]."' doesn't exist.";
									else
										while(!feof($f))
										{
											$buf = fgets($f , 4096);
											$buf = htmlspecialchars_decode($buf, ENT_QUOTES);
											if(!$check)
											{
												echo $buf;
												$check = true;
											}
											else
												echo chr(13).$buf;
										}
								}
								?></textarea>
							</div>
						</div>
						<div id="ftabs-2" style="padding: 5px;height: 205px;">
							<div class="input-div" style="height: 40px;margin: 0;padding: 2px;">
								<div class="lable" style="font-size: 11px;" >Section 2 title</div>
								<input class="textbykk" type="text" id="index2_name" name="index2_name" value="<?php echo $prow[14]; ?>" >
							</div>
							<div style="padding: 0;margin: 0;width: 100%;float: right;">
								<textarea name="index2" id="index2" ><?php
								if(strlen($prow[14]) >= 2)
								{
									$check = false;
									$f = fopen("../".$prow[15], "r");
									if($f===false)
										echo "'".$prow[15]."' doesn't exist.";
									else
										while(!feof($f))
										{
											$buf = fgets($f , 4096);
											$buf = htmlspecialchars_decode($buf, ENT_QUOTES);
											if(!$check)
											{
												echo $buf;
												$check = true;
											}
											else
												echo chr(13).$buf;
										}
								}
								?></textarea>
							</div>
						</div>
						<div id="ftabs-3" style="padding: 5px;height: 205px;">
							<div class="input-div" style="height: 40px;margin: 0;padding: 2px;">
								<div class="lable" style="font-size: 11px;" >Section 3 title</div>
								<input class="textbykk" type="text" id="index3_name" name="index3_name" value="<?php echo $prow[16]; ?>" >
							</div>
							<div style="padding: 0;margin: 0;width: 100%;float: right;">
								<textarea name="index3" id="index3" ><?php
								if(strlen($prow[16]) >= 2)
								{
									$check = false;
									$f = fopen("../".$prow[17], "r");
									if($f===false)
										echo "'".$prow[17]."' doesn't exist.";
									else
										while(!feof($f))
										{
											$buf = fgets($f , 4096);
											$buf = htmlspecialchars_decode($buf, ENT_QUOTES);
											if(!$check)
											{
												echo $buf;
												$check = true;
											}
											else
												echo chr(13).$buf;
										}
								}
								?></textarea>
							</div>
						</div>
						<div id="ftabs-4" style="padding: 5px;height: 205px;">
							<div class="input-div" style="height: 40px;margin: 0;padding: 2px;">
								<div class="lable" style="font-size: 11px;" >Section 4 title</div>
								<input class="textbykk" type="text" id="index4_name" name="index4_name" value="<?php echo $prow[18]; ?>" >
							</div>
							<div style="padding: 0;margin: 0;width: 100%;float: right;">
								<textarea name="index4" id="index4" ><?php
								if(strlen($prow[18]) >= 2)
								{
									$check = false;
									$f = fopen("../".$prow[19], "r");
									if($f===false)
										echo "'".$prow[19]."' doesn't exist.";
									else
										while(!feof($f))
										{
											$buf = fgets($f , 4096);
											$buf = htmlspecialchars_decode($buf, ENT_QUOTES);
											if(!$check)
											{
												echo $buf;
												$check = true;
											}
											else
												echo chr(13).$buf;
										}
								}
								?></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="div-row" >
					<div class="input-div" >
						<input type="submit" class="btnbykk" value="Apply" style="width: 412px;">
					</div>
				</div>
			</form>
			<script type="text/javascript">
			$("#main-picture").mouseenter(function(){
				$("#cropimage").stop().css({'display':'block'}).animate({'opacity':'1'},300);
			}).mouseleave(function(){
				$("#cropimage").stop().animate({'opacity':'0'},300,function(){
					$(this).css({'display':'none'});
				});
			});

			$("#index1").jqte({change: function(){
				var jheight = $("textarea#index1").parent("div").parent("div").height();
					$("#ftabs-1").height(jheight + 55);
			}
			});
			$("#index2").jqte({change: function(){
				var jheight = $("textarea#index2").parent("div").parent("div").height();
					$("#ftabs-2").height(jheight + 55);
			}
			});
			$("#index3").jqte({change: function(){
				var jheight = $("textarea#index3").parent("div").parent("div").height();
					$("#ftabs-3").height(jheight + 55);
			}
			});
			$("#index4").jqte({change: function(){
				var jheight = $("textarea#index4").parent("div").parent("div").height();
					$("#ftabs-4").height(jheight + 55);
			}
			});
			$("#ftabs").tabs();
			$(".jqte").css({'margin':'0'});
			function productBeforeSend()
			{
				var sCounter=0;
				if($("#addproduct_form #product_name").val().length < 2)
				{
					$("#addproduct_form #product_name").removeClass("green").addClass("red");
				}
				else
				{
					$("#addproduct_form #product_name").removeClass("red").addClass("green");
					sCounter++;
				}

				if($("#addproduct_form #p_note").val().length < 2)
				{
					$("#addproduct_form #p_note").removeClass("green").addClass("red");
				}
				else
				{
					$("#addproduct_form #p_note").removeClass("red").addClass("green");
					sCounter++;
				}
				
				if($("#addproduct_form #category").val().length < 2)
				{
					$("#addproduct_form #category").removeClass("green").addClass("red");
				}
				else
				{
					if($("#addproduct_form #category").val() == 'other')
					{
						if($("#addproduct_form #category_name").val().length < 2)
						{
							$("#addproduct_form #category_name").removeClass("green").addClass("red");
						}
						else
						{
							$("#addproduct_form #category_name").removeClass("red").addClass("green");
							sCounter++;
						}
					}
					else
					{
						$("#addproduct_form #category").removeClass("red").addClass("green");
						sCounter++;
					}
				}
			
				if($("#addproduct_form #sub_category").val().length < 2)
				{
					$("#addproduct_form #sub_category").removeClass("green").addClass("red");
				}
				else
				{
					if($("#addproduct_form #sub_category").val() == 'other')
					{
						if($("#addproduct_form #sub_category_name").val().length < 2)
						{
							$("#addproduct_form #sub_category_name").removeClass("green").addClass("red");
						}
						else
						{
							$("#addproduct_form #sub_category_name").removeClass("red").addClass("green");
							sCounter++;
						}
					}
					else
					{
						$("#addproduct_form #sub_category").removeClass("red").addClass("green");
						sCounter++;
					}
				}

				if(sCounter < 4)
				{
					return false;
				}
				else
				{
					progressBar(300, 60);
					return true;
				}
			}
		
			$(document).ready(function() { 
			    $('#addproduct_form').ajaxForm({ 
			    	target: '#main-index', 
			        success: function() { 
			        	progressBar(300, 100);
	            		$('#index-loader').animate({'opacity':'1'},300);
			        } 
			    	,
			    	beforeSubmit: productBeforeSend
			    }); 
			});
			</script>
		</div>
	</div>	
	<?php
		}
	}
	else if($_GET["mode"] == 'delete')
	{
		//include 'database.php';
		$id = $_GET["id"];
		$query = mysql_query("UPDATE productbykk_".$sitelang." SET state = '0' WHERE id='$id' ;", $db);
		if(!$query)
			echo mysql_error();
	}
	else if($_GET["mode"] == 'star')
	{
		//include 'database.php';
		$id = $_GET["id"];
		$query = mysql_query("UPDATE productbykk_".$sitelang." SET highlight = '1' WHERE id='$id' ;", $db);
		if(!$query)
			echo mysql_error();
	}
	else if($_GET["mode"] == 'unstar')
	{
		//include 'database.php';
		$id = $_GET["id"];
		$query = mysql_query("UPDATE productbykk_".$sitelang." SET highlight = '0' WHERE id='$id' ;", $db);
		if(!$query)
			echo mysql_error();
	}
	else
	{
	?>
	<div style="opacity:0;width: 100%;height: 100%;" id="index-loader">
		<script type="text/javascript">
		$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=addproduct', function() {
			$("#page-nav").animate({'opacity':'1'}, 300);
			});
		$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
		"<div class='btn add' onclick='addProduct();' title='Add Product' ></div>"
		).animate({'opacity':'1'},300);
		function linklist(mode)
		{
			$('#linkidajax').load('index/slidepnlist.php?ajax=1&slink=&slang='+$("#linkto_lang").val()+'&smode='+mode,function(){
				//$("select,input").uniform();
				});
			if(mode != '0')
			{
				$("#linktext_container").slideDown(300);
				
			}
			else
			{
				$("#linktext_container").slideUp(300);
			}
				
		}
		function linklist2(mode)
		{
			$('#linkidajax2').load('index/slidepnlist.php?ajax=1&slink=2&slang='+$("#linkto2_lang").val()+'&smode='+mode,function(){
				//$("select,input").uniform();
				});
			if(mode != '0')
			{
				$("#linktext_container2").slideDown(300);
				
			}
			else
			{
				$("#linktext_container2").slideUp(300);
			}
				
		}
		function subcheck(category,subcategory)
		{
			var encodeCategory = encodeURIComponent(category);
			var encodeSubcategory = encodeURIComponent(subcategory);
			$('#sub_category_ajax').load('index/productsubcategory.php?ajax=1&psclang=en&selectedcategory='+encodeCategory+'&selectedsubcategory='+encodeSubcategory);
			$("#sub_category_img").attr("src","../images/cnoimage.jpg");
			if(category == 'other')
			{
				$("#category_img").attr("src","../images/cnoimage.jpg");
			}
			else
			{
				var category_img = category.split("|bykk|");
				category_img = category_img[1];
				if(category_img.length < 3)
					$("#category_img").attr("src","../images/cnoimage.jpg");
				else
					$("#category_img").attr("src",category_img);
			}
		}
		function subCategoryImg(subcategory)
		{
			if(subcategory == 'other')
			{
				$("#sub_category_img").attr("src","../images/cnoimage.jpg");
			}
			else
			{
				var category_img = subcategory.split("|bykk|");
				category_img = category_img[1];
				if(category_img.length < 3)
					$("#sub_category_img").attr("src","../images/cnoimage.jpg");
				else
					$("#sub_category_img").attr("src",category_img);
			}
		}
		</script>
		<div id="success_dialog" style="display: none;opacity:0;top: 50%;height: 60px;">
		</div>
		<div style="width: 100%;height: 100%;overflow: hidden;" id="addproduct-container">
			<div class="div-title">ADD PRODUCT</div>
			<form action="index/addproduct.php?mode=add" method="POST" enctype="multipart/form-data" id="addproduct_form" >
				<div class="div-row">
					<div class="input-div" >
						<div class="lable" ><span class="red" >*</span>Name</div>
						<input type="text" class="textbykk" id="product_name" name="product_name" style="width: 400px;" >
					</div>
					<div class="input-div" >
						<div class="lable" ><span class="red" >*</span>Note</div>
						<input type="text" class="textbykk" id="p_note" name="p_note" style="width: 400px;" >
					</div>
				</div>
				<div class="div-row">
					<div class="input-div" >
						<div class="lable" ><span class="red" >*</span>Picture (main)</div>
						<input type="file" class="textbykk" id="picture" name="picture" style="width: 400px;" >
					</div>
					<div class="input-div" >
						<div class="lable" >Other Pictures (you can select more than 1 file)</div>
						<input type="file" class="textbykk" name="other_pictures[]" style="width: 400px;" multiple="multiple" >
					</div>
				</div>
				<div class="div-row">
					<div class="input-div" style="width: 412px;" >
						<div class="lable" ><span class="red" >*</span>Catgeory</div>
						<select class="textbykk" id="category" name="category" onchange="subcheck(this.value,'');" >
							<option  ></option>
							<?php 
							$pid = $_GET["pid"];
							$query = mysql_query("SELECT category, category_picture FROM productbykk_".$sitelang." WHERE state = 1  ORDER BY category ASC ; ", $db);
							if (!$query)
								die("Error reading query: ".mysql_error());
								
							$category = "";
							while($row=mysql_fetch_row($query))
								{
								if($category != $row[0] )
									{
										echo "
										<option value='".$row[0]."|bykk|".$row[1]."' >".getCategory($row[0])."</option>
										";
										$category = $row[0];
									}
								}
							?>
							<option value="other" >Other...</option>
						</select>
						<input type="text" class="textbykk" id="category_name" name="category_name" >
					</div>
					<div class="input-div" >
						<div class="lable" >Category Picture</div>
						<input type="file" class="textbykk" id="category_picture" name="category_picture" style="width: 250px;" >
					</div>
					<div style="position: relative;float: right;margin-right: 10px;">
						<img src="../images/cnoimage.jpg" style="height:60px;float:right;box-shadow:0 1px 3px rgba(0,0,0,0.5);" id="category_img" />
					</div>
				</div>
				<div class="div-row">
					<div class="input-div" style="width: 412px;"  id="sub_category_ajax" >
						<?php 
						include 'productsubcategory.php';
						?>
					</div>
					<div class="input-div" >
						<div class="lable" >Sub-category Picture</div>
						<input type="file" class="textbykk" id="sub_category_picture" name="sub_category_picture" style="width: 250px;" >
					</div>
					<div style="position: relative;float: right;margin-right: 10px;">
						<img src="../images/cnoimage.jpg" style="height:60px;float:right;box-shadow:0 1px 3px rgba(0,0,0,0.5);" id="sub_category_img" />
					</div>
				</div>
				<div class="div-row">
					<div class="input-div" style="width: 80%;" >
						<div class="lable" ><span class="red" >*</span>Show to</div>
						<select class="textbykk" name="showto" id="showto" style="width: 412px;" >
							<option value="1" >All</option>
							<option value="2" >Users</option>
							<option value="3" >Level 1 users</option>
							<option value="4" >Level 2 users</option>
							<option value="5" >Level 3 users</option>
							<option value="0" >Just admins</option>
						</select>
					</div>
				</div>
				<div class="div-row">
					<div class="input-div" >
						<div class="lable" ><span class="red" >*</span>Link to #1</div>
						<select class="textbykk" id="linkto_lang" name="linkto_lang" style="width: 100px;margin-right: 5px;" >
							<option value="fa" >Farsi</option>
							<option value="en" >English</option>
							<option value="de" >Germany</option>
						</select>
						<select class="textbykk" id="linkto" name="linkto" onchange="linklist(this.value);" style="width: 302px;" >
							<option value="0" >Nothing</option>
							<option value="1" >Products</option>
							<option value="2" >News/Article</option>
							<option value="3" >Gallery</option>
							<option value="4" >Web Address</option>
							<option value="5" >Customized Forms</option>
						</select>
					</div>
					<div class="input-div" id="linkidajax" >
						<div class="lable" >&nbsp;</div>
						<select class="textbykk" id="linkid" name="linkid" disabled="disabled" style="width: 412px;" >
							<option value="0" selected="selected"></option>
						</select>
					</div>
				</div>
				<div class="div-row" id="linktext_container" style="display: none;width: 80%;overflow: hidden;min-height: 0;" >
					<div class="input-div" >
						<div class="lable" >Link text</div>
						<input class="textbykk" type="text" id="linktext" name="linktext" style="width: 400px;">
					</div>
				</div>
				<div class="div-row">
					<div class="input-div" >
						<div class="lable" ><span class="red" >*</span>Link to #2</div>
						<select class="textbykk" id="linkto2_lang" name="linkto2_lang" style="width: 100px;margin-right: 5px;" >
							<option value="fa" >Farsi</option>
							<option value="en" >English</option>
							<option value="de" >Germany</option>
						</select>
						<select class="textbykk" id="linkto2" name="linkto2" onchange="linklist2(this.value);" style="width: 302px;" >
							<option value="0" >Nothing</option>
							<option value="1" >Products</option>
							<option value="2" >News/Article</option>
							<option value="3" >Gallery</option>
							<option value="4" >Web Address</option>
							<option value="5" >Customized Forms</option>
						</select>
					</div>
					<div class="input-div" id="linkidajax2" >
						<div class="lable" >&nbsp;</div>
						<select class="textbykk" id="linkid2" name="linkid2" disabled="disabled" style="width: 412px;" >
							<option value="0" selected="selected"></option>
						</select>
					</div>
				</div>
				<div class="div-row" id="linktext_container2" style="display: none;width: 80%;overflow: hidden;min-height: 0;" >
					<div class="input-div" >
						<div class="lable" >Link text</div>
						<input class="textbykk" type="text" id="linktext2" name="linktext2" style="width: 400px;">
					</div>
				</div>
				<div class="div-row" >
					<div class="input-div" >
						<div class="lable" >Attachments (you can select more than 1 file)</div>
						<input type="file" class="textbykk" id="attachments" name="attachments[]" style="width: 400px;" multiple="multiple">
					</div>
					<div class="input-div" >
						<div class="lable" >Who can download attachments?</div>
						<select class="textbykk" name="whocandl" id="whocandl" style="width: 412px;" >
							<option value="1" >All</option>
							<option value="2" >Users</option>
							<option value="3" >Level 1 users</option>
							<option value="4" >Level 2 users</option>
							<option value="5" >Level 3 users</option>
							<option value="0" >Just admins</option>
						</select>
					</div>
				</div>
				<div class="div-row" style="margin: 0 5% 0 5%;">
					<div id="ftabs">
						<ul>
							<li><a href="#ftabs-1">Section 1</a></li>
							<li><a href="#ftabs-2">Section 2</a></li>
							<li><a href="#ftabs-3">Section 3</a></li>
							<li><a href="#ftabs-4">Section 4</a></li>
						</ul>
						<div id="ftabs-1" style="padding: 5px;height: 205px;">
							<div class="input-div" style="height: 40px;margin: 0;padding: 2px;">
									<div class="lable" style="font-size: 11px;" >Section 1 title</div>
									<input class="textbykk" type="text" id="index1_name" name="index1_name" >
							</div>
							<div style="padding: 0;margin: 0;width: 100%;float: right;">
								<textarea name="index1" id="index1" ></textarea>
							</div>
						</div>
						<div id="ftabs-2" style="padding: 5px;height: 205px;">
							<div class="input-div" style="height: 40px;margin: 0;padding: 2px;">
									<div class="lable" style="font-size: 11px;" >Section 2 title</div>
									<input class="textbykk" type="text" id="index2_name" name="index2_name" >
							</div>
							<div style="padding: 0;margin: 0;width: 100%;float: right;">
								<textarea name="index2" id="index2" ></textarea>
							</div>
						</div>
						<div id="ftabs-3" style="padding: 5px;height: 205px;">
							<div class="input-div" style="height: 40px;margin: 0;padding: 2px;">
									<div class="lable" style="font-size: 11px;" >Section 3 title</div>
									<input class="textbykk" type="text" id="index3_name" name="index3_name" >
							</div>
							<div style="padding: 0;margin: 0;width: 100%;float: right;">
								<textarea name="index3" id="index3" ></textarea>
							</div>
						</div>
						<div id="ftabs-4" style="padding: 5px;height: 205px;">
							<div class="input-div" style="height: 40px;margin: 0;padding: 2px;">
									<div class="lable" style="font-size: 11px;" >Section 4 title</div>
									<input class="textbykk" type="text" id="index4_name" name="index4_name" >
							</div>
							<div style="padding: 0;margin: 0;width: 100%;float: right;">
								<textarea name="index4" id="index4" ></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="div-row" >
					<div class="input-div" >
						<input type="submit" class="btnbykk" value="Add!" style="width: 412px;">
					</div>
				</div>
			</form>
			<script type="text/javascript">
			$("#index1").jqte({change: function(){
				var jheight = $("textarea#index1").parent("div").parent("div").height();
					$("#ftabs-1").height(jheight + 55);
			}
			});
			$("#index2").jqte({change: function(){
				var jheight = $("textarea#index2").parent("div").parent("div").height();
					$("#ftabs-2").height(jheight + 55);
			}
			});
			$("#index3").jqte({change: function(){
				var jheight = $("textarea#index3").parent("div").parent("div").height();
					$("#ftabs-3").height(jheight + 55);
			}
			});
			$("#index4").jqte({change: function(){
				var jheight = $("textarea#index4").parent("div").parent("div").height();
					$("#ftabs-4").height(jheight + 55);
			}
			});
			$("#ftabs").tabs();
			$(".jqte").css({'margin':'0'});
			function productBeforeSend()
			{
				var sCounter=0;
				if($("#addproduct_form #product_name").val().length < 2)
				{
					$("#addproduct_form #product_name").removeClass("green").addClass("red");
				}
				else
				{
					$("#addproduct_form #product_name").removeClass("red").addClass("green");
					sCounter++;
				}

				if($("#addproduct_form #p_note").val().length < 2)
				{
					$("#addproduct_form #p_note").removeClass("green").addClass("red");
				}
				else
				{
					$("#addproduct_form #p_note").removeClass("red").addClass("green");
					sCounter++;
				}

				if($("#addproduct_form #picture").val() == '')
				{
					$("#addproduct_form #picture").removeClass("green").addClass("red");
				}
				else
				{
					$("#addproduct_form #picture").removeClass("red").addClass("green");
					sCounter++;
				}
				
				if($("#addproduct_form #category").val().length < 2)
				{
					$("#addproduct_form #category").removeClass("green").addClass("red");
				}
				else
				{
					if($("#addproduct_form #category").val() == 'other')
					{
						if($("#addproduct_form #category_name").val().length < 2)
						{
							$("#addproduct_form #category_name").removeClass("green").addClass("red");
						}
						else
						{
							$("#addproduct_form #category_name").removeClass("red").addClass("green");
							sCounter++;
						}
					}
					else
					{
						$("#addproduct_form #category").removeClass("red").addClass("green");
						sCounter++;
					}
				}
			
				if($("#addproduct_form #sub_category").val().length < 2)
				{
					$("#addproduct_form #sub_category").removeClass("green").addClass("red");
				}
				else
				{
					if($("#addproduct_form #sub_category").val() == 'other')
					{
						if($("#addproduct_form #sub_category_name").val().length < 2)
						{
							$("#addproduct_form #sub_category_name").removeClass("green").addClass("red");
						}
						else
						{
							$("#addproduct_form #sub_category_name").removeClass("red").addClass("green");
							sCounter++;
						}
					}
					else
					{
						$("#addproduct_form #sub_category").removeClass("red").addClass("green");
						sCounter++;
					}
				}

				if(sCounter < 5)
				{
					return false;
				}
				else
				{
					progressBar(300, 60);
					return true;
				}
			}
		
			$(document).ready(function() { 
			    $('#addproduct_form').ajaxForm({ 
			        target: '#success_dialog', 
			        success: function() { 
			        	progressBar(300, 80);
			        	$('#addproduct-container').animate({'opacity':'0.0','height':'600px'},1000, function(){
		            		$('#addproduct-container').remove();
		            		progressBar(300, 100);
		               	});
			        	$('#success_dialog').css({'display':'block'}).animate({'opacity' : '1'},300);
			        } 
			    	,
			    	beforeSubmit: productBeforeSend
			    }); 
			});
			</script>
		</div>
	</div>	
	<?php
	}
}
?>