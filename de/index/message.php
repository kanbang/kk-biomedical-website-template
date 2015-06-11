<?php
include 'database.php';
if($isAdmin)
{
	if($_GET["mode"] == 'delete')
	{
		$id = $_GET['id'];
		$query = mysql_query("UPDATE messagebykk SET state = '0' WHERE id='$id' ;", $db);
		if(!$query)
			echo mysql_error();
	}
	if($_GET["mode"] == 'reply')
	{
		$id = $_GET['id'];
		$text = $_GET['text'];
		$text = explode("\n", $text);
		$text = implode('<br>', $text);
		$text = mysql_real_escape_string($text);
		
		$query = mysql_query("UPDATE messagebykk SET mreply = '$text' WHERE id='$id' ;", $db);
		if(!$query)
			echo mysql_error();
		
		else
		{
			$query = mysql_query("SELECT email, name, message, mreply, mlang FROM messagebykk WHERE id = '$id' AND state = 1 ;", $db);
			if($row=mysql_fetch_row($query))
			{
				include('../../mail/class.phpmailer.php');
				include("../../mail/class.smtp.php");
		
				$name = $row[1];
				$email = $row[0];
		
				$mail = new PHPMailer();
					
				if($row[4] == 'fa')
				{
					$body= '
					<div style="color:#999999;font-size:15px;direction:rtl;text-align:right;">
					سلام '.$name.'<br>
					ایمیل: '.$email.'<br><br>
					<b>پبام شما:</b><br>
					'.$row[2].'<br><br>
					<b>پاسخ:</b><br>
					'.$row[3].'<br><br>
					باتشکر.
					</div>';
				}
				else 
				{
					$body= '
					<div style="color:#999999;font-size:15px;direction:ltr;text-align:left;">
					Dear '.$name.'<br>
					Email: '.$email.'<br><br>
					<b>Your message:</b><br>
					'.$row[2].'<br><br>
					<b>Admin reply:</b><br>
					'.$row[3].'<br><br>
					Thank You.
					</div>';
				}
					
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
					
				if($row[4] == 'fa')
				{
					$mail->Subject    = "پاسخ پیام";
				}
				else
				{
					$mail->Subject    = "Admin replyed your message";
				}
					
				$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
					
				$mail->MsgHTML($body);
					
				$address = $email;
				$mail->AddAddress($address, $name);
					
				if(!$mail->Send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
					?>
					<textarea class="textbykk" style="width: 97.5%;height: 50px;" id="reply_index" onfocus="if(this.value == 'Reply...') this.value='';" id="reply_text<?php echo $rows[0]; ?>" >Reply...</textarea>
					<div style="width: 100%;padding-top: 3px;height: 18px;">
						<input type="submit" class="btnbykk" value="send" style="float: right;width: 100px;margin-right: 5px;" >
					</div>
					<?php
				}
				else 
				{
					?>
					<span style="float: left;color: #777;clear: left;">Your reply:</span><br>
					<?php 
					$buff = explode("\n", $row[3]); 
					$buff = implode("<br/>", $buff); 
					echo $buff;
				}
			}
		}
	}
	else if($_GET["mode"] == 'show_msg')
	{
		$id = $_GET["id"];
		
		$query = mysql_query("UPDATE messagebykk SET seen = '1' WHERE id='$id' ;", $db);
		if(!$query)
			echo mysql_error();
		
		$query = mysql_query("SELECT * FROM messagebykk WHERE state = 1 AND id = '$id' ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		
		if($mrow = mysql_fetch_row($query))
		{
	?>
		<script>
		$("#controlpanel_container .controls").empty().css({'opacity':'0.0'}).append(
			"<div class='btn delete' onclick='deleteMsg(<?php echo $mrow[0]; ?>);' title='Delete message' ></div>"
			).animate({'opacity':'1'},300);
		</script>
		<div class="header" >
			<span class="mtitle" >Name:</span><span class="mdata" ><?php echo $mrow[2]; ?></span>
			<span class="mtitle" >Email:</span><span class="mdata" ><?php echo $mrow[1]; ?></span>
			<?php if($mrow[3] != '') { ?><span class="mtitle" >Mobile:</span><span class="mdata" ><?php echo $mrow[3]; ?></span><?php } ?>
			<?php if($mrow[4] != '0'){ ?><span class="mtitle"  onclick="msgMEdit(<?php echo $mrow[4]; ?>);" >User link</span><?php } ?>
		</div>
		<div class="message">
			<?php $buff = explode("\n", $mrow[5]); $buff = implode("<br/>", $buff); echo $buff; ?>
		</div>
		<div class="reply">
		<?php 
		if(strlen($mrow[6]) >= 2)
		{
		?>
			<span style="float: left;color: #777;clear: left;">Your reply:</span><br>
			<?php $buff = explode("\n", $mrow[6]); $buff = implode("<br/>", $buff); echo $buff; ?>
		<?php 
		}
		else
		{
		?>
			<textarea class="textbykk" style="width: 97.5%;height: 50px;" id="reply_index" onfocus="if(this.value == 'Reply...') this.value='';" id="reply_text<?php echo $rows[0]; ?>" >Reply...</textarea>
			<div style="width: 100%;padding-top: 3px;height: 18px;">
				<input type="button" class="btnbykk" value="send" style="float: right;width: 100px;margin-right: 5px;" onclick="sendReply(<?php echo $mrow[0]; ?>);" >
			</div>
		<?php 
		}
		?>
		</div>
	<?php
		}
	}
	else
	{
	?>
		<script type="text/javascript">
		$("#page-nav").css({'opacity':'0'}).empty().load('index/pagenavigator.php?page=message', function() {
			$("#page-nav").animate({'opacity':'1'}, 300);
			});
		var msgDelID = 0;
		$(function() {
			$("#delete_dialogMsg").dialog({
				autoOpen: false,
				resizable: false,
				height:130,
				modal: true,
				buttons: {
					"Yes": function() {
						progressBar(300, 60);
						$.get('index/message.php?mode=delete&id='+msgDelID, function()
							{
								gotoPage('full',500,'index/message.php');
							});
						$( this ).dialog( "close" );
					},
					"Cancel": function() {
						$( this ).dialog( "close" );
					}
				}
			});
		});
		function deleteMsg(id)
		{
			msgDelID = id;
			$("#delete_dialogMsg").dialog("open");
		}
		function showMsg(id)
		{
			progressBar(300, 60);
			$("#message-container .message-inner").load('index/message.php?mode=show_msg&id='+id,function(){
				progressBar(300, 100);
			});
		}
		function msgMEdit(id)
		{
			gotoPage('full',500,'index/member.php?mode=edit&id='+id);
		}
		function sendReply(id)
		{
			var text = $("#reply_index").val();
			text = encodeURIComponent(text);
			progressBar(300, 60);
			$("#message-container .message-inner .reply").load('index/message.php?mode=reply&id='+id+'&text='+text, function() {
				progressBar(300, 100);
			});
		}
		</script>
		<div id="delete_dialogMsg" title="Delete Message" style="display: none;">
			<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are you sure?
		</div>
		<div style="opacity:0;width: 100%;height: 100%;" id="index-loader">
			<div id="messages-container">
				<div class="inner">
				<?php
				if(isset($_GET["selected_id"]))
					$selected_id = $_GET["selected_id"];
				else
					$selected_id = '';
				
				$query = mysql_query("SELECT id, name, email, date, time, mlang FROM messagebykk WHERE state = 1 ORDER BY id  DESC ;", $db);
				if (!$query)
					die("Error reading query: ".mysql_error());
				
				while($mrows = mysql_fetch_row($query))
				{
					if($selected_id == '')
						$selected_id = $mrows[0];
					?>
					<div class="mitem <?php if($mrows[0] == $selected_id) echo "selected"; ?>" onclick="showMsg(<?php echo $mrows[0]; ?>);" >
						<span class="datetime" ><?php echo $mrows[3]." ".$mrows[4]; ?></span>
						<div class="text" ><a href="?command=<?php echo encodeURIComponent('page=message|&|mode=show_msg|&|section_id='.$mrows[0]); ?>" ><span style='font-weight: bold;' >Name: </span><?php echo $mrows[1]; ?><br><span style='font-weight: bold;' >Emial: </span><?php echo $mrows[2]; ?></a></div>
					</div>
					<?php 
				}
				?>
				</div>
			</div>
			<div id="about-shadow">
			</div>
			<div id="message-container">
				<div class="message-inner" >
					
				</div>
			</div>
			<script type="text/javascript">
			$(".mitem").mouseenter(function(){
				$(this).children(".text").stop().animate({'padding-left':'20px'},300);
			}).mouseleave(function(){
				if(!$(this).hasClass("selected"))
					$(this).children(".text").stop().animate({'padding-left':'10px'},300);
			}).click(function(){
				$(".mitem").removeClass("selected");
				$(".mitem").not(this).children(".text").animate({'padding-left':'10px'},300);
				$(this).addClass("selected");
			});

			$('#messages-container .inner').slimScroll({
			      wheelStep: 20,
			      height:'600px',
			      position: 'right'
		  	});
		  	
			setTimeout(function(){
				showMsg(<?php echo $selected_id; ?>);
			},100);
			</script>
		</div>
	<?php
	}
}
?>