<?php
include 'database.php';
if($_GET["show"] == '1')
{
	$album = $_GET["album"];
	$query = mysql_query("UPDATE gallerybykk_".$sitelang." SET visitcounter = visitcounter + 1 WHERE album = '$album' ;", $db);
?>
	<span id="close-album"></span>
	<span class="g-title"><?php echo getCategory($album);?></span>
	<div id="album-image-container" class="gad-gallery" style="position: absolute;top:10px;left:10px;right: 10px;bottom:10px;">
		<div class="gad-image-wrapper" >
		</div>
	    <div class="gad-nav">
			        <div class="gad-thumbs">
			        <ul class="gad-thumb-list">
			        <?php 
			        if($isAdmin)
			        	$query = mysql_query("SELECT * FROM gallerybykk_".$sitelang." WHERE state = 1 AND album = '$album' ORDER BY id DESC;", $db);
			        else
			        	$query = mysql_query("SELECT * FROM gallerybykk_".$sitelang." WHERE state = 1 AND showto <= '$level' AND showto > 0 AND album = '$album'  ORDER BY id DESC ;", $db);
			        if (!$query)
			        	die("Error reading query: ".mysql_error());
			        
			        while($grows=mysql_fetch_row($query))
			        {
			        ?>
			        <!-- title="<?php echo getCategory($grows[1]); ?>"  -->
			         	<li>
			              <a href="<?php echo $grows[5]; ?>">
			                <img src="<?php echo $grows[7]; ?>"  alt="<?php echo $grows[8]; ?>" img-id="<?php echo $grows[0]; ?>" >
			              </a>
			            </li>
			        <?php 
			        }
			        ?>
		            </ul>
	            </div>
            </div>
			</div>
			<div id="album-tubnail">
			</div>
		<script>
		$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=gallery&id=<?php echo encodeURIComponent($album); ?>', function() {
			$("#page-nav").animate({'opacity':'1'}, 300);
			});
		<?php 
		if($isAdmin)
		{
		?>
		$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
			"<div class='btn add' onclick='addGallery();' title='Add image/gallery' ></div><div class='btn change' onclick=editAlbum('<?php echo $album; ?>'); title='Edit album' ></div><div class='btn delete' onclick=deleteThisAlbum('<?php echo $album; ?>'); title='Delete whole album!' ></div>"
			).animate({'opacity':'1'},300);
		<?php 
		}
		?>
		var albumIndexHeightB = $(window).height()-40;
		$(".gad-image-wrapper").animate({'height':(albumIndexHeightB-136)+'px'},50,function(){
			$('#album-image-container').gadGallery({
				showGalleryControl: true
			});
		});
		$("#close-album").click(function(){
			if($("#album-index").hasClass("open"))
			{
				$("#album-index").removeClass("open");
				$("#album-index").animate({'height':'0'},300,function(){
					$(this).css({'display':'none'});
					$("#album-index").addClass("close");
				});
				$("#product-overlay").stop().animate({'opacity':'0'},300,function(){
					$("#product-overlay").css({'opacity':'1','display':'none'});
				});
				clearInterval(checkGalleryScrollUpLoop);
			}
		});
		$(window).resize(function(){
			albumIndexHeightB = $(window).height()-40;
			//alert(albumIndexHeight);
			$("#album-index").css({'height':albumIndexHeightB+'px'});
			$("html, body").animate({ scrollTop: "118px" },200);

			$(".gad-image-wrapper").animate({'height':(albumIndexHeightB-136)+'px'},50,function(){
			});
		});
		var GalleryScrollTop = 0;
		function checkGalleryScrollUp()
		{
			var GScrollTop =  $(document).scrollTop();
			if(GalleryScrollTop == GScrollTop && (GScrollTop < 100 || GScrollTop > 130))
			{
				$("html, body").animate({ scrollTop: "118px" },200);
			}
			GalleryScrollTop = GScrollTop;
		}
		checkGalleryScrollUpLoop = setInterval(checkGalleryScrollUp, 1000);
		</script>
<?php
}
else 
{
?>
<?php 
	if($isAdmin)
	{
	?>
	<div id="delete_dialogG" title="Delete Image" style="display: none;">
	<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are You Sure?
	</div>
	<div id="delete_dialogA" title="Delete Album" style="display: none;">
	<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are You Sure?
	</div>
	<?php 
	}
?>
<script>
$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=gallery', function() {
	$("#page-nav").animate({'opacity':'1'}, 300);
	});
<?php 
if($isAdmin)
{
?>
var deleteGID=0, deleteAlbum='';
function addGallery()
{
	gotoPage('full',500,'index/addgallery.php');
}
function deleteGallery(gid)
{
	deleteGID = gid;
	$("#delete_dialogG").dialog("open");
}
function deleteThisAlbum(album)
{
	deleteAlbum = encodeURIComponent(album);
	$("#delete_dialogA").dialog("open");
}
function editGallery(id) 
{
	gotoPage('full',500,'index/addgallery.php?mode=edit_gallery&id='+id);
	try
	{
		clearInterval(checkGalleryScrollUpLoop);
	}
	catch(e)
	{
	  console.log(e);
	}
}
function editAlbum(album) 
{
	gotoPage('full',500,'index/addgallery.php?mode=edit_album&album='+encodeURIComponent(album));
	try
	{
		clearInterval(checkGalleryScrollUpLoop);
	}
	catch(e)
	{
	  console.log(e);
	}
}
$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
	"<div class='btn add' onclick='addGallery();' title='Add image/gallery' ></div>"
	).animate({'opacity':'1'},300);
$(function() {
	$("#delete_dialogG").dialog({
		autoOpen: false,
		resizable: false,
		height:120,
		modal: true,
		buttons: {
			"Yes": function() {
				$.get('index/addgallery.php?mode=delete_gallery&id='+deleteGID,function()
				{
					gotoPage('full',500,'index/gallery.php');
				});
				$( this ).dialog( "close" );
			},
			"Cancel": function() {
				$( this ).dialog( "close" );
			}
		}
	});
});
$(function() {
	$("#delete_dialogA").dialog({
		autoOpen: false,
		resizable: false,
		height:120,
		modal: true,
		buttons: {
			"Yes": function() {
				$.get('index/addgallery.php?mode=delete_album&album='+deleteAlbum,function()
				{
					gotoPage('full',500,'index/gallery.php');
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
function showAlbum(album)
{
	if($("#album-index").hasClass("close") && !isInsideControl)
	{
		$("#album-index").removeClass("close");
		$("#album-index .inner").load('index/gallery.php?show=1&album='+encodeURIComponent(album),function(){
			var productIndexHeight = $(window).height()-40;
			$("#album-index").removeClass("close");
			$("#album-index").stop().css({'height':'0px','display':'block'}).animate({'height':productIndexHeight+'px'},300,function(){
				$("#product-index").addClass("open");
				$("html, body").animate({ scrollTop: "118px" },200);
				$("#album-index").addClass("open");
			});
			$("#product-overlay").stop().css({'opacity':'0.1','display':'block'}).animate({'opacity':'1'},300);
		});
	}
}
</script>
<div style="opacity:0;width: 100%;height: 100%;" id="index-loader">
	<div style="width: 100%;display: none;" id="album-index" class="close">
		<div class="inner" >
		</div>
	</div>
	<div id="gallery-item-container">
		<?php 
	    if($isAdmin)
	    	$query = mysql_query("SELECT id, album, cover1, cover2, cover3, picture_cover, visitcounter FROM gallerybykk_".$sitelang." WHERE state = 1 ORDER BY album ASC , id DESC;", $db);
	    else
	    	$query = mysql_query("SELECT id, album, cover1, cover2, cover3, picture_cover FROM gallerybykk_".$sitelang." WHERE state = 1 AND showto <= '$level' AND showto > 0  ORDER BY album ASC , id DESC ;", $db);
	    if (!$query)
	    	die("Error reading query: ".mysql_error());
	    
	    $album = '';
	    while($grows=mysql_fetch_row($query))
	    {
	    	if($album != $grows[1])
	    	{
	    		$album = $grows[1];
		    	$cover1 = $cover2 = $cover3 = '';
		    	if($grows[2] == '')
		    		$cover1 = $grows[5];
		    	else
		    		$cover1 = $grows[2];
		    	
		    	if($grows[3] == '')
		    		$cover2 = $grows[5];
		    	else
		    		$cover2 = $grows[3];
		    	
		    	if($grows[4] == '')
		    		$cover3 = $grows[5];
		    	else
		    		$cover3 = $grows[4];
	    	?>
			<div class="g-item">
				<div class="album-item" onclick="showAlbum('<?php echo $grows[1]; ?>');" deg1="<?php $x = rand(-100, 100)/10; if( $x >= 0 && $x < 3) $x= 3; if( $x < 0 && $x > -3) $x= -3; echo $x; ?>" deg2="<?php $x = rand(-100, 100)/10; if( $x >= 0 && $x < 4) $x= 4; if( $x < 0 && $x > -4) $x= -4; echo $x; ?>">
					<?php 
					if($isAdmin)
					{
					?>
					<div class="control-container">
						<div class="btn delete" onclick="deleteThisAlbum('<?php echo $grows[1]; ?>');"></div>
						<div class="btn edit" onclick="editAlbum('<?php echo $grows[1]; ?>');"></div>
						<div class="visit-counter" >Visit: <?php echo $grows[6]; ?></div>
					</div>
					<?php 
					}
					?>
					<div class="inner" >
						<img alt="<?php echo getCategory($grows[1]); ?>" src="<?php echo $cover1; ?>" >
						<span ><?php echo getCategory($grows[1]); ?></span>
					</div>
				</div>
				<div class="album-item2" >
					<div class="inner" >
						<img alt="<?php echo getCategory($grows[1]); ?>" src="<?php echo $cover2; ?>" >
					</div>
				</div>
				<div class="album-item3" >
					<div class="inner" >
						<img alt="<?php echo getCategory($grows[1]); ?>" src="<?php echo $cover3; ?>" >
					</div>
				</div>
			</div>
			<?php 
	    	}
	    }
		?>
	</div>
	<script>
	function setGalleryImg(object,destObject,width,height)
	{
		var imgHeight, imgWidth, imgRaito, ratio = height/width;
		var marginH=0, marginV=0,newWidth=0,newHeight=0;
		$(object).each(function(index){
			imgHeight = this.height;
			imgWidth = this.width;
			imgRaito = imgHeight / imgWidth;
			if(imgRaito >= ratio)
			{
				marginV = 0;
				marginH = width - (height/imgRaito);
				newWidth = (height/imgRaito);
				if(marginH != 0)
					marginH = marginH/2;
				else
					marginH = 0;
				$(this).css({'height':height+'px','opacity':'1'});
				$(this).parent(".inner").css({'height':height+'px','width':newWidth+'px'});
				$(this).parent(".inner").parent(destObject).css({'margin':marginV+'px '+marginH+'px','height':height+'px','width':newWidth+'px','opacity':'1'});
			}
			else
			{
				marginV = height - (width*imgRaito);
				marginH = 0;
				newHeight = (width*imgRaito);
				if(marginV != 0)
					marginV = marginV/2;
				else
					marginV = 0;
				$(this).css({'width':width+'px','opacity':'1'});
				$(this).parent(".inner").css({'height':newHeight+'px','width':width+'px'});
				$(this).parent(".inner").parent(destObject).css({'margin':marginV+'px '+marginH+'px','height':newHeight+'px','width':width+'px','opacity':'1'});
			}
		});
	}
	
	$(document).ready(function(){
		jQuery(".g-item .album-item .inner img").each(function(index){
			jQuery(this).load(function(){
				setGalleryImg(this,".album-item",303,210);
			});
			if (this.complete) jQuery(this).trigger("load");
		});
		
		jQuery(".g-item .album-item2 .inner img").each(function(index){
			jQuery(this).load(function(){
				setGalleryImg(this,".album-item2",303,210);
			});
			if (this.complete) jQuery(this).trigger("load");
		});

		jQuery(".g-item .album-item3 .inner img").each(function(index){
			jQuery(this).load(function(){
				setGalleryImg(this,".album-item3",303,210);
			});
			if (this.complete) jQuery(this).trigger("load");
		});

		$(".g-item .album-item .inner").mouseenter(function(){
			$(this).children("span").stop().animate({'padding':'5px 0','height':'20px'},300);
		}).mouseleave(function(){
			$(this).children("span").stop().animate({'padding':'0px','height':'0'},300);
		});

		$(".album-item").mouseenter(function(){
			//$(this).stop();
			var elem = $(this), elem1 = $(this).parent("div").children(".album-item3"), elem2 = $(this).parent("div").children(".album-item2");
			//elem.parent("div").animate({'width':'320px','height':'220px;','margin':'-5px 0 0 -5px'},300);
			elem.css({'z-index':'70006'});
			elem1.css({'z-index':'70004'});
			elem2.css({'z-index':'70005'});
			var randDeg1 = $(this).attr("deg1"), randDeg2 = $(this).attr("deg2");
	        $({deg: 0}).stop().animate({deg: randDeg1}, {
	            duration: 300,
	            step: function(now){
	                elem1.css({
	                  '-moz-transform':'rotate('+now+'deg)',
	                  '-webkit-transform':'rotate('+now+'deg)',
	                  '-o-transform':'rotate('+now+'deg)',
	                  '-ms-transform':'rotate('+now+'deg)',
	                  'transform':'rotate('+now+'deg)'
	                });
	            }
	        });
	        $({deg2: 0}).stop().animate({deg2: randDeg2}, {
	            duration: 300,
	            step: function(now){
	                elem2.css({
	                  '-moz-transform':'rotate('+now+'deg)',
	                  '-webkit-transform':'rotate('+now+'deg)',
	                  '-o-transform':'rotate('+now+'deg)',
	                  '-ms-transform':'rotate('+now+'deg)',
	                  'transform':'rotate('+now+'deg)'
	                });
	            }
	        });
		}).mouseleave(function(){
			var elem = $(this), elem1 = $(this).parent("div").children(".album-item3"), elem2 = $(this).parent("div").children(".album-item2");
			elem.css({'z-index':'70003'});
			elem1.css({'z-index':'70001'});
			elem2.css({'z-index':'70002'});
			var randDeg1 = $(this).attr("deg1"), randDeg2 = $(this).attr("deg2");
	        $({deg: randDeg1}).stop().animate({deg: 0}, {
	            duration: 300,
	            step: function(now){
	                elem1.css({
	                  '-moz-transform':'rotate('+now+'deg)',
	                  '-webkit-transform':'rotate('+now+'deg)',
	                  '-o-transform':'rotate('+now+'deg)',
	                  '-ms-transform':'rotate('+now+'deg)',
	                  'transform':'rotate('+now+'deg)'
	                });
	            }
	        });
	        $({deg2: randDeg2}).stop().animate({deg2: 0}, {
	            duration: 300,
	            step: function(now){
	                elem2.css({
	                  '-moz-transform':'rotate('+now+'deg)',
	                  '-webkit-transform':'rotate('+now+'deg)',
	                  '-o-transform':'rotate('+now+'deg)',
	                  '-ms-transform':'rotate('+now+'deg)',
	                  'transform':'rotate('+now+'deg)'
	                });
	            }
	        });
		});

		<?php 
		if(isset($_GET["gtoshow"]))
		{
			$toShow = $_GET["gtoshow"];
			?>
			setTimeout(function(){
				showAlbum('<?php echo $toShow; ?>');
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