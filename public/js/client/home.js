// (function(){
/* CART DATA 
{
	total_bill: "",
	items_list:
		[
			index = {id,name,price,quantity},
		]
}
*/
var cart = {
	total_bill: 0,
	items_list: []
}
var client_info = {
	
}
var tbl_sDt = new preset_data();
// pre-set clone
var cart_dataTbl = document.getElementById("cart_dataTbl");
cart_dataTbl = cart_dataTbl.childNodes[2];
var clone_trDtbl = $("#cart_dataTbl").children("tbody").find("tr").clone(true,true);
$("#cart_dataTbl").children("tbody").find("tr").remove()

// display pop-up
$(".close_btn").click(function(e){
	e.preventDefault();
	box_to_close = this.parentNode.parentNode;
	if (html_arr(box_to_close.classList).indexOf("general_popUp") == -1) {
		box_to_close = box_to_close.parentNode;
	}
	box_to_close.setAttribute("hide","");
	return false;
});
var cart_btn = document.getElementById("client_cart");
cart_btn.onclick = function() {
	var currentScroll = window.scrollY;
	$(".cart_detail").css({
		"top" : "calc(25% + " + currentScroll + "px)"
	});
	popup_blk_fm(".cart_detail");
	redcart(0);
}
$('*[food-info-id]').click(function(){
	openFood_detail(this);
});
function openFood_detail(dom) {
	var currentScroll = window.scrollY;
	$(".food_detail").css({
		"top" : "calc(25% + " + currentScroll + "px)"
	});
	$(".food_detail")[0].removeAttribute("hide");
	fill_dtFI(dom.parentNode.getElementsByClassName("food_data_cluster")[0]);
	document.getElementById("qty_ifcIf").value = "1";
}
// dragging method
var drag_activate = false;
var host_element;
var omc = {x:0,y:0};
var ctc = {x:0,y:0};
var nmc = {x:0,y:0};
$(".dragger_ttl").mousedown(function(e){
	if (e.which !== 1) {
		return false;
	}
	omc.x = e.screenX;
	omc.y = e.screenY;
	host_element = this.parentNode;
	if (host_element.nodeName == "FORM") {
		host_element = this.parentNode.parentNode;
	}
	var isPgInfo = host_element.classList.contains("dcrtp_cpg");
	if (isPgInfo) {
		host_element = findAncestor(this,"pg_detail");
	}
	set_prioritize(host_element);
	var obj_top = window.getComputedStyle(host_element).top;
	obj_top = parseInt(obj_top);
	var obj_left = host_element.getBoundingClientRect().left;
	ctc.y = obj_top;
	ctc.x = obj_left + (isPgInfo ? host_element.clientWidth/2 : 0);
	host_element.style.top = ctc.y + "px";
	host_element.style.left = ctc.x + "px";
	drag_activate = true;
});
window.onmouseup = function() {
	drag_activate = false;
}
window.onmousemove = function(e) {
	nmc.x = e.screenX;
	nmc.y = e.screenY;

	if (drag_activate) {
		if (host_element) {
			var newX = ctc.x + (nmc.x - omc.x);
			var newY = ctc.y + (nmc.y - omc.y);
			host_element.style.top = newY + "px";
			host_element.style.left = newX + "px";
		}
	}
}
function set_prioritize(d) {
	var x = attr_selector("prioritized");
	for (var i = 0; i < x.length; i++) x[i].removeAttribute("prioritized");
	d.setAttribute("prioritized","");
}
function addEvent(obj, evt, fn) {
    if (obj.addEventListener) {
        obj.addEventListener(evt, fn, false);
    }
    else if (obj.attachEvent) {
        obj.attachEvent("on" + evt, fn);
    }
}
// add food to cart method
var total_items = 0;
$('*[add-to-cart]').click(function(){
	add_toCartF(this);
});
function add_toCartF(dom) {
	var myDForm = dom.parentNode.getElementsByClassName("food_data_cluster")[0];
	insert_itemCart(myDForm);
}
function insert_itemCart(data_form,i_qty = 1){
	var is_form = data_form.nodeName !== undefined;
	// push data to as pre-set
	var item_info = {
		id: is_form ? data_form.f_id.value : data_form.f_id,
		name: is_form ? data_form.f_name.value : data_form.f_name,
		price: is_form ? data_form.f_price.value : data_form.f_price,
		sale: is_form ? data_form.f_sale.value : data_form.f_sale,
		price_s: 0,
		qty: parseInt(i_qty == 0 ? 1 : i_qty) // default
	}
	item_info.price_s = parseInt(item_info.price) * (1 - parseFloat(item_info.sale));
	// check if data is repeated
	var fId_list = [];
	for (var i = 0; i < cart.items_list.length; i++) fId_list.push(cart.items_list[i].id);
	if (fId_list.indexOf(item_info.id) != -1) {
		alert("Đã có sản phẩm này trong giỏ hàng");
		return;
	}
	
	cart.items_list.push(item_info);
	// add item to cart (view)
	var tr_clone = clone_trDtbl.clone(true,true);
	tr_clone.find("[idx]").text(total_items + 1);
	tr_clone.find("[fdn]").find('a').text(cart.items_list[total_items].name);
	tr_clone.find("[qty]").find('.qty_cIp').val(cart.items_list[total_items].qty);
	tr_clone.find("[prc]").text(addComma(item_info.price_s));
	//set events for elm 
	setEvt_rmvF(tr_clone[0]);
	cart_dataTbl.appendChild(tr_clone[0]);
	total_items++;
	update_cart();
	// vibrate cart button & display notification
	vibration(cart_btn);
	redcart(1);
	dp_ppuNtf("Đã thêm " + item_info.name + " vào giỏ hàng");
}
// reset cart inner function
function setEvt_rmvF(elm) {
	elm.querySelectorAll("a[class='remove_itemCart']")[0].onclick = function() {
		rm_foodFC(this);
	}
	// edit quantity method
	elm.querySelectorAll("input[qty_incart]")[0].onkeyup = function(){
		prnt_tr = this.parentNode.parentNode;
		var item_idx = prnt_tr.querySelectorAll("td[idx]")[0].innerHTML;
		item_idx = parseInt(item_idx) - 1;
		cart.items_list[item_idx].qty = parseInt(this.value == "" ? 1 : this.value);
		// update price in cart (view)
		update_cart();
	};
	elm.querySelectorAll("input[qty_incart]")[0].onchange = function() {
		if (this.value == 0) {
			rm_foodFC(this);
		}
	}
}
// remove food from cart method
function rm_foodFC(htmlc){
	var trg_tr = htmlc.parentNode.parentNode;
	var trg_idx = 0 , trg_qty = 0;
	// get index of element
	for (var i = 0; i < trg_tr.childNodes.length; i++) {
		if (trg_tr.childNodes[i].nodeName == "TD") {
			if (trg_tr.childNodes[i].getAttribute("idx") !== null) {
				trg_idx = trg_tr.childNodes[i].textContent;
				trg_idx = parseInt(trg_idx) - 1;
			}
			if (trg_tr.childNodes[i].getAttribute("qty") !== null) {
				trg_qty = trg_tr.childNodes[i].getElementsByClassName('qty_cIp')[0].value;
				trg_qty = parseInt(trg_qty);
				break;
			}
		}
	}
	if (cart_dataTbl.contains(trg_tr)) {
		// remove on data
		cart.items_list.splice(trg_idx ,1);
		// remove on display
		cart_dataTbl.removeChild(trg_tr);
		// rearrange order number on display
		var tr_clt = cart_dataTbl.getElementsByTagName("tr");
		for (var i = 0; i < tr_clt.length; i++) {
			tr_clt[i].getElementsByTagName("td")[0].innerHTML = i + 1;
		}
		total_items--;
	}
	update_cart();
};
// update cart: total price
function update_cart() {
	cart.total_bill = 0;
	for (var i = 0; i < cart.items_list.length; i++) {
		cart.total_bill += cart.items_list[i].qty * parseInt(cart.items_list[i].price_s);
	}
	var sum_bill = document.getElementById("sum_billC");
	sum_bill.innerHTML = addComma(cart.total_bill);
	document.getElementById("nbr_itemsIC").innerHTML = total_items;
}
// clear order
document.getElementById("clear_cart").onclick = clear_allItem;
function clear_allItem() {
	cart_dataTbl.innerHTML = ""
	total_items = 0;
	cart.total_bill = 0;
	cart.items_list = [];
	update_cart();
}
// animation: vibrate cart when add item
function vibration(elm) {
	elm.classList.add("vibration");
	setTimeout(function(){
		elm.classList.remove("vibration");
	},1000);
}
function redcart(k) {
	if (k == 1) {
		cart_btn.classList.add("active_cart");
		return;
	}
	cart_btn.classList.remove("active_cart");
}
// food_info pop-up: fill dynamic content 
var crr_slcItem = {
	f_id: null, f_name: null, f_price: null,
} 
function fill_dtFI(dt_f) {
	crr_slcItem = {
		f_id: dt_f.f_id.value,
		f_name: dt_f.f_name.value,
		f_price: parseInt(dt_f.f_price.value),
		f_sale: parseFloat(dt_f.f_sale.value),
	} 
	var dts = {
		og:{
			nm: dt_f.f_name.value ,
			prc: dt_f.f_price.value ,
			dsc: dt_f.f_dscr.value ,
			_ntr: dt_f.f_nutri.value ,
			_ava: dt_f.f_ava.value ,
			sl: dt_f.f_sale.value
		},
		tg: {
			nm: document.getElementById("og_nm"),
			prc: document.getElementById("og_prc"),
			dsc: document.getElementById("og_dsc"),
			_ntr: document.getElementById("og_ntr"),
			_ava: document.getElementById("og_ava"),
			sl: document.getElementById("og_sl")
		}
	}
	dts.tg.nm.innerHTML = dts.og.nm ;
	dts.tg.prc.innerHTML = addComma(crr_slcItem.f_price - crr_slcItem.f_price * crr_slcItem.f_sale) ;
	dts.tg.dsc.innerHTML = dts.og.dsc ;
	dts.tg._ntr.src = dts.og._ntr ;
	dts.tg._ava.src = dts.og._ava ;
	dts.tg.sl.innerHTML = parseFloat(dts.og.sl) != 0 ? "( -" + parseFloat(dts.og.sl)*100 + "%)" : "";
}
// food_info pop-up: add item to cart
document.getElementById("aCfd_IF").onclick = function() {
	var crr_qty = document.getElementById("qty_ifcIf").value;
	insert_itemCart(crr_slcItem,crr_qty);
}
// food notifcation
function dp_ppuNtf(pd_n) {
	var ctner = document.getElementById("ppu_ntf");
	var prdctn = document.getElementById("fd_ntf");
	prdctn.innerHTML = pd_n;
	ctner.style.display = "block";
	var sto_ct = setTimeout(function(){
		$("#ppu_ntf").fadeOut(1000);
	},3000);
}
// create pagnition buttons
var pgBtCtner = document.getElementsByClassName("pagBtn_ctner")[0];
var mainPgHder = document.querySelectorAll("[crr-pgn]")[0];
create_pagBtn();
function create_pagBtn() {
	var nbBtn = Math.ceil(tbl_sDt.ttr/tbl_sDt.mxDp);
	var trgCln = document.getElementById("splNb");
	var cloneBtn = trgCln.cloneNode(true);
	trgCln.parentNode.removeChild(trgCln);
	cloneBtn.removeAttribute("id");
	cloneBtn.removeAttribute("style");
	for (var i = 1; i <= nbBtn; i++) {
		// default btn 1 is active
		var clnB2 = cloneBtn.cloneNode(true);
		if (i == 1) {
			clnB2.classList.add("active");
		}
		clnB2.setAttribute("_rqpg",i);
		clnB2.children[0].innerHTML = i;
		clnB2.addEventListener("click",chgPag);
		pgBtCtner.appendChild(clnB2);
	}
	return cloneBtn;
}
var smplc = document.getElementById("smp_cltD").cloneNode(true);
var main_menu = document.getElementsByClassName("main_menu")[0];
function clr_mmn(d) {
	while (d.children.length > 0) {
		d.removeChild(d.children[0]);
	}
}
rewrite_saleTag();
function rewrite_saleTag() {
	var stg = document.querySelectorAll("[sale-tag]");
	var npt = document.getElementsByClassName("prc_discounted");
	var npi = document.getElementsByClassName("_lineCrossed");
	for (var i = 0; i < stg.length; i++) {
		if (isFloat(stg[i].innerHTML) && !isNaN(Number(stg[i].innerHTML))) {
			var dct = stg[i].textContent;
			if (i < npi.length) npt[i].innerHTML = parseInt(npi[i].textContent) * (1 - dct);
			stg[i].innerHTML = "-" + parseFloat(dct) * 100 + "%";
		}
	}
}
// pag next and prev btn
[$("[_rqpg='prev']")[0],$("[_rqpg='next']")[0]].forEach(function(elm){
	elm.onclick = function() {
		var crrPgn = $("[crr-pgn]")[0].getAttribute("crr-pgn");
		var pgLibt = pgBtCtner.querySelectorAll("[_rqpg]");
		
		if (this.getAttribute("_rqpg") == 'prev') {
			if (crrPgn - 1 >= 1) {
				pgLibt[crrPgn - 2].click();
			}
		} else {
			if (crrPgn < pgLibt.length) {
				pgLibt[crrPgn].click();
			}
		}
	}
});
/* rewrite number function
	0 = 10000 => 10K
	1 = 10000 => 10,000
*/
var crs_ct = document.querySelectorAll("[fd_tp]");
for (var i = 0; i < crs_ct.length; i++) {
	if (crs_ct[i].getAttribute('fd_tp') != 1) {
		var dksoz = crs_ct[i].getElementsByClassName("prc_val");
		for (var j = 0; j < dksoz.length; j++) {
			rewrnb(1,dksoz[j]);
		}
	}
}
[document.getElementsByClassName("_lineCrossed"),
document.getElementsByClassName("prc_discounted")].forEach(function(a){
	for (var i = 0; i < a.length; i++) {
		a[i].innerHTML = addComma(Number(a[i].innerHTML));
	}
});

function rewrnb(t,d) {
	var str = Number(d.innerHTML);
	if (t == 0) {
		str = str/1000 + "K";
		d.innerHTML = str;
	} else {
		d.innerHTML = addComma(str);
	}
}
// check user info once onload via cookie
var shippingForm = document.getElementById("cltdlvIf");
var sfl = {
	cname: shippingForm.client_name,
	cphone: shippingForm.client_phone,
	cadd: shippingForm.client_address,
	storeInfo: shippingForm.save_data_cookie
}

var slow_network = setInterval(function(){
	if (tbl_sDt.pg_d) {
		set_menu(tbl_sDt.pg_d);
		clearInterval(slow_network);
	}
}, 100);

function set_menu(d) {
	main_menu.innerHTML = "";
	var c = document.getElementsByClassName("dishes");
	for (var i = 0; i < d.length; i++) {
		var x = smplc.cloneNode(true);
		x.removeAttribute("style");
		x.removeAttribute("id");

		x.querySelector("img[food-info-id]").src = d[i].avatar_img;
		x.querySelector("img[food-info-id]").setAttribute("food-info-id",d[i].id);
		var y = "";
		var z = x.getElementsByClassName("discount_tag")[0];
		if (parseFloat(d[i].sale) > 0) {
			y = parseInt(d[i].price) * (1 - parseFloat(d[i].sale));
			x.getElementsByClassName("prc_sale")[0].innerHTML = addComma(y);
			x.getElementsByClassName("prc_origin")[0].innerHTML = addComma(d[i].price);
			z.innerHTML = "-" + (parseFloat(d[i].sale) * 100) + "%";
		} else {
			x.getElementsByClassName("prc_sale")[0].innerHTML = addComma(d[i].price);
			z.parentNode.removeChild(z);
		}
		x.getElementsByClassName("dsck_n")[0].innerHTML = d[i].name;

		x.querySelector("input[name=f_id]").value = d[i].id;
		x.querySelector("input[name=f_price]").value = d[i].price;
		x.querySelector("input[name=f_sale_s]").value = y;
		x.querySelector("input[name=f_name]").value = d[i].name;
		x.querySelector("input[name=f_dscr]").value = d[i].description;
		x.querySelector("input[name=f_nutri]").value = d[i].nutrition_img;
		x.querySelector("input[name=f_ava]").value = d[i].avatar_img;
		x.querySelector("input[name=f_sale]").value = d[i].sale;

		x.querySelectorAll("[add-to-cart]")[0].onclick = function(){
			add_toCartF(this);
		}
		x.querySelector("img[food-info-id]").onclick = function() {
			openFood_detail(this);
		}
		// reform sale-tag
		main_menu.appendChild(x);
	}
}
function chgPag() {
	// clear all active btn
	for (var i = 0; i < pgBtCtner.children.length; i++) {
		pgBtCtner.children[i].classList.remove("active");
	}
	this.classList.add("active");
	// before server request, check if button is repeatitively active
	var pgRqD = "pg_selector=" + this.getAttribute("_rqpg");
	if (mainPgHder.getAttribute("crr-pgn") !== this.getAttribute("_rqpg")) {
		// send request to server
		ajax_processor_url = tbl_sDt.b_url + '/chgPag';
		// clear main_menu
		clr_mmn(main_menu);
		$.post(ajax_processor_url,pgRqD,function(data,status){
			data = JSON.parse(data);
			set_menu(data);
		});
	}
	// set new pg trg of mainPgHder
	mainPgHder.setAttribute("crr-pgn",this.getAttribute("_rqpg"));
}
// proceed cart
var prcd_cartb = document.getElementById("prcd_cart");
var ntf_str;
prcd_cartb.onclick = function() {
	// check if client_info in home_data.js available
	if (isEmpty(client_info)) {
		// if empty: display client form
		alert("Please enter shipping info");
		$("#userProfile").click();
	} else {
		if (cart.items_list.length != 0) {
			var cUrl = tbl_sDt.b_url + "/send_cart";
			var dtd = "clt_spI=" + JSON.stringify({client: client_info, cart: cart});
			ajax_request(cUrl, dtd, function(d) {
				reset_ord_history();
				load_ord_history(true);
				clear_allItem(cart);
				ntf_str = "Submit giỏ hàng thành công";
				dp_ppuNtf(ntf_str);
			});
		} else {
			alert("Giỏ hàng trống.")
		}
		$(".close_btn").click();
	}
}
$("#userProfile").click(function(){
	var currentScroll = window.scrollY;
	popup_blk_fm(".ship_info");
	$(".ship_info").css({
		"top" : "calc(25% + " + currentScroll + "px)"
	});
});
shippingForm.onsubmit = send_shippingInfo;
shippingForm.submit.onclick = send_shippingInfo;
function popup_blk_fm(d) {
	if ($(d)[0].hasAttribute("hide")) {
		$(d)[0].removeAttribute("hide");
	} else {
		$(d)[0].removeAttribute("style");
		$(d)[0].setAttribute("hide","");
	}
	
}
function prepare_cData() {
	var url = tbl_sDt.b_url + "/chkckk_ajx";
	ajax_request(url,null, function(d){
		if (typeof d == "string" && d != "") {
			client_info = JSON.parse(d);

			sfl.cphone.value = client_info.phone;
			sfl.cadd.value = client_info.address;
			sfl.cname.value = client_info.name;
			sfl.storeInfo.value = client_info.saveData;
			sfl.storeInfo.checked = sfl.storeInfo.value == 1 ? true : false;

			// load client order history
			load_ord_history();
			load_max_ttORD();
		}
	});
}

sfl.storeInfo.onchange = function() {tick_strIf(this)};
function tick_strIf(d) {
	if (d.checked == true) {
		d.value = "1";
		return;
	}
	d.value = "0";
}
function send_shippingInfo(e) {
	e.preventDefault();
	if (isInputEmpty(shippingForm.elements)) {
		var sfl_dt = {
			name: sfl.cname.value,
			phone: Number(sfl.cphone.value),
			address: sfl.cadd.value,
			saveData: sfl.storeInfo.value,
		}
		$.ajax({
			url: tbl_sDt.b_url + "/shipInfo",
			data: "clt_spI=" + JSON.stringify(sfl_dt),
			success: function(data) {
				client_info = sfl_dt;
				if (sfl_dt.saveData == 1) {
					var url = tbl_sDt.b_url + "/add_accounts";
					ajax_request(url, null, null);
				}
				ntf_str = "Your shipping info is successfully saved.";
				dp_ppuNtf(ntf_str);
				hide_shipInfo();
			},
		});
	} else {
		alert("Form is left blank or value is invalid");
		hide_shipInfo();
	}
	return false;
}
function hide_shipInfo() {
	$(".ship_info").css({
		"display" : "none"
	});
}
// client order history 
var c_ord = document.getElementById("orderInfo");
var ord_M = document.getElementById("user_dplH");
var ord_w = document.getElementById("ord_dpl_wrapper");
var ord_m = document.getElementById("ord_DK");
var ord_k = document.getElementById("ord_DC");
var _loading_dt = document.getElementsByClassName("_loading_dt")[0];
var pause_vPkg = false;
var pause_lPkg = false;
var max_orders = 0;
var max_orders_dpl = 0;
var ttl_orders = 0;
var rq_resetOH = false;
var pull_dt_reg = {
	limit: 15,
	offset: 0
}
var cn_dh = {
	ord_c: ord_m.querySelector("[sample=ord]"),
	pkg_c: ord_m.querySelector("[sample=pkg]"),
	prd_c: ord_m.querySelector("[sample=prd]")
}
for (var p in cn_dh) {
	cn_dh[p].parentNode.removeChild(cn_dh[p]);
	cn_dh[p].removeAttribute("sample");
	cn_dh[p].removeAttribute("hide");
}
var pkg_cc;
var ord_cc;
var prd_cc;

c_ord.onclick = close_ord_dpl;
$(".close_btn_2").click(close_ord_dpl);
function close_ord_dpl() {
	if (ord_M.hasAttribute("hide")) {
		ord_M.removeAttribute("hide");
	} else {
		ord_M.setAttribute("hide","");
	}
}
function load_max_ttORD() {
	var dr = document.getElementById("cdmxzk");
	dr.innerHTML = "";
	var mdkrt = "r=" + JSON.stringify({
		"tk":  client_info.tokenKey
	});
	ajax_request(tbl_sDt.b_url + "/count_orders_wcd",mdkrt,function(d){
		ttl_orders = d;
		dr.innerHTML = ttl_orders;
	});
}
function load_ord_history(reset = false) {
	rq_resetOH = reset;
	var rdt = "r=" + JSON.stringify({
		"tk":  client_info.tokenKey,
		"dp": "1"
	});
	ajax_request(tbl_sDt.b_url + "/count_orders_wcd",rdt,function(d){
		max_orders_dpl = d;
		max_orders = d;
		document.getElementById("cdMdoc").innerHTML = max_orders;
		if (d == 0) {
			popup_blk_fm("._load_blank");
			return;
		}
		if (!(Object.keys(client_info).length === 0 && client_info.constructor === Object || max_orders == 0)) {
			get_ord_history(append_HOrder);
		}
	});
}
function get_ord_history(cb_fx) {
	if (!rq_resetOH) _loading_dt.removeAttribute("hide");
	pull_dt_reg.tk = client_info.tokenKey;
	var r = "r=" + JSON.stringify(pull_dt_reg);
	var url = tbl_sDt.b_url + "/get_ord_antiquity";
	ajax_request(url,r,function(d){
		if (!_loading_dt.hasAttribute("hide")) _loading_dt.setAttribute("hide","");
		if (rq_resetOH) ord_m.innerHTML = "";
		cb_fx(JSON.parse(d));
	});
}
ord_k.onscroll = function(e) {
	if (pause_lPkg) return;
	var x = this.scrollTop;
	var y = this.offsetHeight;
	var z = ord_m.offsetHeight;
	if (x + y >= z - 30) {
		pause_lPkg = true;
		var a = pull_dt_reg.offset > max_orders;
		var b = max_orders == 0;
		if (!(a || b)) load_ord_history();
	}
}
function append_HOrder(d) {
	for (var i = 0; i < d.length; i++) {
		ord_cc = cn_dh.ord_c.cloneNode(true);
		ord_cc.setAttribute("ord",d[i]['ord']['id']);
		ord_cc.querySelector("[class=stt]").innerHTML = i + 1;
		ord_cc.querySelector("[class=ord_time]").innerHTML = sql_date_converter(d[i]['ord']['time_order']);
		ord_cc.querySelector("[class=ord_pval]").innerHTML = (function(){
			var prcT = 0;
			d[i]['prd'].forEach(function(x){prcT += parseInt(x['prcTotal']);});
			return addComma(prcT);
		})();
		ord_cc.querySelector("[class=ord_room]").innerHTML = d[i]['ord']['address'];
		if (d[i]['ord']['ship_status'] == 1) {
			ord_cc.querySelector("[class=ord_status]").firstElementChild.removeAttribute('static');	
		}
		ord_cc.querySelector("[class=cancle_ship]").addEventListener("click",remove_order);
		ord_cc.querySelector("[class=cancle_ship]").addEventListener("mouseout",function(){
			pause_vPkg = false;
		});
		ord_cc.querySelector("[class=cancle_ship]").addEventListener("mouseover",function(){
			pause_vPkg = true;
		});
		ord_cc.addEventListener("click",function(){
			display_package(this.getAttribute("ord"));
		});
		ord_m.appendChild(ord_cc);

		pkg_cc = cn_dh.pkg_c.cloneNode(true);
		pkg_cc.setAttribute("prd",d[i]['ord']['id']);
		pkg_cc.setAttribute("hide","");
		for (var j = 0; j < d[i]['prd'].length; j++) {
			var prd = d[i]['prd'][j];
			prd_cc = cn_dh.prd_c.cloneNode(true);

			prd_cc.querySelector("[class=prd_img]").firstElementChild.src = prd["thumbnail"];
			prd_cc.querySelector("[class=prd_name]").innerHTML = prd["name"];
			prd_cc.querySelector("[class=prd_prc]").innerHTML = (function(){
				var p_prc = parseInt(prd["price"]);
				var p_dsc = parseInt(prd["prcTotal"]) / parseInt(prd["qty"]);
				return addComma(p_dsc);
			})();
			prd_cc.querySelector("[class=prd_qty]").innerHTML = prd["qty"];
			prd_cc.querySelector("[class=prd_tval]").innerHTML = addComma(prd["prcTotal"]);
			pkg_cc.appendChild(prd_cc);
		}
		ord_m.appendChild(pkg_cc);
	}

	pull_dt_reg.offset += pull_dt_reg.limit;
	pause_lPkg = false;
	rearrange_stt();
}
function display_package(x) {
	if (pause_vPkg) return;
	var dtpId = ord_m.querySelector("[prd='" + x + "']");
	if (dtpId.hasAttribute("hide")) {
		dtpId.removeAttribute("hide");
	} else {
		dtpId.setAttribute("hide","");
	}
}
var rmv_ctn = true;
function remove_order(e) {
	e.preventDefault();
	if (!rmv_ctn) return false;
	rmv_ctn = false;
	var crr_d = get_parent_cn(this, "ord_dcrp");
	var ord_id = crr_d.getAttribute("ord");
	var crr_p = ord_m.querySelector("[prd='" + ord_id + "']");
	var r = "r=" + ord_id;
	var url = tbl_sDt.b_url + "/change_display_orders";
	ajax_request(url,r,function(d){
		rmv_ctn = true;
		crr_p.parentNode.removeChild(crr_p);
		crr_d.parentNode.removeChild(crr_d);
		document.getElementById("cdMdoc").innerHTML = --max_orders_dpl;
		pull_dt_reg.offset--;
		var rmn = ord_m.getElementsByClassName("ord_dcrp").length;
		if (rmn <= 10) load_ord_history(true);
		rearrange_stt();
		// if (d == 1) {
			
		// } else {
		// 	alert("Xóa lỗi, thử lại");
		// }
	});
	return false;
}
function rearrange_stt() {
	var stt_d = ord_m.getElementsByClassName("stt");
	for (var i = 0; i < stt_d.length; i++) {
		stt_d[i].innerHTML = i + 1;
	}
}
function reset_ord_history() {
	pull_dt_reg.offset = 0;
	load_max_ttORD();
}
addEvent(window,"load",function(e) {
	$(".pg_nameB").text(window.location.hostname);
	prepare_cData();
	addEvent(document, "mouseout", function(e) {
        e = e ? e : window.event;
        var from = e.relatedTarget || e.toElement;
        if (!from || from.nodeName == "HTML") {
            drag_activate = false;
        };
    });
});
$("#cls_dtsk").click(function(){
	$("#pgDetail_prmt").attr("hide","");
});
$("#contact_info_b").click(function(){
	var aDpg = document.getElementById("pgDetail_prmt");
	if (aDpg.hasAttribute("hide")) {
		aDpg.removeAttribute("hide");
		var currentScroll = window.scrollY;
		$("#pgDetail_prmt").css({
			"top" : "calc(25% + " + currentScroll + "px)"
		});
	} else {
		aDpg.setAttribute("hide","");
		aDpg.removeAttribute("style");
	}
});
$("#phone_prompt").click(function(){
	var t = $("#ctn_dpl");
	if (t[0].hasAttribute("hide")) {
		var x = getOffsetLeft(this) + this.clientWidth;
		var y = getOffsetTop(this);
		t.css({
			"top": y + "px",
			"left": x + "px"
		});
		t[0].removeAttribute("hide");
	} else {
		t[0].setAttribute("hide","");
	}
});
$(".dtt_pdDt").click(function(){
	SelectText(this);
});
$(".i_pctn_dp").click(function(){
	SelectText($(".phv_dp")[0]);
});
function SelectText(element) {
    var doc = document
        , text = $(element)[0]
        , range, selection
    ;    
    if (doc.body.createTextRange) {
        range = document.body.createTextRange();
        range.moveToElementText(text);
        range.select();
    } else if (window.getSelection) {
        selection = window.getSelection();        
        range = document.createRange();
        range.selectNodeContents(text);
        selection.removeAllRanges();
        selection.addRange(range);
    }
}
// })();