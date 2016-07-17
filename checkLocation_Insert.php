<?php

//http://bus.atilal.com/bus_location.php?lat=100&long=200&busNum=1
//http://bus.atilal.com/checkLocation_insert.php?routeid=10&busno=10&date=10-10-1010&routetime=5:55&day=asdf&traveltime=54

$currentRouteID = $_GET["routeid"];
$currentBusNo = $_GET["busno"];
$currentDate = $_GET["date"];
$routeTime = $_GET["routetime"];
$currentDay = $_GET["day"];
$travelTime = $_GET["traveltime"];

echo "currentRouteID = ".$currentRouteID. 
	"and currentBusNo = ".$currentBusNo. 
	"and currentDate = ".$currentDate. 
	"and routeTime = ".$routeTime. 
	"and currentDay = ".$currentDay. 
	"and travelTime = ".$travelTime;

$servername = "localhost";
$username = "atilalco_bus";
$password = "bustracker";
$dbname = "atilalco_bus";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}


$sqlTravelTime = "SELECT DISTINCT t.id , r.route_id , t.date , t.day , t.bus_num , t.time_leave , t.time_travel FROM calculate_travel_time t INNER JOIN route r on t.route_id = r.route_id WHERE t.route_id = ".$currentRouteID." AND "."t.bus_num = ".$currentBusNo." AND ".
"t.date = \"".$currentDate. "\" AND ".
"t.station_id ="."0"." AND ".
"t.time_leave = \"".$routeTime."\"";
$result_TravelTime = mysqli_query($conn, $sqlTravelTime);

if(mysqli_num_rows($result_TravelTime) == 0) {

	$sql = "INSERT INTO calculate_travel_time (route_id, station_id, date, day, bus_num, time_leave, time_travel)VALUES ('".$currentRouteID ."', '"."0" ."', '".$currentDate ."', '".$currentDay ."', '".$currentBusNo ."', '".$routeTime ."', '".$travelTime ."')";

	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully";
		$sql = "";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

}


$conn->close();


?>
