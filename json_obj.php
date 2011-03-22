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

?>