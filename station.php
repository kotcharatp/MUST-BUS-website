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

$sql = "SELECT s.station_id, s.route_id, r.route, s.station, s.station_thai, s.latitude, s.longitude, s.station_order FROM station s INNER JOIN route r ON s.route_id = r.route_id";

$result = mysqli_query($conn, $sql);



?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Language" content="th">
    <meta http-equiv="content-Type" content="text/html; charset=window-874">
    <title>Station</title>

    <?php include("includes/headerFiles.php"); ?>


</head>

<body style="background-color: #032a47;" >
    <?php include("layout/header.php");?>
    <?php include("layout/menu.php");?>
    <div style="margin-top: 2%; margin-left: 0%; color: white; ">
      <fieldset class="form-group" align = "center" style="width: 84%; margin-left: 10%; ">

          <button class="btn btn-primary btn-lg" align = "center" type="button" onclick="location.href = '../addst.php'">Add Station</button>


      </fieldset>
  </div>

  <div id="rtbx">
      <div id="wrap">

        <div class="panel panel-default">

        <div class="panel-body" style="font-family: Arial">

                <div class="row"><div class="col-sm-12">
                     <table class="table table-striped table-bordered table-hover" id="dataTables-example" >
                        <thead>
                            <tr>
                                <th >Station ID</th>
                                <th >Route</th>
                                <th style="font-size: 20px">Station (ENG)</th>
                                <th >Station (TH)</th>
                                <th >Latittude</th>
                                <th >Longitude</th>
                                <th >Order</th>
                                <th style="font-size: 14px">Delete</th>
                                <th >Edit</th>
                            </thead>
                            <tbody>

                                <?php
                                $output2 = "";
                                if (mysqli_num_rows($result) > 0) {

                                    while($row = mysqli_fetch_assoc($result)) {
      echo "<tr>";
      echo "<td >" . $row['station_id'] . "</td>";
      echo "<td >" . $row['route'] . "</td>";
      echo "<td >" . $row['station'] . "</td>";
      echo "<td >" . $row['station_thai'] . "</td>";
      echo "<td >" . $row['latitude'] . "</td>";
      echo "<td >" . $row['longitude'] . "</td>";
      echo "<td >" . $row['station_order'] . "</td>";
      echo "<td width='5%'><a href='delete_st.php?id=".$row['route_id'].'&ids='.$row['station_id']. "'"?> onclick="return confirm('Confirm to delete?')"><img id="delbut" alt="del" src="del.png" > </a></td>
      <?  echo "<td width='5%'><a href='editst.php?routeID=".$row['route_id'].'&stationID='.$row['station_id']."'"?>><img id="editbut" alt='edit' src='editbut.png' > </a></td>
      <?
      echo "</tr>";
                                  }


                                  $output2 = substr($output2, 0, -1);
                                  echo $output2;
                              } else {
                                echo "0 results";
                            }
                            mysqli_close($conn);
                            ?>

                        </tbody>
                    </table>

                </div></div></div>
            </div>
            <!-- /.table-responsive -->

        </div> <!-- rtbx-->
        <?php include("layout/footer.php"); ?>
    </div>

    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>

    <script src="theme/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="theme/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="theme/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="theme/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="theme/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>



</body>
</html>
