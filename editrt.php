<? require_once('includes/checkLogin.inc.php'); ?>

<?
// Database configuration
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

$route = $_POST['route'];
$route_thai = $_POST['route_thai'];
$route_id = $_REQUEST['edit_id'];

// Edit existing information 

$sql_edit = "UPDATE route r
SET r.route = '$route' , r.route_thai = '$route_thai'
WHERE r.route_id = '$route_id'";
mysqli_query($conn, $sql_edit);
?>
        <script type="text/javascript">
          window.location.href = 'driver.php';
        </script>
        <?php

//-->
}

//Get selected information to fill in textbox
if($_REQUEST['edit_id'] != "")
{
  $route_id = $_REQUEST['edit_id'];
  $sql = "SELECT * FROM route r WHERE r.route_id='$route_id'";
  $result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

}
//--->
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Language" content="th">
  <meta http-equiv="content-Type" content="text/html; charset=window-874">
  <title>route</title>

  <?php include('includes/headerFiles.php') ?>
  </head>

  <body style="background-color: #032a47;" >
    <?php include("layout/header.php");?>
    <?php include("layout/menu.php");?>

    <div style="margin-top: 2%; margin-left: 0%; color: white; ">
      <fieldset class="form-group" style="width: 84%; margin-left: 10%; ">
        <label align = "center" for="exampleSelect1" style="align: center; font-size: 2em; font-family: Arial;">Edit Route</label>

      </fieldset>
    </div>

<div id="bgggg">
    <div id="bgg">



  <div id = "add">
<form action="editrt.php" method="post">
  <label for="route">Route (EN)</label>
  <p align="center"><input name="route" type="text" id="la1" value="<?=$row['route']?>" /></p>
<br />
<label for="route_thai">Route (TH)</label>
  <p align="center"><input name="route_thai" type="text" id="la1" value="<?=$row['route_thai']?>" /></p>
<br />

<p id= "sub" align="center">
<input class="btn btn-primary btn-lg" onclick="return confirm('Confirm to Edit?')" align = "center" type="submit" name="Edit" id="submitbut" value="Edit" />

</p>
<input name="edit_id" type="hidden" id="edit_id" value="<?=$_REQUEST['edit_id']?>" />


</form>

</div>

</div> <!--bbg-->
</div>


<?php include("layout/footer.php"); ?>

</body>
</html>
