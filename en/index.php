<?php
include 'database.php';
$sitelang = 'en';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Rahadarman</title>
		<meta name="Description" content="Rahadarman" />
		<meta name="Author" content="K_H1372@yahoo.com(+989352892554)" />
		<meta name="Copyright" content="http://rahadarmanmp.com" />
		<meta name="Keywords" content="rahadarman , rahadarmanmp <?php 
		$kwquery = mysql_query("SELECT name FROM productbykk_en WHERE state = 1 ORDER BY id  DESC ;", $db);
		if (!$kwquery)
			die("Error reading query: ".mysql_error());
		
		while( $kwrows=mysql_fetch_row($kwquery) )
		{
			echo " , ".$kwrows[0];
		}
		?>" />
		<link rel="shortcut icon" href="../images/favicon.ico" />
		<script type='text/javascript' src='../js/jquery-1.10.2.min.js'></script> 
		<script type='text/javascript' src='../js/jquery-migrate-1.2.0.min.js'></script>
		<script type='text/javascript' src='../js/jquery.easing.js'></script>
		<script type='text/javascript' src='../js/ui/jquery-ui-1.10.3.custom.js'></script>
		<script type='text/javascript' src='../js/slide-menu.js'></script>
		<script type='text/javascript' src='../js/jquery.ad-gallery.js'></script>
		<script type='text/javascript' src='../js/jquery.gad-gallery.js'></script>
		<script type='text/javascript' src='../js/jquery.bxSlider.js'></script>
		<script type='text/javascript' src='../js/jquery.cropbykk-1.0.10.js'></script>
		<script type='text/javascript' src='../js/jquery.superslides.js' charset='utf-8'></script>
		<script type='text/javascript' src='../js/jquery.slimscroll.min.js'></script>
		<script type='text/javascript' src='../js/jquery.form.min.js'></script>
		<script type='text/javascript' src='../js/jquery.history.js'></script>
		
		<?php 
		if($_COOKIE["css3support"] == 'yes' || $_GET["css3support"] == 'yes')
		{
			?>
			<link href="css/stylesheet.css" rel="stylesheet" type="text/css" />
			<?php
		}
		else 
		{
			?>
			<link href="css/stylesheetie.css" rel="stylesheet" type="text/css" />
			<?php
		}
		?>
		
		<?php 
		if($isAdmin)
		{
		?>
		<link href="css/admin.css" rel="stylesheet" type="text/css" />
		<?php 
		}
		?>
		<link href="css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet" />
		<link href="css/ad-gallery.css" rel="stylesheet" type="text/css" />
		<link href="css/gad-gallery.css" rel="stylesheet" type="text/css" />
		<link href="css/bx_styles.css" rel="stylesheet" type="text/css" />
		<link href="css/superslides.css" rel="stylesheet" type="text/css" />
		
		<script type="text/javascript" src="../js/jquery-te-1.4.0.min.js" charset="utf-8"></script>
		<script type="text/javascript" src="../js/jquery.mCustomScrollbar.min.js"></script>
		<link rel="stylesheet" href="css/jquery-te-1.4.0.css" media="screen" />
		<link href="css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div id="crop-overlay" ></div>
		<div id="product-overlay" ></div>
		<div id="news-overlay" ></div>
		<div id="login-overlay" >
			<div id="login-form" >
				<span class="cancelbykk" id="login-cancel">
				</span>
				<form action="?login=1" method="POST" >
					<div style="padding: 5px 5%;">
						<div style="width: 100%;color: #555;margin: 0 0 2px 0;">Email or Mobile-phone</div>
						<input type="text"  style="width: 258px;" class="textbykk" name="lemail" >
					</div>
					<div style="padding: 5px 5%;">
						<div style="width: 100%;color: #555;margin: 0 0 2px 0;">Password</div>
						<input type="password"  style="width: 258px;" class="textbykk" name="lpassword" >
					</div>
					<div style="padding: 5px 5%;">
						<div style="width: 100%;color: #555;margin: 0 0 2px 0;"><input type="checkbox" style="float: left;margin: 5px;" name="rememberme" ><div style="margin: 3px;float: left;">Remember</div></div>
						<input type="submit" value="Login" style="width: 268px;" class="btnbykk" >
						<input type="hidden" name="login" value="1" >
					</div>
				</form>
			</div>
		</div>
		<div id="signup-overlay" >
			<?php 
			if(!$isLoggedIn)
			{
			?>
			<div id="signup-form" >
				<span class="cancelbykk" id="signup-cancel">
				</span>
				<div class="ajax-index">
				</div>
			</div>
			<?php 
			}
			else
			{
			?>
			<div id="profile-form" >
				<span class="cancelbykk" id="profile-cancel">
				</span>
				<div class="ajax-index">
				</div>
			</div>
			<?php 
			}
			?>
		</div>
		<div id="toolbar" >
			<div class="inner" >
				<div id="lang" >
					<span><a href="../fa/" class="download" >[Fa]</a></span>
					<span ><a href="../de/" class="download" >[De]</a></span>
					<span class="selected"><a href="../en/" class="download" >[En]</a></span>
				</div>
				<div id="toolbar-menu" style="">
				<?php 
				if(!$isLoggedIn)
				{
				?>
					<div id="login-pop-up" class="login">Login</div>
					<div id="signup-pop-up" class="signup">Sign up</div>
				<?php 
				}
				else
				{
				?>
					<div class="logout" ><a href="?logout=1" style="color:#ccc;" class="download" >Logout</a></div>
					<div  class="profile" id="profile-pop-up">Profile [<?php if(isset($_SESSION["adminbykk"])) echo $_SESSION["adminbykk"][1]; else echo $_SESSION["userbykk"][1]; ?>]</div>
				<?php 
				}
				?>
				</div>
			</div>
			<?php 
			if(isset($_SESSION["login_msg"]))
			{
			?>
				<div id="login-alert" class="<?php if($_SESSION["login_msg"][0] == '1') echo "green"; else echo "red";?>" ><?php echo $_SESSION["login_msg"][1];?></div>
				<script type="text/javascript">
				<?php 
				if($_SESSION["login_msg"][0] != '2')
				{
				?>
					$("#login-alert").click(function(){
						$("#login-alert").animate({'opacity':'0'},300,function(){
							$("#login-alert").css({'display':'none'});
						});
					});
				<?php 
				}
				?>
				var marginLeft = $("#login-alert").outerWidth()/2;
				setTimeout(function(){
					$("#login-alert").css({'margin-left':-marginLeft+"px"});
				},10);
				setTimeout(function(){
					$("#login-alert").animate({'opacity':'0'},300,function(){
						$("#login-alert").css({'display':'none'});
					});
				},<?php if($_SESSION["login_msg"][0] == '2') echo "10000"; else echo "2500"; ?>);
				</script>
			<?php 
			unset($_SESSION["login_msg"]);
			}
			?>
		</div>
		<!-- start of navigation bar -->
		<div id="navbar" >
			<div id="inner-nav" >
				<div style="height:100%;width: 100px;float: left;" id="logo">
					<a href="?cmode=home&command=<?php echo encodeURIComponent("index/home.php"); ?>" class="item home" >
						<span class="primary" >
							<span class="title" >
								<img alt="Raha Darman" src="../images/raha-darman-logo.png" style="height: 60px;margin: 20px 0 4px 0;" id="rahadarman-logo">
							</span>
						</span>
					</a>
				</div>
				<ul id="menu" >
					<li>
						<a href="?cmode=full&command=<?php echo encodeURIComponent("index/product.php"); ?>" class="item product" >
							<span class="primary" >
								<span class="title" >Product</span>
								<span class="arrow" ></span>
							</span>
						</a>
					</li>
					<li>
						<a href="?cmode=full&command=<?php echo encodeURIComponent("index/news.php"); ?>" class="item news" >
							<span class="primary" >
								<span class="title" >News / Article</span>
							</span>
						</a>
					</li>
					<li>
						<a href="?cmode=full&command=<?php echo encodeURIComponent("index/gallery.php"); ?>" class="item gallery" >
							<span class="primary" >
								<span class="title" >Gallery</span>
							</span>
						</a>
					</li>
					<li>
						<a href="?cmode=full&command=<?php echo encodeURIComponent("index/contact.php"); ?>" class="item contact" >
							<span class="primary" >
								<span class="title" >Contact Us</span>
							</span>
						</a>
					</li>
					<li>
						<a href="?cmode=full&command=<?php echo encodeURIComponent("index/about.php"); ?>" class="item about" >
							<span class="primary" >
								<span class="title" >About Us</span>
							</span>
						</a>
					</li>
					<?php 
					if($isAdmin)
					{
					?>
					<li>
						<a href="#5" class="item control" >
							<span class="primary" >
								<span class="title" >Control panel</span>
							</span>
						</a>
					</li>
					<?php 
					}
					?>
				</ul>
			</div>
			<div id="nav-shadow" >
				<div id="progress-bar"></div>
			</div>
			<div id="sub-menu">
				<?php 
				if($isAdmin)
				{
				?>
				<div id="controlpanel_container" >
					<span class="lable" >control panel</span>
					<div class="controls">
					</div>
				</div>
				<?php 
				}
				?>
				<div class="sub-menus product">
					<span class="title product" >product<br>category</span>
					<div class="container" >
						<div id="product-category-go-prev" ></div>
						<div style="height: 100%;width:830px;float: left;position: relative;overflow: hidden;" >
							<div id="pop-up-product-category" >
								<?php 
							    if($isAdmin)
							    	$cquery = mysql_query("SELECT category , category_picture , picture_thumb FROM productbykk_".$sitelang." WHERE state = 1 ORDER BY category  ASC ;", $db);
							    else
							    	$cquery = mysql_query("SELECT category , category_picture , picture_thumb FROM productbykk_".$sitelang." WHERE state = 1 AND showto <= '$level' AND showto > 0  ORDER BY category  ASC ;", $db);
							    if (!$cquery)
							    	die("Error reading query: ".mysql_error());
							    
							    $check_category = '';
							    $i=0;
							    while($crows=mysql_fetch_row($cquery))
							    {
							    	if($check_category != $crows[0])
							    	{
							    		$check_category = $crows[0];
							    		
							    		if($crows[1] != '') 
							    			$img = $crows[1]; 
							    		else 
							    			$img = $crows[2];
							    		
							    		if(!file_exists($img))
							    			$img = "../images/white.png";
							    		 
							    	?>
							    	<div class="p-item">
										<div class="p-inner">
											<a href="?cmode=full&command=<?php echo encodeURIComponent("index/product.php?category=".$crows[0]."&sub_category=all"); ?>" onclick="gotoPage('full',500,'index/product.php?category=<?php echo encodeURIComponent($crows[0]); ?>&sub_category=all');" >
												<img alt="<?php echo getCategory($crows[0]); ?>" src="<?php echo $img; ?>" >
											</a>
										</div>
										<span><?php echo getCategory($crows[0]); ?></span>
									</div>
							    	<?php
							    	$i++;
							    	}
							    }
							    ?>
							</div>
						</div>
						<div id="product-category-go-next"></div>
					</div>
				</div>
				<div class="sub-menus control">
					<span class="title control" >Control panel</span>
					<div class="container" style="padding: 0;width: 890px;" >
						<div class="cp-menu" style="width: 440px;">
							<h1 class="menu-title" style="">
								add/edit items
							</h1>
							<div class="cpitem" onclick="gotoPage('full',500,'index/addslide.php');" >Slide List</div>
							<div class="cpitem" onclick="gotoPage('full',500,'index/addslide.php?mode=add');">Add Slide</div>
							<div class="cpitem" onclick="gotoPage('full',500,'index/addproduct.php');" >Add Product</div>
							<div class="cpitem" onclick="gotoPage('full',500,'index/addnews.php');">Add News/Article</div>
							<div class="cpitem" onclick="gotoPage('full',500,'index/addform.php?mode=add');" >Add form</div>
							<div class="cpitem" onclick="gotoPage('full',500,'index/addform.php');" >Forms' list</div>
						</div>
						<div class="cp-menu">
							<h1 style="width: 100%;padding: 7px 0 5px 0;color: #333;text-align: center;border-bottom: 1px solid #dadada;font-size: 12px;text-transform:uppercase;margin: 0;">
								member and forms
							</h1>
							<div class="cpitem" onclick="gotoPage('full',500,'index/member.php');" >Members</div>
							<div class="cpitem" onclick="gotoPage('full',500,'index/filledforms.php');" >Filled Forms' list</div>
						</div>
						<div class="cp-menu">
							<h1 style="width: 100%;padding: 7px 0 5px 0;color: #333;text-align: center;border-bottom: 1px solid #dadada;font-size: 12px;text-transform:uppercase;margin: 0;">
								setting and statics
							</h1>
							<div class="cpitem" onclick="gotoPage('full',500,'index/controlpanel.php');" >Control Panel</div>
							<div class="cpitem" onclick="gotoPage('full',500,'index/message.php');" >Message</div>
							<div class="cpitem" onclick="gotoPage('full',500,'index/editfooter.php');" >Edit Footer Text</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end of navigation bar -->
		<div id="page-title" >
			<div style="position: absolute;top:0;left:0;width: 100%;height: 820px;overflow: hidden;" id="slider-height">
				<div id="slider-container" style="opacity:1;margin: 0;width: 100%;padding: 0;" >
				    <div class="slides-container">
				    <?php 
				    if($isAdmin)
				    	$squery = mysql_query("SELECT picture, linkto, linkid FROM slidebykk_".$sitelang." WHERE state = 1 ORDER BY id  DESC ;", $db);
				    else
				    	$squery = mysql_query("SELECT picture, linkto, linkid FROM slidebykk_".$sitelang." WHERE state = 1 AND showto <= '$level' AND showto > 0  ORDER BY id DESC ;", $db);
				    if (!$squery)
				    	die("Error reading query: ".mysql_error());
				    
				    while( $srows=mysql_fetch_row($squery) )
				    {
				    	?>
				    	<img src="<?php echo $srows[0]; ?>" width="1500" height="700" 
				    	<?php 
				    	$linkto_lang = explode("|", $srows[1]);
				    	$linkto = $linkto_lang[1];
				    	$linkto_lang = $linkto_lang[0];
				    	if($linkto == '1')
				    	{
				    		$subquery = mysql_query("SELECT category, sub_category FROM productbykk_".$linkto_lang." WHERE state = 1 AND id='$srows[2]' ;", $db);
				    		if($subrow=mysql_fetch_row($subquery))
				    		{
				    				echo "style='cursor:pointer;' onclick=".chr(34)."gotoPage('full',500,'index/product.php?category=".encodeURIComponent($subrow[0])."&sub_category=".encodeURIComponent($subrow[1])."&ptoshow=".$srows[2]."');".chr(34)." ";
				    		}
				    	}
				    	else if($linkto == '2')
				    	{
			    			echo "style='cursor:pointer;' onclick=".chr(34)."gotoPage('full',500,'index/news.php?ntoshow=".$srows[2]."');".chr(34)." ";
				    	}
				    	else if($linkto == '3')
				    	{
				    		echo "style='cursor:pointer;' onclick=".chr(34)."gotoPage('full',500,'index/gallery.php?gtoshow=".$srows[2]."');".chr(34)." ";
				    	}
				    	else if($linkto == '4')
				    	{
				    		echo "style='cursor:pointer;' onclick=".chr(34)."window.location='".$srows[2]."';".chr(34)." ";
				    	}
				    	else if($linkto == '5')
				    	{
				    		echo "style='cursor:pointer;' onclick=".chr(34)."gotoPage('full',500,'index/fillform.php?goback=home&id=".$srows[2]."');".chr(34)." ";
				    	}
				    	?> >
				    	<?php
				    }
				    ?>
				    </div>
				</div>
			</div>
			<div id="inner-page-title">
				<span id="title">
					raha darman
				</span>
				<!-- <div style="float: left;height: 25px;width: 770px;margin: 0 0 0 10px;position: relative;font-size: 12px;color: #333;background-color: #ccc;">
					<span style="float: left;">&gt;</span>
					<span style="float: left;margin-right: 5px;">Products</span>
					<span style="float: left;">&gt;</span>
				</div> -->
			</div>
		</div>
		<div id="main-index" >
		</div>
		<div id="footer" >
			<div style="height: 210px;width: 980px;margin: 0 auto;position: relative;">
				<div style="height: 30px;width: 950px;margin: 5px 15px 0;border-bottom: 1px solid #555;font-size: 12px;text-transform:uppercase;color: #555;position: relative;display: inline-block;">
					<div style="height: 20px;margin: 5px 5px 0 0;color: #555;font-weight: bold;">
						<span style="float: left;margin: 0 3px;text-shadow: #aaa 1px 1px;cursor: pointer;" onclick="gotoPage('main',500,'index/home.php');" >Rahadarman</span>
						<div id="page-nav" >
						</div>
					</div>
				</div>
				<div style="height: 100px;width: 300px;float: left;">
					<div class="footer-link">
						<a href="?cmode=home&command=<?php echo encodeURIComponent("index/home.php"); ?>" onclick="gotoPage('main',500,'index/home.php');" >Home</a>
					</div>
					<div class="footer-link">
						<a href="?cmode=full&command=<?php echo encodeURIComponent("index/product.php"); ?>" onclick="gotoPage('full',500,'index/product.php');" >Product</a>
					</div>
					<div class="footer-link">
						<a href="?cmode=full&command=<?php echo encodeURIComponent("index/news.php"); ?>" onclick="gotoPage('full',500,'index/news.php');" >News / Article</a>
					</div>
					<div class="footer-link">
						<a href="?cmode=full&command=<?php echo encodeURIComponent("index/about.php"); ?>" onclick="gotoPage('full',500,'index/about.php');" >About Us</a>
					</div>
					<div class="footer-link">
						<a href="?cmode=full&command=<?php echo encodeURIComponent("index/contact.php"); ?>" onclick="gotoPage('full',500,'index/contact.php');" >Contact Us</a>
					</div>
					<div class="footer-link">
						<a href="?cmode=full&command=<?php echo encodeURIComponent("index/contact.php"); ?>" onclick="gotoPage('full',500,'index/contact.php');" >Contact Us</a>
					</div>
				</div>
				<div style="height: 100px;width: 450px;float: right;margin-right: 20px;">
				<?php 
				$contact_address = "aboutandcontact/footer.dtx";
				$check = false;
				$f = fopen($contact_address, "r");
				if($f===false)
					echo $contact_address." doesn't exist.";
				else
					while(!feof($f))
					{
						$buf = fgets($f , 4096);
						$buf = htmlspecialchars_decode($buf, ENT_QUOTES);
						if(!$check)
						{
							echo $buf;
							$check = true;
						}
						else
							echo chr(13).$buf;
					}
					?>
				</div>
				<div style="height: 60px;width: 980px;margin-top: 7px;float: left;position: relative;">
					<div style="height: 60px;width: 60px;position: absolute;left: 460px;top: 0px;z-index: 70002;" id="designerbykkbw"><img alt="" src="../images/hmstudiobw.png" height="60"></div>
					<div style="height: 60px;width: 60px;position: absolute;left: 460px;top: 0px;opacity:0;z-index: 70000;" id="designerbykkc"><img alt="" src="../images/hmstudioc.png" height="60"></div>
					<div style="height: 20px;padding-top:20px;width: 0;position: absolute;left: 460px;top: 0px;opacity:0;z-index: 70001;text-align: center;overflow: hidden;" id="designerbykktext" ><div style="width: 120px;"><a href="http://h-m-studio.com" style="font-weight: bold;color: #0d435f;font-family: Comic Sans MS;" class="download" target="_blank">H-M-Studio.com</a></div></div>
				</div>
			</div>
		</div>
		<script>
		var designerTimeOut;
		$("#designerbykkbw, #designerbykkc, #designerbykktext").mouseenter(function(){
			clearTimeout(designerTimeOut);
			$("#designerbykkbw").stop().animate({'left':'370px'},300);
			$("#designerbykkc").stop().animate({'left':'550px','opacity':'1'},300);
			$("#designerbykktext").stop().animate({'left':'430px','width':'120px','opacity':'1'},300);
		});
		$("#designerbykkbw, #designerbykkc, #designerbykktext").mouseleave(function(){
			designerTimeOut = setTimeout(function(){
				$("#designerbykkbw").stop().animate({'left':'460px'},300);
				$("#designerbykkc").stop().animate({'left':'460px','opacity':'0'},300);
				$("#designerbykktext").stop().animate({'left':'460px','width':'0','opacity':'0'},300);
			},3000)
		});
		// history
		var pageNumber = 0 ;
		var pageHistory = new Array(1000);
		for (var i = 0; i < 1000; i++) {
			pageHistory[i] = new Array(4);
		}
		//
		var popUp = 0, isPop = false;
		var selectedPage = 'main', selectedSub = '', destPage = '', destSub = '';
		var checkProductScrollUpLoop, checkNewsScrollUpLoop, checkGalleryScrollUpLoop;
		function disableATag()
		{
			$("a").not(".download").click(function(e){
				e.preventDefault();
			});
			
		}
		function progressBar(speed,percentage)
		{
			$("#progress-bar").stop().animate({'width': percentage+'%'},speed,"linear",function(){
				if(percentage > 99)
				{
					$("#progress-bar").animate({'opacity':'0'},200,function(){
						$("#progress-bar").css({'width':'0%','opacity':'1'});
					});
					disableATag();
				}
				else
				{
					$("#progress-bar").stop().animate({'width': (percentage+5)+'%'},5000,"linear");
				}
			});
		}
		function mainToFullSection(speed,url,percentage,sub)
		{
			progressBar(speed,percentage);
			$("#main-index").css({'z-index':'auto'});
			$("#index-loader").animate({'opacity':'0'},speed/2);
			$("#main-index").load(url,function() {
				if(!$("#main-index").hasClass("iloaded"))
					$("#main-index").addClass("iloaded");
				if($("#main-index").hasClass("aloaded") && $("#main-index").hasClass("iloaded"))
				{
					$("#index-loader").animate({'opacity':'1'},speed);
					progressBar(speed,100);
					selectedPage = 'full';
				}
			});
			$("#slider-container").animate({'opacity':'0'},speed, function() {
				$(this).css({'display':'none'});
				progressBar(speed,90);
				$("#main-index").animate({'margin-top':'5px','min-height':'600px'},speed,function() {
					if(!$("#main-index").hasClass("aloaded"))
						$("#main-index").addClass("aloaded");
					if($("#main-index").hasClass("aloaded") && $("#main-index").hasClass("iloaded"))
					{
						$("#index-loader").animate({'opacity':'1'},speed);
						progressBar(speed,100);
						selectedPage = 'full';
					}
				});
			});
		}
		function fullSectionToMain(speed,url,percentage,sub)
		{
			progressBar(speed,percentage);
			$("#index-loader").animate({'opacity':'0'},speed/2);
			$("#main-index").css({'z-index':'7000'}).animate({'margin-top':'400px','min-height':'300px'},speed, function() {
				progressBar(speed,90);
				$("#slider-container").css({'display':'block'}).animate({'opacity':'1'},speed, function() {
					if(!$("#main-index").hasClass("aloaded"))
						$("#main-index").addClass("aloaded");
					if($("#main-index").hasClass("aloaded") && $("#main-index").hasClass("iloaded"))
					{
						$("#index-loader").animate({'opacity':'1'},speed);
						progressBar(speed,100);
						selectedPage = 'main';
					}
				});
			});
			$("#main-index").load(url,function() {
				if(!$("#main-index").hasClass("iloaded"))
					$("#main-index").addClass("iloaded");
				if($("#main-index").hasClass("aloaded") && $("#main-index").hasClass("iloaded"))
				{
					$("#index-loader").animate({'opacity':'1'},speed);
					progressBar(speed,100);
					selectedPage = 'main';
				}
			});
		}
		History.Adapter.bind(window,'statechange',function(){ // Note: We are using statechange instead of popstate
			var stateNumber = History.getState().data.number;
			if(stateNumber != pageNumber) 
			{
				pageNumber = stateNumber;
				gotoPage(pageHistory[stateNumber][0],pageHistory[stateNumber][1],pageHistory[stateNumber][2],pageHistory[stateNumber][3],1);
				//alert(pageHistory[stateNumber][0]);
				
			}
		});
		function gotoPage(mode,speed,url,sub,hash)
		{
			if(hash == null )
			{
				pageNumber++;
				History.pushState({number:pageNumber}, "Loading...", "?PH="+pageNumber);
				pageHistory[pageNumber][0] = mode;
				pageHistory[pageNumber][1] = speed;
				pageHistory[pageNumber][2] = url;
				pageHistory[pageNumber][3] = sub;
			}
			/////////
			$("#main-index").removeClass("aloaded").removeClass("iloaded");
			destPage = mode;
			if(sub != null || sub == '')
			{
				destSub = sub;
				doSub = encodeURIComponent(sub);
			}
			else
			{
				doSub = "";
			}
			
			var percentage = 50;
			
			try
			{
				clearInterval(checkProductScrollUpLoop);
			}
			catch(e)
			{
				console.log(e);
			}
			try
			{
				clearInterval(checkNewsScrollUpLoop);
			}
			catch(e)
			{
				console.log(e);
			}
			try
			{
				clearInterval(checkGalleryScrollUpLoop);
			}
			catch(e)
			{
				console.log(e);
			}
			/////////
			$("#product-overlay, #news-overlay").css({'opacity':'1','display':'none'});
			
			if(selectedPage == 'main')
			{
				if(mode == 'full')
				{
					percentage = 50;
					mainToFullSection(speed,url+doSub,percentage,sub);
				}
				else if(mode == 'main')
				{
					percentage = 75;
					$("#main-index").addClass("aloaded");
					progressBar(speed,percentage);
					$("#main-index").load(url+doSub,function() {
						if(!$("#main-index").hasClass("iloaded"))
							$("#main-index").addClass("iloaded");
						if($("#main-index").hasClass("aloaded") && $("#main-index").hasClass("iloaded"))
						{
							$("#index-loader").animate({'opacity':'1'},speed);
							progressBar(speed,100);
							selectedPage = 'main';
						}
					});
				}
			}
			else if(selectedPage == 'full')
			{
				if(mode == 'full')
				{
					percentage = 75;
					$("#main-index").addClass("aloaded");
					progressBar(speed,percentage);
					$("#main-index").load(url+doSub,function() {
						if(!$("#main-index").hasClass("iloaded"))
							$("#main-index").addClass("iloaded");
						if($("#main-index").hasClass("aloaded") && $("#main-index").hasClass("iloaded"))
						{
							$("#index-loader").animate({'opacity':'1'},speed);
							progressBar(speed,100);
							selectedPage = 'full';
						}
					});
				}
				else if(mode == 'main')
				{
					percentage = 50;
					fullSectionToMain(speed,url+doSub,percentage,sub);
				}
			}
			
		}

		$("#logo .item.home").click(function(){
			gotoPage('main',500,'index/home.php');
		});
		$("#menu li .item.product").click(function(){
			gotoPage('full',500,'index/product.php');
		});
		$("#menu li .item.news").click(function(){
			gotoPage('full',500,'index/news.php');
		});
		$("#menu li .item.gallery").click(function(){
			gotoPage('full',500,'index/gallery.php');
		});
		$("#menu li .item.contact").click(function(){
			gotoPage('full',500,'index/contact.php');
		});
		$("#menu li .item.about").click(function(){
			gotoPage('full',500,'index/about.php');
		});
		
		$("#menu li .item,#logo .item").mouseover(function(){
			$("#menu li .item,#logo .item").removeClass("hover");
			$(this).addClass("hover");
			$("#toolbar").stop();
			if($(this).hasClass("product"))
			{
				if(popUp != 1)
				{
					if(!isPop)
					{
						$(".sub-menus").not(".sub-menus.product").stop().animate({'opacity':'0'},100,function(){
							$(".sub-menus").not(".sub-menus.product").css({'display':'none','height':'0px'});
						});
						$(".sub-menus.product").css({'display':'none','height':'0px','opacity':'1'});
						$(".sub-menus.product").children().css({'opacity':'0'});
						$(".sub-menus.product").stop().css({'display':'block'}).animate({'height':'200px'},500,'easeOutBounce',function(){
							$(".sub-menus.product").children().animate({'opacity':'1'},100);
							if(!$("#pop-up-product-category").hasClass("done-setting-margin") && $("#pop-up-product-category").hasClass("done-loading-images"))
								setImgMargin("#pop-up-product-category .p-item .p-inner img",150,140);
						});
					}
					else
					{
						$(".sub-menus").not(".sub-menus.product").stop().animate({'opacity':'0'},300,function(){
							$(".sub-menus").not(".sub-menus.product").css({'display':'none','height':'0px'});
						});
						$(".sub-menus.product").css({'display':'block','height':'200px','opacity':'1'});
						$(".sub-menus.product").children().css({'opacity':'0'});
						$(".sub-menus.product").stop().children().animate({'opacity':'1'},300);
					}
					popUp = 1;
					isPop = true;
				}
			}
			else if($(this).hasClass("control"))
			{
				if(popUp != 2)
				{
					if(!isPop)
					{
						$(".sub-menus").not(".sub-menus.control").stop().animate({'opacity':'0'},100,function(){
							$(".sub-menus").not(".sub-menus.control").css({'display':'none','height':'0px'});
						});
						$(".sub-menus.control").css({'display':'none','height':'0px','opacity':'1'});
						$(".sub-menus.control").children().css({'opacity':'0'});
						$(".sub-menus.control").stop().css({'display':'block'}).animate({'height':'200px'},500,'easeOutBounce',function(){
							$(".sub-menus.control").children().animate({'opacity':'1'},100);
						});
					}
					else
					{
						$(".sub-menus").not(".sub-menus.control").stop().animate({'opacity':'0'},300,function(){
							$(".sub-menus").not(".sub-menus.control").css({'display':'none','height':'0px'});
						});
						$(".sub-menus.control").css({'display':'block','height':'200px','opacity':'1'});
						$(".sub-menus.control").children().css({'opacity':'0'});
						$(".sub-menus.control").stop().children().animate({'opacity':'1'},300);
					}
					popUp = 2;
					isPop = true;
				}
			}
			else
			{
				$("#toolbar").stop().animate({'padding':'0'},500,function(){
					$(".sub-menus").stop().animate({'opacity':'0'},100,function(){
						$(".sub-menus").css({'display':'none','height':'0px'});
						isPop = false;
					});
					//$("#menu li .item").removeClass("hover");
					popUp = 0;
				});
			}
		}).mouseout(function(){
			if(popUp == 0)
			{
				$("#menu li .item, #logo .item").removeClass("hover");
				isPop = false;
			}
		});
		$("#logo,#toolbar").mouseenter(function(){
			$("#toolbar").stop().animate({'padding':'0'},500,function(){
				$(".sub-menus").stop().animate({'opacity':'0'},100,function(){
					$(".sub-menus").css({'display':'none','height':'0px'});
					isPop = false;
				});
				$("#menu li .item, #logo .item").removeClass("hover");
				popUp = 0;
			});
		});
		$(".sub-menus").mouseleave(function(){
			$("#toolbar").stop().animate({'padding':'0'},500,function(){
				$(".sub-menus").stop().animate({'opacity':'0'},100,function(){
					$(".sub-menus").css({'display':'none','height':'0px'});
					isPop = false;
				});
				$("#menu li .item, #logo .item").removeClass("hover");
				popUp = 0;
			});
		});
		$(".sub-menus").mouseenter(function(){
			$("#toolbar").stop();
		});
		$("#menu li .item, .p-item, .c-item, .cpitem").not(".control").click(function(){
			$(".sub-menus").stop().animate({'opacity':'0'},100,function(){
				$(".sub-menus").css({'display':'none','height':'0px'});
				isPop = false;
			});
			popUp = 0;
		});

		$("#lang").children().click(function() {
			$("#lang").children().not(this).removeClass("selected");
			$(this).addClass("selected");
		})

		function setImgMargin(object,width,height)
		{
			var imgHeight, imgWidth, imgRaito, ratio = height/width;
			var marginH=0, marginV=0;
			$(object).each(function(index){
				imgHeight = this.height;
				imgWidth = this.width;
				imgRaito = imgHeight / imgWidth;
				if(imgRaito >= ratio)
				{
					marginV = 0;
					marginH = width - (height/imgRaito);
					if(marginH != 0)
						marginH = marginH/2;
					else
						marginH = 0;
					$(this).css({'margin':marginV+'px '+marginH+'px','height':height+'px','opacity':'1'});
				}
				else
				{
					marginV = height - (width*imgRaito);
					marginH = 0;
					$(this).css({'margin-top':marginV+'px','width':width+'px','opacity':'1'});
				}
			});
			$("#pop-up-product-category").addClass("done-setting-margin");
			//alert();
		}

		var pImgLoaded = {};
		var tryStartSetMargin;
		function trySetMargin(index){
			var count = 0;
			for (e in pImgLoaded){count++;}
			if(count == 0){
				clearInterval(tryStartSetMargin);
				$("#pop-up-product-category").addClass("done-loading-images");
				if(!$.browser.msie)
				{
					setTimeout(function() {
						setImgMargin("#pop-up-product-category .p-item .p-inner img",150,140);
					},300);
				}
			}
		}
		
		
		$(document).ready(function(){
			disableATag();
			
			History.pushState({number:pageNumber}, 'Home', "?PH="+pageNumber);
			/*pageHistory[pageNumber][0] = 'main';
			pageHistory[pageNumber][1] = 500;
			pageHistory[pageNumber][2] = 'index/home.php';*/
			
			$('#slider-container').superslides({
				hashchange: false/*,
				inherit_width_from: "#slider-container",
				inherit_height_from: "#slider-container"*/
				//,inherit_height_from: "#slider-height"
			});

			gotoPage('main',500,'index/home.php');
			
			popUpProductSlider = $("#pop-up-product-category").bxSlider({
		    	displaySlideQty: 5,
		        moveSlideQty: 5,
		        infiniteLoop: false,
				controls: false
			});
			
			$('#product-category-go-prev').click(function(){
				popUpProductSlider.goToPreviousSlide();
			    return false;
			});
		
			$('#product-category-go-next').click(function(){
				popUpProductSlider.goToNextSlide();
				return false;
			});

			$("#pop-up-product-category .p-item .p-inner").hover(function(){
				$(this).stop().animate({'opacity':'0.5'},200);
			},function(){
				$(this).stop().animate({'opacity':'1'},200);
			});

			// check if pop up product category loaded
			var pImg_load = '#pop-up-product-category .p-item .p-inner img';
			jQuery(pImg_load).each(function(index){
				pImgLoaded[index] = true;
				jQuery(this).load(function(){
					delete pImgLoaded[index];
				});
				if (this.complete) jQuery(this).trigger("load");
			});
			
			tryStartSetMargin = setInterval(trySetMargin, 50);

			<?php 
			if(isset($_GET["cmode"]))
			{
			?>
			setTimeout(function(){
			<?php 
				if($_GET["cmode"] == 'full')
				{
				?>
				gotoPage('full',500,'<?php echo $_GET["command"]; ?>');
				<?php
				}
				else if($_GET["cmode"] == 'home')
				{
				?>
				gotoPage('main',500,'<?php echo $_GET["command"]; ?>');
				<?php
				}
			?>
			},300);
			<?php 
			}
			?>
			
		});
		///// end of test \\\\\\\
		var isMenuFixed = false;
		$(document).scroll(function(){
			var scrollTop =  $(document).scrollTop();
			//var menuTop = $("#navbar").position().top;
			if(scrollTop >= 77)
			{
				if(!isMenuFixed)
				{
					$("#navbar").css({'position':'fixed','margin-top':'-54px','top':'0'});
					$("#page-title").css({'margin-top':'90px'});
					$("#rahadarman-logo").stop().animate({'height': '30px','margin': '55px 0 0 0'},200);
					isMenuFixed = true;
				}
			}
			else
			{
				if(isMenuFixed)
				{
					$("#navbar").css({'position':'relative','margin-top':'0px','top':'0'});
					$("#page-title").css({'margin-top':'0px'});
					$("#rahadarman-logo").stop().animate({'height': '60px','margin': '20px 0 4px 0'},200);
					isMenuFixed = false;
				}
			}	
		});
		</script>
		<script type="text/javascript">
		var isInsideLoginForm = false, isInsideSignupForm = false, isInsideProfileForm = false;
		$("#login-form").mouseenter(function(){
			isInsideLoginForm = true;
		}).mouseleave(function(){
			isInsideLoginForm = false;
		});
		<?php 
		if(!$isLoggedIn)
		{
		?>
		$("#signup-form").mouseenter(function(){
			isInsideSignupForm = true;
		}).mouseleave(function(){
			isInsideSignupForm = false;
		});
		<?php 
		}
		else
		{
		?>
		$("#profile-form").mouseenter(function(){
			isInsideProfileForm = true;
		}).mouseleave(function(){
			isInsideProfileForm = false;
		});
		<?php 
		}
		?>
		$(document).click(function(){
			if($("#login-form").hasClass("visible") && !isInsideLoginForm)
			{
				$("#login-overlay").animate({'opacity':'0'},300,function(){
					$(this).css({'display':'none'});
					$("#login-form").removeClass("visible");
				});
			}
			<?php 
			if(!$isLoggedIn)
			{
			?>
			if($("#signup-form").hasClass("visible") && !isInsideSignupForm)
			{
				$("#signup-overlay").animate({'opacity':'0'},300,function(){
					$(this).css({'display':'none'});
					$("#signup-form").removeClass("visible");
				});
			}
			<?php 
			}
			else
			{
			?>
			if($("#profile-form").hasClass("visible") && !isInsideProfileForm)
			{
				$("#signup-overlay").animate({'opacity':'0'},300,function(){
					$(this).css({'display':'none'});
					$("#profile-form").removeClass("visible");
				});
			}
			<?php 
			}
			?>
		});
		<?php 
		if(!$isLoggedIn)
		{
		?>
		$("#signup-cancel").click(function(){
			$("#signup-overlay").animate({'opacity':'0'},300,function(){
				$(this).css({'display':'none'});
				$("#signup-form").removeClass("visible");
			});
		});
		$("#signup-pop-up").click(function(){
			if(!$("#signup-form").hasClass("loaded"))
			{
				progressBar(300, 75);
				$("#signup-form .ajax-index").load('index/register.php',function(){
					$("#signup-form").addClass("loaded");
					progressBar(300, 100);
				});
			}
			$("#signup-overlay").css({'display':'block','opacity':'0'}).animate({'opacity':'1'},300,function(){
				$("#signup-form").addClass("visible");
			});
		});
		<?php 
		}
		else
		{
		?>
		$("#profile-cancel").click(function(){
			$("#signup-overlay").animate({'opacity':'0'},300,function(){
				$(this).css({'display':'none'});
				$("#profile-form").removeClass("visible");
			});
		});
		$("#profile-pop-up").click(function(){
			if(!$("#profile-form").hasClass("loaded"))
			{
				progressBar(300, 75);
				$("#profile-form .ajax-index").load('index/register.php?mode=profile',function(){
					$("#profile-form").addClass("loaded");
					progressBar(300, 100);
				});
			}
			$("#signup-overlay").css({'display':'block','opacity':'0'}).animate({'opacity':'1'},300,function(){
				$("#profile-form").addClass("visible");
			});
		});
		<?php 
		}
		?>
		$("#login-cancel").click(function(){
			$("#login-overlay").animate({'opacity':'0'},300,function(){
				$(this).css({'display':'none'});
				$("#login-form").removeClass("visible");
			});
		});
		$("#login-pop-up").click(function(){
			$("#login-overlay").css({'display':'block','opacity':'0'}).animate({'opacity':'1'},300,function(){
				$("#login-form").addClass("visible");
			});
		});
		</script>
	</body>
</html>