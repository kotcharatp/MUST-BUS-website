<? require_once('includes/checkLogin.inc.php'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Language" content="th">
  <meta http-equiv="content-Type" content="text/html; charset=window-874">
  <title>New Station</title>

  <link rel="stylesheet" type="text/css" href= "style.css"  media="screen" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link href="style.css" rel="stylesheet" type="text/css" media="screen" />
  <style type="text/css"></style>

  <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
  <link href="../dist/css/sb-admin-2.css" rel="stylesheet">
  <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>

  <!-- for favicon or Icon on page -->
  <link rel="apple-touch-icon" sizes="57x57" href="layout/favicons/apple-touch-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="layout/favicons/apple-touch-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="layout/favicons/apple-touch-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="layout/favicons/apple-touch-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="layout/favicons/apple-touch-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="layout/favicons/apple-touch-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="layout/favicons/apple-touch-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="layout/favicons/apple-touch-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="layout/favicons/apple-touch-icon-180x180.png">
  <link rel="icon" type="image/png" href="layout/favicons/favicon-32x32.png" sizes="32x32">
  <link rel="icon" type="image/png" href="layout/favicons/android-chrome-192x192.png" sizes="192x192">
  <link rel="icon" type="image/png" href="layout/favicons/favicon-96x96.png" sizes="96x96">
  <link rel="icon" type="image/png" href="layout/favicons/favicon-16x16.png" sizes="16x16">
  <!-- _________________________________________________________ -->

  <!--  For sidebar menu -->
  <!-- Bootstrap Core CSS -->
  <link href="layout/bs_sidebar/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link href="layout/bs_sidebar/css/simple-sidebar.css" rel="stylesheet">
  <!-- _________________________________________________________ -->

  <!-- Bootstrap Core CSS -->
  <link href="theme/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- MetisMenu CSS -->
  <link href="theme/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="theme/dist/css/sb-admin-2.css" rel="stylesheet">

  <!-- Custom Fonts -->
  <link href="theme/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
   <!-- _________________________________________________________ -->
  <!--  For moris graph -->

   <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
  <script src="http://cdn.oesmith.co.uk/morris-0.4.1.min.js"></script>
     <!-- _________________________________________________________ -->
  <!-- For monthly average rainfall  -->
     <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
<!-- _________________________________________________________ -->
</head>

<body style="background-color: #032a47;" onload = init() >
  <?php include("layout/header.php");?>
  <?php include("layout/menu.php");?>
  <div style="margin-top: 2%; margin-left: 0%; color: white; ">
    <fieldset class="form-group" style="width: 84%; margin-left: 10%; ">
      <label align = "center" for="exampleSelect1" style="margin-left: 0%; font-size: 1.5em; font-family: Arial;">New Station</label>

    </fieldset>
  </div>
<div id="pageeditsta">
<div id="bgg">

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


$station_id = $_POST['station_id'];
$route_id = $_POST['route_id'];
$station = $_POST['station'];
$station_thai = $_POST['station_thai'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$station_order = $_POST['station_order'];

$sql .= "INSERT INTO station (station_id, route_id, station, station_thai, latitude, longitude, station_order)
        VALUES ('$station_id','$route_id','$station','$station_thai','$latitude','$longitude','$station_order')";


$check1 = $conn->multi_query($sql);

?>
<div id = "add">
  <label for="station_id">Station ID</label>
    <p align="center" ><input name="route" type="text" disabled="disabled"  id="la1" value="<?php echo $station_id ?>" /></p>
      <br />
  <label for="route_id">Route ID</label>
  <p align="center" ><input name="route" type="text" disabled="disabled"  id="la1" value="<?php echo $route_id ?>" /></p>
    <br />
  <label for="station">Station (ENG)</label>
  <p align="center" ><input name="route" type="text" disabled="disabled"  id="la1" value="<?php echo $station ?>" /></p>
    <br />
  <label for="station_thai">Station (TH)</label>
  <p align="center" ><input name="route" type="text" disabled="disabled"  id="la1" value="<?php echo $station_thai ?>" /></p>
    <br />
  <label for="latitude">Latittude</label>
  <p align="center" ><input name="route" type="text" disabled="disabled"  id="la1" value="<?php echo $latitude ?>" /></p>
    <br />
    <label for="longitude">Longitude</label>
  <p align="center" ><input name="route" type="text" disabled="disabled"  id="la1" value="<?php echo $longitude ?>" /></p>
    <br />
    <label for="station_order">Station order</label>
    <p align="center" ><input name="route" type="text" disabled="disabled"  id="la1" value="<?php echo $station_order ?>" /></p>
    <br />




</div>
<?php
  echo "<br/>";
  if ($check1 === TRUE) {
      echo '<form align="center" action="addst.php">
        <input class="btn btn-primary btn-lg" align = "center" type="submit" value = "Add more"></form>';
  } else {
     if($check1 === FALSE)
    { echo "Error: " . $sql . "<br>" . $conn->error;   }
  }

  $conn->close();
  ?>




</div>


</div> <!--rtbx-->
<?php include("layout/footer.php"); ?>
</body>
</html>
