<!DOCTYPE html>
<html>
<body>

<?php
	$host = "localhost";
	$user = "root";
	$password = "password";
	$db = "km07";
	$conn = mysql_connect($host,$user,$password);
	$sql = "SELECT date,time,volt,amp,pf,kva FROM rawdata WHERE date='2016-03-17' AND time BETWEEN '02:00:00' and '03:40:00'";
	mysql_select_db(km07);
	$retval = mysql_query($sql,$conn);
	while($row = mysql_fetch_array($retval,MYSQL_ASSOC))
	{
		echo 	"Date : {$row['date']} Time : {$row['time']} <br>".
				"{$row['volt']} Volt {$row['amp']} Amp PF={$row['pf']} Readed KVA={$row['kva']} <br>"
				"------------------------------------------<br>";
	}
	mysql_close($conn);
?>


</body>
</html>