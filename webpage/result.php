<!DOCTYPE html>
<html>
<head>
	<script src="Chart.js"></script>
	<script src="jquery-1.12.4.js"></script>
	<script>
    	var myChart = new Chart({...})
	</script>
	<script>
    $(document).ready(function(){
			$("#latestData").load("realtime.php");
        setInterval(function() {
            $("#latestData").load("realtime.php");
        }, 2000);
    });

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
	//$time = array();
	//$kwh = array();
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

	$deltakwh[0]=0;
	for ($i=1; $i < count($kwh); $i++) {
		$deltakwh[$i]=$kwh[$i]-$kwh[$i-1];
	}
?>

<div id = "latestData">

</div>

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
            label: 'Delta kVh',
            backgroundColor : "rgba(255,67,60,0.4)",
			borderColor : "#E82B72",
			pointBackgroundColor : "#fff",
			pointBorderCorlor : "#E84E2B",
            data: <?=json_encode(array_values($deltakwh));?>
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
            backgroundColor : "rgba(42,32,255,0.4)",
			borderColor : "#1140E8",
			pointBackgroundColor : "#fff",
			pointBorderCorlor : "#5611E8",
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
            backgroundColor : "rgba(72,255,0,0.4)",
			borderColor : "#0CE818",
			pointBackgroundColor : "#fff",
			pointBorderCorlor : "#97E80C",
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
            label: 'Power Factor',
            backgroundColor : "rgba(232,101,255,0.4)",
			borderColor : "#A851E8",
			pointBackgroundColor : "#fff",
			pointBorderCorlor : "#E851C6",
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
            label: 'KVA',
            backgroundColor : "rgba(255,176,0,0.4)",
			borderColor : "#E88E0C",
			pointBackgroundColor : "#fff",
			pointBorderCorlor : "#E8BA0C",
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
