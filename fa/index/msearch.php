<?php
include 'database.php';
if($isAdmin)
{
	if (empty($_GET['term'])) exit ;
	$q = strtolower($_GET["term"]);
	// remove slashes if they were magically added
	if (get_magic_quotes_gpc()) $q = stripslashes($q);
	
	$result = array();
	
	if(isset($_GET["form_id"]))
	{
		$form_id = $_GET["form_id"];
		
		$query = mysql_query("SELECT * FROM formbykk WHERE state = 1 AND id = '$form_id' ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		$num_fields = 0;
		$sqlToSelect[0] = 0;
		if($frow=mysql_fetch_row($query))
		{
			for($i=1;$i<=$frow[6];$i++)
			{
				$fs = $frow[(6+($i*2-1))];
					
				$afs[$i] = explode("|", $fs);
				if($afs[$i][3] == '1')
				{
					$sqlToSelect[$num_fields] = $i;
					$num_fields++;
				}
			}
		}
		
		$i=0;
		$field = '';
		$check = false;
		for($j=0;$j<$num_fields;$j++)
		{
			$query = mysql_query("SELECT fld_".$sqlToSelect[$j]." FROM filledformbykk WHERE state != 0 AND form_id = '$form_id' AND fld_".$sqlToSelect[$j]." REGEXP '$q' ORDER BY fld_".$sqlToSelect[$j]." ASC ;", $db);
			if (!$query)
				die("Error reading query: ".mysql_error());
			
			while($srows = mysql_fetch_row($query))
			{
				if($i>10) {
					$check = true; break;
				}
				if($srows[0] != $field)
				{
					$field = $srows[0];
					if(substr($srows[0], 0,2) == 'o|')
					{
						$other_value = explode("|", $srows[0]);
						$toAdd = $other_value[1];
					}
					else
						$toAdd = $srows[0];
					array_push($result, array("id"=>$i, "label"=>$toAdd, "value" => strip_tags($toAdd)));
					$i++;
				}
			}
			if($check)
				break;
		}
		
	}
	else
	{
		$query = mysql_query("SELECT email FROM registerbykk WHERE state != 0 AND email != 'designer' AND email REGEXP '$q' ORDER BY email ASC ;", $db);
		if (!$query)
			die("Error reading query: ".mysql_error());
		$i=0;
		$field = '';
		$check = false;
		while($srows = mysql_fetch_row($query))
		{
			if($i>10) {$check = true; break;}
			if($srows[0] != $field)
			{
				$field = $srows[0];
				array_push($result, array("id"=>$i, "label"=>$srows[0], "value" => strip_tags($srows[0])));
				$i++;
			}
		}
		if(!$check)
		{
			$query = mysql_query("SELECT name FROM registerbykk WHERE state != 0 AND email != 'designer' AND name REGEXP '$q' ORDER BY name ASC ;", $db);
			if (!$query)
				die("Error reading query: ".mysql_error());
			while($srows = mysql_fetch_row($query))
			{
				if($i>10) {$check = true; break;}
				if($srows[0] != $field)
				{
					$field = $srows[0];
					array_push($result, array("id"=>$i, "label"=>$srows[0], "value" => strip_tags($srows[0])));
					$i++;
				}
			}
		}
		if(!$check)
		{
			$query = mysql_query("SELECT cellphone FROM registerbykk WHERE state != 0 AND email != 'designer' AND cellphone REGEXP '$q' ORDER BY cellphone ASC ;", $db);
			if (!$query)
				die("Error reading query: ".mysql_error());
			while($srows = mysql_fetch_row($query))
			{
				if($i>10) {$check = true; break;}
				if($srows[0] != $field)
				{
					$field = $srows[0];
					array_push($result, array("id"=>$i, "label"=>$srows[0], "value" => strip_tags($srows[0])));
					$i++;
				}
			}
		}
		if(!$check)
		{
			$query = mysql_query("SELECT country FROM registerbykk WHERE state != 0 AND email != 'designer' AND country REGEXP '$q' ORDER BY country ASC ;", $db);
			if (!$query)
				die("Error reading query: ".mysql_error());
			while($srows = mysql_fetch_row($query))
			{
				if($i>10) {
					$check = true; break;
				}
				if($srows[0] != $field)
				{
					$field = $srows[0];
					array_push($result, array("id"=>$i, "label"=>$srows[0], "value" => strip_tags($srows[0])));
					$i++;
				}
			}
		}
		if(!$check)
		{
			$query = mysql_query("SELECT iran_state FROM registerbykk WHERE state != 0 AND email != 'designer' AND iran_state REGEXP '$q' ORDER BY iran_state ASC ;", $db);
			if (!$query)
				die("Error reading query: ".mysql_error());
			while($srows = mysql_fetch_row($query))
			{
				if($i>10) {$check = true; break;}
				if($srows[0] != $field)
				{
					$field = $srows[0];
					array_push($result, array("id"=>$i, "label"=>$srows[0], "value" => strip_tags($srows[0])));
					$i++;
				}
			}
		}
	}
	
	echo json_encode($result);
}
?>