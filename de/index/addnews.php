<?php
include 'database.php';
if($isAdmin)
{
	if($_GET["mode"] == 'add')
	{
		include 'jdf.php';
		
		$ajaxDir = "../";
			
		$name = $_POST["news_name"];
	
		$category = $_POST["category"];
		
		$summary = $_POST["news_summary"];
		$summary = explode("\n", $summary);
		$summary = implode("<br>", $summary);
		$summary = mysql_real_escape_string($summary);
			
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
			
		$showto = $_POST["showto"];
			
		$picture=$_FILES["picture"]["name"];
		$tmp_file=$_FILES["picture"]["tmp_name"];
		$type=$_FILES["picture"]["type"];
			
		$attachment=$_FILES["attachment"]["name"];
		$attachment_file=$_FILES["attachment"]["tmp_name"];
		$attachment_type=$_FILES["attachment"]["type"];
			
		$news_index = $_POST["news_index"];
		if (get_magic_quotes_gpc()) $news_index = stripslashes($news_index);
		$news_index = htmlspecialchars($news_index, ENT_QUOTES,"UTF-8");
			
		$query = mysql_query("SELECT id FROM newsbykk_".$sitelang." ORDER BY id  DESC ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());

		if( $rows=mysql_fetch_row($query) )
			$id = $rows[0] + 1;
		else
			$id = 1000;
				
		$address_picture = '';
		$thumb_name = '';
		if($type == "image/jpeg" || $type == "image/png" || $type == "image/gif" )
		{
			$picture=explode(' ',$picture);
			$picture=implode('',$picture);
			$address_picture= "news/".$id.rand(1000000,9999999).".jpg";;
			move_uploaded_file($tmp_file, $ajaxDir.$address_picture);
				
				
			//$image_name = $address_picture;    // Full path and image name with extension
			$thumb_name = "news/".$id."thumb".rand(1000000,9999999).".jpg";;   // Generated thumbnail name without extension
				
			$image = imagecreatefromstring(file_get_contents($ajaxDir.$address_picture));
				
			$filename = $ajaxDir.$thumb_name;

			$thumb_width = 223;
			$thumb_height = 350;
				
			$width = imagesx($image);
			$height = imagesy($image);
				
			$original_aspect = $width / $height;
			$thumb_aspect = $thumb_width / $thumb_height;
				
			if($original_aspect >= 0.637)
			{
				$thumb = imagecreatetruecolor(223, (223/$original_aspect));
				imagecopyresampled($thumb,
						$image,
						0, 0,
						0, 0,
						223, (223/$original_aspect),
						$width, $height);
				imagejpeg($thumb, $filename, 90);
			}
			else
			{
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
	
				imagefilter($thumb, IMG_FILTER_COLORIZE, 232, 232, 232);
	
				// Resize and crop
				imagecopyresampled($thumb,
						$image,
						0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
						0 - ($new_height - $thumb_height) / 2, // Center the image vertically
						0, 0,
						$new_width, $new_height,
						$width, $height);
				imagejpeg($thumb, $filename, 90);
			}
			$address_picture = $address_picture."|".$width."|".$height;
		}
				
		$address_index="news/".$id."index.dtx" ;
		$news_index=explode(chr(13),$news_index);
		$f=fopen($ajaxDir.$address_index , "w");
		foreach($news_index as $buf )
		{
			fputs($f , $buf);
		}
		fclose($f);
				
		$address_attachment = '';
		if($attachment != '' && $attachment_type != 'php' && $attachment_type != 'asp' && $attachment_type != 'aspx')
		{
			$attachment=explode(' ',$attachment);
			$attachment=implode('',$attachment);
			$address_attachment= "news/".$id."dl".$attachment;
			move_uploaded_file($attachment_file, $ajaxDir.$address_attachment);

		}
				
		$date = date("F d, Y");
		$time = date("G:i");
		$jdate = jdate("j F Y");
		$jtime = jdate("G:i");
			
		$sql = "INSERT INTO `newsbykk_".$sitelang."` (`id`, `category`, `name`, `summary`, `picture`, `picture_thumb`, `news_index`, `attachments`,
		`linkto`, `linkid`, `linktext`, `linkto2`, `linkid2`, `linktext2`, `showto`, `date`, `time`, `jdate`, `jtime`, `state`)
		VALUES ('$id', '$category', '$name', '$summary', '$address_picture', '$thumb_name', '$address_index', '$address_attachment',
		'$linkto', '$linkid', '$linktext', '$linkto2', '$linkid2', '$linktext2', '$showto', '$date', '$time', '$jdate', '$jtime', '1');";
			
		$result = mysql_query($sql, $db);
		if($result == false )
			echo mysql_error();
		else
		{
			?>
			<img alt="correct" src="../images/correct.png" style="float: left;position: relative;height: 60px;"/>
			<div style="font-size: 15px;color: #333;padding: 20px 5px;font-weight: bold;float:left;">News/Article Added</div>
			<script>
			setTimeout(function(){
				gotoPage('full',500,'index/news.php');
			},1000);
			</script>
			<?php
		}
	}
	else if($_GET["mode"] == 'edit' || $_GET["mode"] == 'applyedit')
	{
		?>
		<div style="opacity:0;width: 100%;height: 100%;" id="index-loader">
		<?php
		if($_GET["mode"] == 'applyedit')
		{
			$ajaxDir = "../";
				
			$id = $_POST["id"];
			
			$name = $_POST["news_name"];
			
			$category = $_POST["category"];
			
			$summary = $_POST["news_summary"];
			$summary = explode("\n", $summary);
			$summary = implode("<br>", $summary);
			$summary = mysql_real_escape_string($summary);
				
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
			if($linkto2 == '0' || $linkto2 == '5')
				$linktext2 = '';
			$linkto2 = $linkto2_lang."|".$linkto2;
				
			$showto = $_POST["showto"];
				
			$picture=$_FILES["picture"]["name"];
			$tmp_file=$_FILES["picture"]["tmp_name"];
			$type=$_FILES["picture"]["type"];
			$default_picture = $_POST["default_picture"];
			$default_picture_thumb = $_POST["default_picture_thumb"];
				
			$attachment=$_FILES["attachment"]["name"];
			$attachment_file=$_FILES["attachment"]["tmp_name"];
			$attachment_type=$_FILES["attachment"]["type"];
			$default_attachment=$_POST["default_attachment"];
				
			$news_index = $_POST["news_index"];
			if (get_magic_quotes_gpc()) $news_index = stripslashes($news_index);
			$news_index = htmlspecialchars($news_index, ENT_QUOTES,"UTF-8");
			
			if($_POST["delete_picture"])
			{
				if($default_picture != '')
					unlink($ajaxDir.$default_picture);
				if($default_picture_thumb != '')
					unlink($ajaxDir.$default_picture_thumb);
				$address_picture = '';
				$thumb_name = '';
			}
			else
			{
				$address_picture = $default_picture;
				$thumb_name = $default_picture_thumb;
			}
			if($picture != '')
			{
				if($type == "image/jpeg" || $type == "image/png" || $type == "image/gif" )
				{
					$picture=explode(' ',$picture);
					$picture=implode('',$picture);
					$address_picture= "news/".$id.rand(1000000,9999999).".jpg";
					move_uploaded_file($tmp_file, $ajaxDir.$address_picture);
				
				
					//$image_name = $address_picture;    // Full path and image name with extension
					$thumb_name = "news/".$id."thumb".rand(1000000,9999999).".jpg";  // Generated thumbnail name without extension
				
					$image = imagecreatefromstring(file_get_contents($ajaxDir.$address_picture));
				
					$filename = $ajaxDir.$thumb_name;
				
					$thumb_width = 223;
					$thumb_height = 350;
				
					$width = imagesx($image);
					$height = imagesy($image);
				
					$original_aspect = $width / $height;
					$thumb_aspect = $thumb_width / $thumb_height;
				
					if($original_aspect >= 0.637)
					{
						$thumb = imagecreatetruecolor(223, (223/$original_aspect));
						imagecopyresampled($thumb,
								$image,
								0, 0,
								0, 0,
								223, (223/$original_aspect),
								$width, $height);
						imagejpeg($thumb, $filename, 90);
					}
					else
					{
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
				
						imagefilter($thumb, IMG_FILTER_COLORIZE, 255, 255, 255);
				
						// Resize and crop
						imagecopyresampled($thumb,
								$image,
								0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
								0 - ($new_height - $thumb_height) / 2, // Center the image vertically
								0, 0,
								$new_width, $new_height,
								$width, $height);
						imagejpeg($thumb, $filename, 90);
					}
					$address_picture = $address_picture."|".$width."|".$height;
				}	
			}
			
			$address_index="news/".$id."index.dtx" ;
			$news_index=explode(chr(13),$news_index);
			$f=fopen($ajaxDir.$address_index , "w");
			foreach($news_index as $buf )
			{
				fputs($f , $buf);
			}
			fclose($f);
				
			if($_POST["delete_attachment"])
			{
				if($default_attachment != '')
					unlink($ajaxDir.$default_attachment);
				$address_attachment = '';
			}
			else
				$address_attachment = $default_attachment;
			if($attachment != '')
			{
				if($attachment != '' && $attachment_type != 'php' && $attachment_type != 'asp' && $attachment_type != 'aspx')
				{
					$attachment=explode(' ',$attachment);
					$attachment=implode('',$attachment);
					$address_attachment= "news/".$id."dl".$attachment;
					move_uploaded_file($attachment_file, $ajaxDir.$address_attachment);
			
				}
			}
			
			$query = mysql_query("UPDATE newsbykk_".$sitelang." SET category = '$category', name = '$name', summary = '$summary', picture='$address_picture', 
					picture_thumb = '$thumb_name', news_index='$address_index', attachments ='$address_attachment', linkto = '$linkto', 
					linkid = '$linkid', linktext = '$linktext', `linkto2` = '$linkto2',`linkid2` = '$linkid2', `linktext2` = '$linktext2', showto='$showto' WHERE id='$id' ;", $db);
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
			}
		}
		
		if(isset($_GET['id']))
			$id = $_GET['id'];
		else
			$id = $_POST['id'];
			
		$query = mysql_query("SELECT * FROM newsbykk_".$sitelang." WHERE state = 1 AND id = '$id' ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		if($nrow=mysql_fetch_row($query))
		{
		?>
		<div id="delete_dialogN" title="Delete News" style="display: none;">
		<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are You Sure?
		</div>
		<script type="text/javascript">
		var deleteNID=0;
		
		function deleteNews(nid)
		{
			deleteNID = nid;
			$("#delete_dialogN").dialog("open");
		}

		$(function() {
			$("#delete_dialogN").dialog({
				autoOpen: false,
				resizable: false,
				height:120,
				modal: true,
				buttons: {
					"Yes": function() {
						$.get('index/addnews.php?mode=delete&id='+deleteNID,function()
						{
							gotoPage('full',500,'index/news.php');
						});
						$( this ).dialog( "close" );
					},
					"Cancel": function() {
						$( this ).dialog( "close" );
					}
				}
			});
		});

		$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=addnews&id=<?php echo $id; ?>', function() {
			$("#page-nav").animate({'opacity':'1'}, 300);
			});
		
		$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
		"<div class='btn add' onclick='addNews();' title='Add news/article' ></div><div class='btn change' onclick='editNews(<?php echo $id; ?>);' title='Edit this!' ></div><div class='btn delete' onclick='deleteNews(<?php echo $id; ?>);' title='Delete news/article' ></div>"
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
		</script>
			<div style="width: 100%;height: 100%;overflow: hidden;" id="addnews-container">
				<div class="div-title">EDIT NEWS/ARTICLE</div>
				<form action="index/addnews.php?mode=applyedit" method="POST" enctype="multipart/form-data" id="addnews_form" >
					<input type="hidden" name="id" value="<?php echo $nrow[0]; ?>">
					<div class="div-row">
						<div class="input-div" >
							<div class="lable" ><span class="red" >*</span>name</div>
							<input type="text" class="textbykk" id="news_name" name="news_name" style="width: 400px;" value="<?php echo $nrow[2]; ?>" >
						</div>
						<div class="input-div" >
							<div class="lable" ><span class="red" >*</span>category</div>
							<select class="textbykk" id="category" name="category" style="width: 412px;" >
								<option value="News" <?php if($nrow[1] == "News") echo "selected";?> >News</option>
								<option value="Article" <?php if($nrow[1] == "Artikel") echo "selected";?> >Artikel</option>
							</select>
						</div>
					</div>
					<div class="div-row">
						<div class="input-div" style="width: 845px;" >
							<div class="lable" >Summary (1024 characters max!)</div>
							<textarea class="textbykk" name="news_summary" id="news_summary" style="width: 840px;height: 75px;"><?php $x = explode("<br>",$nrow[3]); $x = implode("\n", $x); echo $x; ?></textarea>
						</div>
					</div>
					<div class="div-row">
						<div class="input-div" style="width: 80%;" >
							<div class="lable" ><span class="red" >*</span>Show to</div>
							<select class="textbykk" name="showto" id="showto" style="width: 412px;" >
								<option value="1" <?php if($nrow[14] == 1) echo "selected";?> >All</option>
								<option value="2" <?php if($nrow[14] == 2) echo "selected";?> >Users</option>
								<option value="3" <?php if($nrow[14] == 3) echo "selected";?> >Level 1 users</option>
								<option value="4" <?php if($nrow[14] == 4) echo "selected";?> >Level 2 users</option>
								<option value="5" <?php if($nrow[14] == 5) echo "selected";?> >Level 3 users</option>
								<option value="0" <?php if($nrow[14] == 0) echo "selected";?> >Just admins</option>
							</select>
						</div>
					</div>
					<div class="div-row">
						<div class="input-div" >
							<div class="lable" ><span class="red" >*</span>Link to #1</div>
							<select class="textbykk" id="linkto_lang" name="linkto_lang" style="width: 100px;margin-right: 5px;" >
							<?php 
							$linkto_lang = explode("|", $nrow[8]);
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
							$select = explode("|", $nrow[8]);
							$selectedMode = $select[1];
							$selectedID = $nrow[9];
							$selectedLang = $select[0];
							$selectedLink = '';
							include 'slidepnlist.php';
							?>
						</div>
					</div>
					<div class="div-row" id="linktext_container" style="<?php if($linkto == '0') echo 'display:none;'; ?>width: 80%;overflow: hidden;min-height: 0;" >
						<div class="input-div" >
							<div class="lable" >Link text</div>
							<input class="textbykk" type="text" id="linktext" name="linktext" style="width: 400px;" value="<?php echo $nrow[10]; ?>">
						</div>
					</div>
					<div class="div-row">
						<div class="input-div" >
							<div class="lable" ><span class="red" >*</span>Link to #2</div>
							<select class="textbykk" id="linkto2_lang" name="linkto2_lang" style="width: 100px;margin-right: 5px;" >
							<?php 
							$linkto2_lang = explode("|", $nrow[11]);
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
							$select = explode("|", $nrow[11]);
							$selectedMode = $select[1];
							$selectedID = $nrow[12];
							$selectedLang = $select[0];
							$selectedLink = '2';
							include 'slidepnlist.php';
							?>
						</div>
					</div>
					<div class="div-row" id="linktext_container2" style="<?php if($linkto2 == '0') echo 'display:none;'; ?>width: 80%;overflow: hidden;min-height: 0;" >
						<div class="input-div" >
							<div class="lable" >Link text</div>
							<input class="textbykk" type="text" id="linktext2" name="linktext2" style="width: 400px;" value="<?php echo $nrow[13]; ?>">
						</div>
					</div>
					<div class="div-row" >
						<div class="input-div" >
							<div class="lable" >Picture</div>
							<input type="file" class="textbykk" id="picture" name="picture" style="width: 400px;" >
							<input type="hidden" name="default_picture" value="<?php echo $nrow[4]; ?>">
							<input type="hidden" name="default_picture_thumb" value="<?php echo $nrow[5]; ?>">
						</div>
						<?php 
						if($nrow[5] != '')
						{
							?>
							<div style="position: relative;float: left;margin-left: 25px;">
								<img src="<?php echo $nrow[5]; ?>" style="height:60px;float:right;box-shadow:0 1px 3px rgba(0,0,0,0.5);" />
								<span style="z-index:299;position: absolute;float: left;bottom:0px;right:0px;left:0;background-color: rgba(0,0,0,0.6);color:#fff;padding: 1px 5px;font-size: 10px;vertical-align: middle;"><input type="checkbox" name="delete_picture" style="margin: 1px;float: left;" ><span style="float: left;margin-bottom: 3px;">DEL</span></span>
							</div>
							<?php 
						}
						?>
					</div>
					<div class="div-row" >
						<div class="input-div" >
							<div class="lable" >Attachments</div>
							<input type="file" class="textbykk" id="attachment" name="attachment" style="width: 400px;">
							<input type="hidden" name="default_attachment" value="<?php echo $nrow[7]; ?>">
						</div>
						<?php
						if($nrow[7] != '')
						{
						?>
						<div style="position: absolute;float: left;bottom: 2px;left:462px">
							<div id="news_attachment" ><a href="<?php echo $nrow[7];?>" target="_blank" class="download"><?php echo $nrow[7];?></a></div>
							<span style="position: absolute;float: left;bottom:0px;left:0px;background-color: rgba(0,0,0,0.6);color:#fff;padding: 2px;font-size: 10px;"><input type="checkbox" name="delete_attachment" >DEL</span>
						</div>
						<?php 
						}
						?>
					</div>
					<div class="div-row" >
						<div class="input-div" style="width: 845px;" >
							<div class="lable" >News Index</div>
							<textarea name="news_index" id="news_index" ><?php 
							$check = false;
							$f = fopen("../".$nrow[6], "r");
							if($f===false)
								die("'".$nrow[6]."' doesn't exist.");
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
							?></textarea>
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
			$("#news_index").jqte();
			function newsBeforeSend()
			{
				if($("#addnews_form #news_name").val().length < 2)
				{
					$("#addnews_form #news_name").removeClass("green").addClass("red");
					return false;
				}
				else
				{
					$("#addnews_form #news_name").removeClass("red").addClass("green");
					progressBar(300, 60);
					return true;
				}
			}
			$(document).ready(function() { 
			    $('#addnews_form').ajaxForm({ 
			        target: '#main-index', 
			        success: function() { 
	            		progressBar(300, 100);
	            		$('#index-loader').animate({'opacity':'1'},300);
			        	//$('#success_dialog').css({'display':'block'}).animate({'opacity' : '1'},300);
			        } 
			    	,
			    	beforeSubmit: newsBeforeSend
			    }); 
			});
			</script>
			</div>
		<?php
		}
	}
	else if($_GET["mode"] == 'delete')
	{
		//include 'database.php';
		$id = $_GET["id"];
		$query = mysql_query("UPDATE newsbykk_".$sitelang." SET state = '0' WHERE id='$id' ;", $db);
		if(!$query)
			echo mysql_error();
	}
	else
	{
	?>
	<div style="opacity:0;width: 100%;height: 100%;" id="index-loader">
	<script type="text/javascript">
	$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=addnews', function() {
		$("#page-nav").animate({'opacity':'1'}, 300);
		});
	$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
	"<div class='btn add' onclick='addNews();' title='Add news/article' ></div>"
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
	</script>
		<div id="success_dialog" style="display: none;opacity:0;top: 50%;height: 60px;">
		</div>
		<div style="width: 100%;height: 100%;overflow: hidden;" id="addnews-container">
			<div class="div-title">ADD NEWS/ARTICLE</div>
			<form action="index/addnews.php?mode=add" method="POST" enctype="multipart/form-data" id="addnews_form" >
				<div class="div-row">
					<div class="input-div" >
						<div class="lable" ><span class="red" >*</span>name</div>
						<input type="text" class="textbykk" id="news_name" name="news_name" style="width: 400px;" >
					</div>
					<div class="input-div" >
						<div class="lable" ><span class="red" >*</span>category</div>
						<select class="textbykk" id="category" name="category" style="width: 412px;" >
							<option value="News" >News</option>
							<option value="Article" >Artikel</option>
						</select>
					</div>
				</div>
				<div class="div-row">
					<div class="input-div" style="width: 845px;" >
						<div class="lable" >Summary (1024 characters max!)</div>
						<textarea class="textbykk" name="news_summary" id="news_summary" style="width: 840px;height: 75px;"></textarea>
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
						<div class="lable" >Picture</div>
						<input type="file" class="textbykk" id="picture" name="picture" style="width: 400px;" >
					</div>
				</div>
				<div class="div-row" >
					<div class="input-div" >
						<div class="lable" >Attachments</div>
						<input type="file" class="textbykk" id="attachment" name="attachment" style="width: 400px;">
					</div>
				</div>
				<div class="div-row" >
					<div class="input-div" style="width: 845px;" >
						<div class="lable" >News Index</div>
						<textarea name="news_index" id="news_index" ></textarea>
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
		$("#news_index").jqte();
		function newsBeforeSend()
		{
			if($("#addnews_form #news_name").val().length < 2)
			{
				$("#addnews_form #news_name").removeClass("green").addClass("red");
				return false;
			}
			else
			{
				$("#addnews_form #news_name").removeClass("red").addClass("green");
				progressBar(300, 60);
				return true;
			}
		}
		$(document).ready(function() { 
		    $('#addnews_form').ajaxForm({ 
		        target: '#success_dialog', 
		        success: function() { 
		        	progressBar(300, 80);
		        	$('#addnews-container').animate({'opacity':'0.0','height':'600px'},1000, function(){
	            		$('#addnews-container').remove();
	            		progressBar(300, 100);
	               	});
		        	$('#success_dialog').css({'display':'block'}).animate({'opacity' : '1'},300);
		        } 
		    	,
		    	beforeSubmit: newsBeforeSend
		    }); 
		});
		</script>
		</div>
<?php 
	}
}
?>