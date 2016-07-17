<?php
$servername = "localhost";
$username = "atilalco_bus";
$password = "bustracker";
$dbname = "atilalco_bus";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->query("set names utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT rs.id
    , r.route
    , r.route_thai
    , s.station
    , s.station_thai
    , rs.bus_num
    , rs.time
    , rs.stationTime
    FROM route_station rs
    INNER JOIN route r
    on rs.route_id = r.route_id
    INNER JOIN station s
    on rs.station_id = s.station_id AND rs.route_id = s.route_id
    ORDER BY rs.id";
$result = mysqli_query($conn, $sql);
$output2 = "";
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    $output = "{\"route_station\": [";
    while($row = mysqli_fetch_assoc($result)) {

        $output2 = $output2 . "{\"id\": \"" . $row["id"]. "\", \"route\": \"" . $row["route"]. "\", \"station\": \"" . $row["station"]."\", \"route_thai\": \"" . $row["route_thai"]. "\", \"station_thai\": \"" . $row["station_thai"]."\", \"bus_num\": \"" . $row["bus_num"]."\", \"time\": \"" . $row["time"]."\",\"stationTime\": \"" . $row["stationTime"]."\"},";
    }
    $output2 = substr($output2, 0, -1);
    $output2 = $output2."]}";
    echo $output.$output2;
} else {
    echo "0 results";
}

mysqli_close($conn);
?>