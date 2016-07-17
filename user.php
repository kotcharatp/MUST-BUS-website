<?php

require_once('includes/checkLogin.inc.php'); 

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

  $sqlTracktime = "SELECT * 
  FROM bus_location t1 
  WHERE tracktime = 
  (SELECT max(tracktime) 
  FROM bus_location 
  WHERE bus_location.bus_num = t1.bus_num) 
  ORDER BY bus_num ASC";
  $result_Tracktime = mysqli_query($conn, $sqlTracktime);

  $sqlTracktime = "SELECT * FROM bus_location t1 WHERE tracktime = (SELECT max(tracktime) FROM bus_location WHERE bus_location.bus_num = t1.bus_num) ORDER BY bus_num ASC";
  $result_Tracktime = mysqli_query($conn, $sqlTracktime);

  $sql = "SELECT r.route, r.route_id FROM route r ORDER BY r.route_id";
  $result = mysqli_query($conn, $sql);

  $sqlSearchArea = "SELECT * FROM station ORDER BY station_order"; 
  $result_SearchArea = mysqli_query($conn, $sqlSearchArea);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<?php include("includes/headerFiles.php"); ?>

</head>




<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">


<?php
$page_title = "User Page";
?>


<title><?php echo $page_title; ?></title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- <link href="style.css" rel="stylesheet" type="text/css" media="screen" /> -->

<style type="text/css"></style>

<style>
#map {
margin-top: 0%;
height: 70%;
margin-left: 15%
margin-right: 1%;
width: 84%;
}


</style>


</head>

<body onload = init() style="background-color: #032a47;">

<?php include("layout/header.php");?>
<?php include("layout/menu.php");?>

<div style="margin-top: 10%; margin-left: 0%; color: white;" >
  <fieldset class="form-group" style="width: 84%; margin-left: 10%; ">
    <label for="exampleSelect1" style="margin-left:0%; font-size: 1.5em; font-family: Arial; ">Select Route</label>
    <select class="form-control" id="exampleSelect1" onchange="mapDirection(this.value)">
      <?php
      while($row = mysqli_fetch_array($result)) {
      		echo "<option value='".$row['route_id']."'> ".$row['route']." </option>"; 	   
      }
      ?>
    </select>
  </fieldset>
</div>


<div id="map"></div> 
<?php include("layout/footer.php"); ?>


<script type="text/javascript">

var map,
searchArea,
searchAreaMarker,
searchAreaRadius = 1000, // metres
startLat = 13.747924,
startLng = 100.433133,
station = [],
search = [];

function mapDirection(routeID){

for (var i = 0; i < station.length; i++) {
  		station[i].marker.setMap(null);
}
	station = [];

<?php 
		if(mysqli_num_rows($result_SearchArea) > 0 ){
			while($row = mysqli_fetch_assoc($result_SearchArea)){
			$title = $row['station'];
  			$lat = $row['latitude'];
  			$lng = $row['longitude'];

			echo "if(routeID == ".$row['route_id']."){";
				echo "station.push("."{".
  			"title: "."\"".$title."\"".",".
  			"latLng: new google.maps.LatLng(".$lat.",".$lng.")".
  			"});";
  			echo "}";

}
}
?>

var waypoints = [];

for (var i = 0; i < station.length; i++) {
  		station[i].marker = new google.maps.Marker({
  			position: station[i].latLng,
  			map: map,
  			title: station[i].title,
  			icon: 'layout/bus_station_icon.png'
  		});
  		waypoints.push({
  			location: station[i].latLng,
  			stopover: true
  		});
  	}

var startLatLng = station[0].marker.getPosition();
var endd = station[(station.length)-1].marker.getPosition();
var request = {
origin:startLatLng, 
destination:endd,
waypoints: waypoints,
//optimizeWaypoints: true,
travelMode: google.maps.DirectionsTravelMode.DRIVING
};

var directionsService = new google.maps.DirectionsService();
directionsDisplay.setMap(map);
directionsDisplay.setOptions( { suppressMarkers: true } );

directionsService.route(request, function(response, status) {
if (status == google.maps.DirectionsStatus.OK) {
  directionsDisplay.setDirections(response);
  var myRoute = response.routes[0];
  var txtDir = '';
  for (var i=0; i<myRoute.legs[0].steps.length; i++) {
    txtDir += myRoute.legs[0].steps[i].instructions+"<br />";
  }
}
});

}

function init() {

var startLatLng = new google.maps.LatLng(startLat, startLng);
directionsDisplay = new google.maps.DirectionsRenderer();
var myOptions = {
mapTypeId: google.maps.MapTypeId.ROADMAP,
center: startLatLng,
zoom: 12
}
map = new google.maps.Map(document.getElementById("map"), myOptions);

directionsDisplay = new google.maps.DirectionsRenderer({
    polylineOptions: {
      strokeColor: "green"
    }
  });
  directionsDisplay.setMap(map);


var randomMarkers = []; 
var searchAreaa = [];

<?php 

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

?>


for (var i = 0; i < randomMarkers.length; i++) {
randomMarkers[i].marker = new google.maps.Marker({
  position: randomMarkers[i].latLng,
  map: map,
  title: randomMarkers[i].title,
  icon: 'http://maps.google.com/mapfiles/kml/paddle/'+randomMarkers[i].title+'.png'

});
}

mapDirection(1);


}

</script>

<!-- jQuery first, then Bootstrap JS. -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>


<!-- http://v4-alpha.getbootstrap.com/components/button-dropdown/ -->
<!-- jQuery -->
<script src="//code.jquery.com/jquery.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyABE1ed0zSRkbAF0tQ90phGSDIE4_-Qm1M&libraries=geometry&callback=init"
async defer></script>

<!-- jQuery -->
<script src="layout/bs_sidebar/js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="layout/bs_sidebar/js/bootstrap.min.js"></script>
<script type="text/javascript">

function showUser(str) {

console.log(str);

}



</script>

</body>
</html>