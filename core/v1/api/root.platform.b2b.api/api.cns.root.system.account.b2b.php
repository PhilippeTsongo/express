<?php
header("Content-Type:application/Json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once '../../core/init.php';

$HASH = new Hash;
// echo  $HASH->encryptAES('cns-api-b2b-acccount-update-basic-information');

# Check Request Method Origin
if($_SERVER['REQUEST_METHOD'] === 'POST'):

  # Get API Headers 
  $headers = Functions::getRequestHeaders();
  if($headers):
      $token       = Functions::getBearerAuthValue($headers);
      $access_data = CNS_B2B_USERS_AccountController::checkToken($token);

      # Check Valid Token :: Access Data
      if($access_data):

          if (Input::checkInput('request', 'post', 1) && Input::checkInput('webToken', 'post', 1)):
            // $_REQUEST_ = Input::get('request', 'post');
            $_REQUEST_ = $HASH->decryptAES(Input::get('request', 'post'));
          
            if ($_REQUEST_):
              switch ($_REQUEST_):
                
                case 'cns-api-b2b-acccount-update-basic-information':
                  $form = \CNS_B2B_AccountController::edit_b2b_basic_information($access_data->cns_b2b);
                  if ($form->ERRORS == false):
                    $response['status']  = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status']  = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;

                case 'cns-api-b2b-acccount-list':
                  $_LIST_DATA_ = \CNS_B2B_AccountController::getAccounts("");
                  if ( $_LIST_DATA_ ):
                    $response['status']  = SUCCESS;
                    $response['message'] = 'SUCCESS';
                    $response['data']    = $_LIST_DATA_;
                  else:
                    $response['status']  = FAILLURE;
                    $response['message'] = 'EMPTY';
                  endif;
                  Json::echo($response);
                  break;

                case 'cns-api-b2b-acccount-activate': 
                  Input::put('agent-status', 'post', 'ACTIVE');
                  $form = \CNS_B2B_AccountController::changeStatus();
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = 0;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;
                
                case 'cns-api-b2b-acccount-deactivate':
                  Input::put('agent-status', 'post', 'DEACTIVE');
                  $form = \CNS_B2B_AccountController::changeStatus();
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = 0;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;

                case 'cns-api-b2b-acccount-reset-password':
                  $form = \CNS_B2B_AccountController::resetPassword();
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = 0;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;

                case 'vwa-api-customer-acccount-restore': 
                  Input::put('account-status', 'post', 'ACTIVE');
                  $form = \CNS_B2B_AccountController::changeStatus();
                  if ($form->ERRORS == false):
                    $response['status']  = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status']  = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;
                
                case 'vwa-api-customer-acccount-suspend':
                  Input::put('account-status', 'post', 'SUSPENDED');
                  $form = \CNS_B2B_AccountController::changeStatus();
                  if ($form->ERRORS == false):
                    $response['status']  = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status']  = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;


                case 'cns-api-b2b-acccount-branch-list':
                  $_LIST_DATA_ = \CNS_B2B_AccountController::getBranches("");
                  if ( $_LIST_DATA_ ):
                    $response['status']  = SUCCESS;
                    $response['message'] = 'SUCCESS';
                    $response['data']    = $_LIST_DATA_;
                  else:
                    $response['status']  = FAILLURE;
                    $response['message'] = 'EMPTY';
                  endif;
                  Json::echo($response);
                  break;

                case 'cns-api-b2b-acccount-branch-activate': 
                  Input::put('agent-status', 'post', 'ACTIVE');
                  $form = \CNS_B2B_AccountController::changeStatus();
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = 0;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;
                
                case 'cns-api-b2b-acccount-branch-deactivate':
                  Input::put('agent-status', 'post', 'DEACTIVE');
                  $form = \CNS_B2B_AccountController::changeStatus();
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = 0;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;











                default:
                  $response['status'] = 1011;
                  $response['message'] = 'INVALID_REQUEST';
                  Json::echo($response);
                  break;

              endswitch;

            else:
              $response['status'] = 1011;
              $response['message'] = 'INVALID_REQUEST';
              Json::echo($response);
            endif;

          endif;
      endif;
    endif;
endif;
// endif;
?>
