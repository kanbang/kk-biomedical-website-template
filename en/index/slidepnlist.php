<?php
if($_GET["ajax"] == 1)
	include 'database.php';
if($isAdmin)
{	
	$smode = $selectedMode;
	if(isset($_GET["smode"]))
		$smode = $_GET["smode"];
	
	$slang = $selectedLang;
	if(isset($_GET["slang"]))
		$slang = $_GET["slang"];
	
	$slink = $selectedLink;
	if(isset($_GET["slink"]))
		$slink = $_GET["slink"];
	
	
	if($smode == '1')
	{
	?>
	<div class="lable" >Product</div>
	<select class="textbykk" id="linkid<?php echo $slink; ?>" name="linkid<?php echo $slink; ?>" style="width: 412px;" >
	<?php 
	$squery = mysql_query("SELECT id, category, sub_category, name FROM productbykk_".$slang." WHERE state = 1 ORDER BY category ASC , sub_category ASC, id ASC ; ", $db);
		
	$category = "";
	$subcategory = "";
	$i=0;
	$check = false;
	while($row=mysql_fetch_row($squery))
	{
		if($category != $row[1] || $subcategory != $row[2])
		{	
			if($subcategory != $row[2] )
			{
				$category = $row[1];
				$subcategory = $row[2];
				if($check)
					echo '</optgroup>';
				echo '<optgroup label="'.getCategory($category).' &gt; '.getCategory($subcategory).'" style="color:#aaa;">';
				$check = true;
			}
		}	
	?>
		<option value="<?php echo $row[0]; ?>" style="color:#000;" <?php if($selectedID == $row[0]) echo 'selected="selected"'; ?> ><?php echo $row[3]; ?></option>
	<?php 
	}
	echo '</optgroup>';
	?> 
	</select>
	<?php 
	}
	else if($smode == '2')
	{
	?>
	<div class="lable" >News</div>
	<select class="textbykk" id="linkid<?php echo $slink; ?>" name="linkid<?php echo $slink; ?>" style="width: 412px;" >
		<?php 
		$squery = mysql_query("SELECT id, name FROM newsbykk_".$slang." WHERE state = 1 ORDER BY id  DESC ;", $db);
		while($row=mysql_fetch_row($squery))
		{
		?>
			<option value="<?php echo $row[0]; ?>" <?php if($selectedID == $row[0]) echo 'selected="selected"'; ?> ><?php echo $row[1]; ?></option>
		<?php 
		}
		?>
	</select>
	<?php
	}
	else if($smode == '3')
	{
	?>
	<div class="lable" >Gallery</div>
	<select class="textbykk" id="linkid<?php echo $slink; ?>" name="linkid<?php echo $slink; ?>" style="width: 412px;" >
		<?php 
		$squery = mysql_query("SELECT album FROM gallerybykk_".$slang." WHERE state = 1 ORDER BY id  DESC ;", $db);
		$albumCheck = '';
		while($row=mysql_fetch_row($squery))
		{
			if($albumCheck != $row[0])
			{
				$albumCheck = $row[0];
				?>
					<option value="<?php echo $row[0]; ?>" <?php if($selectedID == $row[0]) echo 'selected="selected"'; ?> ><?php echo setCategory($row[0]); ?></option>
				<?php 
			}
		}
		?>
	</select>
	<?php
	}
	else if($smode == '4')
	{
		?>
		<div class="lable" >Weblink</div>
		<input class="textbykk" type="text" id="linkid<?php echo $slink; ?>" name="linkaddress<?php echo $slink; ?>" value='<?php if($selectedID == '') echo "http://"; else echo $selectedID; ?>' style="direction: ltr;width: 400px;">
		<?php
	}
	else if($smode == '5')
	{
		?>
		<div class="lable" >Form</div>
		<select class="textbykk" id="linkid<?php echo $slink; ?>" name="linkid<?php echo $slink; ?>" style="width: 412px;" >
			<?php 
			$squery = mysql_query("SELECT id, name FROM formbykk WHERE state = 1 ORDER BY id  DESC ;", $db);
			while($row=mysql_fetch_row($squery))
			{
			?>
				<option value="<?php echo $row[0]; ?>" <?php if($selectedID == $row[0]) echo 'selected="selected"'; ?> ><?php echo $row[1]; ?></option>
			<?php 
			}
			?>
		</select>
		<?php
		}
	else
	{
	?>
	<div class="lable" >&nbsp;</div>
	<select class="textbykk" id="linkid<?php echo $slink; ?>" name="linkid<?php echo $slink; ?>" disabled="disabled" style="width: 412px;" >
		<option value="0" selected="selected"></option>
	</select>
	<?php	
	}
}
?>