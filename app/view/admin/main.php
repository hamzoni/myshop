<!DOCTYPE html>
<html>
<head>
	<title>FUD - Administrator</title>
	<?php include_once "_header.php"; ?>
	<link rel="stylesheet" type="text/css" href="css/admin/main.css">
	<link rel="stylesheet" type="text/css" href="css/admin/order.css">
</head>
<body>
<section class="wrapper">
	<header class="header_bar">
		<figure class="logo_ctner">
			<img src="img/sample_logo.png">
		</figure>
		<!-- end of logo_ctner -->
		<div class="wrapper_rghtB">
			<div class="mid_hb_ctn">
			13:48:56 13/10/2016
			</div>
			<button class="log_outMn">
				log out
			</button>
		</div>
	</header>
	<!-- end of header_bar -->
	<div class="main_pg_container">
		<nav class="sideMenu_bar">
			<a>orders</a>
			<a>products</a>
			<a>clients</a>
		</nav>
		<div class="main_pg_content">
		<div class="preface_pgc">
			<h1 class="fxRtlc"><a>Order list</a></h1>
			<form class="spc_searchEg">
				<input type="text" name="_typeVal" placeholder="sample..">
				<button type="submit">
					<i class="fa fa-search" aria-hidden="true"></i>
				</button>
			</form>
		</div>
		<?php include $data["page"].".php"; ?>
		</div>
	</div>
	<!-- end of main_pg_container -->
</section>
</body>
</html>