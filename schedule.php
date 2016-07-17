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

$sql = "SELECT s.id
    , s.time
    , s.bus_num
    , d.driver
    , d.driver_thai
    , d.phoneNum
    , r.route
    FROM schedule s
    INNER JOIN route r
    on s.route_id = r.route_id
    INNER JOIN driver d
    on d.driver_id = s.driver_id
    ORDER BY s.id";
$result = mysqli_query($conn, $sql);
$output2 = "";
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    $output = "{\"station\": [";
    while($row = mysqli_fetch_assoc($result)) {

        $output2 = $output2 . "{\"id\": \"" . $row["id"]. "\", \"time\": \"" . $row["time"]. "\", \"bus_num\": \"" . $row["bus_num"]."\", \"driver\": \"" . $row["driver"]. "\", \"driver_thai\": \"" . $row["driver_thai"]."\", \"phoneNum\": \"" . $row["phoneNum"]."\", \"route\": \"" . $row["route"]."\"},";
    }
    $output2 = substr($output2, 0, -1);
    $output2 = $output2."]}";
    echo $output.$output2;
} else {
    echo "0 results";
}

mysqli_close($conn);
?>
