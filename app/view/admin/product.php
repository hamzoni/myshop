<div class="prtbl_wrp">
	<table class="table table-bordered table-condensed">
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
			<!-- 7 Type -->
			<th>
				<span class="fixed_widthTd">Type</span>
			</th>
			<!-- 8 Edit button -->
			<th>
				<span class="fixed_widthTd"></span>
			</th>
		</tr>
		<tr>
			<td>1</td>
			<td>SP0001</td>
			<td>Pepperoni Pizza</td>
			<td>239,000</td>
			<td>20%</td>
			<td>1,971</td>
			<td>Sale</td>
			<td>
				<button class="edit_prdOl">
					<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
				</button>
			</td>
		</tr>
	</table>
</div>
<!-- end of prtbl_wrp -->
<section class="prd_mdf_opt">
	<div class="l_col_prdmdf">
		<button class="opt_prdmdf_btn">Add product</button>
		<button class="opt_prdmdf_btn">Display item(s)</button>
		<button class="opt_prdmdf_btn">Remove item(s)</button>
	</div>
	<!-- end of l_col_prdmdf -->
	<div class="r_col_prdmdf">
		<div class="prscr_t">
			Preview item info
		</div>
		<div class="general_popUp food_detail"">
			<div class="dragger_ttl">
				<h2 class="hd_ttl VAAlign">
					<span id="og_nm">PEPPERONI PIZZA</span>
					<span id="og_sl">(-35%)</span>
				</h2>
				<button class="close_btn">
					<i class="fa fa-times" aria-hidden="true"></i>
				</button>
			</div>
			<div class="main_cartCtner clr_dark2">
				<div class="col1_mcct">
					<img id="og_ava" class="fd_inf_ava" src="img/1.jpg">
					<div class="short_dscp">
						<span class="dscrpt_tt">Description:</span>
						<span id="og_dsc">
							re veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem
						</span>
					</div>
				</div>
				<div class="col2_mcc1">
					<img id="og_ntr" class="fd_nutri_info" src="img/sample_nutrition.jpg">
				</div>
			</div>
			<div class="cart_footer">
				<div class="left_cfter">
					<div class="holder_mop">
						<p class="prc_ctner_mop">Price: 
							<span id="og_prc">90.000</span>
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
<div class="popup_addProduct">
	<div class="padp_hder">
		<p>
			new product
		</p>
		<button class="close_btn">
			<i class="fa fa-times" aria-hidden="true"></i>
		</button>
	</div>
	<form id="addPr_f" name="upload_newProduct" action="<?=$data["upload_form"]["handler"]?>" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="MAX_FILE_SIZE" value="<?=$data["upload_form"]["file_size"]?>"> 
		<div class="l_colAp">
			<span class="r_ipcAp">
				<label class="swd_lbt" for="p_name">Product name</label>
				<input class="ipCpaA" type="text" name="p_name" placeholder="eg: Dog meat">
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
					<canvas id="prv_avatar"></canvas>
				</div>
				<div class="upload_imgBtn">
					<button id="f_upl_ava" class="fileUpl_btn">
						Upload Avatar
					</button>
					<button id="f_upl_nutri" class="fileUpl_btn">
						Upload Nutrition Info
					</button>
					<input class="fl_upld" type="file" name="p_nutrition">
					<input class="fl_upld" type="file" name="p_avatar">
					<input type="submit" name="submit_prd" id="sbmitBt_kl">
				</div>
			</div>
		</div>
		<div class="r_colAp">
			<canvas id="prv_nutrition"></canvas>
		</div>
		<textarea name="f_dscrp" id="food_description" placeholder="Food description..."></textarea>
	</form>
</div>