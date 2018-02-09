<?php

class datenbank {

private $db;

  function __construct() {

  }

  function getDB() {
    return $this->db = new mysqli("localhost", "root", "terraria", "chat");
  }

}


?>
