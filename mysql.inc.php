<?php
  // mysql.inc.php - This file will be used to establish the database connection.
  class myConnectDB extends mysqli{
    public function __construct($hostname="localhost",
        $user="titus",
        $password="titus",
        $dbname="juicy_pepper"){
      parent::__construct($hostname, $user, $password, $dbname);
    }
  }

  require_once('mysql.inc.php');    # MySQL Connection Library
  $db = new myConnectDB();          # Connect to MySQL
?>
