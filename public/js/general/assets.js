function addComma(a) {
	if (a == undefined || a == null) return;
	a = a.toString();
	var n = "" , j = 0;
	for (var i = a.length - 1; i >= 0; i--) {
		n += i % 3 == 0 && i != 0 ? + a[j] + "," : a[j];
		j++;
	}
	return n;
}
function attr_selector(attr) {
	var match_elms = [];
	var all = document.getElementsByTagName('*');
	for (var i = 0, n = all.length; i < n; i++) {
		if (all[i].getAttribute(attr) !== null) {
			match_elms.push(all[i]);
		}
	}
	return match_elms;
}
function html_arr(collection) {
	return Array.prototype.slice.call(collection);
}
// preview image on canvas
function handleImage(e){
	var reader = new FileReader();
	reader.onload = function(e){
		readImage(e.target.result);
	}
	reader.readAsDataURL(e.target.files[0]);     
}
function readImage(imgSrc) {
	var img = new Image();
	img.onload = function() {
		cvs.width = img.width;
		cvs.height = img.height;
		ctx.drawImage(img,0,0);
		// resize canvas to fit outer layer
		cvs.style.width = "100%";
		cvs.style.height = "100%";
	}
	img.src = imgSrc;
}
// select all checkboxes that are checked
function get_allCheckedCkb(classname) {
	var dom = document.getElementsByClassName(classname);
	var chk_ctner = [];
	for (var i = 0; i < dom.length; i++) {
		if (dom[i].checked == true) {
			chk_ctner.push(dom[i]);
		}
	}
	return chk_ctner;
}
function cvT_timestampSQL(ms) {
	var date = new Date(ms);
	var d_obj = {
		date:date.getDate(),
		month:date.getMonth() + 1,
		year:date.getFullYear(),
		hour:date.getHours() + 1,
		minute: date.getMinutes(),
		seconds: date.getSeconds()
	}
	var timeStr = d_obj.year + "-" + d_obj.month + "-" + d_obj.date + " " + d_obj.hour + ":" + d_obj.minute + ":" + d_obj.seconds;
	return timeStr;
}

function isInt(n){
    return Number(n) % 1 === 0;
}

function isFloat(n){
    return Number(n) % 1 !== 0;
}
var hasOwnProperty = Object.prototype.hasOwnProperty;

function isEmpty(obj) {
    if (obj == null) return true;
    if (obj.length > 0)    return false;
    if (obj.length === 0)  return true;
    if (typeof obj !== "object") return true;
    for (var key in obj) {
        if (hasOwnProperty.call(obj, key)) return false;
    }
    return true;
}
// check if input is black 
function isInputEmpty(obj) {
	if (obj.length == undefined) {
		for (var p in obj) {
			if (obj[p].nodeName == "INPUT") {
				if (obj[p].value == "") {
					return false;
				}
			}
		}
	} else {
		for (var i = 0; i < obj.length; i++) {
			if (obj[i].nodeName == "INPUT") {
				if (obj[i].value == "") {
					return false;
				}
			}
		}
	}
	return true;
}
function add_IDPrefix(id_n,n) {
	var str = id_n;
	n = "" + n;
	switch(n.length) {
		case 3:
			str += "0" + n;
			break;
		case 2:
			str += "00" + n;
			break;
		case 1:
			str += "000" + n;
			break;
		default:
			str += "" + n;
	}
	return str;
}
function ajax_request(url,dt,callback) {
	$.ajax({
		url: url,
		data: dt,
		success: function(data) {
			if (callback != null) {
				callback(data);
			}
		},
	});
}
function sql_date_converter(date_str) {
	date_str = new Date(date_str);
	var str_r = "";
	var date = {
		sec: date_str.getSeconds(),
		min: date_str.getMinutes(),
		hour: date_str.getHours(),
		day: date_str.getDate(),
		month: date_str.getMonth() + 1,
		year: date_str.getFullYear()
	}
	for (var p in date) {
		date[p] = prefix_zero(date[p]);
	}
	str_r = date.hour + ":" + date.min + ":" + date.sec + " "
			+ date.day + "-" + date.month + "-" + date.year;
	return str_r;
}
function prefix_zero(number) {
	var n = number.toString();
	if (n.length < 2) {
		return "0" + n;
	}
	return n;
}
function keys_discrepancy(k) {
	var special_keys = [19,145,144,45,33,34,35,36,27];
	var range_F1_15 = k >= 112 && k <= 126;
	if (special_keys.indexOf(k) != -1 || range_F1_15) {
		return true;
	}
	return false;
}
function show_keysVal(k) {
	var spec_keys = '[["Backspace","8"],["Tab","9"],["Enter","13"],["Shift","16"],["Ctrl","17"],["Caps","20"],["Esc","27"],["Spacebar","32"],["PageUp","33"],["PageDown","34"],["End","35"],["Home","36"],["LeftArrow","37"],["UpArrow","38"],["RightArrow","39"],["DownArrow","40"],["Insert","45"],["Delete","46"],["NumLock","144"],["ScrLk","145"],["Pause/Break","19"],[";","186"],["=","187"],["-","189"],["/","191"],["`","192"],["[","219"],["\","220"],["]","221"],["\'","222"],[",","188"],[".","190"],["/","191"],["Alt","18"]]';
	spec_keys = JSON.parse(spec_keys);
	spec_keys[27][0] = "\\";
	var key = [];
	var char = [];
	for (var i = 0; i < spec_keys.length; i++) {
		char[i] = spec_keys[i][0];
		key[i] = parseInt(spec_keys[i][1]);
	}
	if ((k >= 65 && k <= 90) ||
		(k >= 48 && k <= 57)) {
		return String.fromCharCode(k);
	} else {
		 if (key.indexOf(k) != -1) {
		 	return char[key.indexOf(k)];
		 }
	}
}
// length of object
function obj_length(d) {
	if (typeof d == "object") return Object.keys(d).length;
}
// return array with no unique data
function array_unique(arr) {
	var rsl = [];
	for (var i = 0; i < arr.length; i++) {
		if (rsl.indexOf(arr[i]) == -1) rsl.push(arr[i]);
	}
	return rsl;
}
// get max in object 
function max_item(a) {
	var b = [Object.keys(a)][0];
	var m = 0;
	for (var i = 0; i < b.length; i++) {
		if (a[b[i]] > a[b[m]]) m = i;
	}
	return b[m];
}
function max_item2(a) {
	var c = [];
	for (var i in a) c.push(max_item(a[i]));
	return c;
}
function max_item_val(a) {
	var b = [Object.keys(a)][0];
	var m = 0;
	for (var i = 0; i < b.length; i++) {
		if (a[b[i]] > m) m = a[b[i]];
	}
	return m;
}
function max_item2_val(a) {
	var c = [];
	for (var i in a) c.push(max_item_val(a[i]));
	return c;
}
function max_iA(a) {
	var m = 0;
	for (var i = 0; i < a.length; i++) {
		if (a[i] > a[m]) m = i;
	}
	return m;
}
function min_item(a) {
	var b = [Object.keys(a)][0];
	var m = 0;
	for (var i = 0; i < b.length; i++) {
		if (a[b[i]] < a[b[m]]) m = i;
	}
	return b[m];
}
function min_item_val(a) {
	var b = [Object.keys(a)][0];
	var m = a[b[0]];
	for (var i = 0; i < b.length; i++) {
		if (a[b[i]] < m) m = a[b[i]];
	}
	return m;
}