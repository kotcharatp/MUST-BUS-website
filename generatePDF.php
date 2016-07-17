<?php
require('fpdf181/fpdf.php');

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

class PDF extends FPDF
{
	// Page header
	function Header()
	{
		// Logo
		$this->Image('logo.png',10,6,20);
		// Arial bold 15
		$this->SetFont('Arial','B',15);
		// Move to the right
		$this->Cell(45);
		// Title
		$this->Cell(100,10,'MUST BUS TIMETABLE',1,0,'C');
		// Line break
		$this->Ln(25);
	}
}

//create PDF
//for both 2 routes
$pdf = new PDF();
// Column headings
$header = array('Route', 'Bus Number', 'Driver', 'Phone Number');
// Data loading
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
while($row = mysqli_fetch_array($result))
{
    // Info
    $pdf->Cell(160,7,$row['route'],0);
    $pdf->Ln();
    
    //GENERATE THE FANCY TABLE
    // Colors, line width and bold font
	$pdf->SetFillColor(0,0,100);
	$pdf->SetTextColor(255);
	$pdf->SetDrawColor(0,0,80);
	$pdf->SetLineWidth(.3);
	$pdf->SetFont('','B');
	// Header
	$w = array(35, 35, 50, 50);
	for($i=0;$i<count($header);$i++)
		$pdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
	$pdf->Ln();
	// Color and font restoration
	$pdf->SetFillColor(224,235,255);
	$pdf->SetTextColor(0);
	$pdf->SetFont('');
	
	// Data
	$fill = false;
	$sql2 = "SELECT s.id, s.time, s.bus_num, d.driver, d.driver_thai, d.phoneNum
	FROM schedule s
	INNER JOIN route r
	ON s.route_id = r.route_id
	INNER JOIN driver d
	ON d.driver_id = s.driver_id
	WHERE s.route_id = '".$row['route_id']."'
	ORDER BY s.id ASC";
	$result2 = mysqli_query($conn,$sql2);
	while($row2 = mysqli_fetch_array($result2))
	{
	    // User
	    $pdf->Cell($w[0],6,$row2['time'],'LR',0,'L',$fill);
		$pdf->Cell($w[1],6,number_format($row2['bus_num']),'LR',0,'L',$fill);
		$pdf->Cell($w[2],6,$row2['driver'],'LR',0,'R',$fill);
		$pdf->Cell($w[3],6,$row2['phoneNum'],'LR',0,'R',$fill);
		$pdf->Ln();
		$fill = !$fill;
	}
	$pdf->Cell(array_sum($w),0,'','T');
	$pdf->Ln(10);

}
$pdf->Output();
?>
