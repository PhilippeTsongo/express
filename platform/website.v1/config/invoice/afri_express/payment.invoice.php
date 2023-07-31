<?php

/**
 * @package Payment Invoice
 * @author Ezechiel Kalengya [ezechielkalengya@gmail.com] Software Engineer
 */
class myPDF extends FPDF
{
  function header() {
   $this->Image( VIEW_LOGO_APAC2, 85,6,40);
  }

  function footer() {
    // $this->Image( VIEW_LOGO_APAC2, 10,260,40);
    // $this->Image( VIEW_LOGO_AWF, 90,266,40);
    // $this->Image( VIEW_LOGO_WCPA, 160,265,40);
    $this->SetY(-15);
    $this->SetFont('cambria','B',11);
    $this->Cell(0,15,'Page '.$this->PageNo().'/{nb}',0,0,'C');
  }

  function viewTable() {

    if(!Input::checkInput('request', 'get', 1) OR !Input::checkInput('authtoken_', 'get', 1))
      Redirect::to(404);

    $_AUTH_TOKEN_ =   Input::get('authtoken_', 'get');

    if(!is_integer(($_PAYMENT_ID_   = Hash::decryptAuthToken($_AUTH_TOKEN_))))
        Redirect::to('');

    if(!($_PARTICIPANT_DATA_ = FutureEventController::getEventParticipantPaymentDataByID($_PAYMENT_ID_)))
        Redirect::to('');

    $_PARTICIPANT_ORGANIZATION_NAME_    = 'N/A';
    $_PARTICIPANT_ORGANIZATION_COUNTRY_ = 'N/A';
    $_PARTICIPANT_ORGANIZATION_CITY_    = 'N/A';

    $_PARTICIPANT_ORGANIZATION_DATA_ = FutureEventController::getParticipantOrganizationOrSchool($_PARTICIPANT_DATA_->event_id, $_PARTICIPANT_DATA_->participant_id);
    if($_PARTICIPANT_ORGANIZATION_DATA_):
      $_PARTICIPANT_ORGANIZATION_NAME_    = $_PARTICIPANT_ORGANIZATION_DATA_->name;
      $_PARTICIPANT_ORGANIZATION_COUNTRY_ = $_PARTICIPANT_ORGANIZATION_DATA_->country;
      $_PARTICIPANT_ORGANIZATION_CITY_    = $_PARTICIPANT_ORGANIZATION_DATA_->city;
    endif;

    # Invoice
    $this->SetFont('arial','B', 11);
    $this->Cell(190,26,'',0,1,'C');
    $this->Cell(190,5,'IUCN Africa Protected Areas Congress',0,1,'C');
    $this->SetFont('arial','',11);
    $this->Cell(190,5,'March 7th to 12th 2021, Kigali, Rwanda',0,1,'C');
    $this->SetFont('arial','',11);
    $this->Cell(190,5,'Email: info@apacongress.africa',0,1,'C');
    $this->Ln();
    $this->Cell(190,1,'',0,4,'C');
    $this->SetFont('arial','B',17);
    $this->SetLineWidth(0.4);
    $this->Cell(190,2,'Invoice',0,1,'C');
    $this->Ln();
    $this->SetFont('arial','B',5);
    $this->cell(190,0,'',1,1,'L');
    $this->Ln();

    $this->Cell(190,2,'',0,4,'C');
    $this->SetFont('arial','',11);
    $this->Cell(190, 11, $_PARTICIPANT_DATA_->participant_firstname.' '.$_PARTICIPANT_DATA_->participant_lastname ,0,1,'L');
    $this->Cell(190,2, $_PARTICIPANT_ORGANIZATION_NAME_ ,0,1,'L');
    $this->Cell(190,11, $_PARTICIPANT_ORGANIZATION_CITY_  ,0,1,'L');
    $this->Cell(190,2, $_PARTICIPANT_ORGANIZATION_COUNTRY_==''?'N/A':countryCodeToCountry($_PARTICIPANT_ORGANIZATION_COUNTRY_) ,0,1,'L');
    $this->Cell(190,11,'Tel:     '. ($_PARTICIPANT_DATA_->participant_telephone==''?'N/A':$_PARTICIPANT_DATA_->participant_telephone),0,1,'L');
    $this->Cell(190,1,"Email: ". ($_PARTICIPANT_DATA_->participant_email==''?'N/A':$_PARTICIPANT_DATA_->participant_email),0,1,'L');
    
    $this->SetFont('arial','',11);
    $this->Cell(190,10,'',0,1,'C');
    $this->Cell(190,1,'Registration number : '.$_PARTICIPANT_DATA_->participant_code ,0,1,'L');
    $this->SetFont('arial','',11);
    $this->Cell(190,11,'',0,1,'C');
    $this->Cell(135,1,'Invoice number: '.$_PARTICIPANT_DATA_->payment_transaction_id ,0,0,'L');
    $this->Cell(0,1,'Invoice Date: '.date('D d-m-Y h:i:a', $_PARTICIPANT_DATA_->payment_transaction_date) ,0,1, 'R');
    $this->cell(100,8,'',0,1,'L');

    $this->SetFont('arial','B', 10);
    $this->Cell(120,7,' Description ',1,0,'L');
    $this->Cell(70,7,' Amount ',1,1,'R');

    $this->SetFont('arial','', 10);
    $this->Cell(120,24,  "" ,1,'L');
    
    $this->Cell(70,24,' ',1,1,'R');
    $this->SetFont('arial','', 10);
    $this->Cell(120, -25, " ". $_PARTICIPANT_DATA_->participation_type_name.' '.$_PARTICIPANT_DATA_->participation_subtype_name.' '.Functions::getEventCategory($_PARTICIPANT_DATA_->event_category) ,0,0,'L');
    $this->Cell(70,12, "" ,0,1,'L');
    
    $this->Cell(120, -60, " IUCN Africa Protected Areas  Congress (APAC)  Registration fee" ,0,0,'L');
    $this->Cell(70,-62, $_PARTICIPANT_DATA_->participation_subtype_currency.' '.$_PARTICIPANT_DATA_->participation_subtype_price ,0,0,'R');

    $this->Cell(190, -11.6,'',0,1,'C');

    $this->Cell(120,7,' Total ',1,0,'R');
    $this->Cell(70,7,$_PARTICIPANT_DATA_->participation_subtype_currency.' '.$_PARTICIPANT_DATA_->participation_subtype_price,1,1,'R');
    $this->cell(100,3,'',0,1,'L');

    $this->SetFont('arial','B',11);
    $this->Cell(190, 3,'',0,1,'L');
    $this->Cell(190,6, 'Payment Options',0,1,'L');
    $this->cell(190,0,'',1,1,'L');
    $this->Ln();
    $this->SetFont('arial','',9);
    $this->Cell(190, 6,'Payments can be made in either US$ of RWF. There are three payment options:',0,1,'L');
    $this->SetFont('arial', '', 9);
    $this->Cell(190, 6,'',0,1,'L');

    $this->Cell(10, 6,'',0,0,'L');
    $this->Cell(6, 5, "1.",0,0,"L");
    $this->MultiCell(175, 5,"By debit/credit card: Payment is accepted by VISA and/or MasterCard credit card and can be made directly online through the registration system. \n\nUpon completion of the registration process, your debit or credit card is charged immediately, and you will receive a balance zero invoice (receipt) by e-mail. Please note that your monthly card statement will indicate payment made to the 'Inaugural IUCN Africa Protected Areas Congress 2022'.
    ",0,'L');

    $this->Cell(10, 6,'',0,0,'L');
    $this->Cell(6, 5, "2.",0,0,"L");
    $this->MultiCell(175, 5,"By bank transfer: \n- You must quote as a reference your Registration Number, first and last names.\n- Bank transfers are accepted in US$ or RWF only and the payee must cover all bank charges for the payment. \n- Bank fees are the sole responsibility of the registrant and should be paid in addition to the registration fees. \n- All bank transfers must clearly state the name of the participant and the invoice number, as unidentified bank transfers cannot be processed.    
    ",0,'L');

    $this->SetFont('arial','B',10);
    $this->Cell(190,20,'',0,1,'L');
    $this->Cell(190,5,'BANK TRANSFER DETAILS:',0,1,'L');
    $this->Cell(190,7,'',0,1,'L');

    $this->SetFont('arial','',9);
    $this->Cell(190,1,'Bank Name: ECOBANK RWANDA PLC ',0,1,'L');
    $this->Cell(190,11,'Bank Address: KN# AV4, AVENUE DE LA PAIX, P.O. BOX 3268, KIGALI, RWANDA ',0,1,'L');
    $this->Cell(190,1,'Swift Code: ECOCRWRW ',0,1,'L');
    $this->Cell(190,11,'Branch name: Main Branch (Headquarters)',0,1,'L');
    $this->Cell(190,1,'Beneficiary Name (on account): IUCN  APAC ',0,1,'L');
    $this->Cell(190,11,'Account number (USD): 6775017613',0,1,'L');
    $this->Cell(190,1,'Transfer reference: '.$_PARTICIPANT_DATA_->participant_firstname.' '.$_PARTICIPANT_DATA_->participant_lastname.' '.$_PARTICIPANT_DATA_->payment_transaction_id, 0, 1, 'L');
    $this->Cell(190,1,'',0,1,'L');

    $this->SetFont('arial','', 9);
    $this->cell(190, 7, '',0,1,'L');
    $this->Cell(10, 6,'',0,0,'L');
    $this->Cell(6, 5, "3.",0,0,"L");
    $this->MultiCell(175, 5,"Mobile Money Transfer: The following mobile money payment options are acceptable: \n- Airtel Money: Powered by Airtel Payments Bank, the Airtel digital money wallet makes payments simple, secure and       cashless. \n- mPesa: mPesa is a convenient mobile money wallet allowing your unbanked customers to pay using their mobile device. \n- MTN's MoMoPay money wallet makes payments convenient by allowing your customers to pay for goods or services using their mobile device. \n- Orange Money \n- TiGO Pesa: Available in Tanzania only. \n- Vodacom mPesa.
    ",0,'L');
    $this->cell(190, 8, '',0,1,'L');
    
    $this->Ln();
    $this->SetFont('arial','B',5);
    $this->cell(190,0,'',1,1,'L');
    $this->Ln();
    $this->SetLineWidth(1);
    $this->cell(190, 8, '',0,1,'L');

    $this->SetFont('arial','B',10);
    $this->Cell(190,1,'Important Information:',0,1,'L');

    $this->cell(190, 7, '',0,1,'L');

    $this->SetFont('arial','',9);
    $this->MultiCell(175, 5,"Payment must to be received within 3 days after completing the registration form; otherwise the registration will be cancelled. \n\nPayments by bank transfer will only be possible until 15th January 2022. After this date, registrations can only be made with credit card payment. No cash payments can be accepted at the venue registration desk.", 0,'L');
   
    $this->cell(190, 5, '',0,1,'L');
    $this->Cell(66, 5,"For details on cancellation and refund, refer to ", 0, 0,'L');
    $this->SetTextColor(0,0,255);
    $this->Cell(2,5 ,'the policy document.','','','',false, "http://apacongress.torusguru.com/policy"); 
    $this->SetTextColor(0,0,0);

  }

}

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','A4',0);
$pdf->viewTable();
$pdf->Output();

 ?>
