<?php
include 'database.php';

$addcheck = false;
$formAdded = false;
if($_GET["mode"] == 'add')
{
	$addcheck = true;
	$form_id = $_POST["form_id"]; 
	
	$query = mysql_query("SELECT * FROM formbykk WHERE state = 1 AND id = '$form_id' ;", $db);
	if (!$query)
		die("Error reading query: ".mysql_error());
	if($frow=mysql_fetch_row($query))
	{
		for($i=1;$i<=$frow[6];$i++)
		{
			$fs = $frow[(6+($i*2-1))];	
			$afs[$i] = explode("|", $fs);
			if($afs[$i][1] == '5' || $afs[$i][1] == '6')
				$afs[$i][1] = '5';
		}
	}
	
	for($i=1;$i<=$frow[6];$i++)
	{
		$fld[$i] = $_POST["fld_".$i];
		$fld[$i] = substr($fld[$i], 0, 290);
		if($afs[$i][1] == '5' && $fld[$i] == 'other')
		{
			$fld[$i] = "o|".$_POST["fld_other_".$i];
		}
	}
	if($_POST["captcha"] == $_SESSION['security_number'])
	{
		include 'jdf.php';
		
		$query = mysql_query("SELECT id FROM filledformbykk ORDER BY id  DESC ;", $db);
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
			
		$sql = "INSERT INTO `filledformbykk` (`id`, `form_id`, `date`, `time`, `jdate`, `jtime`, `state` )
		VALUES ('$id', '$form_id', '$date', '$time', '$jdate' , '$jtime', '0' );";
			
		$result = mysql_query($sql, $db);
		if($result == false )
			echo mysql_error();
		else
		{
			$sqlToUpdate = ' state = 1 ';
			for($i=1;$i<=$frow[6];$i++)
			{
				$value = mysql_real_escape_string($fld[$i]);
				$sqlToUpdate .= ", fld_".$i." = '$value' ";
			}
			
			$query = mysql_query("UPDATE filledformbykk SET ".$sqlToUpdate." WHERE id = '$id' ;",$db);
			if(!$query)
				echo mysql_error();
			else
			{
				$formAdded = true;
				?>
				<div id="success_dialog" style="display: block;opacity:1;top: 40%;height: 60px;">
					<img alt="correct" src="../images/correct.png" style="float: left;position: relative;height: 60px;"/>
					<div style="font-size: 15px;color: #333;padding: 20px 5px;font-weight: bold;float:left;">Form Posted</div>
					<script type="text/javascript">
					$("#success_dialog").click(function(){
							$(this).remove();
						});
					setTimeout(function () {
						$("#success_dialog").animate({'opacity':'0.0'},300,function(){
							$("#success_dialog").remove();
							<?php 
							if($_GET["goback"] == 'news')
							{
								?>
								gotoPage('full',500,'index/news.php');
								<?php
							}
							else if($_GET["goback"] == 'product')
							{
								?>
								gotoPage('full',500,'index/product.php');
								<?php
							}
							else
							{
								?>
								gotoPage('full',500,'index/home.php');
								<?php
							}
							?>
						});
					},2000);
					</script>
				</div>
				<?php
			}
		}
	}
}

if(!isset($_SESSION['security_number']) || ((isset($_SESSION['security_number']) && $_POST["captcha"] != $_SESSION['security_number'] ) && !$formAdded))
{
	if($addcheck)
	{
		?>
		<div id="success_dialog" style="display: block;opacity:1;top: 40%;height: 60px;">
			<img alt="correct" src="../images/wrong.png" style="float: left;position: relative;height: 60px;"/>
			<div style="font-size: 15px;color: #333;padding: 20px 5px;font-weight: bold;float:left;">Wrong Captcha</div>
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
	if(isset($_GET['id']))
		$id = $_GET['id'];
	else
		$id = $_POST['form_id'];
	$query = mysql_query("SELECT * FROM formbykk WHERE state = 1 AND id = '$id' ;", $db);
	if (!$query)
		die("Error reading query: ".mysql_error());
	if($frow=mysql_fetch_row($query))
	{
		$_SESSION['security_number']=rand(10000,99999);
	?>
	<script type="text/javascript">
	$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=fillform&from=<?php echo $_GET["from"]; ?>&id=<?php echo $id; ?>', function() {
		$("#page-nav").animate({'opacity':'1'}, 300);
		});
	</script>
	<div style="opacity:1;width: 100%;height: 100%;" id="index-loader">
		<div style="border: 1px #ccc solid;padding: 0px;margin: 15px auto 0;height: 55px;background-color: #eee;overflow: hidden;border-top-right-radius: 7px;border-top-left-radius: 7px;width: 950px;border-bottom: none;">
			<div style="height: 50px;width: 25%;float: left;padding: 0;margin: 0;">
				<?php 
				if($frow[2] != '')
				{
				?>
				<img alt="<?php echo $frow[1]; ?>" src="../<?php echo $frow[2]; ?>" style="float: left;height: 55px;">
				<?php 
				}
				?>
			</div>
			<div style="height: 40px;width: 30%;float: left;padding: 15px 0 0 0;margin: 0;text-align: center;">
				<span><span style="color: #555;">Titel:</span> <?php echo $frow[1]; ?></span>
			</div>
			<div style="height: 40px;width: 22.5%;float: left;padding: 15px 0 0 0;margin: 0;text-align: center;">
				<span><span style="color: #555;">Document code:</span> <?php echo $frow[4]; ?></span>
			</div>
			<div style="height: 40px;width: 22.5%;float: left;padding: 15px 0 0 0;margin: 0;text-align: center;">
				<span><span style="color: #555;">Einteilung:</span> <?php echo $frow[5]; ?></span>
			</div>
		</div>
		<form action="index/fillform.php?goback=<?php echo $_GET["goback"]; ?>&category=<?php echo $_GET["category"]; ?>&sub_category=<?php echo $_GET["sub_category"]; ?>&pid=<?php echo $_GET["pid"]; ?>&nid=<?php echo $_GET["nid"]; ?>&from=<?php echo $_GET["from"]; ?>&mode=add" method="POST" enctype="multipart/form-data" id="fillform_form" >
			<div style="border: 1px #ccc solid;padding: 0px;margin: 0 auto 15px;width: 950px;overflow: hidden;border-bottom-right-radius: 7px;border-bottom-left-radius: 7px;position: relative;background-color: #eee;">
			<input type="hidden" name="field_num" value="<?php echo $frow[6]; ?>" >
			<input type="hidden" name="form_id" value="<?php echo $frow[0]; ?>" >
			<?php 
			for($i=1;$i<=$frow[6];$i++)
			{
				$fs = $frow[(6+($i*2-1))];
				$fn = $frow[(6+($i*2))];
				
				$afs = explode("|", $fs);
				if($afs[1] == '5' || $afs[1] == '6')
				{
					$afn = explode("|", $fn);
					$f_name = $afn[0];
					if($afs[1] == '6')
						$option_other = true;
					else
						$option_other = false;
					$afs[1] = '5';
				}
				else
					$f_name = $fn;
				
				?>
				<div <?php if($afs[1] == '4' || ($afs[1] == '3' && $afs[0] == '2' )) echo 'style="height:20px;"'; ?> class="<?php 
					switch ($afs[0])
					{
						case '1':
							echo "fbig";
						break;
						case '2':
							if($afs[1] == '2')
								echo "ftanormal";
							else
								echo "fnormal";
						break;
						case '3':
							echo "f3-4";
						break;
						case '4':
							echo "f2-3";
						break;
						case '5':
							echo "f1-2";
						break;
						case '6':
							echo "f1-3";
						break;
						case '7':
							echo "f1-4";
						break;
					}
					?>" >
					<?php 
						if($afs[1] == '1')
						{
							?>
								<div class="flable" ><?php if($afs[2] == '1') echo "<span class='red' >*</span>"; ?><?php echo $f_name; ?></div>
								<input type="text" value="<?php if($afs[4] == '1' && $fld[$i] == '') { if(isset($_SESSION['userbykk'])) echo $_SESSION['userbykk'][0]; else echo $_SESSION['adminbykk'][0]; } else echo $fld[$i]; ?>" class="textbykk <?php 
								if($afs[2] == '1')
									echo "starred ";
								switch ($afs[0])
								{
									case '1':
									case '2':
										echo "finput_normal";
									break;
									case '3':
										echo "finput_3-4";
									break;
									case '4':
										echo "finput_2-3";
									break;
									case '5':
										echo "finput_1-2";
									break;
									case '6':
										echo "finput_1-3";
									break;
									case '7':
										echo "finput_1-4";
									break;
								}
								?>" name="<?php echo "fld_".$i; ?>" id="<?php echo "fld_".$i; ?>" >
							<?php
						}
						else if($afs[1] == '2')
						{
							if($afs[0] == '1')
							{
							?>
								<div class="flable" ><?php if($afs[2] == '1') echo "<span class='red' >*</span>"; ?><?php echo $f_name; ?></div>
								<textarea class="textbykk <?php if($afs[2] == '1')echo "starred ";?>tabig" name="<?php echo "fld_".$i; ?>" id="<?php echo "fld_".$i; ?>" ><?php if($afs[4] == '1' && $fld[$i] == '') { if(isset($_SESSION['userbykk'])) echo $_SESSION['userbykk'][0]; else echo $_SESSION['adminbykk'][0]; } else echo $fld[$i]; ?></textarea>
							<?php
							}
							else
							{
							?>
								<div class="flable" ><?php if($afs[2] == '1') echo "<span class='red' >*</span>"; ?><?php echo $f_name; ?></div>
								<textarea class="textbykk <?php if($afs[2] == '1')echo "starred ";?>taother" name="<?php echo "fld_".$i; ?>" id="<?php echo "fld_".$i; ?>" ><?php if($afs[4] == '1' && $fld[$i] == '') { if(isset($_SESSION['userbykk'])) echo $_SESSION['userbykk'][0]; else echo $_SESSION['adminbykk'][0]; } else echo $fld[$i]; ?></textarea>
							<?php
							}
							
						}
						else if($afs[1] == '3')
						{
							?>
								<div class="flable" style="font-weight: bold;" ><?php echo $f_name; ?></div>
							<?php
						}
						else if($afs[1] == '4')
						{
							?>
								<span style="float: right;margin-right: 16px;">
									<span class="input_span" ><?php if($afs[2] == '1') echo "<span class='red' >*</span>"; ?><?php echo $f_name; ?></span>
									<input type="checkbox" name="<?php echo "fld_".$i; ?>" id="<?php echo "fld_".$i; ?>" <?php if($fld[$i]) echo 'checked="checked"'; ?> >
								</span>
							<?php
						}
						else if($afs[1] == '5')
						{
							?>
								<div class="flable" ><?php if($afs[2] == '1') echo "<span class='red' >*</span>"; ?><?php echo $f_name; ?></div>
								<div style="float: left;margin:4px 0 0 16px;">
							<?php
								$cc = false;
								$other_value = '';
									
								for($j=1;$j<=5;$j++)
								{
									if($afn[$j] != '')
									{
									?>
										<span class="input_span" ><?php echo $afn[$j]; ?></span>
										<input type="radio" <?php if(!$cc && !$addcheck) echo 'checked="checked"'; ?> <?php if($fld[$i] == $afn[$j] ) echo 'checked="checked"'; ?> name="<?php echo "fld_".$i; ?>" id="<?php echo "fld_".$i; ?>" value="<?php echo $afn[$j]; ?>" >
									<?php
										$cc = true;
									}
								}
								
								if(substr($fld[$i], 0,2) == 'o|')
									$other_value = explode("|", $fld[$i]);
								if($option_other)
								{
								?>
								<span class="input_span" >Other</span>
									<input type="radio" name="<?php echo "fld_".$i; ?>" <?php if(is_array($other_value)) echo 'checked="checked"'; ?>  id="<?php echo "fld_".$i; ?>" value="other" >
								<?php
								}
							?>
								</div>
							<?php
							if($option_other)
							{
								?>
									<input type="text" class="textbykk" style="width: 60px;" value="<?php if(is_array($other_value)) echo $other_value[1]; ?>" name="<?php echo "fld_other_".$i; ?>" id="<?php echo "fld_other_".$i; ?>" >
								<?php
							}
						}
						
					?>
					</div>
			<?php 
			}
			
			if($frow[151] != '')
			{
			?>
				<div class="fbig" style="text-align: right;height: auto;">
					<pre style="font-family: tahoma;font-size: 13px;text-align: left;margin: 0;padding: 0 15px;"><?php echo $frow[151]; ?></pre>
				</div>
			<?php
			}
			?>
				<div class="div-row" style="width: 94%;margin:0 3% 0 3%;" >
					<div class="input-div" style="position: relative;padding-left: 0;">
						<div class="lable">Captcha</div>
						<input type="text" style="width: 400px;height: 15px;" class="textbykk" id="captcha" name="captcha" >
						<img src="index/captchaimage.php" id="signup-captcha" title="click to refresh" onclick="this.src='index/captchaimage.php?do='+Math.random();" >
					</div>
					<div class="input-div" style="width: 420px;float: right;">
						<div class="lable" >&nbsp;</div>
						<input type="submit" class="textbykk" id="submitform" value="Post" style="width: 420px;" >
					</div>
				</div>
			</div>
		</form>
	</div>
	<script>
	function hola()
	{
		var starFilledCheck = true;
		for(var i=1;i<=<?php echo $frow[6]; ?>;i++)
		{
			if($("#fillform_form #fld_"+i).hasClass("starred"))
				if($("#fillform_form #fld_"+i).val().length < 1)
				{
					$("#fillform_form #fld_"+i).parent("div").addClass("unfilled");
					starFilledCheck = false;
				}
				else
					$("#fillform_form #fld_"+i).parent("div").removeClass("unfilled");
			if($("#fillform_form #fld_"+i).attr("type") == 'radio')
				if($("#fillform_form #fld_"+i+":checked").val() == 'other')
				{
					if($("#fillform_form #fld_other_"+i).val().length < 1)
					{
						$("#fillform_form #fld_other_"+i).parent("div").addClass("unfilled");
						starFilledCheck = false;
					}
					else
						$("#fillform_form #fld_"+i).parent("div").removeClass("unfilled");
						
				}
				
		}
	}
	function formBeforeSend()
	{
		var starFilledCheck = true;
		for(var i=1;i<=<?php echo $frow[6]; ?>;i++)
		{
			if($("#fillform_form #fld_"+i).hasClass("starred"))
				if($("#fillform_form #fld_"+i).val().length < 1)
				{
					$("#fillform_form #fld_"+i).parent("div").addClass("unfilled");
					starFilledCheck = false;
				}
				else
					$("#fillform_form #fld_"+i).parent("div").removeClass("unfilled");
			if($("#fillform_form #fld_"+i).attr("type") == 'radio')
			{
				if($("#fillform_form #fld_other_"+i).parent("div").hasClass("unfilled"))
					$("#fillform_form #fld_other_"+i).parent("div").removeClass("unfilled");
				if($("#fillform_form #fld_"+i+":checked").val() == 'other')
				{
					if($("#fillform_form #fld_other_"+i).val().length < 1)
					{
						$("#fillform_form #fld_other_"+i).parent("div").addClass("unfilled");
						starFilledCheck = false;
					}
					else
						$("#fillform_form #fld_other_"+i).parent("div").removeClass("unfilled");
						
				}
			}
				
		}
		if(starFilledCheck)
		{
			progressBar(300, 60);
			return true;
		}
		else
			return false;
	}
	$(document).ready(function() { 
	    $('#fillform_form').ajaxForm({ 
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
}
?>