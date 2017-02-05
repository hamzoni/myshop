var f_main = window.document.prf_form;
var psd = new set_preset();
var ad_prf = new set_profile();
var codeK = [];
function set_profile() {}
set_profile.prototype.getDom  = function(df) {
	this.dom = new function() {
		this.name = df.name,
		this.phone = df.phone,
		this.email = df.email,
		this.avatar = df.avatar,
		this.login_key = [],
		this.login_code = df.login_code
	}
}
set_profile.prototype.getVal = function(obj) {
	this.val = new function() {
		this.name = obj.name.value;
		this.phone = obj.phone.value;
		this.email = obj.email.value;
		this.avatar = obj.avatar.value;
		this.login_key = codeK;
		this.login_code = obj.login_code.value;
	}
	
}
set_profile.prototype.setDom = function() {
	this.getDom(f_main);
}
set_profile.prototype.setVal = function() {
	this.getVal(this.dom);
}
set_profile.prototype.setDomVal = function() {
	for (var x in this.dom) {
		if (x != "login_key") this.dom[x].value = this.val[x];
	}
	for (var i = 0; i < this.val.login_key.length; i++) {
		add_spanKey(this.val.login_key[i]);
	}
	readImage(ad_prf.val.avatar);
}
var keyBoxC = document.getElementById("spc_keyB");
(function(){
	f_main.action = psd.base_url + "/upl_admin_avatar";
	ad_prf.setDom();
	ad_prf.setVal();
})();
var denyFocus;
var itv_blink;
var insertKeyRequest = false;
document.getElementById("atv_kRcd").onclick = function(e) {
	e.preventDefault();
	var i_dplIcon = this.firstElementChild;
	if (this.getAttribute("record") == 0 || this.getAttribute("record") == null) {
		this.setAttribute("record", 1);
		i_dplIcon.className = "fa fa-stop";
		itv_blink = setInterval(function(){
			if (window.getComputedStyle(i_dplIcon).display != "none") {
				i_dplIcon.style.display = "none";
			} else {
				i_dplIcon.removeAttribute("style");
			}
		}, 800);
		insertKeyRequest = true;
		window.addEventListener("keypress",suppressTyping);
		var w_input = document.getElementsByTagName("input");
		denyFocus = setInterval(function(e){
			for (var i = 0; i < w_input.length; i++) w_input[i].blur();
		},1);
	} else {
		this.setAttribute("record", 0);
		this.firstElementChild.className = "fa fa-circle";
		i_dplIcon.removeAttribute("style");
		window.clearInterval(itv_blink);
		insertKeyRequest = false;
		window.removeEventListener("keypress",suppressTyping);
		if (typeof denyFocus == "number") window.clearInterval(denyFocus);
	}
	return false;
}
function insertKeyBox(e) {
	c = e.keyCode;
	if (c == undefined 
		|| codeK.indexOf(c) != -1 
		|| keys_discrepancy(c) 
		|| show_keysVal(c) == undefined) return;
	
	switch (c) {
		case 8:
			if (codeK.length > 0) {
				codeK.splice(codeK.length - 1, 1);
				keyBoxC.removeChild(keyBoxC.lastElementChild);
			}
			break;
		case 46:
			if (codeK.length > 0) {
				codeK.splice(0,1);
				keyBoxC.removeChild(keyBoxC.firstElementChild);
				break;
			}
		default:
			if (codeK.length >= 3) {
				alert("Limit 3 Login keys");
				return;
			}
			add_spanKey(c);
			codeK.push(c);
			break;
	}
	ad_prf.setVal();
}
function add_spanKey(k) {
	var dom = document.createElement("span");
	dom.innerHTML = show_keysVal(k);
	dom.addEventListener("click",function(){
		if (f_main.getAttribute("edit") != 1) return;
		var idx = [].slice.call(keyBoxC.children).indexOf(this);
		codeK.splice(idx,1);
		keyBoxC.removeChild(this);

	})
	keyBoxC.appendChild(dom);
}
function reset_codeKey() {
	keyBoxC.innerHTML = "";
	ad_prf.val.login_key = []
	codeK = [];
}
function suppressTyping(e) {
	e.preventDefault();
	return false;
}
$('html').keydown(function(e){
	if(insertKeyRequest) {
		insertKeyBox(e);
	}
})
document.getElementById("dpl_text").onclick = function(e) {
	e.preventDefault();
	if (this.getAttribute("show") == 0 || this.getAttribute("show") == null) {
		this.setAttribute("show",1);
		this.firstElementChild.className = "fa fa-eye-slash";
		ad_prf.dom.login_code.setAttribute("type","text");
	} else {
		this.setAttribute("show",0);
		this.firstElementChild.className = "fa fa-eye";
		ad_prf.dom.login_code.setAttribute("type","password");
	}
	return false;
}
// avatar image upload
var cvs = document.getElementById("admin_avatar");
var ctx = cvs.getContext('2d');
document.getElementById("upl_ava").onclick = function(e) {
	e.preventDefault();
	f_main.upl_avaCtner.click();
	return false;
}
f_main.upl_avaCtner.onchange = handleImage;

// submit profile form
f_main.onsubmit = function(e) {
	e.preventDefault();
	if (this.getAttribute("edit") == 0 || this.getAttribute("edit") == null) {
		this.setAttribute("edit", 1);
		update_interface(1);
	} else {
		this.setAttribute("edit", 0);
		update_interface(0);
		ad_prf.setVal();
		var formData = new FormData(this);
		if (ad_prf.dom.avatar.value == "" || f_main.upl_avaCtner.value != "") {
			$.ajax({
				type:'POST',
				url: $(this).attr('action'),
				data:formData,
				cache:false,
				contentType: false,
				processData: false,
				success:function(data){
				data = JSON.parse(data);
					if (data.error != undefined && data.file_name == undefined) {
						alert(data.error);
					} else {
						ad_prf.dom.avatar.value = data.file_name;
						ad_prf.setVal();
						store_profile();
					}
				},
				error: function(data){
					throw data;
				}
			});
		} else {
			store_profile();
		}
	}
	return false;
}
function update_interface(x) {
	if (x == 1) {
		ad_prf.dom.name.disabled = false;
		ad_prf.dom.phone.disabled = false;
		ad_prf.dom.email.disabled = false;
		ad_prf.dom.login_code.disabled = false;
		ad_prf.dom.name.classList.remove("unl_rsx");
		ad_prf.dom.phone.classList.remove("unl_rsx");
		ad_prf.dom.email.classList.remove("unl_rsx");
		keyBoxC.classList.remove("key_ctner");
		$("#upl_ava").css({"visibility":"visible"});
		$("#atv_kRcd").css({"display":"block"});
		$("#dpl_text").css({"display":"block"});
		f_main.sbm_Dt.value = "submit";
	} else {
		ad_prf.dom.name.disabled = true;
		ad_prf.dom.phone.disabled = true;
		ad_prf.dom.email.disabled = true;
		ad_prf.dom.login_code.disabled = true;
		ad_prf.dom.name.classList.add("unl_rsx");
		ad_prf.dom.phone.classList.add("unl_rsx");
		ad_prf.dom.email.classList.add("unl_rsx");
		keyBoxC.classList.add("key_ctner");
		$("#upl_ava").css({"visibility":"hidden"});
		$("#atv_kRcd").css({"display":"none"});
		$("#dpl_text").css({"display":"none"});
		f_main.sbm_Dt.value = "edit";
	}
}
function store_profile() {
	var url2send = psd.base_url + "/store_profile";
	var data2send = "r=" + JSON.stringify(ad_prf.val);
	ajax_request(url2send,data2send,function(d){
		alert("Done");
	});	
}
// load profile 
window.onload = function() {
	load_profile();
}
function load_profile() {
	$url = psd.base_url + "/load_profile";
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			if (this.responseText == 0) return;
			ad_prf.val = JSON.parse(/.+(?=\")/.exec(this.responseText.replace(/\\+/g,"").replace(/^\"/g,''))[0]);
			codeK = ad_prf.val.login_key;
			ad_prf.setDomVal();
		}
	};
	xhttp.open("GET", $url, true);
	xhttp.send();
}