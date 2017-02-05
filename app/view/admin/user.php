<section class="wrapBoth_ordL">

	<div class="orderList_wrapper">
		<div class="tbl_userList_wrapper">
			<div class="tbl_wrp_main">
				<table class="table table-bordered table-condensed" id="cLr_ct">
					<!-- 1 stt -->
					<col width="31px">
					<!-- 2 order_ID -->
					<col width="55px">
					<!-- 3 client_name -->
					<col width="">
					<!-- 4 client_phone -->
					<col width="120px">
					<!-- 5 client_address -->
					<col width="60px">
					<!-- 6 purchase_count -->
					<col width="60px">
					<!-- 7 purchase_val -->
					<col width="90px">
					<!-- 8 signup_date -->
					<col width="150px">
					<!-- 9 last_update -->
					<col width="150px">
					<!-- 10 product_options: edit -->
					<col width="30px">
					<!-- 11 product_options: edit -->
					<col width="30px">
					<!-- 12 product_options: edit -->
					<col width="30px">
					<tr>
						<th></th>
						<th>ID</th>
						<th>Username</th>
						<th>Phone</th>
						<th>Address</th>
						<th>PC</th>
						<th>PV</th>
						<th>Signup date</th>
						<th>Last activity</th>
						<th>S</th>
						<th colspan="2">R / E</th>
					</tr>
					<tr class="order_tr" style="display:none" title="View order detail">
						<td><input class="slct_r" type="checkbox"></td>
						<td user-id="12">OD0012</td>
						<td>Hillary Trump</td>
						<td>0113114115911</td>
						<td>C 113</td>
						<td>9,999</td>
						<td>99,999,999</td>
						<td>12:55 27/09/2016</td>
						<td>12:55 27/09/2016</td>
						<td>
							<a class="stt_acc">
								<i class="fa fa-ban" aria-hidden="true"></i>
							</a>
						</td>
						<td>
							<a class="rmv_acc">
								<i class="fa fa-times" aria-hidden="true"></i>
							</a>
						</td>
						<td>
							<a class="edit_acc">
								<i class="fa fa-pencil" aria-hidden="true"></i>
							</a>
						</td>
					</tr>
				</table>
			</div>
			<div class="pagn_tbl">
				<button class="pgn_nav_b" id="pgn_left">
					<i class="fa fa-arrow-left" aria-hidden="true"></i>
				</button>
				<ul class="nav_ctn"> 
				</ul>
				<button class="pgn_nav_b" id="pgn_right">
					<i class="fa fa-arrow-right" aria-hidden="true"></i>
				</button>
			</div> 
		</div>
		<!-- end of tbl_userList_wrapper -->
	</div>
	<!-- end of orderList_wrapper -->
</section>
<script type="text/javascript">
	function set_preset() {
		this.base_url = "<?php print_r($data["base_url"]); ?>";
		this.maxData_length = JSON.parse(<?php print_r($data["input_length"]);?>);
	}

</script>

	
</script>