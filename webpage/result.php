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
	$sql = "SELECT date,time,volt,amp,pf,kva,kwh FROM rawdata WHERE date='$date' AND time BETWEEN '$start_time' and '$stop_time'";
	mysql_select_db(km07);
	$retval = mysql_query($sql,$conn);
	/*while($row = mysql_fetch_array($retval,MYSQL_ASSOC))
	{
		echo 	"Date : {$row['date']} Time : {$row['time']} <br>".
				"{$row['volt']} Volt {$row['amp']} Amp PF={$row['pf']} Readed KVA={$row['kva']} kWh={$row['kwh']} <br>".
				"------------------------------------------<br>";
	}*/
	$time = array();
	$kwh = array();
	$n=0;
	while($row = mysql_fetch_array($retval,MYSQL_ASSOC))
	{
		$time[$n] = $row['time'];
		$kwh[$n] = $row['kwh'];
		$volt[$n] = $row['volt'];
		$amp[$n] = $row['amp'];
		$pf[$n] = $row['pf'];
		$kva[$n] = $row['kva'];
		$n++;
	}
	mysql_close($conn);
?>

<canvas id="kwh" width="60" height="20"></canvas>
<canvas id="volt" width="60" height="20"></canvas>
<canvas id="amp" width="60" height="20"></canvas>
<canvas id="pf" width="60" height="20"></canvas>
<canvas id="kva" width="60" height="20"></canvas>
<script>
var ctx = document.getElementById("kwh");
var kwh = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?=json_encode(array_values($time));?>,
        datasets: [{
            label: 'Total kVa',
            data: <?=json_encode(array_values($kwh));?>
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
var ctx = document.getElementById("volt");
var volt = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?=json_encode(array_values($time));?>,
        datasets: [{
            label: 'Voltage',
            data: <?=json_encode(array_values($volt));?>
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:false
                }
            }]
        }
    }
});
var ctx = document.getElementById("amp");
var amp = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?=json_encode(array_values($time));?>,
        datasets: [{
            label: 'Current',
            data: <?=json_encode(array_values($amp));?>
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:false
                }
            }]
        }
    }
});
var ctx = document.getElementById("pf");
var pf = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?=json_encode(array_values($time));?>,
        datasets: [{
            label: 'Voltage',
            data: <?=json_encode(array_values($pf));?>
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
var ctx = document.getElementById("kva");
var kva = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?=json_encode(array_values($time));?>,
        datasets: [{
            label: 'Voltage',
            data: <?=json_encode(array_values($kva));?>
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:false
                }
            }]
        }
    }
});
</script>


</body>
</html>