<!DOCTYPE html>
<html>
<head>
	<title>Error Page</title>
	<?php include_once "_header.php"; ?>
</head>
<body>
<p>
	Error found: <?=$data["err"]?>
</p>
<p>
	This page will be automatically redirected in: <span id="count_down"></span>
	<p>Or <button><a href="<?=$data["rewind_pg"]?>">Redirect immediately</a></button></p>
</p>

<script type="text/javascript">
	var rw_time = <?=$data["rewind_pg_time"]?>;
	document.getElementById("count_down").innerHTML = rw_time;
	rw_time--;
	setInterval(function(){
		document.getElementById("count_down").innerHTML = rw_time--;
	},1000);
</script>
</body>
</html>