<?php
session_start();
/**
 * prepare json object
 * ===================
 */
class JsonObj {
    var $data;
    function setData($foo) {
        $this->data = $foo;
    }
}

$obj = new JsonObj;

/**
 * connect to database and fetch data
 * ==================================
 */

$con = mysql_connect('localhost', 'root', 'styx_hy');
if (!isset($con)) {
    echo "cannot connect to db";
}

mysql_select_db('pchms', $con);


/*!
 * Query data from database
 * ========================
 */
$query = "SELECT * FROM (SELECT span*60000*$_POST[interval] as stamp, times FROM (SELECT CEIL(UNIX_TIMESTAMP(dtstamp)/60.0/$_POST[interval]) span, COUNT(dtstamp) times FROM keytable WHERE userid=('$_SESSION[userid]') GROUP BY span) x ) y WHERE stamp<=UNIX_TIMESTAMP(date_add(curdate(), interval -'$_POST[time_span_s]' day))*1000 and stamp >= UNIX_TIMESTAMP(date_add(curdate(),interval -'$_POST[time_span_e]' day))*1000;";
$result = mysql_query($query, $con);

while ($tmp = mysql_fetch_array($result, MYSQL_NUM)) {
    $final[] = $tmp;
}

$query = "SELECT * FROM (SELECT span*60000*$_POST[interval] as stamp, times FROM (SELECT CEIL(UNIX_TIMESTAMP(dtstamp)/60.0/$_POST[interval]) span, COUNT(dtstamp) times FROM keytable GROUP BY span) x ) y WHERE stamp<=UNIX_TIMESTAMP(date_add(curdate(), interval -'$_POST[time_span_s]' day))*1000 and stamp >= UNIX_TIMESTAMP(date_add(curdate(),interval -'$_POST[time_span_e]' day))*1000;";
$result = mysql_query($query, $con);

while ($tmp = mysql_fetch_array($result, MYSQL_NUM)) {
        $glo[] = $tmp;
}

$data = array($final, $glo);



/**
 * Data Completion for JSON object
 * ===============================
 */
$obj->setData($data);
echo json_encode($obj);
mysql_close($con);

?>