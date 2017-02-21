<form name="ctc_dt" class="f_data" method="post" action="">
	<nav class="opt_fda">
		<a id="upd_favicon">
			<canvas id="fav_ic"></canvas>
		</a>
		<input type="file" name="favi_ic" hide>
		<div class="hptwr">
		  <input type="text" name="hp_ttl" class="hpg_ttl" placeholder="Home page title" disabled>
		  <div class="db_dtr"></div>
		</div>​
		<input name="cf_btn" type="submit" value="save">
	</nav>
	<section class="colf colf_1">
		<div class="cvs_wrapper">
			<button id="upl_cvs">
				<i class="fa fa-camera-retro" aria-hidden="true"></i>
			</button>
			<input type="file" name="logo_imgFile" hide>
			<canvas id="logo_cvs"></canvas>
		</div>
		<!-- end of cvs_wrapper -->
		<div class="field_wrapper" type="wAddrs">
			<span class="field_ctner">
				<div class="data_wrp" index="0">
					<div class="ttl_wrp">
						<p class="sdhw_ctn">website address</p>
						<a class="opt_ct disableBlacken" opt="edit" title="edit website address 1">edit</a>
						<a class="opt_ct disableBlacken" opt="delete" title="delete website address 1">delete</a>
					</div>
					<!-- end of ttl_wrp -->
					<div class="ipt_wrp">
						<label for="">label</label>
						<input class="ipt_dtf" disabled type="text" name="website_lbl" placeholder="example.com">
					</div>
					<div class="ipt_wrp">
						<label for="">data</label>
						<input class="ipt_dtf" disabled type="text" name="website_addr" placeholder="http://www.example.com">
					</div>
				</div>
				<!-- end of data_wrp -->
			</span>
			<input type="button" class="ext_fd" name="_add" value="add">
		</div>
		<!-- end of field_wrapper -->
		<div class="field_wrapper" type="wPhone">
			<span class="field_ctner">
				<div class="data_wrp" index="0">
					<div class="ttl_wrp">
						<p class="sdhw_ctn">phone number</p>
						<a class="opt_ct disableBlacken" opt="edit" title="edit website address 1">edit</a>
						<a class="opt_ct disableBlacken" opt="delete" title="delete website address 1">delete</a>
					</div>
					<!-- end of ttl_wrp -->
					<div class="ipt_wrp">
						<label for="">label</label>
						<input class="ipt_dtf" disabled type="text" name="website_lbl" placeholder="012.345.6789">
					</div>
					<div class="ipt_wrp">
						<label for="">data</label>
						<input class="ipt_dtf" disabled type="text" name="website_addr" placeholder="0123456789">
					</div>
				</div>
				<!-- end of data_wrp -->
			</span>
			<input type="button" class="ext_fd" name="_add" value="add">
		</div>
		<!-- end of field_wrapper -->
	</section>
	<section class="colf colf_2">
		<div class="cvs_wrapper">
			<textarea class="txt_area_wrpp" name="pg_dcrpt" placeholder="About" disabled></textarea>
			<button id="edit_dcrp_w" title="edit page description">
				<i class="fa fa-pencil" aria-hidden="true"></i>
			</button>
		</div>
		<div class="field_wrapper" type="wEmail">
			<span class="field_ctner">
				<div class="data_wrp" index="0">
					<div class="ttl_wrp">
						<p class="sdhw_ctn">email address</p>
						<a class="opt_ct disableBlacken" opt="edit" title="edit website address 1">edit</a>
						<a class="opt_ct disableBlacken" opt="delete" title="delete website address 1">delete</a>
					</div>
					<!-- end of ttl_wrp -->
					<div class="ipt_wrp">
						<label for="">label</label>
						<input class="ipt_dtf" disabled type="text" name="website_lbl" placeholder="sample email">
					</div>
					<div class="ipt_wrp">
						<label for="">data</label>
						<input class="ipt_dtf" disabled type="text" name="website_addr" placeholder="sample@mail.com">
					</div>
				</div>
			</span>
			<input type="button" class="ext_fd" name="_add" value="add">
		</div>
		<!-- end of field_wrapper -->
		<div class="field_wrapper" type="wFBacc">
			<span class="field_ctner">
				<div class="data_wrp" index="0">
					<div class="ttl_wrp">
						<p class="sdhw_ctn">facebook</p>
						<a class="opt_ct disableBlacken" opt="edit" title="edit website address 1">edit</a>
						<a class="opt_ct disableBlacken" opt="delete" title="delete website address 1">delete</a>
					</div>
					<!-- end of ttl_wrp -->
					<div class="ipt_wrp">
						<label for="website_lbl">label</label>
						<input class="ipt_dtf" disabled type="text" name="website_lbl" placeholder="facebook page">
					</div>
					<div class="ipt_wrp">
						<label for="website_addr">data</label>
						<input class="ipt_dtf" disabled type="text" name="website_addr" placeholder="http://facebook.com/mypage">
					</div>
				</div>
				<!-- end of data_wrp -->
			</span>
			<input type="button" class="ext_fd" name="_add" value="add">
		</div>
		<!-- end of field_wrapper -->
	</section>
</form>
<script type="text/javascript">
function set_preset() {
	this.base_url = "<?php print_r($data["base_url"]); ?>";
}
</script>