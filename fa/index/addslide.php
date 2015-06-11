<?php 
include 'database.php';
if($isAdmin)
{
	if($_GET["mode"] == 'addthis' || !isset($_GET["mode"]))
	{
		if($_GET["mode"] == 'addthis' && $_POST["addslide"] == '1')
		{
			include 'jdf.php';
			$ajaxDir = "../";
		
			$picture=$_FILES["picture"]["name"];
			$tmp_file=$_FILES["picture"]["tmp_name"];
			$type=$_FILES["picture"]["type"];
		
			$linkto_lang = $_POST["linkto_lang"];
			$linkto = $_POST["linkto"];
			$linkid = $_POST["linkid"];
			if($linkto == '4')
				$linkid = $_POST["linkaddress"];
			$linkto = $linkto_lang."|".$linkto;
				
			$showto = $_POST["showto"];
		
			$query = mysql_query("SELECT id FROM slidebykk_".$sitelang." ORDER BY id  DESC ;", $db);
			if (!$query)
				die("Error reading query: ".mysql_error());
				
			if( $rows=mysql_fetch_row($query) )
				$id = $rows[0] + 1;
			else
				$id = 1000;
				
			$address_picture = '';
			$thumb_name1 = '';
			$thumb_name2 = '';
			$original_picture = '';
			if($type == "image/jpeg" || $type == "image/png" || $type == "image/gif" )
			{
				$picture=explode(' ',$picture);
				$picture=implode('',$picture);
				$address_picture= "slide/".$id.rand(1000000,9999999).".jpg";
				move_uploaded_file($tmp_file, $ajaxDir.$address_picture);
					
					
				//$image_name = $address_picture;    // Full path and image name with extension
				$thumb_name1 = "slide/".$id."fix".rand(1000000,9999999).".jpg";   // Generated thumbnail name without extension
					
				$image = imagecreatefromstring(file_get_contents($ajaxDir.$address_picture));
					
				$filename = $ajaxDir.$thumb_name1;
					
				$thumb_width = 1500;
				$thumb_height = 700;
					
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
				////////
		
				$thumb_name2 = "slide/".$id."thumb".rand(1000000,9999999).".jpg";   // Generated thumbnail name without extension
		
				$image = imagecreatefromstring(file_get_contents($ajaxDir.$address_picture));
		
				$filename = $ajaxDir.$thumb_name2;
		
				$thumb_width = 290;
				$thumb_height = 135;
		
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
				
				$original_picture = $address_picture;
			}
		
			$date = date("F d, Y");
			$time = date("G:i");
			$jdate = jdate("j F Y");
			$jtime = jdate("G:i");
		
			$sql = "INSERT INTO `slidebykk_".$sitelang."` (`id`, `original_picture`, `picture`, `picture_thumb`, `linkto`, `linkid`,
			`showto`, `date`, `time`, `jdate`, `jtime`, `state`)
			VALUES ('$id', '$original_picture', '$thumb_name1', '$thumb_name2' , '$linkto' ,'$linkid',
			'$showto', '$date', '$time', '$jdate', '$jtime', '1');";
		
			$result = mysql_query($sql, $db);
			if($result == false )
				echo mysql_error();
			else
			{
			?>
			<div id="success_dialog" style="display: block;opacity:1;top: 40%;height: 60px;">
			<img alt="correct" src="../images/correct.png" style="float: right;position: relative;height: 60px;"/>
			<div style="font-size: 15px;color: #333;padding: 20px 5px;font-weight: bold;float:right;">اسلاید اضافه شد!</div>
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
		?>
		<div id="deleteS_dialog" title="حذف اسلاید" style="display: none;">
		<span class="ui-icon ui-icon-alert" style="float:right; margin:0 0 20px 7px;"></span>مطمئن هستید؟
		</div>
		<script>
		$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=addslide', function() {
			$("#page-nav").animate({'opacity':'1'}, 300);
			});
		var deleteSID=0;
		$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
			"<div class='btn add' onclick='addSlide();' title='افزودن اسلاید' ></div>"
			).animate({'opacity':'1'},300);
		function addSlide()
		{
			gotoPage('full', 500,'index/addslide.php?mode=add');
		}
		function deleteSlide(id)
		{
			deleteSID = id;
			$("#deleteS_dialog").dialog("open");
		}
		function editSlide(id)
		{
			gotoPage('full', 500,'index/addslide.php?mode=edit&id='+id);
		}
		$(function() {
			$("#deleteS_dialog").dialog({
				autoOpen: false,
				resizable: false,
				height:130,
				modal: true,
				buttons: {
					"بله": function() {
						$.get('index/addslide.php?mode=delete&id='+deleteSID, function()
							{
							gotoPage('full', 500,'index/addslide.php');
							});
						$( this ).dialog( "close" );
					},
					"خیر": function() {
						$( this ).dialog( "close" );
					}
				}
			});
		});
		</script>
		<div style="opacity:0;width: 100%;height: 100%;" id="index-loader">
		<div class="div-title">لیست اسلاید ها</div>
		<div id="slides-container" >
		<?php 
		$query = mysql_query("SELECT * FROM slidebykk_".$sitelang." WHERE state = 1 ORDER BY id  DESC ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		
		while( $rows=mysql_fetch_row($query) )
		{
		?>
		<div id="slide-item">
			<div class="control-container">
				<div class="btn delete" onclick="deleteSlide(<?php echo $rows[0]; ?>);"></div>
				<div class="btn edit" onclick="editSlide(<?php echo $rows[0]; ?>);"></div>
			</div>
			<img alt="<?php echo $rows[0]; ?>" src="<?php echo $rows[3]; ?>" >
			<div id="details">
			<?php 
			
			
			echo "<span style='position:absolute;bottom:5px;left:5px;font-weight: bold;' >قابل نمایش برای ";
			if($rows[6] == '1')
				echo "همه";
			else if($rows[6] == '2')
				echo "اعضا";
			else if($rows[6] == '3')
				echo "اعضای سطح  1";
			else if($rows[6] == '4')
				echo "اعضای سطح  2";
			else if($rows[6] == '5')
				echo "اعضای سطح  3";
			else if($rows[6] == '0')
				echo "فقط مدیر";
			echo "</span>";
			?>
			</div>
		</div>
		<?php 
		}
		?>
		</div>
		</div>
		<?php
	}
	else if($_GET["mode"] == "edit" || $_GET["mode"] == "applyedit")
	{
		?>
		<div style="opacity:0;width: 100%;height: 100%;" id="index-loader">
		<?php
		if($_GET["mode"] == "applyedit")
		{
			$ajaxDir = "../";
				
			$id = $_POST["id"];
				
			$picture=$_FILES["picture"]["name"];
			$tmp_file=$_FILES["picture"]["tmp_name"];
			$type=$_FILES["picture"]["type"];
			$default_original_picture = $_POST["default_original_picture"];
			$default_thumb1 = $_POST["default_thumb1"];
			$default_thumb2 = $_POST["default_thumb2"];
				
				
			$linkto_lang = $_POST["linkto_lang"];
			$linkto = $_POST["linkto"];
			$linkid = $_POST["linkid"];
			if($linkto == '4')
				$linkid = $_POST["linkaddress"];
			$linkto = $linkto_lang."|".$linkto;
			
			$showto = $_POST["showto"];
			
			$thumb_name1 = $default_thumb1;
			$thumb_name2 = $default_thumb2;
			$original_picture = $default_original_picture;
			if($picture != '')
			{
				$address_picture = '';
				if($type == "image/jpeg" || $type == "image/png" || $type == "image/gif" )
				{
					$picture=explode(' ',$picture);
					$picture=implode('',$picture);
					$address_picture= "slide/".$id.rand(1000000,9999999).".jpg";
					move_uploaded_file($tmp_file, $ajaxDir.$address_picture);
			
			
					//$image_name = $address_picture;    // Full path and image name with extension
					$thumb_name1 = "slide/".$id."fix".rand(1000000,9999999).".jpg";   // Generated thumbnail name without extension
			
					$image = imagecreatefromstring(file_get_contents($ajaxDir.$address_picture));
			
					$filename = $ajaxDir.$thumb_name1;
			
					$thumb_width = 1500;
					$thumb_height = 700;
			
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
					////////
			
					$thumb_name2 = "slide/".$id."thumb".rand(1000000,9999999).".jpg";   // Generated thumbnail name without extension
			
					$image = imagecreatefromstring(file_get_contents($ajaxDir.$address_picture));
			
					$filename = $ajaxDir.$thumb_name2;
			
					$thumb_width = 290;
					$thumb_height = 135;
			
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
					
					$original_picture = $address_picture;
				}
			}
			
			$sql = "UPDATE `slidebykk_".$sitelang."` SET `original_picture` = '$original_picture', `picture` = '$thumb_name1', 
			`picture_thumb` = '$thumb_name2', `linkto` = '$linkto', `linkid` = '$linkid' , `showto` = '$showto' WHERE id = '$id' ;";
			$query = mysql_query($sql,$db);
			if($query)
			{
				?>
				<div id="success_dialog" style="display: block;opacity:1;top: 40%;height: 60px;">
				<img alt="correct" src="../images/correct.png" style="float: right;position: relative;height: 60px;"/>
				<div style="font-size: 15px;color: #333;padding: 20px 5px;font-weight: bold;float:right;">تغییرات اعمال شد!</div>
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
		
		$query = mysql_query("SELECT * FROM slidebykk_".$sitelang." WHERE state = 1 AND id = '$id' ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		if($srow=mysql_fetch_row($query))
		{
		?>
		<script type="text/javascript">
		$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=addslide&id=<?php echo $id; ?>', function() {
			$("#page-nav").animate({'opacity':'1'}, 300);
			});
		$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
		"<div class='btn add' onclick='addSlide();' title='افزودن اسلاید' ></div>"
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
		function cropSlideImage(id,picture_url)
		{
			var cropCommand = "";
			cropCommand = "&mode=slide&lang=fa&id="+id;
			cropCommand = encodeURIComponent(cropCommand);
			$("#crop-overlay").load('index/imagecrop.php?picture='+encodeURIComponent(picture_url)+'&width=750&height=350&forcefull=yes&command='+cropCommand,function(){
				$("#crop-overlay").css({'display':'block'}).animate({'opacity':'1'},300);
				var ccropWidth = $("#crop-overlay .container").outerWidth();
				var ccropHeight = $("#crop-overlay .container").outerHeight();
				$("#crop-overlay .container").css({'margin-right':-(ccropWidth/2)+'px','margin-top':-(ccropHeight/2)+'px'});
			});
		}
		</script>
			<div style="width: 100%;height: 100%;overflow: hidden;" id="addslide-container">
				<div class="div-title">تغییر اسلاید</div>
				<form action="index/addslide.php?mode=applyedit" method="POST" enctype="multipart/form-data" id="addslide_form" >
					<input type="hidden" name="id" value="<?php echo $srow[0]; ?>" >
					<div class="div-row" >
						<div class="input-div" >
							<div class="lable" >تصویر</div>
							<input type="file" class="textbykk" id="picture" name="picture" style="width: 400px;" >
							<input type="hidden" name="default_original_picture" value="<?php echo $srow[1]; ?>">
							<input type="hidden" name="default_thumb1" value="<?php echo $srow[2]; ?>">
							<input type="hidden" name="default_thumb2" value="<?php echo $srow[3]; ?>">
						</div>
						<?php 
						if($srow[3] != '')
						{
							?>
							<div style="position: relative;float: right;margin-right: 25px;margin-top: 10px" id="main-picture">
								<img src="<?php echo $srow[3]; ?>" style="height:60px;float:left;box-shadow:0 1px 3px rgba(0,0,0,0.5);" />
								<span id="cropimage" style="z-index:299;position: absolute;float: right;top:0px;left:0px;right:0;background-color: rgba(255,255,255,0.5);color:#fff;text-align: center;height: 100%;opacity:0;display: none;"><img src="../images/cropimage.png" style="margin: 12px;cursor: pointer;" title="crop image" onclick="cropSlideImage(<?php echo $srow[0];?>,'<?php echo $srow[1]; ?>');"></span>
							</div>
							<?php 
						}
						?>
					</div>
					<div class="div-row">
						<div class="input-div" >
							<div class="lable" ><span class="red" >*</span>لینک به #1</div>
							<select class="textbykk" id="linkto_lang" name="linkto_lang" style="width: 100px;margin-left: 5px;" >
								<?php 
								$linkto_lang = explode("|", $srow[4]);
								$linkto = $linkto_lang[1];
								$linkto_lang = $linkto_lang[0];
								?>
								<option value="fa" <?php if($linkto_lang == "fa") echo "selected";?> >فارسی</option>
								<option value="en" <?php if($linkto_lang == "en") echo "selected";?> >انگلیسی</option>
								<option value="de" <?php if($linkto_lang == "de") echo "selected";?> >آلمانی</option>
							</select>
							<select class="textbykk" id="linkto" name="linkto" onchange="linklist(this.value);" style="width: 302px;" >
								<option value="0" <?php if($linkto == "0") echo "selected";?> >-</option>
								<option value="1" <?php if($linkto == "1") echo "selected";?> >محصولات</option>
								<option value="2" <?php if($linkto == "2") echo "selected";?> >خبر/مقاله</option>
								<option value="3" <?php if($linkto == "3") echo "selected";?> >گالری</option>
								<option value="4" <?php if($linkto == "4") echo "selected";?> >وبسایت</option>
								<option value="5" <?php if($linkto == "5") echo "selected";?> >فرم</option>
							</select>
						</div>
						<div class="input-div" id="linkidajax" >
							<?php 
							$select = explode("|", $srow[4]);
							$selectedMode = $select[1];
							$selectedID = $srow[5];
							$selectedLang = $select[0];
							$selectedLink = '';
							include 'slidepnlist.php';
							?>
						</div>
					</div>
					<div class="div-row">
						<div class="input-div" style="width: 80%;" >
							<div class="lable" ><span class="red" >*</span>قابلیت نمایش</div>
							<select class="textbykk" name="showto" id="showto" style="width: 412px;" >
								<option value="1" <?php if($srow[6] == 1) echo "selected";?> >همه</option>
								<option value="2" <?php if($srow[6] == 2) echo "selected";?> >اعضا</option>
								<option value="3" <?php if($srow[6] == 3) echo "selected";?> >اعضای سطح 1</option>
								<option value="4" <?php if($srow[6] == 4) echo "selected";?> >اعضای سطح 2</option>
								<option value="5" <?php if($srow[6] == 5) echo "selected";?> >اعضای سطح 3</option>
								<option value="0" <?php if($srow[6] == 0) echo "selected";?> >فقط مدیر</option>
							</select>
						</div>
					</div>
					<div class="div-row" >
						<div class="input-div" >
							<input type="submit" class="btnbykk" value="اعمال تغییرات" style="width: 412px;">
						</div>
					</div>
				</form>
			</div>
			<script type="text/javascript">
			$("#main-picture").mouseenter(function(){
				$("#cropimage").stop().css({'display':'block'}).animate({'opacity':'1'},300);
			}).mouseleave(function(){
				$("#cropimage").stop().animate({'opacity':'0'},300,function(){
					$(this).css({'display':'none'});
				});
			});
			function slideBeforeSend()
			{
				progressBar(300, 60);
				return true;
			}
			$(document).ready(function() { 
			    $('#addslide_form').ajaxForm({  
			        target: '#main-index',  
			        success: function() { 
			        	$("#index-loader").animate({'opacity':'1'},300);
						progressBar(300, 100);
			        } 
			    	,
			    	beforeSubmit: slideBeforeSend
			    }); 
			});
			</script>
		</div>
		<?php
		}
	}
	else if($_GET["mode"] == "delete")
	{
		$id = $_GET["id"];
		$query = mysql_query("UPDATE slidebykk_".$sitelang." SET state = '0' WHERE id='$id' ;", $db);
		if(!$query)
			echo mysql_error();
	}
	else if ($_GET["mode"] == 'add')
	{
	?>
	<div style="opacity:0;width: 100%;height: 100%;" id="index-loader">
	<script type="text/javascript">
	$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=addslide&mode=add', function() {
		$("#page-nav").animate({'opacity':'1'}, 300);
		});
	$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
	"<div class='btn add' onclick='addSlide();' title='افزودن اسلاید' ></div>"
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
	</script>
		<div style="width: 100%;height: 100%;overflow: hidden;" id="addslide-container">
			<div class="div-title">افزودن اسلاید</div>
			<form action="index/addslide.php?mode=addthis" method="POST" enctype="multipart/form-data" id="addslide_form" >
				<input type="hidden" name="addslide" value="1" >
				<div class="div-row" >
					<div class="input-div" >
						<div class="lable" >تصویر</div>
						<input type="file" class="textbykk" id="picture" name="picture" style="width: 400px;" >
					</div>
				</div>
				<div class="div-row">
					<div class="input-div" >
						<div class="lable" ><span class="red" >*</span>لینک به</div>
						<select class="textbykk" id="linkto_lang" name="linkto_lang" style="width: 100px;margin-right: 5px;" >
							<option value="fa" >فارسی</option>
							<option value="en" >انگلیسی</option>
							<option value="de" >آلمانی</option>
						</select>
						<select class="textbykk" id="linkto" name="linkto" onchange="linklist(this.value);" style="width: 302px;" >
							<option value="0" >-</option>
							<option value="1" >محصول</option>
							<option value="2" >خبر/مقاله</option>
							<option value="3" >گالری</option>
							<option value="4" >وبسایت</option>
							<option value="5" >فرم</option>
						</select>
					</div>
					<div class="input-div" id="linkidajax" >
						<div class="lable" >&nbsp;</div>
						<select class="textbykk" id="linkid" name="linkid" disabled="disabled" style="width: 412px;" >
							<option value="0" selected="selected"></option>
						</select>
					</div>
				</div>
				<div class="div-row">
					<div class="input-div" style="width: 80%;" >
						<div class="lable" ><span class="red" >*</span>قابلیت نمایش</div>
						<select class="textbykk" name="showto" id="showto" style="width: 412px;" >
							<option value="1" >همه</option>
							<option value="2" >اعضا</option>
							<option value="3" >اعضای سطح 1</option>
							<option value="4" >اعضای سطح 2</option>
							<option value="5" >اعضای سطح 3</option>
							<option value="0" >فقط مدیر</option>
						</select>
					</div>
				</div>
				<div class="div-row" >
					<div class="input-div" >
						<input type="submit" class="btnbykk" value="افزودن!" style="width: 412px;">
					</div>
				</div>
			</form>
		</div>
		<script type="text/javascript">
		function slideBeforeSend()
		{
			if($("#addslide_form #picture").val().length < 5)
			{
				$("#addslide_form #picture").removeClass("green").addClass("red");
				return false;
			}
			else
			{
				$("#addslide_form #picture").removeClass("red").addClass("green");
				progressBar(300, 60);
				return true;
			}
		}
		$(document).ready(function() { 
		    $('#addslide_form').ajaxForm({  
		        target: '#main-index',  
		        success: function() { 
		        	$("#index-loader").animate({'opacity':'1'},300);
					progressBar(300, 100);
		        } 
		    	,
		    	beforeSubmit: slideBeforeSend
		    }); 
		});
		</script>
	</div>
	<?php
	}
}
?>