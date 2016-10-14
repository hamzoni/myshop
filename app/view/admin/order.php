<section class="wrapBoth_ordL">

	<div class="orderList_wrapper">
		<div class="tbl_orderList_wrapper">
			<table class="table table-bordered table-condensed">
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
				<tr package-id='1' title="View order detail">
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
			<table class="table table-bordered table-condensed">
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
				<tr>
					<td>1</td>
					<td>PR0012</td>
					<td>Pepperoni pizza</td>
					<td>90,000</td>
					<td>5</td>
					<td>450,000</td>
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
						<div class="fill_ctnSh">Donald Trump</div>
					</span>
					<span class="pieceInfo">
						<div class="shrtDscr">Phone number</div>
						<div class="fill_ctnSh">0113114115911</div>
					</span>
					<span class="pieceInfo">
						<div class="shrtDscr">Address</div>
						<div class="fill_ctnSh">C 113</div>
					</span>
					<span class="pieceInfo">
						<div class="shrtDscr">Ship status</div>
						<div class="fill_ctnSh">SHIPPED</div>
					</span>
				</div>
				<!-- end of clt_ifCtt -->
				<div class="mnTpco">
					Time order: 12:55 27/09/2016
				</div>
			</div>
			<div class="lw_tPrc">
				<div class="sumPrc_ctner">
					&Sigma;932,500 
				</div>
				<div class="ttl_nbItems">
					(34 items)
				</div>
			</div>
		</div>
		<button class="return_ppage">
			<i class="fa fa-reply" aria-hidden="true"></i>
		</button>
	</div>
	<!-- end of orderList_wrapper -->

</section>
<script type="text/javascript">
	var base_url = "<?php print_r($data["base_url"]); ?>";
	var hdl = ""; // ID of order
	var is_pkgD = false; // If header requested Order Detail
</script>
<script type="text/javascript" src="js/admin/order.js">
	
</script>