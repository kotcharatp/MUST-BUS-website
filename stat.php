<?php 

require_once('includes/checkLogin.inc.php'); 


$servername = "localhost";
$username = "atilalco_bus";
$password = "bustracker";
$dbname = "atilalco_bus";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT r.route, r.route_id FROM route r ORDER BY r.route_id";
$result = mysqli_query($conn, $sql);

$sqlTrackTime = "SELECT * FROM travel_time";
$resultTrackTime = mysqli_query($conn, $sqlTrackTime);

$sqlDay = "SELECT * FROM travel_time group by day";
$resultDay = mysqli_query($conn, $sqlDay);

$days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday"); 


?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

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
<?php
$page_title = "Travel Time Statistics";
?>


<title><?php echo $page_title; ?></title>
<link rel="stylesheet" type="text/css" href= "style.css"  media="screen" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />

<style type="text/css"></style>

<body style="background-color: #032a47;" onload = init() >




<?php include("layout/header.php");?>
<?php include("layout/menu.php");?>

<div style="margin-top: 2%; margin-left: 0%; color: white; ">
<fieldset class="form-group" style="width: 84%; margin-left: 10%; ">
<label for="exampleSelect1" style="margin-left: 0%; font-size: 1.5em; font-family: Arial;">Select Route</label>
<select class="form-control" id="exampleSelect1" onchange="plotnew(this.value)">
    <?php
        while($row = mysqli_fetch_array($result)) {
        		echo "<option value='".$row['route_id']."'> ".$row['route']." </option>"; 	   
        }
    ?>
</select>
</fieldset>

</div>

</div>


<div style="margin-top: 2%; margin-left: 14%" >
<!-- <div id="area-example" style="width: 75%; height: 50%; margin-left: 7%"></div> -->
<div id="graph" style="width: 97%; height: 70%; margin: 0 auto"></div>
</div>

<?php include("layout/footer.php"); ?>


<script type="text/javascript">

function init(){
plotnew(1);
}

function plotnew(routeID){
var category = []; 
var serie = []; 
var allData = []; 


<?php
$timeArray = array(); 

if(mysqli_num_rows($resultTrackTime) > 0 ){
	while($row = mysqli_fetch_assoc($resultTrackTime)){
        $routeID = $row['route_id'];
        $timeleave = $row['time_leave'];
		echo "if(routeID == ".$routeID."){";
		echo "var isIn = category.indexOf('".$timeleave."');";
		//echo "console.log(isIn);";
		//echo "console.log('".$timeleave."');";
		echo "if(isIn == -1){";
		//echo "console.log('".$timeleave."');";
		echo "	category.push('".$row['time_leave']."');
			}";
        echo "  allData.push({
                    day : '".$row['day']."',
                    timeLeave : '".$row['time_leave']."',
                    timeTravel : '".$row['time_travel']."'
            });";
        echo "}
        ";
    }
}
	
?>
 day = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
 day = [{
    day: 'Monday',
    color: 'gold'
 }, {
    day: 'Tuesday',
    color: 'hotpink'
 }, {
    day: 'Wednesday',
    color: 'lime'
 },{
    day: 'Thursday',
    color: 'orange'
 },{
    day: 'Friday',
    color: 'CornflowerBlue'
 }];

for(j=0; j<day.length; j++){
	var dataTravel = [];
	var travel = 0;
	for(k=0; k<category.length; k++){
		for(i=0;i<allData.length;i++){
			if(allData[i].day == day[j].day && allData[i].timeLeave == category[k]){
				// if(allData[i].timeLeave == category[k]){
				travel = parseInt(allData[i].timeTravel);
			}
		}

		if(travel!=0){
			dataTravel.push(parseInt(travel));
			travel = 0;
		} else {
			dataTravel.push(parseInt(0));
		}
		
	}
	console.log(day[j].day);
	console.log(dataTravel);
	serie.push({
        name : day[j].day,
        data : dataTravel,
        color: day[j].color

   });
};


console.log(serie);

for(i=0;i<allData.length;i++){
   //employees[i].id
}


$("#graph").empty()
$(function () {
$('#graph').highcharts({
    chart: {
        type: 'column'
    },
    title: {
        text: 'Travel Time Statistics'
    },
    subtitle: {
        text: 'Source: bus.atilal.com'
    },
    xAxis: {
        categories: category,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Travel Time (minutes)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:20px; margin-left:-120px;">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} mins</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: serie
});
});


}


</script>


</body>
</html>


