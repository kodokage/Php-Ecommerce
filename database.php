<?php
  $host = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'onlinestore';

  $dbcon = new mysqli($host, $username, $password, $dbname);
  if($dbcon->connect_errno){
        die("Connection failed: " . $dbcon->connect_error);
    }

    mysqli_select_db($dbcon, $dbname);
 ?>
