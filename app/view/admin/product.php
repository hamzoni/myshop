<div id="tbl_wpScrll" class="prtbl_wrp">
	<table id="dp_prdTble" class="table table-bordered table-condensed">
		<tr>
			<!-- 1 STT -->
			<th>
				<span class="fixed_widthTd"></span>
			</th>
			<!-- 2 Product ID -->
			<th>
				<span class="fixed_widthTd">P_ID </span>
			</th>
			<!-- 3 Product name -->
			<th>
				<span class="fixed_widthTd">Product name</span>
			</th>
			<!-- 4 Price -->
			<th>
				<span class="fixed_widthTd">Price</span>
			</th>
			<!-- 5 Sale off -->
			<th>
				<span class="fixed_widthTd">
					<img class="discount_perc" src="img/admin/discount.svg">
				</span>
			</th>
			<!-- 6 Purchase count -->
			<th>
				<span class="fixed_widthTd">P_C</span>
			</th>
			<!-- 7 Display -->
			<th>
				<span class="fixed_widthTd">
					<i class="fa fa-eye" aria-hidden="true"></i>
				</span>
			</th>
			<!-- 8 Type -->
			<th>
				<span class="fixed_widthTd">Type</span>
			</th>
			<!-- 9 Edit button -->
			<th>
				<span class="fixed_widthTd"></span>
			</th>
		</tr>
		<?php for($i = 0; $i < count($data["products_tray"]); $i++) { ?>
		<tr>
			<td>
				<form class="prd_infoCtner" prd_id='<?=$data['products_original'][$i]['id']?>' style="display:none;">
				<?php foreach ($data["products_original"][$i] as $k => $v) { ?>
					<input type="hidden" name="prd_<?=$k?>" value="<?=$v?>">
				<?php }; ?>
				</form>
				<input type="checkbox" class="slct_r">
			</td>
			<td><?=$data["products_tray"][$i]['id']?></td>
			<td class="slt_hker"><?=$data["products_tray"][$i]['name']?></td>
			<td><?=$data["products_tray"][$i]['price']?></td>
			<td><?=$data["products_tray"][$i]['sale']?></td>
			<td><?=$data["products_tray"][$i]['purchase_count']?></td>
			<td>
				<i class="fa fa-circle<?=$data["products_tray"][$i]['display']?>" aria-hidden="true"></i>
			</td>
			<td><?=$data["products_tray"][$i]['type']?></td>
			<td>
				<button class="edit_prdOl">
					<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
				</button>
			</td>
		</tr>
		<?php }; ?>
	</table>
</div>
<!-- end of prtbl_wrp -->
<section class="prd_mdf_opt">
	<div class="l_col_prdmdf">
		<button class="opt_prdmdf_btn" id="add_prf">Add product</button>
		<div class="wrp_pbtn">
			<button class="inwbtp" dp-type='1'>Show item(s)</button>
			<button class="inwbtp" dp-type='0'>Hide item(s)</button>
		</div>
		
		<button class="opt_prdmdf_btn" id="rm_item">Remove item(s)</button>
	</div>
	<!-- end of l_col_prdmdf -->
	<div class="r_col_prdmdf">
		<div class="prscr_t">
			Preview item info
		</div>
		<div class="general_popUp food_detail"">
			<div class="dragger_ttl">
				<h2 class="hd_ttl VAAlign">
					<span id="og_nm">
					<?=$data["products_tray"][0]['name']?>
					</span>
					<span id="og_sl">
					(-<?=$data["products_tray"][0]['sale']?>)
					</span>
				</h2>
				<button class="close_btn">
					<i class="fa fa-times" aria-hidden="true"></i>
				</button>
			</div>
			<div class="main_cartCtner clr_dark2">
				<div class="col1_mcct">
					<img id="og_ava" class="fd_inf_ava" src="<?=$data["products_tray"][0]['avatar_img']?>">
					<div class="short_dscp">
						<span class="dscrpt_tt">Description:</span>
						<span id="og_dsc">
						<?=$data["products_tray"][0]['description']?>
						</span>
					</div>
				</div>
				<div class="col2_mcc1">
					<img id="og_ntr" class="fd_nutri_info" src="<?=$data["products_tray"][0]['nutrition_img']?>">
				</div>
			</div>
			<div class="cart_footer">
				<div class="left_cfter">
					<div class="holder_mop">
						<p class="prc_ctner_mop">Price: 
							<span id="og_prc">
							<?=$data["products_tray"][0]['price']?>
							</span>
						</p>
						<label class="qty_lb_vFi">SL</label>
						<input id="qty_ifcIf" type="text" class="qty_ctn_vFi"/>
					</div>
				</div>
				<div class="right_cfter">
					<a id="aCfd_IF" class="normal_sbm_skbc VAAlign">
						add to cart
					</a>
				</div>
			</div>
		</div>
	</div>
	<!-- end of r_col_prdmdf -->
</section>
<div class="boundingLayer" style="display:none;">
	<div class="popup_addProduct">
		<div class="padp_hder">
			<p id="dscr_bxTb">
				new product
			</p>
			<button class="close_btn">
				<i class="fa fa-times" aria-hidden="true"></i>
			</button>
		</div>
		<div id="prg_layer" class="progress_layer" style="display:none;">
			<div class="progL_wrapper">
				<h1 id="upload_status">Upload in process...</h1>
				<progress id="upl_progBar" value="" max="">
			</div>

		</div>
		<form id="addPr_f" name="upload_newProduct" action="<?=$data["upload_form"]["handler"]?>" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="MAX_FILE_SIZE" value="<?=$data["upload_form"]["file_size"]?>"> 
			<input type="hidden" name="previous_pData" value="">
			<div class="l_colAp">
				<span class="r_ipcAp">
					<label class="swd_lbt" for="p_name">Product name</label>
					<input class="ipCpaA" type="text" name="p_name" placeholder="eg: Dog meat"/>
					<button id="dplbtn_c" class="dpl_g2" title="show product?">
						<i class="fa fa-eye-slash" aria-hidden="true"></i>
					</button>
					<input type="hidden" name="p_display" value="0"/>
				</span>
				<span class="r_ipcAp">
					<label class="swd_lbt" for="p_name">Product price</label>
					<input class="ipCpaA" type="text" name="p_price" placeholder="eg: 230000">
					<label class="lbstg" for="p_sale">
						<img src="img/admin/discount.svg">
					</label>
					<input class="ipCpaA" type="text" name="p_sale" placeholder="0" maxlength="2" />
				</span>
				<span class="r_ipcAp ripcd_lc">
					<input gr='1' type="radio" name="p_type" value="2">
					<label gr='1' for="p_type">Sale off</label>
					<input gr='2' type="radio" name="p_type" value="1">
					<label gr='2' for="p_type">Special</label>
					<input gr='3' type="radio" name="p_type" value="0" checked='true'>
					<label gr='3' for="p_type">None</label>
				</span>
				<div class="last_ripcp">
					<div class="prv_avatarCtner">
						<button id="f_upl_ava" class="fileUpl_btn">
							<i class="fa fa-camera" aria-hidden="true"></i>
						</button>
						<canvas id="prv_avatar"></canvas>
					</div>
					<div class="upload_imgBtn">
						<textarea name="f_dscrp" id="food_description" placeholder="Food description..."></textarea>
					</div>
				</div>
			</div>
			<div class="r_colAp">
				<button id="f_upl_nutri" class="fileUpl_btn">
					<i class="fa fa-camera" aria-hidden="true"></i>
				</button>
				<canvas id="prv_nutrition"></canvas>
			</div>
			<div class="ipbtnUl_ctner">
				<input type="submit" name="submit_prd" value="submit" id="sbmitBt_kl">
				<!-- upload file goes here -->
				<input class="fl_upld" id="p_nutriImg" type="file" name="p_nutrition">
				<input class="fl_upld" id="p_avaImg" type="file" name="p_avatar">
			</div>
		</form>
	</div>
	<!-- end of popup_addProduct -->
</div>

<script type="text/javascript">
	// alert notification if having
	<?php if (@isset($data["ntf"])) { ?>
	alert("<?=$data["ntf"];?>");
	<?php };?>
	// preset tbl select data
	function set_preset() {
		this.base_url = '<?=$data["base_url"]?>';
		this.lmt = <?=$data["slc_lm"]?>; // NUMBER OF RECORD TO BE PULLED
		this.ofs = <?=$data["crr_offset"]?>; // POSITION OF STARTED RECORD
		this.ttr = <?=$data["total_records"]?>; // TOTAL RECORDS IN DATABASE
		this.start_id = "<?php print_r($data["id_start"]); ?>";
	}
</script>