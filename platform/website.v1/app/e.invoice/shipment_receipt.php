<?php
require '../../core/init.php';
require '../../config/fpdf_beta/fpdf.php';
// require_once '../core/phpqrcode/qrlib.php';

$_GET['request'] = 'print_invoice_pdf';
// $_POST['event'] = !Input::checkInput('event', 'get', 1)?1:Input::get('event', 'get');
// $_POST['ticket'] = !Input::checkInput('ticket', 'get', 1)?1:Input::get('ticket', 'get');
// $_POST['number'] = !Input::checkInput('number', 'get', 1)?1:Input::get('number', 'get');
$mainPath_        = '../../config/invoice/afri_express/';

// $_DATA_ = HttpRequest::callAPI("POST", "http://127.0.0.1/cns.express/core/v1/cns/master/api/ship", _AUTHORIZATION_, "mfFG8MlpZ7Ya2GPbbYEVMw", "{}");

// echo '<pre>';
// print_r($_DATA_ );
// echo '</pre>';
if(Input::checkInput('request', 'get', 1)):
   switch(Input::get('request', 'get')):

      case 'print_invoice_pdf':
        
       require $mainPath_.'shipment.receipt'.PL;
       break;

     default:
       Redirect::to(404);
       break;
   endswitch;
endif;

