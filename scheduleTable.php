<?php
require_once('includes/checkLogin.inc.php');
// require('fpdf181/fpdf.php');

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

$sql = "SELECT * FROM route ORDER BY route_id";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Language" content="th">
<meta http-equiv="content-Type" content="text/html; charset=window-874">
<title>Homepage</title>

<?php include("includes/headerFiles.php"); ?>


</head>

<title><?php echo $page_title; ?></title>

<body style="background-color: #032a47;" ng-app="myApp" ng-controller="customersCtrl" >

<?php include("layout/header.php");?>
<?php include("layout/menu.php");?>

<div style="margin-top: 2%; margin-left: 0%; color: white; ">
<fieldset class="form-group" align = "center" style="width: 84%; margin-left: 10%; ">

<label for="exampleSelect1" style="margin-left: 0%; font-size: 1.5em; font-family: Arial;">Select Route</label>

<!-- Dropdown for route  -->
<select ng-model='searchString' class="form-control" name="users" id="exampleSelect1" >
<option ng-selected="true" value="">All route</option>

<?php
while($row = mysqli_fetch_array($result)) {
	if($row['route_id']==1){
		echo "<option value='".$row['route']."'> ".$row['route']." </option>";
	} else {
		echo "<option value='".$row['route']."'> ".$row['route']." </option>";
	}
}
?>
</select>


<!-- If user is admin, he or she add add schedule
 --><?php if($uid == true): ?>
<button class="btn btn-primary btn-lg" align = "center" type="button" onclick="location.href = '../addsh.php'">Add Schedule</button>
<?php endif ?>

</fieldset>
</div>

<div id="rtbx">
<div id="wrap">
<div id="seroute">

 <div class="panel panel-default" style="font-family: Arial"> 
  <div class="panel-body">
  <div class="row">
  <div class="col-sm-12">
    <table class="table table-striped table-bordered table-hover" >
    <thead>
        <tr>
          <th  style="width: 100px;">Time</th>
          <th  style="width: 50px; ">Bus number</th>
          <th  style="width: 100px; ">Driver (EN)</th>
          <th  style="width: 100px; ">Driver (TH)</th>
          <th  style="width: 100px; ">Phone Number</th>

          <?php if($uid == true): ?>
          <th  style="width: 100px; ">Delete</th>
          <th  style="width: 100px; ">Edit</th>
          <?php endif ?>

        </tr>
   
    <tbody>
    <tr ng-repeat="x in myData | searchFor:searchString" >
    	<td> {{x.time}}</td>
		<td> {{x.bus_num}}</td>
		<td> {{x.driver}}</td>
		<td> {{x.driver_thai}}</td>
		<td> {{x.phoneNum}}</td>

<!-- If user is admin he or she can edit and delete schedule -->
		<?php if($uid == true): ?>
		<td width=5%><a href='delete_sch.php?id={{x.id}}' onclick="return confirm('Confirm to delete?')"><img id="delbut" alt="del" src="del.png" > </a></td>
		<td width=5%><a href='edit_sch.php?edit_id={{x.id}}'><img id="editbut" alt='edit' src='editbut.png' > </a></td>
		<?php endif ?>
		</tr>

    </tbody>
      </thead>
  </table>
  </div>
  </div>
  </div>
  </div>

<!-- BUTTONS FOR GENERATE PDF AND EXCEL -->
<div align="left">
	<form action="generatePDF.php">
		<input type="submit" value="Generate PDF" class="btn btn-primary">
	</form>
</div>

<?php include("layout/footer.php"); ?>
</div>
</div>
</div> <!-- rtbx-->



</div> <!-- container-->

<!-- DataTables JavaScript -->
<script src="theme/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="theme/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>



<script>
$(document).ready(function() {
$('#dataTables-example').DataTable({
	responsive: true
});
});



        var app = angular.module('myApp', []);

        app.controller('customersCtrl', function($scope, $http) {
            $scope.myData = [];
            $http.get("http://bus.atilal.com/schedule.php").then(function (response) {
                $scope.myData = response.data.station;

            });           

          
            
        });

        app.filter('searchFor', function(){
    	return function(arr, searchString){
    		console.log(searchString);
        if(!searchString){
            return arr;
        }
        var result = [];
        angular.forEach(arr, function(item){
            if(item.route==searchString)
            {
                result.push(item);
   
            }
        }); 
        return result;
    };
});

</script>
</body>
</html>
