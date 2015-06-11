<?php
include 'database.php';
if($isAdmin)
{
	if($_GET["mode"] == 'addthis' || !isset($_GET["mode"]))
	{
		?>
		<div style="opacity:1;width: 100%;height: 100%;" id="index-loader">
		<?php
		if($_GET["mode"] == 'addthis' && $_POST["addform"] == '1')
		{
			include 'jdf.php';
			
			$ajaxDir = "../";
			
			$name = $_POST["name"];
			$document_code = $_POST["document_code"];
			$class = $_POST["class"];
			$field_num = $_POST["field_num"];
			$info = $_POST["info"];
			$info = mysql_real_escape_string($info);
			
			$query = mysql_query("SELECT id FROM formbykk ORDER BY id  DESC ;", $db);
			if (!$query)
				die("Error reading query: ".mysql_error());
			
			if( $rows=mysql_fetch_row($query) )
				$id = $rows[0] + 1;
			else
				$id = 1000;
				
			$name = mysql_real_escape_string($name);
			
			$picture=$_FILES["picture"]["name"];
			$tmp_file=$_FILES["picture"]["tmp_name"];
			$type=$_FILES["picture"]["type"];
			
			$address_picture = '';
			$thumb_name = '';
			if($type == "image/jpeg" || $type == "image/png" || $type == "image/gif" )
			{
				$address_picture= "form/".$id.rand(1000000,9999999).".jpg";
				move_uploaded_file($tmp_file, $ajaxDir.$address_picture);
					
					
				//$image_name = $address_picture;    // Full path and image name with extension
				$thumb_name = "form/".$id."thumb".rand(1000000,9999999).".jpg";   // Generated thumbnail name without extension
					
				$image = imagecreatefromstring(file_get_contents($ajaxDir.$address_picture));
					
				$filename = $ajaxDir.$thumb_name;
			
				$thumb_width = 120;
				$thumb_height = 100;
					
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
			
				imagefilter($thumb, IMG_FILTER_COLORIZE, 232, 232, 232);
			
				// Resize and crop
				imagecopyresampled($thumb,
						$image,
						0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
						0 - ($new_height - $thumb_height) / 2, // Center the image vertically
						0, 0,
						$new_width, $new_height,
						$width, $height);
				imagejpeg($thumb, $filename, 80);
			}
			
			$date = date("F d, Y");
			$time = date("G:i");
			$jdate = jdate("j F Y");
			$jtime = jdate("G:i");
			
			$sql = "INSERT INTO `formbykk` (`id`, `name`, `picture`, `picture_thumb`, `document_code`, `fclass`,
			`field_num`, `date`, `time`, `jdate`, `jtime`, `state` , `info`, `flang` )
			VALUES ('$id', '$name', '$address_picture' ,'$thumb_name', '$document_code' ,'$class',
			'$field_num' , '$date', '$time' , '$jdate' , '$jtime', '0' , '$info' , '".$sitelang."' );";
			
			$result = mysql_query($sql, $db);
			if($result == false )
				echo mysql_error();
			else
			{
				$sqlToUpdate = ' state = 1 ';
				for($i=1;$i<=$field_num;$i++)
				{
					// size|mode|star|search|ucode
					// size: 1->big, 2->normal, 3->3/4, 4->2/3, 5->1/2, 6->1/3, 7->1/4
					// mode: 1->text, 2->texarea, 3->lable, 4-> checkbox, 5->radio without other, 6-> radio with other
					// star: 1-> is starred, 0-> is Not starred
					// search: 1-> be in searach, 0-> do Not be in seach
					$foptions = '';
					$fsetting = '';
					$fname = '';
					
					$f_name = $_POST["f".$i."_name"];
					$f_size = $_POST["f".$i."_size"];
					$f_mode = $_POST["f".$i."_mode"];
					
					if($_POST["f".$i."_search"])
						$f_search = 1;
					else
						$f_search = 0;
					
					if($_POST["f".$i."_star"])
						$f_star = 1;
					else
						$f_star = 0;
					
					if($_POST["f".$i."_ucode"])
						$f_ucode = 1;
					else
						$f_ucode = 0;
					
					if($f_mode == '5' || $f_mode == '6')
					{
						for($j=1;$j<=5;$j++)
						{
							if($_POST["f".$i."_option".$j] != '')
								$foptions .= "|".$_POST["f".$i."_option".$j];
						}
						if($_POST["f".$i."_option_other"])
							$f_mode = 6;
						else
							$f_mode = 5;
						$fname = $f_name.$foptions;
					}
					else
						$fname = $f_name;
					
					$fsetting = $f_size."|".$f_mode."|".$f_star."|".$f_search."|".$f_ucode;
					
					$fsetting = mysql_real_escape_string($fsetting);
					$fname = mysql_real_escape_string($fname);
					
					$sqlToUpdate .= ", fs_".$i." = '$fsetting' , fn_".$i." = '$fname' ";
					
				}
				
				$query = mysql_query("UPDATE formbykk SET ".$sqlToUpdate." WHERE id = '$id' ;",$db);
				if(!$query)
					echo mysql_error();
				else
				{
					?>
					<div id="success_dialog" style="display: block;opacity:1;top: 40%;height: 60px;">
						<img alt="correct" src="../images/correct.png" style="float: left;position: relative;height: 60px;"/>
						<div style="font-size: 15px;color: #333;padding: 20px 5px;font-weight: bold;float:left;">Form Added</div>
						<script>
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
		}
	?>
	<script>
	$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=addform', function() {
		$("#page-nav").animate({'opacity':'1'}, 300);
		});
	$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
		"<div class='btn add' onclick='addForm();' title='Add form' ></div>"
		).animate({'opacity':'1'},300);
	function addForm()
	{
		gotoPage('full',500,'index/addform.php?mode=add');
	}
	function editForm(id)
	{
		gotoPage('full',500,'index/addform.php?mode=edit&id='+id);
	}
	</script>
		<div style="height: 5px;width: 100%;margin: 0;padding: 0;float: right;">&nbsp;</div>
		<?php 
		$query = mysql_query("SELECT id, name, picture_thumb, document_code, fclass, date, time FROM formbykk WHERE state = 1 ORDER BY id  DESC ;", $db);
		
		if (!$query)
			die("Error reading query: ".mysql_error());
		
		while( $rows=mysql_fetch_row($query) )
		{
		?>
		<div class="form_item" style="cursor: default;color: #333;"  >
			<span style="float:left;cursor: pointer;color: #666;font-weight: bold;" onclick="editForm(<?php echo $rows[0]; ?>);">Name: </span><span style="float: left;cursor: pointer;" onclick="editForm(<?php echo $rows[0]; ?>);" ><?php echo $rows[1];?></span><br>
			<span style="float: left;cursor: pointer;color: #666;font-weight: bold;" onclick="editForm(<?php echo $rows[0]; ?>);">Document code: </span><span style="float: left;cursor: pointer;" onclick="editForm(<?php echo $rows[0]; ?>);"><?php echo $rows[3];?></span><br>
			<span style="float: left;cursor: pointer;color: #666;font-weight: bold;" onclick="editForm(<?php echo $rows[0]; ?>);">Classifacition: </span><span style="float: left;cursor: pointer;" onclick="editForm(<?php echo $rows[0]; ?>);"><?php echo $rows[4];?></span>
			<span style="position: absolute;<?php if($rows[2] == '') {?>top: 20px;right: 5px;<?php } else {?>top: 20px;right: 127px;<?php }?>cursor: pointer;" onclick="gotoPage('full',500,'index/fillform.php?from=cp&id=<?php echo $rows[0]; ?>');" ><img src="../images/linkedbykk.png" style="float: right;margin-top: -5px;">Preview</span>
			<span style="position: absolute;<?php if($rows[2] == '') {?>top: 2px;right: 5px;<?php } else {?>top: 2px;right: 127px;<?php }?>font-size: 11px;"><?php echo $rows[5]." ".$rows[6]; ?></span>
			<?php 
			if($rows[2] != '')
			{
				?>
				<img alt="<?php echo $rows[1]; ?>" src="../<?php echo $rows[2]; ?>" onclick="editForm(<?php echo $rows[0]; ?>);" style="bottom: 5px;right:5px;position: absolute;cursor: pointer;">
				<?php 
			}
			?>
		</div>
		<?php 
		}
		?>
	</div>
	<?php 
	}
	else if($_GET["mode"] == "edit" || $_GET["mode"] == "applyedit")
	{
		?>
		<div style="opacity:1;width: 100%;height: 100%;" id="index-loader">
		<?php
		if($_GET["mode"] == "applyedit")
		{
			$ajaxDir = "../";
			
			$id = $_POST['id'];
			
			$name = $_POST["name"];
			$document_code = $_POST["document_code"];
			$class = $_POST["class"];
			$field_num = $_POST["field_num"];
			$info = $_POST["info"];
			$info = mysql_real_escape_string($info);
			
			$name = mysql_real_escape_string($name);
				
			$picture=$_FILES["picture"]["name"];
			$tmp_file=$_FILES["picture"]["tmp_name"];
			$type=$_FILES["picture"]["type"];
			$default_picture = $_POST["default_picture"];
			$default_picture_thumb = $_POST["default_picture_thumb"];
			
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
					$address_picture= "form/".$id.rand(1000000,9999999).".jpg";
					move_uploaded_file($tmp_file, $ajaxDir.$address_picture);
						
						
					//$image_name = $address_picture;    // Full path and image name with extension
					$thumb_name = "form/".$id."thumb".rand(1000000,9999999).".jpg";   // Generated thumbnail name without extension
			
					$image = imagecreatefromstring(file_get_contents($ajaxDir.$address_picture));
			
					$filename = $ajaxDir.$thumb_name;
			
					$thumb_width = 120;
					$thumb_height = 100;
			
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
						
					imagefilter($thumb, IMG_FILTER_COLORIZE, 232, 232, 232);
						
					// Resize and crop
					imagecopyresampled($thumb,
							$image,
							0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
							0 - ($new_height - $thumb_height) / 2, // Center the image vertically
							0, 0,
							$new_width, $new_height,
							$width, $height);
					imagejpeg($thumb, $filename, 80);
				}
			}
			
			$sqlToUpdate = ' ';
			for($i=1;$i<=$field_num;$i++)
			{
				// size|mode|star|search
				// size: 1->big, 2->normal, 3->3/4, 4->2/3, 5->1/2, 6->1/3, 7->1/4
				// mode: 1->text, 2->texarea, 3->lable, 4-> checkbox, 5->radio without other, 6-> radio with other
				// star: 1-> is starred, 0-> is Not starred
				// search: 1-> be in searach, 0-> do Not be in seach
				$foptions = '';
				$fsetting = '';
				$fname = '';
					
				$f_name = $_POST["f".$i."_name"];
				$f_size = $_POST["f".$i."_size"];
				$f_mode = $_POST["f".$i."_mode"];
					
				if($_POST["f".$i."_search"])
				$f_search = 1;
				else
					$f_search = 0;
						
				if($_POST["f".$i."_star"])
					$f_star = 1;
				else
					$f_star = 0;
						
				if($_POST["f".$i."_ucode"])
					$f_ucode = 1;
				else
					$f_ucode = 0;
				
				if($f_mode == '5' || $f_mode == '6')
				{
					for($j=1;$j<=5;$j++)
					{
						if($_POST["f".$i."_option".$j] != '')
							$foptions .= "|".$_POST["f".$i."_option".$j];
					}
					if($_POST["f".$i."_option_other"])
						$f_mode = 6;
					else
						$f_mode = 5;
					$fname = $f_name.$foptions;
				}
				else
					$fname = $f_name;
				
				$fsetting = $f_size."|".$f_mode."|".$f_star."|".$f_search."|".$f_ucode;
						
				$fsetting = mysql_real_escape_string($fsetting);
				$fname = mysql_real_escape_string($fname);
					
				$sqlToUpdate .= ", fs_".$i." = '$fsetting' , fn_".$i." = '$fname' ";
			}
				
			$query = mysql_query("UPDATE formbykk SET name = '$name', picture='$address_picture' , picture_thumb = '$thumb_name' ,
					document_code='$document_code' , fclass ='$class', field_num='$field_num', info = '$info' ".$sqlToUpdate."   WHERE id='$id' ;", $db);
			
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
			else
				echo mysql_error();
		}
		
		if(isset($_GET['id']))
			$id = $_GET['id'];
		else
			$id = $_POST['id'];
		
		$query = mysql_query("SELECT * FROM formbykk WHERE state = 1 AND id = '$id' ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		if($frow=mysql_fetch_row($query))
		{
	?>
		<div id="deletef_dialog" title="Delete Form" style="display: none;">
		<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are You Sure?
		</div>
		<div id="deletefield_dialog" title="Delete Field" style="display: none;">
		<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are You Sure?
		</div>
		<script>
		function addForm()
		{
			gotoPage('full',500,'index/addform.php?mode=add');
		}
		function editForm(id)
		{
			gotoPage('full',500,'index/addform.php?mode=edit&id='+id);
		}
		$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=addform&id=<?php echo $id; ?>', function() {
			$("#page-nav").animate({'opacity':'1'}, 300);
			});
		var deleteFID=0, deleteFieldID=0;
		function deleteForm(id)
		{
			deleteFID = id;
			$("#deletef_dialog").dialog("open");
		}
		
		$(function() {
			$("#deletef_dialog").dialog({
				autoOpen: false,
				resizable: false,
				height:130,
				modal: true,
				buttons: {
					"Yes": function() {
						$.get('index/addform.php?mode=delete&id='+deleteFID, function()
							{
								gotoPage('full',500,'index/addform.php');
							});
						$( this ).dialog( "close" );
					},
					"Cancel": function() {
						$( this ).dialog( "close" );
					}
				}
			});
			$("#deletefield_dialog").dialog({
				autoOpen: false,
				resizable: false,
				height:130,
				modal: true,
				buttons: {
					"Yes": function() {
						delField(deleteFieldID);
						$( this ).dialog( "close" );
					},
					"Cancel": function() {
						$( this ).dialog( "close" );
					}
				}
			});
		});
		function optionSlideUp(id)
		{
			$("#f"+id+"option").slideUp(300);
		}
		function optionSlideDown(id)
		{
			$("#f"+id+"option").slideDown(300);
		}
		function loadFields(num)
		{
			progressBar(300, 60);
			$('#fields_container').load('index/formfield.php?ajax=1&fid=<?php echo $frow[0]; ?>&fnum='+num+'&addoredit=1',function(){
				progressBar(300, 100);
				});
		}
		function deleteField(id)
		{
			deleteFieldID = id;
			$("#deletefield_dialog").dialog("open");
		}
		function delField(id)
		{
			progressBar(300, 60);
			$.get('index/addform.php?mode=delfield&fid=<?php echo $frow[0]; ?>&id='+id, function()
			{
				var fnum = $("#linkto").val();
				fnum--;
				if(fnum>0)
				{
					$("#linkto").val(fnum);
					$("#linkto").trigger('click');
					loadFields(fnum);
					progressBar(300, 100);
				}
			});
		}
		function addField(id)
		{
			var fnum = $("#linkto").val();
			if(fnum<70)
			{
				progressBar(300, 60);
				$.get('index/addform.php?mode=addfield&fid=<?php echo $frow[0]; ?>&id='+id, function()
				{
					fnum++;
					$("#linkto").val(fnum);
					$("#linkto").trigger('click');
					loadFields(fnum);
					progressBar(300, 100);
				});
			}
			else
				alert("Maximum Fileds Acheived!")
		}
		$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
				"<div class='btn add' onclick='addForm();' title='Add form' ></div><div class='btn change' onclick='editForm(<?php echo $id; ?>);' title='Edit form' ></div><div class='btn delete' onclick='deleteForm(<?php echo $id; ?>);' title='Delete form' ></div>"
				).animate({'opacity':'1'},300);
		</script>
		<div id="show_error" style="height: 0px;width: 0px;margin: 0;padding: 0;" ></div>
			<div class="div-title" style="margin-bottom: 5px;">EDIT FORM</div>
			<form action="index/addform.php?mode=applyedit" method="POST" enctype="multipart/form-data" id="addform_form"  >
				<input type="hidden" name="addform" value="1" >
				<input type="hidden" name="id" value="<?php echo $frow[0];?>" >
				<div class="div-row">
					<div class="input-div" >
						<div class="lable" ><span class="red" >*</span>name</div>
						<input type="text" id="firstname" name="name" class="textbykk" style="width: 400px;" value="<?php echo $frow[1]; ?>" >
					</div>
					<div class="input-div" >
						<div class="lable" >Logo</div>
						<input type="file" id="picture" name="picture" class="textbykk" style="width: 250px;" >
						<input type="hidden" name="default_picture" value="<?php echo $frow[2]; ?>">
						<input type="hidden" name="default_picture_thumb" value="<?php echo $frow[3]; ?>">
					</div>
					<?php 
						if($frow[3] != '')
						{
							?>
							<div style="position: relative;float: right;margin-left: 25px;">
								<img src="../<?php echo $frow[3]; ?>" style="height:60px;float:right;box-shadow:0 1px 3px rgba(0,0,0,0.5);" />
								<span style="z-index:299;position: absolute;float: left;bottom:0px;right:0px;left:0;background-color: rgba(0,0,0,0.6);color:#fff;padding: 1px 5px;font-size: 10px;vertical-align: middle;"><input type="checkbox" name="delete_picture" style="margin: 1px;float: left;" ><span style="float: left;margin-bottom: 3px;">DEL</span></span>
							</div>
							<?php 
						}
					?>
				</div>
				<div class="div-row">
					<div class="input-div" >
						<div class="lable" >Document code</div>
						<input type="text" name="document_code" class="textbykk" style="width: 400px;" value="<?php echo $frow[4]; ?>" >
					</div>
					<div class="input-div" >
						<div class="lable" >Classification</div>
						<input type="text"  name="class"  class="textbykk" style="width: 400px;" value="<?php echo $frow[5]; ?>">
					</div>
				</div>
				<div class="div-row">
					<div class="input-div" >
						<div class="lable" >Fields' number</div>
						<select id="linkto" name="field_num" onchange="loadFields(this.value);"  class="textbykk" style="width: 412px;">
							<?php 
							for($i=1;$i<=70;$i++)
							{
								echo "<option value='".$i."' "; 
								if($i == $frow[6])
									echo 'selected="selected"';
								echo " >".$i."</option>".chr(13);
							}
							?>
						</select>
					</div>
					<div class="input-div" >
						<div class="lable" >Help</div>
						<span>Text{<input type="text" disabled="disabled" style="width: 25px;">}</span>
						<span>Textarea{<textarea disabled="disabled" style="height: 20px;width: 25px;position: relative;top:8px;"></textarea>}</span>
						<span>Checknox{<input disabled="disabled" type="checkbox">}</span>
						<span>Select{<input disabled="disabled" type="radio">}</span>
					</div>
				</div>
				<div id="fields_container">
					<?php 
					$fnum = $frow[6];
					$fid = $frow[0];
					$addoredit = '1';
					include 'formfield.php';
					?>
				</div>
				<div class="div-row" style="height: 110px;" >
					<div class="input-div" style="width: 100%;height: 70px;">
						<div class="lable" >Note</div>
						<textarea style="width: 850px;height: 50px;" name="info"  class="textbykk" ><?php echo $frow[151]; ?></textarea>
					</div>
				</div>
				<div class="div-row" >
					<div class="input-div" >
						<input type="submit" class="btnbykk" value="Apply" style="width: 412px;">
					</div>
				</div>
			</form>
		<script>
		function formBeforeSend()
		{
			var searchCounter = 0, searchVal = true;
			for(var i=1;i<=$("#addform_form #linkto").val();i++)
			{
				if($("#addform_form #f"+i+"_search").is(':checked'))
				{
					searchCounter++;
				}
			}
			if(searchCounter>9)
			{
				$("#show_error").load("index/showerror.php");
				searchVal = false;
			}
			
			if($("#addform_form #firstname").val().length < 5)
			{
				$("#addform_form #firstname").removeClass("green").addClass("red");
				return false;
			}
			else if(searchVal)
			{
				$("#addform_form #firstname").removeClass("red").addClass("green");
				progressBar(300, 60);
				return true;
			}
			else
				return false;
		}
		$(document).ready(function() { 
		    $('#addform_form').ajaxForm({ 
		        target: '#main-index', 
		        success: function() { 
		        	progressBar(300, 100);
		        } 
		    	,
		    	beforeSubmit: formBeforeSend
		    }); 
		});
		</script>
		<?php
		}
		?>
		</div>
	<?php
	}
	else if($_GET["mode"] == "delfield")
	{
		$id = $_GET["id"];
		$fid = $_GET["fid"];
		$query = mysql_query("SELECT * FROM formbykk WHERE state = 1 AND id = '$fid' ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		$fdata = array();
		$nfdata = array();
		$fdata[0][0] = '';
		$nfdata[0][0] = '';
		if($ffrow=mysql_fetch_row($query))
		{
			$fnum = $ffrow[6];
			for($i=1;$i<=($fnum+1);$i++)
			{
				$fdata[$i][0] = $ffrow[(6+($i*2-1))];
				$fdata[$i][1] = $ffrow[(6+($i*2))];
			}
			for($i=1;$i<$id;$i++)
			{
				$nfdata[$i][0] = $fdata[$i][0];
				$nfdata[$i][1] = $fdata[$i][1];
			}
			for($i=$id;$i<=($fnum+1);$i++)
			{
				$nfdata[$i][0] = $fdata[($i + 1)][0];
				$nfdata[$i][1] = $fdata[($i + 1)][1];
			}
			
			$sqlToUpdate =  " field_num='".($fnum-1)."' ";
			for($i=1;$i<=$fnum;$i++)
			{
				$sqlToUpdate .= ", fs_".$i." = '".$nfdata[$i][0]."' , fn_".$i." = '".$nfdata[$i][1]."' ";
			}
			
			$query = mysql_query("UPDATE formbykk SET ".$sqlToUpdate."   WHERE id='$fid' ;", $db);
			if(!$query)
				echo mysql_error();
		}
		
		$ffdata = array();
		$nffdata = array();
		$ffdata[0] = '';
		$nffdata[0] = '';
		
		$toSelect = ' id ';
		for($i=1;$i<=$fnum;$i++)
		{
			$toSelect .= ' , fld_'.$i;
		}
		
		$query = mysql_query("SELECT ".$toSelect." FROM filledformbykk WHERE state = 1 AND form_id = '$fid' ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		while($ffrow=mysql_fetch_row($query))
		{
			for($i=1;$i<=$fnum;$i++)
			{
				$ffdata[$i] = $ffrow[$i];
			}
			for($i=1;$i<$id;$i++)
			{
				$nffdata[$i] = $ffdata[$i];
			}
			for($i=$id;$i<=$fnum;$i++)
			{
				$nffdata[$i] = $ffdata[($i + 1)];
			}
			
			$sqlToUpdate =  " state='1' ";
			for($i=1;$i<=$fnum;$i++)
			{
				$sqlToUpdate .= ", fld_".$i." = '".$nffdata[$i]."' ";
			}
				
			$queryU = mysql_query("UPDATE filledformbykk SET ".$sqlToUpdate."   WHERE id='".$ffrow[0]."' ;", $db);
			if(!$queryU)
				echo mysql_error();
		}
		
		
	}
	else if($_GET["mode"] == "addfield")
	{
		$id = $_GET["id"];
		$fid = $_GET["fid"];
		$query = mysql_query("SELECT * FROM formbykk WHERE state = 1 AND id = '$fid' ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		$fdata = array();
		$nfdata = array();
		$fdata[0][0] = '';
		$nfdata[0][0] = '';
		if($ffrow=mysql_fetch_row($query))
		{
			$fnum = $ffrow[6];
			for($i=1;$i<=($fnum);$i++)
			{
				$fdata[$i][0] = $ffrow[(6+($i*2-1))];
				$fdata[$i][1] = $ffrow[(6+($i*2))];
			}
			for($i=1;$i<$id;$i++)
			{
				$nfdata[$i][0] = $fdata[$i][0];
				$nfdata[$i][1] = $fdata[$i][1];
			}
			for($i=$id;$i<=($fnum+1);$i++)
			{
				if($i == $id)
				{
					$nfdata[$i][0] = "1|1|0|0|0";
					$nfdata[$i][1] = "";
				}
				else
				{
					$nfdata[$i][0] = $fdata[($i-1)][0];
					$nfdata[$i][1] = $fdata[($i-1)][1];
				}
			}
				
			$sqlToUpdate =  " field_num='".($fnum+1)."' ";
			for($i=1;$i<=($fnum+1);$i++)
			{
				$sqlToUpdate .= ", fs_".$i." = '".$nfdata[$i][0]."' , fn_".$i." = '".$nfdata[$i][1]."' ";
			}
				
			$query = mysql_query("UPDATE formbykk SET ".$sqlToUpdate."   WHERE id='$fid' ;", $db);
			if(!$query)
				echo mysql_error();
		}
		
		$ffdata = array();
		$nffdata = array();
		$ffdata[0] = '';
		$nffdata[0] = '';
		
		$toSelect = ' id ';
		for($i=1;$i<=$fnum;$i++)
		{
			$toSelect .= ' , fld_'.$i;
		}
		
		$query = mysql_query("SELECT ".$toSelect." FROM filledformbykk WHERE state = 1 AND form_id = '$fid' ;", $db);
			if (!$query)
		die("Error reading query: ".mysql_error());
		echo mysql_num_rows($query);
		while($ffrow=mysql_fetch_row($query))
		{
			echo "laglag";
			for($i=1;$i<=($fnum+1);$i++)
			{
				$ffdata[$i] = $ffrow[$i];
			}
			for($i=1;$i<$id;$i++)
			{
				$nffdata[$i] = $ffdata[$i];
			}
			for($i=$id;$i<=($fnum+1);$i++)
			{
				if($i == $id)
				{
					$nffdata[$i] = "";
				}
				else
				{
					$nffdata[$i] = $ffdata[($i - 1)];
				}
			}
				
			$sqlToUpdate =  " state = '1' ";
			for($i=1;$i<=($fnum+1);$i++)
			{
				$sqlToUpdate .= ", fld_".$i." = '".$nffdata[$i]."' ";
			}
	
			$queryU = mysql_query("UPDATE filledformbykk SET ".$sqlToUpdate."   WHERE id = '".$ffrow[0]."' ;", $db);
			if(!$queryU)
				echo mysql_error();
		}
	}
	else if($_GET["mode"] == "delete")
	{
		$id = $_GET["id"];
		$query = mysql_query("UPDATE formbykk SET state = '0' WHERE id='$id' ;", $db);
		if(!$query)
			echo mysql_error();
	}
	else if($_GET["mode"] == 'add')
	{
	?>
		<div style="opacity:0;width: 100%;height: 100%;" id="index-loader">
		<script type="text/javascript">
		function addForm()
		{
			gotoPage('full',500,'index/addform.php?mode=add');
		}
		$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=addform&mode=add', function() {
			$("#page-nav").animate({'opacity':'1'}, 300);
			});
		$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
			"<div class='btn add' onclick='addForm();' title='Add form' ></div>"
			).animate({'opacity':'1'},300);
		function optionSlideUp(id)
		{
			$("#f"+id+"option").slideUp(300);
		}
		function optionSlideDown(id)
		{
			$("#f"+id+"option").slideDown(300);
		}
		function loadFields(num)
		{
			progressBar(300, 60);
			$('#fields_container').load('index/formfield.php?ajax=1&fnum='+num,function(){
				progressBar(300, 100);
				});
		}
		</script>
		<div id="show_error" style="height: 0px;width: 0px;margin: 0;padding: 0;" ></div>
			<div class="div-title">ADD FORM</div>
			<form action="index/addform.php?mode=addthis" method="POST" enctype="multipart/form-data" id="addform_form" >
				<input type="hidden" name="addform" value="1" >
				<div class="div-row">
					<div class="input-div" >
						<div class="lable" ><span class="red" >*</span>name</div>
						<input type="text" id="firstname" name="name" class="textbykk" style="width: 400px;">
					</div>
					<div class="input-div" >
						<div class="lable" >Logo</div>
						<input type="file" id="picture" name="picture" class="textbykk" style="width: 400px;" >
					</div>
				</div>
				<div class="div-row">
					<div class="input-div" >
						<div class="lable" >Document code</div>
						<input type="text"  name="document_code" class="textbykk" style="width: 400px;" >
					</div>
					<div class="input-div" >
						<div class="lable" >Classification</div>
						<input type="text"  name="class"  class="textbykk" style="width: 400px;" >
					</div>
				</div>
				<div class="div-row">
					<div class="input-div" >
						<div class="lable" >Fields' number</div>
						<select id="linkto" name="field_num" onchange="loadFields(this.value);"  class="textbykk" style="width: 412px;">
							<?php 
							for($i=1;$i<=70;$i++)
							{
								echo "<option value='".$i."' >".$i."</option>".chr(13);
							}
							?>
						</select>
					</div>
					<div class="input-div" >
						<div class="lable" >Help</div>
						<span>Text{<input type="text" disabled="disabled" style="width: 25px;">}</span>
						<span>Textarea{<textarea disabled="disabled" style="height: 20px;width: 25px;position: relative;top:8px;"></textarea>}</span>
						<span>Checknox{<input disabled="disabled" type="checkbox">}</span>
						<span>Select{<input disabled="disabled" type="radio">}</span>
					</div>
				</div>
				<div id="fields_container">
					<?php 
					$fnum = 1;
					include 'formfield.php';
					?>
				</div>
				<div class="div-row" style="height: 110px;" >
					<div class="input-div" style="width: 100%;height: 70px;">
						<div class="lable" >Note</div>
						<textarea style="width: 850px;height: 50px;" name="info"  class="textbykk" ></textarea>
					</div>
				</div>
				<div class="div-row" >
					<div class="input-div" >
						<input type="submit" class="btnbykk" value="Add!" style="width: 412px;">
					</div>
				</div>
			</form>
		<script>
		function formBeforeSend()
		{
			var searchCounter = 0, searchVal = true;
			for(var i=1;i<=$("#addform_form #linkto").val();i++)
			{
				if($("#addform_form #f"+i+"_search").is(':checked'))
				{
					searchCounter++;
				}
			}
			if(searchCounter>9)
			{
				$("#show_error").load("index/showerror.php");
				searchVal = false;
			}
			
			if($("#addform_form #firstname").val().length < 5)
			{
				$("#addform_form #firstname").removeClass("green").addClass("red");
				return false;
			}
			else if(searchVal)
			{
				$("#addform_form #firstname").removeClass("red").addClass("green");
				progressBar(300, 60);
				return true;
			}
			else
				return false;
		}
		$(document).ready(function() { 
		    $('#addform_form').ajaxForm({ 
		        target: '#main-index', 
		        success: function() { 
		        	progressBar(300, 100);
		        } 
		    	,
		    	beforeSubmit: formBeforeSend
		    }); 
		});
		</script>
		</div>
<?php 
	}
}
?>