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
			<a href="<?=BASE_URL?>">
				<img id="company_logo" src="img/hybrid/02566db7174810fa6abccd6fb9a6d42f">
			</a>
		</figure>
		
		<!-- end of logo_ctner -->
		<div class="wrapper_rghtB">
			<div class="mid_hb_ctn" id="adm_pnDt"></div>
			<button class="log_outMn" id="lgOut_b">log out</button>
			<nav class="ctrl_br">
				<ul>
					<li id="msg">
						<i class="fa fa-envelope-o" aria-hidden="true"></i>
					</li>
					<li id="ntf">
						<span id="notificationsCountValue" hide></span>
						<i class="fa fa-globe" aria-hidden="true"></i>
					</li>
				</ul>
			</nav>
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
			<a href="admin/contact">contact</a>
		</nav>
		<div class="main_pg_content">
		<div class="preface_pgc">
			<h1 class="fxRtlc">
				<a id="ol_bt">
				<?=$data["preface_pgc"]?>
				</a>
			</h1>
			<form class="spc_searchEg" name="search_f">
				<input type="text" name="_typeVal" value="OD">
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
	<!-- start of notification -->
	<div class="admin_popup" id="_notify" hide>
		<div class="th_ctt_adnt_t">
			<p class="odth_adnt ordID">order ID</p>
			<p class="odth_adnt ordCname">customer Name</p>
			<p class="odth_adnt ordAdd">room</p>
			<p class="odth_adnt ordprcVal">cart value</p>
			<p class="odth_adnt ordtime">crder time</p>
		</div>
		<div class="th_ctt_adnt">
			<div class="ord_clst_ntf" hide>
				<p class="odth_adnt ordID">OD0551</p>
				<p class="odth_adnt ordCname">Nguyen Acer Sony Yamaha</p>
				<p class="odth_adnt ordAdd">C212</p>
				<p class="odth_adnt ordprcVal">97,900,500</p>
				<p class="odth_adnt ordtime">5 days ago - 11/02/2016</p>
			</div>
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