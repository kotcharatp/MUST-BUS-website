<!-- To block non admin to enter this page -->
<? require_once('includes/checkLogin.inc.php'); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Language" content="th">
<meta http-equiv="content-Type" content="text/html; charset=window-874">
<title>route</title>

<!-- Includes the css files  -->
<?php include("includes/headerFiles.php"); ?>

</head>

<body style="background-color: #032a47;" >
<?php include("layout/header.php");?>
<?php include("layout/menu.php");?>
<div style="margin-top: 2%; margin-left: 0%; color: white; ">
<fieldset class="form-group" align = "center" style="width: 84%; margin-left: 10%; ">
<!-- For the add button -->
<button class="btn btn-primary btn-lg" align = "center" type="button" onclick="location.href = '../addrt.php'">Add route</button>


</fieldset>
</div>

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

//Query route from the database 
$sql = "SELECT * FROM route";

$result = mysqli_query($conn, $sql);
?>
<div id="bgg">
<div id="wrap">
<div class="panel panel-default">
    <div class="panel-body" style="font-family: Arial">
        <div class="row">
            <div class="col-sm-12">
            <!-- The resulting route table from database -->
               <table class="table table-striped table-bordered table-hover" id="dataTables-example" >
                <thead>
                    <tr>
                        <th>Route (ENG)</th>
                        <th>Route (TH)</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </thead>
                    <tbody>

                        <?php

                        if (mysqli_num_rows($result) > 0) {

                            while($row = mysqli_fetch_assoc($result)) {
                              echo "<tr>";
                              echo "<td>" . $row['route'] . "</td>";
                              echo "<td>" . $row['route_thai'] . "</td>";

                              echo "<td width=5%><a href='delete_rt.php?id=".$row['route_id']. "'"?> onclick="return confirm('Confirm to delete?')"><img id="delbut" alt="del" src="del.png" width="50px"> </a></td>
                              <? echo "<td width=5%><a href='editrt.php?edit_id=".$row['route_id']."'"?>><img id="editbut" alt='edit' src='editbut.png' width="50px"> </a></td>
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
        </div>
        </div>
        </div>
    </div>
    <!-- /.table-responsive -->
</div> <!-- rtbx-->
</div>

<?php include("layout/footer.php"); ?>

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
