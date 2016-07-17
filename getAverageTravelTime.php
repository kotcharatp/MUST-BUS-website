<?php 
$servername = "localhost";
$username = "atilalco_bus";
$password = "bustracker";
$dbname = "atilalco_bus";
	// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
if($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$currentDate = date("d-m-Y");

$sqlDRoute = "SELECT DISTINCT route_id, time_leave, bus_num FROM calculate_travel_time";
$result_DRoute = mysqli_query($conn, $sqlDRoute);
echo "Total Route: ".mysqli_num_rows($result_DRoute)."<br>";

$sqlDDay = "SELECT DISTINCT day FROM calculate_travel_time";
$result_DDay = mysqli_query($conn, $sqlDDay);
echo "Total day: ".mysqli_num_rows($result_DDay)."<br>";
echo "------------------------------------------------<br>";

$day = array();
if(mysqli_num_rows($result_DDay) > 0) {
	while($row = mysqli_fetch_array($result_DDay)){
		$day[]=$row['day'];
	}
}

if(mysqli_num_rows($result_DRoute) > 0) {
	while($row = mysqli_fetch_assoc($result_DRoute)){
		$routeid = $row['route_id'];
		$timeleave = $row['time_leave'];
		$busnum = $row['bus_num'];

		foreach($day as $dayy) {
			$avg = 0; 
			$sqlFilter = "SELECT * FROM calculate_travel_time WHERE route_id = ".$routeid." AND time_leave = \"".$timeleave."\"".
			" AND day = \"".$dayy."\"" ;
			$result_Filter = mysqli_query($conn, $sqlFilter);
			$len = mysqli_num_rows($result_Filter);
			echo "Total record for ".$routeid." : ".$timeleave." : ".$dayy." --> ".$len;
			if(mysqli_num_rows($result_Filter) > 0) {
				echo "  Average ";
				while($row = mysqli_fetch_assoc($result_Filter)){
					echo $row['time_travel'].",";
					$avg = $avg + $row['time_travel'];
				}
				$avg = $avg/mysqli_num_rows($result_Filter);
				echo " = ".$avg;

				$sqlTravelTime = "SELECT *
				FROM travel_time
				WHERE route_id = ".$routeid." AND ".
				"bus_num = ".$busnum." AND ".
				"day = \"".$dayy."\" AND ".
				"time_leave = \"".$timeleave."\"";

				$result_TravelTime = mysqli_query($conn, $sqlTravelTime);
				if(mysqli_num_rows($result_TravelTime) == 0){
					$sql = "INSERT INTO travel_time (route_id, station_id, date, day, bus_num, time_leave, time_travel) 
					VALUES ('". 
					$routeid ."', '". 
					"0" ."', '". 
					$currentDate ."', '". 
					$dayy ."', '". 
					$busnum ."', '". 
					$timeleave ."', '". 
					$avg ."')";

					if ($conn->query($sql) === TRUE) {
						echo "New travel time created successfully";
					} else {
						echo "Error";
					}

				} else {
					$sqlAvg = "SELECT * FROM travel_time
					WHERE route_id = ".$routeid." AND ".
					"bus_num = ".$busnum." AND ".
					"day = \"".$dayy."\" AND ".
					"time_leave = \"".$timeleave."\"";

					$result_avg = mysqli_query($conn, $sqlAvg);
					if(mysqli_num_rows($result_avg) > 0){
						while($row = mysqli_fetch_assoc($result_avg)){
							$oldavg = $row['time_travel'];
						}
					}

					$avg = round(($avg+$oldavg)/2);

					$sql = "UPDATE travel_time 
					SET time_travel = ".$avg.
					" WHERE route_id = ".$routeid." AND ".
					"bus_num = ".$busnum." AND ".
					"day = \"".$dayy."\" AND ".
					"time_leave = \"".$timeleave."\"";

					if ($conn->query($sql) === TRUE) {
						echo " <br> Update travel time created successfully <br>";
					} else {
						echo "<br><b>Error</b>". $conn->error."<br>";
					}
				}

			}echo "<br>";
		}
	}
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Average Travel Time</title>
	<style>
		html, body {
			height: 100%;
			margin: 0;
			padding: 0;
		}
		#map {
			height: 50%;
		}
	</style>
</head>
<body>


	<?php  
	
	mysqli_close($conn);
	?>

	
</body>
</html>