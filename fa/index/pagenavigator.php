<?php
include 'database.php';
include 'jdf.php';
function visiting($pname,$db,$sitelang='fa')
{
	$date = jdate('F Y');
	
	$do = "p".$pname;
	$query = mysql_query("SELECT date FROM visitbykk_".$sitelang." WHERE date='$date' ;", $db);
	if( $row=mysql_fetch_row($query) )
	{
		$query = mysql_query("SELECT ".$do." FROM visitbykk_".$sitelang." WHERE date='$date' ;", $db);
		$row=mysql_fetch_row($query);
		$add = $row[0] + 1;
		$query = mysql_query("UPDATE visitbykk_".$sitelang." SET ".$do." = '$add'  WHERE date='$date' ;", $db);
	}
	else
	{
		$query = mysql_query("SELECT id FROM visitbykk_".$sitelang." ORDER BY id DESC ;", $db);
		if( $rows=mysql_fetch_row($query) )
			$vid = $rows[0] + 1;
		else
			$vid = 1000;
		$sql = "INSERT INTO visitbykk_".$sitelang." ( id , date ) VALUES ('$vid' , '$date' );";
		$result = mysql_query($sql);
		$query = mysql_query("UPDATE visitbykk_".$sitelang." SET ".$do." = '1'  WHERE date='$date' ", $db);
		//echo "bigh";
		if(!$query)
			echo mysql_error();
	}
}
$page = $_GET["page"];
if($page == 'main')
{
	visiting('main', $db);
}
else if($page == 'product')
{
	visiting('product', $db);
	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
		$query = mysql_query("SELECT category, sub_category, name FROM productbykk_".$sitelang." WHERE state = 1 AND id = '$id' ;", $db);
		if($row = mysql_fetch_row($query))
		{
			?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/product.php"); ?>" onclick="gotoPage('full',500,'index/product.php');" >محصولات</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/product.php?category=".$row[0]."&sub_category=all"); ?>" onclick="gotoPage('full',500,'index/product.php?category=<?php echo encodeURIComponent($row[0]); ?>&sub_category=all');" ><?php echo getCategory($row[0]); ?></a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/product.php?category=".$row[0]."&sub_category=".$row[1]); ?>" onclick="gotoPage('full',500,'index/product.php?category=<?php echo encodeURIComponent($row[0]); ?>&sub_category=<?php echo encodeURIComponent($row[1]); ?>');" ><?php echo getCategory($row[1]); ?></a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/product.php?category=".$row[0]."&sub_category=".$row[1]."&ptoshow=".$id); ?>" onclick="gotoPage('full',500,'index/product.php?category=<?php echo encodeURIComponent($row[0]); ?>&sub_category=<?php echo encodeURIComponent($row[1]); ?>&ptoshow=<?php echo $id; ?>');" ><?php echo $row[2]; ?></a></span>
		<script>
		window.document.title= "<?php echo $sitetitle." | ".$row[2]; ?>";
		disableATag();
		</script>
		<?php
		}
	}
	else if(isset($_GET["category"]) || isset($_GET["sub_category"]))
	{
		$category = $_GET["category"];
		$sub_category = $_GET["sub_category"];
		?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/product.php"); ?>" onclick="gotoPage('full',500,'index/product.php');" >محصولات</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/product.php?category=".$category."&sub_category=all"); ?>" onclick="gotoPage('full',500,'index/product.php?category=<?php echo encodeURIComponent($category); ?>&sub_category=all');" ><?php echo getCategory($category); ?></a></span>
			<?php 
			if(isset($_GET["sub_category"]) && $sub_category != 'all')
			{
			?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/product.php?category=".$category."&sub_category=".$sub_category); ?>" onclick="gotoPage('full',500,'index/product.php?category=<?php echo encodeURIComponent($category); ?>&sub_category=<?php echo encodeURIComponent($sub_category); ?>');" ><?php echo getCategory($sub_category); ?></a></span>
			<?php
			}
			?>
		<script>
		window.document.title= "<?php echo $sitetitle." | "; ?>محصولات";
		disableATag();
		</script>
		<?php
	}
	else
	{
		?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/product.php"); ?>" onclick="gotoPage('full',500,'index/product.php');" >محصولات</a></span>
		<script>
		window.document.title= "<?php echo $sitetitle." | "; ?>محصولات";
		disableATag();
		</script>
		<?php
				
	}
}
else if($page == 'news')
{
	visiting('news', $db);
	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
		$query = mysql_query("SELECT name FROM newsbykk_".$sitelang." WHERE state = 1 AND id = '$id' ;", $db);
		if($row = mysql_fetch_row($query))
		{
			?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/news.php"); ?>" onclick="gotoPage('full',500,'index/news.php');" >اخبار / مقاله</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/news.php?ntoshow=".$id); ?>" onclick="gotoPage('full',500,'index/news.php?ntoshow=<?php echo $id; ?>');" ><?php echo $row[0]; ?></a></span>
		<script>
		window.document.title= "<?php echo $sitetitle." | ".$row[0]; ?>";
		disableATag();
		</script>
		<?php
		}
	}
	else
	{
		?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/news.php"); ?>" onclick="gotoPage('full',500,'index/news.php');" >اخبار / مقاله</a></span>
		<script>
		window.document.title= "<?php echo $sitetitle." | "; ?>اخبار / مقاله";
		disableATag();
		</script>
		<?php
				
	}
}
else if($page == 'gallery')
{
	visiting('gallery', $db);
	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
		?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/gallery.php"); ?>" onclick="gotoPage('full',500,'index/gallery.php');" >گالری</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/gallery.php?gtoshow=".$id); ?>" onclick="gotoPage('full',500,'index/gallery.php?gtoshow=<?php echo $id; ?>');" ><?php echo getCategory($id); ?></a></span>
		<script>
		window.document.title= "<?php echo $sitetitle." | ".setCategory($id); ?>";
		disableATag();
		</script>
		<?php
	}
	else
	{
		?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/gallery.php"); ?>" onclick="gotoPage('full',500,'index/gallery.php');" >گالری</a></span>
		<script>
		window.document.title= "<?php echo $sitetitle." | "; ?>گالری";
		disableATag();
		</script>
		<?php
				
	}
}
else if($page == 'about')
{
	visiting('about', $db);
	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
		$query = mysql_query("SELECT name FROM aboutbykk_".$sitelang." WHERE state = 1 AND id = '$id' ;", $db);
		if($row = mysql_fetch_row($query))
		{
			?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/about.php"); ?>" onclick="gotoPage('full',500,'index/about.php');" >در باره ما</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/about.php?section_id=".$id); ?>" onclick="gotoPage('full',500,'index/about.php?section_id=<?php echo $id; ?>');" ><?php echo $row[0]; ?></a></span>
		<script>
		window.document.title= "<?php echo $sitetitle." | ".$row[0]; ?>";
		disableATag();
		</script>
		<?php
		}
	}
	else
	{
		?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/about.php"); ?>" onclick="gotoPage('full',500,'index/about.php');" >درباره ما</a></span>
		<script>
		window.document.title= "<?php echo $sitetitle." | "; ?>درباره ما";
		disableATag();
		</script>
		<?php
				
	}
}
else if($page == 'contact')
{
	visiting('contact', $db);
	?>
		<span class="pn-spacer" >&gt;</span>
		<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/contact.php"); ?>" onclick="gotoPage('full',500,'index/contact.php');" >تماس با ما</a></span>
	<script>
	window.document.title= "<?php echo $sitetitle." | "; ?>تماس با ما";
	disableATag();
	</script>
	<?php
}
else if($page == 'addproduct')
{
	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
		$query = mysql_query("SELECT name FROM productbykk_".$sitelang." WHERE state = 1 AND id = '$id' ;", $db);
		if($row = mysql_fetch_row($query))
		{
			?>
				<span class="pn-spacer" >&gt;</span>
				<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/controlpanel.php"); ?>" onclick="gotoPage('full',500,'index/controlpanel.php');" >کنترل پنل</a></span>
				<span class="pn-spacer" >&gt;</span>
				<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/addproduct.php?mode=edit&id=".$id); ?>" onclick="gotoPage('full',500,'index/addproduct.php?mode=edit&id=<?php echo $id; ?>');" >تغییر محصول: <?php echo $row[0]; ?></a></span>
			<script>
			window.document.title= "<?php echo $sitetitle." | "; ?>تغییر محصول: <?php echo $row[0]; ?>";
			disableATag();
			</script>
			<?php
		}
	}
	else
	{
		?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/controlpanel.php"); ?>" onclick="gotoPage('full',500,'index/controlpanel.php');" >کنترل پنل</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/addproduct.php"); ?>" onclick="gotoPage('full',500,'index/addproduct.php');" >افزودن محصول</a></span>
		<script>
		window.document.title= "<?php echo $sitetitle." | "; ?>افزودن محصول";
		disableATag();
		</script>
		<?php
	}
}
else if($page == 'addnews')
{
	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
		$query = mysql_query("SELECT name FROM newsbykk_".$sitelang." WHERE state = 1 AND id = '$id' ;", $db);
		if($row = mysql_fetch_row($query))
		{
			?>
				<span class="pn-spacer" >&gt;</span>
				<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/controlpanel.php"); ?>" onclick="gotoPage('full',500,'index/controlpanel.php');" >کنترل پنل</a></span>
				<span class="pn-spacer" >&gt;</span>
				<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/addnews.php?mode=edit&id=".$id); ?>" onclick="gotoPage('full',500,'index/addnews.php?mode=edit&id=<?php echo $id; ?>');" >تغییر اخبار/مقاله: <?php echo $row[0]; ?></a></span>
			<script>
			window.document.title= "<?php echo $sitetitle." | "; ?>تغییر اخبار/مقاله: <?php echo $row[0]; ?>";
			disableATag();
			</script>
			<?php
		}
	}
	else
	{
		?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/controlpanel.php"); ?>" onclick="gotoPage('full',500,'index/controlpanel.php');" >کنترل پنل</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/addnews.php"); ?>" onclick="gotoPage('full',500,'index/addnews.php');" >افزودن اخبار/مقاله</a></span>
		<script>
		window.document.title= "<?php echo $sitetitle." | "; ?>افزودن اخبار/مقاله";
		disableATag();
		</script>
		<?php
	}
}
else if($page == 'addgallery')
{
	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
		$query = mysql_query("SELECT album FROM gallerybykk_".$sitelang." WHERE state = 1 AND id = '$id' ;", $db);
		if($row = mysql_fetch_row($query))
		{
			?>
				<span class="pn-spacer" >&gt;</span>
				<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/controlpanel.php"); ?>" onclick="gotoPage('full',500,'index/controlpanel.php');" >کنترل پنل</a></span>
				<span class="pn-spacer" >&gt;</span>
				<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/addgallery.php?mode=edit_gallery&id=".$id); ?>" onclick="gotoPage('full',500,'index/addgallery.php?mode=edit_gallery&id=<?php echo $id; ?>');" >تغییر عکس/گالری: <?php echo getCategory($row[0]); ?></a></span>
			<script>
			window.document.title= "<?php echo $sitetitle." | "; ?>Edit Image: <?php echo getCategory($row[0]); ?>";
			disableATag();
			</script>
			<?php
		}
	}
	else if(isset($_GET["album"]))
	{
		$id = $_GET["album"];
		
		?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/controlpanel.php"); ?>" onclick="gotoPage('full',500,'index/controlpanel.php');" >کنترل پنل</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/addgallery.php?mode=edit_album&album=".$id); ?>" onclick="gotoPage('full',500,'index/addgallery.php?mode=edit_album&album=<?php echo $id; ?>');" >تغییر آلبوم: <?php echo getCategory($id); ?></a></span>
		<script>
		window.document.title= "<?php echo $sitetitle." | "; ?>تغییر آلبوم: <?php echo getCategory($id); ?>";
		disableATag();
		</script>
		<?php
	}
	else
	{
		?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/controlpanel.php"); ?>" onclick="gotoPage('full',500,'index/controlpanel.php');" >کنترل پنل</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/addgallery.php"); ?>" onclick="gotoPage('full',500,'index/addgallery.php');" >افرودن عکس/گالری</a></span>
		<script>
		window.document.title= "<?php echo $sitetitle." | "; ?>افرودن عکس/گالری";
		disableATag();
		</script>
		<?php
	}
}
else if($page == 'addslide')
{
	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
		?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/controlpanel.php"); ?>" onclick="gotoPage('full',500,'index/controlpanel.php');" >کنترل پنل</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/addslide.php"); ?>" onclick="gotoPage('full',500,'index/addslide.php');" >لیست اسلایدها</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/addslide.php?mode=edit&id=".$id); ?>" onclick="gotoPage('full',500,'index/addslide.php?mode=edit&id=<?php echo $id; ?>');" >تغییر اسلاید</a></span>
		<script>
		window.document.title= "<?php echo $sitetitle." | "; ?>تغییر اسلاید";
		disableATag();
		</script>
		<?php
	}
	else if($_GET["mode"] == 'add')
	{
		?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/controlpanel.php"); ?>" onclick="gotoPage('full',500,'index/controlpanel.php');" >کنترل پنل</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/addslide.php"); ?>" onclick="gotoPage('full',500,'index/addslide.php');" >لیست اسلایدها</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/addslide.php?mode=add"); ?>" onclick="gotoPage('full',500,'index/addslide.php?mode=add');" >افزودن اسلاید</a></span>
		<script>
		window.document.title= "<?php echo $sitetitle." | "; ?>افزودن اسلاید";
		disableATag();
		</script>
		<?php
	}
	else
	{
		?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/controlpanel.php"); ?>" onclick="gotoPage('full',500,'index/controlpanel.php');" >کنترل پنل</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/addslide.php"); ?>" onclick="gotoPage('full',500,'index/addslide.php');" >لیست اسلایدها</a></span>
		<script>
		window.document.title= "<?php echo $sitetitle." | "; ?>لیست اسلایدها";
		disableATag();
		</script>
		<?php
	}
}
else if($page == 'addform')
{
	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
		?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/controlpanel.php"); ?>" onclick="gotoPage('full',500,'index/controlpanel.php');" >کنترل پنل</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/addform.php"); ?>" onclick="gotoPage('full',500,'index/addform.php');" >لیست فرم ها</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/addform.php?mode=edit&id=".$id); ?>" onclick="gotoPage('full',500,'index/addform.php?mode=edit&id=<?php echo $id; ?>');" >تغییر فرم</a></span>
		<script>
		window.document.title= "<?php echo $sitetitle." | "; ?>تغییر فرم";
		</script>
		<?php
	}
	else if($_GET["mode"] == 'add')
	{
		?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/controlpanel.php"); ?>" onclick="gotoPage('full',500,'index/controlpanel.php');" >کنترل پنل</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/addform.php"); ?>" onclick="gotoPage('full',500,'index/addform.php');" >لیست فرم ها</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/addform.php?mode=add"); ?>" onclick="gotoPage('full',500,'index/addform.php?mode=add');" >افزودن فرم</a></span>
		<script>
		window.document.title= "<?php echo $sitetitle." | "; ?>افزودن فرم";
		</script>
		<?php
	}
	else
	{
		?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/controlpanel.php"); ?>" onclick="gotoPage('full',500,'index/controlpanel.php');" >کنترل پنل</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/addform.php"); ?>" onclick="gotoPage('full',500,'index/addform.php');" >لیست فرم ها</a></span>
		<script>
		window.document.title= "<?php echo $sitetitle." | "; ?>لیست فرم ها";
		</script>
		<?php
	}
}
else if($page == 'member')
{
	if(isset($_GET["id"]))
	{
		$id = $_GET["id"];
		$query = mysql_query("SELECT name FROM registerbykk WHERE state != 0 AND id = '$id' ;", $db);
		if($row = mysql_fetch_row($query))
		{
			?>
				<span class="pn-spacer" >&gt;</span>
				<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/controlpanel.php"); ?>" onclick="gotoPage('full',500,'index/controlpanel.php');" >کنترل پنل</a></span>
				<span class="pn-spacer" >&gt;</span>
				<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/member.php"); ?>" onclick="gotoPage('full',500,'index/member.php');" >اعضا</a></span>
				<span class="pn-spacer" >&gt;</span>
				<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/member.php?mode=edit&id=".$id); ?>" onclick="gotoPage('full',500,'index/member.php?mode=edit&id=<?php echo $id; ?>');" ><?php echo $row[0]; ?></a></span>
			<script>
			window.document.title= "<?php echo $sitetitle." | ".$row[0]; ?>";
			</script>
			<?php
		}
	}
	else
	{
		?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/controlpanel.php"); ?>" onclick="gotoPage('full',500,'index/controlpanel.php');" >کنترل پنل</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/member.php"); ?>" onclick="gotoPage('full',500,'index/member.php');" >اعضا</a></span>
		<script>
		window.document.title= "<?php echo $sitetitle." | "; ?>اعضا";
		</script>
		<?php
	}
}
else if($page == 'filledform')
{
	if(isset($_GET["id"]))
	{
		$form_id = $_GET["form_id"];
		$id = $_GET["id"];
		?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/controlpanel.php"); ?>" onclick="gotoPage('full',500,'index/controlpanel.php');" >کنترل پنل</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/filledforms.php"); ?>" onclick="gotoPage('full',500,'index/filledforms.php');" >لیست فرم های پر شده</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/filledforms.php?mode=change&form_id=".$form_id."&id=".$id); ?>" onclick="gotoPage('full',500,'index/filledforms.php?mode=change&form_id=<?php echo $form_id; ?>&id=<?php echo $id; ?>');" >تغییر فرم پر شده</a></span>
		<script>
		window.document.title= "<?php echo $sitetitle." | "; ?>تغییر فرم پر شده";
		</script>
		<?php
	}
	else
	{
		?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/controlpanel.php"); ?>" onclick="gotoPage('full',500,'index/controlpanel.php');" >کنترل پنل</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/filledforms.php"); ?>" onclick="gotoPage('full',500,'index/filledforms.php');" >لیست فرم های پر شده</a></span>
		<script>
		window.document.title= "<?php echo $sitetitle." | "; ?>لیست فرم های پر شده";
		</script>
		<?php
	}
}
else if($page == 'controlpanel')
{
	?>
		<span class="pn-spacer" >&gt;</span>
		<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/controlpanel.php"); ?>" onclick="gotoPage('full',500,'index/controlpanel.php');" >کنترل پنل</a></span>
	<script>
	window.document.title= "<?php echo $sitetitle." | "; ?>کنترل پنل";
	</script>
	<?php
}
else if($page == 'message')
{
	?>
		<span class="pn-spacer" >&gt;</span>
		<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/controlpanel.php"); ?>" onclick="gotoPage('full',500,'index/controlpanel.php');" >کنترل پنل</a></span>
		<span class="pn-spacer" >&gt;</span>
		<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/message.php"); ?>" onclick="gotoPage('full',500,'index/message.php');" >پیام</a></span>
	<script>
	window.document.title= "<?php echo $sitetitle." | "; ?>پیام";
	</script>
	<?php
}
else if($page == 'fillform')
{
	$id = $_GET["id"];
	$query = mysql_query("SELECT name FROM formbykk WHERE state = 1 AND id = '$id' ;", $db);
	if($row = mysql_fetch_row($query))
	{
		if($_GET["from"] == 'cp')
		{
			?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/controlpanel.php"); ?>" onclick="gotoPage('full',500,'index/controlpanel.php');" >کنترل پنل</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/filledforms.php"); ?>" onclick="gotoPage('full',500,'index/filledforms.php');" >لیست فرم های پر شده</a></span>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/fillform.php?from=cp&id=".$id); ?>" onclick="gotoPage('full',500,'index/fillform.php?from=cp&id=<?php echo $id; ?>');" >پیش نمایش: <?php echo $row[0]; ?></a></span>
		<script>
		window.document.title= "<?php echo $sitetitle." | ".$row[0]; ?>";
		</script>
		<?php
		}
		else
		{
			visiting('form', $db);
		?>
			<span class="pn-spacer" >&gt;</span>
			<span class="pn-item" ><a href="?cmode=full&command=<?php echo encodeURIComponent("index/fillform.php?id=".$id); ?>" onclick="gotoPage('full',500,'index/fillform.php?id=<?php echo $id; ?>');" ><?php echo $row[0]; ?></a></span>
		<script>
		window.document.title= "<?php echo $sitetitle." | ".$row[0]; ?>";
		</script>
		<?php
		}
	}
}
?>