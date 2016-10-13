<?php
	$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']); 
?>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<base href="<?php echo $directory_self; ?>">
<!-- library -->
<link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="lib/font-awesome/css/font-awesome.min.css">
<script type="text/javascript" src="lib/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="lib/bootstrap/js/bootstrap.min.js"></script>