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
function addChar(a,c) {
	if (a == undefined || a == null) return;
	a = a.toString();
	var n = "" , j = 0;
	for (var i = a.length - 1; i >= 0; i--) {
		n += i % 3 == 0 && i != 0 ? + a[j] + c : a[j];
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
function attr_slc_d(d,a) {
	var r = [];
	var m = d.getElementsByTagName('*');
	for (var i = 0; i < m.length; i++) {
		if (typeof a == 'string') {
			if (m[i].hasAttribute(a)) r.push(m[i]);
		} else {
			if (m[i].getAttribute(a[0]) == a[1]) r.push(m[i]);
		}
	}
	return r;
}
function remove_all_attr(x) {
	a = $('[' + x + ']');
	if (a.length == 0) return;
	for (var i = 0; i < a.length; i++) a[i].removeAttribute(x);
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
	var trf = e.target.files[0];
	reader.readAsDataURL(trf);
	return trf;
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
function readImage_c(x, imgSrc) {
	var img = new Image();
	var y = x.getContext('2d');
	img.onload = function() {
		x.width = img.width;
		x.height = img.height;
		y.drawImage(img,0,0);
		// resize canvas to fit outer layer
		x.style.width = "100%";
		x.style.height = "100%";
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
	var date = new Date();
	if (typeof ms != 'object') date = new Date(ms);
	var d_obj = {
		date:date.getDate(),
		month:date.getMonth() + 1,
		year:date.getFullYear(),
		hour:date.getHours(),
		minute: date.getMinutes(),
		seconds: date.getSeconds()
	}
	for (var p in d_obj) {
		d_obj[p] = prefix_zero(d_obj[p]);
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
// get parentNode by class
function get_parent_cn(d, cn) {
	var docE_c = document.querySelectorAll("*").length;
	var p, c = 0;
	p = d.parentNode;
	return p;
	do {
		if (p.className == cn) break;
		p = p.parentNode;
		c++;
	} while (c < docE_c);
}
function findAncestor (el, cls) {
    while ((el = el.parentElement) && !el.classList.contains(cls));
    return el;
}

function get_ridExtra() {
	$( document ).ready(function() {
	    var abc = document.body.innerHTML;
	    var a = String(abc).replace(/\u200B/g,'');
	    document.body.innerHTML = a;
	});
}
// compare object
Object.cpare = function( x, y ) {
  if ( x === y ) return true;
  if ( ! ( x instanceof Object ) || ! ( y instanceof Object ) ) return false;
  if ( x.constructor !== y.constructor ) return false;
  for ( var p in x ) {
    if ( ! x.hasOwnProperty( p ) ) continue;
    if ( ! y.hasOwnProperty( p ) ) return false;
    if ( x[ p ] === y[ p ] ) continue;
    if ( typeof( x[ p ] ) !== "object" ) return false;
    if ( ! Object.cpare( x[ p ],  y[ p ] ) ) return false;
  }
  for ( p in y ) {
    if ( y.hasOwnProperty( p ) && ! x.hasOwnProperty( p ) ) return false;
  }
  return true;
}
// get offset position
function getOffsetLeft( elem ) {
    var offsetLeft = 0;
	do {
		if ( !isNaN( elem.offsetLeft )) offsetLeft += elem.offsetLeft;
	} while(elem = elem.offsetParent);
	return offsetLeft;
}
function getOffsetTop( elem ) {
    var offsetTop = 0;
	do {
		if ( !isNaN( elem.offsetTop )) offsetTop += elem.offsetTop;
	} while(elem = elem.offsetParent);
	return offsetTop;
}
// select text
function SelectText(element) {
    var doc = document
        , text = $(element)[0]
        , range, selection
    ;    
    if (doc.body.createTextRange) {
        range = document.body.createTextRange();
        range.moveToElementText(text);
        range.select();
    } else if (window.getSelection) {
        selection = window.getSelection();        
        range = document.createRange();
        range.selectNodeContents(text);
        selection.removeAllRanges();
        selection.addRange(range);
    }
}
// check if input text is selected
function isTextSelected(input) {
    if (typeof input.selectionStart == "number") {
        return input.selectionStart == 0 && input.selectionEnd == input.value.length;
    } else if (typeof document.selection != "undefined") {
        input.focus();
        return document.selection.createRange().text == input.value;
    }
}
// split time to array
function get_date_split(date,prefix = false) {
	var date = {
		y: date.getFullYear(),
		m: date.getMonth(),
		d: date.getDate(),
	}
	if (prefix) {
		date.m = prefix_zero(date.m + 1);
		date.d = prefix_zero(date.d);
	}
	return date;
}
function get_time_split(time,prefix = false) {
	var time = {
		h: time.getHours(),
		m: time.getMinutes(),
		s: time.getSeconds(),
	}
	if (prefix) {
		for (var p in time) time[p] = prefix_zero(time[p]);
	}
	return time;
}
function month_convert(dt) {
	var dM = dt / (30.4375 * 24 * 60 * 60);
	return Math.round(dM);
}
function diff_minute(dt) {
	var dM = Math.round(dt / 60);
	return dM;
}
function diff_hour(dt) {
	var dH = Math.round(dt / 3600);
	return dH;
}
function diff_day(dt) {
	var dD = Math.round(dt / 86400);
	return dD;
}
function diff_month(d1,d2) {
	var months;
	months = (d2.getFullYear() - d1.getFullYear()) * 12;
	months -= d1.getMonth() + 1;
	months += d2.getMonth();
	return months <= 0 ? 0 : months;
}
function diff_year(d1,d2) {
	y2 = d2.getFullYear();
	m2 = d2.getMonth();
	d2 = d2.getDate();
	var age = y2 - d1.getFullYear(); 
	if (m2 < d1.getMonth() - 1) age--;
	if (d1.getMonth() - 1 == m2 && d2 < d1.getDate()) age--;
	return age;
}
// concatenate object
function concate_obj() {
	var ret = {};
	var len = arguments.length;
	for (var i=0; i<len; i++) {
		for (p in arguments[i]) {
			if (arguments[i].hasOwnProperty(p)) ret[p] = arguments[i][p];
		}
	}
	return ret;
}
// check valid date
function invalid_date(d) {
	if ( Object.prototype.toString.call(d) === "[object Date]" ) {
		return isNaN(d.getTime());
	}
	return true;
}
// toggle display
function knob_dpl(d,c = null,r = false) {
	if (d.hasAttribute('hide')) {
		d.removeAttribute('hide');
		if (null !== c) {
			if (r) $("." + c).removeClass(c);
			d.classList.add(c); 
		}
	} else {
		d.setAttribute('hide','');
		if (null !== c) d.classList.remove(c);
	}
}
function hasClass(element, cls) {
    return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
}
// download file
function download(filename, text) {
	var element = document.createElement('a');
	element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
	element.setAttribute('download', filename);

	element.style.display = 'none';
	document.body.appendChild(element);

	element.click();

	document.body.removeChild(element);
}