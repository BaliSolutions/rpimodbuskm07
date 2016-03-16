<!DOCTYPE html>
<html>
<body>

<?php
	$host = "localhost";
	$user = "root";
	$password = "password";
	$db = "km07";
	$conn = mysql_connect($host,$user,$password);
	$sql = 'SELECT date, time, volt, amp, pf, kva FROM rawdata';
	mysql_select_db(km07);
?>


</body>
</html>