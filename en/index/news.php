<?php
include 'database.php';
if($_GET["show"] == '1')
{
	$id = $_GET["id"];
	$query = mysql_query("UPDATE newsbykk_".$sitelang." SET visitcounter = visitcounter + 1 WHERE id = '$id' ;", $db);
	if($isAdmin)
		$query = mysql_query("SELECT * FROM newsbykk_".$sitelang." WHERE state = 1 AND id = '$id' ORDER BY id  DESC ;", $db);
	else
		$query = mysql_query("SELECT * FROM newsbykk_".$sitelang." WHERE state = 1 AND showto <= '$level' AND showto > 0 AND id = '$id' ORDER BY id  DESC ;", $db);
	
	if($nrow=mysql_fetch_row($query))
	{
	?>
	<span id="close-news">
	</span>
	<div class="container" >
		<?php 
		if($nrow[4] != '')
		{
			$x = explode("|",$nrow[4]);
			$original_aspect = $x[1] / $x[2];
			$height = 300 / $original_aspect;
		?>
		<img src="<?php echo $x[0]; ?>" class="show-news-img" width="300" height="<?php echo $height; ?>">
		<?php 
		}
		?>
		<h3 class="show-news-title" ><?php echo $nrow[2]; ?></h3>
		<?php 
		$f = fopen("../".$nrow[6], "r");
		if($f===false)
			die("'".$nrow[6]."' doesn't exist.");
		else
			while(!feof($f))
			{
				$buf = fgets($f , 4096);
				$buf = htmlspecialchars_decode($buf, ENT_QUOTES);
				echo $buf;
			}
		if($nrow[7] != '')
		{
		?>
		<div class="news-attachment" ><img src="../images/attachment.png"><a href="<?php echo $nrow[7];?>" class="download" target="_blank">Attachment</a></div><br>
		<?php 
		}
		
		$linkto_lang = explode("|", $nrow[8]);
		$linkto = $linkto_lang[1];
		$linkto_lang = $linkto_lang[0];
		if($linkto != '0')
		{
			echo '<div class="news-attachment" ><img src="../images/attachment.png" />';
			pnlink($sitelang, $linkto_lang, $linkto, $nrow[9], $nrow[10], $db,'news');
			echo '</div>';
		}
		
		$linkto_lang = explode("|", $nrow[11]);
		$linkto = $linkto_lang[1];
		$linkto_lang = $linkto_lang[0];
		if($linkto != '0')
		{
			echo '<div class="news-attachment" ><img src="../images/attachment.png" />';
			pnlink($sitelang, $linkto_lang, $linkto, $nrow[12], $nrow[13], $db,'news');
			echo '</div';
		}
		
		?>
	</div>
	<script type="text/javascript">
	$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=news&id=<?php echo $id; ?>', function() {
		$("#page-nav").animate({'opacity':'1'}, 300);
		});
	<?php 
	if($isAdmin)
	{
	?>
	$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
			"<div class='btn add' onclick='addNews();' title='Add news/article' ></div><div class='btn change' onclick='editNews(<?php echo $nrow[0]; ?>);' title='Edit news/article' ></div><div class='btn delete' onclick='deleteNews(<?php echo $nrow[0]; ?>);' title='Delete news/article' ></div>"
			).animate({'opacity':'1'},300);
	<?php 
	}
	?>
	$("#close-news").click(function(){
		if($("#news-index").hasClass("open"))
		{
			$("#news-index").removeClass("open");
			$("#news-index").stop().animate({'height':'0'},300,function(){
				$("#news-index").css({'height':'auto','display':'none'});
				$("#news-index").addClass("close");
			});
			$("#news-overlay").stop().animate({'opacity':'0'},300,function(){
				$("#news-overlay").css({'opacity':'1','display':'none'});
			});
			$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
				"<div class='btn add' onclick='addNews();' title='Add news/article' ></div>"
				).animate({'opacity':'1'},300);
			clearInterval(checkNewsScrollUpLoop);
		}
	});

	var newsScrollTop = 0;
	function checkNewsScrollUp()
	{
		var nScrollTop =  $(document).scrollTop(), indexHeight = $("#news-index").height() - $(window).height() + 50;
		if(indexHeight<0) indexHeight = 0;
		if(newsScrollTop == nScrollTop && (nScrollTop < 100 || nScrollTop > (130 + indexHeight)))
		{
			if(indexHeight == 0)
				$("html, body").animate({ scrollTop: "118px" },200);
			else
			{
				if(nScrollTop < 100)
					$("html, body").animate({ scrollTop: "118px" },200);
				else
					$("html, body").animate({ scrollTop: (118 + indexHeight)+"px" },200);
			}
		}
		newsScrollTop = nScrollTop;
	}
	checkNewsScrollUpLoop = setInterval(checkNewsScrollUp, 1000);
	</script>
	<?php
	}
}
else 
{
?>
<?php 
	if($isAdmin)
	{
	?>
	<div id="delete_dialogN" title="Delete News" style="display: none;">
	<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are You Sure?
	</div>
	<?php 
	}
?>
<script>
$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=news', function() {
	$("#page-nav").animate({'opacity':'1'}, 300);
	});
<?php 
if($isAdmin)
{
?>
var deleteNID=0;
function addNews()
{
	gotoPage('full',500,'index/addnews.php');
}
function deleteNews(nid)
{
	deleteNID = nid;
	$("#delete_dialogN").dialog("open");
}
function editNews(id) 
{
	gotoPage('full',500,'index/addnews.php?mode=edit&id='+id);
	try
	{
		clearInterval(checkNewsScrollUpLoop);
	}
	catch(e)
	{
		console.log(e);
	}
}
$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
"<div class='btn add' onclick='addNews();' title='Add news/article' ></div>"
).animate({'opacity':'1'},300);
$(function() {
	$("#delete_dialogN").dialog({
		autoOpen: false,
		resizable: false,
		height:120,
		modal: true,
		buttons: {
			"Yes": function() {
				$.get('index/addnews.php?mode=delete&id='+deleteNID,function()
				{
					gotoPage('full',500,'index/news.php');
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
</script>
<div style="opacity:0;width: 100%;height: 100%;" id="index-loader">
	<div id="news-index" class="close" >
		<div class="primary" >
			<div class="secondary" >
				
			</div>
		</div>
	</div>
	<div id="news-items">
		<div class="container" id="news-container">
		<?php 
		$first = true;
		if($isAdmin)
			$query = mysql_query("SELECT id, category, name, summary, picture, picture_thumb, date, time, visitcounter FROM newsbykk_".$sitelang." WHERE state = 1 ORDER BY id  DESC ;", $db);
		else
			$query = mysql_query("SELECT id, category, name, summary, picture, picture_thumb, date, time FROM newsbykk_".$sitelang." WHERE state = 1 AND showto <= '$level' AND showto > 0 ORDER BY id  DESC ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		
		while($rows=mysql_fetch_row($query))
		{
			if($first)
			{
				$first = false;
		?>
			<div class="n-item big" id="_<?php echo $rows[0]; ?>">
				<?php 
				if($isAdmin)
				{
				?>
				<div class="control-container">
					<div class="btn delete" onclick="deleteNews(<?php echo $rows[0]; ?>);"></div>
					<div class="btn edit" onclick="editNews(<?php echo $rows[0]; ?>);"></div>
					<div class="visit-counter" >Visit: <?php echo $rows[8]; ?></div>
				</div>
				<?php 
				}
				?>
				<div class="n-inner" >
					<div style="padding: 3px 5px 5px 5px;position: absolute;top:2px;right: 2px;background-color: #eee;border-bottom-left-radius:5px;text-align: center;font-size: 12px;"><?php echo $rows[1]; ?></div>
					<?php 
					if($rows[4] != '')
					{
					?>
					<div class="img" ><img src="<?php $x = explode("|",$rows[4]);  echo $x[0];?>" onclick="showNews(<?php echo $rows[0]; ?>)" style="width: 100%;"></div>
					<?php 
					}
					?>
					<div class="n-text" >
					<h2 ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/news.php?ntoshow=".$rows[0]); ?>" onclick="showNews(<?php echo $rows[0]; ?>)"><?php echo $rows[2];?></a></h2>
					<?php echo $rows[3];?>
					</div>
				</div>
			</div>
		<?php
			}
			else
			{
		?>
			<div class="n-item small" id="_<?php echo $rows[0]; ?>">
				<?php 
				if($isAdmin)
				{
				?>
				<div class="control-container">
					<div class="btn delete" onclick="deleteNews(<?php echo $rows[0]; ?>);"></div>
					<div class="btn edit" onclick="editNews(<?php echo $rows[0]; ?>);"></div>
					<div class="visit-counter" >Visit: <?php echo $rows[8]; ?></div>
				</div>
				<?php 
				}
				?>
				<div class="n-inner" >
					<div style="padding: 3px 5px 5px 5px;position: absolute;top:2px;right: 2px;background-color: #eee;border-bottom-left-radius:5px;text-align: center;font-size: 12px;"><?php echo $rows[1]; ?></div>
					<?php 
					if($rows[5] != '')
					{
					?>
					<div class="img" ><img src="<?php echo $rows[5];?>" onclick="showNews(<?php echo $rows[0]; ?>)" style="width: 100%;"></div>
					<?php 
					}
					?>
					<div class="n-text" >
					<h2 ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/news.php?ntoshow=".$rows[0]); ?>" onclick="showNews(<?php echo $rows[0]; ?>)"><?php echo $rows[2];?></a></h2>
					<?php echo $rows[3];?>
					</div>
				</div>
			</div>
		<?php
			}
		}
		?>
		</div>
	</div>
	<script>
	var isInsideNewsIndex = false;
	var newsCount, newsToSet = 2, tryNCount = 0;
	var newsDiv = new Array(200);
	var newsItemImgLoaded = {};
	var tryStartSetNewsItemPosition;
	for (var i = 0; i < 200; i++) {
		newsDiv[i] = new Array(6);
		newsDiv[i][4] = false;
		newsDiv[i][5] = false;
	}
	// newsDiv[id,top,height,coll,checked-for-min,filled] = {integer, double, double, integer (0~3), boolean (false~true), boolean (false~true)}

	
	function getMinBottom(startD,endD)
	{
		var minBottomDiv = 100000, collDiv = 0, newsDivNum = 0;
		if(endD<4)
		{
			return {bottom: 0, coll:endD};
		}
		else
		{
			for(var i = startD; i < endD; i++)
			{
				if((newsDiv[i][1] + newsDiv[i][2]) < minBottomDiv && newsDiv[i][4] == false)
				{
					minBottomDiv = (newsDiv[i][1] + newsDiv[i][2]);
					collDiv = newsDiv[i][3];
					newsDivNum = i;
				}
			}
			newsDiv[newsDivNum][4] = true;
			return {bottom:minBottomDiv, coll:collDiv};
		}
	}

	
	function SetNewsItemPosition()
	{
		// first big item
		$("#news-items .container .n-item").eq(0);
		newsDiv[0][0] = newsDiv[1][0] = $("#news-items .container .n-item").eq(0).attr("id").substr(1);
		newsDiv[0][1] = newsDiv[1][1] = 10;
		newsDiv[0][2] = newsDiv[1][2] = $("#news-items .container .n-item").eq(0).height();
		newsDiv[0][3] = 0;
		newsDiv[0][5] = newsDiv[1][5] = true;

		newsDiv[1][3] = 1;
		
		$("#news-items .container .n-item").eq(0).children(".n-inner").css({'opacity':'0'});
		$("#news-items .container .n-item").eq(0).css({'opacity':'1','display':'block','height':'0px','top':(10 + (newsDiv[0][2]/2))+'px','width':'0px','left':(10 + (232/2))+'px'})
			.delay(150).animate({'height':newsDiv[0][2]+'px','top':10+'px','width':464+'px','left':10+'px'},300,'easeOutCirc',function(){
			$(this).children(".n-inner").animate({'opacity':'1'},500);
		});
		//
		
		
		for(var i = newsToSet; i < newsCount + 1; i++)
		{
			var posDiv = getMinBottom(0, i);
	
			var topDiv = 0, heightDiv, leftDiv, widthDiv = 227;
			var objectDiv = $("#news-items .container .n-item").eq(i-1);
			
			topDiv = posDiv.bottom + 10;
			heightDiv = objectDiv.height();
			leftDiv = (posDiv.coll * 237) + 10;
			newsDiv[i][0] = objectDiv.attr("id").substr(1);
			newsDiv[i][1] = topDiv;
			newsDiv[i][2] = heightDiv;
			newsDiv[i][3] = posDiv.coll;
			newsDiv[i][5] = true;
	
			objectDiv.children(".n-inner").css({'opacity':'0'});
			objectDiv.css({'opacity':'1','display':'block','height':'0px','top':(topDiv + (heightDiv/2))+'px','width':'0px','left':(leftDiv + (widthDiv/2))+'px'})
				.delay(i*150).animate({'height':heightDiv+'px','top':topDiv+'px','width':widthDiv+'px','left':leftDiv+'px'},300,'easeOutCirc',function(){
				$(this).children(".n-inner").animate({'opacity':'1'},500);
			});
			newsToSet = i+1;
		}

		var collHeight = [0,0,0,0];
		for(var i = 0; i < 200; i++)
		{
			if(newsDiv[i][3] == 0)
				collHeight[0] = collHeight[0] + (newsDiv[i][2] + 10);
			else if(newsDiv[i][3] == 1)
				collHeight[1] = collHeight[1] + (newsDiv[i][2] + 10);
			else if(newsDiv[i][3] == 2)
				collHeight[2] = collHeight[2] + (newsDiv[i][2] + 10);
			else if(newsDiv[i][3] == 3)
				collHeight[3] = collHeight[3] + (newsDiv[i][2] + 10);
		}
		var maxContainerHeight = 0;
		for(var i = 0; i < 4; i++)
		{
			if(collHeight[i] > maxContainerHeight)
				maxContainerHeight = collHeight[i];
		}
		if(maxContainerHeight < 600) maxContainerHeight = 600;
		$("#news-items .container").animate({'height':(maxContainerHeight)+'px'},300);
	}


	function trySetNewsItemPosition(index){
		var count = 0;
		tryNCount++;
		for (e in newsItemImgLoaded){count++;}
		if(count == 0 || tryNCount > 200){
			clearInterval(tryStartSetNewsItemPosition);
			progressBar(300,100);
			SetNewsItemPosition();
		}
	}

	function showNews(id){
		if($("#news-index").hasClass("close"))
		{
			progressBar(300,50);
			$("#news-index .primary .secondary").load('index/news.php?show=1&id='+id,function(){
				var newsIndexHeight = $("#news-index").height();
				$("#news-index").removeClass("close");
				$("#news-index").stop().css({'height':'0px','display':'block'}).animate({'height':newsIndexHeight+'px'},300,function(){
					$("#news-index").addClass("open");
					$("html, body").animate({ scrollTop: "118px" },200);
				});
				$("#news-overlay").stop().css({'opacity':'0.1','display':'block'}).animate({'opacity':'1'},300);
				progressBar(300,100);
			});
		}
	}

	$(document).ready(function(){
		var newsPercentage = 0;
		newsCount = $("#news-items .container .n-item").length;
		
		// check if news item images loaded
		var newsItemImg_load = '#news-items .container .n-item .n-inner .img img';
		jQuery(newsItemImg_load).each(function(index){
			newsItemImgLoaded[index] = true;
			jQuery(this).load(function(){
				delete newsItemImgLoaded[index];
				newsPercentage = newsPercentage + (100/newsCount);
				progressBar(300,newsPercentage);
			});
			if (this.complete) jQuery(this).trigger("load");
		});

		tryStartSetNewsItemPosition = setInterval(trySetNewsItemPosition, 50);

		$("#news-index, #controlpanel_container").mouseenter(function(){
			isInsideNewsIndex = true;
		}).mouseover(function(){
			isInsideNewsIndex = true;
		}).mouseleave(function(){
			isInsideNewsIndex = false;
		});

		<?php 
		if(isset($_GET["ntoshow"]))
		{
			$toShow = $_GET["ntoshow"];
			?>
			setTimeout(function(){
			showNews(<?php echo $toShow; ?>);
			},1000);
			<?php
		}
		?>
				
		$(document).click(function() {
			if(!isInsideNewsIndex && $("#news-index").hasClass("open"))
			{
				$("#news-index").removeClass("open");
				$("#news-index").stop().animate({'height':'0'},300,function(){
					$("#news-index").css({'height':'auto','display':'none'});
					$("#news-index").addClass("close");
				});
				$("#news-overlay").stop().animate({'opacity':'0'},300,function(){
					$("#news-overlay").css({'opacity':'1','display':'none'});
				});
				$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
					"<div class='btn add' onclick='addNews();' title='Add news/article' ></div>"
					).animate({'opacity':'1'},300);
				clearInterval(checkNewsScrollUpLoop);
			}
		});
	});
	
	</script>
</div>
<?php 
}
?>