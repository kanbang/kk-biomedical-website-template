<?php
include 'database.php';
if($isAdmin)
{
	if($_GET["mode"] == 'search' || $_GET["mode"] == 'showmore')
	{
		$query = mysql_query("SELECT id FROM registerbykk WHERE state != 0 AND email != 'designer' ORDER BY id  DESC ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		$memberNum = mysql_num_rows($query);
		
		if($_GET["mode"] == 'search')
		{
			if(isset($_GET["search"]) && $_GET["search"] != '')
			{
				$q = $_GET["search"];
				$q = mysql_real_escape_string($q);
				$search = "";
				$search.= "email REGEXP '$q' OR ";
				$search.= "name REGEXP '$q' OR ";
				$search.= "cellphone REGEXP '$q' OR ";
				$search.= "country REGEXP '$q' OR ";
				$search.= "iran_state REGEXP '$q'";
				$query = mysql_query("SELECT id, email, name, cellphone, country, iran_state, user_level, ulang, ulaerror, state, uadmin, date, time  FROM registerbykk WHERE state != 0 AND email != 'designer' AND ( ".$search." ) ORDER BY uadmin DESC, state DESC, id DESC ;", $db);
			}
			else 
				$query = mysql_query("SELECT id, email, name, cellphone, country, iran_state, user_level, ulang, ulaerror, state, uadmin, date, time  FROM registerbykk WHERE state != 0 AND email != 'designer' ORDER BY uadmin DESC, state DESC, id DESC ;", $db);
		}
		else 
		{
			$limit = $_GET["limit"];
			$limit = explode("|", $limit);
			
			$query = mysql_query("SELECT id, email, name, cellphone, country, iran_state, user_level, ulang, ulaerror, state, uadmin, date, time  FROM registerbykk WHERE state != 0 AND email != 'designer' ORDER BY uadmin DESC, state DESC, id DESC LIMIT ".$limit[0]." , ".$limit[1]." ;", $db);
			
		}
		if (!$query)
			die("Error reading query: ".mysql_error());
		if($_GET["mode"] == 'showmore')
			$i=$limit[0];	
		else
			$i=0;
		$mnum = mysql_num_rows($query);
		
		if($_GET["mode"] == 'search' && $_GET["search"] == '')
		{
		?>
		<script type="text/javascript">moreMember = 1; memberCount = 50;</script> 
		<?php 
		}
		
		while($mrows = mysql_fetch_row($query))
		{
			if($_GET["mode"] == 'showmore' ||  ($_GET["mode"] == 'search' && $_GET["search"] == ''))
			{
				if($i > ($memberNum-1))
				{
					?>
					<script type="text/javascript">moreMember = 0;</script> 
					<?php 
					break; 
				}
				
				if($_GET["mode"] == 'showmore')
				{
					if($i > $limit[1])
						break;
				}
				else
				{
					if($i > 49) 
						break;
				}
			}
			$i++;
			
			$allowEdit = false;
			if($mrows[11] != 1  || $_SESSION["adminbykk"][0] == '99999' || $mrows[6] == '10' )
				$allowEit = true;
			?>
			<div class="field_tr <?php if($mrows[10] == 2) echo "red";?>" id="mf<?php echo $mrows[0];?>" >
				<div class="member_field <?php if($i%2 == 1) echo "fodd"; else echo "feven";?>" style="width: 27px;" <?php if($allowEit) { echo'onclick="mEdit('.$mrows[0].');"'; }?>>
					<?php echo $i;?>
				</div>
				<div class="member_field <?php if($i%2 == 1) echo "fodd"; else echo "feven";?>" style="width: 120px;direction: ltr;text-align: left;" <?php if($allowEit) { echo'onclick="mEdit('.$mrows[0].');"'; }?>>
					<?php echo $mrows[1];?>
				</div>
				<div class="member_field <?php if($i%2 == 1) echo "fodd"; else echo "feven";?>" <?php if($allowEit) { echo'onclick="mEdit('.$mrows[0].');"'; }?>>
					<?php echo $mrows[2];?>
				</div>
				<div class="member_field <?php if($i%2 == 1) echo "fodd"; else echo "feven";?>" <?php if($allowEit) { echo'onclick="mEdit('.$mrows[0].');"'; }?>>
					<?php echo "+".$mrows[3];?>
				</div>
				<div class="member_field <?php if($i%2 == 1) echo "fodd"; else echo "feven";?>" style="width: 120px;" <?php if($allowEit) { echo'onclick="mEdit('.$mrows[0].');"'; }?>>
					<?php echo $mrows[4];?>
				</div>
				<div class="member_field <?php if($i%2 == 1) echo "fodd"; else echo "feven";?>"style="text-align: right;direction: rtl;" <?php if($allowEit) { echo'onclick="mEdit('.$mrows[0].');"'; }?>>
					<?php echo $mrows[5];?>
				</div>
				<div class="member_field <?php if($i%2 == 1) echo "fodd"; else echo "feven";?>" <?php if($allowEit) { echo'onclick="mEdit('.$mrows[0].');"'; }?> style="width:75px;">
					<?php echo $mrows[0];?>
				</div>
				<div class="member_field <?php if($i%2 == 1) echo "fodd"; else echo "feven";?>" style="width: 75px;" <?php if($allowEit) { echo'onclick="mEdit('.$mrows[0].');"'; }?>>
					<?php 
					if($mrows[6] == '2') echo "عادی";
					if($mrows[6] == '3') echo "سطح 1";
					if($mrows[6] == '4') echo "سطح 2";
					if($mrows[6] == '5') echo "سطح 3";
					if($mrows[6] == '7') echo "مدیر";
					if($mrows[6] == '10') echo "مدیر ارشد";
					?>
				</div>
				<div class="member_field <?php if($i%2 == 1) echo "fodd"; else echo "feven";?>" <?php if($allowEit) { echo'onclick="mEdit('.$mrows[0].');"'; }?> style="width:50px;">
					<?php
					if($mrows[7] == 'en')
						echo "انگلیسی";
					else if($mrows[7] == 'fa')
						echo "فارسی";
					else if($mrows[7] == 'de')
						echo "المانی";
					else
						echo "Unknown";
					?>
				</div>
				<div class="member_field <?php if($i%2 == 1) echo "fodd"; else echo "feven";?>" style="cursor: default;padding-top: 0;height: 23px;">
					<div style="height: 20px;width: 90px;padding: 3px 10px 0 0;margin: 0px;float: right;">
						<?php 
						if($allowEit)
						{
						?>
						<img src="../images/wrongbw.png" title="حذف" onmouseover="this.src='../images/wrong.png';" onmouseout="this.src='../images/wrongbw.png';" style="float: right;margin: 0 0 0 10px;height: 20px;cursor: pointer;" onclick="delMember(<?php echo $mrows[0];?>);">
						<?php 
						}
						if($mrows[9] != 1)
						{
						?>
						<img src="../images/correctbw.png" title="تایید" onmouseover="this.src='../images/correct.png';" onmouseout="this.src='../images/correctbw.png';" style="float: right;margin: 0 0 0 10px;height: 20px;cursor: pointer;" onclick="confirmMember(this,<?php echo $mrows[0];?>);">
						<?php 
						}
						?>
					</div>
				</div>
				<div class="member_field <?php if($i%2 == 1) echo "fodd"; else echo "feven";?>"  style="width: 95px;margin: 0px;cursor: default;position: relative;" id="minfo" title="<?php echo "Register Time: ".$mrows[11]." ".$mrows[12]; ?>">
					<?php 
					if($mrows[9] == '2')
						echo 'ایمیل تایید نشده';
					else if($mrows[8] > 9)
						echo 'حسابکاربری قفل شده';
					else "&nbsp";
					?>
				</div>
			</div>
			<?php 
		}
		if($_GET["mode"] == 'search' && $_GET["search"] != ''){?><script type="text/javascript">moreMember = 0;</script> <?php }
		/*if($_GET["mode"] == 'search')
		{
			if($mnum > 16)
			{
				?>
				<script type="text/javascript">
				$("#mnumber").css({'width':'39px'});
				$("#mcontrol").css({'width':'83px'});
				</script>
				<?php 
			}
			else
			{
				?>
				<script type="text/javascript">
				$("#mnumber").css({'width':'27px'});
				$("#mcontrol").css({'width':'95px'});
				</script>
				<?php 
			}
		}*/
	}
	else if($_GET["mode"] == 'delete')
	{
		$askForActiovation = false;
		$check = true;
		$id = $_GET["id"];
		$query = mysql_query("SELECT state FROM registerbykk WHERE id = '$id' ;", $db);
		if($row = mysql_fetch_row($query))
			if($row[0] == '1')
			$check = false;
	
		$query = mysql_query("UPDATE registerbykk SET state = '0' WHERE id='$id' ;", $db);
		if(!$query)
			echo mysql_error();
		else if($check && $askForActiovation)
		{
			$query = mysql_query("SELECT id, firstname, lastname, email FROM registerbykk WHERE id = '$id' ;", $db);
			if (!$query)
				die("Error reading query: ".mysql_error());
				
			if($row = mysql_fetch_row($query))
			{
				include('../../mail/class.phpmailer.php');
				include("../../mail/class.smtp.php");
	
				$firstname = $row[1];
				$lastname = $row[2];
				$email = $row[3];
	
				$mail = new PHPMailer();
					
				$body= '
				<div style="color:#999999;font-size:15px;direction:rtl;text-align:left;">
				Ø¨Ø§ Ø³Ù„Ø§Ù…'.$firstname.' '.$lastname.'<br>
				Ø§ÛŒÙ…ÛŒÙ„: '.$email.'<br>
				Ø­Ø³Ø§Ø¨ Ú©Ø§Ø±Ø¨Ø±ÛŒ Ø´Ù…Ø§ ØªØ§ÛŒÛŒØ¯ Ù†Ø´Ø¯!<br>
				Ø¨Ø§ ØªØ´Ú©Ø±
				</div>';
					
				$mail->IsSMTP(); // telling the class to use SMTP
				//$mail->Host       = "smtp.gmail.com"; // SMTP server
				$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
				// 1 = errors and messages
				// 2 = messages only
				$mail->ContentType = "text/html;charset=utf-8";
				$mail->CharSet = "UTF-8";
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
				$mail->Host       = $emailHost;      // sets GMAIL as the SMTP server
				$mail->Port       = $emailPort;                   // set the SMTP port for the GMAIL server
				$mail->Username   = $emailUsername;  // GMAIL username
				$mail->Password   = $emailPassword;            // GMAIL password
				$mail->SetFrom($emailUsername, $emailName);
					
				// $mail->AddReplyTo("name@yourdomain.com","First Last");
					
				$mail->Subject    = "Ø¹Ø¯Ù… ØªØ§ÛŒÛŒØ¯ Ø­Ø³Ø§Ø¨ Ú©Ø§Ø±Ø¨Ø±ÛŒ";
					
				$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
					
				$mail->MsgHTML($body);
					
				$address = $email;
				$mail->AddAddress($address, $firstname." ".$lastname);
					
					
				if(!$mail->Send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				}
			}
		}
	}
	else if($_GET["mode"] == 'confirm' && $askForActiovation)
	{
		$id = $_GET["id"];
		$query = mysql_query("UPDATE registerbykk SET state = '1' WHERE id='$id' ;", $db);
		if(!$query)
			echo mysql_error();
		else
		{
			$query = mysql_query("SELECT id, firstname, lastname, email FROM registerbykk WHERE id = '$id' ;", $db);
			if (!$query)
				die("Error reading query: ".mysql_error());
	
			if($row = mysql_fetch_row($query))
			{
				include('../../mail/class.phpmailer.php');
				include("../../mail/class.smtp.php");
	
				$firstname = $row[1];
				$lastname = $row[2];
				$email = $row[3];
	
				$mail = new PHPMailer();

				$body= '
				<div style="color:#999999;font-size:15px;direction:rtl;text-align:left;">
				Ø¨Ø§ Ø³Ù„Ø§Ù…'.$firstname.' '.$lastname.'<br>
				Ø§ÛŒÙ…ÛŒÙ„: '.$email.'<br>
				Ø­Ø³Ø§Ø¨ Ú©Ø§Ø±Ø¨Ø±ÛŒ Ø´Ù…Ø§ ØªØ§ÛŒÛŒØ¯ Ø´Ø¯!<br><span style="color:red;font-weight:bold;" >
				Ú©Ø¯ Ú©Ø§Ø±Ø¨Ø±ÛŒ: '.$row[0].'</span><br>
				Ø¨Ø§ ØªØ´Ú©Ø±
				</div>';
				
					
				$mail->IsSMTP(); // telling the class to use SMTP
				//$mail->Host       = "smtp.gmail.com"; // SMTP server
				$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
				// 1 = errors and messages
				// 2 = messages only
				$mail->ContentType = "text/html;charset=utf-8";
				$mail->CharSet = "UTF-8";
				$mail->SMTPAuth   = true;                  // enable SMTP authentication
				$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
				$mail->Host       = $emailHost;      // sets GMAIL as the SMTP server
				$mail->Port       = $emailPort;                   // set the SMTP port for the GMAIL server
				$mail->Username   = $emailUsername;  // GMAIL username
				$mail->Password   = $emailPassword;            // GMAIL password
				$mail->SetFrom($emailUsername, $emailName);
					
				// $mail->AddReplyTo("name@yourdomain.com","First Last");
					
				$mail->Subject    = "Ã˜ÂªÃ˜Â§Ã›Å’Ã›Å’Ã˜Â¯ Ã˜Â­Ã˜Â³Ã˜Â§Ã˜Â¨ ÃšÂ©Ã˜Â§Ã˜Â±Ã˜Â¨Ã˜Â±Ã›Å’";
					
				$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
					
				$mail->MsgHTML($body);
					
				$address = $email;
				$mail->AddAddress($address, $firstname." ".$lastname);
					
					
				if(!$mail->Send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				}
			}
		}
	}
	else if($_GET["mode"] == 'edit' || $_GET["mode"] == 'applyedit')
	{
		?>
		<div style="opacity:0;width: 100%;height: 100%;" id="index-loader">
		<?php
		if($_GET["mode"] == 'applyedit')
		{
			$id = $_POST["id"];
			
			$name = $_POST["uname"];
			$user_level = $_POST["user_level"];
			$cellphone = $_POST["ucellphone"];
			$country = $_POST["ucountry"];
			$iran_state = $_POST["uiran_state"];
			$description = $_POST["udescription"];
			$password = $_POST["upassword"];
			
			$uadmin = false;
			if($user_level == '7' || $user_level == '10')
				$uadmin = true;
			
			$toChangePass = '';
			if($_POST["uchange-password"] == '1')
			{
				if($password != "")
				{
					$md5_code = md5($password);
					$password = mysql_real_escape_string($password);
					$toChangePass = " , password = '$password', md5_code = '$md5_code' ";
				}
			}
			
			$query = mysql_query("UPDATE registerbykk SET name = '$name' , country = '$country' , iran_state = '$iran_state' , description = '$description' , user_level = '$user_level' , uadmin = '$uadmin' , ulaerror = '0' ".$toChangePass." WHERE id = '$id' ;", $db);
			
			if (!$query)
				die("<span class='register-alert green' >".mysql_error()."</span>");
			else
			{
				?>
				<div id="success_dialog" style="display: block;opacity:1;top: 40%;height: 60px;">
				<img alt="correct" src="../images/correct.png" style="float: right;position: relative;height: 60px;"/>
				<div style="font-size: 15px;color: #333;padding: 20px 5px;font-weight: bold;float:right;">تغییرات اعمال شد!</div>
				</div>
				<script type="text/javascript">
				$("#success_dialog").click(function(){
						$(this).remove();
					});
				setTimeout(function () {
					$("#success_dialog").animate({'opacity':'0.0'},300,function(){
						$("#success_dialog").remove();
					});
				},2000);
				</script>
				<?php
			}
			
			
		}
		if(isset($_GET['id']))
			$id = $_GET['id'];
		else
			$id = $_POST['id'];
		$query = mysql_query("SELECT * FROM registerbykk WHERE state != 0 AND email != 'designer' AND id = '$id' ORDER BY id DESC ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		if($mrow=mysql_fetch_row($query))
		{
			?>
			<script type="text/javascript">
			$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=member&id=<?php echo $id; ?>', function() {
				$("#page-nav").animate({'opacity':'1'}, 300);
				});
			</script>
			<div class="div-title">اصلاح اطلاعات عضو</div>
			<form action="index/member.php?mode=applyedit" method="POST" id="edituser_form" >
				<input type="hidden" name="id" value="<?php echo $mrow[0]; ?>">
				<div class="div-row" >
					<div class="input-div" >
						<div class="lable">ایمیل</div>
						<input type="text"  style="width: 400px;" class="textbykk" id="uemail" name="uemail" value="<?php echo $mrow[1]; ?>" disabled="disabled" >
					</div>
					<div class="input-div" style="position: relative;">
						<div class="lable">تلفن همراه</div>
						<div style="float: right;padding: 7px 0 5px 5px;font-size: 13px;position: absolute;bottom: 10px;right:33px;">+</div><input type="text"  style="width: 385px;padding-right: 20px;" class="textbykk" id="ucellphone" name="ucellphone" value="<?php echo $mrow[4]; ?>" disabled="disabled" >
					</div>
				</div>
				<div class="div-row" >
					<div class="input-div" >
						<div class="lable">نام</div>
						<input type="text"  style="width: 400px;" class="textbykk" id="uname" name="uname" value="<?php echo $mrow[3]; ?>">
					</div>
					<div class="input-div" >
						<div class="lable" ><span class="ued" >*</span>سطح عضو</div>
						<select class="textbykk" name="user_level" id="user_level" style="width: 412px;" >
							<option value="2" <?php if($mrow[9] == 2) echo "selected";?> >عادی</option>
							<option value="3" <?php if($mrow[9] == 3) echo "selected";?> >سطح 1</option>
							<option value="4" <?php if($mrow[9] == 4) echo "selected";?> >سطح 2</option>
							<option value="5" <?php if($mrow[9] == 5) echo "selected";?> >سطح 3</option>
							<option value="7" <?php if($mrow[9] == 7) echo "selected";?> >مدیر</option>
							<?php if($_SESSION["adminbykk"][0] == '99999') { ?><option value="10" <?php if($mrow[9] == 10) echo "selected";?> >مدیر ارشد</option><?php } ?>
						</select>
					</div>
				</div>
				<div class="div-row" >
					<div class="input-div">
						<div class="lable">کشور</div>
						<select class="textbykk" style="width: 412px;" id="ucountry" name="ucountry" > <option value="" selected="selected">Select Country</option><option value="Iran Islamic Republic of">Iran, Islamic Republic of</option> <option value="United States">United States</option> <option value="United Kingdom">United Kingdom</option> <option value="Afghanistan">Afghanistan</option> <option value="Albania">Albania</option> <option value="Algeria">Algeria</option> <option value="American Samoa">American Samoa</option> <option value="Andorra">Andorra</option> <option value="Angola">Angola</option> <option value="Anguilla">Anguilla</option> <option value="Antarctica">Antarctica</option> <option value="Antigua and Barbuda">Antigua and Barbuda</option> <option value="Argentina">Argentina</option> <option value="Armenia">Armenia</option> <option value="Aruba">Aruba</option> <option value="Australia">Australia</option> <option value="Austria">Austria</option> <option value="Azerbaijan">Azerbaijan</option> <option value="Bahamas">Bahamas</option> <option value="Bahrain">Bahrain</option> <option value="Bangladesh">Bangladesh</option> <option value="Barbados">Barbados</option> <option value="Belarus">Belarus</option> <option value="Belgium">Belgium</option> <option value="Belize">Belize</option> <option value="Benin">Benin</option> <option value="Bermuda">Bermuda</option> <option value="Bhutan">Bhutan</option> <option value="Bolivia">Bolivia</option> <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option> <option value="Botswana">Botswana</option> <option value="Bouvet Island">Bouvet Island</option> <option value="Brazil">Brazil</option> <option value="British Indian Ocean Territory">British Indian Ocean Territory</option> <option value="Brunei Darussalam">Brunei Darussalam</option> <option value="Bulgaria">Bulgaria</option> <option value="Burkina Faso">Burkina Faso</option> <option value="Burundi">Burundi</option> <option value="Cambodia">Cambodia</option> <option value="Cameroon">Cameroon</option> <option value="Canada">Canada</option> <option value="Cape Verde">Cape Verde</option> <option value="Cayman Islands">Cayman Islands</option> <option value="Central African Republic">Central African Republic</option> <option value="Chad">Chad</option> <option value="Chile">Chile</option> <option value="China">China</option> <option value="Christmas Island">Christmas Island</option> <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option> <option value="Colombia">Colombia</option> <option value="Comoros">Comoros</option> <option value="Congo">Congo</option> <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option> <option value="Cook Islands">Cook Islands</option> <option value="Costa Rica">Costa Rica</option> <option value="Cote D'ivoire">Cote D'ivoire</option> <option value="Croatia">Croatia</option> <option value="Cuba">Cuba</option> <option value="Cyprus">Cyprus</option> <option value="Czech Republic">Czech Republic</option> <option value="Denmark">Denmark</option> <option value="Djibouti">Djibouti</option> <option value="Dominica">Dominica</option> <option value="Dominican Republic">Dominican Republic</option> <option value="Ecuador">Ecuador</option> <option value="Egypt">Egypt</option> <option value="El Salvador">El Salvador</option> <option value="Equatorial Guinea">Equatorial Guinea</option> <option value="Eritrea">Eritrea</option> <option value="Estonia">Estonia</option> <option value="Ethiopia">Ethiopia</option> <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option> <option value="Faroe Islands">Faroe Islands</option> <option value="Fiji">Fiji</option> <option value="Finland">Finland</option> <option value="France">France</option> <option value="French Guiana">French Guiana</option> <option value="French Polynesia">French Polynesia</option> <option value="French Southern Territories">French Southern Territories</option> <option value="Gabon">Gabon</option> <option value="Gambia">Gambia</option> <option value="Georgia">Georgia</option> <option value="Germany">Germany</option> <option value="Ghana">Ghana</option> <option value="Gibraltar">Gibraltar</option> <option value="Greece">Greece</option> <option value="Greenland">Greenland</option> <option value="Grenada">Grenada</option> <option value="Guadeloupe">Guadeloupe</option> <option value="Guam">Guam</option> <option value="Guatemala">Guatemala</option> <option value="Guinea">Guinea</option> <option value="Guinea-bissau">Guinea-bissau</option> <option value="Guyana">Guyana</option> <option value="Haiti">Haiti</option> <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option> <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option> <option value="Honduras">Honduras</option> <option value="Hong Kong">Hong Kong</option> <option value="Hungary">Hungary</option> <option value="Iceland">Iceland</option> <option value="India">India</option> <option value="Indonesia">Indonesia</option> <option value="Iraq">Iraq</option> <option value="Ireland">Ireland</option> <option value="Israel">Israel</option> <option value="Italy">Italy</option> <option value="Jamaica">Jamaica</option> <option value="Japan">Japan</option> <option value="Jordan">Jordan</option> <option value="Kazakhstan">Kazakhstan</option> <option value="Kenya">Kenya</option> <option value="Kiribati">Kiribati</option> <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option> <option value="Korea, Republic of">Korea, Republic of</option> <option value="Kuwait">Kuwait</option> <option value="Kyrgyzstan">Kyrgyzstan</option> <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option> <option value="Latvia">Latvia</option> <option value="Lebanon">Lebanon</option> <option value="Lesotho">Lesotho</option> <option value="Liberia">Liberia</option> <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option> <option value="Liechtenstein">Liechtenstein</option> <option value="Lithuania">Lithuania</option> <option value="Luxembourg">Luxembourg</option> <option value="Macao">Macao</option> <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option> <option value="Madagascar">Madagascar</option> <option value="Malawi">Malawi</option> <option value="Malaysia">Malaysia</option> <option value="Maldives">Maldives</option> <option value="Mali">Mali</option> <option value="Malta">Malta</option> <option value="Marshall Islands">Marshall Islands</option> <option value="Martinique">Martinique</option> <option value="Mauritania">Mauritania</option> <option value="Mauritius">Mauritius</option> <option value="Mayotte">Mayotte</option> <option value="Mexico">Mexico</option> <option value="Micronesia, Federated States of">Micronesia, Federated States of</option> <option value="Moldova, Republic of">Moldova, Republic of</option> <option value="Monaco">Monaco</option> <option value="Mongolia">Mongolia</option> <option value="Montserrat">Montserrat</option> <option value="Morocco">Morocco</option> <option value="Mozambique">Mozambique</option> <option value="Myanmar">Myanmar</option> <option value="Namibia">Namibia</option> <option value="Nauru">Nauru</option> <option value="Nepal">Nepal</option> <option value="Netherlands">Netherlands</option> <option value="Netherlands Antilles">Netherlands Antilles</option> <option value="New Caledonia">New Caledonia</option> <option value="New Zealand">New Zealand</option> <option value="Nicaragua">Nicaragua</option> <option value="Niger">Niger</option> <option value="Nigeria">Nigeria</option> <option value="Niue">Niue</option> <option value="Norfolk Island">Norfolk Island</option> <option value="Northern Mariana Islands">Northern Mariana Islands</option> <option value="Norway">Norway</option> <option value="Oman">Oman</option> <option value="Pakistan">Pakistan</option> <option value="Palau">Palau</option> <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option> <option value="Panama">Panama</option> <option value="Papua New Guinea">Papua New Guinea</option> <option value="Paraguay">Paraguay</option> <option value="Peru">Peru</option> <option value="Philippines">Philippines</option> <option value="Pitcairn">Pitcairn</option> <option value="Poland">Poland</option> <option value="Portugal">Portugal</option> <option value="Puerto Rico">Puerto Rico</option> <option value="Qatar">Qatar</option> <option value="Reunion">Reunion</option> <option value="Romania">Romania</option> <option value="Russian Federation">Russian Federation</option> <option value="Rwanda">Rwanda</option> <option value="Saint Helena">Saint Helena</option> <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> <option value="Saint Lucia">Saint Lucia</option> <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option> <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option> <option value="Samoa">Samoa</option> <option value="San Marino">San Marino</option> <option value="Sao Tome and Principe">Sao Tome and Principe</option> <option value="Saudi Arabia">Saudi Arabia</option> <option value="Senegal">Senegal</option> <option value="Serbia and Montenegro">Serbia and Montenegro</option> <option value="Seychelles">Seychelles</option> <option value="Sierra Leone">Sierra Leone</option> <option value="Singapore">Singapore</option> <option value="Slovakia">Slovakia</option> <option value="Slovenia">Slovenia</option> <option value="Solomon Islands">Solomon Islands</option> <option value="Somalia">Somalia</option> <option value="South Africa">South Africa</option> <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option> <option value="Spain">Spain</option> <option value="Sri Lanka">Sri Lanka</option> <option value="Sudan">Sudan</option> <option value="Suriname">Suriname</option> <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option> <option value="Swaziland">Swaziland</option> <option value="Sweden">Sweden</option> <option value="Switzerland">Switzerland</option> <option value="Syrian Arab Republic">Syrian Arab Republic</option> <option value="Taiwan, Province of China">Taiwan, Province of China</option> <option value="Tajikistan">Tajikistan</option> <option value="Tanzania, United Republic of">Tanzania, United Republic of</option> <option value="Thailand">Thailand</option> <option value="Timor-leste">Timor-leste</option> <option value="Togo">Togo</option> <option value="Tokelau">Tokelau</option> <option value="Tonga">Tonga</option> <option value="Trinidad and Tobago">Trinidad and Tobago</option> <option value="Tunisia">Tunisia</option> <option value="Turkey">Turkey</option> <option value="Turkmenistan">Turkmenistan</option> <option value="Turks and Caicos Islands">Turks and Caicos Islands</option> <option value="Tuvalu">Tuvalu</option> <option value="Uganda">Uganda</option> <option value="Ukraine">Ukraine</option> <option value="United Arab Emirates">United Arab Emirates</option> <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option> <option value="Uruguay">Uruguay</option> <option value="Uzbekistan">Uzbekistan</option> <option value="Vanuatu">Vanuatu</option> <option value="Venezuela">Venezuela</option> <option value="Viet Nam">Viet Nam</option> <option value="Virgin Islands, British">Virgin Islands, British</option> <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option> <option value="Wallis and Futuna">Wallis and Futuna</option> <option value="Western Sahara">Western Sahara</option> <option value="Yemen">Yemen</option> <option value="Zambia">Zambia</option> <option value="Zimbabwe">Zimbabwe</option> </select>
					</div>
					<div class="input-div" style="visibility: hidden;" id="uiran_states">
						<div class="lable">استان - شهر</div>
						<select class="textbykk" style="width: 412px;" id="uiran_state" name="uiran_state" >
								<option value="" ></option>
								<option value="البرز" >البرز</option>
								<option value="آذربایجان شرقی" >آذربایجان شرقی</option>
								<option value="آذربایجان غربی" >آذربایجان غربی</option>
								<option value="اردبیل" >اردبیل</option>
								<option value="اصفهان" >اصفهان</option>
								<option value="ایلام" >ایلام</option>
								<option value="بوشهر" >بوشهر</option>
								<option value="تهران" >تهران</option>
								<option value="چهارمحال و بختیاری" >چهارمحال و بختیاری</option>
								<option value="خراسان جنوبی" >خراسان جنوبی</option>
								<option value="خراسان رضوی" >خراسان رضوی</option>
								<option value="خراسان شمالی" >خراسان شمالی</option>
								<option value="خوزستان" >خوزستان</option>
								<option value="زنجان" >زنجان</option>
								<option value="سمنان" >سمنان</option>
								<option value="سیستان و بلوچستان" >سیستان و بلوچستان</option>
								<option value="فارس" >فارس</option>
								<option value="قزوین" >قزوین</option>
								<option value="قم" >قم</option>
								<option value="کردستان" >کردستان</option>
								<option value="کرمان" >کرمان</option>
								<option value="کرمانشاه" >کرمانشاه</option>
								<option value="کهکیلویه و بویراحمد" >کهگیلویه و بویراحمد</option>
								<option value="گلستان" >گلستان</option>
								<option value="گیلان" >گیلان</option>
								<option value="لرستان" >لرستان</option>
								<option value="مازندران" >مازندران</option>
								<option value="مرکزی" >مرکزی</option>
								<option value="هرمزگان" >هرمزگان</option>
								<option value="همدان" >همدان</option>
								<option value="یزد" >یزد</option>
						</select>
					</div>
				</div>
				<div class="div-row">
					<div class="input-div" style="width: 845px;" >
						<div class="lable" >توضیح</div>
						<textarea class="textbykk" name="udescription" id="udescription" style="width: 840px;height: 75px;"><?php echo $mrow[7]; ?></textarea>
					</div>
				</div>
				<div class="div-row" >
					<div style="padding: 20px 25px 5px;float: right" id="uchange-pass">
							<input type="button" value="Change Password" style="width: 850px;" class="btnbykk" >
					</div>
					<div id="uchange-pass-container" style="display: none;" >
						<div class="input-div">
							<div class="lable">پسورد جدید <span style="color: red;font-size: 11px;display: none;float: left;" id="upass6minalert"> حداق 6 کاراکتر!</span></div>
							<input type="password"  style="width: 400px;" class="textbykk" id="upassword" name="upassword" value="">
							<input type="hidden" id="uchange-password" name="uchange-password" value="0" >
						</div>
						<div class="input-div">
							<div class="lable">تکرار پسورد جدید</div>
							<input type="password"  style="width: 400px;" class="textbykk" id="ucpassword" name="ucpassword"  value="">
						</div>
					</div>
				</div>
				<div class="div-row" >
					<div class="input-div" >
						<input type="submit" class="btnbykk" value="اعمال تغییرات/Unlock" style="width: 412px;">
					</div>
				</div>
			</form>
			<script>
			var uValidate = true, uPassValidate = false, uCPassValidate = false;
			function checkUCountry()
			{
				if($("#ucountry").val() == 'Iran Islamic Republic of')
				{
					$("#uiran_states").css({'visibility':'visible','opacity':'0'}).animate({'opacity':'1'},200,function(){
						$("#uiran_states").addClass("visible");
					});
				}
				else if($("#uiran_states").hasClass("visible"))
				{
					$("#uiran_states").animate({'opacity':'0'},200,function(){
						$(this).css({'visibility':'hidden'});
						$("#uiran_states").removeClass("visible");
					});
					$("#uiran_state option").filter(function(index) { return $(this).val() === ''; }).prop('selected', true);
				}
			}
			$("#ucountry").change(function(){
				checkUCountry();
			});
		
			function userPassCheck1()
			{
				if($("#upassword").val() == '')
				{
					$("#upassword").removeClass("green").removeClass("red");
					$("#upass6minalert").css({'display':'none'});
					uPassValidate = true;
				}
				else if($("#upassword").val().length < 6)
				{
					$("#upassword").removeClass("green").addClass("red");
					$("#upass6minalert").css({'display':'block'});
					uPassValidate = false;
				}
				else
				{
					$("#upassword").removeClass("red").addClass("green");
					$("#upass6minalert").css({'display':'none'});
					uPassValidate = true;
				}	
			}
			function userPassCheck2()
			{
				if($("#ucpassword").val() == '')
				{
					$("#ucpassword").removeClass("green").removeClass("red");
					uCPassValidate = true;
				}
				else if($("#upassword").val() != $("#ucpassword").val() || !uPassValidate)
				{
					$("#ucpassword").removeClass("green").addClass("red");
					uCPassValidate = false;
				}
				else
				{
					$("#ucpassword").removeClass("red").addClass("green");
					uCPassValidate = true;
				}	
			}
			$("#upassword").blur(function(){
		    	userPassCheck1();
		    });
		    $("#ucpassword").blur(function(){
		    	userPassCheck2();
		    });
			function userBeforeSend()
			{
				uValidate = true;
				userPassCheck1();
				userPassCheck2()
				if($("#uname").val().length < 3)
				{
					$("#uname").removeClass("green").addClass("red");
					uValidate = false;
				}
				else
				{
					$("#uname").removeClass("red").addClass("green");
				}	
				if(uValidate && uPassValidate && uCPassValidate)
				{
					return true;
					progressBar(300, 50);
				}
				else
					return false;
			}
			$('#edituser_form').ajaxForm({ 
		        target: '#main-index', 
		        success: function() { 
		        	progressBar(300, 100);
            		$('#index-loader').animate({'opacity':'1'},300);
		        },
		    	beforeSubmit: userBeforeSend
		    }); 
		    
		    
			$("#uchange-pass").click(function(){
				$("#uchange-pass-container").css({'display':'block'}).animate({'opacity':'1'},300);
				$("#uchange-pass").css({'display':'none'});
				$("#uchange-password").val("1");
			});
			setTimeout(function () {
				$("#ucountry option").filter(function(index) { return encodeURIComponent($(this).val()) === '<?php echo encodeURIComponent($mrow[5]); ?>'; }).prop('selected', true);
				setTimeout(function () {
					checkUCountry();
					$("#ucountry").trigger('click');
					setTimeout(function () {
						$("#uiran_state option").filter(function(index) { return encodeURIComponent($(this).val()) === '<?php echo encodeURIComponent($mrow[6]); ?>'; }).prop('selected', true);
						$("#uiran_state").trigger('click');
					},10);
				},100);
			},10);
			</script>
			<?php
		}
		?>
		</div>
		<?php
	}
	else
	{
	?>
	<script type="text/javascript">
	</script>
	<div id="delete_dialogM" title="حدف عضو" style="display: none;">
		<span class="ui-icon ui-icon-alert" style="float:right; margin:0 0 20px 7px;"></span>مطمن هستید؟
	</div>
	<div style="opacity:0;width: 100%;height: 100%;" id="index-loader">
		<div id="member-container">
			<div class="mheader">
				<span style="float: right;font-family: tahoma;font-size: 12px;color: #555;padding: 3px 0;margin-left: 5px;">جستجو: </span>
				<input type="text" id="msearch" style="float: right;width: 150px;font-size: 10px;" class="textbykk">
				<span style="float: left;margin: 0;padding: 2px;">
					<a href="index/exportexcel.php?i1=1&i2=1&i3=1&i4=1&im=1" target="_blank" id="export_excel" class="download" ><img alt="excel export" src="../images/excelexportbw.png" title="خروجی excel 2007 .xlsx" onmouseover="this.src='../images/excelexport.png'" onmouseout="this.src='../images/excelexportbw.png';"  style="margin-right: 10px;height: 25px;width: 25px;" /></a>
				</span>
				<span style="float: left;margin: 0;padding: 3px;">
					<input type="checkbox" id="inc_1" class="inc" checked="checked">عادی
					<input type="checkbox" id="inc_2" class="inc" checked="checked">سطح 1
					<input type="checkbox" id="inc_3" class="inc" checked="checked">سطح 2
					<input type="checkbox" id="inc_4" class="inc" checked="checked">سطح 3
					<input type="checkbox" id="inc_m" class="inc" checked="checked">مدیر
				</span>
			</div>
			<div style="height: 26px;width: 970px;padding: 1px 0px;position: relative;">
				<div style="height: 24px;width: 966px;padding: 0px;margin: 0px 2px 2px 2px;">
					<div class="member_field ftitle" style="width: 30px;" id="mnumber">
					#
					</div>
					<div class="member_field ftitle" style="width: 120px;cursor: pointer;">
						ایمیل
					</div>
					<div class="member_field ftitle">
						نام
					</div>
					<div class="member_field ftitle">
						تلفن همراه
					</div>
					<div class="member_field ftitle" style="width:120px;">
						کشور
					</div>
					<div class="member_field ftitle" >
						استان(فقط ایران)
					</div>
					<div class="member_field ftitle" style="width:75px;" >
						کد کاربری
					</div>
					<div class="member_field ftitle" style="width:75px;" >
						سطح کاربر
					</div>
					<div class="member_field ftitle" style="width:50px;" >
						زبان
					</div>
					<div class="member_field ftitle" style="cursor: default;" >
						کنترل
					</div>
					<div class="member_field ftitle" style="cursor: default;margin: 0;width: 98px;" id="mcontrol">
						توضیحات
					</div>
				</div>
			</div>
			<div id="member_field_container">
				<?php 
				if(isset($_GET["search"]))
					{
						$q = $_GET["search"];
						$q = mysql_real_escape_string($q);
						$search = "";
						$search.= "email REGEXP '$q' OR ";
						$search.= "name REGEXP '$q' OR ";
						$search.= "cellphone REGEXP '$q' OR ";
						$search.= "country REGEXP '$q' OR ";
						$search.= "iran_state REGEXP '$q'";
						$query = mysql_query("SELECT id, email, name, cellphone, country, iran_state, user_level, ulang, ulaerror, state, uadmin, date, time FROM registerbykk WHERE state != 0 AND email != 'designer' AND ( ".$search." ) ORDER BY uadmin DESC, state DESC, id DESC ;", $db);
					}
					else 
						$query = mysql_query("SELECT id, email, name, cellphone, country, iran_state, user_level, ulang, ulaerror, state, uadmin, date, time  FROM registerbykk WHERE state != 0 AND email != 'designer' ORDER BY uadmin DESC, state DESC, id DESC ;", $db);
					if (!$query)
						die("Error reading query: ".mysql_error());
					$i=0;
					$mnum = mysql_num_rows($query);
					while($mrows = mysql_fetch_row($query))
					{
						if($i >= ($mnum-1)){?><script type="text/javascript">moreMember = 0;</script> <?php }
						if($i > 49) break;
						$i++;
						
						$allowEdit = false;
						if($mrows[11] != 1  || $_SESSION["adminbykk"][0] == '99999' || $mrows[6] == '10' )
							$allowEit = true;
					?>
					<div class="field_tr <?php if($mrows[10] == 2) echo "red";?>" id="mf<?php echo $mrows[0];?>" >
						<div class="member_field <?php if($i%2 == 1) echo "fodd"; else echo "feven";?>" style="width: 27px;" <?php if($allowEit) { echo'onclick="mEdit('.$mrows[0].');"'; }?>>
							<?php echo $i;?>
						</div>
						<div class="member_field <?php if($i%2 == 1) echo "fodd"; else echo "feven";?>" style="width: 120px;direction: ltr;text-align: left;" <?php if($allowEit) { echo'onclick="mEdit('.$mrows[0].');"'; }?>>
							<?php echo $mrows[1];?>
						</div>
						<div class="member_field <?php if($i%2 == 1) echo "fodd"; else echo "feven";?>" <?php if($allowEit) { echo'onclick="mEdit('.$mrows[0].');"'; }?>>
							<?php echo $mrows[2];?>
						</div>
						<div class="member_field <?php if($i%2 == 1) echo "fodd"; else echo "feven";?>" <?php if($allowEit) { echo'onclick="mEdit('.$mrows[0].');"'; }?>>
							<?php echo "+".$mrows[3];?>
						</div>
						<div class="member_field <?php if($i%2 == 1) echo "fodd"; else echo "feven";?>" style="width: 120px;" <?php if($allowEit) { echo'onclick="mEdit('.$mrows[0].');"'; }?>>
							<?php echo $mrows[4];?>
						</div>
						<div class="member_field <?php if($i%2 == 1) echo "fodd"; else echo "feven";?>"style="text-align: right;direction: rtl;" <?php if($allowEit) { echo'onclick="mEdit('.$mrows[0].');"'; }?>>
							<?php echo $mrows[5];?>
						</div>
						<div class="member_field <?php if($i%2 == 1) echo "fodd"; else echo "feven";?>" <?php if($allowEit) { echo'onclick="mEdit('.$mrows[0].');"'; }?> style="width:75px;">
							<?php echo $mrows[0];?>
						</div>
						<div class="member_field <?php if($i%2 == 1) echo "fodd"; else echo "feven";?>" style="width: 75px;" <?php if($allowEit) { echo'onclick="mEdit('.$mrows[0].');"'; }?>>
							<?php 
							if($mrows[6] == '2') echo "عادی";
							if($mrows[6] == '3') echo "سطح 1";
							if($mrows[6] == '4') echo "سطح 2";
							if($mrows[6] == '5') echo "سطح 3";
							if($mrows[6] == '7') echo "مدیر";
							if($mrows[6] == '10') echo "مدیر ارشد";
							?>
						</div>
						<div class="member_field <?php if($i%2 == 1) echo "fodd"; else echo "feven";?>" <?php if($allowEit) { echo'onclick="mEdit('.$mrows[0].');"'; }?> style="width:50px;">
							<?php
							if($mrows[7] == 'en')
								echo "انگلیسی";
							else if($mrows[7] == 'fa')
								echo "فارسی";
							else if($mrows[7] == 'de')
								echo "المانی";
							else
								echo "Unknown";
							?>
						</div>
						<div class="member_field <?php if($i%2 == 1) echo "fodd"; else echo "feven";?>" style="cursor: default;padding-top: 0;height: 23px;">
							<div style="height: 20px;width: 90px;padding: 3px 10px 0 0;margin: 0px;float: right;">
								<?php 
								if($allowEit)
								{
								?>
								<img src="../images/wrongbw.png" title="حذف" onmouseover="this.src='../images/wrong.png';" onmouseout="this.src='../images/wrongbw.png';" style="float: right;margin: 0 0 0 10px;height: 20px;cursor: pointer;" onclick="delMember(<?php echo $mrows[0];?>);">
								<?php 
								}
								if($mrows[9] != 1)
								{
								?>
								<img src="../images/correctbw.png" title="تایید" onmouseover="this.src='../images/correct.png';" onmouseout="this.src='../images/correctbw.png';" style="float: right;margin: 0 0 0 10px;height: 20px;cursor: pointer;" onclick="confirmMember(this,<?php echo $mrows[0];?>);">
								<?php 
								}
								?>
							</div>
						</div>
						<div class="member_field <?php if($i%2 == 1) echo "fodd"; else echo "feven";?>"  style="width: 95px;margin: 0px;cursor: default;position: relative;" id="minfo" title="<?php echo "Register Time: ".$mrows[11]." ".$mrows[12]; ?>">
							<?php 
							if($mrows[9] == '2')
								echo 'ایمیل تایید نشده';
							else if($mrows[8] > 9)
								echo 'حسابکاربری قفل شده';
							else "&nbsp";
							?>
						</div>
					</div>
					<?php 
					}
					/*if($mnum > 16)
					{
						?>
						<script type="text/javascript">
						$("#mnumber").css({'width':'39px'});
						$("#mcontrol").css({'width':'83px'});
						</script>
						<?php 
					}
					else
					{
						?>
						<script type="text/javascript">
						$("#mnumber").css({'width':'27px'});
						$("#mcontrol").css({'width':'95px'});
						</script>
						<?php 
					}*/
				?>
			</div>
		</div>
	<style>
	.ui-autocomplete-loading {
		background: url('../images/ui-anim_basic_16x16.gif') right center no-repeat;
	}
	</style>
	<script type="text/javascript">
	$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=member', function() {
		$("#page-nav").animate({'opacity':'1'}, 300);
		});
	var mDelID = 0;
	var moreMember = 1, memberCount = 50;
	/*$(function() {*/
	$("#msearch").autocomplete({
		source: "index/msearch.php",
		minLength: 2
	});
	$("#delete_dialogM").dialog({
		autoOpen: false,
		resizable: false,
		height:130,
		modal: true,
		buttons: {
			"بله": function() {
				$("#mf"+mDelID+" #minfo").append("<div class='loader_bg' >&nbsp;</div>");
				$("#mf"+mDelID+" #minfo .loader_bg").animate({'opacity':'0.5'}, 300);
				$.get('index/member.php?mode=delete&id='+mDelID, function()
					{
						deleteMember(mDelID);
					});
				$( this ).dialog( "close" );
			},
			"خیر": function() {
				$( this ).dialog( "close" );
			}
		}
	});
	//});
	function delMember(id)
	{
		mDelID = id;
		$("#delete_dialogM").dialog("open");
	}
	function deleteMember(id) 
	{
		var myObject = $("#mf"+id);
		myObject.animate({'opacity':'0.0'},300,function (){
				myObject.animate({'height':'0px'},300,function (){
					myObject.remove();
				});
			});
	}
	function confirmMember(mobject, id) 
	{
		var mObject = $(mobject);
		$("#mf"+id+" #minfo").append("<div class='loader_bg' >&nbsp;</div>");
		$("#mf"+id+" #minfo .loader_bg").animate({'opacity':'0.5'}, 300);
		$.get('index/member.php?mode=confirm&id='+id, function()
			{
				mObject.parent("div").parent("div").parent("div").children("#minfo").empty().append("<span style='color:green;' >Confirmed</span>");
				mObject.parent("div").parent("div").parent("div").removeClass("red");
				$("#mf"+id+" #minfo .loader_bg").animate({'opacity':'0.0'}, 300, function (){
					$("#mf"+id+" #minfo .loader_bg").children(".loader_bg").remove();
				});
				mObject.animate({'opacity' : '0'},300, function(){
					mObject.remove();
				});
			});
	}
	function loadMemberField()
	{
		$("#member_field_container").mCustomScrollbar({
			set_width:false, /*optional element width: boolean, pixels, percentage*/
			set_height:false, /*optional element height: boolean, pixels, percentage*/
			horizontalScroll:false, /*scroll horizontally: boolean*/
			scrollInertia:950, /*scrolling inertia: integer (milliseconds)*/
			mouseWheel:true, /*mousewheel support: boolean*/
			mouseWheelPixels:200, /*mousewheel pixels amount: integer, "auto"*/
			autoDraggerLength:true, /*auto-adjust scrollbar dragger length: boolean*/
			autoHideScrollbar:true, /*auto-hide scrollbar when idle*/
			scrollButtons:{ /*scroll buttons*/
				enable:false, /*scroll buttons support: boolean*/
				scrollType:"continuous", /*scroll buttons scrolling type: "continuous", "pixels"*/
				scrollSpeed:"auto", /*scroll buttons continuous scrolling speed: integer, "auto"*/
				scrollAmount:40 
				},
			advanced:{
				updateOnBrowserResize:true, /*update scrollbars on browser resize (for layouts based on percentages): boolean*/
				updateOnContentResize:false, /*auto-update scrollbars on content resize (for dynamic content): boolean*/
				autoExpandHorizontalScroll:false, /*auto-expand width for horizontal scrolling: boolean*/
				autoScrollOnFocus:false, /*auto-scroll on focused elements: boolean*/
				normalizeMouseWheelDelta:false /*normalize mouse-wheel delta (-1/1)*/
			}, /*scroll buttons pixels scroll amount: integer (pixels)*/
			theme:"dark-2", /*"light", "dark", "light-2", "dark-2", "light-thick", "dark-thick", "light-thin", "dark-thin"*/
			callbacks:{
				onTotalScroll:function(){
					if(moreMember == 1)
					{
						$(".ajax-loader.main-index").fadeIn(100);
						var content, moreM;
						$.get('index/member.php?mode=showmore&limit='+(memberCount)+'|'+(memberCount+49), function(data){
						    content= data;
						    moreM=$("#member_field_container").find(".mCSB_container .field_tr:last");
						    moreM.after(content);
						    $("#member_field_container").mCustomScrollbar("update");
						    memberCount +=50;
						    $(".ajax-loader.main-index").fadeOut(100);
						});
					}
				}
			}
			});
	}
	function mEdit(id)
	{
		gotoPage('full',500,'index/member.php?mode=edit&id='+id);
	}
	function msearch(query)
	{
		var encodeQuery = encodeURIComponent(query);
		var i1=0, i2=0, i3=0, i4=0, im=0;
		if($("#inc_1").is(':checked'))
			i1 = 1;
		if($("#inc_2").is(':checked'))
			i2 = 1;
		if($("#inc_3").is(':checked'))
			i3 = 1;
		if($("#inc_4").is(':checked'))
			i4 = 1;
		if($("#inc_m").is(':checked'))
			im = 1;
		$("#member_field_container").animate({'opacity' : '0.0'}, 300);
		$("#member_field_container").load("index/member.php?mode=search&search="+encodeQuery, function(){
				$("#member_field_container").animate({'opacity' : '1'}, 300, function() {
					$("#export_excel").attr('href','index/exportexcel.php?i1='+i1+'&i2='+i2+'&i3='+i3+'&i4='+i4+'&im='+im+'&search='+encodeQuery);
					loadMemberField();
				});
			});
	}
	$(".inc").change(function(){
		var encodeQuery = encodeURIComponent($("#msearch").val());
		var i1=0, i2=0, i3=0, i4=0, im=0;
		if($("#inc_1").is(':checked'))
			i1 = 1;
		if($("#inc_2").is(':checked'))
			i2 = 1;
		if($("#inc_3").is(':checked'))
			i3 = 1;
		if($("#inc_4").is(':checked'))
			i4 = 1;
		if($("#inc_m").is(':checked'))
			im = 1;
		$("#export_excel").attr('href','index/exportexcel.php?i1='+i1+'&i2='+i2+'&i3='+i3+'&i4='+i4+'&im='+im+'&search='+encodeQuery);
	});
	$("#msearch").keypress(function(event) {
		if ( event.which == 13 ) 
		{
			var value = $("#msearch").val();
			event.preventDefault();
			msearch(value);
		}
	});
	$(document).ready(function(){
		loadMemberField();
	});
	</script>
	</div>
	<?php 
	}
}
?>