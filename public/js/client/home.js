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
	box_to_close.style.display = "none";
	return false;
});
var cart_btn = document.getElementById("client_cart");
cart_btn.onclick = function() {
	var currentScroll = window.scrollY;
	$(".cart_detail").css({
		"display" : "block",
		"top" : "calc(25% + " + currentScroll + "px)"
	});
	redcart(0);
}
$('*[food-info-id]').click(function(){
	openFood_detail(this);
});
function openFood_detail(dom) {
	var currentScroll = window.scrollY;
	$(".food_detail").css({
		"display" : "block",
		"top" : "calc(25% + " + currentScroll + "px)"
	});
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
	var obj_top = window.getComputedStyle(host_element).top;
	obj_top = parseInt(obj_top);
	var obj_left = host_element.getBoundingClientRect().left;
	ctc.y = obj_top;
	ctc.x = obj_left;
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
function addEvent(obj, evt, fn) {
    if (obj.addEventListener) {
        obj.addEventListener(evt, fn, false);
    }
    else if (obj.attachEvent) {
        obj.attachEvent("on" + evt, fn);
    }
}
addEvent(window,"load",function(e) {
	prepare_cData();
	 addEvent(document, "mouseout", function(e) {
        e = e ? e : window.event;
        var from = e.relatedTarget || e.toElement;
        if (!from || from.nodeName == "HTML") {
            drag_activate = false;
        };
    });
});
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
	dp_ppuNtf(item_info.name);
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
		f_price: dt_f.f_price.value,
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
	dts.tg.prc.innerHTML = addComma(dts.og.prc) ;
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
prcd_cartb.onclick = function() {
	// check if client_info in home_data.js available
	if (isEmpty(client_info)) {
		// if empty: display client form
		alert("Please enter shipping info");
		$("#userProfile").click();
	} else {
		var cUrl = tbl_sDt.b_url + "/send_cart";
		var dtd = "clt_spI=" + JSON.stringify({client: client_info, cart: cart});
		ajax_request(cUrl, dtd, function(d) {
			clear_allItem();
			alert("Submit giỏ hàng thành công");
		});
		$(".close_btn").click();
	}
}
$("#userProfile").click(function(){
	var currentScroll = window.scrollY;
	$(".ship_info").css({
		"display" : "block",
		"top" : "calc(25% + " + currentScroll + "px)"
	});
});
shippingForm.onsubmit = send_shippingInfo;
shippingForm.submit.onclick = send_shippingInfo;


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
				alert("Your shipping info is successfully saved.");
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
// })();