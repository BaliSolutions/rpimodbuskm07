<!DOCTYPE html>
<html>
<body>

<?php
	$host = "localhost";
	$user = "root";
	$password = "password";
	$db = "km07";
	$conn = mysql_connect($host,$user,$password);
	$sql = "SELECT * FROM rawdata";
	mysql_select_db(km07);
	$retval = mysql_query($sql,$conn);
	while($row = mysql_fetch_array($retval,MYSQL_ASSOC))
	{
		echo 	"Date : {$row['date']} ".
				"Time : {$row['time']} <br>"

	}
	mysql_close($conn);
?>


</body>
</html>