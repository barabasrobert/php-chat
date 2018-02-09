<?php

class datenbank {

private $db;

  function __construct() {

  }

  function getDB() {
    return $this->db = new mysqli("IP-to-MySQL-Server", "username", "password", "name-of-database");
  }

}


?>
