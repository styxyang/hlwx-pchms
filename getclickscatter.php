<?php
/*!
 * Initialization
 * =======================
 */
require_once(dirname(__FILE__) . "/json_obj.php");

session_start();

/* prepare json object */

$obj = new JsonObj;

/* connect to database and fetch data */

$con = mysql_connect('localhost', 'root', 'styx_hy');
if (!isset($con)) {
    echo "cannot connect to db";
}

mysql_select_db('intelpchms', $con);


/*!
 * Query data from database
 * ========================
 */
// 先找到屏幕的分辨率
$max = "SELECT max(xpos), max(ypos) FROM mousetable WHERE userid=$_SESSION[userid]";
$result = mysql_query($max, $con);
$row = mysql_fetch_array($result, MYSQL_NUM);
$xmax = $row[0];
$ymax = $row[1];
/* $_SESSION['xmax'] = $xmax; */
/* $_SESSION['ymax'] = $ymax; */

/* $query = "SELECT xpos, $ymax-ypos FROM mousetable WHERE userid=$_SESSION[userid] order by rand() limit 4000"; */

$query = "SELECT xpos, $ymax-ypos FROM mousetable order by rand() limit 4000";
$result = mysql_query($query, $con);

while ($tmp = mysql_fetch_array($result, MYSQL_NUM)) {
    $final[] = $tmp;
}

$personal->setLabel("Click on the Screen");
$personal->setData($final);

/**
 * Data Completion for JSON object
 * ===============================
 */
$obj->setData($final);
echo json_encode($obj);
mysql_close($con);
?>
