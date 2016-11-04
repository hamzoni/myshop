<!DOCTYPE html>
<html>
<head>
	<title>FUD - FPT University Dining</title>	
	<?php include_once "_header.php"; ?>
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
									<?=$data["items"]["popular"][0]['price']?>
								</div>
							</div>
						</article>
						<form class="food_data_cluster">
							<input type="hidden" name="f_id" value="<?=$data["items"]["popular"][0]["id"]?>">
							<input type="hidden" name="f_price" value="<?=$data["items"]["popular"][0]["price"]?>">
							<input type="hidden" name="f_name" value="<?=$data["items"]["popular"][0]["name"]?>">
							<input type="hidden" name="f_dscr" value="<?=$data["items"]["popular"][0]["description"]?>">
							<input type="hidden" name="f_nutri" value="<?=$data["items"]["popular"][0]["nutrition_img"]?>">
							<input type="hidden" name="f_ava" value="<?=$data["items"]["popular"][0]["avatar_img"]?>">
							<input type="hidden" name="f_sale" value="<?=$data["items"]["popular"][0]["sale"]?>">
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
								<?=$data["items"]["popular"][$i]["price"]?>
								</div>
							</div>
						</article>
						<form class="food_data_cluster">
							<input type="hidden" name="f_id" value="<?=$data["items"]["popular"][$i]["id"]?>">
							<input type="hidden" name="f_price" value="<?=$data["items"]["popular"][$i]["price"]?>">
							<input type="hidden" name="f_name" value="<?=$data["items"]["popular"][$i]["name"]?>">
							<input type="hidden" name="f_dscr" value="<?=$data["items"]["popular"][$i]["description"]?>">
							<input type="hidden" name="f_nutri" value="<?=$data["items"]["popular"][$i]["nutrition_img"]?>">
							<input type="hidden" name="f_ava" value="<?=$data["items"]["popular"][$i]["avatar_img"]?>">
							<input type="hidden" name="f_sale" value="<?=$data["items"]["popular"][$i]["sale"]?>">
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
								<?=$data["items"]["special"][0]['price'];?>
								</div>
							</div>
						</article>
						<form class="food_data_cluster">
							<input type="hidden" name="f_id" value="<?=$data["items"]["special"][0]["id"]?>">
							<input type="hidden" name="f_price" value="<?=$data["items"]["special"][0]["price"]?>">
							<input type="hidden" name="f_name" value="<?=$data["items"]["special"][0]["name"]?>">
							<input type="hidden" name="f_dscr" value="<?=$data["items"]["special"][0]["description"]?>">
							<input type="hidden" name="f_nutri" value="<?=$data["items"]["special"][0]["nutrition_img"]?>">
							<input type="hidden" name="f_ava" value="<?=$data["items"]["special"][0]["avatar_img"]?>">
							<input type="hidden" name="f_sale" value="<?=$data["items"]["special"][0]["sale"]?>">
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
								<?=$data["items"]["special"][$i]["price"]?>
								</div>
							</div>
						</article>
						<form class="food_data_cluster">
							<input type="hidden" name="f_id" value="<?=$data["items"]["special"][$i]["id"]?>">
							<input type="hidden" name="f_price" value="<?=$data["items"]["special"][$i]["price"]?>">
							<input type="hidden" name="f_name" value="<?=$data["items"]["special"][$i]["name"]?>">
							<input type="hidden" name="f_dscr" value="<?=$data["items"]["special"][$i]["description"]?>">
							<input type="hidden" name="f_nutri" value="<?=$data["items"]["special"][$i]["nutrition_img"]?>">
							<input type="hidden" name="f_ava" value="<?=$data["items"]["special"][$i]["avatar_img"]?>">
							<input type="hidden" name="f_sale" value="<?=$data["items"]["special"][$i]["sale"]?>">
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
	 		<?php if (count($this->page_data["items"]["suggest"]) > 1) { ?>
	 		<div class="banner_ctner">
	 			<div id="myCarousel3" class="carousel slide" data-ride="carousel" data-interval="8000">
					<div class="carousel-inner" role="listbox">
						<div class="item active">
							<?php for ($i = 1; $i < count($data["items"]["suggest"][0]); $i++) { ?>
							<div class="food_itemCtner">
								<img food-info-id="<?=$data["items"]["suggest"][0]['id']?>" src="<?=$data["items"]["suggest"][0]['avatar_img']?>" alt="<?=$data["items"]["suggest"][0]['name']?>">
								<div class="minor_dscr_fic" add-to-cart>
									<span class="dsck_n"><?=$data["items"]["suggest"][0]['name']?></span>
									<span class="dsck_p"><?=$data["items"]["suggest"][0]['price']?></span>
								</div>
								<form class="food_data_cluster">
									<input type="hidden" name="f_id" value="<?=$data["items"]["suggest"][0]['id']?>">
									<input type="hidden" name="f_price" value="<?=$data["items"]["suggest"][0]['price']?>">
									<input type="hidden" name="f_name" value="<?=$data["items"]["suggest"][0]['name']?>">
									<input type="hidden" name="f_dscr" value="<?=$data["items"]["suggest"][0]['description']?>">
									<input type="hidden" name="f_nutri" value="<?=$data["items"]["suggest"][0]['nutrition_img']?>">
									<input type="hidden" name="f_ava" value="<?=$data["items"]["suggest"][0]['avatar_img']?>">
									<input type="hidden" name="f_sale" value="<?=$data["items"]["suggest"][0]['sale']?>">
								</form>
							</div>
							<?php }; ?>
						</div>
						<?php if (count($this->page_data["items"]["suggest"]) > 1) { ?>
						<?php for ($j = 1; $j < count($this->page_data["items"]["suggest"]); $j++) { ?>
						<div class="item">
							<?php for ($i = 0; $i < count($this->page_data["items"]["suggest"][$j]); $i++) { ?>
							<div class="food_itemCtner">
								<img food-info-id="<?=$this->page_data["items"]["suggest"][$j]['id']?>" src="<?=$this->page_data["items"]["suggest"][$j]['avatar_img']?>" alt="<?=$this->page_data["items"]["suggest"][$j]['name']?>">
								<div class="minor_dscr_fic" add-to-cart>
									<span class="dsck_n"><?=$this->page_data["items"]["suggest"][$j]['name']?></span>
									<span class="dsck_p"><?=$this->page_data["items"]["suggest"][$j]['price']?></span>
								</div>
								<form class="food_data_cluster">
									<input type="hidden" name="f_id" value="<?=$data["items"]["suggest"][$j]['id']?>">
									<input type="hidden" name="f_price" value="<?=$data["items"]["suggest"][$j]['price']?>">
									<input type="hidden" name="f_name" value="<?=$data["items"]["suggest"][$j]['name']?>">
									<input type="hidden" name="f_dscr" value="<?=$data["items"]["suggest"][$j]['description']?>">
									<input type="hidden" name="f_nutri" value="<?=$data["items"]["suggest"][$j]['nutrition_img']?>">
									<input type="hidden" name="f_ava" value="<?=$data["items"]["suggest"][$j]['avatar_img']?>">
									<input type="hidden" name="f_sale" value="<?=$data["items"]["suggest"][$j]['sale']?>">
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
	 <div class="dishes" id="smp_cltD" style="display:none">
 		<div class="dishes_content">
 			<div class="discount_tag" sale-tag>
 			</div>
 			<img food-info-id="" src="" title="view detail"/>
 			<div class="minor_dscr_fic" title="add to cart" add-to-cart>
				<span class="dsck_n"></span>
				<span class="dsck_p"></span>
				<button class="add_to_cart">
					<i class="fa fa-shopping-cart" aria-hidden="true"></i>
				</button>
			</div>
			<form class="food_data_cluster">
				<input type="hidden" name="f_id" value="">
				<input type="hidden" name="f_price" value="">
				<input type="hidden" name="f_name" value="">
				<input type="hidden" name="f_dscr" value="">
				<input type="hidden" name="f_nutri" value="">
				<input type="hidden" name="f_ava" value="">
				<input type="hidden" name="f_sale" value="">
			</form>
 		</div>
 	</div>
	 <section class="main_menu" crr-pgn='1'>
 	<?php for ($i = 0; $i < count($this->page_data["items"]["menu"]); $i++) { ?>
 	<div class="dishes">
 		<div class="dishes_content">
 			<?php if ($this->page_data["items"]["menu"][$i]['type'] == '2') { ?>
 			<div class="discount_tag" sale-tag>
 				<?=$this->page_data["items"]["menu"][$i]['sale']?>
 			</div>
 			<?php }; ?>
 			<img food-info-id="<?=$this->page_data["items"]["menu"][$i]["id"]?>" src="<?=$this->page_data["items"]["menu"][$i]["avatar_img"]?>" title="view detail"/>
 			<div class="minor_dscr_fic" title="add to cart" add-to-cart>
				<span class="dsck_n"><?=$this->page_data["items"]["menu"][$i]["name"]?></span>
				<span class="dsck_p"><?=$this->page_data["items"]["menu"][$i]["price"]?></span>
				<button class="add_to_cart">
					<i class="fa fa-shopping-cart" aria-hidden="true"></i>
				</button>
			</div>
			<form class="food_data_cluster">
				<input type="hidden" name="f_id" value="<?=$data["items"]["menu"][$i]["id"]?>">
					<input type="hidden" name="f_price" value="<?=$data["items"]["menu"][$i]["price"]?>">
					<input type="hidden" name="f_name" value="<?=$data["items"]["menu"][$i]["name"]?>">
					<input type="hidden" name="f_dscr" value="<?=$data["items"]["menu"][$i]["description"]?>">
					<input type="hidden" name="f_nutri" value="<?=$data["items"]["menu"][$i]["nutrition_img"]?>">
					<input type="hidden" name="f_ava" value="<?=$data["items"]["menu"][$i]["avatar_img"]?>">
					<input type="hidden" name="f_sale" value="<?=$data["items"]["menu"][$i]["sale"]?>">
			</form>
 		</div>
 	</div>
 	<?php }; ?>
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
<nav class="free_nav_bar">
	<button class="_myCart" id="userProfile">
		<i class="fa fa-user-o" aria-hidden="true"></i>
	</button>
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
			<a class="chkOut_smt" id="prcd_cart">
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
<div class="general_popUp ship_info clr_dark shd_white" style="display:block;">
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
			<input type="checkbox" name="save_data_cookie" class="chkbx_saveDt"/>
			<label for="save_data_cookie">Save data in this computer?</label>
		</div>
	</div>
	<div class="cart_footer crt_fter_sIf">
		<input name="submit" type="submit" value="proceed"/>
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
<script type="text/javascript">
	// alert notification if having
	<?php if (@isset($data["ntf"])) { ?>
	alert("<?=$data["ntf"];?>");
	<?php };?>
	// preset tbl select data
	var tbl_sDt = {
		b_url: '<?=$data["base_url"]?>',
		mxDp: 12, // NUMBER OF ITEMS DISPLAYED PER PAGINATION
		lmt: <?=$data["slc_lm"]?>, // NUMBER OF RECORD TO BE PULLED
		ofs: <?=$data["crr_offset"]?>, // POSITION OF STARTED RECORD
		ttr: <?=$data["total_records"]?> // TOTAL RECORDS IN DATABASE
	}
</script>
<script type="text/javascript" src="js/general/assets.js"></script>
<script type="text/javascript" src="js/client/home_data.js"></script>
<script type="text/javascript" src="js/client/home.js"></script>
</body>
</html>