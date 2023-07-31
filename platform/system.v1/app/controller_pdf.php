<?php
require '../core/init.php';
require '../config/FPDF/fpdf.php';

if (!Input::checkInput('request', 'get', 1))
  Redirect::to(404);
if (!Input::checkInput('authtoken_', 'get', 1))
  Redirect::to(404);

$mainPath_ = '../config/payment.pdf/invoice/';
$_AUTH_TOKEN_ = Input::get('authtoken_', 'get');
if (!is_integer(($_PAYMENT_ID_ = Hash::decryptAuthToken($_AUTH_TOKEN_))))
  Redirect::to('');


if (Input::checkInput('request', 'get', 1)):
  switch (Input::get('request', 'get')):

    //  case 'print_payment_invoice':
    //     if(!($_PARTICIPANT_DATA_ = FutureEventController::getEventParticipantPaymentDataByID($_PAYMENT_ID_)))
    //         Redirect::to('');  

    //    require $mainPath_.'payment.invoice'.PL;
    //    break;

    //  case 'print_payment_receipt':
    //     if(!($_PARTICIPANT_DATA_ = FutureEventController::getEventParticipantPaymentDataByID($_PAYMENT_ID_)))
    //         Redirect::to('');

    //    if($_PARTICIPANT_DATA_->payment_transaction_status != 'COMPLETED')
    //       Redirect::to('payment/receipt/unfound/notification/'.sha1(time().'pay'));

    //    require $mainPath_.'payment.receipt'.PL;
    //    break;

    case 'print_invitation_letter':
      //  if($_PARTICIPANT_DATA_->payment_transaction_status != 'COMPLETED')
      //     Redirect::to('payment/receipt/unfound/notification/'.sha1(time().'pay'));

      require $mainPath_ . 'invitation.letter' . PL;
      break;

    default:
      Redirect::to(404);
      break;
  endswitch;
endif;
