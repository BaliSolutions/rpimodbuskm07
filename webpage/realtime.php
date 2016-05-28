<?php
  $host = "localhost";
  $user = "root";
  $password = "password";
  $db = "km07";
  $conn = mysql_connect($host,$user,$password);
  $sql = "SELECT * FROM realtime WHERE id=1";
  mysql_select_db(km07);
  $retval = mysql_query($sql,$conn);
  echo $retval['volt'];
?>
