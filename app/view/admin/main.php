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
			<div class="mid_hb_ctn" id="adm_pnDt">
			</div>
			<button class="log_outMn" id="lgOut_b">
				log out
			</button>
		</div>
	</header>
	<!-- end of header_bar -->
	<div class="main_pg_container">
		<nav class="sideMenu_bar">
			<a href="admin/statistic">statistic</a>
			<a href="admin/order">orders</a>
			<a href="admin/product">products</a>
			<a href="admin/user">clients</a>
			<a href="admin/profile">profile</a>
		</nav>
		<div class="main_pg_content">
		<div class="preface_pgc">
			<h1 class="fxRtlc">
				<a id="ol_bt">
				<?=$data["preface_pgc"]?>
				</a>
			</h1>
			<form class="spc_searchEg" name="search_f">
				<input type="text" name="_typeVal" value="OD asdzxc">
				<input type="text" name="sr_tId" value="" style="display:none">
				<input type="text" name="sr_tPg" value="" style="display:none">
				<button type="submit" name="sb_sf">
					<i class="fa fa-search" aria-hidden="true"></i>
				</button>
			</form>
		</div>
		<?php include $data["page"].".php"; ?>
		</div>
	</div>
	<!-- end of main_pg_container -->
	<div class="_search_rcmd" id="search_thing">
		<div class="ttl_rcd">search result:</div>
		<div class="ctn_srcd_wrapper" id="sgg_ctner">
		</div>
	</div>
	<script type="text/javascript" src="js/general/assets.js"></script>
	<script type="text/javascript" src="js/general/date.js"></script>
	<script type="text/javascript" src="js/general/admin_panel.js"></script>
	<?php if (@$data["header"]["js"]) { ?>
	<?php for ($i = 0; $i < count($data["header"]["js"]); $i++) { ?>
	<script type="text/javascript" src="js/<?php echo $data["header"]["user"]; ?>/<?php echo $data["header"]["js"][$i]; ?>.js"></script>
	<?php };?>
	<?php };?>
</section>
</body>
</html>