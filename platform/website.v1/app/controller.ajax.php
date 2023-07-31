<?php
require_once '../core/init.php';

$response['status'] = 0;
$response['message'] = 'Initialized';


if (Input::checkInput('request', 'post', 1) && Input::checkInput('webToken', 'post', 1)):
  $_REQUEST_ = $HASH->decryptAES(Input::get('request', 'post'));
  
  if ($_REQUEST_):
    switch ($_REQUEST_):

      default:
        $response['status'] = 1011;
        $response['message'] = 'INVALID_REQUEST';
        JSON::echo($response);
        break;

    endswitch;

  else:
    $response['status'] = 1011;
    $response['message'] = 'INVALID_REQUEST';
    JSON::echo($response);
  endif;

endif;
?>
