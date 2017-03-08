<section class="wrapBoth_ordL">

	<div class="orderList_wrapper">
		<div class="tbl_userList_wrapper" id="client_tbl">
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
		<div class="tbl_userList_wrapper" id="user_tbl">
			<div class="tbl_wrp_main" id="clr_ur">
				<section class="user_tblD">
					<div class="user_rec" hide>
						<div class="ur_c1" u_av><img></div>
						<div class="ur_c2">
							<div class="ur_r" u_fn>Trần Duật</div>
							<div class="ur_r" u_em>sample@mail-domain.com</div>
						</div>
						<div class="ur_c3">
							<div class="ur_r" u_gd>Male</div>
							<div class="ur_r" u_pv>Facebook</div>
						</div>
						<div class="ur_c4">
							<div class="ur_r">
								<span class="ur_tc">signup</span>
								<span class="ur_sg" u_cr>18:01:00 12-02-2017</span>
							</div>
							<div class="ur_r">
								<span class="ur_tc">last login</span>
								<span class="ur_lg" u_ud>18:01:00 12-02-2017</span>
							</div>
						</div>
						<div class="ur_c5">
							<div class="ur_r">
								<a class="ur_opt" u_bn>
									<i class="fa fa-ban" aria-hidden="true"></i>
								</a>
							</div>
							<div class="ur_r">
								<a class="ur_opt" target="_blank" fb_u>
									<i class="fa fa-link" aria-hidden="true"></i>
								</a>
							</div>
						</div>
					</div>
				</section>
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
	<form class="ban_dialog" name="ban_form" style="width: 258px" hide>
		<div class="bd_l_wrp">
			<section class="bd_header">
				<div class="bdh_tt">
					<p class="bdh_tt_txt">
						schedule user ban
					</p>
				</div>
				<a class=bd_close>
					<i class="fa fa-times" aria-hidden="true"></i>
				</a>
			</section>
			<div class="bd_m_wr">
				<section class="bd_schedule">
					<div class="bd_r">
						<div class="bd_cl">From</div>
						<div class="bd_cr">
							<button class="_choose_now_btn" sender="start_date">
								<i class="fa fa-clock-o" aria-hidden="true"></i>
							</button>
							<div class="dpl_start_date">
								<!-- start of prompt_choose_start -->
								<div class="prompt_choose_start">
									<span class="group_time">
										<input type="text" name="s_hh" max-length="2" max-val="24" min-val="0" placeholder="hh">
										<span class="spc_char">:</span>
										<input type="text" name="s_MM" max-length="2" max-val="60" min-val="0" placeholder="MM">
										<span class="spc_char">:</span>
										<input type="text" name="s_ss" max-length="2" max-val="60" min-val="0" placeholder="ss">
									</span>
									<span class="group_date">
										<input type="text" name="s_dd" max-length="2" max-val="31" min-val="1" placeholder="dd">
										<span class="spc_char">/</span>
										<input type="text" name="s_mm" max-length="2" max-val="12" min-val="1" placeholder="mm">
										<span class="spc_char">/</span>
										<input type="text" name="s_YY" max-length="4" max-val="<?=intval(date('Y')) + 100?>" min-val="<?=intval(date('Y'))?>" placeholder="yyyy">
									</span>
								</div>
								<!-- end of prompt_choose_start -->
							</div>
							<button class="_choose_calendar" sender="start_date">
								<i class="fa fa-calendar" aria-hidden="true"></i>
							</button>
						</div>
					</div>
					<div class="bd_rb">
						<div class="bd_cl">To</div>
						<div class="bd_cr_l">
							<div class="bd_cr">
								<button class="_choose_now_btn" sender="end_date">
									<i class="fa fa-clock-o" aria-hidden="true"></i>
								</button>
								<div class="dpl_end_date">
									<!-- start of prompt_choose_start -->
									<div class="prompt_choose_start">
										<span class="group_time">
											<input type="text" name="e_hh" max-length="2" max-val="24" min-val="0" placeholder="hh">
											<span class="spc_char">:</span>
											<input type="text" name="e_MM" max-length="2" max-val="60" min-val="0" placeholder="MM">
											<span class="spc_char">:</span>
											<input type="text" name="e_ss" max-length="2" max-val="60" min-val="0" placeholder="ss">
										</span>
										<span class="group_date">
											<input type="text" name="e_dd" max-length="2" max-val="31" min-val="1" placeholder="dd">
											<span class="spc_char">/</span>
											<input type="text" name="e_mm" max-length="2" max-val="12" min-val="1" placeholder="mm">
											<span class="spc_char">/</span>
											<input type="text" name="e_YY" max-length="4" max-val="<?=intval(date('Y')) + 100?>" min-val="<?=intval(date('Y'))?>" placeholder="yyyy">
										</span>
									</div>
									<!-- end of prompt_choose_start -->
								</div>
								<button class="_choose_calendar" sender="end_date">
									<i class="fa fa-calendar" aria-hidden="true"></i>
								</button>
							</div>
							<div class="bd_cr">
								<input type="text" name="ext_v" max-length="2" class="extend_b_val" placeholder="00" diff_date>
								<div class="extend_b_type">
									<input type="hidden" name="ext_t" value="2">
									<div class="dpl_b_opt opt_down" receiver='ext_ban'>day</div>
									<div class="ext_b_opt" sender='ext_ban' hide>
										<span value="0">minute</span>
										<span value="1">hour</span>
										<span value="2">day</span>
										<span value="3">month</span>
										<span value="4">year</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="bd_r p_b_o">
						<input type="checkbox" name="p_ban" class="chbx">
						<span class="tt_chb_ct">
							permanent ban
						</span>
					</div>
				</section>
				<section class="bd_extend_opt">
					<div class="bd_r">
						<span class="bd_att">
							auto extend interval
						</span>
						<input type="text" name="ext_va" max-length="2" class="extend_b_val" placeholder="00">
						<div class="extend_b_auto">
							<input type="hidden" name="ext_a" value="2">
							<div class="dpl_b_opt opt_down" receiver='ext_auto'>day</div>
							<div class="ext_b_opt" sender='ext_auto' hide>
								<span value="0">minute</span>
								<span value="1">hour</span>
								<span value="2">day</span>
								<span value="3">month</span>
							</div>
						</div>
					</div>
					<input type="submit" class="ban_submit" value="ban user">
					<input type="button" class="rmv_ur_ban" value="remove ban">
				</section>
			</div>
		</div>
		<!-- end of bd_l_wrp -->
		<div class="bd_r_wrp" style="visibility: hidden;">
			<div class="bd_r_b">
				<input type="text" id="dpl_date_ip" gldp-id="calendar_output" disabled>
			</div>
			<div class="bd_cld">
				<div class="bd_clt" gldp-el="calendar_output">
					
				</div>
			</div>
		</div>
		<!-- end of bd_r_wrp -->
	</div>

</form>
<script type="text/javascript">
	function set_preset() {
		this.base_url = "<?php print_r($data["base_url"]); ?>";
		this.maxData_length = JSON.parse(<?php print_r($data["input_length"]);?>);
		this.start_id = "<?php print_r($data["id_start"]); ?>";
	}

</script>