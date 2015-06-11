<?php
include 'database.php';
if($_GET["mode"] == 'addsection' && $isAdmin)
{
	?>
	<div style="opacity:0;width: 100%;height: 100%;" id="index-loader">
		<div class="div-title">ADD ABOUT SECTION</div>
		<form action="index/about.php?mode=addthissection" method="POST" enctype="multipart/form-data" id="addaboutsection_form" >
			<input type="hidden" name="addsection" value="1" >
			<div class="div-row" >
				<div class="input-div" >
					<div class="lable" ><span class="red">*</span>Title</div>
					<input type="text" class="textbykk" id="about_name" name="about_name" style="width: 400px;" >
				</div>
				<div class="input-div" >
					<div class="lable" >Note</div>
					<input type="text" class="textbykk" id="about_note" name="about_note" style="width: 400px;" >
				</div>
			</div>
			<div class="div-row" >
				<div class="input-div" >
					<div class="lable" >Picture</div>
					<input type="file" class="textbykk" id="picture" name="picture" style="width: 400px;" >
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
			<div class="div-row" >
				<div class="input-div" style="width: 845px;" >
					<div class="lable" >Section Index</div>
					<textarea name="about_index" id="about_index" ></textarea>
				</div>
			</div>
			<div class="div-row" >
				<div class="input-div" >
					<input type="submit" class="btnbykk" value="Add!" style="width: 412px;">
				</div>
			</div>
		</form>
		<script type="text/javascript">
		$("#about_index").jqte();
		function aboutBeforeSend()
		{
			if($("#addaboutsection_form #about_name").val().length < 3)
			{
				$("#addaboutsection_form #about_name").removeClass("green").addClass("red");
				return false;
			}
			else
			{
				$("#addaboutsection_form #about_name").removeClass("red").addClass("green");
				progressBar(300, 60);
				return true;
			}
		}
		$(document).ready(function() { 
		    $('#addaboutsection_form').ajaxForm({  
		        target: '#main-index',  
		        success: function() { 
		        	$("#index-loader").animate({'opacity':'1'},300);
					progressBar(300, 100);
		        } 
		    	,
		    	beforeSubmit: aboutBeforeSend
		    }); 
		});
		</script>
	</div>
	<?php
}
else if(($_GET["mode"] == 'edit' || $_GET["mode"] == 'applyedit' )&& $isAdmin)
{
	?>
	<div style="opacity:0;width: 100%;height: 100%;" id="index-loader">
	<?php
	if($_GET["mode"] == 'applyedit')
	{
		include 'jdf.php';
		
		$ajaxDir = "../";
			
		$id = $_POST["id"];
		
		$name = $_POST["about_name"];
		
		$note = $_POST["about_note"];
			
		$picture=$_FILES["picture"]["name"];
		$tmp_file=$_FILES["picture"]["tmp_name"];
		$type=$_FILES["picture"]["type"];
		$default_picture = $_POST["default_picture"];
		$default_picture_thumb = $_POST["default_picture_thumb"];
		
		$showto = $_POST["showto"];
		
		$about_index = $_POST["about_index"];
		if (get_magic_quotes_gpc()) $about_index = stripslashes($about_index);
		$about_index = htmlspecialchars($about_index, ENT_QUOTES,"UTF-8");
			
		
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
				$address_picture= "aboutandcontact/".$id.rand(1000000,9999999).".jpg";
				move_uploaded_file($tmp_file, $ajaxDir.$address_picture);
			
			
				//$image_name = $address_picture;    // Full path and image name with extension
				$thumb_name = "aboutandcontact/".$id."thumb".rand(1000000,9999999).".jpg";	// Generated thumbnail name without extension
			
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
			}
		}
		
		$address_index="aboutandcontact/".$id."index.dtx" ;
		$about_index=explode(chr(13),$about_index);
		$f=fopen($ajaxDir.$address_index , "w");
		foreach($about_index as $buf )
		{
			fputs($f , $buf);
		}
		fclose($f);
		
		$query = mysql_query("UPDATE aboutbykk_".$sitelang." SET name = '$name', about_note = '$note', picture='$address_picture',
				picture_thumb = '$thumb_name', about_index='$address_index', showto='$showto' WHERE id='$id' ;", $db);
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
		
	$query = mysql_query("SELECT * FROM aboutbykk_".$sitelang." WHERE state = 1 AND id = '$id' ;", $db);
	if (!$query)
		die("Error reading query: ".mysql_error());
	if($arow=mysql_fetch_row($query))
	{
	?>
		<div class="div-title">EDIT ABOUT SECTION</div>
		<form action="index/about.php?mode=applyedit" method="POST" enctype="multipart/form-data" id="addaboutsection_form" >
			<input type="hidden" name="id" value="<?php echo $arow[0]; ?>" >
			<div class="div-row" >
				<div class="input-div" >
					<div class="lable" ><span class="red">*</span>Title</div>
					<input type="text" class="textbykk" id="about_name" name="about_name" style="width: 400px;" value="<?php echo $arow[1]; ?>" >
				</div>
				<div class="input-div" >
					<div class="lable" >Note</div>
					<input type="text" class="textbykk" id="about_note" name="about_note" style="width: 400px;" value="<?php echo $arow[2]; ?>" >
				</div>
			</div>
			<div class="div-row" >
				<div class="input-div" >
					<div class="lable" >Picture</div>
					<input type="file" class="textbykk" id="picture" name="picture" style="width: 400px;" >
					<input type="hidden" name="default_picture" value="<?php echo $arow[3]; ?>">
					<input type="hidden" name="default_picture_thumb" value="<?php echo $arow[4]; ?>">
				</div>
				<?php 
				if($arow[4] != '')
				{
					?>
					<div style="position: relative;float: left;margin-left: 25px;">
						<img src="<?php echo $arow[4]; ?>" style="height:60px;float:right;box-shadow:0 1px 3px rgba(0,0,0,0.5);" />
						<span style="z-index:299;position: absolute;float: left;bottom:0px;right:0px;left:0;background-color: rgba(0,0,0,0.6);color:#fff;padding: 1px 5px;font-size: 10px;vertical-align: middle;"><input type="checkbox" name="delete_picture" style="margin: 1px;float: left;" ><span style="float: left;margin-bottom: 3px;">DEL</span></span>
					</div>
					<?php 
				}
				?>
			</div>
			<div class="div-row">
				<div class="input-div" style="width: 80%;" >
					<div class="lable" ><span class="red" >*</span>Show to</div>
					<select class="textbykk" name="showto" id="showto" style="width: 412px;" >
						<option value="1" <?php if($arow[6] == 1) echo "selected";?> >All</option>
						<option value="2" <?php if($arow[6] == 2) echo "selected";?> >Users</option>
						<option value="3" <?php if($arow[6] == 3) echo "selected";?> >Level 1 users</option>
						<option value="4" <?php if($arow[6] == 4) echo "selected";?> >Level 2 users</option>
						<option value="5" <?php if($arow[6] == 5) echo "selected";?> >Level 3 users</option>
						<option value="0" <?php if($arow[6] == 0) echo "selected";?> >Just admins</option>
					</select>
				</div>
			</div>
			<div class="div-row" >
				<div class="input-div" style="width: 845px;" >
					<div class="lable" >Section Index</div>
					<textarea name="about_index" id="about_index" ><?php 
					$check = false;
					$f = fopen("../".$arow[5], "r");
					if($f===false)
						echo "'".$arow[5]."' doesn't exist.";
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
		<script type="text/javascript">
		$("#about_index").jqte();
		function aboutBeforeSend()
		{
			if($("#addaboutsection_form #about_name").val().length < 3)
			{
				$("#addaboutsection_form #about_name").removeClass("green").addClass("red");
				return false;
			}
			else
			{
				$("#addaboutsection_form #about_name").removeClass("red").addClass("green");
				progressBar(300, 60);
				return true;
			}
		}
		$(document).ready(function() { 
		    $('#addaboutsection_form').ajaxForm({  
		        target: '#main-index',  
		        success: function() { 
		        	$("#index-loader").animate({'opacity':'1'},300);
					progressBar(300, 100);
		        } 
		    	,
		    	beforeSubmit: aboutBeforeSend
		    }); 
		});
		</script>
	<?php
	}
	?>
	</div>
	<?php
}
else if($_GET["mode"] == 'delete')
{
	//include 'database.php';
	$id = $_GET["id"];
	$query = mysql_query("UPDATE aboutbykk_".$sitelang." SET state = '0' WHERE id='$id' ;", $db);
	if(!$query)
		echo mysql_error();
}
else
{
	if($_GET["mode"] == 'addthissection' && $_POST["addsection"] == '1' && $isAdmin)
	{
		include 'jdf.php';
		
		$ajaxDir = "../";
			
		$name = $_POST["about_name"];
		
		$note = $_POST["about_note"];
			
		$picture=$_FILES["picture"]["name"];
		$tmp_file=$_FILES["picture"]["tmp_name"];
		$type=$_FILES["picture"]["type"];
		
		$showto = $_POST["showto"];
		
		$about_index = $_POST["about_index"];
		if (get_magic_quotes_gpc()) $about_index = stripslashes($about_index);
		$about_index = htmlspecialchars($about_index, ENT_QUOTES,"UTF-8");
			
		$query = mysql_query("SELECT id FROM aboutbykk_".$sitelang." ORDER BY id  DESC ;", $db);
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
			$address_picture= "aboutandcontact/".$id.rand(1000000,9999999).".jpg";
			move_uploaded_file($tmp_file, $ajaxDir.$address_picture);
		
		
			//$image_name = $address_picture;    // Full path and image name with extension
			$thumb_name = "aboutandcontact/".$id."thumb".rand(1000000,9999999).".jpg";	// Generated thumbnail name without extension
		
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
		}
		
		$address_index="aboutandcontact/".$id."index.dtx" ;
		$about_index=explode(chr(13),$about_index);
		$f=fopen($ajaxDir.$address_index , "w");
		foreach($about_index as $buf )
		{
			fputs($f , $buf);
		}
		fclose($f);
		
		$date = date("F d Y");
		$time = date("G:i");
		$jdate = jdate("j F Y");
		$jtime = jdate("G:i");
			
		$sql = "INSERT INTO `aboutbykk_".$sitelang."` (`id`, `name`, `about_note`, `picture`, `picture_thumb`, `about_index`,
		`showto`, `date`, `time`, `jdate`, `jtime`, `state`)
		VALUES ('$id', '$name', '$note', '$address_picture', '$thumb_name', '$address_index',
		'$showto', '$date', '$time', '$jdate', '$jtime', '1');";
			
		$result = mysql_query($sql, $db);
		if($result == false )
			echo mysql_error();
		else
		{
			?>
			<div id="success_dialog" style="display: block;opacity:1;top: 40%;height: 60px;">
			<img alt="correct" src="../images/correct.png" style="float: left;position: relative;height: 60px;"/>
			<div style="font-size: 15px;color: #333;padding: 20px 5px;font-weight: bold;float:left;">Section Added!</div>
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
			</div>
			<?php
		}
		
	}
?>
<?php 
	if($isAdmin)
	{
	?>
	<div id="delete_dialogA" title="Delete About Section" style="display: none;">
	<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are You Sure?
	</div>
	<?php 
	}
?>
<script>
<?php 
if($isAdmin)
{
?>

var deleteAID=0;
function addAboutSection()
{
	gotoPage('full',500,'index/about.php?mode=addsection');
}
function deleteAboutSection(aid)
{
	deleteAID = aid;
	$("#delete_dialogA").dialog("open");
}
function editAboutSection(id) 
{
	gotoPage('full',500,'index/about.php?mode=edit&id='+id);
}

$(function() {
	$("#delete_dialogA").dialog({
		autoOpen: false,
		resizable: false,
		height:120,
		modal: true,
		buttons: {
			"Yes": function() {
				$.get('index/about.php?mode=delete&id='+deleteAID,function()
				{
					gotoPage('full',500,'index/about.php');
				});
				$( this ).dialog( "close" );
			},
			"Cancel": function() {
				$( this ).dialog( "close" );
			}
		}
	});
});

$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
	"<div class='btn add' onclick='addAboutSection();' title='Add New Section' ></div><div class='btn change' onclick='editAboutSection(<?php echo $arow[0]; ?>);' title='Edit This Section' ></div><div class='btn delete' onclick='deleteAboutSection(<?php echo $nrow[0]; ?>);' title='Delete This Section' ></div>"
	).animate({'opacity':'1'},300);
<?php 
}
?>
</script>
<div style="opacity:0;width: 100%;height: 100%;" id="index-loader">
	<div id="about-category">
	<?php
	if(isset($_GET["section_id"]))
		$section_id = $_GET["section_id"];
	else
		$section_id = '';
	if($isAdmin)
		$query = mysql_query("SELECT id, name FROM aboutbykk_".$sitelang." WHERE state = 1 ORDER BY id  ASC ;", $db);
	else
		$query = mysql_query("SELECT id, name FROM aboutbykk_".$sitelang." WHERE state = 1 AND showto <= '$level' AND showto > 0 ORDER BY id  ASC ;", $db);
	if (!$query)
		die("Error reading query: ".mysql_error());
	
	while($arows = mysql_fetch_row($query))
	{
		if($section_id == '')
			$section_id = $arows[0];
	?>
		<div class="about-category <?php if($arows[0] == $section_id) echo "selected"; ?>" onclick="gotoPage('full',500,'index/about.php?section_id=<?php echo $arows[0]; ?>')">
			<div class="text" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/about.php?section_id=".$arows[0]); ?>" ><?php echo $arows[1]; ?></a></div>
		</div>
	<?php 
	}
	?>
	</div>
	<div id="about-shadow">
	</div>
	<div id="about-container">
		<?php 
		if($isAdmin)
			$query = mysql_query("SELECT * FROM aboutbykk_".$sitelang." WHERE state = 1 AND id = '$section_id' ;", $db);
		else
			$query = mysql_query("SELECT * FROM aboutbykk_".$sitelang." WHERE state = 1 AND showto <= '$level' AND showto > 0 AND id = '$section_id' ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		if($arow = mysql_fetch_row($query))
		{
		?>
		<div class="about-inner" >
			<!-- <h3 ><?php echo $arow[1]; ?></h3> -->
			<?php 
			if($arow[3] != '')
			{
			?>
				<img alt="<?php echo $arow[1]; ?>" src="<?php echo $arow[3]; ?>" class="about-img" >
			<?php 
			}
			?>
			<div class="about-text" >
			<?php 
			$f = fopen("../".$arow[5], "r");
			if($f===false)
				die("'".$arow[5]."' doesn't exist.");
			else
				while(!feof($f))
				{
					$buf = fgets($f , 4096);
					$buf = htmlspecialchars_decode($buf, ENT_QUOTES);
					echo $buf;
				}
				?>
			</div>
		</div>
		<?php
		}
		?>
	</div>
	<script type="text/javascript">
	<?php 
	if(isset($_GET["section_id"]))
	{
		?>
		$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=about&id=<?php echo $section_id; ?>', function() {
			$("#page-nav").animate({'opacity':'1'}, 300);
			});
		<?php
	}
	else 
	{
		?>
		$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=about', function() {
			$("#page-nav").animate({'opacity':'1'}, 300);
			});
		<?php
	}
	if($isAdmin)
	{
	?>
	$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
		"<div class='btn add' onclick='addAboutSection();' title='Add New Section' ></div><div class='btn change' onclick='editAboutSection(<?php echo $section_id; ?>);' title='Edit This Section' ></div><div class='btn delete' onclick='deleteAboutSection(<?php echo $section_id; ?>);' title='Delete This Section' ></div>"
		).animate({'opacity':'1'},300);
	<?php 
	}
	?>
	$(".about-category").mouseenter(function(){
		$(this).children(".text").stop().animate({'padding-left':'20px'},300);
	}).mouseleave(function(){
		if(!$(this).hasClass("selected"))
			$(this).children(".text").stop().animate({'padding-left':'10px'},300);
	}).click(function(){
		$(".about-category").removeClass("selected");
		$(".about-category").not(this).children(".text").animate({'padding-left':'10px'},300);
		$(this).addClass("selected");
	});

	$('.about-inner').slimScroll({
	      wheelStep: 20,
	      height:'580px',
	      position: 'right'
  	});
	</script>
</div>
<?php 
}
?>