<!DOCTYPE html>
<html>
<head>
	<script src="Chart.js"></script>
	<script>
    	var myChart = new Chart({...})
	</script>
</head>>
<body>
Select Date and Time range to view data
<form action="result.php" method="post">
<input type="date" name="date" value="<?php echo $_POST["date"]; ?>">
From <input type="time" name="start_time" value="<?php echo $_POST["start_time"]; ?>"> To <input type="time" name="stop_time" value="<?php echo $_POST["stop_time"]; ?>"> 
 <br><br>
 <input type="submit">
</form>
<br>



<?php
	$host = "localhost";
	$user = "root";
	$password = "password";
	$db = "km07";
	$conn = mysql_connect($host,$user,$password);
	$date = mysql_real_escape_string($_POST['date']);
	$start_time = mysql_real_escape_string($_POST['start_time']);
	$stop_time = mysql_real_escape_string($_POST['stop_time']);
	$sql = "SELECT date,time,volt,amp,pf,kva FROM rawdata WHERE date='$date' AND time BETWEEN '$start_time' and '$stop_time'";
	mysql_select_db(km07);
	$retval = mysql_query($sql,$conn);
	while($row = mysql_fetch_array($retval,MYSQL_ASSOC))
	{
		echo 	"Date : {$row['date']} Time : {$row['time']} <br>".
				"{$row['volt']} Volt {$row['amp']} Amp PF={$row['pf']} Readed KVA={$row['kva']} <br>".
				"------------------------------------------<br>";
	}
	mysql_close($conn);
?>

<canvas id="myChart" width="150" height="150"></canvas>
<script>
var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3]
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>

</body>
</html>