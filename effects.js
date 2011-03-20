/**
 * scripts for pchms
 * effects: drawing functions
 * dependings: jquery.min.js/jquery.js, jquery.flot.js
 * ****************************************************
 * author: Styx
 * reference: http://www.baiduux.com/blog/2010/08/31/%E5%9F%BA%E4%BA%8Ecanvas%E7%9A%84%E7%83%AD%E5%8A%9B%E5%9B%BE%E7%BB%98%E5%88%B6%E6%96%B9%E6%B3%95/#more-722
 */


/**
 * working with heat map which displays click frequency on the screen
 * working with ajax data pass by way of parameter "series"
 * REQUIRES: browser support - ff, chrome, opera, safari
 * @param series 2-d array of data
 */

function draw_heat_map(series) {
    var points = [];
    points.push(series.data);
    var canvas = document.getElementById("myCanvas");
    var context = canvas.getContext('2d');
    if (context) {
	//context.fillRect(0, 0, 150, 100);
    }
    var cache = {};
    //计算每个点的密度
    for (var i = 0, len = points.length; i < len; i++) {
	for (var j = 0, len2 = points[i].length; j < len2; j++) {
	    var key = points[i][j][0] + '*' + points[i][j][1];
	    if (cache[key]) {
		cache[key] ++;
	    } else {
		cache[key] = 1;
	    }
	}
    }
    //点数据还原
    var oData = [];
    for (var m in cache) {
	if (m == '0*0') continue;
	var x = parseInt(m.split('*')[0], 10);
	var y = parseInt(m.split('*')[1], 0);
	oData.push([x, y, cache[m]]);
    }
    //简单排序，使用数组内建的sort
    oData.sort(function(a, b){
	return a[2] - b[2];
    });
    var max = oData[oData.length - 1][2];
    var pi2 = Math.PI * 2;
    //设置阈值，可以过滤掉密度极小的点
    var threshold = this._points_min_threshold * max;
    //alpha增强参数
    var pr = (Math.log(245)-1)/245;
    for (var i = 0, len = oData.length; i < len; i++) {
	if (oData[i][2] > 0 ? 0 : 1);
	//q参数用于平衡梯度差，使之符合人的感知曲线log2N，如需要精确梯度，去掉log计算
	var q = parseInt(Math.log(oData[i][2]) / Math.log(max) * 255);
	var r = parseInt(128 * Math.sin((1 / 256 * q - 0.5 ) * Math.PI ) + 200);
	var g = parseInt(128 * Math.sin((1 / 128 * q - 0.5 ) * Math.PI ) + 127);
	var b = parseInt(256 * Math.sin((1 / 256 * q + 0.5 ) * Math.PI ));
	var alp = (0.92 * q + 20) / 255;
	//如果需要灰度增强，则取消此行注释
	//var alp = (Math.exp(pr * q + 1) + 10) / 255
	var radgrad = context.createRadialGradient(oData[i][0], oData[i][1], 1, oData[i][0], oData[i][1], 8);
	radgrad.addColorStop( 0, 'rgba(' + r + ',' + g + ','+ b + ',' + alp + ')');
	radgrad.addColorStop( 1, 'rgba(' + r + ',' + g + ','+ b + ',0)');
	context.fillStyle = radgrad;	
	context.fillRect( oData[i][0] - 8, oData[i][1] - 8, 16, 16);
    }
}
