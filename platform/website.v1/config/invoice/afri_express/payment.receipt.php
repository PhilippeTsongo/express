<?php

/**
 * @package Payment Receipt
 * @author Ezechiel Kalengya [ezechielkalengya@gmail.com] Software Engineer
 */
class myPDF extends FPDF
{
  function header() {
    // $this->Image( VIEW_LOGO_APAC2, 85,6,40);
  }
 
  function footer() {
    $this->SetY(-15);
    // $this->SetFont('cambria','B',11);
    $this->Cell(0,15,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    $this->Ln();
  }

  function viewTable() {

    # RECEIPT HEADER
    $this->SetFont('arial','B', 35);
    $this->Cell(30,5,'Invoice',0,0,'L');
    $this->SetFont('arial','B', 11);
    $this->Cell(250,5,'Goma, C.Nyirangongo, Av.Majengo No 098',0,1, 'C');
    $this->Ln();
    $this->Ln();
    $this->SetFont('arial','B',11);
    $this->Cell(10,0,'Invoice Number:   3099847646',0,0, 'L');
    $this->Cell(58,5,'_______________',0,0, 'R');

    $this->Cell(120,0,'Date:   27-10-2022',0,0, 'R');
    $this->Cell(6,5,'____________',0,1, 'R');
    $this->Ln(10);

    # RECEIPT BODY
    $this->SetFont('arial','B', 11);
    $this->SetTextColor(255,255,255);
    $this->MultiCell(190,8,' Bill To',1,1, 'L');
    $this->Ln(5);
    $this->SetTextColor(0,0,0);
    $this->SetFont('arial','', 11);
    $this->Cell(33,0,'Name:   Chishugi',0,0, 'R');
    $this->Cell(68,3,'_______________________________________',0,1, 'R');
    $this->Ln(7);
    $this->Cell(90,0,'Address:   Av. Solidarite No 56, Q.Panzi Bkv, RDC',0,0, 'R');
    $this->Cell(15,3,'_______________________________________',0,1, 'R');

    $this->Ln(7);
    $this->Cell(60,0,'Email:   cishugiluc98@gmail.com',0,0, 'R');
    $this->Cell(40,3,'_______________________________________',0,0, 'R');

    $this->Cell(55,0,'Phone:   +250 788980610',0,0, 'R');
    $this->Cell(32,3,'____________________________',0,1, 'R');
    $this->Ln(5);

    $this->SetFont('arial','B', 11);
    $this->SetTextColor(255,255,255);
    $this->MultiCell(190,8,' Products Or Service',1,1, 'L');

    $this->Ln(5);
    $this->SetTextColor(0,0,0);
    $this->SetFont('arial','B', 11);
    $this->Cell(60,8,' Description',1,0, 'L');
    $this->Cell(50,8,' Price',1,0, 'L');
    $this->Cell(40,8,' Quantity',1,0, 'L');
    $this->Cell(40,8,' Amout',1,1, 'L');

    $this->SetFont('arial','', 11);
    $this->Cell(60,8,' Soulier',1,0, 'L');
    $this->Cell(50,8,' 60000 Fc',1,0, 'L');
    $this->Cell(40,8,' 2',1,0, 'L');
    $this->Cell(40,8,' 120000 Fc',1,1, 'L');
    $this->Cell(60,8,' Pantalon',1,0, 'L');
    $this->Cell(50,8,' 20000 Fc',1,0, 'L');
    $this->Cell(40,8,' 1',1,0, 'L');
    $this->Cell(40,8,' 20000 Fc',1,1, 'L');
    $this->Cell(60,8,' Chemise',1,0, 'L');
    $this->Cell(50,8,' 10000 Fc',1,0, 'L');
    $this->Cell(40,8,' 3',1,0, 'L');
    $this->Cell(40,8,' 30000 Fc',1,1, 'L');

        // $this->SetLineWidth(0.4);
        $this->Ln();

        $this->SetFont('arial','B',9);
    
        $this->Cell(62,20,'',1,0,'L');
        // $this->Cell(0,0,'',0,1,'L');
        $this->Cell(-1,10,'We accept the following card payment:',0,1,'R');
        $this->Cell(-25,4,'MasterCard and Visa',0,1,'L');
    
        $this->SetFont('arial','B', 11);
        $this->Cell(191,0,'Sub Total:           170000 FC',0,1, 'R');
    
        $this->Ln(7);
        $this->Cell(191,0,'Tax:                              0 FC',0,1, 'R');
    
        $this->Ln(7);
        $this->Cell(191,0,'Shipping:                      0 FC',0,1, 'R');
    
        $this->Ln(7);
        $this->Cell(191,0,'Total Due:             170000 FC',0,1, 'R');
    
        $this->Ln(96);
        $this->SetFont('arial','B', 11);
        $this->SetTextColor(255,255,255);
        $this->MultiCell(190,10,'Thank you for your purchase, Powered by https://web.store.cnsplateforme.com',1,1, 'C');

  }

}
  
$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','A4',0);
$pdf->viewTable();
$pdf->Output();

 ?>
