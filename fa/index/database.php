<?php
session_start();

$sitelang = 'fa';

include '../../setting.php';

$db = mysql_connect( $GLOBALS["host"], $GLOBALS["user"] , $GLOBALS["pass"] );
if (!$db)
	die("Error connecting server: ".mysql_error());
$db_sel = mysql_select_db($GLOBALS["database"], $db);
if (!$db_sel)
	die("Error selecting database: ".mysql_error());

if(isset($_COOKIE["remembermebykk"]) && !isset($_SESSION["adminbykk"]) && !isset($_SESSION["userbykk"]))
{
	$cookieValue = $_COOKIE["remembermebykk"];
	$cookieValue = explode("|bykk|", $cookieValue);
	if($cookieValue[0] == "a")
	{
		$query = mysql_query("SELECT id, email, name, country, md5_code FROM registerbykk WHERE id = '".($cookieValue[1]/7)."' AND state != 0 AND ulogout = 0 ;",$db);
		if($query)
		{
			if($lrow = mysql_fetch_row($query))
			{
				if($lrow[4] == $cookieValue[2])
				{
					$_SESSION["adminbykk"][0] = $lrow[0];
					$_SESSION["adminbykk"][1] = $lrow[2];
					$_SESSION["adminbykk"][2] = $lrow[3];
					$_SESSION["adminbykk"][3] = "admin";
					$_SESSION["adminbykk"][4] = $lrow[1];
				}
			}
		}
	}
	else if($cookieValue[0] == "u")
	{
		$query = mysql_query("SELECT id, email, name, country, md5_code, user_level FROM registerbykk WHERE id = '".($cookieValue[1]/3)."' AND state != 0 AND ulogout = '0' ;",$db);
		if($query)
		{
			if($lrow = mysql_fetch_row($query))
			{
				if($lrow[4] == $cookieValue[2])
				{
					$_SESSION["userbykk"][0] = $lrow[0];
					$_SESSION["userbykk"][1] = $lrow[2];
					$_SESSION["userbykk"][2] = $lrow[3];
					$_SESSION["userbykk"][3] = $lrow[5];
					$_SESSION["userbykk"][4] = $lrow[1];
				}
			}
		}
	}
}

if(isset($_POST["login"]) && $_POST["login"] == '1' && !isset($_SESSION["adminbykk"]) && !isset($_SESSION["userbykk"])
		|| (isset($_SESSION["adminbykk"]) && $_SESSION["adminbykk"][3] == "10") && isset($_POST["login"]) && $_POST["login"] == '1')
{
	$lemail = $_POST["lemail"];
	$lpassword = $_POST["lpassword"];
	$rememberme = $_POST["rememberme"];

	$lemail = strtolower($lemail);

	$query = mysql_query("SELECT id, email, password, name, country, md5_code, user_level, uadmin, state FROM registerbykk WHERE (email = '$lemail' OR cellphone = '$lemail') AND ulaerror < 10 AND state != 0 ;",$db);
	if($query)
	{
		if($lrow = mysql_fetch_row($query))
		{
			if($lrow[2] == $lpassword)
			{
				if($_SESSION["adminbykk"][3] == "10")
					unset($_SESSION["adminbykk"]);
				if($lrow[8] == 1)
				{
					if($lrow[7] == 1)
					{
						if($rememberme)
						{
							$expire = 7*24*60*60;
							$cookieValue = "a|bykk|".($lrow[0]*7)."|bykk|".$lrow[5]."|bykk|".rand(0,100000);
							setcookie("remembermebykk", $cookieValue, time()+$expire);
						}
						$_SESSION["adminbykk"][0] = $lrow[0];
						$_SESSION["adminbykk"][1] = $lrow[3];
						$_SESSION["adminbykk"][2] = $lrow[4];
						$_SESSION["adminbykk"][3] = "admin";
						$_SESSION["adminbykk"][4] = $lrow[1];
						$_SESSION["login_msg"][0] = "1";
						$_SESSION["login_msg"][1] = $lrow[3]." خوش آمدید!";
						$query = mysql_query("UPDATE registerbykk SET ulaerror = 0 , ulogout = 0 WHERE email = '$lrow[1]' ;",$db);
						if(!$query)
							echo mysql_error();
					}
					else
					{
						if($rememberme)
						{
							$expire = 14*24*60*60;
							$cookieValue = "u|bykk|".($lrow[0]*3)."|bykk|".$lrow[5]."|bykk|".rand(0,100000);
							setcookie("remembermebykk", $cookieValue, time()+$expire);
						}
						$_SESSION["userbykk"][0] = $lrow[0];
						$_SESSION["userbykk"][1] = $lrow[3];
						$_SESSION["userbykk"][2] = $lrow[4];
						$_SESSION["userbykk"][3] = $lrow[6];
						$_SESSION["userbykk"][4] = $lrow[1];
						$_SESSION["login_msg"][0] = "1";
						$_SESSION["login_msg"][1] = $lrow[3]." خوش آمدید!";
						$query = mysql_query("UPDATE registerbykk SET ulaerror = 0 , ulogout = 0 WHERE email = '$lrow[1]' ;",$db);
						if(!$query)
							echo mysql_error();
					}
				}
				else if($lrow[8] == 2)
				{
					$_SESSION["login_msg"][0] = "0";
					$_SESSION["login_msg"][1] = "حساب کاربری شما هنوز تایید نشده است!!!";
				}
			}
			else
			{
				$query = mysql_query("UPDATE registerbykk SET ulaerror = ulaerror + 1 WHERE email = '$lemail' ;",$db);
				if(!$query)
					echo mysql_error();
				$_SESSION["login_msg"][0] = "2";
				$_SESSION["login_msg"][1] = "پسورد شما غلط است، برای بازیابی پسورد <a href='index/activeusermail.php?mode=recoverpass&email=".$lrow[1]."' target='_blank' style='color:#aaa;' class='download' >این لینک</a> را کلیک کنید";
			}
		}
		else
		{
			$_SESSION["login_msg"][0] = "0";
			$_SESSION["login_msg"][1] = "ایمیل یا رمز غلط است!";
		}
	}
	else
	{
		$_SESSION["login_msg"][0] = "0";
		$_SESSION["login_msg"][1] = "ایمیل یا رمز غلط است!";
	}
}

if(isset($_GET["logout"]) && $_GET["logout"] == '1' && (isset($_SESSION["adminbykk"]) || isset($_SESSION["userbykk"])) )
{
	if(isset($_SESSION["adminbykk"]))
	{
		$id = $_SESSION["adminbykk"][0];
		unset ($_SESSION["adminbykk"]);
	}
	else if(isset($_SESSION["userbykk"]))
	{
		$id = $_SESSION["userbykk"][0];
		unset ($_SESSION["userbykk"]);
	}

	setcookie("remembermebykk", "" , time()-60);

	$query = mysql_query("UPDATE registerbykk SET ulogout = 1 WHERE id = '$id' ;",$db);
	if(!$query)
		echo mysql_error();
	else
	{
		$_SESSION["login_msg"][0] = "1";
		$_SESSION["login_msg"][1] = "شما با موفقیت خارج شدید!";
	}
}
$isAdmin = false;
if(isset($_SESSION["adminbykk"]))
{
	if($_SESSION["adminbykk"][3] == "admin")
		$isAdmin = true;
	$level = $_SESSION["adminbykk"][3];
	$isLoggedIn = true;
}
else if(isset($_SESSION["userbykk"]))
{
	$level = $_SESSION["userbykk"][3];
	$isLoggedIn = true;
}
else
{
	$level = 1;
	$isLoggedIn = false;
}

function getCategory($string)
{
	$string = explode("_", $string);
	return implode(" ", $string);
}

function setCategory($string)
{
	$string = explode(" ", $string);
	return implode("_", $string);
}

function reArrayFiles(&$file_post) {

	$file_ary = array();
	$file_count = count($file_post['name']);
	$file_keys = array_keys($file_post);

	for ($i=0; $i<$file_count; $i++) {
		foreach ($file_keys as $key) {
			$file_ary[$i][$key] = $file_post[$key][$i];
		}
	}

	return $file_ary;
}

function encodeURIComponent($str) {
	$revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
	return strtr(rawurlencode($str), $revert);
}

function pnlink($clang,$lang,$mode,$id,$text,$db, $goback = '')
{
	$blankLink = false;
	if($clang != $lang)
		$blankLink = true;
	if($mode == '1')
	{
		$subquery = mysql_query("SELECT category, sub_category FROM productbykk_".$lang." WHERE state = 1 AND id='$id' ;", $db);
		if($subrow=mysql_fetch_row($subquery))
		{
			if(!$blankLink)
			{
				echo "<a href='?cmode=full&command=".encodeURIComponent("index/product.php?category=".$subrow[0]."&sub_category=".$subrow[1]."&ptoshow=".$id)."' ";
				echo " onclick=".chr(34)."gotoPage('full',500,'index/product.php?category=".encodeURIComponent($subrow[0])."&sub_category=".encodeURIComponent($subrow[1])."&ptoshow=".$id."');".chr(34)." >";
			}
			else
			{
				echo "<a href='../".$lang."/?cmode=full&command=".encodeURIComponent("index/product.php?category=".$subrow[0]."&sub_category=".$subrow[1]."&ptoshow=".$id)."' ";
				echo " class='download' target='_blank' >";
			}
			if($text == '')
				echo "لینک محصول";
			else
				echo $text;
			echo"</a>";
		}
	}
	else if($mode == '2')
	{
		if(!$blankLink)
		{
			echo "<a href='?cmode=full&command=".encodeURIComponent("index/news.php?ntoshow=".$id)."' ";
			echo " onclick=".chr(34)."gotoPage('full',500,'index/news.php?ntoshow=".$id."');".chr(34)." >";
		}
		else
		{
			echo "<a href='../".$lang."/?cmode=full&command=".encodeURIComponent("index/news.php?ntoshow=".$id)."' ";
			echo " class='download' target='_blank' >";
		}
		if($text == '')
			echo "لینک خبر/مقاله";
		else
			echo $text;
		echo"</a>";
	}
	else if($mode == '3')
	{
		if(!$blankLink)
		{
			echo "<a href='?cmode=full&command=".encodeURIComponent("index/gallery.php?gtoshow=".$id)."' ";
			echo " onclick=".chr(34)."gotoPage('full',500,'index/gallery.php?gtoshow=".$id."');".chr(34)." >";
		}
		else
		{
			echo "<a href='../".$lang."/?cmode=full&command=".encodeURIComponent("index/gallery.php?gtoshow=".$id)."' ";
			echo " class='download' target='_blank' >";
		}
		if($text == '')
			echo "لینگ گالری";
		else
			echo $text;
		echo"</a>";
	}
	else if($mode == '4')
	{
		echo "<a href='".$id."' class='download' target='_blank'  >";
		if($text == '')
			echo "لینک وبسایت";
		else
			echo $text;
		echo"</a>";
	}
	else if($mode == '5')
	{
		if(!$blankLink)
		{
			echo "<a href='?cmode=full&command=".encodeURIComponent("index/fillform.php?goback=".$goback."&id=".$id)."' ";
			echo " onclick=".chr(34)."gotoPage('full',500,'index/fillform.php?goback=".$goback."&id=".$id."');".chr(34)." >";
		}
		else
		{
			echo "<a href='../".$lang."/?cmode=full&command=".encodeURIComponent("index/fillform.php?goback=".$goback."&id=".$id)."' ";
			echo " class='download' target='_blank' >";
		}
		if($text == '')
			echo "لینک فرم";
		else
			echo $text;
		echo"</a>";
	}
}

?>