<!DOCTYPE html>
<html>
<body>

<?php
	$host = "localhost";
	$user = "root";
	$password = "password";
	$db = "km07";
	$conn = mysql_connect($host,$user,$password);
<<<<<<< HEAD
	$sql = "SELECT * FROM rawdata";

||||||| a60406e... asdf
	$sql = "SELECT date, time FROM rawdata WHERE date=\'2016-03-17\' AND time BETWEEN \'02:00:00\' and \'03:40:00\'";
=======
	$sql = "SELECT * FROM rawdata WHERE date='2016-03-17' AND time BETWEEN '02:00:00' and '03:40:00'";
>>>>>>> parent of a60406e... asdf
	mysql_select_db(km07);
	$retval = mysql_query($sql,$conn);
	while($row = mysql_fetch_array($retval,MYSQL_ASSOC))
	{
		echo 	"REPLIED <br>".
				"Date : {$row['date']} <br>".
				"Time : {$row['time']} <br>";
	}
	mysql_close($conn);
?>


</body>
</html>