var newPrd_form = window.upload_newProduct;
var p_dp_f = newPrd_form.p_display;
var p_sale = newPrd_form.p_sale;
var p_price = newPrd_form.p_price;
var p_type = newPrd_form.p_type;

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
var p_display = false;
$("#dplbtn_c").click(function(e){
	e.preventDefault();
	icon = this.firstElementChild;
	if (p_display) {
		icon.className = "fa fa-eye-slash";
		this.className = "dpl_g2";
		this.title = "show product?"
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