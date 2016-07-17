<? require_once('includes/checkLogin_admin.inc.php'); ?>
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


  $sql = "SELECT * FROM driver";
  $result = mysqli_query($conn, $sql);
  ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Language" content="th">
  <meta http-equiv="content-Type" content="text/html; charset=window-874">
  <title>Driver</title>

  <?php include("includes/headerFiles.php"); ?>

  <!-- MetisMenu CSS -->
  <link href="theme/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="theme/dist/css/sb-admin-2.css" rel="stylesheet">

  <!-- Custom Fonts -->
  <link href="theme/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- _________________________________________________________ -->

</head>

<body style="background-color: #032a47;" >
  <?php include("layout/header.php");?>
  <?php include("layout/menu.php");?>
  <div style="margin-top: 2%; margin-left: 0%; color: white; ">
    <fieldset class="form-group" align = "center" style="width: 84%; margin-left: 10%; ">
      <button class="btn btn-primary btn-lg" align = "center" type="button" onclick="location.href = '../adddv.php'">Add Driver</button>
    </fieldset>
  </div>


  <div id="bgg">
    <div id="wrap">
      <div class="panel panel-default">

         <div class="panel-body" style="font-family: Arial">

          <div class="row"><div class="col-sm-12">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example" >
              <thead>
                <tr role="row" >
                  <th width="10%">Driver (ENG)</th>
                  <th width="10%">Driver (TH)</th>
                  <th width="10%">Phone number</th>
                  <th width="10%">Delete</th>
                  <th >Edit</th>
                </thead>
                <tbody>

                  <?php
                 
                  if (mysqli_num_rows($result) > 0) {

                    while($row = mysqli_fetch_assoc($result)) {

                      echo "<tr>";
                      echo "<td >" . $row['driver'] . "</td>";
                      echo "<td >" . $row['driver_thai'] . "</td>";
                      echo "<td >" . $row['phoneNum'] . "</td>";
                      echo "<td width='10%' ><a href='delete_dv.php?id=".$row['driver_id']. "'"?> onclick="return confirm('Confirm to delete?')"><img id="delbut" alt="del" src="del.png" width="50px"> </a></td>
                      <?  echo "<td width='10%' ><a href='editdv.php?edit_id=".$row['driver_id']."'"?>><img id="editbut" alt='edit' src='editbut.png'  width="50px" > </a></td>
                      <?
                      echo "</tr>";
                    } 
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
          <?php include("layout/footer.php");?>
        </div> <!-- rtbx-->

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


      <?php include("layout/footer.php"); ?>

    </body>
    </html>
