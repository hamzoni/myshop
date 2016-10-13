<!DOCTYPE html>
<html>
<head>
	<title>FUD - FPT University Dining</title>	
	<?php include_once "_header.php"; ?>
	<!-- source -->
	<link rel="stylesheet" type="text/css" href="css/client/main.css">
	<link rel="stylesheet" type="text/css" href="css/client/home.css">
	<link rel="stylesheet" type="text/css" href="css/client/color.css">
</head>
<body>

<section class="wrapper">
	 <header class="_header">
	 	<div class="_typeWrapper">
	 		<!-- start of food_type -->
			<div class="food_type">
				<span class="txt_food_type VAAlign">
					popular
				</span>
			</div>
			<div class="food_type">
				<span class="txt_food_type VAAlign">
					sale off
				</span>
			</div>
			<div class="food_type">
				<span class="txt_food_type VAAlign">
					special
				</span>
			</div>
			<!-- end of food_type -->
	 	</div>
	 	<nav class="slide_container">
			<!-- start of carousel slide -->
			<div id="myCarousel" class="carousel slide carousel_size" data-ride="carousel" data-interval="8000">

				<ol class="carousel-indicators">
					<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
					<?php for ($i = 1; $i < 4; $i++) { ?>
					<li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>"></li>
					<?php }; ?>
				</ol>

				<div class="carousel-inner" role="listbox">
					<div class="item active">
						<img food-info-id="11" src="img/1.jpg" alt="Chania">
						<!-- food_narration -->
						<article class="food_narration" add-to-cart>
							<i class="fa fa-cart-plus cart_lil" aria-hidden="true"></i>
							<div class="_veil"></div>
							<div class="mc_fnr">
								<div class="trc_fnr">
									<span class="VAAlign">
										Sample food name
									</span>
								</div>
								<div class="prc_val">
									200K
								</div>
							</div>
						</article>
						<form class="food_data_cluster">
							<input type="hidden" name="f_id" value="11">
							<input type="hidden" name="f_price" value="50000">
							<input type="hidden" name="f_name" value="Chicken">
							<input type="hidden" name="f_dscr" value="tasteless">
							<input type="hidden" name="f_nutri" value="img/sample_nutrition.jpg">
							<input type="hidden" name="f_ava" value="img/1.jpg">
							<input type="hidden" name="f_sale" value="0">
						</form>
					</div>
					<?php for ($i = 2; $i < 5; $i++) { ?>
					<div class="item">
						<img food-info-id="10" src="img/<?php echo $i; ?>.jpg" alt="Chania">
						<!-- food_narration -->
						<article class="food_narration" add-to-cart>
							<i class="fa fa-cart-plus cart_lil" aria-hidden="true"></i>
							<div class="_veil"></div>
							<div class="mc_fnr">
								<div class="trc_fnr">
									<span class="VAAlign">
										Sample food name
									</span>
								</div>
								<div class="prc_val">
									200K
								</div>
							</div>
						</article>
						<form class="food_data_cluster">
							<input type="hidden" name="f_id" value="10">
							<input type="hidden" name="f_price" value="45000">
							<input type="hidden" name="f_name" value="Noodle">
							<input type="hidden" name="f_dscr" value="tasteless">
							<input type="hidden" name="f_nutri" value="img/sample_nutrition.jpg">
							<input type="hidden" name="f_ava" value="img/<?php echo $i; ?>.jpg">
							<input type="hidden" name="f_sale" value="0">
						</form>
					</div>
					<?php }; ?>
				</div>

				<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
			<!-- start of carousel slide -->
			<!-- start of carousel slide 2 -->
			<div id="myCarousel1" class="carousel slide carousel_size" data-ride="carousel" data-interval="8000">

				<ol class="carousel-indicators">
					<li data-target="#myCarousel1" data-slide-to="0" class="active"></li>
					<?php for ($i = 1; $i < 4; $i++) { ?>
					<li data-target="#myCarousel1" data-slide-to="<?php echo $i; ?>"></li>
					<?php }; ?>
				</ol>


				<div class="carousel-inner" role="listbox">

					<div class="item active">
						<img food-info-id="8" src="img/5.jpg" alt="Chania">
						<div class="percentage_slf">
							-67%
						</div>
						<article class="food_narration" add-to-cart>
							<i class="fa fa-cart-plus cart_lil" aria-hidden="true"></i>
							<div class="_veil"></div>
							<div class="mc_fnr">
								<div class="trc_fnr">
									<span class="VAAlign">
										Sample food name
									</span>
								</div>
								<div class="prc_val">
									<span class="prc_origin">
										<span class="_lineCrossed">300k</span>
									</span>
									<span class="prc_discounted">
										99K
									</span>
								</div>
							</div>
						</article>
						<form class="food_data_cluster">
							<input type="hidden" name="f_id" value="8">
							<input type="hidden" name="f_price" value="43000">
							<input type="hidden" name="f_name" value="Noodle">
							<input type="hidden" name="f_dscr" value="tasteless">
							<input type="hidden" name="f_nutri" value="img/sample_nutrition.jpg">
							<input type="hidden" name="f_ava" value="img/5.jpg">
							<input type="hidden" name="f_sale" value="0.67">
						</form>
					</div>
					<?php for ($i = 6; $i < 9; $i++) { ?>
					<div class="item">
						<img food-info-id="7" src="img/<?php echo $i; ?>.jpg" alt="Chania">
						<div class="percentage_slf">
							-67%
						</div>
						<article class="food_narration" add-to-cart>
							<i class="fa fa-cart-plus cart_lil" aria-hidden="true"></i>
							<div class="_veil"></div>
							<div class="mc_fnr">
								<div class="trc_fnr">
									<span class="VAAlign">
										Sample food name
									</span>
								</div>
								<div class="prc_val">
									<span class="prc_origin">
										<span class="_lineCrossed">300k</span>
									</span>
									<span class="prc_discounted">
										99K
									</span>
								</div>
							</div>
						</article>
						<form class="food_data_cluster">
							<input type="hidden" name="f_id" value="7">
							<input type="hidden" name="f_price" value="72000">
							<input type="hidden" name="f_name" value="Noodle">
							<input type="hidden" name="f_dscr" value="tasteless">
							<input type="hidden" name="f_nutri" value="img/sample_nutrition.jpg">
							<input type="hidden" name="f_ava" value="img/<?php echo $i; ?>.jpg">
							<input type="hidden" name="f_sale" value="0.67">
						</form>
					</div>
					<?php }; ?>
				</div>

				<a class="left carousel-control" href="#myCarousel1" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#myCarousel1" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
			<!-- start of carousel slide 2 -->
			<!-- start of carousel slide 3 -->
			<div id="myCarousel2" class="carousel slide carousel_size" data-ride="carousel" data-interval="8000">

				<ol class="carousel-indicators">
					<li data-target="#myCarousel2" data-slide-to="0" class="active"></li>
					<?php for ($i = 1; $i < 4; $i++) { ?>
					<li data-target="#myCarousel2" data-slide-to="<?php echo $i; ?>"></li>
					<?php }; ?>
				</ol>


				<div class="carousel-inner" role="listbox">

					<div class="item active">
						<img food-info-id="6" src="img/9.jpg" alt="Chania">
						<article class="food_narration" add-to-cart>
							<i class="fa fa-cart-plus cart_lil" aria-hidden="true"></i>
							<div class="_veil"></div>
							<div class="mc_fnr">
								<div class="trc_fnr">
									<span class="VAAlign">
										Sample food name
									</span>
								</div>
								<div class="prc_val">
									200K
								</div>
							</div>
						</article>
						<form class="food_data_cluster">
							<input type="hidden" name="f_id" value="10">
							<input type="hidden" name="f_price" value="66000">
							<input type="hidden" name="f_name" value="Duck">
							<input type="hidden" name="f_dscr" value="tasteless">
							<input type="hidden" name="f_nutri" value="img/sample_nutrition.jpg">
							<input type="hidden" name="f_ava" value="img/9.jpg">
							<input type="hidden" name="f_sale" value="0">
						</form>
					</div>
					<?php for ($i = 10; $i < 13; $i++) { ?>
					<div class="item">
						<img food-info-id="5" src="img/<?php echo $i; ?>.jpg" alt="Chania">
						<article class="food_narration" add-to-cart>
							<i class="fa fa-cart-plus cart_lil" aria-hidden="true"></i>
							<div class="_veil"></div>
							<div class="mc_fnr">
								<div class="trc_fnr">
									<span class="VAAlign">
										Sample food name
									</span>
								</div>
								<div class="prc_val">
									200K
								</div>
							</div>
						</article>
						<form class="food_data_cluster">
							<input type="hidden" name="f_id" value="10">
							<input type="hidden" name="f_price" value="92000">
							<input type="hidden" name="f_name" value="Shit">
							<input type="hidden" name="f_dscr" value="tasteless">
							<input type="hidden" name="f_nutri" value="img/sample_nutrition.jpg">
							<input type="hidden" name="f_ava" value="img/<?php echo $i; ?>.jpg">
							<input type="hidden" name="f_sale" value="0">
						</form>
					</div>
					<?php }; ?>
				</div>

				<a class="left carousel-control" href="#myCarousel2" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#myCarousel2" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
			<!-- start of carousel slide 3 -->
	 	</nav>
	 	<nav class="brand_part">
	 		<div class="banner_ctner">
	 				<div id="myCarousel3" class="carousel slide" data-ride="carousel" data-interval="8000">

				<div class="carousel-inner" role="listbox">
					<div class="item active">
						<?php for ($i = 1; $i < 4; $i++) { ?>
						<div class="food_itemCtner">
							<img food-info-id="3" src="img/<?php echo $i;?>.jpg" alt="Chania">
							<div class="minor_dscr_fic" add-to-cart>
								<span class="dsck_n">Sample name</span>
								<span class="dsck_p">15.000</span>
							</div>
							<form class="food_data_cluster">
								<input type="hidden" name="f_id" value="10">
								<input type="hidden" name="f_price" value="22000">
								<input type="hidden" name="f_name" value="Dog meat">
								<input type="hidden" name="f_dscr" value="tasteless">
								<input type="hidden" name="f_nutri" value="img/sample_nutrition.jpg">
								<input type="hidden" name="f_ava" value="img/<?php echo $i; ?>.jpg">
								<input type="hidden" name="f_sale" value="0.17">
							</form>
						</div>
						<?php }; ?>
					</div>
					<?php $n = 4; ?>
					<?php for ($j = 0; $j < 3; $j++) { ?>
					<div class="item">
						<?php for ($i = 0; $i < 3; $i++) { ?>
						<div class="food_itemCtner">
							<img food-info-id="4" src="img/<?php echo $n++;?>.jpg" alt="Chania">
							<div class="minor_dscr_fic" add-to-cart>
								<span class="dsck_n">Sample name</span>
								<span class="dsck_p">15.000</span>
							</div>
							<form class="food_data_cluster">
								<input type="hidden" name="f_id" value="4">
								<input type="hidden" name="f_price" value="15000">
								<input type="hidden" name="f_name" value="Cake">
								<input type="hidden" name="f_dscr" value="tasteless">
								<input type="hidden" name="f_nutri" value="img/sample_nutrition.jpg">
								<input type="hidden" name="f_ava" value="img/<?php echo $n; ?>.jpg">
								<input type="hidden" name="f_sale" value="0.33">
							</form>
						</div>
						<?php }; ?>
					</div>
					<?php }; ?>
				</div>

				<button class="slide_nav_ctrl" href="#myCarousel3" role="button" data-slide="prev">
					<i class="fa fa-chevron-left" aria-hidden="true"></i>
				</button>
				<button class="slide_nav_ctrl" href="#myCarousel3" role="button" data-slide="next">
					<i class="fa fa-chevron-right" aria-hidden="true"></i>
				</button>
			</div>
	 		</div>
	 		<div class="logo_ctner">
	 			<img src="img/sample_logo.png">
	 			<div class="company_info">
	 				<a href="#" class="contacts">
	 					<i class="fa fa-globe" aria-hidden="true"></i>
	 					www.FUDining.com
	 				</a>
	 				<a href="#" class="contacts">
	 					<i class="fa fa-phone-square" aria-hidden="true"></i>
	 					012.345.6969
	 				</a>
	 				<a href="#" class="contacts">
	 					<i class="fa fa-envelope" aria-hidden="true"></i>
	 					FUDining@gmail.com
	 				</a>
	 				<a href="#" class="contacts">
	 					<i class="fa fa-facebook-official" aria-hidden="true"></i>
	 					fb.com/subway
	 				</a>
	 			</div>
	 		</div>
	 	</nav>
	 </header>
	 <section class="main_menu">
	 	<?php $n = 1 ?>
	 	<?php for ($i = 0; $i < 15; $i++) { ?>
	 	<div class="dishes">
	 		<div class="dishes_content">
	 			<div class="discount_tag">
	 				-67%
	 			</div>
	 			<img food-info-id="2" src="img/<?php echo $n++ >= 12 ? $n = 1 : $n;?>.jpg" title="view detail"/>
	 			<div class="minor_dscr_fic" title="add to cart" add-to-cart>
					<span class="dsck_n">Sample name</span>
					<span class="dsck_p">15.000</span>
					<button class="add_to_cart">
						<i class="fa fa-shopping-cart" aria-hidden="true"></i>
					</button>
				</div>
				<form class="food_data_cluster">
					<input type="hidden" name="f_id" value="2">
					<input type="hidden" name="f_price" value="38500">
					<input type="hidden" name="f_name" value="Cat">
					<input type="hidden" name="f_dscr" value="tasteless">
					<input type="hidden" name="f_nutri" value="img/sample_nutrition.jpg">
					<input type="hidden" name="f_ava" value="img/<?php echo $n; ?>.jpg">
					<input type="hidden" name="f_sale" value="0.67">
				</form>
	 		</div>
	 	</div>
	 	<?php }; ?>
	 </section>
</section>
<!-- end of wrapper -->
<nav class="free_nav_bar">
 	<button class="_myCart" id="client_cart">
 		<i class="fa fa-shopping-basket" aria-hidden="true"></i>
 	</button>
 	<div id="nbr_itemsIC">
 		0
 	</div>
 </nav>
<!-- start of pop-up cluster -->
<div class="general_popUp cart_detail clr_dark shd_white" style="display:none;">
	<div class="dragger_ttl">
		<h2 class="hd_ttl VAAlign">cart</h2>
		<button class="close_btn">
			<i class="fa fa-times" aria-hidden="true"></i>
		</button>
	</div>
	<div class="main_cartCtner clr_dark2">
		<table class="table table-condensed fixed_col">
			<col width="30px"/>
			<col width="260px"/>
			<col width="35px"/>
			<col width=""/>
			<col width="30px"/>
			<tr>
				<th></th>
				<th>Item name</th>
				<th>Qty</th>
				<th>Price</th>
				<th></th>
			</tr>
		</table>
		<div class="tbl_main_wrpC shd_white_inset">
			<table id="cart_dataTbl" class="table table-condensed main_ctnCol">
				<col width="30px"/>
				<col width="260px"/>
				<col width="35px"/>
				<col width=""/>
				<col width="30px"/>
				<tr>
					<td idx></td>
					<td fdn>
						<a food-info-id="1">
							Sample food name
						</a>
					</td>
					<td qty>
						<input type="text" maxlength="2" qty_inCart value="1" class="qty_cIp">
					</td>
					<td prc>50.000</td>
					<td>
						<a class="remove_itemCart">
							<i class="fa fa-times" aria-hidden="true"></i>
						</a>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="cart_footer">
		<div class="left_cfter">
			<span class="upper_lcfter">
				<a id="clear_cart">Cancle order</a>
			</span>
			<span class="lower_lcfter">
				&Sigma;
				<span id="sum_billC">
				0
				</span>
			</span>
		</div>
		<div class="right_cfter">
			<a class="chkOut_smt">
				<span class="VAAlign">Proceed</span>
			</a>
		</div>
	</div>
</div>
<div class="general_popUp food_detail clr_dark shd_white" style="display:none;">
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
<div class="general_popUp ship_info clr_dark shd_white" style="display:none;">
	<form action="" method="GET" class="shipIF_stl">
	<div class="dragger_ttl">
		<h2 class="hd_ttl VAAlign">SHIPPING INFO</h2>
		<button class="close_btn">
			<i class="fa fa-times" aria-hidden="true"></i>
		</button>
	</div>
	<div class="main_cartCtner clr_dark2">
		<div class="ip_shIpGr">
			<span class="lbl_ipClts">
				<label class="spc_lbl" for="client_name">Full name</label>
				<input type="text" name="client_name"/>
			</span>
		</div>
		<div class="ip_shIpGr">
			<span class="lbl_ipClts">
				<label class="spc_lbl" for="client_phone">Phone</label>
				<input type="text" name="client_phone"/>
			</span>
			<span class="lbl_ipClts">
				<label class="spc_lbl" for="client_address">DOM,Room</label>
				<input type="text" name="client_address"/>
			</span>
		</div>
		<div class="ip_shIpGr">
			<input type="checkbox" name="save_data_cookie" class="chkbx_saveDt"/>
			<label for="save_data_cookie">Save data in this computer?</label>
		</div>
	</div>
	<div class="cart_footer crt_fter_sIf">
		<input type="submit" value="proceed"/>
	</div>
	</form>
</div>
<!-- end of pop-up cluster -->
<!-- start of ctner_ppuntf -->
<div id="ppu_ntf" class="clrD_whiteB">
	Đã thêm
	<span id="fd_ntf">sample product name</span>
	vào giỏ hàng
</div>
<!-- end of ctner_ppuntf -->

<script type="text/javascript" src="js/general/string_modify.js"></script>
<script type="text/javascript" src="js/client/home_data.js"></script>
<script type="text/javascript" src="js/client/home.js"></script>
</body>
</html>