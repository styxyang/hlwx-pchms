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

$query = "SELECT * FROM (SELECT span*86400000 as stamp, times FROM (SELECT CEIL(UNIX_TIMESTAMP(dtstamp)/86400.0) span, COUNT(dtstamp) times FROM mousetable WHERE userid=" . $_SESSION['userid'] . " GROUP BY span) x ) y WHERE stamp<=UNIX_TIMESTAMP(date_add(curdate(), interval -" . $_POST['time_span_s'] . " day))*1000 and stamp >= UNIX_TIMESTAMP(date_add(curdate(),interval -" . $_POST['time_span_e'] . " day))*1000";
$result = mysql_query($query, $con);

$personal = new DataPack;
//echo mysql_num_rows($result);
while ($tmp = mysql_fetch_array($result, MYSQL_NUM)) {
  $final[] = $tmp;
}
//echo $query;
$personal->setLabel("Mouse Click");
$personal->setData($final);

$query = "SELECT * FROM (SELECT span*86400000 as stamp, times FROM (SELECT CEIL(UNIX_TIMESTAMP(dtstamp)/86400.0) span, COUNT(dtstamp) times FROM keytable WHERE userid=" . $_SESSION['userid'] . " GROUP BY span) x ) y WHERE stamp<=UNIX_TIMESTAMP(date_add(curdate(), interval -" . $_POST[time_span_s] . " day))*1000 and stamp >= UNIX_TIMESTAMP(date_add(curdate(),interval -" . $_POST[time_span_e] . " day))*1000";
$result = mysql_query($query, $con);

while ($tmp = mysql_fetch_array($result, MYSQL_NUM)) {
  $glo[] = $tmp;
}
$global = new DataPack;
$global->setLabel("KeyBoard Count");
$global->setData($glo);

$data = array($personal, $global);

/**
 * Data Completion for JSON object
 * ===============================
 */
$obj->setData($data);
echo json_encode($obj);
mysql_close($con);

?>