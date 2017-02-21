(function(){

var map = {}; // You could also use an array
var data_load = false;
onkeydown = onkeyup = function(e){
    e = e || event; // to deal with IE
    map[e.keyCode] = e.type == 'keydown';
    if (data_load) check_loginKey();
}
var admin_data = {};
window.onload = function() {
	load_admin_profile("login_key");
}
function load_admin_profile() {
	var url = new preset_data().b_url + "/load_Adprofile";
	ajax_request(url,null,function(d){
		admin_data = JSON.parse(/.+(?=\")/.exec(d.replace(/\\+/g,"").replace(/^\"/g,''))[0]);
		data_load = true;
	});
}
function check_loginKey() {
	for (var i = 0; i < admin_data.login_key.length; i++) {
		if (!map[admin_data.login_key[i]]) return false;
	}
	for (var i = 0; i < admin_data.login_key.length; i++) {
		map[admin_data.login_key[i]] = false;
	}
	display_loginPanel();
}
var logged_in = new preset_data().lg_s;
var intv_lgStt = logged_in != 0 ? setInterval(check_login_status, 1 * 1000) : 0;
function display_loginPanel() {
	if (logged_in != 0) {
		window.open(logged_in);
		return;
	} else {
		var keyCode = prompt("Enter Admin code: ","");
		if (keyCode == admin_data.login_code) {
			var url = new preset_data().b_url + "/create_AdSession";
			var r = "r=" + new Date().valueOf();
			ajax_request(url, r, function(d) {
				logged_in = d ? d : 0;
				intv_lgStt = setInterval(check_login_status, 1 * 1000);
				window.open(d);
			});
		} else {
			alert("Admin code is not correct")
		}
	}
}
function check_login_status() {
	try {
		var url = new preset_data().b_url + "/check_ADlogin_stt"; 
			ajax_request(url, null, function(d){
				if (d == 0) {
					location.reload();
				} else {
					logged_in = d;
				}
			});
	} catch (err) {};
}


})();