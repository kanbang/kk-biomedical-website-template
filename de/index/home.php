<?php
//sleep(2);
include 'database.php';
?>
<div style="opacity:0;width: 100%;height: 100%;" id="index-loader">
	<script type="text/javascript">
	$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=main', function() {
		$("#page-nav").animate({'opacity':'1'}, 300);
		});
	$("#controlpanel_container .controls").empty();
	</script>
	<div id="home-container">
		<div id="most-visited-product" >
			<h1 class="home-title" style="line-height: 1em;" >
				Produkte<br><span style="font-size: 10px;line-height: 1em;"> (Meistbesuchten)</span>
			</h1>
			<div class="mvp-arrow prev" >
				<div id="mvp-go-prev"></div>
			</div>
			<div id="mvp-container">
				<div id="mvp-slider">
				<?php 
			    if($isAdmin)
			    	$cquery = mysql_query("SELECT id, category, sub_category, name , p_note , picture FROM productbykk_".$sitelang." WHERE state = 1 ORDER BY visitcounter  DESC , id DESC ;", $db);
			    else
			    	$cquery = mysql_query("SELECT id, category, sub_category , name , p_note , picture FROM productbykk_".$sitelang." WHERE state = 1 AND showto <= '$level' AND showto > 0  ORDER BY visitcounter  DESC , id DESC ;", $db);
			    if (!$cquery)
			    	die("Error reading query: ".mysql_error());
			    
			    $i=0;
			    while($mvprows=mysql_fetch_row($cquery))
			    {
			    	if($i>=7) break;
		    	?>
		    		<div class="mvp-item" >
		    			<a href="?cmode=full&command=<?php echo encodeURIComponent("index/product.php?category=".$mvprows[1]."&sub_category=".$mvprows[2]."&ptoshow=".$mvprows[0]); ?>" onclick="gotoPage('full',500,'index/product.php?category=<?php echo encodeURIComponent($mvprows[1]); ?>&sub_category=<?php echo encodeURIComponent($mvprows[2]); ?>&ptoshow=<?php echo $mvprows[0]; ?>')"><img alt="<?php echo $mvprows[4];  ?>" src="<?php echo $mvprows[5]; ?>"></a>
		    			<span><?php echo $mvprows[3];  ?></span>
		    		</div>
		    	<?php
		    		$i++;
			    }
			    ?>
				</div>
			</div>
			<div class="mvp-arrow next" >
				<div id="mvp-go-next" ></div>
			</div>
		</div>
		<div id="most-recent-product" >
			<h1 class="home-title" style="line-height: 1em;" >
				Produkte<br><span style="font-size: 10px;line-height: 1em;"> (Neuesten)</span>
			</h1>
			<div class="mrp-arrow prev" >
				<div id="mrp-go-prev"></div>
			</div>
			<div id="mrp-container">
				<div id="mrp-slider">
				<?php 
			    if($isAdmin)
			    	$cquery = mysql_query("SELECT id, category, sub_category, name , p_note , picture FROM productbykk_".$sitelang." WHERE state = 1 ORDER BY id DESC ;", $db);
			    else
			    	$cquery = mysql_query("SELECT id, category, sub_category , name , p_note , picture FROM productbykk_".$sitelang." WHERE state = 1 AND showto <= '$level' AND showto > 0  ORDER BY id DESC ;", $db);
			    if (!$cquery)
			    	die("Error reading query: ".mysql_error());
			    
			    $i=0;
			    while($mrprows=mysql_fetch_row($cquery))
			    {
			    	if($i>=7) break;
		    	?>
		    		<div class="mrp-item" >
		    			<a href="?cmode=full&command=<?php echo encodeURIComponent("index/product.php?category=".$mrprows[1]."&sub_category=".$mrprows[2]."&ptoshow=".$mrprows[0]); ?>" onclick="gotoPage('full',500,'index/product.php?category=<?php echo encodeURIComponent($mrprows[1]); ?>&sub_category=<?php echo encodeURIComponent($mrprows[2]); ?>&ptoshow=<?php echo $mrprows[0]; ?>')"><img alt="<?php echo $mrprows[4];  ?>" src="<?php echo $mrprows[5]; ?>"></a>
		    			<span><?php echo $mrprows[3];  ?></span>
		    		</div>
		    	<?php
		    		$i++;
			    }
			    ?>
				</div>
			</div>
			<div class="mrp-arrow next" >
				<div id="mrp-go-next" ></div>
			</div>
		</div>
		<div id="most-recent-news">
			<h1 class="recent-news-title" style="line-height: 1em;" >
				News<br><span style="font-size: 10px;line-height: 1em;"> (Neuesten)</span>
			</h1>
			<div class="mrn-scroll">
				<div class="mrn-container">
					<?php 
				    if($isAdmin)
				    	$cquery = mysql_query("SELECT id, name, summary, picture_thumb, date, time FROM newsbykk_".$sitelang." WHERE state = 1 ORDER BY id DESC ;", $db);
				    else
				    	$cquery = mysql_query("SELECT id, name, summary, picture_thumb, date, time FROM newsbykk_".$sitelang." WHERE state = 1 AND showto <= '$level' AND showto > 0  ORDER BY id DESC ;", $db);
				    if (!$cquery)
				    	die("Error reading query: ".mysql_error());
				    
				    $i=0;
				    while($mrnrows=mysql_fetch_row($cquery))
				    {
				    	if($i>=10) break;
			    	?>
					<div class="mrn-item">
						<?php 
						if($mrnrows[3] != '')
						{
						?>
						<div style="" class="img-container">
							<img alt="<?php echo $mrnrows[2]; ?>" src="<?php echo $mrnrows[3]; ?>" >
						</div>
						<?php 
						}
						?>
						<span class="date-time"><?php echo $mrnrows[4]." ".$mrnrows[5]; ?></span>
						<a href="?cmode=full&command=<?php echo encodeURIComponent("index/news.php?ntoshow=".$mrnrows[0]); ?>" onclick="gotoPage('full',500,'index/news.php?ntoshow=<?php echo $mrnrows[0]; ?>');" ><?php echo $mrnrows[1]; ?></a>
					</div>
					<?php
			    		$i++;
				    }
				    ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$("#most-visited-product").mouseenter(function(){
	$(this).stop().animate({'width':'364px'},300);
	$(this).children(".mvp-arrow").animate({'width':'25px'},300);
	$("#mvp-container").stop().animate({'margin-left':'0px'},300);

	$("#most-recent-product").stop().animate({'width':'264px'},300);
}).mouseleave(function(){
	$(this).stop().animate({'width':'314px'},300);
	$(this).children(".mvp-arrow").animate({'width':'0px'},300);
	$("#mvp-container").stop().animate({'margin-left':'-25px'},300);

	$("#most-recent-product").stop().animate({'width':'314px'},300);
});

$(".mvp-item").mouseenter(function(){
	$(this).children("span").stop().css({'height':'auto'}).animate({'padding':'10px 0 20px'},300);
}).mouseleave(function(){
	$(this).children("span").stop().animate({'padding':'0px','height':'0'},300);
});

$("#most-recent-product").mouseenter(function(){
	$(this).stop().animate({'width':'364px'},300);
	$(this).children(".mrp-arrow").animate({'width':'25px'},300);
	$("#mrp-container").stop().animate({'right':'50px'},300);

	$("#most-visited-product").stop().animate({'width':'264px'},300);
}).mouseleave(function(){
	$(this).stop().animate({'width':'314px'},300);
	$(this).children(".mrp-arrow").animate({'width':'0px'},300);
	$("#mrp-container").stop().animate({'right':'25px'},300);

	$("#most-visited-product").stop().animate({'width':'314px'},300);
});

$(".mrp-item").mouseenter(function(){
	$(this).children("span").stop().css({'height':'auto'}).animate({'padding':'10px 0 20px'},300);
}).mouseleave(function(){
	$(this).children("span").stop().animate({'padding':'0px','height':'0'},300);
});

$(document).ready(function(){
	window.document.title = "<?php echo $sitetitle." | "; ?>Startseite";
	mvpSlider = $("#mvp-slider").bxSlider({
    	displaySlideQty: 1,
        moveSlideQty: 1,
        infiniteLoop: true,
		controls: false,
		speed: 500,
		pause: 5000,
		auto: true,
		autoHover: true
	});
	
	$('#mvp-go-prev').click(function(){
		mvpSlider.goToPreviousSlide(false);
	    return false;
	});

	$('#mvp-go-next').click(function(){
		mvpSlider.goToNextSlide(false);
		return false;
	});

	mrpSlider = $("#mrp-slider").bxSlider({
    	displaySlideQty: 1,
        moveSlideQty: 1,
        infiniteLoop: true,
		controls: false,
		speed: 500,
		pause: 5000,
		auto: true,
		autoHover: true
	});
	
	$('#mrp-go-prev').click(function(){
		mrpSlider.goToPreviousSlide(false);
	    return false;
	});

	$('#mrp-go-next').click(function(){
		mrpSlider.goToNextSlide(false);
		return false;
	});

	$('#most-recent-news .mrn-scroll').slimScroll({
	      wheelStep: 20,
	      height:'320px',
	      position: 'right'
	  });
});
</script>