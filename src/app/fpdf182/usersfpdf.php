<?php

require_once('../fpdf182/fpdf.php');
require_once('../functions.php');

/**
  GET 10 results for id, name email, only active users and registration date order by registration date 
 **/
$sql = "SELECT id, name, email, status > 0, registration_date FROM users ORDER BY id";
$stmt = conn()->prepare($sql);
if ($stmt->execute()) {
  $n = $stmt->rowCount();
  if ($n > 0) {
    $r = $stmt->fetchAll();
    $stmt = null;
  }
}

class PDF extends FPDF
{
  function Header()
  {
    global $nUsers;
    // Select Arial bold 15
    $this->SetFont('Arial', 'B', 30);
    // Move to the right
    $this->Cell(80);
    // Framed title
    $this->Cell(30, 10, $nUsers." active users", 0, 0, 'C');
    // Line break
    $this->Ln(20);
  }
  function Body()
  {
    $this->SetFont('Arial', '', '12');
  }
  function Footer()
  {
    //$this->Write(1, "End of list;");
    $date = date('l jS \of F Y h:i:s A');
    // Go to 1.5 cm from bottom
    $this->SetY(-15);
    // Select Arial italic 8
    $this->SetFont('Arial', 'I', 8);
    // Print centered page number
    $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 1, 'C');
    //$this->Ln();
    $this->Cell(0, 1, $date, 0, 0, 'C');
  }
}
$pdf = new PDF();

$nUsers = count($r);

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 12);
$pdf->Write(6, "Get results for id, name email, active users and registration date order by id.");
$pdf->Ln(10);
// for ($i = 1; $i <= 20; $i++)
//   $pdf->Cell(0, 5, 'Printing ' . $i, 0, 1);

/**
  Table
 **/
$y_axis_initial = 50;
$pdf->SetFillColor(232, 232, 232);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetY($y_axis_initial);
$pdf->SetX(5);
$pdf->Cell(10, 6, 'ID', 1, 0, 'L', 1);
$pdf->Cell(60, 6, 'NAME', 1, 0, 'L', 1);
$pdf->Cell(70, 6, 'EMAIL', 1, 0, 'L', 1);
$pdf->Cell(60, 6, 'REGISTRATION DATE', 1, 0, 'L', 1);

$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('Arial', '', 8);

//var_dump($r[0]);

for($i=0; $i < count($r); $i++) {

  $y_axis_initial += 5;
  if ($y_axis_initial >= 275){
    $pdf->AddPage();
    $y_axis_initial = 30;

  }
   //var_dump($y_axis_initial);
  $pdf->SetY($y_axis_initial);
  $pdf->SetX(5);
  $pdf->Cell(10, 6, $r[$i]['id'], 1, 0, 'L', 1);
  $pdf->Cell(60, 6, $r[$i]['name'], 1, 0, 'L', 1);
  $pdf->Cell(70, 6, $r[$i]['email'], 1, 0, 'L', 1);
  $pdf->Cell(60, 6, $r[$i]['registration_date'], 1, 0, 'L', 1);
  
}





$pdf->Output();
