<?php

/**
 * @package Ticket Qr
 * @author Ezechiel Kalengya [ezechielkalengya@gmail.com] Software Engineer
 */
class myPDF extends FPDF
{
  function header() {
  //  $this->Image( VIEW_LOGO_, 162  ,8,43);
        
  }

  function footer() {
    $this->SetY(-15);
    $this->SetFont('arial','B',11);
    $this->Cell(0,15,'Page '.$this->PageNo().'/{nb}',0,0,'C');
  }

  function viewTable() {  
    // $this->SetFont('arial','B', 12);
    // $this->Cell(0,5, 'RWANDA GOSPEL STARS LIVE - TICKETS REGULAR', 0, 1,'C');

    # Ticket Qr

    # List QR 0 - 150 | 151 - 300 - VIP
    // $_limit_condition_ = " LIMIT 0, 50 "; // Day 1 2 # 1st Batch # DONE
    // $_limit_condition_ = " LIMIT 50, 25 "; // Day 1 # 2nd Batch # DONE
    // $_limit_condition_ = " LIMIT 0, 25 "; // Day 2 # 2nd Batch # DONE

    # List QR 0 - 1500 | 1501 - 3000 - VVIP
    //  $_limit_condition_ = " LIMIT 0, 50 "; // 3 # 1st Batch # DONE
    //  $_limit_condition_ = " LIMIT 50, 24 "; // day 1 # 2nd Batch #  Mtn
    //  $_limit_condition_ = " LIMIT 74, 16 "; // day 1 # 3Rd Batch #  AMSTEL
      // $_limit_condition_ = " LIMIT 0, 17 "; // day 2 # 2nd Batch #  Mtn
      // $_limit_condition_ = " LIMIT 17, 16 "; // day 2 # 2nd Batch #  AMSTEL

    # List QR 0 - 3000 | 3001 - 6000 - REGULAR
  //  $_limit_condition_ = " LIMIT 0, 500 "; // day 1 # 2nd Batch #  Mtn
    //  $_limit_condition_ = " LIMIT 500, 50 "; // day 1 # 3Rd Batch #  AMSTEL
      // $_limit_condition_ = " LIMIT 0, 500 "; // day 2 # 2nd Batch #  Mtn
        $_limit_condition_ = " LIMIT 500, 50 "; // day 2 # 3Rd Batch #  AMSTEL


    $_condition  = " AND val_campain_ticket.ID =  9 AND event_day_ID = 6 ";
    $_data_table = TicketPurchaseController::getTicketsPurchase($_condition, $_limit_condition_ );

    if($_data_table):
      $count=0;
      $_Y_IMAGE_TICKET_  = 10;
      $_Y_IMAGE_QR_      = 34.5;
      $_Y_QR_CODE_       = 0;
      foreach($_data_table as $ticket_):
        $count++;

        /** Handle Qr COde */
        $_qrID_		   = $ticket_->qr_ID;
        $_qrEncoded_ = $ticket_->qr_string;
        $_qrFilename_= $_qrID_.".png";

        if($count == 6 ):
          // $this->PageNo();
          // $_Y_IMAGE_TICKET_ += -250;
          // $_Y_IMAGE_QR_     += -250;
          // $_Y_QR_CODE_         += 250;
          // $this->Ln(-450);
          // $this->Cell(0,50,'',0,1,'L');

        endif;

        $_TICKET_DESIGN_IMAGE_ = ROOT_TICKET_DESIGN_IMAGE.'/ATHF.REGULAR.DAY2.png';
        $_POWERED_BY_IMAGE_ = ROOT_TICKET_DESIGN_IMAGE.'powered_tchaptchap2.jpg';
        $_TICKET_QR_IMAGE_     = ROOT_TICKET_QR_IMAGE.$_qrFilename_;
    
        $this->Ln(45);
        $this->SetFont('arial', 'B', 4);
        // $this->Cell(0,50,'',0,1,'L');
        $this->Image( $_TICKET_DESIGN_IMAGE_, 23, $_Y_IMAGE_TICKET_, 150, 64);
        $this->Image( $_TICKET_QR_IMAGE_, 125.5,  $_Y_IMAGE_QR_, 22.5, 22.5);
        $this->Image( $_POWERED_BY_IMAGE_, 146.58,  $_Y_IMAGE_QR_+17.5, 11, 5.2);
        $this->Cell(0, $_Y_QR_CODE_ , '', 0, 1, 'L');
        $this->Cell(119.9, 0, '', 0, 0, 'L');
        $this->Cell(20, 2 , $_qrID_, 0, 1,'');
        $this->Ln(23);

        $_Y_IMAGE_TICKET_ += 70;
        $_Y_IMAGE_QR_     += 70;
        
        // if($count >= 0 && $count<=5):
        //   if($count%2 == 1)
        //     $_Y_QR_CODE_    += 18.9;

        //   if($count ==3 )
        //     $_Y_QR_CODE_    = -3.9;

        //   if($count > 3 )
        //     $_Y_QR_CODE_    += -0.4;
        // endif;
        
        if($count%4 == 0):
          // $this->PageNo();
          // $_Y_IMAGE_TICKET_ += 50;
          // $_Y_IMAGE_QR_     += -250;
          // $_Y_QR_CODE_      += 0;
          // $this->Ln(25);
          // $this->Ln(26);
          $this->Cell(0, 43, '', 0, 1, 'L');
          $this->Cell(0, -43, '', 0, 1, 'L');
          $_Y_IMAGE_TICKET_  = 10;
          $_Y_IMAGE_QR_      = 34.5;
          $_Y_QR_CODE_       = 0;
          // $this->Ln(4);

        endif;
          // $this->Cell(0,250,'',0,1,'L');

      endforeach;
    endif;
    
  }

}

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','A4',0);
$pdf->viewTable();

//ob_end_clean();
$pdf->Output();
//ob_end_flush();

 ?>
