var stat_date = {};
var chart_cvs = {VIEWS: {}, TRANSACTIONS: {}, ACCOUNTS: {}, INCOMES: {}};
var G = {
    VIEWS: {D:"page_view_CC",T: "VISITS",C: "line"},
    TRANSACTIONS: {D: "transaction_CC",T: "PURCHASES",C: "column"},
    ACCOUNTS: {D: "account_CC",T: "CUSTOMERS",C: "column"},
    INCOMES: {D: "income_CC",T: "REVENUE",C: "line"}
}
split_data();
function split_data() {
    var stat_dt = new set_preset().base_stats;
        stat_dt = JSON.parse(stat_dt);
    var st_DFn = {};
    var stat_detail = {};

    for (var i in stat_dt.DETAIL) {
        st_DFn[i] = [];
        for (var j in stat_dt.DETAIL[i]) {
            st_DFn[i].push(j);
        }
        st_DFn[i].sort();
        stat_detail[i] = {};
    }
    // sort time;
    for (var i in st_DFn) {
        for (var j = 0; j < st_DFn[i].length; j++) {
            stat_detail[i][st_DFn[i][j]] = stat_dt.DETAIL[i][st_DFn[i][j]];
        }
    }
    // sort in to year
    for (var i in stat_detail) {
        stat_date[i] = {};
        var c = 0;
        for (var j in stat_detail[i]) {
            var date = new Date(j * 1000);    
            var year = date.getFullYear();
            var month = date.getMonth();
            var day = date.getDate();
            if (undefined == stat_date[i][year]) stat_date[i][year] = {};
            if (undefined == stat_date[i][year][month]) stat_date[i][year][month] = {};
            stat_date[i][year][month][day] = stat_detail[i][j];
        }
    }
    // sum of month and year
    for (var t in stat_date) {
        chart_cvs[t].AGG = {_A:0, _Y: {}, _M: {}};
        chart_cvs[t].AVG = {_A:0,_Y:{},_M:{}};
        for (var y in stat_date[t]) {
            chart_cvs[t].AGG._M[y] = {};
            chart_cvs[t].AVG._M[y] = {};
            for (var m in stat_date[t][y]) {
                chart_cvs[t].AGG._M[y][m] = get_sum(stat_date[t][y][m]);
                chart_cvs[t].AVG._M[y][m] = Math.round(get_sum(stat_date[t][y][m]) / obj_length(stat_date[t][y][m]));
            }
            chart_cvs[t].AGG._Y[y] = get_sum(chart_cvs[t].AGG._M[y]);
            chart_cvs[t].AVG._Y[y] = Math.round(chart_cvs[t].AGG._Y[y] / obj_length(chart_cvs[t].AGG._M[y]));
        }
        chart_cvs[t].AGG._A = get_sum(chart_cvs.VIEWS.AGG._Y);
        chart_cvs[t].AVG._A = Math.round(chart_cvs[t].AGG._A / obj_length(chart_cvs.VIEWS.AGG._Y));
    }
}


function create_chart(graph, type, container, title, data, ySf) {
    graph.chart = new CanvasJS.Chart(container, {
    title: {
        text: title
    },
    zoomEnabled: true,
    axisY: {
        suffix: ySf ? ySf : "", 
        gridDashType: "",
        gridThickness: 1,
        labelFormatter: function (e) {
            var p = 1;
            if (ySf == "B") p = Math.pow(10,9);
            if (ySf == "M") p = Math.pow(10,6);
            if (ySf == "K") p = Math.pow(10,3); 
            return Math.round(e.value / p);
        },
    },
    axisX : {
        gridDashType: "",
        gridThickness: 1 
    },
    data: [{
            type: type,
            dataPoints: data,
          }]
    });
    graph.chart.render();
}
function create_data(x,y,z) {
    return {x: x, y: y, label: z ? z : ""};
}
function get_sum(obj) {
    var val = 0;
    for (var p in obj) val += obj[p];
    return val;
}
function get_suffix(n) {
    var min = n;
    if (typeof n == "object") {
         min = n[Object.keys(n)[0]];
        for (var p in n) {
            if (n[p] < min) min = n[p];
        }
    }
    if (min >= Math.pow(10,9)) return "B";
    if (min >= Math.pow(10,6)) return "M";
    if (min >= Math.pow(10,3)) return "K";   
}
$("input[name=sum_month]").click(function(){
    var F = $(this).closest('form')[0];
    var T = F.getAttribute("d_type");
    var V = {
        M: F._chooseMonth.value,
        Y: F._chooseYear.value
    }
    var TT = " OF MONTH";
    var D = [], c = 0;
    try { var S = stat_date[T][V.Y][V.M - 1]; } catch (err) {};
    if (!S) return;
    for (var p in S) {
        var z = p + "/" + V.M + "/" + V.Y;
        D[c] = new create_data(c, S[p], z);
        c++;
    }
    create_chart(chart_cvs[T], G[T].C, G[T].D, G[T].T + TT, D, get_suffix(S));
});
var MRC = ["JAN","FEB","MAR","APR","MAY","JUNE","JULY","AUG","SEP","OCT","NOV","DEC"];
$("input[name=sum_year]").click(function(){
    var F = $(this).closest('form')[0];
    var T = F.getAttribute("d_type");
    var Y = F._chooseYear.value;
    var TT = " OF YEAR";
    var D = [], DX = [], c = 0;
    try { var S = stat_date[T][Y]; } catch (err) {};
    if (!S) return;
    for (var p in S) {
        var z = MRC[p] + " " + Y;
        DX.push(get_sum(S[p]));
        D[c] = new create_data(c, DX[DX.length - 1], z);
        c++;
    }
    create_chart(chart_cvs[T], G[T].C, G[T].D, G[T].T + TT, D, get_suffix(Math.min.apply(null, DX)));
});
$("input[name=sum_overall]").click(function(){
    var F = $(this).closest('form')[0];
    var T = F.getAttribute("d_type");
    var TT = " OVERALL";
    try { var S = stat_date[T]; } catch (err) {};
    if (!S) return;
    var D = [], YD = {}, c = 0;
    for (var p in S) {
        YD[p] = {};
        for (var k in S[p]) YD[p][k] = get_sum(S[p][k]);
        YD[p] = get_sum(YD[p]);
        D[c] = new create_data(c, YD[p], p);
        c++;
    }
    create_chart(chart_cvs[T], G[T].C, G[T].D, G[T].T + TT, D, get_suffix(YD));
});

$("input[name=avg_overall]").click(function(){
   var F = $(this).closest('form')[0];
   var T = F.getAttribute("d_type");
   var TT = " OVERALL AVERAGE";
    try { var S = chart_cvs[T].AVG._Y; } catch (err) {};
    if (!S) return;
    var D = [], c = 0;
    for (var p in S) {
        D[c] = new create_data(c, S[p], p);
        c++;
    }
    create_chart(chart_cvs[T], G[T].C, G[T].D, G[T].T + TT, D, get_suffix(S));
});
$("input[name=avg_year]").click(function(){
   var F = $(this).closest('form')[0];
   var T = F.getAttribute("d_type");
   var Y = F._chooseYear.value;
   var TT = " AVERAGE OF YEAR " + Y;
    try { var S = chart_cvs[T].AVG._M[Y]; } catch (err) {};
    if (!S) return;
    var D = [], c = 0;
    for (var p in S) {
        var z = MRC[p] + " " + Y;
        D[c] = new create_data(c, S[p], z);
        c++;
    }
    create_chart(chart_cvs[T], G[T].C, G[T].D, G[T].T + TT, D, get_suffix(S));
});
window.onload = function() {
    // create summary div clone
    var cDl = document.getElementsByClassName("summary_field");
    var cDl_m = cDl[0];
    for (var i = 1; i < cDl.length; i++) cDl[i].innerHTML = cDl_m.innerHTML;
    // set up select option
    for (var i = 0; i < $("form").length; i++) {
        var t = $("form")[i].getAttribute("d_type");
        if (t != null) {
            var cY = $("form")[i].querySelector("select[name=_chooseYear]");
            var cM = $("form")[i].querySelector("select[name=_chooseMonth]");
            var eD = stat_date[t];
            for (var p in eD) create_option(p,p,cY);
            for (var k = 1; k <= 12; k++) create_option(k,k,cM);
            // set default seelct option
            var nD = new Date();
            default_option(cY, nD.getFullYear());
            default_option(cM, nD.getMonth() + 1);
            // display graph
            $("form")[i].querySelector("input[name=sum_month]").click();
            // set up summary
            set_summary(t);
        }
    }
}
function set_summary(t) {
    var d = document.getElementById(t);
    var txt = d.innerHTML.replace(/[\t\n\r]+/gim,'');
    var f = $("form[d_type=VIEWS]");
    var y = f.find($("select[name=_chooseYear]"))[0].value;
    var m = f.find($("select[name=_chooseMonth]"))[0].value - 1;
    var tD = new Date().getDate();
    var XDT = {
        TYPE: t,
        YEAR: y,
        YEAR_SUM: addComma(chart_cvs[t].AGG._Y[y]),
        MONTH: MRC[m],
        MONTH_SUM: addComma(chart_cvs[t].AGG._M[y][m]),
        DAY: tD,
        TODAY_SUM: addComma(stat_date[t][y][m][tD]),
        MAX_YEAR_ALL: function() {
            var yr_c = chart_cvs[t].AGG._Y;
            var year = max_item(yr_c);
            var yr_val = addComma(yr_c[year]);
            return year + ": " + yr_val;
        },
        MAX_MONTH_ALL: function() {
            var yr_c = chart_cvs[t].AGG._M;
            var mx_i = { 
                yk: Object.keys(yr_c),
                mk: max_item2(yr_c),
                v: max_item2_val(yr_c)
            };
            var i = max_iA(mx_i.v);
            return MRC[mx_i.mk[i]] + " " + mx_i.yk[i] + ": " + addComma(mx_i.v[i]);
        },
        MAX_DATE_ALL: function() {
            var yr_c = stat_date[t];
            var mv = {};
            var mx = {y:[], m:[], d:[], v:[]};
            for (var i in yr_c) {
                mv[i] = {m:[], d:[], v:[]};
                var c = 0;
                for (var j in yr_c[i]) {
                    var mD = max_item(yr_c[i][j]);
                    mv[i].m[c] = j;
                    mv[i].d[c] = mD;
                    mv[i].v[c] = yr_c[i][j][mD];
                    c++;
                }
                c = max_iA(mv[i].v);
                mx.m.push(mv[i].m[c]);
                mx.d.push(mv[i].d[c]);
                mx.v.push(mv[i].v[c]);
            }
            var k = max_iA(mx.v);
            mx.m = mx.m[k];
            mx.d = mx.d[k];
            mx.v = mx.v[k];
            mx.y = Object.keys(mv)[k];
            
            return mx.d + " " + MRC[mx.m] + " " + mx.y + ": " + addComma(mx.v);
        },
        SUM_ALL: addComma(chart_cvs[t].AGG._A),
        AVERAGE_ALL: addComma(chart_cvs[t].AVG._A),
    }
    // set table
    var MM_tbl = $("table[term=MAX_MONTH_OF_YEAR]")[Object.keys(chart_cvs).indexOf(t)];
    var MiM_tbl = $("table[term=MIN_MONTH_OF_YEAR]")[Object.keys(chart_cvs).indexOf(t)];
    set_dataTable(MiM_tbl, t, 0);
    set_dataTable(MM_tbl, t, 1);
    // file in data
    var x = d.querySelectorAll("*");
    for (var p in XDT) {
        for (var i = 0; i < x.length; i++) {
            x[i].innerHTML = x[i].innerHTML.replace("\{" + p + "\}",XDT[p]);
        }
    }
}
function create_option(a,b,c) {
    var d = document.createElement("option");
    d.innerHTML = a;
    d.value = b;
    c.appendChild(d);
}
function set_dataTable(d, t, st) {
    var tr1 = document.createElement("tr"); // time
    var tr2 = document.createElement("tr"); // value
    var D = chart_cvs[t].AGG._M;
    for (var i in D) {
        var td = document.createElement("td");
        td.innerHTML = MRC[(function(){
            return st == 1 ? max_item(D[i]) : min_item(D[i]);
        })()] + " " + i;
        tr1.appendChild(td);

        td = document.createElement("td");
        td.innerHTML = addComma((function(){
            return st == 1 ? max_item_val(D[i]) : min_item_val(D[i]);
        })());
        tr2.appendChild(td);
    }
    d.appendChild(tr1);
    d.appendChild(tr2);
}
function default_option(slc, val) {
    for(var i, j = 0; i = slc.options[j]; j++) {
        if(i.value == val) {
            slc.selectedIndex = j;
            return;
        }
    }
}