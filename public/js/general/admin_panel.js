var t_c = document.getElementById("adm_pnDt");
var upd_dP = setInterval(function(){
	t_c.innerHTML = dateFormat(new Date(), "hh:MM:ss mm-dd-yyyy");
},1000);
document.getElementById("lgOut_b").onclick = function() {
	var url = new set_preset().base_url + "/access_object";
	var r = "r=" + JSON.stringify({obj:"AUTHc", func:"logout"});
	console.log("ok");
	ajax_request(url, r, function(d){
		window.close();
	});
}

var srh_egn = {
	d: {
		f: window.search_f,
		b: window.search_f.sb_sf,
		t: window.search_f._typeVal
	}
}
srh_egn.d.b.onclick = function(e) {
	e.preventDefault();
	var url = new set_preset().base_url + "/request_method";
	var r = {
		v: srh_egn.d.t.value,
		obj: "SEARCH_ADMIM",
		func: "execute_search",
	}
	r = "r=" + JSON.stringify(r);
	ajax_request(url, r, function(d){
		console.log(d);
	});
	return false;
}
var search_enable = true;
srh_egn.d.t.onkeyup = function() {
	if (!search_enable) return;
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
function insert_suggestion(d) {
	d = JSON.parse(d);
	var dct_wrapper = document.getElementById("search_thing");
	var dct = document.getElementById("sgg_ctner");
	dct.innerHTML = "";
	if (is_sDataEmpty(d)) {
		search_enable = true;
		dct_wrapper.style.display = "none";
		return;
	}
	dct_wrapper.style.display = "block";
	for (var p in d) {
		for (var i = 0; i < d[p].length; i++) {
			var djRc = document.createElement("a");
			djRc.className = "ctn_srcd";
			djRc.href = "http://google.com";
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
			dct.appendChild(djRc);
		}
	}
	search_enable = true;
}
function is_sDataEmpty(x) {
	for (var i in x) {
		if (x[i].length <= 0) return true;
	}
	return false;
}