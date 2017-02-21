var sps = new set_preset();
var udr = false;

var dx = {}; // clone data for comparison
var f = {d:{},v:{}};
f.d.f = window.ctc_dt;
f.d.b = f.d.f.cf_btn; // submit
f.d.lg = f.d.f.logo_imgFile; // logo
f.d.fc = f.d.f.favi_ic; // favicon
f.d.d = f.d.f.pg_dcrpt; // description
f.d.t = f.d.f.hp_ttl; // home page title

f.v = new set_fv();
dx = new set_fv();
// index tracker 
var idx_t = {
	wAddrs: 0,
	wEmail: 0,
	wFBacc: 0,
	wPhone: 0,
}
// check typed
var fdt_tpe = {
	wAddrs:[false],
	wEmail:[false],
	wFBacc:[false],
	wPhone:[false],
};
// check saved
var fdt_atv = {
	wAddrs:[false],
	wEmail:[false],
	wFBacc:[false],
	wPhone:[false],
};
var wDscrp = false;

function set_value(x = null,y = null) {
	this.label =  x;
	this.data = y;
}
function set_fv() {
	this.wBLogo = null;
	this.wDscrp = null;
	this.wHpgtt = null;
	this.wAddrs = [new set_value(null,null)];
	this.wEmail = [new set_value(null,null)];
	this.wFBacc = [new set_value(null,null)];
	this.wPhone = [new set_value(null,null)];
}
// load data from file
f.d.f.action = sps.base_url + "/upl_trademark";
function load_pageInfo() {
	var url = sps.base_url + "/load_pageInfo";
	ajax_request(url,null,function(d){
		d = "\"" + d.match(/{.+}/g)[0] + "\"";
		set_display_data(JSON.parse(JSON.parse(d)));
	});
}
function set_display_data(x) {
	readImage_c($("#fav_ic")[0], 'img/favicon.ico');
	if (x.wDscrp != "") {
		f.d.d.value = x.wDscrp;
		f.v.wDscrp = x.wDscrp;
	}
	if (x.wBLogo != null) {
		readImage_c($("#logo_cvs")[0], x.wBLogo);
		f.v.wBLogo = x.wBLogo;
	}
	if (x.wHpgtt != null) {
		f.d.t.value = x.wHpgtt;
		f.v.wHpgtt = x.wHpgtt;
	}
	var fw, fc, fb, fi, fg;
	for (var p in x) {
		if (x[p].constructor === Array) {
			fw = attr_slc_d(f.d.f,["type",p])[0];
			fc = fw.firstElementChild;
			for (var i = 0; i < x[p].length; i++) {
				if (x[p][i] != null) {
					idx_t[p]++;
					f.v[p][i] = x[p][i];
					fdt_tpe[p][i] = false;
					fdt_atv[p][i] = false;

					fb = fw.getElementsByClassName("data_wrp")[0];
					if (i != 0) fb = fb.cloneNode(true);
					fb.setAttribute("index",i);
					fi = fb.getElementsByTagName("input");

					fi[0].value = f.v[p][i].label;
					fi[1].value = f.v[p][i].data;
					if (i != 0) {
						fi[0].addEventListener("keyup",function(){auto_type(this)});
						fi[1].addEventListener("keyup",function(){auto_type(this)});
						fb.querySelector("[opt=edit]").onclick = function(){tgg_edt(this)};
						fb.querySelector("[opt=delete]").onclick = function(){rmv_frm(this)};
						fc.appendChild(fb);
					}
				}
			}
		}
	}
	// set data for clone data
	dx = jQuery.extend(true, {}, f.v);
}
function dt_chg(x) {
	if (udr == x) return;
	udr = x;
	if (udr) {
		f.d.b.setAttribute("prepare","");
		return;
	}
	f.d.b.removeAttribute("prepare");
}
// add more field
$("[name=_add]").click(function(){
	var x = this.parentNode.getElementsByClassName("data_wrp");
	var y = this.parentNode.getElementsByClassName("field_ctner")[0];
	var z = x[0].cloneNode(true);
	var m = z.getElementsByTagName("input");
	for (var i = 0; i < m.length; i++) {
		m[i].addEventListener("keyup",function(){auto_type(this)});
		m[i].setAttribute("disabled","")
		m[i].value = null;
	}
	z.querySelector("[opt=edit]").onclick = function(){tgg_edt(this)};
	z.querySelector("[opt=delete]").onclick = function(){rmv_frm(this)};
	var n_tpe = y.parentNode.getAttribute("type");
	var n_idx = idx_t[n_tpe]++;
	z.setAttribute("index",n_idx);
	fdt_atv[n_tpe][n_idx] = false;
	fdt_tpe[n_tpe][n_idx] = false;
	f.v[n_tpe][n_idx] = new set_value(null,null);
	y.appendChild(z);
});
$("[opt=edit]").click(function(){tgg_edt(this);});
$("[opt=delete]").click(function(){rmv_frm(this);});
$("[name=website_lbl]").keyup(function(){
	check_diff(this,auto_type);
});
$("[name=website_addr]").keyup(function(){
	check_diff(this,auto_type);
});

function check_diff(d,fx) {
	if (fx) fx(d);
	dt_chg((function(){
		for (var p in f.v) {
			if (f.v[p].constructor === Array) {
				for (var i = 0; i < f.v[p].length; i++) {
					if (f.v[p][i].label != dx[p][i].label ||
						f.v[p][i].data != dx[p][i].data) {
						return true;
					}
				}
			} else {
				if (f.v[p] != dx[p]) return true;
			}
		}
		return false;
	})());
}
function auto_type(d) {
	var v = d.value;
	var pr_i = findAncestor(d,"data_wrp");
	var pr_t = findAncestor(d,"field_wrapper");
	var n_idx = pr_i.getAttribute("index");
	var n_tpe = pr_t.getAttribute("type");

	var ipt = pr_i.getElementsByClassName("ipt_dtf");
	ipt = html_arr(ipt);
	if (ipt.indexOf(d) == 0) {
		if (!fdt_tpe[n_tpe][n_idx]) {
			ipt[1].value = auto_prototype(v,n_tpe);
			if (v == "") ipt[1].value = "";
		}
		f.v[n_tpe][n_idx].label = d.value;
	} else {
		fdt_tpe[n_tpe][n_idx] = true;
		if (v == "") fdt_tpe[n_tpe][n_idx] = false;
		f.v[n_tpe][n_idx].data = d.value;
	}
}
function auto_prototype(t,x) {
	switch (x) {
		case "wAddrs":
			t = "http://www." + t + "/";
			break;
		case "wEmail":
			if (t.indexOf("@") == -1) {
				t = t.toLowerCase() + "@" + window.location.hostname;
			} else {
				t = t.toLowerCase();
			}
			break;
		break;
		case "wFBacc":
			t = "https://fb.me/" + t;
			break;
		break;
		case "wPhone":
			t = t.replace(/[^\d]+/g,'');
			break;
	}
	return t;
}

// edit button
function tgg_edt(d) {
	var pr_i = findAncestor(d,"data_wrp");
	var pr_t = findAncestor(d,"field_wrapper");
	var ipt = pr_i.getElementsByTagName("input");
	var n_idx = pr_i.getAttribute("index");
	var n_tpe = pr_t.getAttribute("type");
	if (fdt_atv[n_tpe][n_idx]) {
		ipt[0].setAttribute("disabled","");
		ipt[1].setAttribute("disabled","");
		f.v[n_tpe][n_idx].label = ipt[0].value;
		f.v[n_tpe][n_idx].data = ipt[1].value;
	} else {
		ipt[0].removeAttribute("disabled");
		ipt[1].removeAttribute("disabled","");
	}
	fdt_atv[n_tpe][n_idx] = !fdt_atv[n_tpe][n_idx];
}
// remove button
function rmv_frm(d) {
	dt_chg(true);
	var pr_i = findAncestor(d,"data_wrp");
	var pr_t = findAncestor(d,"field_wrapper");
	var n_idx = pr_i.getAttribute("index");
	var n_tpe = pr_t.getAttribute("type");
	pr_i.parentNode.removeChild(pr_i);
	f.v[n_tpe][n_idx] = new set_value();
}
// edit text area
var txt_d = document.getElementById("edit_dcrp_w");
txt_d.onclick = function(e) {
	e.preventDefault();
	if (wDscrp) {
		this.firstElementChild.className = "fa fa-pencil";
		f.d.d.setAttribute("disabled","");
		f.v.wDscrp = f.d.d.value;
	} else {
		this.firstElementChild.className = "fa fa-floppy-o";
		f.d.d.removeAttribute("disabled");
	}
	wDscrp = !wDscrp;
	return false;
}
f.d.d.onkeyup = function(){
	check_diff(this,upd_wDscrp);
}
function upd_wDscrp(d) {
	f.v.wDscrp = d.value;
}

function store_all() {
	var iptt = f.d.f.getElementsByClassName("ipt_dtf");
	var pr_i, pr_t;
	for (var i = 0; i < iptt.length; i++) {
		pr_i = findAncestor(iptt[i],"data_wrp").getAttribute("index");
		pr_t = findAncestor(iptt[i],"field_wrapper").getAttribute("type");
		if (fdt_atv[pr_t][pr_i]) tgg_edt(iptt[i]);
	}
	if (wDscrp) txt_d.click();
	// remove any null and empty data
	for (var p in f.v) {
		if (f.v[p].constructor === Array) {
			var g = attr_slc_d(f.d.f,["type",p])[0];
			for (var i = 0, j = 0; i < f.v[p].length; i++, j++) {
				if ((f.v[p][i].label == "" || f.v[p][i].label == null) &&
					(f.v[p][i].data == "" || f.v[p][i].data == null)) {
					var x = attr_slc_d(g,["index",j])[0];
					if (x) g.firstElementChild.removeChild(x);
					fdt_atv[p].splice(i,1);
					fdt_tpe[p].splice(i,1);
					f.v[p].splice(i,1);
					idx_t[p]--;
					i--;
				}
			}
			// re indexing dom
			for (var i = 0; i < f.v[p].length; i++) {
				var h = g.getElementsByClassName("data_wrp");
				h[i].setAttribute("index",i);
			}
		}		
	}
}
// avatar image upload
var cvs, ctx;
document.getElementById("upl_cvs").onclick = function(e) {
	e.preventDefault();

	cvs = document.getElementById("logo_cvs");
	ctx = cvs.getContext('2d');
	f.d.lg.click();

	return false;
}
f.d.lg.onchange = function(e) {
	dt_chg(true);
	handleImage(e);
}
// favicon upload
document.getElementById("upd_favicon").onclick = function() {

	cvs = document.getElementById("fav_ic");
	ctx = cvs.getContext('2d');
	f.d.fc.click();
}
f.d.fc.onchange = function(e) {
	dt_chg(true);
	handleImage(e);
}
// submit data to server 
f.d.f.onsubmit = function(e) {
	e.preventDefault();
	if (!udr) return;
	store_all();
	if (f.d.lg.value != "" || f.d.fc.value != "") {
		$.ajax({
			type:'POST',
			url: $(this).attr('action'),
			data: new FormData(this),
			cache:false,
			contentType: false,
			processData: false,
			success:function(data){
				if (typeof data == 'object') {
					data = JSON.parse(data);
					if (data.error != undefined && data.file_name == undefined) {
						alert(data.error);
					} else {
						f.v.wBLogo = data.file_name;
						store_pageInfo();
					}
				}
				console.log(data);
			},
			error: function(data){
				throw data;
			}
		});
	} else {
		store_pageInfo();
	}
	return false;
}
function store_pageInfo() {
	// update logo 
	$(".logo_ctner").find("img").attr("src",f.v.wBLogo);
	// store data to file
	var url = sps.base_url + "/store_pageInfo";
	var r = "r=" + JSON.stringify(f.v);
	ajax_request(url,r,function(d){
		dt_chg(false);
		alert("Done");
	});	
}
f.d.t.onkeyup = function(){
	f.v.wHpgtt = this.value;
	check_diff();
}
$(".hptwr > .db_dtr").click(function(e){
	$(this).hide().prev("input[disabled]").prop("disabled", false).focus();
});
$(".hpg_ttl").blur(function(){
	$(".hptwr > .db_dtr").show();
	$(this).prop("disabled",true);
	f.v.wHpgtt = $(this).val();
});
window.onload = function() {
	load_pageInfo();
}

