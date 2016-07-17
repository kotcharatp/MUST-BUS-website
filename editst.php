<? require_once('includes/checkLogin.inc.php'); ?>
<?
// Configurate database information 
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

    if($_POST['Edit'])
    {

      $station_id = $_POST['station_id'];
      $route_id = $_POST['route_id'];
      $station = $_POST['station'];
      $station_thai = $_POST['station_thai'];
      $latitude = $_POST['latitude'];
      $longitude = $_POST['longitude'];
      $station_order = $_POST['station_order'];


    // Edit information 

    $sql_edit = "UPDATE station st SET st.station_id = '$station_id' , st.route_id = '$route_id', st.station = '$station', st.station_thai = '$station_thai', st.latitude = '$latitude', st.longitude = '$longitude', st.station_order = '$station_order' WHERE st.route_id = '$route_id' AND st.station_id = '$station_id'";

    mysqli_query($conn, $sql_edit);
    
    ?>
    <script type="text/javascript">
          window.location.href = 'station.php';
        </script>
        <?php

}

//Call information to show on the textbox
if($_REQUEST['routeID'] != "")
{
  $routeID = $_REQUEST['routeID'];
  $stationID = $_REQUEST['stationID'];
  $sql = "SELECT * FROM station st WHERE st.route_id='$routeID' AND st.station_id = '$stationID'";
  $result = mysqli_query($conn, $sql);
  $rowRE = mysqli_fetch_array($result);

}
//--->
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Language" content="th">
  <meta http-equiv="content-Type" content="text/html; charset=window-874">
  <title>Edit station</title>

  <!-- Include css files  -->
  <?php include("includes/headerFiles.php"); ?>
  </head>

  <body style="background-color: #032a47;" >
    <?php include("layout/header.php");?>
    <?php include("layout/menu.php");?>

    <div style="margin-top: 2%; margin-left: 0%; color: white; ">
      <fieldset class="form-group" style="width: 84%; margin-left: 10%; ">
        <label align = "center" for="exampleSelect1" style="align: center; font-size: 2em; font-family: Arial;">Edit Station</label>

      </fieldset>
    </div>

<div id="pageeditsta">
    <div id="bgg">



  <div id = "add">
<form action="editst.php" method="post">
  <label for="station_id">Station ID</label>
    <p align="center">
    <input name="station_id" type="text"  id = "la1"  value="<?=$rowRE['station_id']?>" /></p>

<br />

<label for="route_id">Route</label>
<p align="center"><select name = "route_id" id = "la1" value="<?=$row['route_id']?>">

  <?php
  $sql = "SELECT * FROM route";
  $result = mysqli_query($conn, $sql);

  while($row = mysqli_fetch_array($result)) {
    if($row['route_id'] == $routeID){
      echo "<option selected='selected' value='".$row['route_id']."'> ".$row['route']."</option>";
    } else{
      echo "<option value='".$row['route_id']."'> ".$row['route']."</option>";
    }
    
  }
  ?>
</select></p>
<br />
<label for="station">Station (ENG)</label>
      <p align="center"><input  name="station"  type="text" id = "la1" value="<?=$rowRE['station']?>" /></p>
<br />
<label for="station_thai">Station (TH)</label>
   <p align="center"><input  name="station_thai"  type="text" id = "la1" value="<?=$rowRE['station_thai']?>" /></p>
<br />
<label for="latitude">Latittude</label>
      <p align="center"><input name="latitude"  type="text" id = "la1" value="<?=$rowRE['latitude']?>"/></p>
<br />
<label for="longitude">Longitude</label>
 <p align="center"><input name="longitude"  type="text" id = "la1" value="<?=$rowRE['longitude']?>"/></p>
<br />
<label for="station_order">Station order</label>
     <p align="center"><input name="station_order"  type="text" id = "la1" value="<?=$rowRE['station_order']?>"/></p>
<br />
<p id= "sub" align="center">
<input class="btn btn-primary btn-lg" align = "center" onclick="return confirm('Confirm to Edit?')" type="submit" name="Edit" id="submitbut" value="Edit" />
</p>
<input name="edit_id" type="hidden" id="edit_id" value="<?=$_REQUEST['edit_id']?>" />


</form>
</div>

</div> <!--bbg-->

</div>

<?php include("layout/footer.php"); ?>

</body>
</html>
