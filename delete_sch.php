
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

  $id = $_GET['id'];

  $sql = "DELETE FROM schedule WHERE id='".$id."'";

  if ($conn->query($sql) === TRUE) {
      echo "Record deleted successfully.";

  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();

  header("Location: scheduleTable.php");

  ?>


