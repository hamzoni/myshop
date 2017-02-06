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
		srh_egn.d.smD.id.value == ""
	) {
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
		if (!search_enable) return;
		prev_slc.i = -1;
		srh_egn.d.f.action = "";
		search_enable = false;
		var url = new set_preset().base_url + "/request_method";
		var r = {
			v: srh_egn.d.t.value,
			obj: "SEARCH_ADMIM",
			func: "get_suggestion",
		}
		r = "r=" + JSON.stringify(r);
		ajax_request(url, r, function(d){
			insert_suggestion(d);
		});
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
	dct_wrapper.style.display = "block";
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