// (function(){
set_evtOlbt();
var pkg_tblD = document.getElementById("pkg_tblD").children[0];
var pkg_sum = {};
var preset_data = new set_preset();
var base_url = preset_data.base_url;
var hdl = preset_data.hdl;
var is_pkgD = preset_data.is_pkgD;
if (is_pkgD) {
	return_pageOL();
}
function set_evtOlbt() {
	$("#ol_bt").click(function(){
		return_pageOL();
	});
}
$(".return_ppage").click(function(){
	return_pageOL();
});
function return_pageOL() {
	$(".orderList_wrapper").css({
		"display" : "block"
	});
	$(".orderDetail_wrapper").css({
		"display" : "none"
	});
	$(".fxRtlc").html(
		"<a id=\"ol_bt\">Order list</a>"
	);
	window.history.pushState("", "", base_url);
	var tr_s = pkg_tblD.getElementsByTagName("tr");
	while (tr_s[1]) {
		tr_s[1].parentNode.removeChild(tr_s[1]);
	}
	pkg_sum = {};
}
window.onhashchange = function() {
	return_pageOL();
}
window.addEventListener('popstate', function(event) {
	return_pageOL();
}, false);
var scrlBox = document.getElementsByClassName("tbl_orderList_wrapper")[0];

var order_load = {
	limit: 12,
	offset: 0,
	total_records: null,
	load_img: null,
	start_id: preset_data.start_id
}
var html_ordCtner = document.getElementById("order_ctnerTbl");
var orders = [];
var load_pause = false;
var temp_dom;
var first_load = true;
window.onload = function() {
	load_sumRecords();
	load_orders();
	pst_s_ord();
}
function load_sumRecords(data) {
	if (data == null) {
		var url = base_url;
		url += "/count_order_records";
		var ordr_dt = "r=" + JSON.stringify(order_load);
		ajax_request(url, ordr_dt, load_sumRecords);
	} else {
		order_load.total_records = data;
	}
}
function load_orders() {
	var url = base_url;
	url += "/load_order";
	var ordr_dt = "instruction=" + JSON.stringify(order_load);
	order_load.load_img = document.createElement("div");
	order_load.load_img.classList.add("load_gif");
	scrlBox.appendChild(order_load.load_img);
	ajax_request(url, ordr_dt, dpl_ordRcd);
}
scrlBox.onscroll = function() {
	if (load_pause || (order_load.total_records < order_load.offset)) return;
	var a = this.scrollTop + this.offsetHeight;
	var b = parseFloat(window.getComputedStyle(scrlBox).paddingTop) + this.firstElementChild.offsetHeight;
	if (a >= b) {
		load_pause = true;
		load_orders();
	}
}
function dpl_ordRcd(d) {
	order_load.load_img.parentNode.removeChild(order_load.load_img);
	if (order_load.total_records == 0) {
		return;
	}
	var d = JSON.parse(d);
	for (var i = 0; i < d.length; i++) {
		orders.push(d[i]);
	}
	for (var i = order_load.offset; i < orders.length; i++) {
		var cln = html_ordCtner.getElementsByClassName("order_tr")[0].cloneNode(true);
		cln.removeAttribute("style");
		var cln_td = cln.getElementsByTagName("td");
		cln_td[0].innerHTML = i + 1;
		cln_td[1].setAttribute("order-id",orders[i].id);
		cln_td[1].innerHTML = add_IDPrefix("OD",orders[i].id);
		cln_td[2].innerHTML = orders[i].name;
		cln_td[3].innerHTML = orders[i].phone;
		cln_td[4].innerHTML = orders[i].address;
		cln_td[5].innerHTML = sql_date_converter(orders[i].time_order);
		for (var j = 0; j < 6; j++) {
			cln_td[j].addEventListener("click",tr_barClick);
		}
		if (orders[i].ship_status == 1) {
			cln_td[6].firstElementChild.classList.add("atv_active");
			cln_td[6].firstElementChild.setAttribute("ship",1);
		} else {
			cln_td[6].firstElementChild.setAttribute("ship",0);
		}
		cln_td[6].firstElementChild.addEventListener("click", ship_click);
		cln_td[7].firstElementChild.addEventListener("click", remove_click);
		cln_td[8].firstElementChild.addEventListener("click", edit_click);
		html_ordCtner.children[1].appendChild(cln);
	}
	order_load.offset += order_load.limit;
	load_pause = false;
	if (order_load.start_id != "" && first_load == true) {
		first_load = false;
		document.getElementsByClassName("order_tr")[1].children[2].click();
	}
}
function ship_click() {
	if (this.getAttribute("ship") == 1) {
		this.setAttribute("ship",0);
		if ([].slice.call(this.classList).indexOf("atv_active") != - 1) {
			this.classList.remove("atv_active");
		}
	} else {
		this.setAttribute("ship",1);
		if ([].slice.call(this.classList).indexOf("atv_active") == - 1) {
			this.classList.add("atv_active");
		}
	}
	var record_id = this.parentNode.parentNode.querySelectorAll("[order-id]")[0].getAttribute("order-id");
	var url = base_url;
	url += "/edit_ship_status";
	var stt_dt = "r=" + JSON.stringify({"ship_bool": this.getAttribute("ship"), "order_id": record_id});
	ajax_request(url, stt_dt, cb_ship_stt);
}
function cb_ship_stt(data) {
	if (data == 0) {
		alert("Edit ship status error. Try again");
	}
}
function remove_click() {
	var pRn = this.parentNode.parentNode;
	temp_dom = pRn;
	var ord_id = pRn.querySelector("[order-id]").getAttribute("order-id");
	var cnf = confirm("Delete permanently order " + pRn.querySelector("[order-id]").textContent + "?");
	if (!cnf) return;
	var url = base_url;
	url += "/remove_order";
	var stt_dt = "order_id=" + ord_id;
	ajax_request(url, stt_dt, cb_rm_ord);
}
function cb_rm_ord(data) {
	console.log(data);
	if (data == 1) {
		alert("Delete order successful");
		order_load.offset--;
		order_load.total_records--;
		temp_dom.parentNode.removeChild(temp_dom);
		return;
	}
	alert("Unable to delete order. Try again later.");
}
var e_dstg = [];
function const_ed_stg(name, phone, add) {
	return {
		name: name,
		phone: phone,
		address: add
	};
}
function edit_click() {
	var pRn = this.parentNode.parentNode;
	var td = pRn.getElementsByTagName("td");
	var iconAE = this.getElementsByTagName("i")[0];
	var host_element = this;
	var current_val, temp_elm; 
	temp_dom = pRn;
	var x = [].slice.call(pRn.parentNode.getElementsByClassName("order_tr")).indexOf(pRn) - 1;
	if (x < 0) return;
	if (pRn.getAttribute("edit") == "off" || pRn.getAttribute("edit") == null) {
		pRn.setAttribute("edit","on");
		e_dstg[x] = {bf: null, af: null};
		var dt2s = [];
		for (var i = 2; i < 5; i++) {
			if (td[i].firstChild.nodeName != "#text") {
				pRn.setAttribute("edit","off");
				return;
			}	
			temp_elm = document.createElement("input");
			current_val = td[i].textContent;
			dt2s.push(current_val);
			temp_elm.value = "" + current_val;
			temp_elm.className = "edit_order_ip edoP_t" + i;
			td[i].replaceChild(temp_elm, td[i].firstChild);
		}
		iconAE.className = "fa fa-check";
		e_dstg[x].bf = new const_ed_stg(dt2s[0],dt2s[1],dt2s[2]);
	} else {
		pRn.setAttribute("edit","off");
		var dt2s = [];
		for (var i = 2; i < 5; i++) {
			if (td[i].firstChild.nodeName != "INPUT") {
				pRn.setAttribute("edit","on");
				return;
			}
			current_val = td[i].firstElementChild.value;
			dt2s.push(current_val);
			td[i].innerHTML = current_val;
		}
		e_dstg[x].af = new const_ed_stg(dt2s[0],dt2s[1],dt2s[2]);
		if (e_dstg[x].bf != null && e_dstg[x].af != null) {
			var diff_ed = check_diff_edit(e_dstg[x].bf, e_dstg[x].af);
			if (diff_ed) {
				e_dstg[x].af.ord_id = temp_dom.querySelector("[order-id]").getAttribute("order-id");
				
				// add loading icon
				var div = document.createElement("div");
				div.classList.add("load_gif_2");
				this.appendChild(div);
				iconAE.style.visibility = "hidden";

				// create server request using xhttp
				var url = base_url + "/edit_order";
				var send_data = "r=" +  JSON.stringify(e_dstg[x].af);
				ajax_request(url,send_data,function(d) {
					console.log(d);
					if (d == 1) {
						alert("Edit order info successful");
						orders[x].name = e_dstg[x].af.name;
						orders[x].phone = e_dstg[x].af.name;
						orders[x].address = e_dstg[x].af.name;
					} else {
						alert("Failed to edit order. Try again later");
						td[2].innerHTML = e_dstg[x].bf.name;
						td[3].innerHTML = e_dstg[x].bf.phone;
						td[4].innerHTML = e_dstg[x].bf.address;
					}
				});
			}
			var dtr = host_element.getElementsByTagName("div")[0];
			host_element.removeChild(dtr);
			iconAE.className = "fa fa-pencil";
			if (iconAE.hasAttribute("style")) iconAE.removeAttribute("style");
		}
	}
}

function check_diff_edit(a,b) {
	for (var p in a) {
		if (a[p] != b[p]) return true;
	}
	return false;
}
function tr_barClick(){
	var d = this.parentNode;
	if (this.firstChild.nodeName == "INPUT") return;
	$(".orderList_wrapper").css({
		"display" : "none"
	});
	$(".orderDetail_wrapper").css({
		"display" : "block"
	});
	hdl = d.querySelectorAll("[order-id]")[0].innerHTML;
	$(".fxRtlc").html(
		"<a id=\"ol_bt\">Order list</a> > <a>Order detail</a>"
		+ ": " + hdl
	);
	var new_url = base_url + "/package/" + hdl;
	// window.history.pushState("", "", new_url);
	set_evtOlbt();
	// set data for package
	var url = base_url;
	url += "/load_package";
	pkg_sum.order_id = d.querySelectorAll("[order-id]")[0].getAttribute("order-id");
	var pkg_dt = "order_id=" +  pkg_sum.order_id;
	ajax_request(url, pkg_dt, dpl_pkgRcd);
}
function dpl_pkgRcd(d) {
	d = JSON.parse(d);
	pkg_sum.totalItems = d.length;
	pkg_sum.totalPrice = 0;
	for (var i = 0; i < d.length; i++) {
		var tr = document.createElement("tr");
		for (var j = 0; j < 8; j++) tr.appendChild(document.createElement("td"));
		var td_s = tr.getElementsByTagName("td");
		td_s[0].innerHTML = i + 1;
		td_s[1].setAttribute("product-id",d[i].product_id);
		td_s[1].innerHTML = add_IDPrefix("SP",d[i].product_id);
		td_s[2].innerHTML = d[i].p_name;
		td_s[3].innerHTML = addComma(d[i].p_price);
		// price sale
		var p_sale = d[i].prcTotal / d[i].qty;
		td_s[4].innerHTML = addComma(p_sale);
		// sale
		p_sale = p_sale / d[i].p_price;
		p_sale = p_sale < 1 ? (100 - p_sale * 100) + "%" : 0;
		td_s[5].innerHTML = p_sale;
		td_s[6].innerHTML = d[i].qty;
		td_s[7].innerHTML = addComma(d[i].prcTotal);
		pkg_sum.totalPrice += parseInt(d[i].prcTotal);
		pkg_tblD.appendChild(tr);
	}
	set_ordSum();
}
// order summary 
var ord_sum = {
	c_name: document.getElementById("c_name"),
	c_phone: document.getElementById("c_phone"),
	c_add: document.getElementById("c_add"),
	c_status: document.getElementById("c_status"),
	time_order: document.getElementById("time_order"),
	s_price: document.getElementById("s_price"),
	s_items: document.getElementById("s_items"),
}
function set_ordSum() {
	var ord = find_ordId(pkg_sum.order_id);
	ord_sum.c_name.innerHTML = ord.name;
	ord_sum.c_phone.innerHTML = ord.phone;
	ord_sum.c_add.innerHTML = ord.address;
	if (ord.ship_status == 1) {
		ord_sum.c_status.classList.add("atv_active");
		ord_sum.c_status.setAttribute("title","shipped");
	} else {
		if ([].slice.call(ord_sum.c_status.classList).indexOf("atv_active") != -1) {
			ord_sum.c_status.classList.remove("atv_active");
		}
		ord_sum.c_status.setAttribute("title","not shipped");
	}
	ord_sum.time_order.innerHTML = sql_date_converter(ord.time_order);
	ord_sum.s_price.innerHTML = addComma(pkg_sum.totalPrice);
	ord_sum.s_items.innerHTML = pkg_sum.totalItems;
}
function find_ordId(id) {
	for (var p in orders) {
		if (orders[p].id == id) {
			return orders[p];
		}
	}
}
$("[info-target]").click(function(){
	var x = this.getAttribute('info-target');
	var y = $("[info-receiver=" + x + "]");
	if (y[0].hasAttribute('hide')) {
		y[0].removeAttribute('hide');
		this.classList.add('opt_atv');
	} else {
		y[0].setAttribute('hide','');
		this.classList.remove('opt_atv');
	}
});
$(".str_opt").click(function(){
	if (!this.hasAttribute('info-target')) {
		var b = $(".str_opt");
		var c = 'opt_atv';
		var h = this.getAttribute('hit-target');
		if (h != 'ord_dwnld') {
			var p = $(this).parents('.wr_store_c')[0];
			var q = p.querySelector('[receiver=' + h + ']');
			for (var i = 0; i < b.length; i++) {
				if (b[i].classList.contains(c)) 
					b[i].classList.remove(c);
			}
			this.classList.add(c);
			// clear chosen box to empty
			var g = $('[chosen]');
			for (var i = 0; i < g.length; i++) 
				g[i].removeAttribute('chosen');
			q.setAttribute('chosen','');
		}
	}
});
var ord_s_bucket;
var ord_s_clone = $(".s_ord_row")[0];
var crr_o_data = JSON.parse(preset_data.ord_seller);
function pst_s_ord() {
	ord_s_clone.parentNode.removeChild(ord_s_clone);
	ord_s_clone.removeAttribute('hide');
	ord_s_clone.classList.remove('s_ord_row');
	var x = {};
	var v = crr_o_data;
	for (var i in v) {
		x[i] = [];
		if (v[i].length > 0) {
			for (var j = 0; j < v[i][0].length; j++) 
				x[i][j] = v[i][0][j];
		}
	}
	crr_o_data = x;
}
$("[hit-target=ord_seen]").click(function(){
	load_ord_sX(this,1);
});
$("[hit-target=ord_notseen]").click(function(){
	load_ord_sX(this,0);
});
$("[hit-target=ord_text]").click(function(){
	dpl_ord_tbl(this);
	// fill data
	var x =  $(this).parents('[store-id]');
	var c = x.find('[receiver=ord_text]')[0];
	c.innerHTML = "";
	var st_id = x[0].getAttribute('store-id');
	var y = crr_o_data[st_id];
	var str_v;
	for (var i = 0; i < y.length; i++) {
		str_v = "";
		str_v += (i + 1) + " - ";
		str_v += y[i].address + " - ";
		str_v += y[i].qty + " - ";
		str_v += y[i].product_name + "\n";
		str_v = document.createTextNode(str_v);
		c.appendChild(str_v);
	}
});
$("[hit-target=ord_dwnld]").click(function(){
	var t = $(this).parents(".wr_store_c");
	var f = t.find('[store_data_f]')[0];
	var n = new Date();
	n = n.getHours() + "h" + n.getMinutes() + "m" + n.getSeconds() +
		"s" + n.getDate() + "_" + (n.getMonth() + 1) + "_" + n.getFullYear();
	n += f.s_sn.value + "_" + f.s_on.value + ".txt";
	var v = t.find('[receiver=ord_text]').val();
	v = v.split('\n').join('\r\n');
	download(n,v);
});
function load_ord_sX(dom,type) {
	var  x =  $(dom).parents('[store-id]');
	var st_id = x[0].getAttribute('store-id');
	ord_s_bucket = dom.getAttribute('hit-target');
	ord_s_bucket = x.find('[receiver=' + ord_s_bucket + ']');
	// get data
	get_upd_seen(st_id,type,push_data_s);
	// update button interface
	dpl_ord_tbl(dom);
}
function dpl_ord_tbl(d) {
	var a = d.getAttribute('hit-target');
	var t = $("[receiver=" + a + "]");
	var x = $(d).parents('[store-id]');
	var m = x[0].getAttribute('store-id');
	for (var i = 0; i < t.length; i++) {
		var y = $(t[i]).parents('[store-id]')[0];
		if (y.getAttribute('store-id') == m) t = t[i];
	}
	var r = x[0].querySelectorAll('[receiver]');
	for (var i = 0; i < r.length; i++) {
		if (!r[i].hasAttribute('hide')) r[i].setAttribute('hide','');
	}
	for (var i = 0; i < r.length; i++) {
		if (r[i].getAttribute('receiver') == a) 
			r[i].removeAttribute('hide');
	}
}
function get_upd_seen(id,t,cb) {
	var url = base_url + "/get_vendor_ajax";
	var r = "r=" + JSON.stringify({
		store_id: id,
		get_type: t,
	});
	ajax_request(url,r,cb);
}
function push_data_s(d) {
	if (!d) return;
	d = JSON.parse(d);
	var x = ord_s_bucket;
	var y;
	if (d.length > 0) {
		x.html('');
		for (var i = 0; i < d.length; i++) {
			y = ord_s_clone.cloneNode(true);
			$(y).children('.ord_col_1').html(i + 1);
			$(y).children('.ord_col_2').html(d[i].address);
			$(y).children('.ord_col_3').html(d[i].product_name);
			$(y).children('.ord_col_4').html(d[i].qty);
			x[0].appendChild(y);
		}
	}
	// fill data in offset data
	var x_id = $(x).parents(".wr_store_c")[0].getAttribute('store-id');
	crr_o_data[x_id] = d;
}
$("[clr_ord_dpl]").click(function(){
	var x = this.getAttribute('clr_ord_dpl');
	var y = $(this).parents('[store-id]');
	var z = y.find('[chosen]');
	var a = z[0].getAttribute('receiver');
	var b = y[0].getAttribute('store-id');

	var url = base_url + '/set_vendor_view';
	var r = 'r=',s;
	switch (a) {
		case 'ord_seen':
			s = {'type':'2','store_id':b};
			break;
		case 'ord_notseen':
			s = {'type':'1','store_id':b};
			break;
		default:
			break;
	}
	r += JSON.stringify(s);
	ajax_request(url,r,function(d){
		console.log(d);
	});
});

// })()