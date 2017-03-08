<!DOCTYPE html>
<html>
<head>
	<title>
		<?=$data["contact"]["wHpgtt"]?>
	</title>	
	<?php include_once "_header.php"; ?>
	<script type="text/javascript" src="js/client/fb_auth.js"></script>
</head>
<body>
<?php

?>
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
			<!-- start of carousel slide popular -->
			<div id="myCarousel" fd_tp='0' class="carousel slide carousel_size" data-ride="carousel" data-interval="8000">

				<ol class="carousel-indicators">
					<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
					<?php for ($i = 1; $i < count($data["items"]["popular"]); $i++) { ?>
					<li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>"></li>
					<?php }; ?>
				</ol>

				<div class="carousel-inner" role="listbox">
					<div class="item active">
						<img food-info-id="<?=$data["items"]["popular"][0]['id']?>" src="<?=$data["items"]["popular"][0]['avatar_img']?>" alt="Chania">
						<!-- food_narration -->
						<article class="food_narration" add-to-cart>
							<i class="fa fa-cart-plus cart_lil" aria-hidden="true"></i>
							<div class="_veil"></div>
							<div class="mc_fnr">
								<div class="trc_fnr">
									<span class="VAAlign">
									<?=$data["items"]["popular"][0]['name']?>
									</span>
								</div>
								<div class="prc_val">
									<?=$data["items"]["popular"][0]['price_s']?>
								</div>
							</div>
						</article>
						<form class="food_data_cluster">
							<input type="hidden" name="f_id" value="<?=$data["items"]["popular"][0]["id"]?>">
							<input type="hidden" name="f_price" value="<?=$data["items"]["popular"][0]["price"]?>">
							<input type="hidden" name="f_price_s" value="<?=$data["items"]["popular"][0]["price_s"]?>">
							<input type="hidden" name="f_name" value="<?=$data["items"]["popular"][0]["name"]?>">
							<input type="hidden" name="f_dscr" value="<?=$data["items"]["popular"][0]["description"]?>">
							<input type="hidden" name="f_nutri" value="<?=$data["items"]["popular"][0]["nutrition_img"]?>">
							<input type="hidden" name="f_ava" value="<?=$data["items"]["popular"][0]["avatar_img"]?>">
							<input type="hidden" name="f_sale" value="<?=$data["items"]["popular"][0]["sale"]?>">
							<input type="hidden" name="f_vendorID" value="<?=$data["items"]["popular"][0]["store_id"]?>">
						</form>
					</div>
					<?php for ($i = 1; $i < count($data["items"]["popular"]); $i++) { ?>
					<div class="item">
						<img food-info-id="<?=$data["items"]["popular"][$i]["id"]?>" src="<?=$data["items"]["popular"][$i]["avatar_img"]?>" alt="Chania">
						<!-- food_narration -->
						<article class="food_narration" add-to-cart>
							<i class="fa fa-cart-plus cart_lil" aria-hidden="true"></i>
							<div class="_veil"></div>
							<div class="mc_fnr">
								<div class="trc_fnr">
									<span class="VAAlign">
									<?=$data["items"]["popular"][$i]["name"]?>
									</span>
								</div>
								<div class="prc_val">
								<?=$data["items"]["popular"][$i]["price_s"]?>
								</div>
							</div>
						</article>
						<form class="food_data_cluster">
							<input type="hidden" name="f_id" value="<?=$data["items"]["popular"][$i]["id"]?>">
							<input type="hidden" name="f_price" value="<?=$data["items"]["popular"][$i]["price"]?>">
							<input type="hidden" name="f_price_s" value="<?=$data["items"]["popular"][$i]["price_s"]?>">
							<input type="hidden" name="f_name" value="<?=$data["items"]["popular"][$i]["name"]?>">
							<input type="hidden" name="f_dscr" value="<?=$data["items"]["popular"][$i]["description"]?>">
							<input type="hidden" name="f_nutri" value="<?=$data["items"]["popular"][$i]["nutrition_img"]?>">
							<input type="hidden" name="f_ava" value="<?=$data["items"]["popular"][$i]["avatar_img"]?>">
							<input type="hidden" name="f_sale" value="<?=$data["items"]["popular"][$i]["sale"]?>">
							<input type="hidden" name="f_vendorID" value="<?=$data["items"]["popular"][$i]["store_id"]?>">
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
			<!-- start of carousel slide 2 sale -->
			<div id="myCarousel1" fd_tp='1' class="carousel slide carousel_size" data-ride="carousel" data-interval="8000">

				<ol class="carousel-indicators">
					<li data-target="#myCarousel1" data-slide-to="0" class="active"></li>
					<?php for ($i = 1; $i < count($data["items"]["saleOff"]); $i++) { ?>
					<li data-target="#myCarousel1" data-slide-to="<?php echo $i; ?>"></li>
					<?php }; ?>
				</ol>

				<div class="carousel-inner" role="listbox">

					<div class="item active">
						<img food-info-id="<?=$data["items"]["saleOff"][0]["id"];?>" src="<?=$data["items"]["saleOff"][0]["avatar_img"];?>" alt="<?=$data["items"]["saleOff"][0]["name"];?>">
						<div class="percentage_slf" sale-tag>
						<?=$data["items"]["saleOff"][0]["sale"];?>
						</div>
						<article class="food_narration" add-to-cart>
							<i class="fa fa-cart-plus cart_lil" aria-hidden="true"></i>
							<div class="_veil"></div>
							<div class="mc_fnr">
								<div class="trc_fnr">
									<span class="VAAlign">
									<?=$data["items"]["saleOff"][0]["name"];?>
									</span>
								</div>
								<div class="prc_val">
									<span class="prc_origin">
										<span class="_lineCrossed">
										<?=$data["items"]["saleOff"][0]["price"];?>
										</span>
									</span>
									<span class="prc_discounted">
										99K
									</span>
								</div>
							</div>
						</article>
						<form class="food_data_cluster">
							<input type="hidden" name="f_id" value="<?=$data["items"]["saleOff"][0]["id"]?>">
							<input type="hidden" name="f_price" value="<?=$data["items"]["saleOff"][0]["price"]?>">
							<input type="hidden" name="f_name" value="<?=$data["items"]["saleOff"][0]["name"]?>">
							<input type="hidden" name="f_dscr" value="<?=$data["items"]["saleOff"][0]["description"]?>">
							<input type="hidden" name="f_nutri" value="<?=$data["items"]["saleOff"][0]["nutrition_img"]?>">
							<input type="hidden" name="f_ava" value="<?=$data["items"]["saleOff"][0]["avatar_img"]?>">
							<input type="hidden" name="f_sale" value="<?=$data["items"]["saleOff"][0]["sale"]?>">
							<input type="hidden" name="f_vendorID" value="<?=$data["items"]["saleOff"][0]["store_id"]?>">
						</form>
					</div>
					<?php for ($i = 1; $i < count($data["items"]["saleOff"]); $i++) { ?>
					<div class="item">
						<img food-info-id="<?=$data["items"]["saleOff"][$i]["id"];?>" src="<?=$data["items"]["saleOff"][$i]["avatar_img"];?>" alt="<?=$data["items"]["saleOff"][$i]["name"];?>">
						<div class="percentage_slf" sale-tag>
						<?=$data["items"]["saleOff"][$i]["sale"];?>
						</div>
						<article class="food_narration" add-to-cart>
							<i class="fa fa-cart-plus cart_lil" aria-hidden="true"></i>
							<div class="_veil"></div>
							<div class="mc_fnr">
								<div class="trc_fnr">
									<span class="VAAlign">
									<?=$data["items"]["saleOff"][$i]["name"];?>
									</span>
								</div>
								<div class="prc_val">
									<span class="prc_origin">
										<span class="_lineCrossed">
										<?=$data["items"]["saleOff"][$i]["price"];?>
										</span>
									</span>
									<span class="prc_discounted">
										99K
									</span>
								</div>
							</div>
						</article>
						<form class="food_data_cluster">
							<input type="hidden" name="f_id" value="<?=$data["items"]["saleOff"][$i]["id"]?>">
							<input type="hidden" name="f_price" value="<?=$data["items"]["saleOff"][$i]["price"]?>">
							<input type="hidden" name="f_name" value="<?=$data["items"]["saleOff"][$i]["name"]?>">
							<input type="hidden" name="f_dscr" value="<?=$data["items"]["saleOff"][$i]["description"]?>">
							<input type="hidden" name="f_nutri" value="<?=$data["items"]["saleOff"][$i]["nutrition_img"]?>">
							<input type="hidden" name="f_ava" value="<?=$data["items"]["saleOff"][$i]["avatar_img"]?>">
							<input type="hidden" name="f_sale" value="<?=$data["items"]["saleOff"][$i]["sale"]?>">
							<input type="hidden" name="f_vendorID" value="<?=$data["items"]["saleOff"][$i]["store_id"]?>">
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
			<!-- start of carousel slide 3 special -->
			<div id="myCarousel2" fd_tp='2' class="carousel slide carousel_size" data-ride="carousel" data-interval="8000">

				<ol class="carousel-indicators">
					<li data-target="#myCarousel2" data-slide-to="0" class="active"></li>
					<?php for ($i = 1; $i < count($data["items"]["special"]); $i++) { ?>
					<li data-target="#myCarousel2" data-slide-to="<?php echo $i; ?>"></li>
					<?php }; ?>
				</ol>


				<div class="carousel-inner" role="listbox">

					<div class="item active">
						<img food-info-id="<?=$data["items"]["special"][0]['id'];?>" src="<?=$data["items"]["special"][0]['avatar_img'];?>" alt="<?=$data["items"]["special"][0]['name'];?>">
						<article class="food_narration" add-to-cart>
							<i class="fa fa-cart-plus cart_lil" aria-hidden="true"></i>
							<div class="_veil"></div>
							<div class="mc_fnr">
								<div class="trc_fnr">
									<span class="VAAlign">
									<?=$data["items"]["special"][0]['name'];?>
									</span>
								</div>
								<div class="prc_val">
								<?=$data["items"]["special"][0]['price_s'];?>
								</div>
							</div>
						</article>
						<form class="food_data_cluster">
							<input type="hidden" name="f_id" value="<?=$data["items"]["special"][0]["id"]?>">
							<input type="hidden" name="f_price" value="<?=$data["items"]["special"][0]["price"]?>">
							<input type="hidden" name="f_price_s" value="<?=$data["items"]["special"][0]["price_s"]?>">
							<input type="hidden" name="f_name" value="<?=$data["items"]["special"][0]["name"]?>">
							<input type="hidden" name="f_dscr" value="<?=$data["items"]["special"][0]["description"]?>">
							<input type="hidden" name="f_nutri" value="<?=$data["items"]["special"][0]["nutrition_img"]?>">
							<input type="hidden" name="f_ava" value="<?=$data["items"]["special"][0]["avatar_img"]?>">
							<input type="hidden" name="f_sale" value="<?=$data["items"]["special"][0]["sale"]?>">
							<input type="hidden" name="f_vendorID" value="<?=$data["items"]["special"][0]["store_id"]?>">
						</form>
					</div>
					<?php for ($i = 1; $i < count($data["items"]["special"]); $i++) { ?>
					<div class="item">
						<img food-info-id="<?=$data["items"]["special"][$i]["id"]?>" src="<?=$data["items"]["special"][$i]["avatar_img"]?>" alt="<?=$data["items"]["special"][$i]["name"]?>">
						<article class="food_narration" add-to-cart>
							<i class="fa fa-cart-plus cart_lil" aria-hidden="true"></i>
							<div class="_veil"></div>
							<div class="mc_fnr">
								<div class="trc_fnr">
									<span class="VAAlign">
									<?=$data["items"]["special"][$i]["name"]?>
									</span>
								</div>
								<div class="prc_val">
								<?=$data["items"]["special"][$i]["price_s"]?>
								</div>
							</div>
						</article>
						<form class="food_data_cluster">
							<input type="hidden" name="f_id" value="<?=$data["items"]["special"][$i]["id"]?>">
							<input type="hidden" name="f_price" value="<?=$data["items"]["special"][$i]["price"]?>">
							<input type="hidden" name="f_price_s" value="<?=$data["items"]["special"][$i]["price_s"]?>">
							<input type="hidden" name="f_name" value="<?=$data["items"]["special"][$i]["name"]?>">
							<input type="hidden" name="f_dscr" value="<?=$data["items"]["special"][$i]["description"]?>">
							<input type="hidden" name="f_nutri" value="<?=$data["items"]["special"][$i]["nutrition_img"]?>">
							<input type="hidden" name="f_ava" value="<?=$data["items"]["special"][$i]["avatar_img"]?>">
							<input type="hidden" name="f_sale" value="<?=$data["items"]["special"][$i]["sale"]?>">
							<input type="hidden" name="f_vendorID" value="<?=$data["items"]["special"][$i]["store_id"]?>">
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
	 	
	 	<header class="user_barTab">
	 		<nav class="ctc_ct">
	 			<div class="fb_login_wr">
		 			<a class="btn btn-block btn-social btn-facebook" href="<?=@$data["fb_url"]["href"]?>">
		 				 <span class="fa fa-facebook"></span>
		 				<?=@$data["fb_url"]["label"]?>
		 			</a>
				</div>
 				<a class="nvCtD VAAlign" id="phone_prompt"><i class="fa fa-phone" aria-hidden="true"></i></a>
 				<a class="nvCtD VAAlign" target="_blank" href="<?=$data['contact']['wFBacc'][0]['data']?>">
 					<i class="fa fa-facebook" aria-hidden="true"></i>
 				</a>
 				<a class="nvCtD VAAlign" phone_val="<?=$data['contact']['wPhone'][0]['data']?>" id="contact_info_b"><i class="fa fa-info" aria-hidden="true"></i></a>
 			</nav>
	 	</header>

	 	<nav class="brand_part">
	 		<?php if (count($this->page_data["items"]["suggest"]) > 1) { ?>
	 		<div class="banner_ctner">
	 			<div id="myCarousel3" class="carousel slide" data-ride="carousel" data-interval="8000">
					<div class="carousel-inner" role="listbox">
						<div class="item active">
							<?php for ($i = 0; $i < count($data["items"]["suggest"][0]); $i++) { ?>
							<div class="food_itemCtner">
								<img food-info-id="<?=$data["items"]["suggest"][0][$i]['id']?>" src="<?=$data["items"]["suggest"][0][$i]['avatar_img']?>" alt="<?=$data["items"]["suggest"][0][$i]['name']?>">
								<div class="minor_dscr_fic" add-to-cart>
									<span class="dsck_n"><?=$data["items"]["suggest"][0][$i]['name']?></span>
									<span class="dsck_p"><?=$data["items"]["suggest"][0][$i]['price']?></span>
								</div>
								<form class="food_data_cluster">
									<input type="hidden" name="f_id" value="<?=$data["items"]["suggest"][0][$i]['id']?>">
									<input type="hidden" name="f_price" value="<?=$data["items"]["suggest"][0][$i]['price']?>">
									<input type="hidden" name="f_name" value="<?=$data["items"]["suggest"][0][$i]['name']?>">
									<input type="hidden" name="f_dscr" value="<?=$data["items"]["suggest"][0][$i]['description']?>">
									<input type="hidden" name="f_nutri" value="<?=$data["items"]["suggest"][0][$i]['nutrition_img']?>">
									<input type="hidden" name="f_ava" value="<?=$data["items"]["suggest"][0][$i]['avatar_img']?>">
									<input type="hidden" name="f_sale" value="<?=$data["items"]["suggest"][0][$i]['sale']?>">
									<input type="hidden" name="f_vendorID" value="<?=$data["items"]["suggest"][0][$i]["store_id"]?>">
								</form>
							</div>
							<?php }; ?>
						</div>
						<?php if (count($this->page_data["items"]["suggest"]) > 1) { ?>
						<?php for ($j = 1; $j < count($this->page_data["items"]["suggest"]); $j++) { ?>
						<div class="item">
							<?php for ($i = 0; $i < count($this->page_data["items"]["suggest"][$j]); $i++) { ?>
							<div class="food_itemCtner">
								<img food-info-id="<?=$this->page_data["items"]["suggest"][$j]['id']?>" src="<?=$this->page_data["items"]["suggest"][$j][$i]['avatar_img']?>" alt="<?=$this->page_data["items"]["suggest"][$j][$i]['name']?>">
								<div class="minor_dscr_fic" add-to-cart>
									<span class="dsck_n"><?=$this->page_data["items"]["suggest"][$j][$i]['name']?></span>
									<span class="dsck_p"><?=$this->page_data["items"]["suggest"][$j][$i]['price']?></span>
								</div>
								<form class="food_data_cluster">
									<input type="hidden" name="f_id" value="<?=$data["items"]["suggest"][$j][$i]['id']?>">
									<input type="hidden" name="f_price" value="<?=$data["items"]["suggest"][$j][$i]['price']?>">
									<input type="hidden" name="f_name" value="<?=$data["items"]["suggest"][$j][$i]['name']?>">
									<input type="hidden" name="f_dscr" value="<?=$data["items"]["suggest"][$j][$i]['description']?>">
									<input type="hidden" name="f_nutri" value="<?=$data["items"]["suggest"][$j][$i]['nutrition_img']?>">
									<input type="hidden" name="f_ava" value="<?=$data["items"]["suggest"][$j][$i]['avatar_img']?>">
									<input type="hidden" name="f_sale" value="<?=$data["items"]["suggest"][$j][$i]['sale']?>">
									<input type="hidden" name="f_vendorID" value="<?=$data["items"]["suggest"][$j][$i]["store_id"]?>">
								</form>
							</div>
							<?php }; ?>
						</div>
						<?php }; ?>
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
	 		<?php }; ?>
	 		<div class="logo_ctner">
	 			<img id="page_brdLg" src="<?=$data["contact"]["wBLogo"]?>">
	 		</div>
	 	</nav>
	 </header>
	 <div class="dishes" id="smp_cltD" style="display:none">
 		<div class="dishes_content">
 			<div class="discount_tag" sale-tag>
 			</div>
 			<img food-info-id="" src="#" title="view detail"/>
 			<div class="minor_dscr_fic" title="add to cart" add-to-cart>
				<span class="dsck_n"></span>
				<span class="dsck_p">
					<span class="prc_sale"></span>
					<span class="prc_origin"></span>
				</span>
				<button class="add_to_cart">
					<i class="fa fa-shopping-cart" aria-hidden="true"></i>
				</button>
			</div>
			<form class="food_data_cluster">
				<input type="hidden" name="f_id" value="">
				<input type="hidden" name="f_price" value="">
				<input type="hidden" name="f_sale_s" value="">
				<input type="hidden" name="f_name" value="">
				<input type="hidden" name="f_dscr" value="">
				<input type="hidden" name="f_nutri" value="">
				<input type="hidden" name="f_ava" value="">
				<input type="hidden" name="f_sale" value="">
				<input type="hidden" name="f_vendorID" value="">
			</form>
 		</div>
 	</div>
	 <section class="main_menu" crr-pgn='1'>
	 </section>
	 <nav class="pagination_nav">
	 	<div class="pag_wrapper">
	 		<a _rqpg='prev'>
		 		<span class="VAAlign">Previous</span>
		 	</a>
		 	<ul class="pagBtn_ctner">
		 		<button _rqPg='' style="display:none" id="splNb">
		 			<span>1</span>
		 		</button>
		 	</ul>
		 	<a _rqpg='next'>
		 		<span class="VAAlign">Next</span>
		 	</a>
	 	</div>
	 </nav>
</section>
<!-- end of wrapper -->
<?php if ($data["USER_PRIVILEGE"]) : ?>
<nav class="free_nav_bar">
	<button class="_myCart" id="orderInfo" title="Order info">
		<i class="fa fa-list" aria-hidden="true"></i>
	</button>
	<button class="_myCart" id="userProfile" title="Shipping Info">
		<i class="fa fa-user-o" aria-hidden="true"></i>
	</button>
 	<button class="_myCart" id="client_cart" title="Cart Info">
 		<i class="fa fa-shopping-basket" aria-hidden="true"></i>
 	</button>
 	<div id="nbr_itemsIC">
 		0
 	</div>
 </nav>

 <!-- start of pop-up cluster -->
<div class="general_popUp cart_detail clr_dark shd_white" hide>
	<div class="dragger_ttl">
		<h2 class="hd_ttl VAAlign">cart</h2>
		<button class="close_btn">
			<i class="fa fa-times" aria-hidden="true"></i>
		</button>
	</div>
	<div class="main_cartCtner clr_dark2">
		<p class="asterisk_notation">
			<i class="fa fa-asterisk" aria-hidden="true"></i>
			Click vào số lượng để sửa
		</p>
		<table class="table table-condensed fixed_col">
			<col width="30px"/>
			<col width="230px"/>
			<col width="30px"/>
			<col width=""/>
			<col width="30px">
			<col width="30px"/>
			<tr class="fr_lnTbl">
				<th></th>
				<th>Item name</th>
				<th class="text-center" title="Quantity">
					<i class="fa fa-balance-scale" aria-hidden="true"></i>
				</th>
				<th>Price</th>
				<th></th>
				<th></th>
			</tr>
		</table>
		<div class="tbl_main_wrpC">
			<table id="cart_dataTbl" class="table table-condensed main_ctnCol">
				<col width="30px"/>
				<col width="230px"/>
				<col width="30px"/>
				<col width=""/>
				<col width="30px">
				<col width="30px"/>
				<tr class="prRod_tr">
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
					<td class="text-center">
						<a class="add_notes" title="add note">
							<i class="fa fa-sticky-note" aria-hidden="true"></i>
						</a>
					</td>
					<td class="text-center">
						<a class="remove_itemCart" title="remove from cart">
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
			<div class="upper_lcfter">
				<a id="add_orderNote">
					Add order note
				</a>
			</div>
			<a class="chkOut_smt" id="prcd_cart">
				<span class="VAAlign">Proceed</span>
			</a>
		</div>
	</div>
	<!-- start of #add_note_cart -->
	<div id="add_note_cart" hide>
		<span class="note_header">
			Add note
			<a class="_closeNote">
				<i class="fa fa-times" aria-hidden="true"></i>
			</a>
		</span>
		<textarea id="note_content" placeholder="add text here..."></textarea>
		<span class="note_option">
			<button id="done_note">done</button>
			<button id="clear_note">
				<i class="fa fa-eraser" aria-hidden="true"></i>
			</button>
		</span>
	</div>
	<!-- end of #add_note_cart -->
</div>

<div class="general_popUp ship_info clr_dark shd_white" hide>
	<form id="cltdlvIf" class="shipIF_stl">
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
			<input type="checkbox" name="save_data_cookie" value="0" class="chkbx_saveDt"/>
			<label for="save_data_cookie">Save data in this computer?</label>
		</div>
	</div>
	<div class="cart_footer crt_fter_sIf">
		<input name="submit" type="submit" value="save"/>
	</div>
	</form>
</div>
<!-- start of client order history -->
<div class="ord_history" id="user_dplH" hide>
	<h1 class="tt_ordh">
		<div class="hdttx">
			Order history  
		</div>
		<span class="ordrec_wr">
			<p class="adzkkd"> --- records:</p> 
			<p id="cdmxzk"></p>
			<p class="adzkkd"> show:</p> 
			<p id="cdMdoc"></p>
		</span>
		<span class="btOdh_wrp">
			<button class="close_btn_2">
				<i class="fa fa-times" aria-hidden="true"></i>
			</button>
		</span>
	</h1>
	<div id="ord_dpl_wrapper">
		<div class="order_ctner" id="ord_DC">
			<section class="mn_dtWrp" id="ord_DK">
				<div class="ord_dcrp" sample="ord" hide>
					<div class="stt"></div>
					<div class="ord_time"></div>
					<div class="ord_pval"></div>
					<div class="ord_room"></div>
					<div class="ord_status">
						<i class="fa fa-truck" aria-hidden="true" static></i>
					</div>
					<button class="cancle_ship">
						<i class="fa fa-times" aria-hidden="true"></i>
					</button>
				</div>
				<!-- end of ord -->
				<div class="pkg_dcrp" sample="pkg" hide>
					<div class="prd_dcrp" sample="prd" hide>
						<div class="prd_img">
							<img/>
						</div>
						<div class="prd_name"></div>
						<div class="prd_prc"></div>
						<div class="prd_qty"></div>
						<div class="prd_tval"></div>
					</div>
				</div>
				<!-- end of pkg -->
			</section>
		</div>
		<div class="_loading_dt">
			<img class="VAAlign" src="img/admin/load_2w.svg">
		</div>
		<div class="_load_blank" hide>
			<i class="fa fa-shopping-cart" aria-hidden="true"></i>
			<p class="cart_empty">cart empty</p>
		</div>
	</div>
</div>
<!-- end of client order history -->
<!-- end of pop-up cluster -->
<?php ENDIF; ?>
<div class="general_popUp food_detail clr_dark shd_white" hide>
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
				<span id="og_dsc"></span>
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
					<span id="og_prc"></span>
				</p>
				<?php if ($data["USER_PRIVILEGE"]) : ?>
				<label class="qty_lb_vFi">SL</label>
				<input id="qty_ifcIf" type="text" class="qty_ctn_vFi"/>
				<?php ENDIF; ?>
			</div>
		</div>
		<div class="right_cfter">
			<?php if ($data["USER_PRIVILEGE"]) : ?>
			<a id="aCfd_IF" class="normal_sbm_skbc VAAlign">
				add to cart
			</a>
			<?php ENDIF; ?>
		</div>
	</div>
</div>

<!-- start of page details -->
<div class="pg_detail" id="pgDetail_prmt" hide>
	<section class="m_pgDtp">
		<img class="lg_ctNDp" src="<?=$data["contact"]["wBLogo"]?>">
		<div class="dcrtp_cpg">
			<span class="hder_clsP dragger_ttl">
				<p class="pg_nameB"></p>
				<button id="cls_dtsk">
					<i class="fa fa-times" aria-hidden="true"></i>
				</button>
			</span>
			<article class="pg_Dcrpt_ctt">
			<?=$data["contact"]["wDscrp"]?>
			</article>
		</div>
	</section>
	<section class="sb_dtaC">
		<div class="col_sbDtc">
			<p class="ttL_d">
				<i class="fa fa-mobile" aria-hidden="true"></i>
				Phone
			</p>
			<div class="phone_list">
				<?php for ($i = 0; $i < count($data["contact"]["wPhone"]); $i++) { ?>
				<p class="pN_dta" toggle_data="<?=$data["contact"]["wPhone"][$i]["data"]?>">
					<span class="lbl_pdDt">
					<?=$data["contact"]["wPhone"][$i]["label"]?>:
					</span>
					<span class="dtt_pdDt">
					<?=$data["contact"]["wPhone"][$i]["data"]?>
					</span>
				</p>
				<?php }; ?>
			</div>
		</div>
		<div class="col_sbDtc">
			<p class="ttL_d">
				<i class="fa fa-envelope-o" aria-hidden="true"></i>
				Email
			</p>
			<?php for ($i = 0; $i < count($data["contact"]["wEmail"]); $i++) { ?>
			<p class="pN_dta">
				<span class="lbl_pdDt">
				<?=$data["contact"]["wEmail"][$i]["label"]?>:
				</span>
				<span class="dtt_pdDt">
				<?=$data["contact"]["wEmail"][$i]["data"]?>
				</span>
			</p>
			<?php }; ?>
		</div>
		<div class="col_sbDtc">
			<p class="ttL_d">
				<i class="fa fa-users" aria-hidden="true"></i>
				Social Network
			</p>
			<?php for ($i = 0; $i < count($data["contact"]["wFBacc"]); $i++) { ?>
			<a href="<?=$data["contact"]["wFBacc"][$i]["data"]?>" class="nav_sclNw">
				<figure class="icnTc_w">
					<i class="fa fa-facebook-official" aria-hidden="true"></i>
				</figure>
				<p class="ctLbl">
				<?=$data["contact"]["wFBacc"][$i]["label"]?>
				</p>
			</a>
			<?php }; ?>
		</div>
	</section>
</div>
<!-- end of page details -->
<div id="ctn_dpl" hide>
	<div class="ptner_d"></div>
	<div class="i_pctn_dp">
		<span class="lbl_dp"><?=$data["contact"]["wPhone"][0]["label"]?>:</span>
		<span class="phv_dp"><?=$data["contact"]["wPhone"][0]["data"]?></span>
	</div>
</div>
<!-- start of ctner_ppuntf -->
<div id="ppu_ntf" class="clrD_whiteB">
	<span id="fd_ntf">sample product name</span>
</div>
<!-- end of ctner_ppuntf -->
<script type="text/javascript">
	function preset_data() {
		this.b_url = '<?=$data["base_url"]?>';
		this.fb_login = 1 == <?php echo ($data["USER_PRIVILEGE"]) ? 1 : 0 ?>;
		<?php if (@$data["BAN_STATUS"]) : ?>
		this.ban_status = 1 == <?php echo $data["BAN_STATUS"] ? 1 : 0;?>;
		<?php ENDIF; ?>
		this.mxDp = 12; // NUMBER OF ITEMS DISPLAYED PER PAGINATION
		this.lmt = <?=$data["slc_lm"]?>; // NUMBER OF RECORD TO BE PULLED
		this.ofs = <?=$data["crr_offset"]?>; // POSITION OF STARTED RECORD
		this.ttr = <?=$data["total_records"]?>; // TOTAL RECORDS IN DATABASE
		this.lg_s = "<?php echo @$_SESSION["admin_login"]["url"] ? $_SESSION["admin_login"]["url"] : 0; ?>";
		this.pg_d = <?=$this->page_data["items"]["menu"];?>;
	}
</script>
<script type="text/javascript" src="js/general/assets.js"></script>
<?php if (@$data["header"]["js"]) { ?>
<?php for ($i = 0; $i < count($data["header"]["js"]); $i++) { ?>
<script type="text/javascript" src="js/<?php echo $data["header"]["user"]; ?>/<?php echo $data["header"]["js"][$i]; ?>.js"></script>
<?php };?>
<?php };?>
</body>
</html>