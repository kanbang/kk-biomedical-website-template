<?php
include 'database.php';
if($isAdmin)
{
	if($_GET["mode"] == 'add')
	{
		include 'jdf.php';
		
		$ajaxDir = "../";
			
		$album = $_POST["album"];
		if($album == 'other')
		{
			$album = $_POST["album_name"];
			$album = setCategory($album);
		}
		$album = mysql_real_escape_string($album);
		
		$picture=$_FILES["picture"]["name"];
		$tmp_file=$_FILES["picture"]["tmp_name"];
		$type=$_FILES["picture"]["type"];
		
		$picture_title = $_POST["picture_title"];
		$picture_title = mysql_real_escape_string($picture_title);
		
		$showto = $_POST["showto"];
		
		$query = mysql_query("SELECT id FROM gallerybykk_".$sitelang." ORDER BY id  DESC ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		
		if( $rows=mysql_fetch_row($query) )
			$id = $rows[0] + 1;
		else
			$id = 1000;
		
		$allPictures = 0;
		$donePictures = 0;
		$thumbCovers = '';
		
		if(is_array($_FILES['picture']))
		{
			$file_ary = reArrayFiles($_FILES['picture']);
			$allPictures = count($file_ary);
			foreach ($file_ary as $file)
			{
				$address_picture = '';
				$thumb_cover = '';
				$thumb_name = '';
				$original_picture = '';
				
				$picture = $file["name"];
				$type = $file["type"];
				$tmp_file = $file["tmp_name"];
				
				if($type == "image/jpeg" || $type == "image/png" || $type == "image/gif" )
				{
					$address_picture= "gallery/".$id.rand(1000000,9999999).".jpg";
					if(!move_uploaded_file($tmp_file, $ajaxDir.$address_picture))
					{
						
					}
					else
					{
						//$image_name = $address_picture;    // Full path and image name with extension
						$thumb_name = "gallery/".$id."thumb".rand(1000000,9999999).".jpg";	// Generated thumbnail name without extension
					
						$image = imagecreatefromstring(file_get_contents($ajaxDir.$address_picture));
					
						$filename = $ajaxDir.$thumb_name;
					
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
						imagejpeg($thumb, $filename, 90);
					
						$thumb_cover = "gallery/".$id."cover".rand(1000000,9999999).".jpg";   // Generated thumbnail name without extension
					
						$image = imagecreatefromstring(file_get_contents($ajaxDir.$address_picture));
					
						$filename = $ajaxDir.$thumb_cover;
					
						$thumb_width = 310;
						$thumb_height = 210;
					
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
					
						//unlink($ajaxDir.$address_picture);
						$original_picture = $address_picture;
						
						$date = date("F d Y");
						$time = date("G:i");
						$jdate = jdate("j F Y");
						$jtime = jdate("G:i");
							
						$sql = "INSERT INTO `gallerybykk_".$sitelang."` (`id`, `album`, `picture`, `picture_cover`, `picture_thumb`, `picture_title`,
						`showto`, `date`, `time`, `jdate`, `jtime`, `state`)
						VALUES ('$id', '$album', '$original_picture', '$thumb_cover', '$thumb_name', '$picture_title',
						'$showto', '$date', '$time', '$jdate', '$jtime', '1');";
							
						$result = mysql_query($sql, $db);
						if($result == false )
							echo mysql_error();
						else
						{
							$id++;
							$donePictures++;
							$thumbCovers = $thumbCovers."|".$thumb_cover;
						}
					}
				}
			}
		}
		
		/*$result = mysql_query($sql, $db);
		if($result == false )
			echo mysql_error();
		else
		{*/
			?>
			<img alt="correct" src="../images/correct.png" style="float: left;position: relative;height: 60px;"/>
			<div style="font-size: 13px;color: #333;padding: 20px 5px;font-weight: bold;float:left;"><?php echo $donePictures." of ".$allPictures; ?> Image(s) Added!</div>
			<script>
			setTimeout(function(){
				gotoPage('full',500,'index/gallery.php');
			},3000);
			</script>
			<?php
			$cover1 = $cover2 = $cover3 = '';
			$thumbCovers = explode("|", $thumbCovers);
			$toCover[0] = $toCover[1] = $toCover[2] = '';
			$i = 0;
			foreach ($thumbCovers as $cover)
			{
				if(strlen($cover)>3)
				{
					$toCover[$i] = $cover;
					$i++;
				}
				if($i>=3) break;
			}
			
			$query = mysql_query("SELECT cover1, cover2, cover3 FROM gallerybykk_".$sitelang." WHERE album = '$album' ORDER BY id  ASC ;", $db);
			if (!$query)
				die("Error reading query: ".mysql_error());
			if($rows=mysql_fetch_row($query))
			{
				if($rows[0] == '')
					$cover1 = $toCover[0];
				else
					$cover1 = $rows[0];
				
				if($rows[1] == '')
					$cover2 = $toCover[1];
				else
					$cover2 = $rows[1];
				
				if($rows[2] == '')
					$cover3 = $toCover[2];
				else
					$cover3 = $rows[2];
			}
			else
			{
				$cover1 = $toCover[0];
				$cover2 = $toCover[1];
				$cover3 = $toCover[2];
			}

			$query = mysql_query("UPDATE `gallerybykk_".$sitelang."` SET `cover1` = '$cover1' , `cover2` = '$cover2' , `cover3` = '$cover3' WHERE `album` = '$album' ;", $db);
			if (!$query)
				die("Error reading query: ".mysql_error());
		//}
	}
	else if($_GET["mode"] == 'edit_gallery' || $_GET["mode"] == 'applyedit_gallery')
	{
		?>
		<div style="opacity:1;width: 100%;height: 100%;" id="index-loader">
		<?php
		if($_GET["mode"] == 'applyedit_gallery')
		{
			include 'jdf.php';
			
			$ajaxDir = "../";
				
			$id = $_POST["id"];
			
			$album = $_POST["album"];
			if($album == 'other')
			{
				$album = $_POST["album_name"];
				$album = setCategory($album);
			}
			$album = mysql_real_escape_string($album);
			
			$picture=$_FILES["picture"]["name"];
			$tmp_file=$_FILES["picture"]["tmp_name"];
			$type=$_FILES["picture"]["type"];
			$default_picture = $_POST["default_picture"];
			$default_picture_cover = $_POST["default_picture_cover"];
			$default_picture_thumb = $_POST["default_picture_thumb"];
			
			$picture_title = $_POST["picture_title"];
			$picture_title = mysql_real_escape_string($picture_title);
			
			$showto = $_POST["showto"];
			
			
			$original_picture = $default_picture;
			$thumb_cover = $default_picture_cover;
			$thumb_name = $default_picture_thumb;
			if($picture != '')
			{
				unlink($original_picture);
				unlink($thumb_cover);
				unlink($thumb_name);
				if($type == "image/jpeg" || $type == "image/png" || $type == "image/gif" )
				{
					$address_picture= "gallery/".$id.rand(1000000,9999999).".jpg";
					move_uploaded_file($tmp_file, $ajaxDir.$address_picture);
					
					//$image_name = $address_picture;    // Full path and image name with extension
					$thumb_name = "gallery/".$id."thumb".rand(1000000,9999999).".jpg";	// Generated thumbnail name without extension
				
					$image = imagecreatefromstring(file_get_contents($ajaxDir.$address_picture));
				
					$filename = $ajaxDir.$thumb_name;
				
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
					imagejpeg($thumb, $filename, 90);
				
					$thumb_cover = "gallery/".$id."cover".rand(1000000,9999999).".jpg";   // Generated thumbnail name without extension
				
					$image = imagecreatefromstring(file_get_contents($ajaxDir.$address_picture));
				
					$filename = $ajaxDir.$thumb_cover;
				
					$thumb_width = 310;
					$thumb_height = 210;
				
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
				
					$original_picture = $address_picture;
				}
			}
			
			$query = mysql_query("UPDATE gallerybykk_".$sitelang." SET album = '$album', picture = '$original_picture', picture_cover = '$thumb_cover', 
					picture_thumb='$thumb_name', picture_title = '$picture_title', showto='$showto' WHERE id='$id' ;", $db);
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
				$cover1 = $cover2 = $cover3 = '';
				$query = mysql_query("SELECT cover1, cover2, cover3 FROM gallerybykk_".$sitelang." WHERE album = '$album' AND id != '$id' ORDER BY id  ASC ;", $db);
				if (!$query)
					die("Error reading query: ".mysql_error());
				if($rows=mysql_fetch_row($query))
				{
					if($rows[0] == '')
						$cover1 = $thumb_cover;
					else
						$cover1 = $rows[0];
					
					if($cover1 != $thumb_cover)
					{
						if($rows[1] == '')
							$cover2 = $thumb_cover;
						else
							$cover2 = $rows[1];
					}
					
					if($cover2 != $thumb_cover)
					{
						if($rows[2] == '')
							$cover3 = $thumb_cover;
						else
							$cover3 = $rows[2];
					}
				}
				else
				{
					$cover1 = $thumb_cover;
				}
				
				$query = mysql_query("UPDATE `gallerybykk_".$sitelang."` SET `cover1` = '$cover1' , `cover2` = '$cover2' , `cover3` = '$cover3' WHERE `album` = '$album' ;", $db);
				if (!$query)
					die("Error reading query: ".mysql_error());
			}
		}
		
		if(isset($_GET['id']))
			$id = $_GET['id'];
		else
			$id = $_POST['id'];
			
		$query = mysql_query("SELECT * FROM gallerybykk_".$sitelang." WHERE state = 1 AND id = '$id' ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		if($grow=mysql_fetch_row($query))
		{
		?>
		<script type="text/javascript">
		$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=addgallery&id=<?php echo $id?>', function() {
			$("#page-nav").animate({'opacity':'1'}, 300);
			});
		$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
				"<div class='btn add' onclick='addGallery();' title='Add image/gallery' ></div><div class='btn change' onclick=editGallery('<?php echo $id; ?>'); title='Edit Image' ></div><div class='btn delete' onclick=deleteGallery('<?php echo $id; ?>'); title='Delete Image!' ></div>"
				).animate({'opacity':'1'},300);
		</script>
		<div style="width: 100%;height: 100%;overflow: hidden;" id="addgallery-container">
			<div class="div-title">EDIT IMAGE</div>
			<form action="index/addgallery.php?mode=applyedit_gallery" method="POST" enctype="multipart/form-data" id="addgallery_form" >
				<input type="hidden" name="id" value="<?php echo $grow[0]; ?>">
				<div class="div-row">
					<div class="input-div" style="width: 700px;" >
						<div class="lable" ><span class="red" >*</span>Albums</div>
						<select class="textbykk" id="album" name="album" >
							<option value=""  ></option>
							<?php 
							$pid = $_GET["pid"];
							$query = mysql_query("SELECT album FROM gallerybykk_".$sitelang." WHERE state = 1  ORDER BY album ASC ; ", $db);
							if (!$query)
								die("Error reading query: ".mysql_error());
								
							$category = "";
							while($row=mysql_fetch_row($query))
								{
								if($category != $row[0] )
									{
										echo "
										<option value='".$row[0]."' ";
										if($grow[1] == $row[0])
											echo " selected = 'selected'";
										 echo " >".getCategory($row[0])."</option>
										";
										$category = $row[0];
									}
								}
							?>
							<option value="other" >Other...</option>
						</select>
						<input type="text" class="textbykk" id="album_name" name="album_name" >
					</div>
				</div>
				<div class="div-row" >
					<div class="input-div" >
						<div class="lable" ><span class="red" >*</span>Picture</div>
						<input type="file" class="textbykk" id="picture" name="picture" style="width: 400px;" >
						<input type="hidden" name="default_picture" value="<?php echo $grow[5]; ?>">
						<input type="hidden" name="default_picture_cover" value="<?php echo $grow[6]; ?>">
						<input type="hidden" name="default_picture_thumb" value="<?php echo $grow[7]; ?>">
					</div>
				</div>
				<div class="div-row">
					<div class="input-div" >
						<div class="lable" >Picture title</div>
						<input type="text" class="textbykk" id="picture_title" name="picture_title" style="width: 400px;" value="<?php echo $grow[8]; ?>">
					</div>
					<div class="input-div" >
						<div class="lable" ><span class="red" >*</span>Show to</div>
						<select class="textbykk" name="showto" id="showto" style="width: 412px;" >
							<option value="1" <?php if($grow[9] == 1) echo "selected";?> >All</option>
							<option value="2" <?php if($grow[9] == 2) echo "selected";?> >Users</option>
							<option value="3" <?php if($grow[9] == 3) echo "selected";?> >Level 1 users</option>
							<option value="4" <?php if($grow[9] == 4) echo "selected";?> >Level 2 users</option>
							<option value="5" <?php if($grow[9] == 5) echo "selected";?> >Level 3 users</option>
							<option value="0" <?php if($grow[9] == 0) echo "selected";?> >Just admins</option>
						</select>
					</div>
				</div>
				<div class="div-row" >
					<div class="input-div" >
						<input type="submit" class="btnbykk" value="Apply" style="width: 412px;">
					</div>
				</div>
			</form>
		</div>
		<script type="text/javascript">
		function galleryBeforeSend()
		{
			var sCounter = 0;
			if($("#addgallery_form #album").val().length < 2)
			{
				$("#addgallery_form #album").removeClass("green").addClass("red");
			}
			else
			{
				if($("#addgallery_form #album").val() == 'other')
				{
					if($("#addgallery_form #album_name").val().length < 2)
					{
						$("#addgallery_form #album_name").removeClass("green").addClass("red");
					}
					else
					{
						$("#addgallery_form #album_name").removeClass("red").addClass("green");
						sCounter++;
					}
				}
				else
				{
					$("#addgallery_form #album").removeClass("red").addClass("green");
					sCounter++;
				}
			}
			
			if(sCounter>=1)
			{
				progressBar(300, 60);
				return true;
			}
			else
				return false;
		}
		$(document).ready(function() { 
		    $('#addgallery_form').ajaxForm({ 
		        target: '#main-index', 
		        success: function() { 
            		progressBar(300, 100);
		        	$('#success_dialog').css({'display':'block'}).animate({'opacity' : '1'},300);
		        } 
		    	,
		    	beforeSubmit: galleryBeforeSend
		    }); 
		});
		</script>
		<?php 
		}
		?>
		</div>
		<?php
	}
	else if($_GET["mode"] == 'edit_album' || $_GET["mode"] == 'applyedit_album')
	{
		?>
		<div style="opacity:1;width: 100%;height: 100%;" id="index-loader">
		<?php
		if($_GET["mode"] == 'applyedit_album')
		{
			$album = $_POST['album'];
			$album = mysql_real_escape_string($album);
			
			$album_title = $_POST['album_title'];
			$album_title = setCategory($album_title);
			$album_title = mysql_real_escape_string($album_title);
			
			$showto = $_POST['showto'];
			
			$cover1 = $_POST['cover1'];
			$cover2 = $_POST['cover2'];
			$cover3 = $_POST['cover3'];
			
			$query = mysql_query("UPDATE gallerybykk_".$sitelang." SET album = '$album_title', cover1 = '$cover1', cover2 = '$cover2',
					cover3='$cover3', showto = '$showto' WHERE album = '$album' ;", $db);
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
				$album = $album_title;
			}
		}
		if(isset($_GET['album']))
			$album = $_GET['album'];
		
		$album = mysql_real_escape_string($album);
			
		$query = mysql_query("SELECT * FROM gallerybykk_".$sitelang." WHERE state = 1 AND album = '$album' ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		if($grow=mysql_fetch_row($query))
		{
		?>
		<script type="text/javascript">
		$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=addgallery&album=<?php echo encodeURIComponent($album); ?>', function() {
			$("#page-nav").animate({'opacity':'1'}, 300);
			});
		</script>
		<div style="width: 100%;height: 100%;overflow: hidden;" id="addgallery-container">
			<div class="div-title">EDIT ALBUM</div>
			<form action="index/addgallery.php?mode=applyedit_album" method="POST" enctype="multipart/form-data" id="addgallery_form" >
				<input type="hidden" name="album" value="<?php echo $grow[1]; ?>">
				<div class="div-row" >
					<div class="input-div" >
						<div class="lable" ><span class="red" >*</span>Album</div>
						<input type="text" class="textbykk" id="album" name="album_title" style="width: 400px;" value="<?php echo getCategory($grow[1]); ?>" >
					</div>
					<div class="input-div" >
						<div class="lable" ><span class="red" >*</span>Show to</div>
						<select class="textbykk" name="showto" id="showto" style="width: 412px;" >
							<option value="1" <?php if($grow[9] == 1) echo "selected";?> >All</option>
							<option value="2" <?php if($grow[9] == 2) echo "selected";?> >Users</option>
							<option value="3" <?php if($grow[9] == 3) echo "selected";?> >Level 1 users</option>
							<option value="4" <?php if($grow[9] == 4) echo "selected";?> >Level 2 users</option>
							<option value="5" <?php if($grow[9] == 5) echo "selected";?> >Level 3 users</option>
							<option value="0" <?php if($grow[9] == 0) echo "selected";?> >Just admins</option>
						</select>
					</div>
				</div>
				<div class="div-row">
					<div class="input-div" >
						<div class="lable" ><span class="red" >*</span>Cover 1</div>
						<select class="textbykk" id="cover1" name="cover1" style="width: 412px;" >
							<option value=""  ></option>
							<?php 
							$salbum = mysql_real_escape_string($grow[1]);
							$query = mysql_query("SELECT picture_cover FROM gallerybykk_".$sitelang." WHERE state = 1 AND album = '$salbum'  ORDER BY id ASC ; ", $db);
							if (!$query)
								die("Error reading query: ".mysql_error());
								
							while($row=mysql_fetch_row($query))
							{
								echo "
								<option value='".$row[0]."' ";
								if($grow[2] == $row[0])
									echo " selected = 'selected'";
								 echo " >".$row[0]."</option>
								";
							}
							?>
						</select>
					</div>
					<div class="input-div" >
						<div class="lable" ><span class="red" >*</span>Cover 2</div>
						<select class="textbykk" id="cover2" name="cover2" style="width: 412px;" >
							<option value=""  ></option>
							<?php 
							$salbum = mysql_real_escape_string($grow[1]);
							$query = mysql_query("SELECT picture_cover FROM gallerybykk_".$sitelang." WHERE state = 1 AND album = '$salbum'  ORDER BY id ASC ; ", $db);
							if (!$query)
								die("Error reading query: ".mysql_error());
								
							while($row=mysql_fetch_row($query))
							{
								echo "
								<option value='".$row[0]."' ";
								if($grow[3] == $row[0])
									echo " selected = 'selected'";
								 echo " >".$row[0]."</option>
								";
							}
							?>
						</select>
					</div>
				</div>
				<div class="div-row">
					<div class="input-div" >
						<div class="lable" ><span class="red" >*</span>Cover 3</div>
						<select class="textbykk" id="cover3" name="cover3" style="width: 412px;" >
							<option value=""  ></option>
							<?php 
							$salbum = mysql_real_escape_string($grow[1]);
							$query = mysql_query("SELECT picture_cover FROM gallerybykk_".$sitelang." WHERE state = 1 AND album = '$salbum'  ORDER BY id ASC ; ", $db);
							if (!$query)
								die("Error reading query: ".mysql_error());
								
							while($row=mysql_fetch_row($query))
							{
								echo "
								<option value='".$row[0]."' ";
								if($grow[4] == $row[0])
									echo " selected = 'selected'";
								 echo " >".$row[0]."</option>
								";
							}
							?>
						</select>
					</div>
				</div>
				<div class="div-row" >
					<div class="input-div" >
						<input type="submit" class="btnbykk" value="Apply" style="width: 412px;">
					</div>
				</div>
			</form>
		</div>
		<script type="text/javascript">
		function galleryBeforeSend()
		{
			var sCounter = 0;
			if($("#addgallery_form #album").val().length < 2)
			{
				$("#addgallery_form #album").removeClass("green").addClass("red");
			}
			else
			{
				$("#addgallery_form #album").removeClass("red").addClass("green");
				sCounter++;
			}
			
			
			if(sCounter>=1)
			{
				progressBar(300, 60);
				return true;
			}
			else
				return false;
		}
		$(document).ready(function() { 
		    $('#addgallery_form').ajaxForm({ 
		        target: '#main-index', 
		        success: function() { 
            		progressBar(300, 100);
		        	$('#success_dialog').css({'display':'block'}).animate({'opacity' : '1'},300);
		        } 
		    	,
		    	beforeSubmit: galleryBeforeSend
		    }); 
		});
		</script>
		<?php 
		}
		?>
		</div>
	<?php
	}
	else if($_GET["mode"] == 'delete_album')
	{
		$album = $_GET["album"];
		$album = mysql_real_escape_string($album);
		$query = mysql_query("UPDATE gallerybykk_".$sitelang." SET state = '0' WHERE album='$album' ;", $db);
		if(!$query)
			echo mysql_error();
	}
	else if($_GET["mode"] == 'delete_gallery')
	{
		$id = $_GET["id"];
		$query = mysql_query("SELECT picture_cover FROM gallerybykk_".$sitelang." WHERE id='$id' ;", $db);
		if(!$query)
			echo mysql_error();
		if($row=mysql_fetch_row($query))
		{
			$query = mysql_query("UPDATE gallerybykk_".$sitelang." SET cover1 = '' WHERE cover1='$row[0]' ;", $db);
			if(!$query)
				echo mysql_error();
			$query = mysql_query("UPDATE gallerybykk_".$sitelang." SET cover2 = '' WHERE cover2='$row[0]' ;", $db);
			if(!$query)
				echo mysql_error();
			$query = mysql_query("UPDATE gallerybykk_".$sitelang." SET cover3 = '' WHERE cover3='$row[0]' ;", $db);
			if(!$query)
				echo mysql_error();
		}
		
		$query = mysql_query("UPDATE gallerybykk_".$sitelang." SET state = '0' WHERE id='$id' ;", $db);
		if(!$query)
			echo mysql_error();
	}
	else
	{
	?>
	<div style="opacity:0;width: 100%;height: 100%;" id="index-loader">
	<script type="text/javascript">
	$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=addgallery', function() {
		$("#page-nav").animate({'opacity':'1'}, 300);
		});
	</script>
		<div id="success_dialog" style="display: none;opacity:0;top: 50%;height: 60px;">
		</div>
		<div style="width: 100%;height: 100%;overflow: hidden;" id="addgallery-container">
			<div class="div-title">ADD GALLERY</div>
			<form action="index/addgallery.php?mode=add" method="POST" enctype="multipart/form-data" id="addgallery_form" >
				<div class="div-row">
					<div class="input-div" style="width: 700px;" >
						<div class="lable" ><span class="red" >*</span>Albums</div>
						<select class="textbykk" id="album" name="album" >
							<option value=""  ></option>
							<?php 
							$pid = $_GET["pid"];
							$query = mysql_query("SELECT album FROM gallerybykk_".$sitelang." WHERE state = 1  ORDER BY album ASC ; ", $db);
							if (!$query)
								die("Error reading query: ".mysql_error());
								
							$category = "";
							while($row=mysql_fetch_row($query))
								{
								if($category != $row[0] )
									{
										echo "
										<option value='".$row[0]."' >".getCategory($row[0])."</option>
										";
										$category = $row[0];
									}
								}
							?>
							<option value="other" >Other...</option>
						</select>
						<input type="text" class="textbykk" id="album_name" name="album_name" >
					</div>
				</div>
				<div class="div-row" >
					<div class="input-div" >
						<div class="lable" ><span class="red" >*</span>Picture (You can select more than one pictures!)</div>
						<input type="file" class="textbykk" id="picture" name="picture[]" style="width: 400px;" multiple="multiple" >
					</div>
				</div>
				<div class="div-row">
					<div class="input-div" >
						<div class="lable" >Picture title</div>
						<input type="text" class="textbykk" id="picture_title" name="picture_title" style="width: 400px;" >
					</div>
					<div class="input-div" >
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
				<div class="div-row" >
					<div class="input-div" >
						<input type="submit" class="btnbykk" value="Add!" style="width: 412px;">
					</div>
				</div>
			</form>
		</div>
		<script type="text/javascript">
		function galleryBeforeSend()
		{
			var sCounter = 0;
			if($("#addgallery_form #album").val().length < 2)
			{
				$("#addgallery_form #album").removeClass("green").addClass("red");
			}
			else
			{
				if($("#addgallery_form #album").val() == 'other')
				{
					if($("#addgallery_form #album_name").val().length < 2)
					{
						$("#addgallery_form #album_name").removeClass("green").addClass("red");
					}
					else
					{
						$("#addgallery_form #album_name").removeClass("red").addClass("green");
						sCounter++;
					}
				}
				else
				{
					$("#addgallery_form #album").removeClass("red").addClass("green");
					sCounter++;
				}
			}
			if($("#addgallery_form #picture").val().length < 2)
			{
				$("#addgallery_form #picture").removeClass("green").addClass("red");
			}
			else
			{
				$("#addgallery_form #picture").removeClass("red").addClass("green");
				sCounter++;
			}
			
			if(sCounter>=2)
			{
				progressBar(300, 60);
				return true;
			}
			else
				return false;
		}
		$(document).ready(function() { 
		    $('#addgallery_form').ajaxForm({ 
		        target: '#success_dialog', 
		        success: function() { 
		        	progressBar(300, 80);
		        	$('#addgallery-container').animate({'opacity':'0.0','height':'600px'},1000, function(){
	            		$('#addgallery-container').remove();
	            		progressBar(300, 100);
	               	});
		        	$('#success_dialog').css({'display':'block'}).animate({'opacity' : '1'},300);
		        } 
		    	,
		    	beforeSubmit: galleryBeforeSend
		    }); 
		});
		</script>
	</div>
	<?php
	}
}
?>