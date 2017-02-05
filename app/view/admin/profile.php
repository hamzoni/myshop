<div class="prf_wrp">
	<form name="prf_form" action="" method="POST">
		<div class="admp_col admp_c_l">
			<div class="r_infN">
				<label for="name">Name</label>
				<input type="text" name="name" class="bsc_ipPrf unl_rsx" disabled="true">
			</div>
			<div class="r_infN">
				<label for="phone">Phone</label>
				<input type="text" name="phone" class="bsc_ipPrf unl_rsx" disabled="true">
			</div>
			<div class="r_infN">
				<label for="Email">Email</label>
				<input type="text" name="email" class="bsc_ipPrf unl_rsx" disabled="true">
			</div>
			 <div class="lg_rKb">
			 	<div class="lbl_drKb">Login Key</div>
			 	<div class="lg_kBd spc_kCt">
			 		<div id="spc_keyB" class="key_ctner"></div>
			 		<button id="atv_kRcd" class="rcd_kBtn">
			 			<i class="fa fa-circle" aria-hidden="true"></i>
			 		</button>
			 	</div>
			 </div>
			 <div class="lg_rKb">
			 	<div class="lbl_drKb">Login Code</div>
			 	<div class="wrp_lgC">
			 		<input class="lldc_iP" type="password" name="login_code" disabled="true">
			 		<button id="dpl_text" class="dpl_cBtn">
			 			<i class="fa fa-eye" aria-hidden="true"></i>
			 		</button>
			 	</div>
			 </div>
		</div>
		<div class="admp_col admp_c_r">
			<div class="cvs_ctn_adprf edt_b">
				<canvas id="admin_avatar"></canvas>
				<button class="upl_ava_btn" id="upl_ava">
					<i class="fa fa-camera"></i>
					Upload Avatar
				</button>
				<input type="text" name="avatar" class="hidden_txt">
				<input type="file" name="upl_avaCtner">
			</div>
			<input type="submit" name="sbm_Dt" value="edit">
		</div>
	</form>
</div>
<script type="text/javascript">
	function set_preset() {
		this.base_url = "<?php print_r($data["base_url"]); ?>";
	}

</script>