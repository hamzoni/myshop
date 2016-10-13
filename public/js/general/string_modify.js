function addComma(a) {
	a = a.toString();
	var n = "" , j = 0;
	for (var i = a.length - 1; i >= 0; i--) {
		n += i % 3 == 0 && i != 0 ? + a[j] + "," : a[j];
		j++;
	}
	return n;
}
function addComma2(a) {
	var n = "";
	for (var i = Math.floor(Math.sqrt(a.length,2)) - 1; i >= 0; i++) {
		n += n[i*3 + 3] + ",";
	}
	return n;
}