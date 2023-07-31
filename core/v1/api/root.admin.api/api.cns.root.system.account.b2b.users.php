<?php
header("Content-Type:application/Json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once '../../core/init.php';

// if($session_user->isLoggedIn()):

$HASH = new Hash;
// echo  $HASH->encryptAES('cns-api-b2b-user-acccount-type-list');

# Check Request Method Origin
if($_SERVER['REQUEST_METHOD'] === 'POST'):

  # Get API Headers 
  $headers = Functions::getRequestHeaders();
  if($headers):
      $token       = Functions::getBearerAuthValue($headers);
      $access_data = CNS_ROOT_AccountController::checkToken($token);

      # Check Valid Token :: Access Data
      if($access_data):

          if (Input::checkInput('request', 'post', 1) && Input::checkInput('webToken', 'post', 1)):
            // $_REQUEST_ = Input::get('request', 'post');
            $_REQUEST_ = $HASH->decryptAES(Input::get('request', 'post'));
            
            if ($_REQUEST_):
              switch ($_REQUEST_):

                case 'cns-api-b2b-user-acccount-creation':
                  $form = \CNS_B2B_USERS_AccountController::create(0,0);
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;

                case 'cns-api-b2b-user-acccount-update':
                  $form = \CNS_B2B_USERS_AccountController::edit_basic_information();
                  if ($form->ERRORS == false):
                    $response['status']  = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status']  = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;

                case 'cns-api-b2b-user-acccount-list':
                  $_LIST_DATA_ = \CNS_B2B_USERS_AccountController::getAccounts("");
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

                       
                case 'cns-api-b2b-user-acccount-data':
                  if(Input::checkInput('_id_', 'post', 1)):
                    $_ID_   = $HASH->decryptAES(Input::get('_id_', 'post'));
                    $_DATA_ = \CNS_B2B_USERS_AccountController::getAccountByID($_ID_);
                    if ($_DATA_):
                      $response['status']  = SUCCESS;
                      $response['message'] = 'Operation success!';
                      $response['data']    = $_DATA_;
                    else:
                      $response['status']  = FAILLURE;
                      $response['message'] = $form->ERRORS_SCRIPT;
                    endif;
                  else:
                    $response['status']  = FAILLURE;
                    $response['message'] = "Required param";
                  endif;
                  Json::echo($response);
                 break;

                case 'cns-api-b2b-user-acccount-activate': 
                  Input::put('account-status', 'post', 'ACTIVE');
                  $form = \CNS_B2B_USERS_AccountController::changeStatus();
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = 0;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;
                
                case 'cns-api-b2b-user-acccount-deactivate':
                  Input::put('account-status', 'post', 'DEACTIVE');
                  $form = \CNS_B2B_USERS_AccountController::changeStatus();
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = 0;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;

                case 'cns-api-b2b-user-acccount-reset-password':
                  $form = \CNS_B2B_USERS_AccountController::resetPassword($access_data->cns_platform);
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = 0;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;

                case 'cns-api-b2b-user-acccount-restore': 
                  Input::put('account-status', 'post', 'ACTIVE');
                  $form = \CNS_B2B_USERS_AccountController::changeStatus();
                  if ($form->ERRORS == false):
                    $response['status']  = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status']  = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;
                
                case 'cns-api-b2b-user-acccount-suspend':
                  Input::put('account-status', 'post', 'SUSPENDED');
                  $form = \CNS_B2B_USERS_AccountController::changeStatus();
                  if ($form->ERRORS == false):
                    $response['status']  = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status']  = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;

                case 'cns-api-b2b-user-acccount-type-list':
                  $_LIST_DATA_ = \CNS_B2B_USERS_AccountController::getAccountTypes("");
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
