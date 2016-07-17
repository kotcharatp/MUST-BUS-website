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


$route1 = $_POST['route_1'];
$route2 = $_POST['route_2'];
$route1 = $route1 . " to " . $route2;
$route_thai1 = $_POST['route_thai_1'];
$route_thai2 = $_POST['route_thai_2'];
$route_thai1 = $route_thai1 . " ไป " . $route_thai2;

$route_thai = $_POST['route_thai'];

$sql .= "INSERT INTO route (route, route_thai) VALUES ('$route1','$route_thai1')";
$check1 = $conn->multi_query($sql);
?>
        <script type="text/javascript">
          window.location.href = 'route.php';
        </script>
        <?php

?>

  $conn->close();
  ?>

