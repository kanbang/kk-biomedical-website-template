<?php
include 'database.php';

if(($_GET["mode"] == 'edit' || $_GET["mode"] == 'applyedit' )&& $isAdmin)
{
	if($_GET["mode"] == 'applyedit')
	{
		$ajaxDir = "../";
		
		$picturetl=$_FILES["picturetl"]["name"];
		$tmp_filetl=$_FILES["picturetl"]["tmp_name"];
		$typetl=$_FILES["picturetl"]["type"];
		$delete_picturetl = $_POST["delete_picturetl"];
		
		/*$picturebr=$_FILES["picturebr"]["name"];
		$tmp_filebr=$_FILES["picturebr"]["tmp_name"];
		$typebr=$_FILES["picturebr"]["type"];
		$delete_picturebr = $_POST["delete_picturebr"];*/
		
		$contact_index = $_POST["contact_index"];
		$contact_index = htmlspecialchars($contact_index, ENT_QUOTES,"UTF-8");
		
		if($delete_picturetl)
		{
			if(file_exists("../aboutandcontact/contacttopleft.jpg"))
				unlink("../aboutandcontact/contacttopleft.jpg");
			if(file_exists("../aboutandcontact/contacttopleft.png"))
				unlink("../aboutandcontact/contacttopleft.png");
			if(file_exists("../aboutandcontact/contacttopleft.gif"))
				unlink("../aboutandcontact/contacttopleft.gif");
		}
		
		if($picturetl != '')
		{
			$picture = $picturetl;
			$tmp_file = $tmp_filetl;
			$type = $typetl;
			
			if($type == "image/jpeg" || $type == "image/png" || $type == "image/gif" )
			{
				$picture=explode(' ',$picture);
				$picture=implode('',$picture);
				$address_picture= "aboutandcontact/".$picture;
				if($type == "image/jpeg")
					$thumb_name = "aboutandcontact/contacttopleft.jpg";   // Generated thumbnail name without extension
				else if($type == "image/png")
					$thumb_name = "aboutandcontact/contacttopleft.png";
				else if($type == "image/gif")
					$thumb_name = "aboutandcontact/contacttopleft.gif";
				move_uploaded_file($tmp_file, $ajaxDir.$thumb_name);
		
				/*
				//$image_name = $address_picture;    // Full path and image name with extension
				if($type == "image/jpeg")
					$thumb_name = "aboutandcontact/contacttopleft.jpg";   // Generated thumbnail name without extension
				else if($type == "image/png")
					$thumb_name = "aboutandcontact/contacttopleft.png";
				else if($type == "image/gif")
					$thumb_name = "aboutandcontact/contacttopleft.gif";
				
				$image = imagecreatefromstring(file_get_contents($ajaxDir.$address_picture));
		
				$filename = $ajaxDir.$thumb_name;
		
				$thumb_width = 300;
				$thumb_height = 225;
		
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
				
				unlink($ajaxDir.$address_picture);*/
			}
		}
		
		/*
		if($delete_picturebr)
		{
			if(file_exists("../aboutandcontact/contactbottomright.jpg"))
				unlink("../aboutandcontact/contactbottomright.jpg");
			if(file_exists("../aboutandcontact/contactbottomright.png"))
				unlink("../aboutandcontact/contactbottomright.png");
			if(file_exists("../aboutandcontact/contactbottomright.gif"))
				unlink("../aboutandcontact/contactbottomright.gif");
		}
		
		if($picturebr != '')
		{
			$picture = $picturebr;
			$tmp_file = $tmp_filebr;
			$type = $typebr;
				
			if($type == "image/jpeg" || $type == "image/png" || $type == "image/gif" )
			{
				$picture=explode(' ',$picture);
				$picture=implode('',$picture);
				$address_picture= "aboutandcontact/".$picture;
				move_uploaded_file($tmp_file, $ajaxDir.$address_picture);
		
		
				//$image_name = $address_picture;    // Full path and image name with extension
				if($type == "image/jpeg")
					$thumb_name = "aboutandcontact/contactbottomright.jpg";   // Generated thumbnail name without extension
				else if($type == "image/png")
					$thumb_name = "aboutandcontact/contactbottomright.png";
				else if($type == "image/gif")
					$thumb_name = "aboutandcontact/contactbottomright.gif";
		
				$image = imagecreatefromstring(file_get_contents($ajaxDir.$address_picture));
		
				$filename = $ajaxDir.$thumb_name;
		
				$thumb_width = 300;
				$thumb_height = 225;
		
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
		
				unlink($ajaxDir.$address_picture);
			}
		}
		*/
		
		$address_index="aboutandcontact/contact.dtx" ;
		if (get_magic_quotes_gpc()) $contact_index = stripslashes($contact_index);
		$contact_index=explode(chr(13),$contact_index);
		$f=fopen($ajaxDir.$address_index , "w");
		foreach($contact_index as $buf )
		{
			fputs($f , $buf);
		}
		fclose($f);
		
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
?>
<div style="opacity:0;width: 100%;height: 100%;" id="index-loader">
	<div class="div-title">EDIT CONTACT US</div>
	<form action="index/contact.php?mode=applyedit" method="POST" enctype="multipart/form-data" id="changecontact_form" >
		<div class="div-row" >
			<div class="input-div">
				<div class="lable" >Upper picture</div>
				<input type="file" id="picturetl" name="picturetl" class="textbykk" width="412px">
			</div>
			<div style="position: relative;float: left;margin-left: 25px;">
			<?php 
			if(file_exists("../aboutandcontact/contacttopleft.jpg"))
			{
				echo '<img src="aboutandcontact/contacttopleft.jpg" style="height:60px;float:right;box-shadow:0 0 3px rgba(0,0,0,0.5);" />';
				echo '<span style="z-index:299;position: absolute;float: left;bottom:0px;right:0px;left:0;background-color: rgba(0,0,0,0.6);color:#fff;padding: 1px 5px;font-size: 10px;vertical-align: middle;"><input type="checkbox" name="delete_picturetl" style="margin: 1px;float: left;" ><span style="float: left;margin-bottom: 3px;">DEL</span></span>';
			}
			else if(file_exists("../aboutandcontact/contacttopleft.png"))
			{
				echo '<img src="aboutandcontact/contacttopleft.png" style="height:60px;float:right;box-shadow:0 0 3px rgba(0,0,0,0.5);" />';
				echo '<span style="z-index:299;position: absolute;float: left;bottom:0px;right:0px;left:0;background-color: rgba(0,0,0,0.6);color:#fff;padding: 1px 5px;font-size: 10px;vertical-align: middle;"><input type="checkbox" name="delete_picturetl" style="margin: 1px;float: left;" ><span style="float: left;margin-bottom: 3px;">DEL</span></span>';
			}
			if(file_exists("../aboutandcontact/contacttopleft.gif"))
			{
				echo '<img src="aboutandcontact/contacttopleft.gif" style="height:60px;float:right;box-shadow:0 0 3px rgba(0,0,0,0.5);" />';
				echo '<span style="z-index:299;position: absolute;float: left;bottom:0px;right:0px;left:0;background-color: rgba(0,0,0,0.6);color:#fff;padding: 1px 5px;font-size: 10px;vertical-align: middle;"><input type="checkbox" name="delete_picturetl" style="margin: 1px;float: left;" ><span style="float: left;margin-bottom: 3px;">DEL</span></span>';
			}
			?>
			</div>
		</div>
		<div class="div-row" >
			<div class="input-div" style="width: 845px;" >
				<div class="labl" >Contact Us Index</div>
				<textarea name="contact_index" class="textbykk" id="contact_index" ><?php 
				$contact_address = "aboutandcontact/contact.dtx";
				$check = false;
				$f = fopen("../".$contact_address, "r");
				if($f===false)
					echo $contact_address." doesn't exist.";
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
<script>
function contactBeforeSend()
{
	progressBar(300, 60);
	return true;
}
$(document).ready(function() { 
	$("#contact_index").jqte();
    $('#changecontact_form').ajaxForm({ 
        target: '#main-index',
        success: function() { 
        	progressBar(300, 100);
        	$('#index-loader').animate({'opacity':'1'},300);
        } 
    	,
    	beforeSubmit: contactBeforeSend
    }); 
});
</script>
<?php
}
else if($_GET["mode"] == 'addmsg')
{
	$captcha = $_POST["captcha"];
	
	if($captcha == $_SESSION['security_number'])
	{
		include 'jdf.php';
	
		$email = $_POST["email"];
		$name = $_POST["name"];
		$message = $_POST["message"];
		$cellphone = $_POST["cellphone"];
	
		if (get_magic_quotes_gpc()) $message = stripslashes($message);
		$message = mysql_real_escape_string($message);
	
		$email = strtolower($email);
	
		if(isset($_SESSION['userbykk']))
		{
			$member_id = $_SESSION['userbykk'][0];
			$name = $_POST["default_name"];
			$email= $_POST["default_email"];
		}
		else
			$member_id = 0;
	
		$query = mysql_query("SELECT id FROM messagebykk ORDER BY id  DESC ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
	
		if( $rows=mysql_fetch_row($query) )
			$id = $rows[0] + 1;
		else
			$id = 1000;
	
		$date = date("F d, Y");
		$time = date("G:i");
		$jdate = jdate("j F Y");
		$jtime = jdate("G:i");
	
		$sql = "INSERT INTO `messagebykk` (`id`, `email`, `name`, `cellphone`, `member_id`, `message`,
		`date`, `time`, `jdate`, `jtime`, `mlang`, `state`)
		VALUES ( '$id', '$email', '$name', '$cellphone', '$member_id', '$message', 
		'$date', '$time', '$jdate', '$jtime' , '".$sitelang."' ,'1');";
	
		$result = mysql_query($sql,$db);
	
		if($result)
		{
			?>
			<div class='register-alert green' >Ihre Nachricht auf dem Laufenden!</div>
			<script>
			$(".register-alert").click(function(){
			   	$(".register-alert").stop().animate({'opacity':'0'},300,function(){
			      	$(".register-alert").css({'display':'none'});
			    });
		    });
		    setTimeout(function(){
		        $(".register-alert").stop().animate({'opacity':'0'},300,function(){
		        	$(".register-alert").css({'display':'none'});
		        });
		    },3000);
			</script>
			<?php 
		}
		else
		{
			?>
			<div class='register-alert red' >Ihre Nachricht hat keine Stellen!</div>
			<script>
			$(".register-alert").click(function(){
			   	$(".register-alert").stop().animate({'opacity':'0'},300,function(){
			      	$(".register-alert").css({'display':'none'});
			    });
		    });
		    setTimeout(function(){
		        $(".register-alert").stop().animate({'opacity':'0'},300,function(){
		        	$(".register-alert").css({'display':'none'});
		        });
		    },3000);
			</script>
			<?php 
		}
	}
	else
	{
	?>
	<div class='register-alert red' >Falsch Captcha</div>
	<script>
	$(".register-alert").click(function(){
	   	$(".register-alert").stop().animate({'opacity':'0'},300,function(){
	      	$(".register-alert").css({'display':'none'});
	    });
    });
    setTimeout(function(){
        $(".register-alert").stop().animate({'opacity':'0'},300,function(){
        	$(".register-alert").css({'display':'none'});
        });
    },3000);
	</script>
	<?php 
	}
	$_SESSION['security_number']=rand(10000,99999);
}
else
{
?>
<script>
$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=contact', function() {
	$("#page-nav").animate({'opacity':'1'}, 300);
	});
<?php 
if($isAdmin)
{
?>
function editContact(id) 
{
	gotoPage('full',500,'index/contact.php?mode=edit&id='+id);
}
$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
		"<div class='btn change' onclick='editContact();' title='Edit Contact Us' ></div>"
		).animate({'opacity':'1'},300);
<?php 
}
?>
</script>
<div style="opacity:0;width: 100%;height: 100%;" id="index-loader">
	<div style="padding: 10px 1%;color: #333;width: 98%;display: inline-block;">
		<?php 
		if(file_exists("../aboutandcontact/contacttopleft.jpg"))
			echo '<img src="aboutandcontact/contacttopleft.jpg" class="topleft" />';
		if(file_exists("../aboutandcontact/contacttopleft.png"))
			echo '<img src="aboutandcontact/contacttopleft.png" class="topleft" />';
		if(file_exists("../aboutandcontact/contacttopleft.gif"))
			echo '<img src="aboutandcontact/contacttopleft.gif" class="topleft" />';
		
		
		$contact_address = "aboutandcontact/contact.dtx";
		$check = false;
		$f = fopen("../".$contact_address, "r");
		if($f===false)
			echo $contact_address." doesn't exist.";
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
		
		if(file_exists("../aboutandcontact/contactbottomright.jpg"))
			echo '<img src="aboutandcontact/contactbottomright.jpg" class="bottomright" />';
		if(file_exists("../aboutandcontact/contactbottomright.png"))
			echo '<img src="aboutandcontact/contactbottomright.png" class="bottomright" />';
		if(file_exists("../aboutandcontact/contactbottomright.gif"))
			echo '<img src="aboutandcontact/contactbottomright.gif" class="bottomright" />';
		?>
	</div>
	<div style="width: 65%;margin: 20px 17.5%;border: 1px solid #bbb;position: relative;padding: 20px 0;" id="msg-container">
		<div style="top: 0px;left: 0px;position: absolute;color: #eee;background-color: #bbb;padding: 2px 5px;">MESSAGE</div>
		<div id="msg-result"></div>
		<form action="index/contact.php?mode=addmsg" method="POST" id="message_form" >
			<?php 
			$_SESSION['security_number']=rand(10000,99999);
			$isUserLogged = false;
			if(isset($_SESSION["userbykk"]))
			{
				$isUserLogged = true;
				$id = $_SESSION["userbykk"][0];
				$query = mysql_query("SELECT email, name, cellphone FROM registerbykk WHERE id = '$id' ;", $db);
				if (!$query)
					die("Error reading query: ".mysql_error());
				
				if( $row=mysql_fetch_row($query) )
				{
					$default_email = $row[0];
					$default_name = $row[1];
					$default_cellphone = $row[2];
					?>
					<input type="hidden" name="default_name" value="<?php echo $default_name?>">
					<input type="hidden" name="default_email" value="<?php echo $default_email?>">
					<?php
				}
			}
			?>
			<div class="div-row">
				<div class="input-div">
					<div class="lable" ><span class="red" >*</span>Name</div>
					<input type="text" id="firstname" name="name" class="textbykk" style="width: 250px;" value="<?php if($isUserLogged) echo $default_name; ?>" <?php if($isUserLogged) echo 'disabled="disabled"'; ?> />
				</div>
				<div class="input-div">
					<div class="lable" ><span class="red" >*</span>E-Mail</div>
					<input type="text" id="email" name="email" class="textbykk" style="width: 238px;" value="<?php if($isUserLogged) echo $default_email; ?>" <?php if($isUserLogged) echo 'disabled="disabled"'; ?> />
				</div>
			</div>
			<div class="div-row">
				<div class="input-div">
					<div class="lable" >Handy</div>
					<input type="text" id="cellphone" name="cellphone" class="textbykk" style="width: 250px;" value="<?php if($isUserLogged) echo $default_cellphone; ?>"  />
				</div>
			</div>
			<div class="div-row" style="height: 150px;">
				<div class="input-div" style="width: 700px;height:120px;">
					<textarea class="textbykk" style="height: 120px;width:530px;font-family: tahoma;font-size: 13px;color: #333;" name="message" onfocus="if(this.value == 'Your message...' )this.value='';" >Your message...</textarea>
				</div>
			</div>
			<div class="div-row" >
				<div class="input-div" style="position: relative;">
					<div class="lable">Captcha</div>
					<input type="text" style="width: 250px;height: 15px;" class="textbykk" id="captcha" name="captcha" >
					<img src="index/captchaimage.php" id="signup-captcha" title="click to refresh" onclick="this.src='index/captchaimage.php?do='+Math.random();" >
				</div>
				<div class="input-div">
					<div class="lable">&nbsp;</div>
					<input type="submit" value="SEND" style="width: 250px;" class="btnbykk" >
				</div>
			</div>
		</form>
		<script type="text/javascript">
		function beforeSendMsg()
		{
			var validateCounter = 0;
			var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			if(re.test( $("#message_form #email").val() ))
			{
				$("#message_form #email").removeClass("red").addClass("green");
				validateCounter++;
			}
			else
				$("#message_form #email").removeClass("green").addClass("red");
			
			if($("#message_form #firstname").val().length >= 2)
			{
				$("#message_form #firstname").removeClass("red").addClass("green");
				validateCounter++;
			}
			else
				$("#message_form #firstname").removeClass("green").addClass("red");

			if($("#message_form #captcha").val().length >= 5)
			{
				$("#message_form #captcha").removeClass("red").addClass("green");
				validateCounter++;
			}
			else
				$("#message_form #captcha").removeClass("green").addClass("red");

			if(validateCounter>= 3)
			{
				progressBar(300, 60);
				return true;
			}
			else
				return false;
		}
		$(document).ready(function() { 
		    $('#message_form').ajaxForm({ 
		        target: '#msg-result', 
		        success: function() { 
		        	progressBar(300, 100);
		        	$("#signup-captcha").attr("src",'index/captchaimage.php?do='+Math.random());
		        	$("#captcha").val("");
		        } 
		    	,
		    	beforeSubmit: beforeSendMsg
		    }); 
		});
		</script>
	</div>
</div>
<?php 
}
?>