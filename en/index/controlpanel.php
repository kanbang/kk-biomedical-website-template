<?php
include 'database.php';
if($isAdmin)
{
?>
	<script type="text/javascript">
	$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=controlpanel', function() {
		$("#page-nav").animate({'opacity':'1'}, 300);
		});
	</script>
	<div style="opacity:0;width: 100%;height: 100%;" id="index-loader">
		<div class="controlpanel-item" style="cursor: default;" >
			<span class="left" style="font-weight: bold;">Most Visited Product:</span>
			<?php 
			$query = mysql_query("SELECT id, category, sub_category, name FROM productbykk_".$sitelang." WHERE state = 1 ORDER BY visitcounter  DESC ;", $db);
			if (!$query)
				die("Error reading query: ".mysql_error());
			
			if($row=mysql_fetch_row($query))
			{
				?>
				<span class="left" style="cursor: pointer;" onclick="gotoPage('full',500,'index/product.php?category=<?php echo encodeURIComponent($row[1]); ?>&sub_category=all');" ><?php echo getCategory($row[1]);?></span>
				<span class="left">&gt;</span>
				<span class="left" style="cursor: pointer;" onclick="gotoPage('full',500,'index/product.php?category=<?php echo encodeURIComponent($row[1]); ?>&sub_category=<?php echo encodeURIComponent($row[2]); ?>');"><?php echo getCategory($row[2]);?></span>
				<span class="left">&gt;</span>
				<span class="left" style="cursor: pointer;" onclick="gotoPage('full',500,'index/product.php?category=<?php echo encodeURIComponent($row[1]); ?>&sub_category=<?php echo encodeURIComponent($row[2]); ?>&ptoshow=<?php echo $row[0]; ?>');"><?php echo $row[3];?></span>
				<?php
			}
			?>
		</div>
		<div class="controlpanel-item" style="cursor: default;" >
			<span class="left" style="font-weight: bold;">Least Visited Product:</span>
			<?php 
			$query = mysql_query("SELECT id, category, sub_category, name FROM productbykk_".$sitelang." WHERE state = 1 ORDER BY visitcounter  ASC ;", $db);
			if (!$query)
				die("Error reading query: ".mysql_error());
			
			if($row=mysql_fetch_row($query))
			{
				?>
				<span class="left" style="cursor: pointer;" onclick="gotoPage('full',500,'index/product.php?category=<?php echo encodeURIComponent($row[1]); ?>&sub_category=all');" ><?php echo getCategory($row[1]);?></span>
				<span class="left">&gt;</span>
				<span class="left" style="cursor: pointer;" onclick="gotoPage('full',500,'index/product.php?category=<?php echo encodeURIComponent($row[1]); ?>&sub_category=<?php echo encodeURIComponent($row[2]); ?>');"><?php echo getCategory($row[2]);?></span>
				<span class="left">&gt;</span>
				<span class="left" style="cursor: pointer;" onclick="gotoPage('full',500,'index/product.php?category=<?php echo encodeURIComponent($row[1]); ?>&sub_category=<?php echo encodeURIComponent($row[2]); ?>&ptoshow=<?php echo $row[0]; ?>');"><?php echo $row[3];?></span>
				<?php
			}
			?>
		</div>
		<div class="controlpanel-item" style="cursor: default;" >
			<span class="left" style="font-weight: bold;">Most Visited News / Article:</span>
			<?php 
			$query = mysql_query("SELECT id, name FROM newsbykk_".$sitelang." WHERE state = 1 ORDER BY visitcounter  DESC ;", $db);
			if (!$query)
				die("Error reading query: ".mysql_error());
			
			if($row=mysql_fetch_row($query))
			{
				?>
				<span class="left" style="cursor: pointer;" onclick="gotoPage('full',500,'index/news.php?ntoshow=<?php echo $row[0]; ?>');"><?php echo $row[1];?></span>
				<?php
			}
			?>
		</div>
		<div class="controlpanel-item" style="cursor: default;width: 46%;" >
			<span class="left" style="font-weight: bold;">Message:</span>
			<?php 
			$query = mysql_query("SELECT * FROM messagebykk WHERE state = 1 ;", $db);
			if (!$query)
				die("Error reading query: ".mysql_error());
			
			if($num=mysql_num_rows($query))
			{
				?>
				<span class="left" title="All Messages" style="cursor: pointer;" onclick="gotoPage('full',500,'index/message.php');"><?php echo $num;?></span>
				<span class="left">/</span>
				<?php
			}
			$query = mysql_query("SELECT * FROM messagebykk WHERE state = 1 AND seen = 0 ;", $db);
			if (!$query)
				die("Error reading query: ".mysql_error());
				
			if(($num=mysql_num_rows($query)) >= 0)
			{
				?>
				<span class="left" title="Unread Messages" style="cursor: pointer;" onclick="gotoPage('full',500,'index/message.php');"><?php echo $num;?></span>
				<?php
			}
			?>
		</div>
		<div class="controlpanel-item" style="cursor: default;width: 47%;margin-left: 8px;" >
			<span class="left" style="font-weight: bold;">User Num:</span>
			<?php 
			$query = mysql_query("SELECT * FROM registerbykk WHERE state != 0 AND uadmin != 1 ;", $db);
			if (!$query)
				die("Error reading query: ".mysql_error());
			
			if($num=mysql_num_rows($query))
			{
				?>
				<span class="left" style="cursor: pointer;" onclick="gotoPage('full',500,'index/member.php');"><?php echo $num;?></span>
				<?php
			}
			?>
		</div>
		<div class="controlpanel-item" style="cursor: default;width: 46%;" >
			<span class="left" style="font-weight: bold;">Filled Forms:</span>
			<?php 
			$query = mysql_query("SELECT * FROM filledformbykk WHERE state = 1 ;", $db);
			if (!$query)
				die("Error reading query: ".mysql_error());
			
			if($num=mysql_num_rows($query))
			{
				?>
				<span class="left" title="All" style="cursor: pointer;" onclick="gotoPage('full',500,'index/filledforms.php');"><?php echo $num;?></span>
				<span class="left">/</span>
				<?php
			}
			$query = mysql_query("SELECT * FROM filledformbykk WHERE state = 1 AND seen = 0 ;", $db);
			if (!$query)
				die("Error reading query: ".mysql_error());
				
			if(($num=mysql_num_rows($query)) >= 0)
			{
				?>
				<span class="left" title="Unread" style="cursor: pointer;" onclick="gotoPage('full',500,'index/filledforms.php');"><?php echo $num;?></span>
				<?php
			}
			?>
		</div>
		<div class="controlpanel-item" style="cursor: default;width: 47%;margin-left: 8px;" >
			<span class="left" style="font-weight: bold;">Form Num:</span>
			<?php 
			$query = mysql_query("SELECT * FROM formbykk WHERE state != 0 ;", $db);
			if (!$query)
				die("Error reading query: ".mysql_error());
			
			if($num=mysql_num_rows($query))
			{
				?>
				<span class="left" style="cursor: pointer;" onclick="gotoPage('full',500,'index/addform.php');"><?php echo $num;?></span>
				<?php
			}
			?>
		</div>
		<div class="controlpanel-item" style="width: 98%;cursor: default;padding: 1% 0px;" >
			<span class="left" style="width: 10.4%;">Data</span>
			<span class="left" style="width: 10.4%;">Home</span>
			<span class="left" style="width: 10.4%;">Product</span>
			<span class="left" style="width: 10.4%;">News/Article</span>
			<span class="left" style="width: 10.4%;">Gallery</span>
			<span class="left" style="width: 10.4%;">About</span>
			<span class="left" style="width: 10.4%;">Contact</span>
			<span class="left" style="width: 10.4%;">Form</span>
			<span class="left" style="width: 8.5%;">Total</span>
		</div>
		<div class="controlpanel-index" style="width: 98%;display: block;padding: 1% 0px;">
		<?php 
		$check = false;
		$query = mysql_query("SELECT * FROM visitbykk_".$sitelang." ORDER BY id DESC ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		while ($rows=mysql_fetch_row($query))
		{
			if($check)
			{
			?>
			<span class="left" style="width: 96%;margin: 5px 2% 2px 2%;border-top: 1px #ddd solid;height: 3px;overflow: hidden;">&nbsp;</span>
			<?php 
			}
			?>
			<span class="left" style="width: 10.4%;"><?php echo $rows[1]; ?></span>
			<span class="left" style="width: 10.4%;"><?php echo $rows[2]; ?></span>
			<span class="left" style="width: 10.4%;"><?php echo $rows[3]; ?></span>
			<span class="left" style="width: 10.4%;"><?php echo $rows[4]; ?></span>
			<span class="left" style="width: 10.4%;"><?php echo $rows[5]; ?></span>
			<span class="left" style="width: 10.4%;"><?php echo $rows[6]; ?></span>
			<span class="left" style="width: 10.4%;"><?php echo $rows[7]; ?></span>
			<span class="left" style="width: 10.4%;"><?php echo $rows[8]; ?></span>
			<span class="left" style="width: 8.5%;"><?php echo  $rows[8] + $rows[7] + $rows[6] + $rows[5] + $rows[4] + $rows[3] + $rows[2] + $rows[1]; ?></span>
		<?php 
			$check = true;
		}
		?>
		</div>
	</div>
<?php 
}
?>