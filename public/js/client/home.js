// pre-set clone
var cart_dataTbl = document.getElementById("cart_dataTbl");
cart_dataTbl = cart_dataTbl.childNodes[2];
var clone_trDtbl = $("#cart_dataTbl").children("tbody").find("tr").clone(true,true);
$("#cart_dataTbl").children("tbody").find("tr").remove()

// display pop-up
$(".close_btn").click(function(){
	var box_to_close = this.parentNode.parentNode;
	box_to_close.style.display = "none";
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
	var currentScroll = window.scrollY;
	$(".food_detail").css({
		"display" : "block",
		"top" : "calc(25% + " + currentScroll + "px)"
	});
	fill_dtFI(this.parentNode.getElementsByClassName("food_data_cluster")[0]);
	document.getElementById("qty_ifcIf").value = "1";
});
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
	var myDForm = this.parentNode.getElementsByClassName("food_data_cluster")[0];
	insert_itemCart(myDForm);
});
function insert_itemCart(data_form,i_qty = 1){
	var is_form = data_form.nodeName !== undefined;
	// push data to as pre-set
	var item_info = {
		id: is_form ? data_form.f_id.value : data_form.f_id,
		name: is_form ? data_form.f_name.value : data_form.f_name,
		price: is_form ? data_form.f_price.value : data_form.f_price,
		qty: parseInt(i_qty == 0 ? 1 : i_qty) // default
	}
	// check if data is repeated
	var fId_list = [];
	for (var i =0; i < cart.items_list.length; i++) {
		fId_list.push(cart.items_list[i].id);
	}
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
	tr_clone.find("[prc]").text(addComma(cart.items_list[total_items].price));
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
		cart.total_bill += cart.items_list[i].qty * parseInt(cart.items_list[i].price);
	}
	var sum_bill = document.getElementById("sum_billC");
	sum_bill.innerHTML = addComma(cart.total_bill);
	document.getElementById("nbr_itemsIC").innerHTML = total_items;
}
// clear order
document.getElementById("clear_cart").onclick = clear_allItem;
function clear_allItem() {
	cart_dataTbl.innerHTML = ""
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
