// JavaScript Document
window.onload = function() {
    // initialize global variables

    // current graph that is displaying, related to options of the chart
    var current = "#daily_count";

    // option of whether to show global data
    var global_data = true;

    // start point of time span
    var time_span_s = 0;

    // end point of time span
    var time_span_e = 100;

    // interval of calculating op count
    var interval = 10;

    // create div for options
    var choiceContainer = $("#filter");
    choiceContainer.append('<br /><input type="checkbox" name="global" checked="checked" id="global">' +'<label for="global">' + "global" + '</label>');
    $("#global").attr("checked", "checked");
    
    /**
     * set listeners when page finishes loading
     */

    // event listener for daily count
    $("#daily_count").click(function() {
        current = "#daily_count";
        document.getElementById("placeholder").style.display = "block";
        document.getElementById("myCanvas").style.display = "none";
        $("#chart_title").html("Daily Count");

        var stack = 0, bars = true, lines = false, steps = false;
        var options = {
            xaxis: {
                mode: "time",
                timeFormat: "%d",
            },
            series: {
                stack: stack,
                bars: { show: bars, barWidth: 10 }
            },
            legend: { show: true, position: 'ne' },
            grid: {
                hoverable: true
            }
        };
        var dataurl = "getdaily.php";
        var already_fetched = {};
	var post_info = {
            table: "daily",
            time_span_s: time_span_s,
            time_span_e: time_span_e,
            interval: interval
	};
        var data_mouse = [];
        var data_key = [];
        function on_data_received(series) {
            data = series.data;
            $.plot($("#placeholder"), [ { data:data[0], label: "Mouse Data" },
                                        { data:data[1], label: "Keyboard Data" } ], options);
        }
        $.ajax({
            url: dataurl,
            type: 'post',
            data: post_info,
            dataType: 'json',
            success: on_data_received
        });
    });


    // event listener for mouse count
    $("#mouse_count").click(function() {
        current = "#mouse_count";
        document.getElementById("placeholder").style.display = "block";
        document.getElementById("myCanvas").style.display = "none";
        $("#chart_title").html("Mouse Count Per 10 minutes");
        var options = {
            xaxis: {
                color: ["#ffffff"],
                mode: "time",
                timeformat: "%h:%M\r%m/%d"
            },
            lines: { show: true },
            points: { show: true },
            legend: { show: true, position: 'ne' },
            crosshair: { mode: "x" },
            grid: {
                hoverable: true,
            }
        };
        var dataurl = "getmouse.php";
	var post_info = {
	    table: "mousetable",
            time_span_s: time_span_s,
            time_span_e: time_span_e,
            interval: interval
	};
        var already_fetched = {};
        var data = [];
        function on_data_received(series) {
            data = series.data;
	    //alert(data[0].label);
            if (global_data) 
                $.plot($("#placeholder"), [ { data:data[0].data, label: data[0].label },
                                            { data:data[1].data, label: data[1].label }], options);
            else
                $.plot($("#placeholder"), [ { data:data[0].data, label: data[0].label }], options);
	}
        $.ajax({
            url: dataurl,
            type: 'post',
            data: post_info,
            dataType: 'json',
            success: on_data_received
        });
    });


    // event listener for keyboard count
    $("#keyboard_count").click(function() {
        current = "#keyboard_count";
        document.getElementById("placeholder").style.display = "block";
        document.getElementById("myCanvas").style.display = "none";
        $("#chart_title").html("Keyboard Count");
        var options = {
            xaxis: {
                color: ["#000"],
                mode: "time"
                //min: (new Date()).getTime() - 86400000 * 20,
                //max: (new Date()).getTime() - 86400000 * 17
            },
            series: {
                bars: { show: true, barWidth: 1 }
            },
            //lines: { show: true },
            //points: { show: true },
            legend: { show: true, position: 'ne' },
            grid: {
                hoverable: true,
                color: "#000",
                tickColor: "#ffffff"
            }
        };
        var dataurl = "getkeyboard.php";
	var post_info = {
            time_span_s: time_span_s,
            time_span_e: time_span_e,
            interval: interval
	};
        var already_fetched = {};
        var data = [];
        function on_data_received(series) {
            //alert(series);
            data = series.data;
            if (global_data) 
                $.plot($("#placeholder"), [ { data:data[0], label: "Keyboard Cound" },
                                            { data:data[1], label: "Global Count" }], options);
            else
                $.plot($("#placeholder"), [ { data:data[0], label: "Keyboard Cound" }], options);
        }
        $.ajax({
            url: dataurl,
            type: 'POST',
            data: post_info,
            dataType: 'json',
            success: on_data_received
        });
    });


    // event listener for scatter chart
    $("#scatter").click(function() {
        current = "#scatter";
        document.getElementById("placeholder").style.display = "block";
        document.getElementById("myCanvas").style.display = "none";
        $("#chart_title").html("Mouse Click on the Screen");
        var options = {
            xaxis: {
                color: ["#000"],
                // mode: "time",
                // min: (new Date()).getTime() - 86400000 * 18,
                // max: (new Date()).getTime() - 86400000 * 17
            },
            // lines: { show: true },
            points: { show: true },
            legend: { show: true, position: 'ne' },
            grid: {
                hoverable: true,
            }
        };
        var dataurl = "getclickscatter.php";
	var post_info = {
            time_span_s: time_span_s,
            time_span_e: time_span_e,
            interval: interval
	};
        var already_fetched = {};
        var data = [];
        function on_data_received(series) {
            data.push(series.data);
            $.plot($("#placeholder"), [ { data:data[0], label: "Click" } ], options);
        }
        $.ajax({
            url: dataurl,
            type: 'post',
            data: post_info,
            dataType: 'json',
            success: on_data_received
        });
    });


    // event listener for heatmap graph
    $("#heatmap").click(function() {
        current = "#heatmap";
        document.getElementById("placeholder").style.display = 'none';
        document.getElementById("myCanvas").style.display = 'block';
        $("#chart_title").html("Heat Map of Mouse Click");
        var dataurl = "getheat.php";
	var post_info = {
            time_span_s: time_span_s,
            time_span_e: time_span_e,
            interval: interval
	};
        $.ajax({
            url: dataurl,
            type: 'post',
            data: post_info,
            dataType: 'json',
            success: draw_heat_map
        });
        
    });

    // button to enable tooltip on the graph
    $("#enable_tooltip").click(function() {
        if ($("#enableTooltip:checked").length > 0) {
            $("#enableTooltip").attr("checked", false);
        } else {
            $("#enableTooltip").attr("checked", true);
        }
    });


    /**
     * decide whether to show tooltip
     */

    $(function() {
        function showTooltip(x, y, contents) {
            $('<div id="tooltip">' + contents + '</div>').css( {
                position: 'absolute',
                display: 'none',
                top: y + 5,
                left: x + 5,
                border: '1px solid #fdd',
                padding: '2px',
                'background-color': '#fee',
                opacity: 0.80
            }).appendTo("body").fadeIn(200);
        }
        
        var previousPoint = null;
        $("#placeholder").bind("plothover", function (event, pos, item) {
            //$("#x").text(pos.x.toFixed(2));
            $("#x").text(pos.x.toLocaleString());
            $("#y").text(pos.y.toFixed(2));
            
            if ($("#enableTooltip:checked").length > 0) {
                if (item) {
                    if (previousPoint != item.datapoint) {
                        previousPoint = item.datapoint;
                        
                        $("#tooltip").remove();
                        var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2);
                        
                        showTooltip(item.pageX, item.pageY,
                                    item.series.label + " of " + x + " = " + y);
                    }
                }
                else {
                    $("#tooltip").remove();
                    previousPoint = null;            
                }
            }
        });
        
        $("#placeholder").bind("plotclick", function (event, pos, item) {
            if (item) {
                $("#clickdata").text("You clicked point " + item.dataIndex + " in " + item.series.label + ".");
                plot.highlight(item.series, item.datapoint);
            }
        });
    });

    // 显示每张表对应的自定义选项
    $("a#plot_settings").click(function () {
        var displayContent = initOptions(current, time_span_s, time_span_e, interval);
        $.floatbox({
            content: displayContent,
            fade: true,
            boxConfig: {
                height: "250px",
                width: "600px",
            }
        });
        $(".time_span").change(function () {
            time_span_s = $("#time_span_s").val();
            time_span_e = $("#time_span_e").val();
            interval = $("#interval").val();
            $(current).click();
        });
    });

    // 是否选择描绘全站信息
    function plotAccordingToChoices() {
        var status = $("#global").attr("checked");
        //alert(status);
        if (status) {
            //var key = $(this).attr("name");
            global_data = true;
            $(current).click();
        } else {
            global_data = false;
            $(current).click();
        }
    }

    $("#download").click(function () {
        current = "#download";
        document.getElementById("placeholder").style.display = "block";
        document.getElementById("myCanvas").style.display = "none";
        $("#placeholder").html("<div id='download_list'><ul><li><a href='/chart_1'>Chart 1</a></li><li><a href='/chart_2'>Chart 2</a></li><li><a href='chart_3'>Chart 3</a></li></ul></div>");
    });
    // 监听对全站信息的筛选
    $("#global").click(plotAccordingToChoices);
};


function initOptions(chart, start, end, span) {
    var content;
    switch (chart) {
    case "#daily_count":
        {
            content = "<div id=\"float_frame\"><h2>Settings for " + $(chart).text() + "</h2>";
            content = content + "<p><label class=\"option_label\">时间段选择: </label><input type=\"text\" value=" + start + " id=\"time_span_s\" class=\"time_span\"></input> ~ <input type=\"text\" value=" + end + " id=\"time_span_e\" class=\"time_span\" align=\"left\"></input> 天以内的数据</p>";
            content = content + "<p><label class=\"option_label\">统计时间跨度: </label><select id='interval' class='time_span' value='" + span +"'><option value=\"10\">10分钟</option><option value=\"15\">15分钟</option><option value=\"30\">30分钟</option><option value=\"60\">1小时</option></select></p>"
            content = content + "<br /><div><input type=\"submit\" id=\"set_options\" value=\"Set\"></div></div>";
            return(content);
        }
        break;
    case "#mouse_count":
        {
            content = "<div id=\"float_frame\"><h2>Settings for " + $(chart).text() + "</h2>";
            content = content + "<p><label class=\"option_label\">时间段选择: </label><input type=\"text\" value=" + start + " id=\"time_span_s\" class=\"time_span\"></input> ~ <input type=\"text\" value=" + end + " id=\"time_span_e\" class=\"time_span\" align=\"left\"></input> 天以内的数据</p>";
            content = content + "<p><label class=\"option_label\">统计时间跨度: </label><select id='interval' class='time_span' value='" + span +"'><option value=\"10\">10分钟</option><option value=\"15\">15分钟</option><option value=\"30\">30分钟</option><option value=\"60\">1小时</option></select></p>"
            content = content + "<br /><div><input type=\"submit\" id=\"set_options\" value=\"Set\"></div></div>";
            return(content);
        }
        break;
    case "#keyboard_count":
        {
            content = "<div id=\"float_frame\"><h2>Settings for " + $(chart).text() + "</h2>";
            content = content + "<p><label class=\"option_label\">时间段选择: </label><input type=\"text\" value=" + start + " id=\"time_span_s\" class=\"time_span\"></input> ~ <input type=\"text\" value=" + end + " id=\"time_span_e\" class=\"time_span\" align=\"left\"></input> 天以内的数据</p>";
            content = content + "<p><label class=\"option_label\">统计时间跨度: </label><select id='interval' class='time_span' value='" + span +"'><option value=\"10\">10分钟</option><option value=\"15\">15分钟</option><option value=\"30\">30分钟</option><option value=\"60\">1小时</option></select></p>"
            content = content + "<br /><div><input type=\"submit\" id=\"set_options\" value=\"Set\"></div></div>";
            return(content);
        }
        break;
    case "#scatter":
        {}
        break;
    case "#heatmap":
        {}
        break;
    default:
        break;
    }
}


function draw_heat_map(series) {
    var points = [];
    points.push(series.data);
    var canvas = document.getElementById("myCanvas");
    var context = canvas.getContext('2d');
    context.clearRect(0, 0, canvas.width, canvas.height);
    context.globalAlpha = 0.8;
    context.globalCompositeOperation = "lighter";
    // context.translate(0, canvas.height);
    // context.scale(1, -1);
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
    var xmax = series.xmax;
    var ymax = series.ymax;
    var oData = [];
    for (var m in cache) {
        if (m == '0*0') continue;
        var x = parseInt(m.split('*')[0], 10)/xmax*canvas.width;
        var y = parseInt(m.split('*')[1], 0)/ymax*canvas.height;
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
