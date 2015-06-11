<?php
include 'database.php';
if(($_GET["mode"] == 'profile' || $_GET["mode"] == 'edit_profile') && $isLoggedIn)
{
	if($_SESSION["adminbykk"])
		$user_id = $_SESSION["adminbykk"][0];
	else
		$user_id = $_SESSION["userbykk"][0];
	
	if($_GET["mode"] == 'edit_profile')
	{
		$name = $_POST["rname"];
		$cellphone = $_POST["rcellphone"];
		$country = $_POST["rcountry"];
		$iran_state = $_POST["riran_state"];
		$description = $_POST["rdescription"];
		$password = $_POST["rpassword"];
		$ppassword = $_POST["ppassword"];
		
		$query = mysql_query("SELECT password FROM registerbykk WHERE id = '$user_id' ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		
		if($rows=mysql_fetch_row($query))
		{
			if($rows[0] == $ppassword)
			{
				$toChangePass = '';
				if($password != "")
				{
					$md5_code = md5($password);
					$password = mysql_real_escape_string($password);
					$toChangePass = " , password = '$password', md5_code = '$md5_code' ";
				}
				$query = mysql_query("UPDATE registerbykk SET name = '$name' , country = '$country' , iran_state = '$iran_state' , description = '$description' ".$toChangePass." WHERE id = '$user_id' ;", $db);
				if (!$query)
					die("<span class='register-alert green' >".mysql_error()."</span>");
				else
				{
					if($toChangePass == '')
						echo "<span class='register-alert green' >Your profile changed!</span>";
					else
						echo "<span class='register-alert green' >Your profile including password changed!</span>";
				}
				
			}
			else 
				echo "<span class='register-alert red' >Wrong password!</span>";
		}
	}
	
	$query = mysql_query("SELECT * FROM registerbykk WHERE id = '$user_id' ;", $db);
	if (!$query)
		die("Error reading query: ".mysql_error());
		
	if($rows=mysql_fetch_row($query))
	{
?>
	<form action="index/register.php?mode=edit_profile" method="POST" id="profile_form" >
		<div class="input-div" >
			<div class="lable">E-Mail</div>
			<input type="text"  style="width: 248px;" class="textbykk" id="remail" name="remail" value="<?php echo $rows[1]; ?>" disabled="disabled" >
		</div>
		<div class="input-div" style="position: relative;">
			<div class="lable">Handy</div>
			<div style="float: left;padding: 7px 5px 5px 0;font-size: 13px;position: absolute;bottom: 10px;left:33px;">+</div><input type="text"  style="width: 235px;padding-left: 20px;" class="textbykk" id="rcellphone" name="rcellphone" value="<?php echo $rows[4]; ?>" disabled="disabled" >
		</div>
		<div class="input-div" style="width: 80%;">
			<div class="lable">Name</div>
			<input type="text"  style="width: 248px;" class="textbykk" id="rname" name="rname" value="<?php echo $rows[3]; ?>">
		</div>
		<div class="input-div">
			<div class="lable">Staat</div>
			<select class="textbykk" style="width: 260px;" id="rcountry" name="rcountry" > <option value="" selected="selected">Select Country</option><option value="Iran Islamic Republic of">Iran, Islamic Republic of</option> <option value="United States">United States</option> <option value="United Kingdom">United Kingdom</option> <option value="Afghanistan">Afghanistan</option> <option value="Albania">Albania</option> <option value="Algeria">Algeria</option> <option value="American Samoa">American Samoa</option> <option value="Andorra">Andorra</option> <option value="Angola">Angola</option> <option value="Anguilla">Anguilla</option> <option value="Antarctica">Antarctica</option> <option value="Antigua and Barbuda">Antigua and Barbuda</option> <option value="Argentina">Argentina</option> <option value="Armenia">Armenia</option> <option value="Aruba">Aruba</option> <option value="Australia">Australia</option> <option value="Austria">Austria</option> <option value="Azerbaijan">Azerbaijan</option> <option value="Bahamas">Bahamas</option> <option value="Bahrain">Bahrain</option> <option value="Bangladesh">Bangladesh</option> <option value="Barbados">Barbados</option> <option value="Belarus">Belarus</option> <option value="Belgium">Belgium</option> <option value="Belize">Belize</option> <option value="Benin">Benin</option> <option value="Bermuda">Bermuda</option> <option value="Bhutan">Bhutan</option> <option value="Bolivia">Bolivia</option> <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option> <option value="Botswana">Botswana</option> <option value="Bouvet Island">Bouvet Island</option> <option value="Brazil">Brazil</option> <option value="British Indian Ocean Territory">British Indian Ocean Territory</option> <option value="Brunei Darussalam">Brunei Darussalam</option> <option value="Bulgaria">Bulgaria</option> <option value="Burkina Faso">Burkina Faso</option> <option value="Burundi">Burundi</option> <option value="Cambodia">Cambodia</option> <option value="Cameroon">Cameroon</option> <option value="Canada">Canada</option> <option value="Cape Verde">Cape Verde</option> <option value="Cayman Islands">Cayman Islands</option> <option value="Central African Republic">Central African Republic</option> <option value="Chad">Chad</option> <option value="Chile">Chile</option> <option value="China">China</option> <option value="Christmas Island">Christmas Island</option> <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option> <option value="Colombia">Colombia</option> <option value="Comoros">Comoros</option> <option value="Congo">Congo</option> <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option> <option value="Cook Islands">Cook Islands</option> <option value="Costa Rica">Costa Rica</option> <option value="Cote D'ivoire">Cote D'ivoire</option> <option value="Croatia">Croatia</option> <option value="Cuba">Cuba</option> <option value="Cyprus">Cyprus</option> <option value="Czech Republic">Czech Republic</option> <option value="Denmark">Denmark</option> <option value="Djibouti">Djibouti</option> <option value="Dominica">Dominica</option> <option value="Dominican Republic">Dominican Republic</option> <option value="Ecuador">Ecuador</option> <option value="Egypt">Egypt</option> <option value="El Salvador">El Salvador</option> <option value="Equatorial Guinea">Equatorial Guinea</option> <option value="Eritrea">Eritrea</option> <option value="Estonia">Estonia</option> <option value="Ethiopia">Ethiopia</option> <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option> <option value="Faroe Islands">Faroe Islands</option> <option value="Fiji">Fiji</option> <option value="Finland">Finland</option> <option value="France">France</option> <option value="French Guiana">French Guiana</option> <option value="French Polynesia">French Polynesia</option> <option value="French Southern Territories">French Southern Territories</option> <option value="Gabon">Gabon</option> <option value="Gambia">Gambia</option> <option value="Georgia">Georgia</option> <option value="Germany">Germany</option> <option value="Ghana">Ghana</option> <option value="Gibraltar">Gibraltar</option> <option value="Greece">Greece</option> <option value="Greenland">Greenland</option> <option value="Grenada">Grenada</option> <option value="Guadeloupe">Guadeloupe</option> <option value="Guam">Guam</option> <option value="Guatemala">Guatemala</option> <option value="Guinea">Guinea</option> <option value="Guinea-bissau">Guinea-bissau</option> <option value="Guyana">Guyana</option> <option value="Haiti">Haiti</option> <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option> <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option> <option value="Honduras">Honduras</option> <option value="Hong Kong">Hong Kong</option> <option value="Hungary">Hungary</option> <option value="Iceland">Iceland</option> <option value="India">India</option> <option value="Indonesia">Indonesia</option> <option value="Iraq">Iraq</option> <option value="Ireland">Ireland</option> <option value="Israel">Israel</option> <option value="Italy">Italy</option> <option value="Jamaica">Jamaica</option> <option value="Japan">Japan</option> <option value="Jordan">Jordan</option> <option value="Kazakhstan">Kazakhstan</option> <option value="Kenya">Kenya</option> <option value="Kiribati">Kiribati</option> <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option> <option value="Korea, Republic of">Korea, Republic of</option> <option value="Kuwait">Kuwait</option> <option value="Kyrgyzstan">Kyrgyzstan</option> <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option> <option value="Latvia">Latvia</option> <option value="Lebanon">Lebanon</option> <option value="Lesotho">Lesotho</option> <option value="Liberia">Liberia</option> <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option> <option value="Liechtenstein">Liechtenstein</option> <option value="Lithuania">Lithuania</option> <option value="Luxembourg">Luxembourg</option> <option value="Macao">Macao</option> <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option> <option value="Madagascar">Madagascar</option> <option value="Malawi">Malawi</option> <option value="Malaysia">Malaysia</option> <option value="Maldives">Maldives</option> <option value="Mali">Mali</option> <option value="Malta">Malta</option> <option value="Marshall Islands">Marshall Islands</option> <option value="Martinique">Martinique</option> <option value="Mauritania">Mauritania</option> <option value="Mauritius">Mauritius</option> <option value="Mayotte">Mayotte</option> <option value="Mexico">Mexico</option> <option value="Micronesia, Federated States of">Micronesia, Federated States of</option> <option value="Moldova, Republic of">Moldova, Republic of</option> <option value="Monaco">Monaco</option> <option value="Mongolia">Mongolia</option> <option value="Montserrat">Montserrat</option> <option value="Morocco">Morocco</option> <option value="Mozambique">Mozambique</option> <option value="Myanmar">Myanmar</option> <option value="Namibia">Namibia</option> <option value="Nauru">Nauru</option> <option value="Nepal">Nepal</option> <option value="Netherlands">Netherlands</option> <option value="Netherlands Antilles">Netherlands Antilles</option> <option value="New Caledonia">New Caledonia</option> <option value="New Zealand">New Zealand</option> <option value="Nicaragua">Nicaragua</option> <option value="Niger">Niger</option> <option value="Nigeria">Nigeria</option> <option value="Niue">Niue</option> <option value="Norfolk Island">Norfolk Island</option> <option value="Northern Mariana Islands">Northern Mariana Islands</option> <option value="Norway">Norway</option> <option value="Oman">Oman</option> <option value="Pakistan">Pakistan</option> <option value="Palau">Palau</option> <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option> <option value="Panama">Panama</option> <option value="Papua New Guinea">Papua New Guinea</option> <option value="Paraguay">Paraguay</option> <option value="Peru">Peru</option> <option value="Philippines">Philippines</option> <option value="Pitcairn">Pitcairn</option> <option value="Poland">Poland</option> <option value="Portugal">Portugal</option> <option value="Puerto Rico">Puerto Rico</option> <option value="Qatar">Qatar</option> <option value="Reunion">Reunion</option> <option value="Romania">Romania</option> <option value="Russian Federation">Russian Federation</option> <option value="Rwanda">Rwanda</option> <option value="Saint Helena">Saint Helena</option> <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> <option value="Saint Lucia">Saint Lucia</option> <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option> <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option> <option value="Samoa">Samoa</option> <option value="San Marino">San Marino</option> <option value="Sao Tome and Principe">Sao Tome and Principe</option> <option value="Saudi Arabia">Saudi Arabia</option> <option value="Senegal">Senegal</option> <option value="Serbia and Montenegro">Serbia and Montenegro</option> <option value="Seychelles">Seychelles</option> <option value="Sierra Leone">Sierra Leone</option> <option value="Singapore">Singapore</option> <option value="Slovakia">Slovakia</option> <option value="Slovenia">Slovenia</option> <option value="Solomon Islands">Solomon Islands</option> <option value="Somalia">Somalia</option> <option value="South Africa">South Africa</option> <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option> <option value="Spain">Spain</option> <option value="Sri Lanka">Sri Lanka</option> <option value="Sudan">Sudan</option> <option value="Suriname">Suriname</option> <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option> <option value="Swaziland">Swaziland</option> <option value="Sweden">Sweden</option> <option value="Switzerland">Switzerland</option> <option value="Syrian Arab Republic">Syrian Arab Republic</option> <option value="Taiwan, Province of China">Taiwan, Province of China</option> <option value="Tajikistan">Tajikistan</option> <option value="Tanzania, United Republic of">Tanzania, United Republic of</option> <option value="Thailand">Thailand</option> <option value="Timor-leste">Timor-leste</option> <option value="Togo">Togo</option> <option value="Tokelau">Tokelau</option> <option value="Tonga">Tonga</option> <option value="Trinidad and Tobago">Trinidad and Tobago</option> <option value="Tunisia">Tunisia</option> <option value="Turkey">Turkey</option> <option value="Turkmenistan">Turkmenistan</option> <option value="Turks and Caicos Islands">Turks and Caicos Islands</option> <option value="Tuvalu">Tuvalu</option> <option value="Uganda">Uganda</option> <option value="Ukraine">Ukraine</option> <option value="United Arab Emirates">United Arab Emirates</option> <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option> <option value="Uruguay">Uruguay</option> <option value="Uzbekistan">Uzbekistan</option> <option value="Vanuatu">Vanuatu</option> <option value="Venezuela">Venezuela</option> <option value="Viet Nam">Viet Nam</option> <option value="Virgin Islands, British">Virgin Islands, British</option> <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option> <option value="Wallis and Futuna">Wallis and Futuna</option> <option value="Western Sahara">Western Sahara</option> <option value="Yemen">Yemen</option> <option value="Zambia">Zambia</option> <option value="Zimbabwe">Zimbabwe</option> </select>
		</div>
		<div class="input-div" style="visibility: hidden;" id="iran_states">
			<div class="lable">Zustand</div>
			<select class="textbykk" style="width: 260px;" id="riran_state" name="riran_state" >
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
		<div class="input-div" style="width: 80%;height: 75px;">
			<div class="lable">Beschreibung</div>
			<textarea  style="width: 535px;height: 50px;" class="textbykk" id="rdescription" name="rdescription" ><?php echo $rows[7]; ?></textarea>
		</div>
		<div style="position: relative;width: 100%;overflow: hidden;float: left;">
			<div style="padding: 20px 25px 5px;float: left" id="change-pass">
					<input type="button" value="Passwort ändern" style="width: 545px;" class="btnbykk" >
			</div>
			<div id="change-pass-container" style="display: none;">
				<div class="input-div">
					<div class="lable">Neues Passwort<span style="color: red;font-size: 11px;display: none;float: right;" id="pass6minalert"> 6 characters min!</span></div>
					<input type="password"  style="width: 248px;" class="textbykk" id="rpassword" name="rpassword" value="">
				</div>
				<div class="input-div">
					<div class="lable">Neues Passwort Bestätigen</div>
					<input type="password"  style="width: 248px;" class="textbykk" id="rcpassword" name="rcpassword"  value="">
				</div>
			</div>
		</div>
		<div class="input-div">
			<div class="lable">Passwort</div>
			<input type="password"  style="width: 248px;" class="textbykk" id="ppassword" name="ppassword">
		</div>
		<div style="padding: 22px 25px 5px;float: left">
			<input type="submit" value="Zutreffen" style="width: 260px;" class="btnbykk" >
		</div>
	</form>
	<script>
	$("#profile-form").css({'height':'400px'});
	var rValidate = true, rPassValidate = false, rCPassValidate = false;
	function checkRCountry()
	{
		if($("#rcountry").val() == 'Iran Islamic Republic of')
		{
			$("#iran_states").css({'visibility':'visible','opacity':'0'}).animate({'opacity':'1'},200,function(){
				$("#iran_states").addClass("visible");
			});
		}
		else if($("#iran_states").hasClass("visible"))
		{
			$("#iran_states").animate({'opacity':'0'},200,function(){
				$(this).css({'visibility':'hidden'});
				$("#iran_states").removeClass("visible");
			});
			$("#riran_state option").filter(function(index) { return $(this).val() === ''; }).prop('selected', true);
		}
	}
	$("#rcountry").change(function(){
		checkRCountry();
	});

	function profilePassCheck1()
	{
		if($("#rpassword").val() == '')
		{
			$("#rpassword").removeClass("green").removeClass("red");
			$("#pass6minalert").css({'display':'none'});
			rPassValidate = true;
		}
		else if($("#rpassword").val().length < 6)
		{
			$("#rpassword").removeClass("green").addClass("red");
			$("#pass6minalert").css({'display':'block'});
			rPassValidate = false;
		}
		else
		{
			$("#rpassword").removeClass("red").addClass("green");
			$("#pass6minalert").css({'display':'none'});
			rPassValidate = true;
		}	
	}
	function profilePassCheck2()
	{
		if($("#rcpassword").val() == '')
		{
			$("#rcpassword").removeClass("green").removeClass("red");
			rCPassValidate = true;
		}
		else if($("#rpassword").val() != $("#rcpassword").val() || !rPassValidate)
		{
			$("#rcpassword").removeClass("green").addClass("red");
			rCPassValidate = false;
		}
		else
		{
			$("#rcpassword").removeClass("red").addClass("green");
			rCPassValidate = true;
		}	
	}
	$("#rpassword").blur(function(){
    	profilePassCheck1();
    });
    $("#rcpassword").blur(function(){
    	profilePassCheck2();
    });
	function profileBeforeSend()
	{
		rValidate = true;
		profilePassCheck1();
		profilePassCheck2()
		if($("#rname").val().length < 3)
		{
			$("#rname").removeClass("green").addClass("red");
			rValidate = false;
		}
		else
		{
			$("#rname").removeClass("red").addClass("green");
		}	
		
		if(rValidate && rPassValidate && rCPassValidate)
		{
			return true;
		}
		else
			return false;
	}
	$('#profile_form').ajaxForm({ 
        target: '#profile-form .ajax-index', 
        success: function() { 
        	//$(".ajax-loader.main-index").fadeOut(100);
        },
    	beforeSubmit: profileBeforeSend
    }); 
    
	$(".register-alert").click(function(){
	   	$(".register-alert").stop().animate({'opacity':'0'},300,function(){
	      	$(".register-alert").css({'display':'none'});
	    });
    });
    setTimeout(function(){
        $(".register-alert").stop().animate({'opacity':'0'},300,function(){
        	$(".register-alert").css({'display':'none'});
        });
    },3000);
    
	$("#change-pass").click(function(){
		$("#change-pass-container").css({'display':'block'}).animate({'opacity':'1'},300);
		$("#change-pass").css({'display':'none'});
	});
	setTimeout(function () {
		$("#rcountry option").filter(function(index) { return encodeURIComponent($(this).val()) === '<?php echo encodeURIComponent($rows[5]); ?>'; }).prop('selected', true);
		setTimeout(function () {
			checkRCountry();
			$("#rcountry").trigger('click');
			setTimeout(function () {
				$("#riran_state option").filter(function(index) { return encodeURIComponent($(this).val()) === '<?php echo encodeURIComponent($rows[6]); ?>'; }).prop('selected', true);
				$("#riran_state").trigger('click');
			},10);
		},100);
	},10);
	</script>
<?php
	}
}
else
{
	include('../../mail/class.phpmailer.php');
	include("../../mail/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded
	if($_GET["mode"] == 'add')
	{
		
		$captcha = $_POST["rcaptcha"];
		$email = $_POST["remail"];
		$cemail = $_POST["rcemail"];
		$name = $_POST["rname"];
		$cellphone = $_POST["rcellphone"];
		$country = $_POST["rcountry"];
		$iran_state = $_POST["riran_state"];
		$password = $_POST["rpassword"];
		$cpassword = $_POST["rcpassword"];
		
		if($captcha == $_SESSION['security_number'])
		{
			$email = strtolower($email);
			$email = explode(' ',$email);
			$email = implode('', $email);
			
			$query = mysql_query("SELECT id FROM registerbykk WHERE email = '$email' ;", $db);
			if( $rows=mysql_fetch_row($query) )
			{
				echo "<span class='register-alert red' >This email has been registered before!</span>";
			}
			else 
			{
				$query = mysql_query("SELECT id FROM registerbykk WHERE cellphone = '$cellphone' ;", $db);
				if( $rows=mysql_fetch_row($query) )
				{
					echo "<span class='register-alert red' >This cellphone has been registered before!</span>";
				}
				else
				{
					include 'jdf.php';
					
					$query = mysql_query("SELECT id FROM registerbykk ORDER BY id  DESC ;", $db);
					if (!$query)
						die("Error reading query: ".mysql_error());
					
					if( $rows=mysql_fetch_row($query) )
						$id = $rows[0] + 1;
					else
						$id = 100000;
					
					$md5_code = md5($password);
					$password = mysql_real_escape_string($password);
					
					$date=date("F d Y");
					$time = date("G:i");
					$jdate=jdate('j F Y');
					$jtime = jdate("G:i");
					
					$sql = "INSERT INTO `registerbykk` (`id`, `email`, `password`, `name`, `cellphone`, `country`, `iran_state`, `description`, 
					`md5_code`, `user_level`, `uadmin`, `ulogout`, `ulaerror`, `ulang`, `date`, `time`, `jdate`, `jtime`, `state` )
					VALUES ( '$id', '$email', '$password', '$name', '$cellphone', '$country', '$iran_state', '', 
					'$md5_code', '2', '0', '0', '0', '".$sitelang."','$date', '$time', '$jdate', '$jtime', '1');";
					
					$result = mysql_query($sql,$db);
					
					if(!$result)
					{
						echo "<span class='register-alert red' >".mysql_error()."</span>";
					}
					else
					{
						/*
						$mail = new PHPMailer();
							
						$body= '
						<div style="color:#999999;font-size:15px;direction:rtl;text-align:right;">
						Ã˜Â³Ã™â€žÃ˜Â§Ã™â€¦ '.$firstname.' '.$lastname.'<br>
						Ã˜Â¨Ã˜Â±Ã˜Â§Ã›Å’ Ã˜ÂªÃ˜Â§Ã›Å’Ã›Å’Ã˜Â¯ Ã˜Â§Ã›Å’Ã™â€¦Ã›Å’Ã™â€ž Ã˜Â®Ã™Ë†Ã˜Â¯ Ã™Ë†Ã˜Â§Ã˜Â±Ã˜Â¯ Ã™â€žÃ›Å’Ã™â€ ÃšÂ© Ã˜Â²Ã›Å’Ã˜Â± Ã˜Â´Ã™Ë†Ã›Å’Ã˜Â¯<br>
						<a href="'.$hosturi.'/index/activeusermail.php?id='.$id.'&activate_code='.$activate_code.'&email='.$email.'" target="_blank" style="font-weight:bold;color:red;">'.$hosturi.'/index/activeusermail?id='.$id.'&activate_code='.$activate_code.'&email='.$email.'</a><br>
						Ã˜Â¨Ã˜Â§Ã˜ÂªÃ˜Â´ÃšÂ©Ã˜Â±.
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
							
						$mail->Subject    = "Ã™â€žÃ›Å’Ã™â€ ÃšÂ© Ã˜ÂªÃ˜Â§Ã›Å’Ã›Å’Ã˜Â¯ Ã˜Â§Ã›Å’Ã™â€¦Ã›Å’Ã™â€ž";
							
						$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
							
						$mail->MsgHTML($body);
							
						$address = $email;
						$mail->AddAddress($address, $firstname." ".$lastname);
							
							
						if(!$mail->Send()) {
						}*/
						echo "<span class='register-alert green' >You successfuly registered!</span>";
					}
				}
			}
		}
		else
			echo "<span class='register-alert red' >Wrong captcha</span>";
	}
	$_SESSION['security_number']=rand(10000,99999);
	?>
	<form action="index/register.php?mode=add" method="POST" id="register_form" >
		<div class="input-div" >
			<div class="lable">E-Mail</div>
			<input type="text"  style="width: 248px;" class="textbykk" id="remail" name="remail" value="<?php echo $email; ?>" >
		</div>
		<div class="input-div">
			<div class="lable">E-Mail Bestätigen</div>
			<input type="text"  style="width: 248px;" class="textbykk" id="rcemail" name="rcemail" value="<?php echo $cemail; ?>" >
		</div>
		<div class="input-div">
			<div class="lable">Name</div>
			<input type="text"  style="width: 248px;" class="textbykk" id="rname" name="rname" value="<?php echo $name; ?>">
		</div>
		<div class="input-div" style="position: relative;">
			<div class="lable">Handy</div>
			<div style="float: left;padding: 7px 5px 5px 0;font-size: 13px;position: absolute;bottom: 10px;left:33px;">+</div><input type="text"  style="width: 235px;padding-left: 20px;" class="textbykk" id="rcellphone" name="rcellphone" value="<?php echo $cellphone; ?>" >
		</div>
		<div class="input-div">
			<div class="lable">Staat</div>
			<select class="textbykk" style="width: 260px;" id="rcountry" name="rcountry" > <option value="" selected="selected">Select Country</option><option value="Iran Islamic Republic of">Iran, Islamic Republic of</option> <option value="United States">United States</option> <option value="United Kingdom">United Kingdom</option> <option value="Afghanistan">Afghanistan</option> <option value="Albania">Albania</option> <option value="Algeria">Algeria</option> <option value="American Samoa">American Samoa</option> <option value="Andorra">Andorra</option> <option value="Angola">Angola</option> <option value="Anguilla">Anguilla</option> <option value="Antarctica">Antarctica</option> <option value="Antigua and Barbuda">Antigua and Barbuda</option> <option value="Argentina">Argentina</option> <option value="Armenia">Armenia</option> <option value="Aruba">Aruba</option> <option value="Australia">Australia</option> <option value="Austria">Austria</option> <option value="Azerbaijan">Azerbaijan</option> <option value="Bahamas">Bahamas</option> <option value="Bahrain">Bahrain</option> <option value="Bangladesh">Bangladesh</option> <option value="Barbados">Barbados</option> <option value="Belarus">Belarus</option> <option value="Belgium">Belgium</option> <option value="Belize">Belize</option> <option value="Benin">Benin</option> <option value="Bermuda">Bermuda</option> <option value="Bhutan">Bhutan</option> <option value="Bolivia">Bolivia</option> <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option> <option value="Botswana">Botswana</option> <option value="Bouvet Island">Bouvet Island</option> <option value="Brazil">Brazil</option> <option value="British Indian Ocean Territory">British Indian Ocean Territory</option> <option value="Brunei Darussalam">Brunei Darussalam</option> <option value="Bulgaria">Bulgaria</option> <option value="Burkina Faso">Burkina Faso</option> <option value="Burundi">Burundi</option> <option value="Cambodia">Cambodia</option> <option value="Cameroon">Cameroon</option> <option value="Canada">Canada</option> <option value="Cape Verde">Cape Verde</option> <option value="Cayman Islands">Cayman Islands</option> <option value="Central African Republic">Central African Republic</option> <option value="Chad">Chad</option> <option value="Chile">Chile</option> <option value="China">China</option> <option value="Christmas Island">Christmas Island</option> <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option> <option value="Colombia">Colombia</option> <option value="Comoros">Comoros</option> <option value="Congo">Congo</option> <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option> <option value="Cook Islands">Cook Islands</option> <option value="Costa Rica">Costa Rica</option> <option value="Cote D'ivoire">Cote D'ivoire</option> <option value="Croatia">Croatia</option> <option value="Cuba">Cuba</option> <option value="Cyprus">Cyprus</option> <option value="Czech Republic">Czech Republic</option> <option value="Denmark">Denmark</option> <option value="Djibouti">Djibouti</option> <option value="Dominica">Dominica</option> <option value="Dominican Republic">Dominican Republic</option> <option value="Ecuador">Ecuador</option> <option value="Egypt">Egypt</option> <option value="El Salvador">El Salvador</option> <option value="Equatorial Guinea">Equatorial Guinea</option> <option value="Eritrea">Eritrea</option> <option value="Estonia">Estonia</option> <option value="Ethiopia">Ethiopia</option> <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option> <option value="Faroe Islands">Faroe Islands</option> <option value="Fiji">Fiji</option> <option value="Finland">Finland</option> <option value="France">France</option> <option value="French Guiana">French Guiana</option> <option value="French Polynesia">French Polynesia</option> <option value="French Southern Territories">French Southern Territories</option> <option value="Gabon">Gabon</option> <option value="Gambia">Gambia</option> <option value="Georgia">Georgia</option> <option value="Germany">Germany</option> <option value="Ghana">Ghana</option> <option value="Gibraltar">Gibraltar</option> <option value="Greece">Greece</option> <option value="Greenland">Greenland</option> <option value="Grenada">Grenada</option> <option value="Guadeloupe">Guadeloupe</option> <option value="Guam">Guam</option> <option value="Guatemala">Guatemala</option> <option value="Guinea">Guinea</option> <option value="Guinea-bissau">Guinea-bissau</option> <option value="Guyana">Guyana</option> <option value="Haiti">Haiti</option> <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option> <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option> <option value="Honduras">Honduras</option> <option value="Hong Kong">Hong Kong</option> <option value="Hungary">Hungary</option> <option value="Iceland">Iceland</option> <option value="India">India</option> <option value="Indonesia">Indonesia</option> <option value="Iraq">Iraq</option> <option value="Ireland">Ireland</option> <option value="Israel">Israel</option> <option value="Italy">Italy</option> <option value="Jamaica">Jamaica</option> <option value="Japan">Japan</option> <option value="Jordan">Jordan</option> <option value="Kazakhstan">Kazakhstan</option> <option value="Kenya">Kenya</option> <option value="Kiribati">Kiribati</option> <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option> <option value="Korea, Republic of">Korea, Republic of</option> <option value="Kuwait">Kuwait</option> <option value="Kyrgyzstan">Kyrgyzstan</option> <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option> <option value="Latvia">Latvia</option> <option value="Lebanon">Lebanon</option> <option value="Lesotho">Lesotho</option> <option value="Liberia">Liberia</option> <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option> <option value="Liechtenstein">Liechtenstein</option> <option value="Lithuania">Lithuania</option> <option value="Luxembourg">Luxembourg</option> <option value="Macao">Macao</option> <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option> <option value="Madagascar">Madagascar</option> <option value="Malawi">Malawi</option> <option value="Malaysia">Malaysia</option> <option value="Maldives">Maldives</option> <option value="Mali">Mali</option> <option value="Malta">Malta</option> <option value="Marshall Islands">Marshall Islands</option> <option value="Martinique">Martinique</option> <option value="Mauritania">Mauritania</option> <option value="Mauritius">Mauritius</option> <option value="Mayotte">Mayotte</option> <option value="Mexico">Mexico</option> <option value="Micronesia, Federated States of">Micronesia, Federated States of</option> <option value="Moldova, Republic of">Moldova, Republic of</option> <option value="Monaco">Monaco</option> <option value="Mongolia">Mongolia</option> <option value="Montserrat">Montserrat</option> <option value="Morocco">Morocco</option> <option value="Mozambique">Mozambique</option> <option value="Myanmar">Myanmar</option> <option value="Namibia">Namibia</option> <option value="Nauru">Nauru</option> <option value="Nepal">Nepal</option> <option value="Netherlands">Netherlands</option> <option value="Netherlands Antilles">Netherlands Antilles</option> <option value="New Caledonia">New Caledonia</option> <option value="New Zealand">New Zealand</option> <option value="Nicaragua">Nicaragua</option> <option value="Niger">Niger</option> <option value="Nigeria">Nigeria</option> <option value="Niue">Niue</option> <option value="Norfolk Island">Norfolk Island</option> <option value="Northern Mariana Islands">Northern Mariana Islands</option> <option value="Norway">Norway</option> <option value="Oman">Oman</option> <option value="Pakistan">Pakistan</option> <option value="Palau">Palau</option> <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option> <option value="Panama">Panama</option> <option value="Papua New Guinea">Papua New Guinea</option> <option value="Paraguay">Paraguay</option> <option value="Peru">Peru</option> <option value="Philippines">Philippines</option> <option value="Pitcairn">Pitcairn</option> <option value="Poland">Poland</option> <option value="Portugal">Portugal</option> <option value="Puerto Rico">Puerto Rico</option> <option value="Qatar">Qatar</option> <option value="Reunion">Reunion</option> <option value="Romania">Romania</option> <option value="Russian Federation">Russian Federation</option> <option value="Rwanda">Rwanda</option> <option value="Saint Helena">Saint Helena</option> <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> <option value="Saint Lucia">Saint Lucia</option> <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option> <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option> <option value="Samoa">Samoa</option> <option value="San Marino">San Marino</option> <option value="Sao Tome and Principe">Sao Tome and Principe</option> <option value="Saudi Arabia">Saudi Arabia</option> <option value="Senegal">Senegal</option> <option value="Serbia and Montenegro">Serbia and Montenegro</option> <option value="Seychelles">Seychelles</option> <option value="Sierra Leone">Sierra Leone</option> <option value="Singapore">Singapore</option> <option value="Slovakia">Slovakia</option> <option value="Slovenia">Slovenia</option> <option value="Solomon Islands">Solomon Islands</option> <option value="Somalia">Somalia</option> <option value="South Africa">South Africa</option> <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option> <option value="Spain">Spain</option> <option value="Sri Lanka">Sri Lanka</option> <option value="Sudan">Sudan</option> <option value="Suriname">Suriname</option> <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option> <option value="Swaziland">Swaziland</option> <option value="Sweden">Sweden</option> <option value="Switzerland">Switzerland</option> <option value="Syrian Arab Republic">Syrian Arab Republic</option> <option value="Taiwan, Province of China">Taiwan, Province of China</option> <option value="Tajikistan">Tajikistan</option> <option value="Tanzania, United Republic of">Tanzania, United Republic of</option> <option value="Thailand">Thailand</option> <option value="Timor-leste">Timor-leste</option> <option value="Togo">Togo</option> <option value="Tokelau">Tokelau</option> <option value="Tonga">Tonga</option> <option value="Trinidad and Tobago">Trinidad and Tobago</option> <option value="Tunisia">Tunisia</option> <option value="Turkey">Turkey</option> <option value="Turkmenistan">Turkmenistan</option> <option value="Turks and Caicos Islands">Turks and Caicos Islands</option> <option value="Tuvalu">Tuvalu</option> <option value="Uganda">Uganda</option> <option value="Ukraine">Ukraine</option> <option value="United Arab Emirates">United Arab Emirates</option> <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option> <option value="Uruguay">Uruguay</option> <option value="Uzbekistan">Uzbekistan</option> <option value="Vanuatu">Vanuatu</option> <option value="Venezuela">Venezuela</option> <option value="Viet Nam">Viet Nam</option> <option value="Virgin Islands, British">Virgin Islands, British</option> <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option> <option value="Wallis and Futuna">Wallis and Futuna</option> <option value="Western Sahara">Western Sahara</option> <option value="Yemen">Yemen</option> <option value="Zambia">Zambia</option> <option value="Zimbabwe">Zimbabwe</option> </select>
		</div>
		<div class="input-div" style="visibility: hidden;" id="iran_states">
			<div class="lable">Zustand</div>
			<select class="textbykk" style="width: 260px;" id="riran_state" name="riran_state" >
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
		<div class="input-div">
			<div class="lable">Passwort <span style="color: red;font-size: 11px;display: none;float: right;" id="pass6minalert"> 6 characters min!</span></div>
			<input type="password"  style="width: 248px;" class="textbykk" id="rpassword" name="rpassword">
		</div>
		<div class="input-div">
			<div class="lable">Passwort Bestätigen</div>
			<input type="password"  style="width: 248px;" class="textbykk" id="rcpassword" name="rcpassword">
		</div>
		<div class="input-div" style="position: relative;">
			<div class="lable">Captcha</div>
			<input type="text" style="width: 248px;height: 15px;" class="textbykk" id="rcaptcha" name="rcaptcha" >
			<img src="index/captchaimage.php" id="signup-captcha" title="click to refresh" onclick="this.src='index/captchaimage.php?do='+Math.random();" >
		</div>
		<div style="padding: 20px 25px 5px;float: left">
			<input type="submit" value="Registrieren" style="width: 260px;" class="btnbykk" >
		</div>
	</form>
	<script type="text/javascript">
	var rValidate = true, rEmailValidate = false, rCEmailValidate = false, rPassValidate = false, rCPassValidate = false;
	function checkRCountry()
	{
		if($("#rcountry").val() == 'Iran Islamic Republic of')
		{
			$("#iran_states").css({'visibility':'visible','opacity':'0'}).animate({'opacity':'1'},200,function(){
				$("#iran_states").addClass("visible");
			});
		}
		else if($("#iran_states").hasClass("visible"))
		{
			$("#iran_states").animate({'opacity':'0'},200,function(){
				$(this).css({'visibility':'hidden'});
				$("#iran_states").removeClass("visible");
			});
		}
	}
	$("#rcountry").change(function(){
		checkRCountry();
	});
	function registerEmialCheck1()
	{
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		if(!re.test($("#remail").val()))
		{
			$("#remail").removeClass("green").addClass("red");
			rEmailValidate = false;
		}
		else
		{
			$("#remail").removeClass("red").addClass("green");
			rEmailValidate = true;
		}	
	}
	function registerEmialCheck2()
	{
		if($("#remail").val() != $("#rcemail").val() || !rEmailValidate)
		{
			$("#rcemail").removeClass("green").addClass("red");
			rCEmailValidate = false;
		}
		else
		{
			$("#rcemail").removeClass("red").addClass("green");
			rCEmailValidate = true;
		}	
	}
	function registerPassCheck1()
	{
		if($("#rpassword").val().length < 6)
		{
			$("#rpassword").removeClass("green").addClass("red");
			$("#pass6minalert").css({'display':'block'});
			rPassValidate = false;
		}
		else
		{
			$("#rpassword").removeClass("red").addClass("green");
			$("#pass6minalert").css({'display':'none'});
			rPassValidate = true;
		}	
	}
	function registerPassCheck2()
	{
		if($("#rpassword").val() != $("#rcpassword").val() || !rPassValidate)
		{
			$("#rcpassword").removeClass("green").addClass("red");
			rCPassValidate = false;
		}
		else
		{
			$("#rcpassword").removeClass("red").addClass("green");
			rCPassValidate = true;
		}	
	}
	function registerBeforeSend()
	{
		rValidate = true;
		registerEmialCheck1();
		registerEmialCheck2();
		registerPassCheck1();
		registerPassCheck2()
		if($("#rname").val().length < 3)
		{
			$("#rname").removeClass("green").addClass("red");
			rValidate = false;
		}
		else
		{
			$("#rname").removeClass("red").addClass("green");
		}	
	
		if($("#rcellphone").val().match(/\D/) || $("#rcellphone").val().length < 10)
		{
			$("#rcellphone").removeClass("green").addClass("red");
			rValidate = false;
		}
		else
		{
			$("#rcellphone").removeClass("red").addClass("green");
		}
	
		if($("#rcountry").val() == '')
		{
			$("#rcountry").removeClass("green").addClass("red");
			rValidate = false;
		}
		else
		{
			$("#rcountry").removeClass("red").addClass("green");
			if($("#riran_state").val() == '' && $("#rcountry").val() == 'Iran Islamic Republic of')
			{
				$("#riran_state").removeClass("green").addClass("red");
				rValidate = false;
			}
			else
			{
				$("#riran_state").removeClass("red").addClass("green");
			}
		}
	
		if($("#rcaptcha").val().length < 5)
		{
			$("#rcaptcha").removeClass("green").addClass("red");
			rValidate = false;
		}
		else
		{
			$("#rcaptcha").removeClass("red").addClass("green");
		}
		
		if(rValidate && rEmailValidate && rCEmailValidate && rPassValidate && rCPassValidate)
		{
			return true;
		}
		else
			return false;
		
	}
    $('#register_form').ajaxForm({ 
        target: '#signup-form .ajax-index', 
        success: function() { 
        	//$(".ajax-loader.main-index").fadeOut(100);
        },
    	beforeSubmit: registerBeforeSend
    }); 
    $(".register-alert").click(function(){
	   	$(".register-alert").stop().animate({'opacity':'0'},300,function(){
	      	$(".register-alert").css({'display':'none'});
	    });
    });
    setTimeout(function(){
        $(".register-alert").stop().animate({'opacity':'0'},300,function(){
        	$(".register-alert").css({'display':'none'});
        });
    },3000);

    $("#remail").blur(function(){
    	registerEmialCheck1();
    });
    $("#rcemail").blur(function(){
    	registerEmialCheck2();
    });
    $("#rpassword").blur(function(){
    	registerPassCheck1();
    });
    $("#rcpassword").blur(function(){
    	registerPassCheck2();
    });
	
	<?php 
	if(isset($_POST["rcountry"]))
	{
	?>
	    setTimeout(function () {
			$("#rcountry option").filter(function(index) { return encodeURIComponent($(this).val()) === '<?php echo encodeURIComponent($country); ?>'; }).prop('selected', true);
			setTimeout(function () {
				checkRCountry();
				$("#rcountry").trigger('click');
				setTimeout(function () {
					$("#riran_state option").filter(function(index) { return encodeURIComponent($(this).val()) === '<?php echo encodeURIComponent($iran_state); ?>'; }).prop('selected', true);
					$("#riran_state").trigger('click');
				},10);
			},100);
		},10);
	<?php 
	}
	?>
	</script>
<?php 
}
?>