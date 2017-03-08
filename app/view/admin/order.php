<section class="wrapBoth_ordL">

	<div class="orderList_wrapper">
		<div class="tbl_orderList_wrapper">
			<table class="table table-bordered table-condensed" id="order_ctnerTbl">
				<!-- 1 stt -->
				<col width="31px">
				<!-- 2 order_ID -->
				<col width="80px">
				<!-- 3 client_name -->
				<col width="180px">
				<!-- 4 client_phone -->
				<col width="100px">
				<!-- 5 client_address -->
				<col width="60px">
				<!-- 6 client_timeOrder -->
				<col width="">
				<!-- 7 product_shipStatus -->
				<col width="30px">
				<!-- 8 product_options: remove -->
				<col width="30px">
				<!-- 9 product_options: edit -->
				<col width="30px">
				<tr>
					<th></th>
					<th>Order ID</th>
					<th>Customer name</th>
					<th>Phone</th>
					<th>Address</th>
					<th>Time ordered</th>
					<th colspan="3">S / R / E</th>
				</tr>
				<tr class="order_tr" style="display: none" title="View order detail">
					<td>1</td>
					<td order-id="12">OD0012</td>
					<td>Hillary Trump</td>
					<td>0113114115911</td>
					<td>C 113</td>
					<td>12:55 27/09/2016</td>
					<td>
						<a class="atv_ship">
							<i class="fa fa-motorcycle" aria-hidden="true"></i>
						</a>
					</td>
					<td>
						<a class="rmv_order">
							<i class="fa fa-times" aria-hidden="true"></i>
						</a>
					</td>
					<td>
						<a class="edit_order">
							<i class="fa fa-pencil" aria-hidden="true"></i>
						</a>
					</td>
				</tr>
			</table>
		</div>
		<!-- end of tbl_orderList_wrapper -->
	</div>
	<!-- end of orderList_wrapper -->
	<div class="orderDetail_wrapper">
		<div class="tbl_orderDetail_wrapper">
			<table class="table table-bordered table-condensed" id="pkg_tblD">
				<tr>
					<th>
						<span style="width: 32px; display: block;overflow: hidden;">
							
						</span>
					</th>
					<th>
						<span style="width:80px; display: block;overflow: hidden;">
							Product ID
						</span>
					</th>
					<th>
						<span style="width:180px; display: block;overflow: hidden;">
							Product name
						</span>
					</th>
					<th>
						<span style="width:80px; display: block;overflow: hidden;">
							Price
						</span>
					</th>
					<th>
						<span style="width:80px; display: block;overflow: hidden;">
							Price Sale
						</span>
					</th>
					<th>
						<span style="width:40px; display: block;overflow: hidden;">
							Sale
						</span>
					</th>
					<th>
						<span style="width:40px; display: block;overflow: hidden;">
							Qty
						</span>
					</th>
					<th>
						<span style="width:120px; display: block;overflow: hidden;">
							Total Cost/Item
						</span>
					</th>
				</tr>
			</table>
		</div>
		<!-- end of tbl_orderList_wrapper -->
		<div class="sumPrc_bxCtner">
			<div class="sumPrc_board">
				<div class="clt_ifDscr">
					Summary
				</div>
				<div class="clt_ifCtt">
					<span class="pieceInfo">
						<div class="shrtDscr">Customer name</div>
						<div class="fill_ctnSh" id="c_name">Donald Trump</div>
					</span>
					<span class="pieceInfo">
						<div class="shrtDscr">Phone number</div>
						<div class="fill_ctnSh" id="c_phone">0113114115911</div>
					</span>
					<span class="pieceInfo">
						<div class="shrtDscr">Address</div>
						<div class="fill_ctnSh" id="c_add">C 113</div>
					</span>
					<span class="pieceInfo">
						<div class="shrtDscr">Ship status</div>
						<div class="fill_ctnSh atv_ship_pk" id="c_status">
							<i class="fa fa-motorcycle" aria-hidden="true"></i>
						</div>
					</span>
				</div>
				<!-- end of clt_ifCtt -->
				<div class="mnTpco">
					Time order:
					<span id="time_order">12:55 27/09/2016</span>
				</div>
			</div>
			<div class="lw_tPrc">
				<div class="sumPrc_ctner">
					&Sigma;<span id="s_price">932,500</span>
				</div>
				<div class="ttl_nbItems">
					<span id="s_items">34</span> items
				</div>
			</div>
		</div>
		<button class="return_ppage">
			<i class="fa fa-reply" aria-hidden="true"></i>
		</button>
	</div>
	<!-- end of orderList_wrapper -->

</section>
<section class="wrapOrd_st">
	<div class="tbl_wrst">
		<div class="hd_wrp">
			<h1 class="tt_hd_wrp">orders by store</h1>
			<span class="srch_bx">
				<input type="text" id="srch_str" placeholder='search store...'>
				<button id="srch_str_btn">
					<i class="fa fa-search" aria-hidden="true"></i>
				</button>
			</span>
		</div>
		<!-- end of hd_wrp -->
		<div class="major_wr_ct">
			<article class="main_wr_ct">
				<?php for ($i = 0; $i < count($data['store']['info']); $i++) { ?>
				<?php $store_id = $data['store']['info'][$i]['id']; ?>
				<div class="wr_store_c" store-id="<?=$store_id?>">
					<form store_data_f hide>
						<input type="hidden" name="s_id" value="<?=$store_id?>">
						<input type="hidden" name="s_sn" value="<?=$data['store']['info'][$i]['store_name']?>">
						<input type="hidden" name="s_on" value="<?=$data['store']['info'][$i]['owner']?>">
						<input type="hidden" name="s_p" value="<?=$data['store']['info'][$i]['phone']?>">
						<input type="hidden" name="s_fb" value="<?=$data['store']['info'][$i]['facebook']?>">
					</form>
					<div class="wr_st_hd">
						<div class="str_n_hd">
							<?=$data['store']['info'][$i]['store_name']?>
							-
							<?=$data['store']['info'][$i]['owner']?>
						</div>
						<div class="str_opt_wr">
							<button class="str_opt" info-target="<?=$store_id?>">
								<i class="fa fa-info" aria-hidden="true"></i>
							</button>
							<button class="str_opt" hit-target="ord_seen">
								<i class="fa fa-eye" aria-hidden="true"></i>
							</button>
							<button class="str_opt opt_atv" hit-target="ord_notseen">
								<i class="fa fa-eye-slash" aria-hidden="true"></i>
							</button>
							<button class="str_opt" hit-target="ord_text">
								<i class="fa fa-file-text-o" aria-hidden="true"></i>
							</button>
							<button class="str_opt" hit-target="ord_dwnld">
								<i class="fa fa-download" aria-hidden="true"></i>
							</button>
						</div>
					</div>
					<!-- end of wr_st_hd -->
					<div class="store_content">
						<p class="ord_row s_ord_row" hide>
							<span class="ord_col ord_col_1"></span>
							<span class="ord_col ord_col_2"></span>
							<span class="ord_col ord_col_4"></span>
							<span class="ord_col ord_col_3"></span>
						</p>
					 	<div class="store_info" info-receiver="<?=$store_id?>" hide>
							<p title="store name">
								<i class="lnr lnr-store" aria-hidden="true"></i>
								<?=$data['store']['info'][$i]['store_name']?>
							</p>
							<p title="store owner">
								<i class="lnr lnr-user" aria-hidden="true"></i>
								<?=$data['store']['info'][$i]['owner']?>
							</p>
							<p title="facebook account">
								<i class="fa fa-facebook-official" aria-hidden="true"></i>
								<a href="<?=$data['store']['info'][$i]['facebook']?>" target="_blank"><?=$data['store']['info'][$i]['facebook']?></a>
							</p>
							<p title="phone number">
								<i class="fa fa-phone-square" aria-hidden="true"></i>
								<?=$data['store']['info'][$i]['phone']?>
							</p>
						</div>
						<article class="store_ctt_t" receiver="ord_seen" hide>
							<?php if (@$data["store"]["order"][$store_id][1]) : ?>
							<?php for ($j = 0; $j < count($data["store"]["order"][$store_id][1]); $j++) { ?>
							<p class="ord_row">
								<span class="ord_col ord_col_1"><?=$j + 1?></span>
								<span class="ord_col ord_col_2">
								<?=$data["store"]["order"][$store_id][1][$j]['address']?>
								</span>
								<span class="ord_col ord_col_4">
								<?=$data["store"]["order"][$store_id][1][$j]['qty']?>
								</span>
								<span class="ord_col ord_col_3">
								<?=$data["store"]["order"][$store_id][1][$j]['product_name']?>
								</span>
							</p>
							<?php }; ?>
							<?php ENDIF; ?>
						</article>
						<article class="store_ctt_t" receiver="ord_notseen" chosen>
							<?php if (@$data["store"]["order"][$store_id][0]) : ?>
							<?php for ($j = 0; $j < count($data["store"]["order"][$store_id][0]); $j++) { ?>
							<p class="ord_row">
								<span class="ord_col ord_col_1"><?=$j + 1?></span>
								<span class="ord_col ord_col_2">
								<?=$data["store"]["order"][$store_id][0][$j]['address']?>
								</span>
								<span class="ord_col ord_col_4">
								<?=$data["store"]["order"][$store_id][0][$j]['qty']?>
								</span>
								<span class="ord_col ord_col_3">
								<?=$data["store"]["order"][$store_id][0][$j]['product_name']?>
								</span>
							</p>
							<?php }; ?>
							<?php ENDIF; ?>
						</article>
						<textarea class="ord_txt_hlder" receiver="ord_text" hide><?php 
						if (@$data["store"]["order"][$store_id][0]) {
						for ($j = 0; $j < count($data["store"]["order"][$store_id][0]); $j++) {
							echo ($j + 1)." - ".$data["store"]["order"][$store_id][0][$j]['address']." - "
								.$data["store"]["order"][$store_id][0][$j]['qty']." - "
								.$data["store"]["order"][$store_id][0][$j]['product_name']."\n";
						};};
						?></textarea>
					</div>
					<a class="_emt_str_ord" clr_ord_dpl='<?=$store_id?>'>empty</a>
				</div>
				<!-- end of wr_store_c -->
				<?php }; ?>
			</article>
		</div>
	</div>
</section>

<script type="text/javascript">
	function set_preset() {
		this.base_url = "<?php print_r($data["base_url"]); ?>";
		this.hdl = ""; // ID of order
		this.is_pkgD = false; // If header requested Order Detail
		this.start_id = "<?php print_r($data["id_start"]); ?>";
		this.ord_seller = '<?=json_encode($data["store"]["order"])?>';
	}
</script>

	
</script>