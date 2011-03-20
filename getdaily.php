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

$query = "SELECT * FROM (SELECT span*86400000 as stamp, times FROM (SELECT CEIL(UNIX_TIMESTAMP(dtstamp)/86400.0) span, COUNT(dtstamp) times FROM mousetable WHERE userid='$_SESSION[userid]' GROUP BY span) x ) y WHERE stamp<=UNIX_TIMESTAMP(date_add(curdate(), interval -'$_GET[time_span_s]' day))*1000 and stamp >= UNIX_TIMESTAMP(date_add(curdate(),interval -'$_GET[time_span_e]' day))*1000";
$result1 = mysql_query($query, $con);

while ($tmp = mysql_fetch_array($result1, MYSQL_NUM)) {
    $final[] = $tmp;
}

$query = "SELECT * FROM (SELECT span*86400000 as stamp, times FROM (SELECT CEIL(UNIX_TIMESTAMP(dtstamp)/86400.0) span, COUNT(dtstamp) times FROM keytable WHERE userid=('$_SESSION[userid]') GROUP BY span) x ) y WHERE stamp<=UNIX_TIMESTAMP(date_add(curdate(), interval -'$_GET[time_span_s]' day))*1000 and stamp >= UNIX_TIMESTAMP(date_add(curdate(),interval -'$_GET[time_span_e]' day))*1000";

$result2 = mysql_query($query, $con);

while ($tmp = mysql_fetch_array($result2, MYSQL_NUM)) {
    $last[] = $tmp;
    for ($i = 0; $i < count($final); $i++) {
        if ($final[$i][0] == $tmp[0]) {
            $final[$i][1] += $tmp[1];
        }
    }
}

$data = array($final, $last);

/**
 * Data Completion for JSON object
 * ===============================
 */
$obj->setData($data);
echo json_encode($obj);
mysql_close($con);

?>