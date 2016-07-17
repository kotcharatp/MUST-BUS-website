<? require_once('includes/checkLogin.inc.php'); ?>
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


$time1 = $_POST['time_1'];
$time2 = $_POST['time_2'];
$time1 = $time1 . ":" . $time2;

$bus_num = $_POST['bus_num'];
$driver = $_POST['driver'];
$driver_id = $_POST['driver_id'];
$route_id = $_POST['route_id'];
$driver_thai = $_POST['driver_thai'];
$phoneNum = $_POST['phoneNum'];
$route = $_POST['route'];


$sql .= "INSERT INTO schedule (time, bus_num, driver_id, route_id) VALUES ('$time1','$bus_num','$driver_id','$route_id')";
$check1 = $conn->multi_query($sql);

?>
    <script type="text/javascript">
          window.location.href = 'scheduleTable.php';
        </script>
        <?php


?>
