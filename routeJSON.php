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

$sql = "SELECT * FROM route ORDER BY route_id"; 
$result = mysqli_query($conn, $sql);

$output2 = "";
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    $output = "{\"route\": [";
    while($row = mysqli_fetch_assoc($result)) {

        $output2 = $output2 . "{\"id\": \"" . $row["route_id"]. "\", \"route\": \"" . $row["route"]. "\", \"route_thai\": \"" . $row["route_thai"]."\"},";
    }
    $output2 = substr($output2, 0, -1);
    $output2 = $output2."]}";
    echo $output.$output2;
} else {
    echo "0 results";
}

mysqli_close($conn);
?>