<?php
require '../core/init.php';

if (Input::checkInput('request', 'post', 1) && Input::checkInput('webToken', 'post', 1)):
  switch (Input::get('request', 'post')):

    case 'system-account-signin':
      $form = \AccountController::login();
      if ($form->ERRORS == false):
        $response['status'] = 1;
        $response['message'] = 'Operation success!';
      else:
        $response['status'] = 0;
        $response['message'] = $form->ERRORS_SCRIPT;
      endif;
      break;

    default:
      Redirect::to(404);
      break;

  endswitch;

  echo json_encode($response);
endif;
?>
