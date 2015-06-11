<?php
include 'database.php';
if($isAdmin)
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Rahadarman</title>
		<meta name="Author" content="K_H1372@yahoo.com(+989352892554)" />
		<meta name="Copyright" content="rahadarmanmp.com" />
		<link href="../css/admin.css" rel="stylesheet" type="text/css" />
	</head>
	<body style="background-image: none;background-color: #fff;">
		<div style="padding: 0;margin: 0 auto;width: 950px;">
		<?php 
		if(isset($_GET['form_id']))
			$form_id = $_GET['form_id'];
		else
			$form_id = $_POST['form_id'];
		
		if(isset($_GET['id']))
			$id = $_GET['id'];
		else
			$id = $_POST['id'];
		
		///// seen
		$query = mysql_query("UPDATE filledformbykk SET seen = '1' WHERE id='$id' ;", $db);
		if(!$query)
			echo mysql_error();
		//////
		
		$query = mysql_query("SELECT * FROM formbykk WHERE state = 1 AND id = '$form_id' ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		if($frow=mysql_fetch_row($query))
		{
			$ffquery = mysql_query("SELECT * FROM filledformbykk WHERE state = 1 AND id = '$id' AND form_id = '$form_id' ;", $db);
			if (!$ffquery)
				die("Error reading query: ".mysql_error());
			if($ffrow=mysql_fetch_row($ffquery))
			{
				for($i=1;$i<=$frow[6];$i++)
				{
					$fld[$i] = $ffrow[($i+1)];
				}
			}
		?>
		<div style="border: 1px #ccc solid;padding: 0px;margin: 0;height: 55px;background-color: #fff;overflow: hidden;border-top-right-radius: 7px;border-top-left-radius: 7px;">
			<div style="height: 50px;width: 25%;float: left;padding: 0;margin: 0;">
				<?php 
				if($frow[2] != '')
				{
				?>
				<img alt="<?php echo $frow[1]; ?>" src="../../<?php echo $frow[2]; ?>" style="float: left;height: 55px;">
				<?php 
				}
				?>
			</div>
			<div style="height: 40px;width: 30%;float: left;padding: 15px 0 0 0;margin: 0;text-align: left;">
				<span><span style="color: #555;">Title:</span> <?php echo $frow[1]; ?></span>
			</div>
			<div style="height: 40px;width: 22.5%;float: left;padding: 15px 0 0 0;margin: 0;text-align: center;">
				<span><span style="color: #555;">Document code:</span> <?php echo $frow[4]; ?></span>
			</div>
			<div style="height: 40px;width: 22.5%;float: left;padding: 15px 0 0 0;margin: 0;text-align: center;">
				<span><span style="color: #555;">Classification:</span> <?php echo $frow[5]; ?></span>
			</div>
		</div>
		<div style="border: 1px #ccc solid;padding: 0px;margin: 0;overflow: hidden;border-bottom-right-radius: 7px;border-bottom-left-radius: 7px;position: relative;border-top: none; ">
		<?php 
		
		$widthPercentage = 0;
		$pafs = array();
		$pafs[0][0] = '0';
		
		function checkAllRowCheckBox(&$pafs,$i,$widthPercentage,$lasRow)
		{
			if($pafs[$i][1] == '4')
			{
				if($lasRow)
					return true;
				$fwp = $widthPercentage;
				for($j=1;$j<4;$j++)
				{
					switch ($pafs[$i + $j][0])
					{
						case '1':
						case '2':
							$fwp += 100;
							break;
						case '3':
							$fwp += 75;
							break;
						case '4':
							$fwp += 66;
							break;
						case '5':
							$fwp += 50;
							break;
						case '6':
							$fwp += 33;
							break;
						case '7':
							$fwp += 25;
							break;
					}
					if($pafs[$i + $j][1] != '4')
						return false;
		
					if($fwp > 90)
						break;
				}
				return true;
			}
			else
				return false;
		}
		
		for($i=1;$i<=$frow[6];$i++)
		{
			$fs = $frow[(6+($i*2-1))];
			$pafs[$i] = explode("|", $fs);
		}
		for($i=1;$i<=$frow[6];$i++)
		{
			$fs = $frow[(6+($i*2-1))];
			$fn = $frow[(6+($i*2))];
			
			$afs = explode("|", $fs);
			if($afs[1] == '5' || $afs[1] == '6')
			{
				$afn = explode("|", $fn);
				$f_name = $afn[0];
				if($afs[1] == '6')
					$option_other = true;
				else
					$option_other = false;
				$afs[1] = '5';
			}
			else
				$f_name = $fn;
			
			switch ($afs[0])
			{
				case '1':
				case '2':
					$widthPercentage += 100;
					break;
				case '3':
					$widthPercentage += 75;
					break;
				case '4':
					$widthPercentage += 66;
					break;
				case '5':
					$widthPercentage += 50;
					break;
				case '6':
					$widthPercentage += 33;
					break;
				case '7':
					$widthPercentage += 25;
					break;
			}
			
			if($widthPercentage > 90)
			{
				$widthPercentage = 0;
				$lastRow = true;
			}
			else
				$lastRow = false;
			
			?>
			<div style="<?php if(($afs[1] == '4' && checkAllRowCheckBox($pafs, $i, $widthPercentage, $lastRow))|| ($afs[1] == '3' && $afs[0] == '2' )) echo 'height:20px;'; if($lastRow) echo "border-right:none;"; ?>" class="<?php 
				switch ($afs[0])
				{
					case '1':
						echo "pfbig";
					break;
					case '2':
						echo "pfnormal";
					break;
					case '3':
						echo "pf3-4";
					break;
					case '4':
						echo "pf2-3";
					break;
					case '5':
						echo "pf1-2";
					break;
					case '6':
						echo "pf1-3";
					break;
					case '7':
						echo "pf1-4";
					break;
				}
				?>" >
				<?php 
				if($afs[1] == '1')
				{
					?>
						<?php if($afs[2] == '1') echo "<div style='float:left;' class='red' >*</div>"; ?><div class="pflable" ><?php echo $f_name; ?>:</div>
						<span class="ptext"><?php echo $fld[$i]; ?></span>
					<?php
				}
				else if($afs[1] == '2')
				{
					?>
						<?php if($afs[2] == '1') echo "<div style='float:left;' class='red' >*</div>"; ?><div class="pflable" ><?php echo $f_name; ?>:</div>
						<pre class="ppre"><?php echo $fld[$i]; ?></pre>
					<?php
				}
				else if($afs[1] == '3')
				{
					?>
						<div class="flable" style="font-weight: bold;" ><?php echo $f_name; ?></div>
					<?php
				}
				else if($afs[1] == '4')
				{
					?>
						<span style="float: left;margin-left: 16px;height: 13px;">
							<?php if($afs[2] == '1') echo "<div class='red' >*</div>"; ?><span class="input_span" style="float: left;" ><?php echo $f_name; ?> </span>
							<?php 
							if($fld[$i])
							{
							?>
								<img src="../../images/check.png" style="float: left;margin-left: 7px;margin-top: 2px;" />
							<?php 
							}
							else
							{
							?>
								<img src="../../images/uncheck.png" style="float: right;margin-left: 7px;margin-top: 2px;" />
							<?php
							} 
							?>
						</span>
					<?php
				}
				else if($afs[1] == '5')
				{
					?>
						<div style="float: left;"><?php if($afs[2] == '1') echo "<div class='red' >*</div>"; ?></div><div class="pflable" ><?php echo $f_name; ?>:</div>
						<span style="float: left;margin-top: 2px;">
					<?php
						$other_value = '';
							
						for($j=1;$j<=5;$j++)
						{
							if($afn[$j] != '')
							{
							?>
								<span style="float: left;margin-left: 3px;"><span class="input_span" style="float: left;" ><?php echo $afn[$j]; ?></span>
								<?php 
								if($fld[$i] == $afn[$j] )
								{
								?>
									<img src="../../images/check.png" style="float: right;margin-left: 3px;margin-top: 2px;" />
								<?php 
								}
								else
								{
								?>
									<img src="../../images/uncheck.png" style="float: right;margin-left: 3px;margin-top: 2px;" />
								<?php
								} 
								?>
								</span>
							<?php
							}
						}
						
						if(substr($fld[$i], 0,2) == 'o|')
							$other_value = explode("|", $fld[$i]);
						if($option_other)
						{
						?>
							<span style="float: left;margin-left: 3px;"><span class="input_span" style="float: left;" >other</span>
								<?php 
								if(is_array($other_value))
								{
								?>
									<img src="../../images/check.png" style="float: right;margin-left: 3px;margin-top: 2px;" />
								<?php 
								}
								else
								{
								?>
									<img src="../../images/uncheck.png" style="float: right;margin-left: 3px;margin-top: 2px;" />
								<?php
								} 
								?>
							</span>
						<?php
						}
					?>
						</span>
					<?php
					if($option_other)
					{
						?>
							<span style="float: left;margin-left: 3px;">
								<span class="input_span" style="float: left;border-bottom: 1px #aaa solid" ><?php if(is_array($other_value)) echo $other_value[1]; ?></span>
							</span>
						<?php
					}
				}
			?>
			</div>
		<?php 
		}
		if($frow[151] != '')
		{
			?>
			<div class="fbig" style="text-align: left;height: auto;">
				<pre style="font-family: tahoma;font-size: 13px;text-align: left;margin: 0;padding: 0;"><?php echo $frow[151]; ?></pre>
			</div>
		<?php
		}
		?>
		</div>
		<div style="width: 100%;height: 50px;padding: 0;margin: 0;">&nbsp;</div>
		<?php 
		}
		?>
		</div>
	</body>
</html>
<?php
}
?>