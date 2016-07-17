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

$sqlSchedule = "SELECT s.id
, s.time
, s.bus_num
, d.driver
, d.driver_thai
, d.phoneNum
, r.route
, r.route_id
FROM schedule s
INNER JOIN route r
on s.route_id = r.route_id
INNER JOIN driver d
on d.driver_id = s.driver_id
ORDER BY s.id";
$result_Schedule = mysqli_query($conn, $sqlSchedule);

$sqlTracktime = "SELECT * 
FROM bus_location t1 
WHERE tracktime = 
(SELECT max(tracktime) 
FROM bus_location 
WHERE bus_location.bus_num = t1.bus_num) 
ORDER BY bus_num ASC";
$result_Tracktime = mysqli_query($conn, $sqlTracktime);

$currentTime = date("H:i");
$currentDate = date("d-m-Y");
$currentDay = date('l');


//$currentTime = "9:55";
echo "Current Date ".$currentDate."<br>";
echo "Current Time ".$currentTime."<br>";
$currentTime = strtotime($currentTime);

if(mysqli_num_rows($result_Tracktime) > 0) {
	while($row = mysqli_fetch_assoc($result_Tracktime)){
		if($row['bus_num']==1){
			$timestamp = strtotime($row['tracktime']);
			$time = date('H:i', $timestamp);
			echo "Most recent record of bus_num1: ".$time."<br>";
		}
	}
}

$busnoArray = array();
$sqlbusno = "SELECT DISTINCT bus_num FROM bus_location ORDER BY bus_num ASC
";
$result_busno = mysqli_query($conn, $sqlbusno);
if(mysqli_num_rows($result_busno) > 0) {
	while($row = mysqli_fetch_array($result_busno)) {
		$busnoArray[]=$row['bus_num'];
	}
}

$currentArray = array();


if (mysqli_num_rows($result_Schedule) > 0) {
	while($row = mysqli_fetch_assoc($result_Schedule)) {
		$scheduleTime = strtotime($row['time']);
		$busno = $row['bus_num'];
		$routeid = $row['route_id']; 
		$time = $row['time'];

		foreach($busnoArray as $bus) {
			if($bus==$busno){
				$routeTime = $row['time'];
				echo "<br>".$routeTime;
				if($currentTime>=$scheduleTime){

		    	//Plus two hours
					$scheduleTime2hour = $scheduleTime + (60*60*2)-(30*60);
					$time = date('H:i', $scheduleTime2hour);

					if($currentTime<$scheduleTime2hour){
						echo "   <b> <-- route</b>";
						$currentRouteID = $routeid;
						$currentRouteTime = $time;
						$currentBusNo = $busno;

						$sqlSearchArea = "SELECT * FROM station WHERE route_id = ".$currentRouteID." ORDER BY station_order DESC LIMIT 1"; 
	  					$result_SearchArea = mysqli_query($conn, $sqlSearchArea);
	  				if(mysqli_num_rows($result_SearchArea) > 0 ){
	  				while($row = mysqli_fetch_assoc($result_SearchArea)){
	  					$lastrouteid = $row['station_id'];
	  					echo "<br>Last station id".$lastrouteid;	
	  				}		

						echo "<br>Current route ID ".$currentRouteID."<br>";
						echo "Bus should arrive before ".$currentRouteTime."<br>";
						echo "Current Bus No ".$currentBusNo."<br>";
						$travelTime = (abs($currentTime-strtotime($routeTime))/3600*60);
						echo $travelTime." minutes to travel";
						$newdata =  array (
							'currentRouteID' => $currentRouteID,
							'routeTime' => $routeTime,
							'currentBusNo' => $currentBusNo,
							'travelTime' => $travelTime,
							'currentLastStation' => $lastrouteid
							);
						array_push($currentArray, $newdata);

					}
				}
			}
			
		}
	}
}



$sqlTracktime = "SELECT * FROM bus_location t1 WHERE tracktime = (SELECT max(tracktime) FROM bus_location WHERE bus_location.bus_num = t1.bus_num) ORDER BY bus_num ASC";
$result_Tracktime = mysqli_query($conn, $sqlTracktime);

?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="refresh" content="3">
	<title>Check Location</title>
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
<body onload = init()>
	<div id="map"></div>
	<p> D:  
		<input type="text" id="d" name="d"/>
	</p>
	<script type="text/javascript">
		var map,
		inornot,
		currentLocation,
		searchArea,
		searchAreaMarker,
	  searchAreaRadius = 550, // metres
	  startLat = 13.794759,
	  startLng = 100.323397;

	  function addmarker(title, lat, lng){
	  	randomMarkers.push(
	  	{	
	  		title: title,
	  		latLng: new google.maps.LatLng(lat, lng)
	  	});
	  }

	  function init() {
	  	var startLatLng = new google.maps.LatLng(startLat, startLng);

	  	map = new google.maps.Map(document.getElementById('map'), {
	  		center: new google.maps.LatLng(13.794877, 100.344124),
	  		zoom: 14
	  	});

	  	searchArea = new google.maps.Circle({
	  		strokeColor: '#FF0000',
	  		strokeOpacity: 0.5,
	  		strokeWeight: 2,
	  		fillColor: '#FF0000',
	  		fillOpacity: 0.2,
	  		map: map,
	  		center: startLatLng,
	  		radius: searchAreaRadius
	  	});

	  	searchAreaMarker = new google.maps.Marker({
	  		position: startLatLng,
	  		map: map,
	  		draggable: true,
	  		animation: google.maps.Animation.DROP,
	  		title: 'searchAreaMarker'
	  	});

	  	var randomMarkers = []; 

	  	<?php 
	  	//if($currentDay!="Saturday"&&$currentDay!="Sunday"){
	  	if(mysqli_num_rows($result_Tracktime) > 0) {
	  		while($row = mysqli_fetch_assoc($result_Tracktime)){
	  			$title = $row['bus_num'];
	  			$lat = $row['latitude'];
	  			$lng = $row['longitude'];
	  			echo "randomMarkers.push("."{".
	  			"title: "."\"".$title."\"".",".
	  			"latLng: new google.maps.LatLng(".$lat.",".$lng.")".
	  			"});";
	  		}
	  	}
	  	//}
	  	?>


	  	for (var i = 0; i < randomMarkers.length; i++) {
	  		randomMarkers[i].marker = new google.maps.Marker({
	  			position: randomMarkers[i].latLng,
	  			map: map,
	  			title: randomMarkers[i].title,
	  			icon: 'http://maps.google.com/mapfiles/kml/paddle/'+randomMarkers[i].title+'.png'
	  			
	  		});
	  	}

	  	var num; 

	  		<?php 

	  		$keys = array_keys($currentArray);
	  		//print("console.log( 'keys : $keys[1]' );");


	  		for($i = 0; $i < count($currentArray); $i++) {
	  			$text = ""; 

	  			foreach($currentArray[$keys[$i]] as $key => $value) {
	  				
	  				if($key == "currentRouteID"){
	  					$currentRouteID = $value;
	  				}
	  				if($key == "currentBusNo"){
	  					$currentBusNo = $value;
	  				}
	  				if($key == "routeTime"){
	  					$routeTime = $value;
	  				}
	  				if($key == "travelTime"){
	  					$travelTime = $value;
	  				}
	  				if($key == "currentLastStation"){
	  					$laststationid = $value;
	  				}
	  				$text = $text.$key . " : " . $value . "  ";

	  			}
	  			//$no = $currentBusNo;
	  			echo "console.log('".$text."');";
	  			$sqlSearchArea = "SELECT * FROM station WHERE route_id = ".$currentRouteID." ORDER BY station_order DESC LIMIT 1"; 
	  			$result_SearchArea = mysqli_query($conn, $sqlSearchArea);
	  		
	  			if(mysqli_num_rows($result_SearchArea) > 0 ){
	  				while($row = mysqli_fetch_assoc($result_SearchArea)){
	  						$search = $row['latitude'].",".$row['longitude'];

	  			//function checkLocation(search, busno, stationName, currentRouteID, currentDate, routeTime, currentDay, travelTime){
				echo "checkLocation(".
				$row['latitude'].",".
				$row['longitude'].",".
				$currentBusNo.",'".
				$row['station']."','".
				$currentRouteID."','".
				$currentDate."','".
				$routeTime."','".
				$currentDay."','".
				$travelTime."');
				";
	  					
	  					}

	  					}
	  				}

}
	  			?>

	  			function checkLocation(searchLat, searchLng, busno, stationName, currentRouteID, currentDate, routeTime, currentDay, travelTime){

  		searchAreaRadius = 550;

  		for (var i = 0; i < randomMarkers.length; i++) {
  			if(randomMarkers[i].marker.getTitle() == busno){
  				num = i;
  			}
  		}

  		currentLo = randomMarkers[num].marker.getPosition();
  		searchStation = new google.maps.LatLng(searchLat, searchLng);
  		
  		if (google.maps.geometry.spherical.computeDistanceBetween(currentLo, searchStation) <= searchAreaRadius) {
  			
  			console.log("Bus No." + busno + "=> is in "+ stationName);
  			
  			var url = 'http://bus.atilal.com/checkLocation_Insert.php?routeid=' + currentRouteID+"&busno="+ busno +"&date="+currentDate+"&routetime="+routeTime+"&day="+currentDay+"&traveltime="+travelTime;
  			console.log(url);
  				//window.open(url);

  				var xmlHttp = new XMLHttpRequest();
			    xmlHttp.open( "GET", url, true ); // false for synchronous request
			    xmlHttp.send( null );
			    console.log(xmlHttp.responseText);


} else {
console.log("Bus No." + busno + "=> is NOT in "+ stationName);
}
}
	  		
	  	}


	  </script>

	  <?php  
	  mysqli_close($conn);
	  ?>

	  <script type="text/javascript">


	  </script>


	  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBe9-834OFQGlYMFuAD0u_5cOVj2GBMFfw&signed_in=true&libraries=geometry"
	  async defer></script>
	</body>
	</html>