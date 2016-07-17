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

// Find information according to the schedule id send for set default in editbox
if($_REQUEST['edit_id'] != "")
{
	$id = $_REQUEST['edit_id'];
	$sql = "SELECT s.id, s.time, s.bus_num, d.driver_id, d.driver, r.route, s.driver_id, r.route_id
	FROM schedule s
	INNER JOIN route r
	ON s.route_id = r.route_id
	INNER JOIN driver d
	ON d.driver_id = s.driver_id
	WHERE s.id='$id'";
	$result = mysqli_query($conn, $sql);
	$rowRE = mysqli_fetch_array($result);

}

// Update information according to the data in form 
			if($_POST['Edit'])
			{

				$time = $_POST['time_id'];
				$bus_num = $_POST['bus_num'];
				$driver_id = $_POST['driver_id'];
				$route_id = $_POST['route_id'];
				$id = $_REQUEST['edit_id'];

				$sql_edit = "UPDATE schedule s
				JOIN route r
				ON s.route_id = r.route_id
				JOIN driver d
				ON d.driver_id = s.driver_id
				SET s.time = '".$time."' ,
				s.bus_num = '".$bus_num."',
				s.driver_id = '".$driver_id."',
				s.route_id = '".$route_id.
				"' WHERE s.id = ".$id;

				mysqli_query($conn, $sql_edit);

				?>
				<script type="text/javascript">
					window.location.href = 'main_sch.php';
				</script>
				<?php

			}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Language" content="th">
	<meta http-equiv="content-Type" content="text/html; charset=window-874">
	<title>Edit schedule</title>

	<!-- Include css files  -->
	<?php include("includes/headerFiles.php"); ?>


</head>

<body style="background-color: #032a47;" >
	<?php include("layout/header.php");?>
	<?php include("layout/menu.php");?>

	<div style="margin-top: 2%; margin-left: 0%; color: white; ">
		<fieldset class="form-group" style="width: 84%; margin-left: 10%; ">
			<label align = "center" for="exampleSelect1" style="margin-left: 0%; 
			font-size: 2em; font-family: Arial;">Edit Schedule</label>
		</fieldset>
	</div>


	<div id="pageeditdri">
		<div id="bgg">
			<div id = "add">
				<form action="edit_sch.php" method="post">
					<label for="time">Time</label>
						<p align="center">
							<input name="time_id" type="text" id="la1" value="<?=$rowRE['time']?>" />
						</p>
					<br/>

					<label for="bus_num">Bus number</label>
					<p align="center"><select name = "bus_num" id = "la1" value="<?=$row['bus_num']?>">

						<?php
						$sql = "SELECT s.bus_num, s.id FROM schedule s GROUP BY s.bus_num";
						$result = mysqli_query($conn, $sql);

						while($row = mysqli_fetch_array($result)) {
							// echo "<script> console.log('bus num ".$rowRE['bus_num']."'); </script>";
							if($rowRE['bus_num'] == $row['bus_num']){
								//Set default from the passed value
								echo "<option selected = \"selected\" value='".$row['bus_num']."'> ".$row['bus_num']."</option>";
							} else {
								echo "<option value='".$row['bus_num']."'> ".$row['bus_num']."</option>";
							}
							
						}
						?>
					</select></p>
					<br />

					<label for="driver">Driver</label>
					<p align="center"><select name = "driver_id" id = "la1" value="<?=$row['driver']?>">

						<?php
						$sql = "SELECT d.driver, d.driver_id FROM driver d GROUP BY d.driver";
						$result = mysqli_query($conn, $sql);

						while($row = mysqli_fetch_array($result)) {
							if($rowRE['driver_id'] == $row['driver_id']){
								echo "<option selected = 'selected' value='".$row['driver_id']."'> ".$row['driver']."</option>";
							} else {
								echo "<option value='".$row['driver_id']."'> ".$row['driver']."</option>";
							}

						}
						?>
					</select></p>
					<br />

					<label for="route">Route</label>
					<p align="center"><select name = "route_id" id = "la1" value="<?=$row['route']?>">

						<?php
						$sql = "SELECT r.route, r.route_id FROM route r GROUP BY r.route";
						$result = mysqli_query($conn, $sql);

						while($row = mysqli_fetch_array($result)) {

							if($rowRE['route_id'] == $row['route_id']){
								echo "<option selected = 'selected' value='".$row['route_id']."'> ".$row['route']."</option>";
							} else {
								echo "<option value='".$row['route_id']."'> ".$row['route']."</option>";
							}
						}
						
						?>
					</select></p>


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
