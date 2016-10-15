set_evtOlbt();
if (is_pkgD) {
	return_pageOL();
}
$("[package-id]").click(function(){
	$(".orderList_wrapper").css({
		"display" : "none"
	});
	$(".orderDetail_wrapper").css({
		"display" : "block"
	});
	hdl = this.querySelectorAll("[order-id]")[0].innerHTML;
	$(".fxRtlc").html(
		"<a id=\"ol_bt\">Order list</a> > <a>Order detail</a>"
		+ ": " + hdl
	);
	var new_url = base_url + "/package/" + hdl;
	window.history.pushState("", "", new_url);
	set_evtOlbt();
});
function set_evtOlbt() {
	$("#ol_bt").click(function(){
		return_pageOL();
	});
}
$(".return_ppage").click(function(){
	return_pageOL();
});
function return_pageOL() {
	$(".orderList_wrapper").css({
		"display" : "block"
	});
	$(".orderDetail_wrapper").css({
		"display" : "none"
	});
	$(".fxRtlc").html(
		"<a id=\"ol_bt\">Order list</a>"
	);
	window.history.pushState("", "", base_url);
}
window.onhashchange = function() {
	return_pageOL();
}
window.addEventListener('popstate', function(event) {
	return_pageOL();
}, false);