<?php
if($_GET["ajax"] == 1)
	include 'database.php';
if($isAdmin)
{
	if(isset($_GET["fnum"]))
		$fnum = $_GET["fnum"];
	
	if(isset($_GET["fid"]))
		$fid = $_GET["fid"];
	
	if(isset($_GET["addoredit"]))
		$addoredit = $_GET["addoredit"];
	
	$fcheck = false;
	if($fid >= 900)
	{
		$query = mysql_query("SELECT * FROM formbykk WHERE state = 1 AND id = '$fid' ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		if($ffrow=mysql_fetch_row($query))
			$fcheck = true;		
		if($addoredit == '1')
			$fcheck = false;
	}
	$ffnum = $ffrow[6];
	for($i=1;$i<=$fnum;$i++)
	{
		$fs = $ffrow[(6+($i*2-1))];
		$fn = $ffrow[(6+($i*2))];
		
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
	<div id="field_container" >
		<span class="field_container_name" >فیلد #<?php echo $i; ?>
			<?php 
			if($addoredit == '1')
			{
			?>
			<span style="float: right;"><img src="../images/wrongbw.png" style="height: 20px;margin-left: 5px;cursor: pointer;margin-top: -2px;" onmouseover="this.src='../images/wrong.png'" onmouseout="this.src='../images/wrongbw.png'" onclick="deleteField(<?php echo $i; ?>)" title="Delete this field" ></span>
			<span style="float: right;"><img src="../images/addbw.png" style="height: 20px;margin-left: 5px;cursor: pointer;margin-top: -2px;" onmouseover="this.src='../images/add.png'" onmouseout="this.src='../images/addbw.png'" title="Add a field below this" onclick="addField(<?php echo $i; ?>)" ></span>
			<?php 
			}
			?>
		</span>
		<div class="field_input f1" >
			<div class="aflable" >عنوان</div>
			<input type="text" class="textbykk" style="width: 90%;float: right;" name="f<?php echo $i; ?>_name" value="<?php echo $f_name; ?>" >
		</div>
		<div class="field_input f2" >
			<div class="aflable" >اندازه</div>
			<div style="float: right;" >
				<div style="float: right;" >
					<input type="radio" value="1" name="f<?php echo $i; ?>_size" <?php if($afs[0] == '1') echo 'checked="checked"';?> <?php if(!$fcheck || ($addoredit == '1' && $i > $ffnum)) echo 'checked="checked"';?> ><span>بزرگ</span>
					<input type="radio" value="2" name="f<?php echo $i; ?>_size" <?php if($afs[0] == '2') echo 'checked="checked"';?> ><span>عادی</span>
					<input type="radio" value="3" name="f<?php echo $i; ?>_size" <?php if($afs[0] == '3') echo 'checked="checked"';?> ><span>3/4</span>
					<input type="radio" value="4" name="f<?php echo $i; ?>_size" <?php if($afs[0] == '4') echo 'checked="checked"';?> ><span>2/3</span>
					<input type="radio" value="5" name="f<?php echo $i; ?>_size" <?php if($afs[0] == '5') echo 'checked="checked"';?> ><span>1/2</span>
					<input type="radio" value="6" name="f<?php echo $i; ?>_size" <?php if($afs[0] == '6') echo 'checked="checked"';?> ><span>1/3</span>
					<input type="radio" value="7" name="f<?php echo $i; ?>_size" <?php if($afs[0] == '7') echo 'checked="checked"';?> ><span>1/4</span>
				</div>
			</div>
		</div>
		<div class="field_input f1" >
			<div class="aflable" >امکانات</div>
			<div style="float: right;" >
				<input type="checkbox" id="f<?php echo $i; ?>_search" name="f<?php echo $i; ?>_search" <?php if($afs[3]) echo 'checked="checked"';?> ><span>جستجو</span>
				<input type="checkbox" name="f<?php echo $i; ?>_star" <?php if($afs[2]) echo 'checked="checked"';?> ><span>اجباری</span>
				<input type="checkbox" name="f<?php echo $i; ?>_ucode" <?php if($afs[4]) echo 'checked="checked"';?> ><span>کد کاربری</span>
			</div>
		</div>
		<div class="field_input f2" >
			<div class="aflable" >نوع</div>
			<div style="float: right;">
				<input type="radio" value="1" name="f<?php echo $i; ?>_mode" onclick="optionSlideUp(<?php echo $i; ?>);" <?php if($afs[1] == '1') echo 'checked="checked"';?> <?php if(!$fcheck || ($addoredit == '1' && $i > $ffnum)) echo 'checked="checked"';?> ><span>عادی</span>
				<input type="radio" value="2" name="f<?php echo $i; ?>_mode" onclick="optionSlideUp(<?php echo $i; ?>);" <?php if($afs[1] == '2') echo 'checked="checked"';?> ><span>متن</span>
				<input type="radio" value="3" name="f<?php echo $i; ?>_mode" onclick="optionSlideUp(<?php echo $i; ?>);" <?php if($afs[1] == '3') echo 'checked="checked"';?> ><span>لیبل</span>
				<input type="radio" value="4" name="f<?php echo $i; ?>_mode" onclick="optionSlideUp(<?php echo $i; ?>);" <?php if($afs[1] == '4') echo 'checked="checked"';?> ><span>تیک</span>
				<input type="radio" value="5" name="f<?php echo $i; ?>_mode" onclick="optionSlideDown(<?php echo $i; ?>);" <?php if($afs[1] == '5') echo 'checked="checked"';?> ><span>انتخابی</span>
			</div>
		</div>
		<div class="field_input f5" id="f<?php echo $i; ?>option" <?php if($afs[1] == 5) echo 'style="display:block;"'; ?> >
			<div class="option_field" style="padding-right:10px;" >
				<div class="aflable" >انتخاب #1</div>
				<input type="text" class="textbykk" style="width: 90%;float: right;" name="f<?php echo $i; ?>_option1" value="<?php if($afs[1] == '5') echo $afn[1];?>" >
			</div>
			<div class="option_field" >
				<div class="aflable" >انتخاب #2</div>
				<input type="text" class="textbykk" style="width: 90%;float: right;" name="f<?php echo $i; ?>_option2" value="<?php if($afs[1] == '5') echo $afn[2];?>" >
			</div>
			<div class="option_field" >
				<div class="aflable" >انتخاب #3</div>
				<input type="text" class="textbykk" style="width: 90%;float: right;" name="f<?php echo $i; ?>_option3" value="<?php if($afs[1] == '5') echo $afn[3];?>" >
			</div>
			<div class="option_field" >
				<div class="aflable" >انتخاب #4</div>
				<input type="text" class="textbykk" style="width: 90%;float: right;" name="f<?php echo $i; ?>_option4" value="<?php if($afs[1] == '5') echo $afn[4];?>" >
			</div>
			<div class="option_field" >
				<div class="aflable" >انتخاب #5</div>
				<input type="text" class="textbykk" style="width: 90%;float: right;" name="f<?php echo $i; ?>_option5" value="<?php if($afs[1] == '5') echo $afn[5];?>" >
			</div>
			<div class="option_field" style="width: 50px;">
				<div class="aflable" >دیگر</div>
				<input type="checkbox" class="textbykk" style="float: right;" name="f<?php echo $i; ?>_option_other" <?php if($option_other) echo 'checked="checked"';?>  >
			</div>
		</div>
	</div>
<?php
	}
}
?>