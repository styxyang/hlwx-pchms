<?php
session_start();
echo $_SESSION['userid'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="/base.css" type="text/css" />
    <link rel="stylesheet" href="/frame.css" type="text/css" />
    <title>Personal Center</title>
    <?php
    if (count($_SESSION) == 0) {
        $url = "/index.php";
        echo "you have not loggin yet, will return to login page in 3s";
        echo "<script type=\"text/javascript\">window.setTimeout(function() {location.href=\"/index.php\";}, 3000);</script>";
    }
    ?>
    <script language="javascript" type="text/javascript" src="/jquery.js"></script>
    <script language="javascript" type="text/javascript" src="/jquery.flot.js"></script>
    <script language="javascript" type="text/javascript" src="/jquery.floatbox.js"></script>
    <script language="javascript" type="text/javascript" src="/pchms.js"></script>
    <script language="javascript" type="text/javascript" src="/jquery.flot.crosshair.js"></script>
    <script language="javascript" type="text/javascript" src="../jquery.flot.stack.js"></script>
    <script language="javascript" type="text/javascript">
    $(document).ready(function () {
	$("#menus ul li").mouseover(function() {
	    $(this).addClass("over");}).mouseout(function() {
		$(this).removeClass("over");});
	$("#menus ul li:even").addClass("alt");
	$("a").not($(".chart_select")).mouseover(function () {
	    $(this).addClass("light");}).mouseout(function () {
		$(this).removeClass("light")});

      });
    </script>
  </head>

  <body>
    <div id="wrapper" align="center">
      <div id="top_title" align="right">
        <div style="float:left;margin-left:220px;font-size:13px;" align="left">
          <span>这里是PCHMS-hlwx edition在线版</span>
          <br />
          <br />
          <span>基于Javascript的数据系统，若Internet Explorer无法显示</span>
          <br />
          <br />
          <span>请使用FF、Chrome、Opera、Safari等开源浏览器</span>
        </div>
        <div class="user_settings">
          <ul style="display:block;">
            <li>Hello, <?php echo $_SESSION['username']; ?></li>
            <li><a href="action.php?action=help">帮助</a></li> |
            <li><a href="javascript:void(0);" id="plot_settings">设置</a></li> |
            <li><a href="action.php?action=logout">退出</a></li>
          </ul>
        </div>
      </div>
      <br />
      <div id="plot">
        <div id="menus">
          <ul>
            <li><a href="javascript:void(0);" class="chart_select" id="daily_count"> Daily Count </a></li>
            <li><a href="javascript:void(0);" class="chart_select" id="mouse_count"> Mouse Count </a></li>
            <li><a href="javascript:void(0);" class="chart_select" id="keyboard_count"> Keyboard Count </a></li>
            <li><a href="javascript:void(0);" class="chart_select" id="scatter"> Click Scatterring </a></li>
            <li><a href="javascript:void(0);" class="chart_select" id="heatmap"> Heat Map </a></li>
            <li><a href="javascript:void(0);" class="chart_select" id="enable_tooltip"> Enable Tooltip </a></li>
          </ul>
        </div>
        <div id="holder">
          <div id="chart_title" align="center">图表将在以下区域画出</div>
          <div id="placeholder" align="center"></div>
          <canvas id="myCanvas"></canvas>
          <div id="hover_option" align="center">
            <p id="hoverdata">Mouse hovers at (<span id="x">0</span>, <span id="y">0</span>). <span id="clickdata"></span></p>
            <p>
              <input id="enableTooltip" type="checkbox">
                Enable Tooltip
              </input>
            </p>
            <p id="filter">Show:</p>
          </div>
        </div>
      </div>
      <div align="center"> <br />
        <br />
        <br />
        <br />
        <div class="info">
          <ul class="proj">
            <li>SE09@SJTU Intel-SJTU Project 2011-2</li>
            |
            <li>Member: 洪扬，柳古月，王立擘，许欣昊</li>
          </ul>
        </div>
      </div>
      <script language="javascript" type="text/javascript">
        
      </script> 
    </div>
  </body>
</html>
