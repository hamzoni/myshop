var c_tbl = {
	rcd_t: {
		limit: 10, 
		offset: 0, 
		total_records: null,
		last_pgClick: 0
	},
	type: 'client',
	url: 'count_client_records',
	tbl: $("#client_tbl")[0],
}
var u_tbl = {
	rcd_t: {
		limit: 10, 
		offset: 0, 
		total_records: null,
		last_pgClick: 0
	},
	type: 'user',
	url: 'count_user_records',
	tbl: $("#user_tbl")[0],
}
var psd = new set_preset();
var u_data = new Array();
var ban_list; 
// tbody
var tbl_rc = document.getElementById("cLr_ct").children[1];
var tbl_ur = document.getElementById("clr_ur");
window.onload = function() {
	load_clientData(c_tbl.rcd_t.limit, c_tbl.rcd_t.offset);
	load_userData(u_tbl.rcd_t.limit, u_tbl.rcd_t.offset);
	load_pagination(null,u_tbl);
	load_pagination(null,c_tbl);
}
var cln_m = tbl_rc.getElementsByClassName("order_tr")[0];
var cln_c = tbl_ur.getElementsByClassName("user_rec")[0];
function load_userData(a,b) {
	var user_load = {lim: a, offs: b, start_id: psd.start_id};
	var url = psd.base_url + "/load_userData";
	var r = "r=" + JSON.stringify(user_load);
	ajax_request(url,r,function(d){
		d = JSON.parse(d);
		ban_list = d[1];
		solve_data(d[0]);
	});
	function solve_data(d) {
		var prv = tbl_ur.getElementsByClassName("order_tr");
		if (prv.length > 0) {
			while (prv[0]) tbl_ur.removeChild(prv[0]);
		}
		for (var i = 0; i < d.length; i++) {
			var c = cln_c.cloneNode(true);
			c.removeAttribute('hide');
			c.setAttribute("u_id",d[i].id);
			attr_slc_d(c,'u_av')[0].querySelector('img').src = d[i].picture;
			$(attr_slc_d(c,'u_fn')[0]).val(d[i].last_name + " " + d[i].first_name);
			$(attr_slc_d(c,'u_em')[0]).val(d[i].email);
			$(attr_slc_d(c,'u_gd')[0]).val(d[i].gender);
			$(attr_slc_d(c,'u_pv')[0]).val(d[i].oauth_provider);
			$(attr_slc_d(c,'u_cr')[0]).val(d[i].created);
			$(attr_slc_d(c,'u_ud')[0]).val(d[i].modified);
			$(attr_slc_d(c,'u_bn')[0]).click(function(){
				ban_FBuser(this);
			});
			attr_slc_d(c,'fb_u')[0].href = d[i].link;
			tbl_ur.appendChild(c);
		}
	}
}
// ban data 
var ban_data = {};
var crr_ban = {};
var b_dpl = {x:0,y:0};
var b_f = {
	f: window.ban_form,
}
// check permanent ban
b_f.p = b_f.f.p_ban;
// start date input
b_f.s = [
	b_f.f.s_ss, b_f.f.s_MM, b_f.f.s_hh,
	b_f.f.s_dd, b_f.f.s_mm, b_f.f.s_YY,
]
// end date input
b_f.e = [
	b_f.f.e_ss, b_f.f.e_MM, b_f.f.e_hh,
	b_f.f.e_dd, b_f.f.e_mm, b_f.f.e_YY,
]
// end date input offset
b_f.i = {
	v:b_f.f.ext_v,
	t:b_f.f.ext_t,
}
// auto extend date input
b_f.a = {
	v:b_f.f.ext_va,
	t:b_f.f.ext_a,
}
function new_ban(start,end,interval) {
	this.time = {
		start: start,
		end: end
	}
	this.extend = interval;
}
// click on user
function ban_FBuser(d) {
	var md = findAncestor(d,'user_rec');
	var id = md.getAttribute('u_id');
	var bd = (function(){
		for (var i = 0; i < ban_list.length; i++) {
			if (ban_list[i].id = id) return ban_list[i];
		}
	})();
	if (isNaN(parseInt(id))) return;

	b_dpl.x = getOffsetLeft(d) - $(".sideMenu_bar").outerWidth() + 11;
	b_dpl.y = getOffsetTop(d) - $("[u_id=" + id + "]").innerHeight() + 1;
	// start filling data
	toggle_dpl_ban(undefined,bd);
	crr_ban.id = id;
}
function set_ban_data(bd) {
	if (bd) {
		fill_date_data('start_date',new Date(bd.start_date));
		fill_date_data('end_date',new Date(bd.end_date));
		b_f.p.checked = bd.permanent == 1;
		convert_time_gap(bd.periodic);
		find_diff_date();
	}
}
// toggle display ban window
function toggle_dpl_ban(sw,cr) {
	b_f.f.reset();
	$(b_f.f).css({
		'left': b_dpl.x + 'px',
		'top': b_dpl.y + 'px'
	});
	if (sw) {
		if (sw == 1) b_f.f.removeAttribute('hide');
		if (sw == 0) b_f.f.setAttribute('hide','');
	} else {
		if (b_f.f.hasAttribute('hide')) {
			b_f.f.removeAttribute('hide');
			set_ban_data(cr);
		} else {
			b_f.f.setAttribute('hide','');
		}
	}	
}
$('.bd_close').click(function(){
	toggle_dpl_ban(0);
});
b_f.f.onreset = function() {
	$(".dpl_b_opt").html('Day');
	$(".ext_b_opt").attr('hide','');
	b_f.i.t.value = 2;
	b_f.a.t.value = 2;
	crr_ban = {};
}
// set default ban value 
$("[max-length]").keypress(function(e){
	var y = this.getAttribute('max-length');
	y = parseInt(y);
	if ((e.keyCode < 48 || e.keyCode > 57)) return false;
	if (this.value.length >= y && !isTextSelected(this)) return false;
});
$("[max-length]").keyup(function(e){
	if (this.hasAttribute('min-val') &&
		this.hasAttribute('max-val')) {
		var x = this.value;
		var y = this.getAttribute('max-length');
		var a = this.getAttribute('min-val');
		var b = this.getAttribute('max-val');
		y = parseInt(y);
		if (x.length >= y) {
			x = parseInt(x);
			a = parseInt(a);
			if (x < a) this.value = "";
			if (x > b) this.value = "";
		}
	}
	if (!this.hasAttribute('diff_date'))
		find_diff_date();
});
function convert_time_gap(dD) {
	if (dD > 0) {
		var d;
		dD *= 60;
		var r = [diff_minute(dD),diff_hour(dD),diff_day(dD),month_convert(dD)];
		for (var i = r.length - 1; i >= 0; i--) {
			if (r[i] > 0) {
				d = i;
				break;
			}
		}
		b_f.a.v.value = r[d];
		b_f.a.t.value = d;
		$("[receiver=ext_auto]").html(b_f_opt[d]);
	}
}
function find_diff_date() {
	if (chk_date_empty()) return;
	var d = return_date_val();
	var dD = d.e.valueOf() - d.s.valueOf();
	var r = [];
	if (dD > 0) {
		dD = dD / 1000
		r = [diff_minute(dD),diff_hour(dD),diff_day(dD),diff_month(d.s,d.e),diff_year(d.s,d.e)];
		for (var i = r.length - 1; i >= 0; i--) {
			if (r[i] > 0) {
				d = i;
				break;
			}
		}
		if (r[d]) {
			b_f.i.v.value = r[d];
			b_f.i.t.value = d;
			$("[receiver=ext_ban]").html(b_f_opt[d]);
		}
	}
}
function chk_date_empty() {
	var F = false;
	[b_f.s,b_f.e].forEach(function(x){
		if (F = chk_null_date(x)) return;
	});
	if (F) return true;
	return false;
}
$("._choose_now_btn").click(function(e){
	e.preventDefault();
	var t = this.getAttribute('sender');
	fill_date_data(t, new Date());
	find_diff_date();
	return false;
});
function fill_date_data(t,date) {
	var x = get_time_split(date,true);
	var y = get_date_split(date,true);
	var i = 2, j = 5, m;
	t == 'start_date' ? m = b_f.s : m = b_f.e;
	for (var p in x) m[i--].value = x[p];
	for (var p in y) m[j--].value = y[p];
}
// set select option
var f_yr = new Date().getFullYear();
var b_f_opt = ['minute','hour','day','month','year'];
var b_f_opm = {
	'minute':{max:60, min:0},
	'hour':{max:24, min:0},
	'day':{max:31, min:1},
	'month':{max:12, min:1},
	'year':{max:f_yr + 100, min: f_yr} 
};
var b_a_opt = ['minute','hour','day','month'];
$(".ext_b_opt span").click(function(){
	var v = this.getAttribute("value");
	var t = $(this).parent('.ext_b_opt').attr('sender');
	var r = $('[receiver=' + t + ']');
	var h = null, _v;
	if (t == 'ext_ban') {
		_t = b_f_opt[v];
		_v = b_f_opm[_t]
		b_f.i.t.value = v;
		if (_t != 'year') {
			b_f.i.v.setAttribute('max-val',b_f_opm[_t].max);
			b_f.i.v.setAttribute('min-val',b_f_opm[_t].min);
		} else {
			b_f.i.v.removeAttribute('max-val');
			b_f.i.v.removeAttribute('min-val');
		}
		h = b_f_opt[v];
	} else {
		b_f.a.t.value = v;
		h = b_a_opt[v];
	}
	r.html(h);
	toggle_dpl_eOpt($(this).parent('.ext_b_opt')[0],r[0]);
	upd_end_date();
});
b_f.i.v.onkeyup = function() {
	upd_end_date();
}

function upd_end_date() {
	var x = parseInt(b_f.i.v.value);
	var y = b_f_opt[parseInt(b_f.i.t.value)];
	if (!isNaN(x) && !chk_date_empty()) {
		var d = return_date_val().s;
		switch (y) {
			case b_f_opt[0]: // minute
				d = new Date(new Date().setMinutes(d.getMinutes() + x));
				break;
			case b_f_opt[1]: // hour
				d = new Date(new Date().setHours(d.getHours() + x));
				break;
			case b_f_opt[2]: // day
				d = new Date(new Date().setDate(d.getDate() + x));
				break;
			case b_f_opt[3]: // month
				d = new Date(new Date().setMonth(d.getMonth() + x));
				break;
			case b_f_opt[4]: // year
				d = new Date(new Date().setFullYear(d.getFullYear() + x))
				break;
		}

		fill_date_data(null,d);
	}
}
$(".dpl_b_opt").click(function(){
	var t = $(this).attr('receiver');
	var r = $('[sender=' + t + ']')[0];
	toggle_dpl_eOpt(r,this);
});
function toggle_dpl_eOpt(t,x) {
	if (t.hasAttribute("hide")) {
		t.removeAttribute("hide");
		x.classList.remove('opt_down');
		x.classList.add('opt_up');
	} else {
		t.setAttribute("hide","");
		x.classList.remove('opt_up');
		x.classList.add('opt_down');
	}
}
var target_input = 'start_date';
var date_picker;
var cld_wrp = $(".ban_dialog")[0];
$("._choose_calendar").click(function(e){
	e.preventDefault();
	if (!this.hasAttribute('cld_atv')) {
		remove_all_attr('cld_atv');
		this.setAttribute('cld_atv','');
		target_input = this.getAttribute('sender');
		$(".bd_r_wrp").css({
			'visibility':'visible',
		});
		cld_wrp.style.width = "460px";
		// display calendar accordingly to currently chosen date
		var x = this.getAttribute('sender');
		var d = x == 'start_date' ? return_date_val().s : return_date_val().e;
		d = invalid_date(d) ? new Date() : d;
		date_picker.options.selectedDate = d;
		date_picker.options.firstDate   = d;
		date_picker.render();
	} else {
		this.removeAttribute('cld_atv');
		cld_wrp.style.width = "258px";
		$(".bd_r_wrp").css({
			'visibility':'hidden',
		});
	}
	return false;
});
$(window).on("load",function(e) {
	cld_wrp.style.width = "258px";
	$(".bd_r_wrp").css({
		'visibility':'hidden',
	});
	// CALENDAR
	$('#dpl_date_ip').glDatePicker({
		showAlways: true,
		calendarOffset: {
			x: 0, 
			y: 1 
		},
		todayDate: new Date(),
		onClick: (function(el, cell, date, data) {
			el.val(date.toLocaleDateString());
			var t = get_date_split(date,true);
			fill_date_input(t);
			find_diff_date();
		}),
	});
	date_picker = $('#dpl_date_ip').glDatePicker(true);
})
function fill_date_input(d) {
	var st_i = b_f.s.length - 1;
	if (target_input == 'start_date') {
		for (var p in d) b_f.s[st_i--].value = d[p];
	} else {
		for (var p in d) b_f.e[st_i--].value = d[p];
	}
}
b_f.f.onsubmit = function(e) {
	e.preventDefault();
	if  (!b_f.p.checked) { // permanent ban
		crr_ban.permanent = 0;
		// check empty value
		var d = {s: b_f.s,e: b_f.e};
		for (var p in d) {
			if (chk_null_date(d[p])) {
				alert("Error: blank input");
				return false;
			}
		}
		// check date diff valid
		var dD = return_date_val().e.valueOf() - return_date_val().s.valueOf();
		if (dD <= 0) {
			alert("Error: invalid ban schedule");
			return false;
		}
		cvT_timestampSQL
		var n_ban = new new_ban(
			cvT_timestampSQL(return_date_val().s),
			cvT_timestampSQL(return_date_val().e),
			(function(){
				var x = parseInt(b_f.a.v.value);
				var y = b_f_opt[parseInt(b_f.a.t.value)];
				switch (y) {
					case 'hour': 
						x = x * 60;
						break;
					case 'day': 
						x = x * 60 * 24;
						break;
					case 'month': 
						x = Math.round(x * 60 * 24 * 30.5);
						break;
				}
				return x;
			})()
		);
		crr_ban = concate_obj(crr_ban,n_ban);
	} else {
		crr_ban.permanent = 1;
	}
	ajax_request(psd.base_url + "/ban_FBUser",
		"r=" + JSON.stringify(crr_ban),
		function(d) {
			if (d == 1) {
				toggle_dpl_ban(0);
			} else {
				alert("Error: unable to ban user")
			}
		}
	);
	return false;
}
function return_date_val() {
	var d = {s: b_f.s,e: b_f.e};
	var n = {s:[],e:[]};
	for (var p in d) {
		for (var i = 0; i < d[p].length; i++) {
			n[p][i] = parseInt(d[p][i].value);
			if (i == 4) n[p][i]--;
		};
		n[p] = new Date(n[p][5],n[p][4],n[p][3],n[p][2],n[p][1],n[p][0],0);
	}
	
	return n;
}
function chk_null_date(a) {
	for (var i = 0; i < a.length; i++) {
	 	var x = a[i].value;
		if (isNaN(x) || x == "" || undefined === x) return true;
	}
	return false;
}
// remove user ban
$(".rmv_ur_ban").click(function(){
	if (crr_ban.id) {
		var url = psd.base_url + "/remove_user_ban";
		var r = "r=" + crr_ban.id;
		ajax_request(url,r,function(d){
			if (d == 1) {
				toggle_dpl_ban(0);
			} else {
				alert("Error: Failed to ban user");
			}
		});
	}
});
// end of ban FB user function
function load_clientData(a, b) {
	var client_load = {lim: a, offs: b, start_id: psd.start_id};
	var url = psd.base_url + "/load_clientData";
	var ordr_dt = "instruction=" + JSON.stringify(client_load);
	ajax_request(url, ordr_dt, function(data){solve_data(data)});
	function solve_data(d) {
		var prv = $("#cLr_ct")[0].getElementsByClassName("order_tr");
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
			td[10].firstElementChild.onclick = delete_client;
			td[11].firstElementChild.onclick = edit_client;
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
function delete_client() {
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
			load_clientData(c_tbl.rcd_t.limit, c_tbl.rcd_t.offset);
			load_pagination(null,c_tbl);
			return;
		}
		alert("Unable to delete user data. Try again");
	}
}
function edit_client() {
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
function load_pagination(data, tbl) {
	if (data == null) {
		var url = psd.base_url;
		url += "/" + tbl.url;
		ajax_request(url, null, function(d){
			load_pagination(d,tbl);
		});
	} else {
		c_tbl.rcd_t.total_records = parseInt(data);
		var n_pgB = Math.ceil(c_tbl.rcd_t.total_records / c_tbl.rcd_t.limit);
		var ul = c_tbl.tbl.getElementsByClassName("nav_ctn")[0];
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
			if (c_tbl.rcd_t.last_pgClick == idx) return;
			for (var i = 0; i < ul.children.length; i++) {
				ul.children[i].className = "";
			}
			ul.children[idx].className = "atv_pgn";
			c_tbl.rcd_t.offset = idx * c_tbl.rcd_t.limit;
			load_clientData(c_tbl.rcd_t.limit, c_tbl.rcd_t.offset);
			c_tbl.rcd_t.last_pgClick = idx;
		}
		document.getElementById("pgn_right").onclick = function() {
			var temp = c_tbl.rcd_t.last_pgClick;
			if (temp + 1 < ul.children.length) {
				ul.children[c_tbl.rcd_t.last_pgClick + 1].click();
			}
			move_offset(c_tbl.rcd_t.last_pgClick);
		}
		document.getElementById("pgn_left").onclick = function() {
			var temp = c_tbl.rcd_t.last_pgClick;
			if (temp - 1 >= 0) {
				ul.children[c_tbl.rcd_t.last_pgClick - 1].click();
			}
			move_offset(c_tbl.rcd_t.last_pgClick);
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