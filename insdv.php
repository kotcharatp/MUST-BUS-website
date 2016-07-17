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


$driver = $_POST['driver'];
$driver_thai = $_POST['driver_thai'];
$phoneNum = $_POST['phoneNum'];

$sql .= "INSERT INTO driver (driver, driver_thai, phoneNum) VALUES ('$driver','$driver_thai','$phoneNum')";


$check1 = $conn->multi_query($sql);
$sql2 = "SELECT id FROM driver";
$result = $conn->query($sql2);

?>
        <script type="text/javascript">
          window.location.href = 'driver.php';
        </script>
        <?php


  ?>

