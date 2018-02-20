<?php
require('fpdf.php');

$name = "aaaaaaaaaaaaaa";

$pdf = new FPDF('P', 'pt', array(1000, 1000));

$pdf->AddPage();

$pdf->Image('tutorial/logo_pb.png', 0, 0, 1000, 1000);

$pdf->SetFont('Arial', 'B', 23);

$pdf->Text(500, 457, $name);

$pdf->Text(500, 1268, date('jS F Y'), $row['when']);

$pdf->Output();

?>
