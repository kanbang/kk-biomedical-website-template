<?php
if($_GET["ajax"] == 1)
	include 'database.php';
if($isAdmin)
{
	if(isset($_GET["psclang"]))
		$psclang = $_GET["psclang"];
	else
	{
		if(!isset($psclang))
			$psclang = "en";
	}
?>

<div class="lable" ><span class="red" >*</span><?php if($psclang == 'fa') echo "زیر گروه"; else echo "Sub-category"; ?></div>
<select size="1" class="textbykk" name="sub_category" id="sub_category" onchange="subCategoryImg(this.value);" >
	<option value="" ></option>
	<?php 
	if(isset($_GET["selectedcategory"]))
	{
		$selectedcategory = $_GET["selectedcategory"];
		$selectedcategory = explode("|bykk|", $selectedcategory);
		$selectedcategory = $selectedcategory[0];
	}
	if(isset($_GET["selectedsubcategory"]))
		$selectedsubcategory = $_GET["selectedsubcategory"];
	
	
	$query = mysql_query("SELECT sub_category , sub_category_picture FROM productbykk_".$psclang." WHERE state = 1 AND category = '$selectedcategory' ORDER BY sub_category ASC ; ", $db);
	if (!$query)
		die("Error reading query: ".mysql_error());
		
	$category = "";
	while($row=mysql_fetch_row($query))
		{
		if($category != $row[0] )
			{
				echo "
				<option value='".$row[0]."|bykk|".$row[1]."' ";
				if($selectedsubcategory == $row[0])
					echo " selected = 'selected'";
				echo " >".getCategory($row[0])."</option>
				";
				$category = $row[0];
			}
		}
	?>
	<option value="other" ><?php if($psclang == 'fa') echo "دیگر..."; else echo "other..."; ?></option>
</select>
<input type="text" class="textbykk" id="sub_category_name" name="sub_category_name" >
<?php 
}
?>