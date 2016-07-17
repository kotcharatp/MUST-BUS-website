<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Delete Station</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">

<style type="text/css"></style>
</head>

<body>
    <div id="wrapper">
      <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

          <div class="navbar-default sidebar" role="navigation">

              <!-- /.sidebar-collapse -->
          </div>
          <!-- /.navbar-static-side -->
      </nav>

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
  $ids = $_GET['ids'];

  $sql = "DELETE FROM station WHERE station_id='$ids' AND route_id='$id' ";

  if ($conn->query($sql) === TRUE) {
      echo "Record deleted successfully";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
?>
        <script type="text/javascript">
          window.location.href = 'station.php';
        </script>
        <?php
        

  ?>


</body>
</html>
