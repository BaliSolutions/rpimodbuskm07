<?php
  $host = "localhost";
  $user = "root";
  $password = "password";
  $db = "km07";
  $conn = mysql_connect($host,$user,$password);
  $sql = "SELECT * FROM realtime WHERE id=1";
  mysql_select_db(km07);
  $retval = mysql_query($sql,$conn);
  while($row = mysql_fetch_array($retval))
	{
		$volt = $row['volt'];
		$amp = $row['amp'];
		$pf = $row['pf'];
		$kw = $row['kw'];
		$kvar = $row['kvar'];
		$kva = $row['kva'];
		$kwh = $row['kwh'];
	}
  echo "Voltage = " . $volt . "V. Current = " . $amp . " A. Power Factor = " . $pf . "<br> Power = " . $kw . " kW Reactive Power = " . $kvar . " kVar Apparent Power = " . $kva . " kVA". "<br> Total Power = " . $kwh . " kWh";
?>
