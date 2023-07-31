<?php

/**
 * @package Payment Invoice
 * @author Ezechiel Kalengya [ezechielkalengya@gmail.com] Software Engineer
 */
class myPDF extends FPDF
{
  function header()
  {
    $this->Image(VIEW_LOGO_APAC2, 162, 8, 43);
  }

  function footer()
  {
    // $this->Image( VIEW_LOGO_APAC2, 10,260,40);
    // $this->Image( VIEW_LOGO_AWF, 90,266,40);
    // $this->Image( VIEW_LOGO_WCPA, 160,265,40);
    $this->SetY(-15);
    $this->SetFont('cambria', 'B', 11);
    $this->Cell(0, 15, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
  }

  function viewTable()
  {

    if (!Input::checkInput('request', 'get', 1) or !Input::checkInput('authtoken_', 'get', 1))
      Redirect::to(404);

    $_AUTH_TOKEN_ = Input::get('authtoken_', 'get');

    if (!is_integer(($_PAYMENT_ID_ = Hash::decryptAuthToken($_AUTH_TOKEN_))))
      Redirect::to('');

    if (!($_PARTICIPANT_DATA_ = FutureEventController::getEventParticipantDataByID($_PAYMENT_ID_)))
      Redirect::to('');
    //    if($_PARTICIPANT_DATA_->registration_status != 'APPROVED')
//        Redirect::to('invitation/letter/unfound/notification/'.sha1(time().'pay'));

    $_PARTICIPANT_NAMES_ = $_PARTICIPANT_DATA_->participant_firstname . ' ' . $_PARTICIPANT_DATA_->participant_lastname;
    $_PARTICIPANT_BIRTHDATE_ = $_PARTICIPANT_DATA_->participant_birthday;
    $_PARTICIPANT_ID_TYPE_ = $_PARTICIPANT_DATA_->participant_id_type;
    $_PARTICIPANT_ID_NUMBER_ = $_PARTICIPANT_DATA_->participant_id_number;
    $_PARTICIPANT_COUNTRY_ = "";
    $_PARTICIPANT_NATIONALITY_ = "";

    $_PARTICIPANT_ORGANIZATION_DATA_ = FutureEventController::getParticipantOrganizationOrSchool($_PARTICIPANT_DATA_->event_id, $_PARTICIPANT_DATA_->participant_id);
    if ($_PARTICIPANT_ORGANIZATION_DATA_):
      $_PARTICIPANT_COUNTRY_ = $_PARTICIPANT_ORGANIZATION_DATA_->country;
    endif;

    $_PARTICIPANT_COUNTRY_ = ($_PARTICIPANT_COUNTRY_ == '') ? '' : countryCodeToCountry($_PARTICIPANT_COUNTRY_);

    $content_confirmation = "I hereby confirm that $_PARTICIPANT_NAMES_ of $_PARTICIPANT_ID_TYPE_ No $_PARTICIPANT_ID_NUMBER_, residing in $_PARTICIPANT_COUNTRY_, ";
    if ($_PARTICIPANT_BIRTHDATE_ != '' || $_PARTICIPANT_BIRTHDATE_ != 'dd/mm/yyyy'):
      $_PARTICIPANT_BIRTHDATE_ = date_format(date_create($_PARTICIPANT_BIRTHDATE_), 'd M, Y');
      $content_confirmation .= "born on $_PARTICIPANT_BIRTHDATE_ ";
    endif;

    if ($_PARTICIPANT_NATIONALITY_ != '')
      $content_confirmation .= " of nationality $_PARTICIPANT_NATIONALITY_, ";
    $content_confirmation .= "  is duly registered to attend the Africa Protected Areas Congress 2022 and that the registration fees, if any, are paid in full.   All travel expenses, including airfare, hotel, meals and travel insurance, are the sole responsibility of the participant. Participants are also solely responsible for obtaining their visas and/or all necessary documents to enter Rwanda. ";

    # Invoice
    $this->SetFont('arial', '', 10);
    $this->Cell(0, 27, '', 0, 4, 'L');
    $this->Cell(0, 5, 'Dear Sir or Madam,', 0, 1, 'L');

    $this->Cell(0, 11, '', 0, 4, 'L');
    $this->SetFont('arial', 'B', 11);
    $this->SetTextColor(8, 8, 8);
    $this->Cell(190, 2, 'INVITATION TO THE AFRICA PROTECTED AREAS CONGRESS', 0, 1, 'L');
    $this->Ln();
    $this->SetFont('arial', '', 0);
    $this->SetTextColor(0);
    $this->cell(1, 0, '', 0, 0, 'L');
    $this->cell(116, 0, '', 1, 1, 'L');
    $this->Ln();

    $this->SetFont('arial', '', 10);
    $this->Cell(0, 6, '', 0, 4, 'L');
    $this->MultiCell(190, 5, "The IUCN Africa Protected Areas Congress (APAC) is the first ever continent-wide gathering of African leaders, citizens, and interest groups to discuss the role of protected areas in conserving nature, safeguarding Africa's iconic wildlife, delivering vital life-supporting ecosystem services, promoting sustainable development while conserving Africa's cultural heritage and traditions.    ", 0, 'J');

    $this->SetFont('arial', '', 10);
    $this->Cell(0, 6, '', 0, 4, 'L');
    $this->MultiCell(190, 5, "The overarching objective of the IUCN Africa Protected Areas Congress (APAC) is to position Africa protected and conserved areas within the broader goals of economic development and community well- being and to increase the understanding of vital role parks play in conserving biodiversity and delivering the ecosystem services that underpin human welfare and livelihoods.", 0, 'J');


    $this->SetFont('arial', '', 10);
    $this->Cell(0, 6, '', 0, 4, 'L');
    $this->MultiCell(190, 5, "The Congress will take place between 7th and 12th March 2022 in Kigali, Rwanda and is organized by the Rwanda Government through the Ministry of Environment, in collaboration with The International Union for the Conservation of Nature (IUCN) and the African Wildlife Foundation (AWF) and other partners. There will be a pre-congress meeting targeting Youth and IPLCs on 5th and 6th March 2022.", 0, 'J');


    $this->SetFont('arial', '', 10);
    $this->Cell(0, 6, '', 0, 4, 'L');
    $this->MultiCell(190, 5, $content_confirmation, 0, 'L');

    $this->cell(190, 6, '', 0, 1, 'L');
    $this->Cell(117, 5, "For more information on the congress please contact the APAC Secretariat ", 0, 0, 'L');
    $this->SetTextColor(0, 0, 255);
    $this->Cell(40, 5, " info@apacongress.africa ", 0, 0, 'L');
    $this->SetTextColor(0, 0, 0);
    $this->Cell(10, 5, " or visit the APAC ", 0, 0, 'L');
    $this->cell(190, 5, '', 0, 1, 'L');
    $this->Cell(18, 5, "Website at ", 0, 0, 'L');
    $this->SetTextColor(0, 0, 255);
    $this->Cell(8, 5, 'https://apacongress.africa.', '', '', '', false, "https://apacongress.africa/ ");
    $this->SetTextColor(0, 0, 0);

    $this->SetFont('arial', '', 10);
    $this->Cell(0, 10, '', 0, 1, 'L');
    $this->MultiCell(0, 5, "Yours faithfully, \nAPAC Secretariat", 0, 'L');



  }

}

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P', 'A4', 0);
$pdf->viewTable();
$pdf->Output();

?>
