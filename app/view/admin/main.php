<!DOCTYPE html>
<html>
<head>
	<title>FUD - Administrator</title>
	<?php include_once "_header.php"; ?>
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
			<a href="admin/order">orders</a>
			<a href="admin/product">products</a>
			<a href="admin/client-info">clients</a>
		</nav>
		<div class="main_pg_content">
		<div class="preface_pgc">
			<h1 class="fxRtlc"><a id="ol_bt">Order list</a></h1>
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
	<script type="text/javascript" src="js/general/assets.js"></script>
</section>
</body>
</html>