<?php
include 'database.php';
if($isAdmin)
{
	if($_GET["mode"] == 'search')
	{
		if(isset($_GET["form_id"]))
		{
			$form_id = $_GET["form_id"];
			$query = mysql_query("SELECT * FROM formbykk WHERE state = 1 AND id = '$form_id' ;", $db);
		}
		if (!$query)
			die("Error reading query: ".mysql_error());
		$num_fields = 0;
		$sqlToSelect = ' id ';
		if($frow=mysql_fetch_row($query))
		{
			for($i=1;$i<=$frow[6];$i++)
			{
				$fs = $frow[(6+($i*2-1))];
					
				$afs[$i] = explode("|", $fs);
				if($afs[$i][1] == '5' || $afs[$i][1] == '6')
				{
					$afs[$i][1] = '5';
				}
				if($afs[$i][3] == '1')
				{
					$num_fields++;
					$sqlToSelect .= ", fld_".$i;
				}
			}
		}
		$sqlToSelect .= ", seen ";
		//$num_fields = 7;
		//echo $num_fields;
		$field_width = (100-((($num_fields+2)*(1))+5))/($num_fields+1);
		
		if(isset($_GET["search"]) && $_GET["search"] != '')
		{
			$q = $_GET["search"];
			$q = mysql_real_escape_string($q);
			$search = "";
			$scheck = false;
			for($i=1;$i<=$frow[6];$i++)
			{
				if($afs[$i][3] == '1')
				{
					if($scheck)
						$search.= " OR fld_".$i." REGEXP '$q'";
					else
						$search.= " fld_".$i." REGEXP '$q'";
					$scheck = true;
				}
			}
			$query = mysql_query("SELECT ".$sqlToSelect." FROM filledformbykk WHERE state != 0 AND form_id = '$form_id' AND ( ".$search." ) ORDER BY id DESC ;", $db);
		}
		else
			$query = mysql_query("SELECT ".$sqlToSelect." FROM filledformbykk WHERE state != 0 AND form_id = '$form_id' ORDER BY id DESC ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		$j=0;
		$ffnum = mysql_num_rows($query);
		while($ffrows = mysql_fetch_row($query))
		{
			$j++;
		?>
		<div class="ffield_tr <?php if($ffrows[($num_fields+1)] == '0') echo "unseen";?>" <?php if($ffrows[($num_fields+1)] == '0') echo 'title="مشاهده نشده"'; ?> id="ff<?php echo $ffrows[0];?>">
			<div class="member_field <?php if($j%2 == 1) echo "fodd"; else echo "feven";?> fnumber" style="width: 5%;">
				<?php echo $j;?>
			</div>
			<?php 
			$k=1;
			for($i=1;$i<=$frow[6];$i++)
			{
				if($afs[$i][3] == '1')
				{
				?>
				<div class="member_field <?php if($j%2 == 1) echo "fodd"; else echo "feven";?>" style="width: <?php echo $field_width; ?>%;" >
					<?php
					if($afs[$i][1] == '5' || $afs[$i][1] == '6')
					{
						if(substr($ffrows[$k], 0,2) == 'o|')
						{
							$other_value = explode("|", $ffrows[$k]);
							echo $other_value[1];
						}
						else 
							echo $ffrows[$k];
					}
					else
						echo $ffrows[$k];
					?>	
				</div>
				<?php 
				$k++;
				}
			}
			?>
			<div class="member_field <?php if($j%2 == 1) echo "fodd"; else echo "feven";?>" style="width: <?php echo $field_width; ?>%;"  >
				<div style="padding: 0 3px 0 0;margin: 0;float: right;width: 100px;position: relative;margin-top: -4px;" id="fctrl">
					<img src="../images/wrongbw.png" title="Delete" onmouseover="this.src='../images/wrong.png';" onmouseout="this.src='../images/wrongbw.png';" style="float: right;margin: 0 0 0 5px;height: 20px;cursor: pointer;" onclick="delFForm(<?php echo $ffrows[0];?>);">
					<img src="../images/editbw.png" title="Edit Form Data" onmouseover="this.src='../images/editc.png';" onmouseout="this.src='../images/editbw.png';" style="float: right;margin: 0 0 0 5px;height: 20px;cursor: pointer;" onclick="editFForm(<?php echo $ffrows[0];?>);">
					<a href="index/printfilledform.php?form_id=<?php echo $form_id; ?>&id=<?php echo $ffrows[0]; ?>" class="download" target="_blank"><img src="../images/printbw.png" title="Printable Version" onmouseover="this.src='../images/printc.png';" onmouseout="this.src='../images/printbw.png';" style="float: right;margin: 0 0 0 5px;height: 20px;cursor: pointer;"></a>
				</div>
			</div>
		</div>
		<?php 
		}
		/*if($ffnum > 16)
		{
			?>
			<script type="text/javascript">
			$(".fnumber").addClass("width3-5").removeClass("width5");
			</script>
			<?php 
		}
		else
		{
			?>
			<script type="text/javascript">
			$(".fnumber").addClass("width5").removeClass("width3-5");
			</script>
			<?php 
		}*/
		
	}
	else if($_GET["mode"] == 'delete')
	{
		$id = $_GET["id"];
		$query = mysql_query("UPDATE filledformbykk SET state = '0' WHERE id='$id' ;", $db);
		if(!$query)
			echo mysql_error();
	}
	else if($_GET["mode"] == 'change' || $_GET["mode"] == 'applychange')
	{
		?>
		<div style="opacity:1;width: 100%;height: 100%;" id="index-loader">
		<?php
		///// seen
		if(isset($_GET["id"]))
		{
			$id = $_GET["id"];
			$query = mysql_query("UPDATE filledformbykk SET seen = '1' WHERE id='$id' ;", $db);
			if(!$query)
				echo mysql_error();
		}
		//////
		if($_GET["mode"] == 'applychange')
		{
			$id = $_POST["id"];
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
			?>
				<div id="success_dialog" style="display: block;opacity:1;top: 40%;height: 60px;">
					<img alt="correct" src="../images/correct.png" style="float: left;position: relative;height: 60px;"/>
					<div style="font-size: 15px;color: #333;padding: 20px 5px;font-weight: bold;float:left;">Changes Applied!</div>
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
		if(isset($_GET['form_id']))
			$form_id = $_GET['form_id'];
		else
			$form_id = $_POST['form_id'];
		
		if(isset($_GET['id']))
			$id = $_GET['id'];
		else
			$id = $_POST['id'];
		$query = mysql_query("SELECT * FROM formbykk WHERE state = 1 AND id = '$form_id' ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		if($frow=mysql_fetch_row($query))
		{
			$ffquery = mysql_query("SELECT * FROM filledformbykk WHERE state = 1 AND id = '$id' AND form_id = '$form_id' ;", $db);
			if (!$ffquery)
				die("Error reading query: ".mysql_error());
			if($ffrow=mysql_fetch_row($ffquery))
			{
				for($i=1;$i<=$frow[6];$i++)
				{
					$fld[$i] = $ffrow[($i+1)];
				}
			}
		?>
		<script type="text/javascript">
		$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=filledform&form_id=<?php echo $form_id; ?>&id=<?php echo $id; ?>', function() {
			$("#page-nav").animate({'opacity':'1'}, 300);
			});
		</script>
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
					<span><span style="color: #555;">Title:</span> <?php echo $frow[1]; ?></span>
				</div>
				<div style="height: 40px;width: 22.5%;float: left;padding: 15px 0 0 0;margin: 0;text-align: center;">
					<span><span style="color: #555;">Document code:</span> <?php echo $frow[4]; ?></span>
				</div>
				<div style="height: 40px;width: 22.5%;float: left;padding: 15px 0 0 0;margin: 0;text-align: center;">
					<span><span style="color: #555;">Classification:</span> <?php echo $frow[5]; ?></span>
				</div>
			</div>
			<form action="index/filledforms.php?mode=applychange" method="POST" enctype="multipart/form-data" id="fillform_form" >
				<div style="border: 1px #ccc solid;padding: 0px;margin: 0 auto 15px;width: 950px;overflow: hidden;border-bottom-right-radius: 7px;border-bottom-left-radius: 7px;position: relative;background-color: #eee;">
				<input type="hidden" name="field_num" value="<?php echo $frow[6]; ?>" >
				<input type="hidden" name="form_id" value="<?php echo $form_id; ?>" >
				<input type="hidden" name="id" value="<?php echo $id; ?>" >
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
									<input type="text" value="<?php echo $fld[$i]; ?>" class="textbykk <?php 
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
									<textarea class="textbykk <?php if($afs[2] == '1')echo "starred ";?>tabig" name="<?php echo "fld_".$i; ?>" id="<?php echo "fld_".$i; ?>" ><?php echo $fld[$i]; ?></textarea>
								<?php
								}
								else
								{
								?>
									<div class="flable" ><?php if($afs[2] == '1') echo "<span class='red' >*</span>"; ?><?php echo $f_name; ?></div>
									<textarea class="textbykk <?php if($afs[2] == '1')echo "starred ";?>taother" name="<?php echo "fld_".$i; ?>" id="<?php echo "fld_".$i; ?>" ><?php echo $fld[$i]; ?></textarea>
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
					<div class="fbig" style="text-align: left;height: auto;">
						<pre style="font-family: tahoma;font-size: 13px;text-align: left;margin: 0;padding: 0;"><?php echo $frow[151]; ?></pre>
					</div>
				<?php
				}
				?>
					<div class="div-row" style="width: 94%;margin:0 3% 0 3%;">
						<div class="input-div" >
							<input type="submit" class="btnbykk" value="Apply" style="width: 412px;">
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
						alert();
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
	else
	{
	?>
	<script type="text/javascript">
	$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=filledform', function() {
		$("#page-nav").animate({'opacity':'1'}, 300);
		});
	</script>
	<div id="delete_dialogF" title="Delete Form" style="display: none;">
		<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are you sure?
	</div>
	<div style="opacity:0;width: 100%;height: 100%;" id="index-loader">
		<div id="member-container">
			<div class="mheader" >
				<span style="float: right;margin-right: 10px;">
					<select id="linkto" onchange="loadFForm(this.value);" class="textbykk">
						<?php 
						$query = mysql_query("SELECT id, name FROM formbykk WHERE state = 1 ORDER BY id  DESC ;", $db);
						if (!$query)
							die("Error reading query: ".mysql_error());
						
						while( $rows=mysql_fetch_row($query) )
						{
						?>
						<option value="<?php echo $rows[0]; ?>" <?php if($_GET["form_id"] == $rows[0]) echo 'selected="selected"'; ?> ><?php echo $rows[1]; ?></option>
						<?php 
						}
						?>
					</select>
				</span>
				<span style="float: left;font-family: tahoma;font-size: 12px;color: #555;padding: 3px 0;margin-right: 5px;">Search: </span>
				<input type="text" id="fsearch" style="float: left;width: 150px;font-size: 10px;" class="textbykk">
			</div>
			<?php 
			if(isset($_GET["form_id"]))
			{
				$form_id = $_GET["form_id"];
				$query = mysql_query("SELECT * FROM formbykk WHERE state = 1 AND id = '$form_id' ;", $db);
			}
			else	
			{
				$query = mysql_query("SELECT * FROM formbykk WHERE state = 1 ORDER BY id DESC ;", $db);
			}
			if (!$query)
				die("Error reading query: ".mysql_error());
			$num_fields = 0;
			$sqlToSelect = ' id ';
			if($frow=mysql_fetch_row($query))
			{
				if(!isset($_GET["form_id"]))
					$form_id = $frow[0];
				
				for($i=1;$i<=$frow[6];$i++)
				{
					$fs = $frow[(6+($i*2-1))];
					$fn = $frow[(6+($i*2))];
					
					$afs[$i] = explode("|", $fs);
					if($afs[$i][1] == '5' || $afs[$i][1] == '6')
					{
						$afn[$i] = explode("|", $fn);
						$afn[$i] = $afn[$i][0];
						$afs[$i][1] = '5';
					}
					else
						$afn[$i] = $fn;
					if($afs[$i][3] == '1')
					{
						$num_fields++;
						$sqlToSelect .= ", fld_".$i;
					}
				}
			}
			$sqlToSelect .= ", seen ";
			//$num_fields = 7;
			//echo $num_fields;
			$field_width = (100-((($num_fields+2)*(1))+5))/($num_fields+1);
			?>
			<div style="height: 26px;width: 970px;padding: 1px 0px;position: relative;">
				<div style="height: 24px;width: 966px;padding: 0px;margin: 0px 2px 2px 2px;">
					<div class="fform_field ftitle" style="width: 5%;" >
					#
					</div>
					<?php 
					for($i=1;$i<=$frow[6];$i++)
					{
						if($afs[$i][3] == '1')
						{
						?>
						<div class="fform_field ftitle" style="width: <?php echo $field_width; ?>%;" >
							<?php 
								echo $afn[$i]; 
							?>
						</div>
						<?php
						}
					}
					?>
					<div class="fform_field ftitle" style="width: <?php echo $field_width; ?>%;" >
						Controls
					</div>
				</div>
			</div>
			<div id="ffield_container">
				<?php 
					if(isset($_GET["search"]))
					{
						$q = $_GET["search"];
						$q = mysql_real_escape_string($q);
						$search = "";
						$scheck = false;
						for($i=1;$i<=$frow[6];$i++)
						{
							if($afs[$i][3] == '1')
							{
								if($scheck)
									$search.= " OR fld_".$i." REGEXP '$q'";
								else
									$search.= " fld_".$i." REGEXP '$q'";
								$scheck = true;
							}
						}
						$query = mysql_query("SELECT ".$sqlToSelect." FROM filledformbykk WHERE state != 0 AND form_id = '$form_id' AND ( ".$search." ) ORDER BY id DESC ;", $db);
					}
					else 
						$query = mysql_query("SELECT ".$sqlToSelect." FROM filledformbykk WHERE state != 0 AND form_id = '$form_id' ORDER BY id DESC ;", $db);
					if (!$query)
						die("Error reading query: ".mysql_error());
					$j=0;
					$ffnum = mysql_num_rows($query);
					while($ffrows = mysql_fetch_row($query))
					{
						$j++;
					?>
					<div class="ffield_tr <?php if($ffrows[($num_fields+1)] == '0') echo "unseen";?>" <?php if($ffrows[($num_fields+1)] == '0') echo 'title="مشاهده نشده"'; ?> id="ff<?php echo $ffrows[0];?>">
						<div class="member_field <?php if($j%2 == 1) echo "fodd"; else echo "feven";?> fnumber" style="width: 5%;">
							<?php echo $j;?>
						</div>
						<?php 
						$k=1;
						for($i=1;$i<=$frow[6];$i++)
						{
							if($afs[$i][3] == '1')
							{
							?>
							<div class="member_field <?php if($j%2 == 1) echo "fodd"; else echo "feven";?>" style="width: <?php echo $field_width; ?>%;" >
								<?php
								if($afs[$i][1] == '5' || $afs[$i][1] == '6')
								{
									if(substr($ffrows[$k], 0,2) == 'o|')
									{
										$other_value = explode("|", $ffrows[$k]);
										echo $other_value[1];
									}
									else 
										echo $ffrows[$k];
								}
								else
									echo $ffrows[$k];
								?>	
							</div>
							<?php 
							$k++;
							}
						}
						?>
						<div class="member_field <?php if($j%2 == 1) echo "fodd"; else echo "feven";?>" style="width: <?php echo $field_width; ?>%;"  >
							<div style="padding: 0 3px 0 0;margin: 0;float: right;width: 100px;position: relative;margin-top: -4px;" id="fctrl">
								<img src="../images/wrongbw.png" title="Delete" onmouseover="this.src='../images/wrong.png';" onmouseout="this.src='../images/wrongbw.png';" style="float: right;margin: 0 0 0 5px;height: 20px;cursor: pointer;" onclick="delFForm(<?php echo $ffrows[0];?>);">
								<img src="../images/editbw.png" title="Edit Form Data" onmouseover="this.src='../images/editc.png';" onmouseout="this.src='../images/editbw.png';" style="float: right;margin: 0 0 0 5px;height: 20px;cursor: pointer;" onclick="editFForm(<?php echo $ffrows[0];?>);">
								<a href="index/printfilledform.php?form_id=<?php echo $form_id; ?>&id=<?php echo $ffrows[0]; ?>" class="download" target="_blank"><img src="../images/printbw.png" title="Printable Version" onmouseover="this.src='../images/printc.png';" onmouseout="this.src='../images/printbw.png';" style="float: right;margin: 0 0 0 5px;height: 20px;cursor: pointer;"></a>
							</div>
						</div>
					</div>
					<?php 
					}
					/*if($ffnum > 16)
					{
						?>
						<script type="text/javascript">
						$(".fnumber").addClass("width3-5").removeClass("width5");
						</script>
						<?php 
					}
					else
					{
						?>
						<script type="text/javascript">
						$(".fnumber").addClass("width5").removeClass("width3-5");
						</script>
						<?php 
					}*/
					?>
				</div>
		</div>
	</div>
	<style>
	.width5 {
		width: 5%;
	}
	.width3-5 {
		width: 3.5%;
	}
	.ui-autocomplete-loading {
		background: url('images/ui-anim_basic_16x16.gif') left center no-repeat;
	}
	</style>
	<script type="text/javascript">
	var fDelID = 0;
	/*$(function() {*/
	$("#fsearch").autocomplete({
		source: "index/msearch.php?form_id=<?php echo $form_id; ?>",
		minLength: 2
	});
	$("#delete_dialogF").dialog({
		autoOpen: false,
		resizable: false,
		height:130,
		modal: true,
		buttons: {
			"Yes": function() {
				$("#ff"+fDelID+" #fctrl").append("<div class='loader_bg' >&nbsp;</div>");
				$("#ff"+fDelID+" #fctrl .loader_bg").animate({'opacity':'0.5'}, 300);
				$.get('index/filledforms.php?mode=delete&id='+fDelID, function()
					{
						deleteFForm(fDelID);
					});
				$( this ).dialog( "close" );
			},
			"Cancel": function() {
				$( this ).dialog( "close" );
			}
		}
	});
	function delFForm(id)
	{
		fDelID = id;
		$("#delete_dialogF").dialog("open");
	}
	function deleteFForm(id) 
	{
		var myObject = $("#ff"+id);
		myObject.animate({'opacity':'0.0'},300,function (){
				myObject.animate({'height':'0px'},300,function (){
					myObject.remove();
				});
			});
	}
	function loadFForm(id)
	{
		gotoPage('full',500,'index/filledforms.php?form_id='+id);
	}
	function loadFField()
	{
		$("#ffield_container").mCustomScrollbar({
			set_width:false, /*optional element width: boolean, pixels, percentage*/
			set_height:false, /*optional element height: boolean, pixels, percentage*/
			horizontalScroll:false, /*scroll horizontally: boolean*/
			scrollInertia:950, /*scrolling inertia: integer (milliseconds)*/
			mouseWheel:true, /*mousewheel support: boolean*/
			mouseWheelPixels:200, /*mousewheel pixels amount: integer, "auto"*/
			autoDraggerLength:true, /*auto-adjust scrollbar dragger length: boolean*/
			autoHideScrollbar:true, /*auto-hide scrollbar when idle*/
			scrollButtons:{ /*scroll buttons*/
				enable:false, /*scroll buttons support: boolean*/
				scrollType:"continuous", /*scroll buttons scrolling type: "continuous", "pixels"*/
				scrollSpeed:"auto", /*scroll buttons continuous scrolling speed: integer, "auto"*/
				scrollAmount:40 
				},
				advanced:{
					updateOnBrowserResize:true, /*update scrollbars on browser resize (for layouts based on percentages): boolean*/
					updateOnContentResize:false, /*auto-update scrollbars on content resize (for dynamic content): boolean*/
					autoExpandHorizontalScroll:false, /*auto-expand width for horizontal scrolling: boolean*/
					autoScrollOnFocus:false, /*auto-scroll on focused elements: boolean*/
					normalizeMouseWheelDelta:false /*normalize mouse-wheel delta (-1/1)*/
				}, /*scroll buttons pixels scroll amount: integer (pixels)*/
				theme:"dark-2" /*"light", "dark", "light-2", "dark-2", "light-thick", "dark-thick", "light-thin", "dark-thin"*/
			});
	}
	function editFForm(id)
	{
		gotoPage('full',500,'index/filledforms.php?mode=change&form_id=<?php echo $form_id; ?>&id='+id);
	}
	function fsearch(query)
	{
		var encodeQuery = encodeURIComponent(query);
		$("#ffield_container").animate({'opacity' : '0.0'}, 300);
		$("#ffield_container").load("index/filledforms.php?form_id=<?php echo $form_id; ?>&mode=search&search="+encodeQuery, function(){
				$("#ffield_container").animate({'opacity' : '1'}, 300, function() {
					loadFField();
				});
			});
	}
	$("#fsearch").keypress(function(event) {
		if ( event.which == 13 ) 
		{
			var value = $("#fsearch").val();
			event.preventDefault();
			fsearch(value);
		}
	});
	$(document).ready(function(){
		loadFField();
	});
	</script>
	<?php
	}
}
?>