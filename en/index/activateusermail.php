<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="../css/stylesheet.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Activation</title>
</head>
<body>
<div id="success_dialog" style="opacity: 1;height: 60px;z-index: 300;background-color: rgba(200,200,200,0.9);">
<div style="width: 100%;height: 65px;text-align: center;direction: rtl;border:none;color: #888;font-size: 15px;font-weight: normal;vertical-align: center;">
<?php
include 'database.php';

if($_GET["mode"] == 'recoverpass')
{
	include('../../mail/class.phpmailer.php');
	include("../../mail/class.smtp.php");
	$email = $_GET["email"];
	$query = mysql_query("SELECT id, firstname, ulang, email FROM registerbykk WHERE email = '$email' ;", $db);
	if (!$query)
		die("Error reading query: ".mysql_error());
	if($row = mysql_fetch_row($query))
	{
		$id = $row[0];
		$firstname = $row[1];
		$lastname = "";
		$email = $row[3];
		$new_password = rand(1000000, 100000000);
		$md5_code = md5($new_password);
		
		$new_password = mysql_real_escape_string($new_password);
		
		$query = mysql_query("UPDATE registerbykk SET password = '$new_password', md5_code = '$md5_code'  WHERE id = '$id' ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		else
		{
			$mail = new PHPMailer();
			
			$body= '
			<div style="color:#999999;font-size:15px;direction:rtl;text-align:right;">
			Hi '.$firstname.'<br>
			Email: '.$email.'<br>
			New password: '.$new_password.'<br>
			Thank You.
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
			
			$mail->Subject    = "Password Recovery";
			
			$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
			
			$mail->MsgHTML($body);
			
			$address = $email;
			$mail->AddAddress($address, $firstname." ".$lastname);
			
			
			if(!$mail->Send()) {
				echo "Mailer Error: " . $mail->ErrorInfo;
			}
			else
			{
			?>
			<img alt="correct" src="../images/correct.png" style="float: right;position: relative;height: 60px;"/><br/>
			New Password Sent to Your Email.
			<?php
			}
		}
		
	}
}
?>
</div>
</div>
</body>
</html>