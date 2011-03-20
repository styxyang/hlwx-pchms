<?php
/**
 * Copyright (C) 2011 SJTU School of Software
 * 
 * definition of data object used to pass series data
 */

/**
 * Class: DataPack
 * basic unit of a pack of data designed to be part ot JsonObj
 */

class DataPack {
  var $label;
  var $data;

  function setData($data) {
    $this->data = $data;
  }

  function setLabel($label) {
    $this->label = $label;
  }
}

/**
 * Class: JsonObj
 * packed object containing several DataPack in response to Ajax request
 */
class JsonObj {
  var $data;

  function setData($data) {
    $this->data = $data;
  }
}

function query_data(&$personal, &$global, $con) {
  $query = "SELECT * FROM (SELECT span*60000*" . $_POST['interval']. " as stamp, times FROM (SELECT CEIL(UNIX_TIMESTAMP(dtstamp)/60.0/" . $_POST['interval'] . ") span, COUNT(dtstamp) times FROM " . $_POST['table'] . " WHERE userid=" . $_SESSION['userid'] . " GROUP BY span) x ) y WHERE stamp<=UNIX_TIMESTAMP(date_add(curdate(), interval -" . $_POST['time_span_s'] . " day))*1000 and stamp >= UNIX_TIMESTAMP(date_add(curdate(),interval -" . $_POST['time_span_e'] . " day))*1000;";
  $result = mysql_query($query, $con);

  $personal = new DataPack;
  while ($tmp = mysql_fetch_array($result, MYSQL_NUM)) {
    $final[] = $tmp;
  }
  //$personal->setLabel("Personal Mouse Click");
  $personal->setData($final);

  $query = "SELECT * FROM (SELECT span*60000*" . $_POST['interval'] . " as stamp, times FROM (SELECT CEIL(UNIX_TIMESTAMP(dtstamp)/60.0/" . $_POST['interval'] . ") span, COUNT(dtstamp) times FROM " . $_POST['table'] . " GROUP BY span) x ) y WHERE stamp<=UNIX_TIMESTAMP(date_add(curdate(), interval -" . $_POST['time_span_s'] . " day))*1000 and stamp >= UNIX_TIMESTAMP(date_add(curdate(),interval -" . $_POST['time_span_e'] . " day))*1000;";
  $result = mysql_query($query, $con);

  while ($tmp = mysql_fetch_array($result, MYSQL_NUM)) {
    $glo[] = $tmp;
  }
  $global = new DataPack;
  $global->setLabel("Global Count");
  $global->setData($glo);
}

function setLabel(&$series) {
  switch ($_POST['table']) {
  case 'daily':
    $series.setLabel("Daily Count");
  case 'mousetable':
    $series.setLabel("Personal Mouse Click");
  case 'keytable':
    $series.setLabel("Personal Keyboard");
  case 'scatter':
  case 'heatmap':
  }
}
?>