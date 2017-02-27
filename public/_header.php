<?php
	$directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']); 
?>
<meta charset="utf-8"/>
<link rel="shortcut icon" href="img/favicon.ico?v=<?=V_FAVICON?>">
<link rel="icon" href="img/favicon.ico?v=<?=V_FAVICON?>">

<meta name="viewport" content="width=device-width, initial-scale=1">
<base href="<?php echo $directory_self; ?>">
<!-- library -->
<link rel="stylesheet" type="text/css" href="lib/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="lib/bootstrap-social/bootstrap-social.css">
<link rel="stylesheet" type="text/css" href="lib/font-awesome/css/font-awesome.min.css">
<script type="text/javascript" src="lib/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="lib/bootstrap/js/bootstrap.min.js"></script>
<!-- assets -->
<?php if (@isset($data["header"])) { ?>
<?php for ($i = 0; $i < count($data["header"]["css"]); $i++) { ?>
<link rel="stylesheet" type="text/css" href="css/<?php echo $data["header"]["user"]; ?>/<?php echo $data["header"]["css"][$i]; ?>.css">
<?php };?>
<?php };?>