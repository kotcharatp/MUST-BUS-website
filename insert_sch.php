<? require_once('includes/checkLogin.inc.php'); ?>
<!DOCTYPE html>
<html>
<head>
</head>

<body>
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



$time = $_POST['time'];
$bus_num = $_POST['bus_num'];
$driver_id = $_POST['driver_id'];
$route_id = $_POST['route_id'];
$driver = $_POST['driver'];
$driver_thai = $_POST['driver_thai'];
$phoneNum = $_POST['phoneNum'];
$route_thai = $_POST['route_thai'];
$route = $_POST['route'];

$sql3 = "SELECT r.route FROM route r GROUP BY r.route";
$sql4 = "SELECT d.driver FROM driver d GROUP BY d.driver";
$result = mysqli_query($conn, $sql3);
$result = mysqli_query($conn, $sql4);

$sql = "INSERT INTO schedule s (s.time, s.bus_num, s.driver_id, s.route_id ) VALUES ('$time','$bus_num','$driver_id','$route_id');";
$sql .= "INSERT INTO driver d (d.driver, d.driver_thai, d.phoneNum) VALUES ('$driver','$driver_thai', '$phoneNum');";
$sql .= "INSERT INTO route d (r.route, r.route_thai) VALUES ('$route','$route_thai')";


$check1 = $conn->multi_query($sql);
$sql2 = "SELECT id FROM schedule";
$sql3 = "SELECT r.route FROM route r GROUP BY r.route";
$sql4 = "SELECT d.driver FROM driver d GROUP BY d.driver";
$result = mysqli_query($conn, $sql3);
$result = mysqli_query($conn, $sql4);
$result = $conn->query($sql2);


    echo "<br/>";
    if ($check1 === TRUE) {
        echo '<form action="add.php"><input type="submit" value = "Press to add more info"></form>';
        echo '<form action="qq.php"><input type="submit" value = "Back to main page"></form></span>';
    } else {
       if($check1 === FALSE)
      { echo "Error: " . $sql . "<br>" . $conn->error;   }
    }




    $conn->close();
    ?>

    <div class = "addschedule">
    <p>Time: <span style= "text-decoration: underline"> <?php echo $time ?> </span> </p>
    <p>bus_num: <span style= "text-decoration: underline"> <?php echo $bus_num ?> </span> </p>
    <p>Route:
      <select name='route' ;
      <?php

      while($row = mysqli_fetch_array($result)) {
          echo "<option value='".$row['route_id']."'>".$row['route']."</option>";
      }
      echo "</select>";
  ?>
    <p>Driver:
      <select name='driver' ;
          <?php

          while($row = mysqli_fetch_array($result)) {
              echo "<option value='".$row['driver_id']."'>".$row['driver']."</option>";
          }
          echo "</select>";
      ?>
  </div>
</body>
</html>
