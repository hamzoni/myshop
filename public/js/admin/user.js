var records_track = {
	limit: 10, 
	offset: 0, 
	total_records: null,
	last_pgClick: 0
};
var psd = new set_preset();
var u_data = new Array();
var tbl_rc = document.getElementById("cLr_ct").children[1];
window.onload = function() {
	load_clientData(records_track.limit, records_track.offset);
	load_pagination();
}
var cln_m = document.getElementsByClassName("order_tr")[0];
function load_clientData(a, b) {
	var client_load = {lim: a, offs: b, start_id: psd.start_id};
	var url = psd.base_url;
	url += "/load_clientData";
	var ordr_dt = "instruction=" + JSON.stringify(client_load);
	ajax_request(url, ordr_dt, function(data){solve_data(data)});
	function solve_data(d) {
		var prv = document.getElementsByClassName("order_tr");
		if (prv.length > 0) {
			while (prv[0]) {
				tbl_rc.removeChild(prv[0]);
			}
		}
		d = JSON.parse(d);
		u_data = d;
		for (var i = 0; i < d.length; i++) {
			var cloneNd = cln_m.cloneNode(true);
			cloneNd.removeAttribute("style");
			var td = cloneNd.getElementsByTagName("td");
			td[1].setAttribute("user-id",d[i].id);
			td[1].innerHTML = add_IDPrefix("KH",d[i].id);
			td[2].innerHTML = d[i].name;
			td[3].innerHTML = d[i].phone;
			td[4].innerHTML = d[i].address;
			td[5].innerHTML = addComma(d[i].purchase_count);
			td[6].innerHTML = addComma(d[i].total_purchaseVal);
			td[7].innerHTML = sql_date_converter(d[i].signup_date);
			td[8].innerHTML = sql_date_converter(d[i].last_update);
			if (d[i].status == 1) td[9].firstElementChild.classList.add("atv_stt");
			td[9].firstElementChild.setAttribute("status", d[i].status);
			td[9].firstElementChild.onclick = ban_user;
			td[10].firstElementChild.onclick = delete_user;
			td[11].firstElementChild.onclick = edit_user;
			tbl_rc.appendChild(cloneNd);
		}
	}
}
function ban_user() {
	var elm = this;
	var tr = this.parentNode.parentNode;
	var user_id = tr.querySelector("[user-id]").getAttribute("user-id");
	var user_sttVal = this.getAttribute("status");
	user_sttVal == 1 ? user_sttVal = 0 : user_sttVal = 1;
	ajax_request(psd.base_url + "/ban_client", "c_stt=" + JSON.stringify({id:user_id, val: user_sttVal}),function(data){
		solve_data(data, elm);
	});
	function solve_data(x, d) {
		if (x == 1) {
			user_sttVal == 1 ? d.classList.add("atv_stt") : d.classList.remove("atv_stt");
			return;
		}
		alert("Failed to ban user. Try again");
	}
}
function delete_user() {
	var elm = this;
	var tr = this.parentNode.parentNode;
	var user_id = tr.querySelector("[user-id]").getAttribute("user-id");
	var url = psd.base_url;
	url += "/delete_client";
	var rq = "r=" + user_id;
	ajax_request(url, rq, function(data){solve_data(data)});
	function solve_data(d) {	
		if (d == 1) {
			tbl_rc.removeChild(tr);
			load_clientData(records_track.limit, records_track.offset);
			load_pagination();
			return;
		}
		alert("Unable to delete user data. Try again");
	}
	
}
function edit_user() {
	var mTr = this.parentNode.parentNode;
	var idx = [].slice.call(document.getElementsByClassName("order_tr")).indexOf(mTr);
	var power_on = this.getAttribute("edit");
	if (power_on == 0 || power_on == null) {
		this.setAttribute("edit",1);
		this.firstElementChild.className = "fa fa-check";
		var l_keys = Object.keys(psd.maxData_length);
		var max_lBk = [];
		for (var i = 2, j = 0; i < 5; i++, j++) {
			max_lBk[i] = psd.maxData_length[l_keys[j]];
			mTr.children[i].setAttribute("contenteditable", true);
			mTr.children[i].style.color = "#000";
			mTr.children[i].style.backgroundColor = "#fff";
			mTr.children[i].onkeyup = function() {
				var ip_idx = [].slice.call(mTr.children).indexOf(this);
				if (this.textContent.length > max_lBk[ip_idx]) {
					this.innerHTML = this.innerHTML.substr(0, max_lBk[ip_idx]);
				}
			}
		}
	} else {
		this.setAttribute("edit",0);
		for (var i = 2; i < 5; i++) {
			mTr.children[i].removeAttribute("contenteditable");
			mTr.children[i].removeAttribute("style");
		}
		if (u_data[idx].name != mTr.children[2].textContent ||
			u_data[idx].phone != mTr.children[3].textContent ||
			u_data[idx].address != mTr.children[4].textContent) {
			var elm = this;
			var new_data = {
				id: u_data[idx].id,
				name: mTr.children[2].textContent,
				phone: mTr.children[3].textContent,
				address: mTr.children[4].textContent
			}
			this.firstElementChild.style.visibility = "hidden";
			this.classList.add("load_w");
			ajax_request(psd.base_url + "/edit_client", "r=" + JSON.stringify(new_data),function(data){
				solve_data(data, elm);
			});
			function solve_data(data, dom) {
				var n_mTr = dom.parentNode.parentNode;
				dom.classList.remove("load_w");
				dom.firstElementChild.removeAttribute("style");
				dom.firstElementChild.className = "fa fa-pencil";
				if (data == 1) {
					u_data[idx].name = n_mTr.children[2].textContent;
					u_data[idx].phone = n_mTr.children[3].textContent;
					u_data[idx].address = n_mTr.children[4].textContent;
					return;
				}
				alert("Edit record failed. Try again");
				n_mTr.children[2].innerHTML = u_data[idx].name;
				n_mTr.children[3].innerHTML = u_data[idx].phone;
				n_mTr.children[4].innerHTML = u_data[idx].address;
			}
		} else {
			this.firstElementChild.className = "fa fa-pencil";
		}
	}
}
function load_pagination(data) {
	if (data == null) {
		var url = psd.base_url;
		url += "/count_client_records";
		ajax_request(url, null, load_pagination);
	} else {
		records_track.total_records = parseInt(data);
		var n_pgB = Math.ceil(records_track.total_records / records_track.limit);
		var ul = document.getElementsByClassName("nav_ctn")[0];
		var df_dpl = 5;
		var crr_dpl = {a:0,b:4};
		ul.innerHTML = "";
		for (var i = 0; i < n_pgB; i++) {
			var li = document.createElement("li");
			li.addEventListener("click",load_newPg);
			var span = document.createElement("span");
			span.classList.add("VAAlign");
			span.innerHTML = i + 1;
			if (i > 4) {
				li.style.display = "none";
			}
			li.appendChild(span);
			ul.appendChild(li);
		}
		ul.firstElementChild.classList.add("atv_pgn");
		function load_newPg() {
			var idx = [].slice.call(ul.children).indexOf(this);
			if (records_track.last_pgClick == idx) return;
			for (var i = 0; i < ul.children.length; i++) {
				ul.children[i].className = "";
			}
			ul.children[idx].className = "atv_pgn";
			records_track.offset = idx * records_track.limit;
			load_clientData(records_track.limit, records_track.offset);
			records_track.last_pgClick = idx;
		}
		document.getElementById("pgn_right").onclick = function() {
			var temp = records_track.last_pgClick;
			if (temp + 1 < ul.children.length) {
				ul.children[records_track.last_pgClick + 1].click();
			}
			move_offset(records_track.last_pgClick);
		}
		document.getElementById("pgn_left").onclick = function() {
			var temp = records_track.last_pgClick;
			if (temp - 1 >= 0) {
				ul.children[records_track.last_pgClick - 1].click();
			}
			move_offset(records_track.last_pgClick);
		}
		function move_offset(idx) {
			if (idx < crr_dpl.a || idx > crr_dpl.b) {
				if (idx > crr_dpl.b) {
					crr_dpl.b = idx;
					crr_dpl.a = idx - (df_dpl - 1);
				} else if (idx < crr_dpl.a) {
					crr_dpl.a = idx;
					crr_dpl.b = idx + df_dpl - 1;
				}
				for (var i = 0; i < ul.children.length; i++) ul.children[i].style.display = "none";
				for (var i = crr_dpl.a; i <= crr_dpl.b; i++) ul.children[i].style.display = "block";
			}
		}
	}
}