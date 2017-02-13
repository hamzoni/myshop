var newPrd_form = window.upload_newProduct;
var p_n_f = newPrd_form.p_name;
var p_dp_f = newPrd_form.p_display;
var p_sale = newPrd_form.p_sale;
var p_price = newPrd_form.p_price;
var p_type = newPrd_form.p_type;
var p_dscr = newPrd_form.f_dscrp;
var previous_pData = newPrd_form.previous_pData;
var tbl_sDt = new set_preset();
p_price.onkeypress = function(e) {
	return event.charCode >= 48 && event.charCode <= 57;
}
p_sale.onkeypress = function(e) {
	return event.charCode >= 48 && event.charCode <= 57;
}
p_sale.onkeyup = function() {
	if (this.value > 0) {
		p_type[0].checked = true;
	}
}
var p_display = false; // true = eye-slash, false = eye
$("#dplbtn_c").click(function(e){
	e.preventDefault();
	icon = this.firstElementChild;
	if (p_display) {
		icon.className = "fa fa-eye-slash";
		this.className = "dpl_g2";
		this.title = "show product?";
		p_dp_f.value = "0";
		p_display = false;
	} else {
		icon.className = "fa fa-eye";
		this.className = "dpl_g";
		this.title = "hide product?"
		p_dp_f.value = "1";
		p_display = true;
	}
	return false;
});
$(".fileUpl_btn").click(function(e){
	e.preventDefault();
	return false;
});
var cvs; // set canvas target for previewing
var ctx; // set canvas context for previewing
var cvs_nutr = document.getElementById("prv_nutrition");
var cvs_avat = document.getElementById("prv_avatar");
var ctx_nutr = cvs_nutr.getContext('2d');
var ctx_avat = cvs_avat.getContext('2d');

$("#f_upl_ava").click(function(){
	cvs = cvs_avat;
	ctx = ctx_avat;
	newPrd_form.p_avatar.click();
});
$("#f_upl_nutri").click(function(){
	cvs = cvs_nutr;	
	ctx = ctx_nutr;
	newPrd_form.p_nutrition.click();
});
newPrd_form.p_avatar.onchange = handleImage;
newPrd_form.p_nutrition.onchange = handleImage;

// set radio: click label enable check
$("label[for='p_type']").click(function(){
	var idtt = this.getAttribute("gr");
	$("input[gr=" + idtt + "]").prop('checked', true);
	if (idtt != 1) {
		p_sale.value = "";
	}
});
// final check when submit form
document.getElementById("sbmitBt_kl").onclick = function() {
	// check if type=sale && sale% > 0
	if (p_type.value == "2" && p_sale <= 0) {
		alert("Invalid input sale");
		return false;
	}
}
$(".close_btn").click(function(){
	$(".boundingLayer").css({
		"display":"none"
	});
	reset_form();
});
// identify target, whether it's Edit form (1) or Add form (0)
var f_trg = 0;
$("#add_prf").click(function(){
	f_trg = 0;
	document.getElementById("dscr_bxTb").innerHTML = "new product";
	$(".boundingLayer").css({
		"display":"block"
	});
	var f_action_val = document.getElementsByClassName("boundingLayer")[0].firstElementChild;
	f_action_val = f_action_val.getElementsByTagName("form")[0].setAttribute("action",tbl_sDt.base_url + "/add_product");
});
function reset_form() {
	// reset form
	newPrd_form.reset();
	p_dp_f.value = "0";
	p_display = true;
	$("#dplbtn_c").click();
	p_type[2].checked = true;
	// reset canvas
	ctx_nutr.clearRect(0, 0, cvs_nutr.width, cvs_nutr.height);
	ctx_avat.clearRect(0, 0, cvs_avat.width, cvs_avat.height);
}
var dp_prdTble = document.getElementById("dp_prdTble");
var tr_dpt_h = dp_prdTble.getElementsByTagName("tr")[0];
tr_dpt_h = tr_dpt_h.offsetHeight;
var tbl_wpScrll = document.getElementById("tbl_wpScrll");
var tbl_wpPadding = {
	top: parseFloat(window.getComputedStyle(tbl_wpScrll)["padding-top"]),
	bottom: parseFloat(window.getComputedStyle(tbl_wpScrll)["padding-bottom"])
}
var new_tblwp_width = tbl_wpPadding.top + tbl_wpPadding.bottom + tr_dpt_h*10; // 10 records stack
tbl_wpScrll.style.height = new_tblwp_width + "px";
var pauseScroll = false;
var ajax_processor_url;
var crr_records_view = document.getElementsByClassName("prd_infoCtner").length;
tbl_wpScrll.onscroll = function(e) {
	if (this.scrollTop >= (dp_prdTble.offsetHeight - tbl_wpScrll.offsetHeight)
		&& !pauseScroll) {
		pauseScroll = true;
		if (crr_records_view < tbl_sDt.ttr) {
			ajax_processor_url = tbl_sDt.base_url;
			if (ajax_processor_url.search(/\/$/g) == -1) {
				ajax_processor_url += "/";
			}
			if (tbl_sDt.ttr == 0) { // no data in db
				return;
			}
			if (tbl_sDt.ofs > tbl_sDt.ttr) { // offset data in db
				return;
			}
			ajax_processor_url += "adding_dataTbl/";
			var r = {
				offset: tbl_sDt.ofs,
				start_id: tbl_sDt.start_id
			}
			r = "r=" + JSON.stringify(r);
			ajax_request(ajax_processor_url,r,function(d){
				pauseScroll = false;
				d = JSON.parse(d);
				update_prdTable(d);
			});
			tbl_sDt.ofs += tbl_sDt.lmt;
			crr_records_view = document.getElementsByClassName("prd_infoCtner").length;
		}
	}
}
function update_prdTable(dtdc) {
	var tbb = dp_prdTble.firstElementChild;
	var vfn = ['id','name','price','sale','purchase_count','display','type'];

	for (var i = 0; i < dtdc[1].length; i++) { // tr
		var tr_ptbl = document.createElement("tr");
		var chkbx = tbb.lastElementChild.firstElementChild.cloneNode(true);
		var chkbx_f = chkbx.getElementsByTagName("form")[0];
		var n = 0;
		for (var fn1 in dtdc[0][i]) { // form
			chkbx_f.elements[n].value = dtdc[0][i][fn1];
			n++;
		}
		chkbx_f.setAttribute("prd_id",dtdc[0][i]['id']);
		tr_ptbl.appendChild(chkbx);
		for (var j = 0; j < vfn.length; j++) {
			if (vfn[j] == 'display') {
				var dplbx = tbb.lastElementChild.getElementsByTagName("td")[6].cloneNode(true);
				dplbx.firstElementChild.className = "fa fa-circle" + dtdc[1][i][vfn[j]];
				tr_ptbl.appendChild(dplbx);
			} else {
				var td_ptbl = document.createElement("td");
				if (vfn[j] == 'name') {
					td_ptbl.onclick = function() {
						preview_product(this);
					}
					preview_product.className = "slt_hker";
				}
				td_ptbl.innerHTML = dtdc[1][i][vfn[j]];
				tr_ptbl.appendChild(td_ptbl);
			}
		}
		var edtbx = tbb.lastElementChild.lastElementChild.cloneNode(true);
		edtbx.firstElementChild.addEventListener('click',function(){
			editPrd_f(this);	
		})
		tr_ptbl.appendChild(edtbx)
		tbb.appendChild(tr_ptbl);
	}
}
// display or hide items
var ajax_processor_url; // reuse variable
$(".inwbtp").click(function(){
	var dp_v = parseInt(this.getAttribute("dp-type"));
	var nwCln = dp_v == 0 ? "fa fa-circle-thin": "fa fa-circle";
	var slc_ckb = get_allCheckedCkb("slct_r");
	if (slc_ckb.length <= 0) { // cancel if no checkbox is checked
		return;
	}
	// get all ID of slc_ckb
	var id_arC = [], val_arC = [], vbk= {dom:[],f_val:[]};
	for (var i = 0; i < slc_ckb.length; i++) {
		var slt_f = slc_ckb[i].parentNode.getElementsByTagName("form")[0];
		if (slt_f.prd_display.value != dp_v) {
			id_arC.push(parseInt(slt_f.prd_id.value));
			val_arC.push(dp_v);
			vbk.dom.push(slc_ckb[i]);
			vbk.f_val.push(slt_f.prd_display);
		}
	}
	if (id_arC.length <= 0) { // cancel if repetition in value found
		return;
	}
	id_arC = "UpdateDisplay=" + JSON.stringify({prdId:id_arC,prdnVal:val_arC});
	// send data to server using ajax
	ajax_processor_url = tbl_sDt.base_url + '/upd_prdDpl';
	$.post(ajax_processor_url,id_arC,function(data,status){
		if (data && parseInt(data) == 1) {
			for (var i = 0; i < vbk.dom.length; i++) {
				vbk.f_val[i].value = dp_v;
				vbk.dom[i].parentNode.parentNode.getElementsByTagName("td")[6].firstElementChild.className = nwCln;
			}
		}
	});
	for (var i = 0; i < slc_ckb.length; i++) {
		slc_ckb[i].checked = false;
	}
});

// select product to view detail
// default selected product: #1 <tr>
var tblb = dp_prdTble.firstElementChild;
var allTr = tblb.getElementsByTagName("tr");
var fldtc = {
	name: document.getElementById("og_nm"), // InnerHTML
	sale: document.getElementById("og_sl"), // InnerHTML
	prc: document.getElementById("og_prc"), // InnerHTML
	dscr: document.getElementById("og_dsc"), // InnerHTML
	a_img: document.getElementById("og_ava"), // Src
	n_img: document.getElementById("og_ntr") // Src
};
allTr[1].className = "selected_product";
$(".slt_hker").click(function(){
	preview_product(this);
});
function preview_product(d) {
	for (var i = 0; i < allTr.length; i++) {
		allTr[i].classList.remove("selected_product");
	}
	d.parentNode.classList.add("selected_product");
	// get data presetting from form
	var ctf = d.parentNode.getElementsByClassName("prd_infoCtner")[0];
	fldtc.name.innerHTML = ctf.prd_name.value;
	fldtc.sale.innerHTML = "(-" + ctf.prd_sale.value*100 + "%)";
	fldtc.prc.innerHTML = ctf.prd_price.value;
	fldtc.dscr.innerHTML = ctf.prd_description.value;
	fldtc.a_img.src = ctf.prd_avatar_img.value;
	fldtc.n_img.src = ctf.prd_nutrition_img.value;
}
// remove from database::
document.getElementById("rm_item").onclick = function() {
	var slc_ckb = get_allCheckedCkb("slct_r");
	if (slc_ckb.length <= 0) { // cancel if no checkbox is checked
		return;
	}
	// ask user if surely want to delete record(s)
	if (!confirm("This action is irreversible, are you sure to continue?")) {
		return;
	}
	// get all ID of slc_ckb
	var id_arC = [],pImg_ctner = [[],[]], tr_ctner = [];
	for (var i = 0; i < slc_ckb.length; i++) {
		tr_ctner.push(slc_ckb[i].parentNode);
		var slt_f = tr_ctner[i].getElementsByTagName("form")[0];
		pImg_ctner[0].push(slt_f.prd_avatar_img.value);
		pImg_ctner[1].push(slt_f.prd_nutrition_img.value);

		id_arC.push(parseInt(slt_f.prd_id.value));
	}
	if (id_arC.length <= 0) { // cancel if repetition in value found
		return;
	}
	id_arC = "DeleteRecords=" + JSON.stringify({prdId:id_arC,prdImg:pImg_ctner});
	// send data to server using ajax
	ajax_processor_url = tbl_sDt.base_url + '/del_prdRcrd';
	$.post(ajax_processor_url,id_arC,function(data,status){
		console.log(data);
		if (data && parseInt(data) == 1) {
			for (var i = 0; i < tr_ctner.length; i++) {
				tr_ctner[0].parentNode.remove(tr_ctner[0]);
			}
			alert("Delete successfully")
		}
	});
	for (var i = 0; i < slc_ckb.length; i++) {
		slc_ckb[i].checked = false;
	}
}
// update button
var prnt_dt;
$(".edit_prdOl").click(function(){
	editPrd_f(this);
});
function editPrd_f(elm) {
	f_trg = 1;
	document.getElementById("dscr_bxTb").innerHTML = "edit product";
	$(".boundingLayer").css({
		"display":"block"
	});
	prnt_dt = elm.parentNode.parentNode.firstElementChild.getElementsByTagName("form")[0];
	// change form handler
	var f_action_val = document.getElementsByClassName("boundingLayer")[0].firstElementChild;
	f_action_val = f_action_val.getElementsByTagName("form")[0].removeAttribute("action");
	// get present value
	prnt_dt = {
		id: prnt_dt.prd_id.value,
		name: prnt_dt.prd_name.value,
		price: prnt_dt.prd_price.value,
		sale: prnt_dt.prd_sale.value,
		ava: prnt_dt.prd_avatar_img.value,
		ntr: prnt_dt.prd_nutrition_img.value,
		type: prnt_dt.prd_type.value,
		dpl: prnt_dt.prd_display.value,
		dscr: prnt_dt.prd_description.value
	}
	// fill present value in edit data in form
	p_n_f.value = prnt_dt.name;
	p_dp_f.value = prnt_dt.dpl;
	p_dp_f.value == 1 ? $("#dplbtn_c").click() : null;
	p_sale.value = parseInt(parseFloat(prnt_dt.sale)*100);
	p_price.value = prnt_dt.price;
	p_type.value = prnt_dt.type;
	p_dscr.value = prnt_dt.dscr;
	// draw present images
	cvs = cvs_avat;
	ctx = ctx_avat;
	readImage(prnt_dt.ava);
	setTimeout(function(){
		cvs = cvs_nutr;
		ctx = ctx_nutr;
		readImage(prnt_dt.ntr);
	},100);
}
// send ajax to server once submit update btn
var prg_tracker = {
	bar: document.getElementById("upl_progBar"),
	layer: document.getElementById("prg_layer"),
	status: document.getElementById("upload_status"),
	status_d: ["Upload in process...","Upload successful"]
}
$("#sbmitBt_kl").click(function(e){
	if (f_trg == 1) {
		e.preventDefault();
		ajax_processor_url = tbl_sDt.base_url + '/upd_prdc';
		
		var img_processor = {
			ava:null,ntr:null
		};
		for (var prop in prnt_dt) {
			if (prop != 'ava' && prop != 'ntr') {
				img_processor[prop] = prnt_dt[prop];
			}
		}
		//check if image is available & set previous link of img for deletion
		p_avaImg.value !== "" ? img_processor.ava = prnt_dt.ava : 0;
		p_nutriImg.value !== "" ? img_processor.ntr = prnt_dt.ntr : 0;
		if (parseInt(p_sale.value) > 99) {
			p_sale.value = 0;
		}
		if (parseInt(p_sale.value) > 0 && parseInt(p_sale.value) < 100) {
			p_sale.value = (Math.round(p_sale.value * 100)/100)/100;
		}
		img_processor = JSON.stringify(img_processor);
		// send data to server using ajax
		previous_pData.value = img_processor;
		// display upload progress tracker
		prg_tracker.layer.style.display = "block";
		$.ajax({
			url: ajax_processor_url,  //Server script to process data
			type: 'POST',
			xhr: function() {  // Custom XMLHttpRequest
			    var myXhr = $.ajaxSettings.xhr();
			    if(myXhr.upload){ // Check if upload property exists
			        myXhr.upload.addEventListener('progress',progressHandlingFunction, false);
			    }
			    return myXhr;
			},
			beforeSend: null,
			success: function(data){
				data = JSON.parse(data);
				var data0 = data[1][0];
				data = data[0];
				var updPrd_Inf = document.querySelectorAll("[prd_id='" + data.id + "']")[0];
				var tr_updp = updPrd_Inf.parentNode.parentNode;
				
				// update data in hidden form
				updPrd_Inf.prd_name = data.p_name;updPrd_Inf.prd_type = data.p_type;
				updPrd_Inf.prd_price = data.p_price;updPrd_Inf.prd_display = data.p_display;
				updPrd_Inf.prd_sale = data.p_sale;updPrd_Inf.prd_description = data.f_dscrp;
				updPrd_Inf.prd_avatar_img = data.ava;updPrd_Inf.prd_last_update = data.last_upd;
				updPrd_Inf.prd_nutrition_img = data.ntr;
				// update data in product rows
				tr_updp.children[2].innerHTML = updPrd_Inf.prd_name.value;
				tr_updp.children[3].innerHTML = updPrd_Inf.prd_price.value;
				tr_updp.children[4].innerHTML = data0.sale;
				tr_updp.children[6].children[0].className = "fa fa-circle" + data0.display;
				tr_updp.children[7].innerHTML = data0.type;
			},
			error: function(){
				alert("Unknown error occur!")
			},
			data: new FormData($("#addPr_f")[0]),
			cache: false,
			contentType: false,
			processData: false
		});
		return false;
	}
});

function progressHandlingFunction(e){
    if(e.lengthComputable){
        $('#upl_progBar').attr({value:e.loaded,max:e.total});
        if (e.loaded == e.total) {
        	prg_tracker.status.innerHTML = prg_tracker.status_d[1];
        	setTimeout(function(){
        		// close update box
        		$(".close_btn").click();
        		// hide progress tracker layer 
        		prg_tracker.layer.style.display = "none";
        		// reset tracker status to default
        		prg_tracker.status.innerHTML = prg_tracker.status_d[0];
        	},1000);
        }
    }
}
add_price_sale();
function add_price_sale() {
	var td, td_o, df;
	var tr = dp_prdTble.getElementsByTagName("tr");
	for (var i = 1, j = 0; i < tr.length; i++, j++) {
		df = tr[i].getElementsByClassName("prd_infoCtner")[0];
		df = parseFloat(df.querySelector("[name=prd_sale]").value);
		td = tr[i].getElementsByTagName("td")[3];
		td_o = parseInt(td.textContent);
		td.innerHTML = "";
		td.innerHTML = addComma(td_o) + " / " + addComma(td_o * (1 - df));
	}
}