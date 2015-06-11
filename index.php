<html>
<head>
	<title>Redirect</title>
</head>
<body>
	<?php 
	if(!isset($_COOKIE["css3support"]))
	{
	?>
		<script >
		if (!('WebkitTransform' in document.body.style 
				 || 'MozTransform' in document.body.style 
				 || 'OTransform' in document.body.style 
				 || 'transform' in document.body.style))
		{
			window.location = 'fa/?css3support=no';
		}
		else
		{
			window.location = 'fa/?css3support=yes';
		}	
		</script>
	<?php 
	}
	else 
	{
	?>
		<script >
			window.location = 'fa';
		</script>
	<?php 
	}
	?>
</body>
</html>