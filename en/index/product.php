<?php
include 'database.php';
if($_GET["show"] == '1')
{
	$id = $_GET["id"];
	$query = mysql_query("UPDATE productbykk_".$sitelang." SET visitcounter = visitcounter + 1 WHERE id = '$id' ;", $db);
	if($isAdmin)
		$query = mysql_query("SELECT * FROM productbykk_".$sitelang." WHERE state = 1 AND id = '$id' ORDER BY id  DESC ;", $db);
	else
		$query = mysql_query("SELECT * FROM productbykk_".$sitelang." WHERE state = 1 AND showto <= '$level' AND showto > 0 AND id = '$id' ORDER BY id  DESC ;", $db);
	if (!$query)
		die("Error reading query: ".mysql_error());
	if($prow=mysql_fetch_row($query))
	{
	?>
	<span id="close-product">
	</span>
	<div class="container">
	<h1 id="product-title" ><?php echo $prow[1];?><br><span><?php echo $prow[2];?></span></h1>
		<div id="product-tabs" >
			<?php 
			if($prow[12] != ''){?><div class="tab selected" rel=".tab-1" ><span><?php echo $prow[12];?></span></div><?php }
			if($prow[14] != ''){?><div class="tab" rel=".tab-2" ><span><?php echo $prow[14];?></span></div><?php }
			if($prow[16] != ''){?><div class="tab" rel=".tab-3" ><span><?php echo $prow[16];?></span></div><?php }
			if($prow[18] != ''){?><div class="tab" rel=".tab-4" ><span><?php echo $prow[18];?></span></div><?php }
			if($prow[20] != '' && (($prow[21] <= $level && $prow[21] > 0) || $isAdmin)){?><div class="tab" rel=".tab-5" ><span>Downloads</span></div><?php }
			?>
			
		</div>
		<?php 
		if($prow[12] != '')
		{
		?>
		<div class="tab-container tab-1" >
			<div class="tab-inner">
				<div id="ftabs-1">
				<?php 
				$f = fopen("../".$prow[13], "r");
				if($f===false)
					die("'".$prow[13]."' doesn't exist.");
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
		</div>
		<?php 
		}
		
		if($prow[14] != '')
		{
		?>
		<div class="tab-container tab-2" >
			<div class="tab-inner">
				<div id="ftabs-1">
				<?php 
				$f = fopen("../".$prow[15], "r");
				if($f===false)
					die("'".$prow[15]."' doesn't exist.");
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
		</div>
		<?php 
		}
		
		if($prow[16] != '')
		{
		?>
		<div class="tab-container tab-3" >
			<div class="tab-inner">
				<div id="ftabs-1">
				<?php 
				$f = fopen("../".$prow[17], "r");
				if($f===false)
					die("'".$prow[17]."' doesn't exist.");
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
		</div>
		<?php 
		}
		 
		if($prow[18] != '')
		{
		?>
		<div class="tab-container tab-4" >
			<div class="tab-inner">
				<div id="ftabs-1">
				<?php 
				$f = fopen("../".$prow[19], "r");
				if($f===false)
					die("'".$prow[19]."' doesn't exist.");
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
		</div>
		<?php 
		}
		
		if($prow[20] != '' && (($prow[21] <= $level && $prow[21] > 0) || $isAdmin))
		{
			?>
		<div class="tab-container tab-5" >
			<div class="tab-inner">
				<?php
				$attachments = explode("|", $prow[20]);
				foreach ($attachments as $attachment)
				{
					if(strlen($attachment) > 3)
					{
				?>
				<div class="news-attachment" ><img src="../images/attachment.png" ><a href="product/attachment/<?php echo $attachment;?>" class="download" target="_blank">Download(<?php echo $attachment; ?>)</a></div><br>
				<?php
					}
				}
				?>
			</div>
		</div>
			<?php
		}
		?>
		<div id="product-images-container">
		<!-- start of product image gallery -->
				<div id="product-photo-gallery" class="ad-gallery">
			      <div class="ad-image-wrapper">
			      </div>
			      <div class="ad-nav">
			        <div class="ad-thumbs">
			          <ul class="ad-thumb-list">
			            <li>
			              <a href="<?php echo $prow[8]; ?>">
			                <img src="<?php echo $prow[9]; ?>" height="60">
			              </a>
			            </li>
			            <?php 
			            $other_pictures = $prow[10];
			            $other_pictures_thumb = $prow[11];
			            $other_pictures = explode("|", $other_pictures);
			            $other_pictures_thumb = explode("|", $other_pictures_thumb);
			            $i=0;
			            foreach($other_pictures_thumb as $pictures)
			            {
			            	if(strlen($pictures) > 3)
			            	{
			            	?>
			            	<li>
				              <a href="<?php echo "product/".$other_pictures[$i]; ?>">
				                <img src="<?php echo "product/".$pictures; ?>">
				              </a>
				            </li>
			            	<?php	
							$i++;
							}
            						
						}
			            ?>
		            </ul>
	            </div>
            </div>
            </div>
			<!-- end of product image gallery -->
		</div>
		<?php 
		$linkto_lang = explode("|", $prow[22]);
		$linkto = $linkto_lang[1];
		$linkto_lang = $linkto_lang[0];
		if($linkto != '0')
		{
			echo '<div class="news-attachment" style="width:98.7%;" ><img src="../images/attachment.png" />';
			pnlink($sitelang, $linkto_lang, $linkto, $prow[23], $prow[24], $db,'product');
			echo '</div>';
		}
		
		$linkto_lang = explode("|", $prow[25]);
		$linkto = $linkto_lang[1];
		$linkto_lang = $linkto_lang[0];
		if($linkto != '0')
		{
			echo '<div class="news-attachment" style="width:98.7%;" ><img src="../images/attachment.png" />';
			pnlink($sitelang, $linkto_lang, $linkto, $prow[26], $prow[27], $db,'product');
			echo '</div';
		}
		?>
	</div>
	<script>
	$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=product&id=<?php echo $id; ?>', function() {
		$("#page-nav").animate({'opacity':'1'}, 300);
		});

	<?php 
	if($isAdmin)
	{
	?>
	$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
		"<div class='btn add' onclick='addProduct();' title='Add product' ></div><div class='btn change' onclick='editProduct(<?php echo $prow[0]; ?>);' title='Edit product' ></div><div class='btn delete' onclick='deleteProduct(<?php echo $prow[0]; ?>);' title='Delete product' ></div>"
		).animate({'opacity':'1'},300);
	<?php 
	}
	?>
	//********\\

	$("#product-photo-gallery").mouseenter(function(){
		$("#product-photo-gallery .ad-nav").stop().css({'display':'block'}).animate({'opacity':'1'},300);
	}).mouseleave(function(){
		$("#product-photo-gallery .ad-nav").stop().animate({'opacity':'0'},300,function(){
			$("#product-photo-gallery .ad-nav").css({'display':'none'});
		});
	});
	
	$("#product-tabs .tab").mouseenter(function(){
		$("#product-tabs .tab").not(this).stop().animate({'margin-left':'0','padding-left':'25px'},200);
		$(this).stop().animate({'margin-left':-($(this).children("span").width())+'px','padding-left':'10px'},200);
	}).mouseleave(function(){
		$("#product-tabs .tab.selected").stop().animate({'margin-left':-($("#product-tabs .tab.selected span").width())+'px','padding-left':'10px'},200);
		$("#product-tabs .tab").not(".selected").stop().animate({'margin-left':'0','padding-left':'25px'},200);
	});
	
	$("#product-tabs .tab").click(function(){
		$("#product-tabs .tab").removeClass("selected");
		$(this).addClass("selected");
		$("#product-tabs .tab.selected").stop().animate({'margin-left':-($("#product-tabs .tab.selected span").width())+'px','padding-left':'10px'},200);
		$("#product-tabs .tab").not(".selected").stop().animate({'margin-left':'0','padding-left':'25px'},200);
		$(".tab-container").stop().animate({'opacity':'0'},200,function(){
			$("tab-container").not($(this).attr("rel")).css({'display':'none'});
		});
		
		$($(this).attr("rel")).stop().delay(200).css({'display':'block'}).animate({'opacity':'1'},200,function(){
		});

		
	});

	$("#close-product").click(function(){
		if($("#product-index").hasClass("open"))
		{
			$("#product-index").removeClass("open");
			$("#product-index").stop().animate({'height':'0'},300,function(){
				$("#product-index").css({'height':'auto','display':'none'});
				$("#product-index").addClass("close");
			});
			$("#product-overlay").stop().animate({'opacity':'0'},300,function(){
				$("#product-overlay").css({'opacity':'1','display':'none'});
			});
			$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
				"<div class='btn add' onclick='addProduct();' title='Add Product' ></div>"
				).animate({'opacity':'1'},300);
			clearInterval(checkProductScrollUpLoop);
		}
	});
	
	$("#product-index .primary .secondary .container .tab-container").mouseenter(function(){
		$("#product-tabs .tab").stop().animate({'margin-left':'0','padding-left':'25px'},200);
	}).mouseleave(function(){
		$("#product-tabs .tab.selected").stop().animate({'margin-left':-($("#product-tabs .tab.selected span").width())+'px','padding-left':'10px'},200);
		$("#product-tabs .tab").not(".selected").stop().animate({'margin-left':'0','padding-left':'25px'},200);
	});
	
	setTimeout(function(){
		$("#product-tabs .tab.selected").css({'margin-left':-($("#product-tabs .tab.selected span").width())+'px','padding-left':'10px'});
		$("#product-tabs .tab").not(".selected").css({'margin-left':'0','padding-left':'25px'});
		$($("#product-tabs .tab.selected").attr("rel")).css({'display':'block','opacity':'1'});
		$("#product-photo-gallery .ad-nav").css({'display':'block'});
		
		$('#product-photo-gallery').adGallery();

		$('.tab-container .tab-inner').slimScroll({
	      wheelStep: 20,
	      height:'455px',
	      position: 'left'
	  });
	},300);

	var productScrollTop = 0;
	function checkProductScrollUp()
	{
		var pScrollTop =  $(document).scrollTop(), indexHeight = $("#news-index").height() - $(window).height() + 50;
		if(indexHeight<0) indexHeight = 0;
		if(productScrollTop == pScrollTop && (pScrollTop < 330 || pScrollTop > (350 + indexHeight)))
		{
			if(indexHeight == 0)
				$("html, body").animate({ scrollTop: "342px" },200);
			else
			{
				if(nScrollTop < 330)
					$("html, body").animate({ scrollTop: "342px" },200);
				else
					$("html, body").animate({ scrollTop: (342 + indexHeight)+"px" },200);
			}
		}
		productScrollTop = pScrollTop;
	}
	checkProductScrollUpLoop = setInterval(checkProductScrollUp, 1000);
	</script>
	<?php
	}
}
else 
{
	if(!isset($_GET["category"]) && !isset($_GET["sub_category"]))
	{
		if($isAdmin)
			$query = mysql_query("SELECT category, sub_category FROM productbykk_".$sitelang." WHERE state = 1 ORDER BY id  DESC ;", $db);
		else
			$query = mysql_query("SELECT category, sub_category FROM productbykk_".$sitelang." WHERE state = 1 AND showto <= '$level' AND showto > 0  ORDER BY id  DESC ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
	
		if( $rows=mysql_fetch_row($query) )
		{
			$category = $rows[0];
			$sub_category = $rows[1];
		}
	}
	else
	{
		$category = $_GET["category"];
		$sub_category = $_GET["sub_category"];
	}
	
	if($isAdmin)
	{
		if($sub_category == 'all')
			$query = mysql_query("SELECT id, name, p_note, picture, picture_thumb, highlight, sub_category, visitcounter FROM productbykk_".$sitelang." WHERE state = 1 AND category = '$category' ORDER BY id  DESC ;", $db);
		else
			$query = mysql_query("SELECT id, name, p_note, picture, picture_thumb, highlight, sub_category, visitcounter FROM productbykk_".$sitelang." WHERE state = 1 AND category = '$category' AND sub_category = '$sub_category' ORDER BY id  DESC ;", $db);
	}
	else
	{
		if($sub_category == 'all')
			$query = mysql_query("SELECT id, name, p_note, picture, picture_thumb, highlight, sub_category FROM productbykk_".$sitelang." WHERE state = 1 AND showto <= '$level' AND showto > 0 AND category = '$category' ORDER BY id  DESC ;", $db);
		else
			$query = mysql_query("SELECT id, name, p_note, picture, picture_thumb, highlight, sub_category FROM productbykk_".$sitelang." WHERE state = 1 AND showto <= '$level' AND showto > 0 AND category = '$category' AND sub_category = '$sub_category' ORDER BY id  DESC ;", $db);
	}
	if (!$query)
		die("Error reading query: ".mysql_error());
	$num = mysql_num_rows($query);
	$i=0;
	while($prows=mysql_fetch_row($query))
	{
		$allrows[$i] = $prows;
		$i++;
	}
	
	/*$num = 30;
	for($i=0;$i<$num;$i++)
	{
		$allrows[$i][0] = $i;
		if(rand(0, 12)%4 == 0)
			$allrows[$i][5] = 1;
		else
			$allrows[$i][5] = 0;
		echo $allrows[$i][0]."-".$allrows[$i][5]."|";
	}*/
	
	
	function swap (&$ary,$element1,$element2)
	{
		$temp=$ary[$element1];
		$ary[$element1]=$ary[$element2];
		$ary[$element2]=$temp;
	}
	
	/*for($i=0;$i<(($num/4)+1);$i++)
	{*/
	$start_counter = 0;
	while(1)
	{
		if($start_counter >= $num)
			break;
		$check2 = false;
		for($j=0;$j<4;$j++)
		{
			if($allrows[$start_counter+$j][5] == 1)
			{
				$check2 = true;
				break;
			}
		}
		
		if($check2)
		{
			$check1 = false;
			for($j=0;$j<5;$j++)
			{
				if(($start_counter+$j) >= $num)
					break;
				if($allrows[$start_counter+$j][5] == 1 && !$check1 && $j == 0)
				{
					$check1 = true;
				}
				else if($allrows[$start_counter+$j][5] == 1 && !$check1 && $j != 0)
				{
					swap($allrows,($start_counter+$j), $start_counter);
					$check1 = true;
				}
				else if($allrows[$start_counter+$j][5] == 1 && $check1 && $j != 0)
				{
					for($k = ($start_counter+$j+1); $k < $num;$k++)
					{
						if($allrows[$k][5] != 1)
						{
							swap($allrows,($start_counter+$j), $k);
							break;
						}
					}
				}
			}
			$start_counter = $start_counter + 5;
		}
		else
		{
			$start_counter = $start_counter + 4;
		}
	}
?>
<?php 
	if($isAdmin)
	{
	?>
	<div id="delete_dialogP" title="Delete Product" style="display: none;">
	<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are You Sure?
	</div>
	<?php 
	}
?>
<script>
<?php 
if(isset($_GET["category"]))
{
?>
	$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=product&category=<?php echo encodeURIComponent($category);?>&sub_category=<?php echo encodeURIComponent($sub_category);?>', function() {
		$("#page-nav").animate({'opacity':'1'}, 300);
	});
<?php 
}
else
{
?>
	$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=product', function() {
		$("#page-nav").animate({'opacity':'1'}, 300);
	});
<?php 
}

if($isAdmin)
{
?>
var deletePID=0;
function addProduct()
{
	gotoPage('full',500,'index/addproduct.php');
}
function deleteProduct(pid)
{
	deletePID = pid;
	$("#delete_dialogP").dialog("open");
}
function starProduct(id,category,subcategory)
{
	var encodeCategory = encodeURIComponent(category);
	var encodeSubcategory = encodeURIComponent(subcategory);
	progressBar(300, 25);
	$.get('index/addproduct.php?mode=star&id='+id,function(){
		gotoPage('full',500,'index/product.php?category='+encodeCategory+'&sub_category='+encodeSubcategory);
	});
}
function unstarProduct(id,category,subcategory)
{
	var encodeCategory = encodeURIComponent(category);
	var encodeSubcategory = encodeURIComponent(subcategory);
	progressBar(300, 25);
	$.get('index/addproduct.php?mode=unstar&id='+id,function(){
		gotoPage('full',500,'index/product.php?category='+encodeCategory+'&sub_category='+encodeSubcategory);
	});
}
function editProduct(id)
{
	gotoPage('full',500,'index/addproduct.php?mode=edit&id='+id);
	try
	{
		clearInterval(checkProductScrollUpLoop);
	}
	catch(e)
	{
		console.log(e);
	}
}
$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
"<div class='btn add' onclick='addProduct();' title='Add Product' ></div>"
).animate({'opacity':'1'},300);
$(function() {
	$("#delete_dialogP").dialog({
		autoOpen: false,
		resizable: false,
		height:120,
		modal: true,
		buttons: {
			"Yes": function() {
				$.get('index/addproduct.php?mode=delete&id='+deletePID,function()
				{
					gotoPage('full',500,'index/product.php');
				});
				$( this ).dialog( "close" );
			},
			"Cancel": function() {
				$( this ).dialog( "close" );
			}
		}
	});
});
<?php 
}
?>
var isInsideControl = false;
$(".control-container").mouseenter(function(){
	isInsideControl = true;
}).mouseover(function(){
	isInsideControl = true;
}).mouseleave(function(){
	isInsideControl = false;
});

function showProduct(id)
{
	if($("#product-index").hasClass("close") && !isInsideControl)
	{
		progressBar(400,50);
		$("#product-index .primary .secondary").load('index/product.php?show=1&id='+id,function(){
			var productIndexHeight = $("#product-index").height();
			$("#product-index").removeClass("close");
			$("#product-index").stop().css({'height':'0px','display':'block'}).animate({'height':productIndexHeight+'px'},300,function(){
				$("#product-index").addClass("open");
				$("html, body").animate({scrollTop: "342px"},200);
				//product photo gallery
				//
			});
			$("#product-overlay").stop().css({'opacity':'0.1','display':'block'}).animate({'opacity':'1'},300);
			progressBar(300,100);
		});
	}
}

</script>
<div style="opacity:0;width: 100%;height: 100%;" id="index-loader">
	<div id="product-categry-container" >
		<div id="product-sub-category">
			<ul>
			<?php 
			if($isAdmin)
				$cquery = mysql_query("SELECT category, sub_category, sub_category_picture, picture_thumb FROM productbykk_".$sitelang." WHERE state = 1 ORDER BY category ASC , sub_category ASC ;", $db);
			else
				$cquery = mysql_query("SELECT category, sub_category, sub_category_picture, picture_thumb FROM productbykk_".$sitelang." WHERE state = 1 AND showto <= '$level' AND showto > 0  ORDER BY category  ASC , sub_category ASC ;", $db);
			if (!$cquery)
				die("Error reading query: ".mysql_error());
			
			$check = false;
			$check_category = '';
			$check_sub_category = '';
			while($crows=mysql_fetch_row($cquery))
			{
				if($check_sub_category != $crows[1])
				{
					$check_sub_category = $crows[1];
					if($check_category != $crows[0])
					{
						if($check)
							echo "</ul><ul>";
						else
							$check = true;
						$check_category = $crows[0];
					}
					
					if($crows[2] != '')
						$img = $crows[2];
					else
						$img = $crows[3];
						
					if(!file_exists("../".$img))
						$img = "../images/white.png";
				?>
				<li>
					<a href="?cmode=full&command=<?php echo encodeURIComponent("index/product.php?category=".$crows[0]."&sub_category=".$crows[1]); ?>" class="img" onclick="gotoPage('full',500,'index/product.php?category=<?php echo encodeURIComponent($crows[0]); ?>&sub_category=<?php echo encodeURIComponent($crows[1]); ?>');" >
						<img src="<?php echo $img; ?>" />
					</a>
					<h4><a href="?cmode=full&command=<?php echo encodeURIComponent("index/product.php?category=".$crows[0]."&sub_category=".$crows[1]); ?>" onclick="gotoPage('full',500,'index/product.php?category=<?php echo encodeURIComponent($crows[0]); ?>&sub_category=<?php echo encodeURIComponent($crows[1]); ?>');" <?php if($crows[1] == $sub_category && $crows[0] == $category) echo 'class="selected"'; ?>><?php echo getCategory($crows[1]); ?></a></h4>
				</li>
				<?php 
				
				}
			}
			?>
			</ul>
		</div>
		<div id="product-category">
		    <!-- <a href="#" data-target="0" >Pro Video</a>
		    <a href="#" data-target="1" class="active">Pro Audio</a>
		    <a href="#" data-target="2">Computer &amp; Office</a>
		    <a href="#" data-target="3">Meeting &amp; Event</a> -->
		    <?php 
		    if($isAdmin)
		    	$cquery = mysql_query("SELECT category FROM productbykk_".$sitelang." WHERE state = 1 ORDER BY category  ASC ;", $db);
		    else
		    	$cquery = mysql_query("SELECT category FROM productbykk_".$sitelang." WHERE state = 1 AND showto <= '$level' AND showto > 0  ORDER BY category  ASC ;", $db);
		    if (!$cquery)
		    	die("Error reading query: ".mysql_error());
		    
		    $check_category = '';
		    $i=0;
		    while($crows=mysql_fetch_row($cquery))
		    {
		    	if($check_category != $crows[0])
		    	{
		    		$check_category = $crows[0];
		    	?>
		    	<a href="?cmode=full&command=<?php echo encodeURIComponent("index/product.php?category=".$crows[0]."&sub_category=all"); ?>"  ondblclick="gotoPage('full',500,'index/product.php?category=<?php echo encodeURIComponent($crows[0]); ?>&sub_category=all');"  data-target="<?php echo $i;?>" <?php if($crows[0] == $category) echo 'class="active"'; ?> ><?php echo getCategory($crows[0]); ?></a>
		    	<?php
		    	$i++;
		    	}
		    }
		    ?>
		</div>
	</div>
	<div id="product-index" class="close" >
		<div class="primary" >
			<div class="secondary" >
				
			</div>
		</div>
	</div>
	<div id="product-items">
		<div class="container" >
		<?php 
		$start_counter = 0;
		$parity = true;
		while(1)
		{
			if($start_counter >= $num)
				break;
			$check2 = 0;
			$counter = 0;
			for($j=0;$j<4;$j++)
			{
				if($allrows[$start_counter+$j][5] == 1)
				{
					$counter++;
				}
			}
			if($counter >= 2 )
			{
				$counter = 0;
				for($j=0;$j<2;$j++)
				{
					if($allrows[$start_counter+$j][5] == 1)
					{
						$counter++;
					}
				}
				if($counter >=2)
					$check2 = 2;
				else
					$check2 = 1;
			}
			else if($counter == 1)
				$check2 = 1;
			else
				$check2 = 0;
			
			if($check2 == 0)
			{
				echo "<div style='height:238px;width:948px;' >";
				for($i=0;$i<4;$i++)
				{
					if($start_counter + $i >= $num)
						break;
				?>
				<div style="background-image: url('<?php echo $allrows[$start_counter+$i][4]; ?>');" class="item small" >
					<?php 
					if($isAdmin)
					{
					?>
					<div class="control-container">
						<div class="btn star none" onclick="starProduct(<?php echo $allrows[$start_counter+$i][0]; ?>,'<?php echo $category; ?>','<?php echo $sub_category; ?>');"></div>
						<div class="btn delete" onclick="deleteProduct(<?php echo $allrows[$start_counter+$i][0]; ?>);"></div>
						<div class="btn edit" onclick="editProduct(<?php echo $allrows[$start_counter+$i][0]; ?>);"></div>
						<div class="visit-counter" >Visit: <?php echo $allrows[$start_counter+$i][7]; ?></div>
					</div>
					<?php 
					}
					?>
					<a href="?cmode=full&command=<?php echo encodeURIComponent("index/product.php?category=".$category."&sub_category=".$sub_category."&ptoshow=".$allrows[$start_counter+$i][0]); ?>" >
					<div  class="p-inner none-pattern" onclick="showProduct(<?php echo $allrows[$start_counter+$i][0]; ?>);">
						<span class="first">
							<?php echo $allrows[$start_counter+$i][1]; ?>
						</span>
						<span class="second">
							<?php echo $allrows[$start_counter+$i][2]; ?>
						</span>
					</div>
					</a>
				</div>
				<?php 
				}
				$start_counter = $start_counter + 4;
			}
			else if($check2 == 1)
			{
				echo "<div style='height:475px;width:948px;' >";
				$check1 = false;
				$check2 = false;
				for($i=0;$i<5;$i++)
				{
					if($start_counter + $i >= $num)
						break;
					// checking more than 2 highlighted item
					if($allrows[$start_counter+$i][5] == 1 && $check1)
					{
						$start_counter = $start_counter + $i;
						$check2 = true;
						break;
					}
					if($allrows[$start_counter+$i][5] == 1)
					{
						$check1 = true;
					?>
					<div style="background-image: url('<?php echo $allrows[$start_counter+$i][3]; ?>');<?php if(!$parity) echo "float:right;"?>" class="item big"  >
						<?php 
						if($isAdmin)
						{
						?>
						<div class="control-container">
							<div class="btn star selected" onclick="unstarProduct(<?php echo $allrows[$start_counter+$i][0]; ?>,'<?php echo $category; ?>','<?php echo $sub_category; ?>');"></div>
							<div class="btn delete" onclick="deleteProduct(<?php echo $allrows[$start_counter+$i][0]; ?>);"></div>
							<div class="btn edit" onclick="editProduct(<?php echo $allrows[$start_counter+$i][0]; ?>);"></div>
							<div class="visit-counter" >Visit: <?php echo $allrows[$start_counter+$i][7]; ?></div>
						</div>
						<?php 
						}
						?>
						<a href="?cmode=full&command=<?php echo encodeURIComponent("index/product.php?category=".$category."&sub_category=".$sub_category."&ptoshow=".$allrows[$start_counter+$i][0]); ?>" >
						<div  class="p-inner none-pattern" onclick="showProduct(<?php echo $allrows[$start_counter+$i][0]; ?>);">
							<span class="first">
								<?php echo $allrows[$start_counter+$i][1]; ?>
							</span>
							<span class="second">
								<?php echo $allrows[$start_counter+$i][2]; ?>
							</span>
						</div>
						</a>
					</div>
					<?php
					}
					else
					{
					?>
					<div style="background-image: url('<?php echo $allrows[$start_counter+$i][4]; ?>');<?php if(!$parity) echo "float:right;"?>" class="item small" >
						<?php 
						if($isAdmin)
						{
						?>
						<div class="control-container">
							<div class="btn star none" onclick="starProduct(<?php echo $allrows[$start_counter+$i][0]; ?>,'<?php echo $category; ?>','<?php echo $sub_category; ?>');"></div>
							<div class="btn delete" onclick="deleteProduct(<?php echo $allrows[$start_counter+$i][0]; ?>);"></div>
							<div class="btn edit" onclick="editProduct(<?php echo $allrows[$start_counter+$i][0]; ?>);"></div>
							<div class="visit-counter" >Visit: <?php echo $allrows[$start_counter+$i][7]; ?></div>
						</div>
						<?php 
						}
						?>
						<a href="?cmode=full&command=<?php echo encodeURIComponent("index/product.php?category=".$category."&sub_category=".$sub_category."&ptoshow=".$allrows[$start_counter+$i][0]); ?>" >
						<div class="p-inner none-pattern" onclick="showProduct(<?php echo $allrows[$start_counter+$i][0]; ?>);">
							<span class="first">
								<?php echo $allrows[$start_counter+$i][1]; ?>
							</span>
							<span class="second">
								<?php echo $allrows[$start_counter+$i][2]; ?>
							</span>
						</div>
						</a>
					</div>
					<?php 
					}
				}
				if(!$check2)
					$start_counter = $start_counter + 5;
				
				if($parity)
					$parity = false;
				else 
					$parity = true;
			}
			else if($check2 == 2)
			{
				echo "<div style='height:475px;width:948px;' >";
				for($i=0;$i<2;$i++)
				{
					if($start_counter + $i >= $num)
						break;
				?>
				<div style="background-image: url('<?php echo $allrows[$start_counter+$i][3]; ?>');" class="item big"  >
					<?php 
					if($isAdmin)
					{
					?>
					<div class="control-container">
						<div class="btn star selected" onclick="unstarProduct(<?php echo $allrows[$start_counter+$i][0]; ?>,'<?php echo $category; ?>','<?php echo $sub_category; ?>');"></div>
						<div class="btn delete" onclick="deleteProduct(<?php echo $allrows[$start_counter+$i][0]; ?>);"></div>
						<div class="btn edit" onclick="editProduct(<?php echo $allrows[$start_counter+$i][0]; ?>);"></div>
						<div class="visit-counter" >Visit: <?php echo $allrows[$start_counter+$i][7]; ?></div>
					</div>
					<?php 
					}
					?>
					<a href="?cmode=full&command=<?php echo encodeURIComponent("index/product.php?category=".$category."&sub_category=".$sub_category."&ptoshow=".$allrows[$start_counter+$i][0]); ?>" >
					<div  class="p-inner none-pattern" onclick="showProduct(<?php echo $allrows[$start_counter+$i][0]; ?>);">
						<span class="first">
							<?php echo $allrows[$start_counter+$i][1]; echo $allrows[$start_counter+$i][5];?>
						</span>
						<span class="second">
							<?php echo $allrows[$start_counter+$i][2]; ?>
						</span>
					</div>
					</a>
				</div>
				<?php 
				}
				$start_counter = $start_counter + 2;
			}
			echo "</div>";
		}
		?>
		</div>
	</div>
	<script>
	var isInsideProductIndex = false;
	$(document).ready(function(){
		
	    var productCategory = new slideMenu({
			div: "#product-sub-category",
			controls: "#product-category",
			loader: false,
			x: 140,
			y: 170,
			easing: "easeOutBackSmall",
			easeIn: "easeOutBack",
			preloadAll: true,
			frame_width: 120,
			frame_height: 120
	    });

	    $("#product-items .item a").mouseenter(function(){
	    	var pFirstDetailOW = $(this).children(".p-inner").children(".first").outerWidth(),
	    		pFirstDetailW = $(this).children(".p-inner").children(".first").width(),
	    		pSecondDetailOW = $(this).children(".p-inner").children(".second").outerWidth(),
	    		pSecondDetailW = $(this).children(".p-inner").children(".second").width();
    		
	    	$(this).children(".p-inner").children(".first").css({'width':pFirstDetailW+'px','right':(-pFirstDetailOW)+'px','display':'block'});
	    	$(this).children(".p-inner").children(".second").css({'width':pSecondDetailW+'px','left':(-pSecondDetailOW)+'px','display':'block'});
	    	
		    $(this).children(".p-inner").removeClass("none-pattern").stop().animate({'opacity':'1'},300);
		    $(this).children(".p-inner").children(".first").stop().animate({'right':'0px'},300);
		    $(this).children(".p-inner").children(".second").stop().animate({'left':'0px'},300);
		    
	    }).mouseleave(function(){
	    	$(this).children(".p-inner").addClass("none-pattern").stop().animate({'opacity':'0'},300);
	    	$(this).children(".p-inner").children(".first").css({'display':'none'});
		    $(this).children(".p-inner").children(".second").css({'display':'none'});
	    });

	    $("#product-index, #controlpanel_container").mouseenter(function(){
			isInsideProductIndex = true;
		}).mouseover(function(){
			isInsideProductIndex = true;
		}).mouseleave(function(){
			isInsideProductIndex = false;
		});
		$(document).click(function() {
			if(!isInsideProductIndex && $("#product-index").hasClass("open"))
			{
				$("#product-index").removeClass("open");
				$("#product-index").stop().animate({'height':'0'},300,function(){
					$("#product-index").css({'height':'auto','display':'none'});
					$("#product-index").addClass("close");
				});
				$("#product-overlay").stop().animate({'opacity':'0'},300,function(){
					$("#product-overlay").css({'opacity':'1','display':'none'});
				});
				$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
					"<div class='btn add' onclick='addProduct();' title='Add Product' ></div>"
					).animate({'opacity':'1'},300);
				clearInterval(checkProductScrollUpLoop);
			}
		});

		<?php 
		if(isset($_GET["ptoshow"]))
		{
			$toShow = $_GET["ptoshow"];
			?>
			setTimeout(function(){
			showProduct(<?php echo $toShow; ?>);
			},1000);
			<?php
		}
		?>
	});

	</script>
</div>
<?php 
}
?>