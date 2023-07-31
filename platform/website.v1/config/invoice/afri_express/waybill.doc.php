<?php

/**
 * @package Shipment Receipt
 * @author Luc Chishugi [cishugiluc98@gmail.com] Software Engineer
 */
class myPDF extends FPDF
{
  function header() {
    // $this->Image( VIEW_LOGO_APAC2, 85,6,40);
  }
 
  function footer() {
    $this->SetY(-15);
    // $this->SetFont('cambria','B',11);
    $this->SetFont('arial','B', 8);
    $this->Cell(0,15,'Copyright 2023. Afri_Express - All rights reserved',0,0,'C');
    $this->Cell(0,15,'Page '.$this->PageNo().'/{nb}',0,0,'R');
    $this->Ln();
  }
  
  function viewTable() {

    

    
  }

}
  
$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','A4',0);
$pdf->viewTable();
$pdf->Output();

 ?>
