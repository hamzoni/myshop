var t_c = document.getElementById("adm_pnDt");
var upd_dP = setInterval(function(){
	t_c.innerHTML = dateFormat(new Date(), "hh:MM:ss mm-dd-yyyy");
},1000);
document.getElementById("lgOut_b").onclick = function() {
	var url = new set_preset().base_url + "/access_object";
	var r = "r=" + JSON.stringify({obj:"AUTHc", func:"logout"});
	ajax_request(url, r, function(d){
		window.close();
	});
}

var srh_egn = {
	d: {
		f: window.search_f,
		b: window.search_f.sb_sf,
		t: window.search_f._typeVal,
		smD: {
			tPg: window.search_f.sr_tPg,
			id: window.search_f.sr_tId
		}
	}
}
srh_egn.d.b.onclick = function(e) {
	srh_egn.d.f.method = "POST";
	if (srh_egn.d.f.action == "" || 
		srh_egn.d.smD.tPg.value == "" ||
		srh_egn.d.smD.id.value == "") {
		e.preventDefault();
		return false;
	}
}
var search_enable = true;
var prev_slc = {
	t: document.getElementById("sgg_ctner").getElementsByClassName("ctn_srcd"),
	i: -1
}
srh_egn.d.t.onkeyup = function(e) {
	if (e.keyCode == 38) {
		if (prev_slc.i > 0) new_select(0);
	} else if (e.keyCode == 40) {
		if (prev_slc.i < prev_slc.t.length - 1) new_select(1);
	} else if (e.keyCode == 13) {
		srh_egn.d.b.click();
		return;
	} else {
		searching();
	}
	function new_select(t) {
		if (prev_slc.i !== -1) {
			if (prev_slc.t[prev_slc.i].hasAttribute("selected")) {
				prev_slc.t[prev_slc.i].removeAttribute("selected");
			}
		}
		prev_slc.i += t == 1 ? 1 : - 1;
		prev_slc.t[prev_slc.i].setAttribute("selected","");
		form_fSearch(prev_slc.t[prev_slc.i]);
	}
}
var hidden_search = false;
function searching(v = null) {
	if (!search_enable) return;
	prev_slc.i = -1;
	srh_egn.d.f.action = "";
	search_enable = false;
	var url = new set_preset().base_url + "/request_method";
	var r = {
		v: v == null ? srh_egn.d.t.value : v,
		obj: "SEARCH_ADMIM",
		func: "get_suggestion",
	}
	r = "r=" + JSON.stringify(r);
	ajax_request(url, r, function(d){
		if (v != null) hidden_search = true;
		insert_suggestion(d);
	});
}
function insert_suggestion(d) {
	srh_egn.d.f.action = "";
	d = JSON.parse(d);
	var dct_wrapper = document.getElementById("search_thing");
	var dct = document.getElementById("sgg_ctner");
	dct.innerHTML = "";
	if (is_sDataEmpty(d) || srh_egn.d.t.value == "") {
		search_enable = true;
		dct_wrapper.style.display = "none";
		return;
	}
	for (var p in d) {
		for (var i = 0; i < d[p].length; i++) {
			var djRc = document.createElement("a");
			djRc.className = "ctn_srcd";
			djRc.setAttribute("f_action",d[p][i].href);
			djRc.setAttribute("t_id",d[p][i].id);
			djRc.setAttribute("t_pg",d[p][i].page);
			dcRt = [];
			for (var j = 0; j < 4; j++) {
				dcRt[j] = document.createElement("div");
				dcRt[j].className = "col_ctSr";
				dcRt[j].setAttribute("type","c" + (j + 1));
			}
			switch (p) {
				case "orders":
				case "clients":
					dcRt[0].innerHTML = add_IDPrefix(p == "orders" ? "OD" : "KH",d[p][i].id);
					dcRt[1].innerHTML = d[p][i].name;
					dcRt[2].innerHTML = d[p][i].phone;
					dcRt[3].innerHTML = d[p][i].address;
					break;
				case "products":
					dcRt[0].innerHTML = add_IDPrefix("SP",d[p][i].id);
					dcRt[1].innerHTML = d[p][i].name;
					dcRt[2].innerHTML = d[p][i].price;
					dcRt[3].innerHTML = d[p][i].sale * 100 + "%";
					break;
			}
			for (var j = 0; j < 4; j++) djRc.appendChild(dcRt[j]);
			djRc.onclick = function() {
				dct_wrapper.style.display = "none";
				form_fSearch(this);
			}
			dct.appendChild(djRc);
		}
	}
	if (hidden_search) {
		hidden_search = false;
		var adt = document.getElementsByClassName("ctn_srcd");
		form_fSearch(adt[0]);
		srh_egn.d.b.click();
	} else {
		dct_wrapper.style.display = "block";
	}
	search_enable = true;
}
function form_fSearch(d) {
	srh_egn.d.t.value = d.firstElementChild.textContent;
	srh_egn.d.smD.id.value = d.getAttribute("t_id");
	srh_egn.d.smD.tPg.value = d.getAttribute("t_pg");
	srh_egn.d.f.action = d.getAttribute("f_action");
}
function is_sDataEmpty(x) {
	var n = Object.keys(x).length;
	var c = 0;
	for (var i in x) {
		if (x[i].length <= 0) c++;
	}
	if (c == n) return true;
	return false;
}

var ntf_ctner = document.getElementById("_notify");
var ntf_counter = document.getElementById("notificationsCountValue");
var ntf_crr_dpl = 0;
var ntf_no_seen = 0;
var ntf_clN = document.getElementsByClassName("ord_clst_ntf")[0];
var ntfCC_tt = document.getElementsByClassName("th_ctt_adnt")[0];
var ntb = document.getElementById("ntf");
var base_title = document.title;
var ntf_check_itv;
var ld_ntf = {
	lmt: 15, 
	ofs: 0,
	max: 0,
	mxT: 0,
}
ntb.onclick = function() {
	if (ntf_ctner.hasAttribute("hide")) {
		ntf_counter.innerHTML = "";
		document.title = base_title;
		ntf_counter.setAttribute("hide","");
		var ntb_pX = window.innerWidth - $("#ntf").offset().left - 
					 ntb.getBoundingClientRect().right + ntb.getBoundingClientRect().left - 20;
		ntf_ctner.style.right = ntb_pX + "px";
		ntf_ctner.removeAttribute("hide");
	} else {
		ld_ntf.max = 0;
		ntf_ctner.setAttribute("hide","");
		$("[not_seen]").removeAttr("not_seen");
		ajax_request(ajax_url("have_seen_order_ntf"),null,null);
	}
}
var p_ld_n = false;
function load_ordNew() {
	if (p_ld_n) return; 
	p_ld_n = true;
	var url = new set_preset().base_url + "/request_new_order";
	if (ld_ntf.ofs > ld_ntf.mxT || ld_ntf.mxT == 0) return;
	var r = "r=" + JSON.stringify({
		d: 7, // previous order in 7 days
		c: ["id","name","time_order","address","totalValue","view"],
		b: {
			lmt: ld_ntf.lmt, 
			ofs: ld_ntf.ofs,
			max: ld_ntf.max,
		}
	}); // date range: 7 days from now
	ajax_request(url,r,function(d){
		load_ntf_ord(d);
	});
}
function load_ntf_ord(d){
	d = JSON.parse(d);
	p_ld_n = false;
	add_newNTF(d);
}
function add_newNTF(d,bf = null) {
	for (var i = 0; i < d.length; i++) {
		if (!check_idNTF_avlb(d[i].id)) {
			var x = ntf_clN.cloneNode(true);
			x.removeAttribute("hide");
			if (d[i].view == 0) x.setAttribute("not_seen","");
			x.setAttribute("ord_idN",d[i].id);
			x.getElementsByClassName("ordID")[0].innerHTML = add_IDPrefix("OD",d[i].id);
			x.getElementsByClassName("ordCname")[0].innerHTML = d[i].name;
			x.getElementsByClassName("ordAdd")[0].innerHTML = d[i].address;
			x.getElementsByClassName("ordprcVal")[0].innerHTML = d[i].totalValue;
			x.getElementsByClassName("ordtime")[0].setAttribute("sql_date" ,d[i].time_order);
			x.getElementsByClassName("ordtime")[0].innerHTML = sql_date_converter(d[i].time_order);
			x.onclick = function() {
				var ord_id = this.getElementsByClassName("ordID")[0].textContent;
				searching(ord_id);
			}
			if (bf) {
				++ld_ntf.max;
				dpl_ntfCounter(ld_ntf.max);
				ntfCC_tt.insertBefore(x, ntfCC_tt.firstElementChild);
			} else {
				ntfCC_tt.appendChild(x);
			}
			ntf_crr_dpl++;
			ld_ntf.ofs++;
		}
	}
}
function check_idNTF_avlb(x) {
	var a = ntfCC_tt.children;
	for (var i = 0; i < a.length; i++) {
		if (a[i].getAttribute("ord_idn") == x) return true;
	}
	return false;
}
ntfCC_tt.onscroll = function() {
	var x = this.scrollTop;
	var y = this.offsetHeight;
	var h = $(".ord_clst_ntf").height() + 1;
	var z = h * ntf_crr_dpl;
	if (x + y >= z - h) load_ordNew();
}
function ld_maxOrdNw() {
	ntf_clN.parentNode.removeChild(ntf_clN);
	var url = new set_preset().base_url + "/count_new_order";
	ajax_request(url,null,function(d) {
		ld_ntf.max = d;
		dpl_ntfCounter(ld_ntf.max);
		ajax_request(ajax_url('count_all_order'),null,function(d){
			ld_ntf.mxT = d;
			load_ordNew();
			ntf_check_itv = setInterval(function(){
				if (ntfCC_tt.children.length > 0) {
					var r = "r=" + ntfCC_tt.firstElementChild.getAttribute("ord_idn");
					ajax_request(ajax_url("check_new_order"),r,function(d){
						d = JSON.parse(d);
						add_newNTF(d,true);
					});
				}
			},1000);
		});
	});
}
function dpl_ntfCounter(n) {
	if (n == 0) {
		ntf_counter.innerHTML = "";
		document.title = base_title;
		ntf_counter.setAttribute("hide","");
		return;
	}
	ntf_counter.innerHTML = n;
	document.title = "(" + n + ") " + base_title;
	ntf_counter.removeAttribute("hide");
}
function ajax_url(link) {
	return  new set_preset().base_url + "/" + link;
}
(function(){
	ld_maxOrdNw();
})();