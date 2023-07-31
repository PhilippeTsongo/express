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
    $_limit_condition_ = " LIMIT 0, 50 "; //  # DONE
    // $_limit_condition_ = " LIMIT 50, 25 "; // # DONE

    $_event  = Input::get('event', 'post');
    $_ticket = Input::get('ticket', 'post');
    $_number = Input::get('number', 'post');
 
    $_condition  = " AND cns_event_participants.event = $_event AND cns_event_participants.ticket = $_ticket ORDER BY cns_event_participants.id ASC";
    $_data_table = CNS_EVENT_Controller::get_event_physical_ticket_list($_condition );

    if($_data_table):
      $count=0;
      $_Y_IMAGE_TICKET_  = 3;
      $_Y_IMAGE_QR_      = 15;
      $_Y_QR_CODE_       = 0;
      foreach($_data_table as $ticket_):
        $ticket_ = (object) $ticket_;
        $count++;

        /** Handle Qr COde */
        $_qrID_		   = $ticket_->code;
        $_qrEncoded_ = $ticket_->code_string;
        $_qrFilename_= $_qrID_.".png";

        if($count == 6 ):
          // $this->PageNo();
          // $_Y_IMAGE_TICKET_ += -250;
          // $_Y_IMAGE_QR_     += -250;
          // $_Y_QR_CODE_         += 250;
          // $this->Ln(-450);
          // $this->Cell(0,50,'',0,1,'L');

        endif;

        $_TICKET_DESIGN_IMAGE_ = ROOT_TICKET_DESIGN_IMAGE.'/TICKET_VIP_001.png';
        $_POWERED_BY_IMAGE_ = ROOT_TICKET_DESIGN_IMAGE.'powered_by_cns_plateforme.png';
        $_TICKET_QR_IMAGE_     = ROOT_TICKET_QR_IMAGE.$_qrFilename_;
    
        $this->Ln(29.4);
        $this->SetFont('arial', 'B', 4.5);
        // $this->Cell(0,50,'',0,1,'L');
        $this->Image( $_TICKET_DESIGN_IMAGE_, 10, $_Y_IMAGE_TICKET_, 185, 49);
        $this->Image( $_TICKET_QR_IMAGE_, 155,  $_Y_IMAGE_QR_, 26.6, 26.6);
        $this->Image( $_POWERED_BY_IMAGE_, 154.5  ,  $_Y_IMAGE_QR_+29, 30, 8);
        $this->Cell(0, $_Y_QR_CODE_ , '', 0, 1, 'L');
        $this->Cell(150, 0, '', 0, 0, 'L');
        $this->Cell(20, 2 , $_qrID_, 0, 1,'');
        $this->SetFont('arial', 'B', 6.5);
        $this->Cell(6, 0, '', 0, 0, 'L');
        $this->SetTextColor(255,255,255);
        $this->Cell(167.3, 2.9, 'event.cnsplateforme.com', 0, 0, 'R');
        $this->Ln(24.5);

        $_Y_IMAGE_TICKET_ += 56;
        $_Y_IMAGE_QR_     += 56;
        
        // if($count >= 0 && $count<=5):
        //   if($count%2 == 1)
        //     $_Y_QR_CODE_    += 18.9;

        //   if($count ==3 )
        //     $_Y_QR_CODE_    = -3.9;

        //   if($count > 3 )
        //     $_Y_QR_CODE_    += -0.4;
        // endif;
        
        if($count%5 == 0):
          // $this->PageNo();
          // $_Y_IMAGE_TICKET_ += 50;
          // $_Y_IMAGE_QR_     += -250;
          // $_Y_QR_CODE_      += 0;
          // $this->Ln(25);
          // $this->Ln(26);
          $this->Cell(0, 20, '', 0, 1, 'L');
          $this->Cell(0, -20, '', 0, 1, 'L');
          $_Y_IMAGE_TICKET_  = 3;
          $_Y_IMAGE_QR_      = 15;
          $_Y_QR_CODE_       = 0;
          // $this->Ln(26);

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
