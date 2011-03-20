<?php
session_start();
/**
 * prepare json object
 * ===================
 */
class JsonObj {
    var $label;
    var $data;
    var $xmax;
    var $ymax;
    function setData($foo) {
        $this->data = $foo;
    }

    function setLabel($label) {
        $this->label = $label;
    }

    function setMax($x, $y) {
        $this->xmax = $x;
        $this->ymax = $y;
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
$max = "SELECT max(xpos), max(ypos) FROM mousetable WHERE userid=$_SESSION[userid]";
$result = mysql_query($max, $con);
$row = mysql_fetch_array($result, MYSQL_NUM);
$xmax = $row[0];
$ymax = $row[1];
/* $_SESSION['xmax'] = $xmax; */
/* $_SESSION['ymax'] = $ymax; */
$query = "SELECT xpos, $ymax-ypos FROM mousetable WHERE userid=$_SESSION[userid]";
$result = mysql_query($query, $con);

while ($tmp = mysql_fetch_array($result, MYSQL_NUM)) {
    $final[] = $tmp;
}


/**
 * merge data to fit into certain time span
 */

/* $tmp  = mysql_fetch_row($result); /\* fetch first record *\/ */
/* $time[strtotime($tmp[1])] = 1; */
/* $last = strtotime($tmp[1]) * 1000; */
/* $i = 1; */
/* $final = array(); /\* array for generate json object *\/ */

/* while ($row = mysql_fetch_row($result)) { */
/*     $timestamp = strtotime($row[1]) * 1000; */
/*     if ($timestamp <= $last + 500000) { */
/*         $time[$last/1000]++; */
/*     } else { */
/*         array_push($final, array($last, $time[$last/1000])); */
/*         $i++; */
/*         $time[$timestamp/1000] = 0; */
/*         $time[$timestamp/1000]++; */
/*         $last = $timestamp; */
/*     } */
/* } */
//echo count($time);
//print_r($time);

/* $file = "cache.txt"; */
/* $fp = fopen($file, "w"); */
/* fwrite($fp, serialize($final)); */
/* fclose($fp); */

/**
 * Data Completion for JSON object
 * ===============================
 */
$obj->setData($final);
$obj->setLabel("Mouse Count");
$obj->setMax($xmax, $ymax);
echo json_encode($obj);
mysql_close($con);
?>