<?php 
	require('fpdf.php');
	echo "hello world";

	class PDF extends FPDF
	{
	}

	$pdf = new PDF();
	$pdf->Output();
?>