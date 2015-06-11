<?php
include 'database.php';

if($isAdmin)
{

	if($_GET["mode"] == 'applyedit')
	{
		$ajaxDir = "../";
		
		$contact_index = $_POST["contact_index"];
		$contact_index = htmlspecialchars($contact_index, ENT_QUOTES,"UTF-8");
		
		$address_index="aboutandcontact/footer.dtx" ;
		if (get_magic_quotes_gpc()) $contact_index = stripslashes($contact_index);
		$contact_index=explode(chr(13),$contact_index);
		$f=fopen($ajaxDir.$address_index , "w");
		foreach($contact_index as $buf )
		{
			fputs($f , $buf);
		}
		fclose($f);
		
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
?>
<div style="opacity:0;width: 100%;height: 100%;" id="index-loader">
	<div class="div-title">تغییر متن پایین صفحه</div>
	<form action="index/editfooter.php?mode=applyedit" method="POST" enctype="multipart/form-data" id="changecontact_form" >
		<div class="div-row" >
			<div class="input-div" style="width: 845px;" >
				<div class="labl" >متن</div>
				<textarea name="contact_index" class="textbykk" id="contact_index" ><?php 
				$contact_address = "aboutandcontact/footer.dtx";
				$check = false;
				$f = fopen("../".$contact_address, "r");
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
					?></textarea>
			</div>
		</div>
		<div class="div-row" >
			<div class="input-div" >
				<input type="submit" class="btnbykk" value="اعمال تغییرات" style="width: 412px;">
			</div>
		</div>
	</form>
</div>
<script>
function contactBeforeSend()
{
	progressBar(300, 60);
	return true;
}
$(document).ready(function() { 
	$("#contact_index").jqte();
    $('#changecontact_form').ajaxForm({ 
        target: '#main-index',
        success: function() { 
        	progressBar(300, 100);
        	$('#index-loader').animate({'opacity':'1'},300);
        } 
    	,
    	beforeSubmit: contactBeforeSend
    }); 
});
</script>
<?php
}
?>