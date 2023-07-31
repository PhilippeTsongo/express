<?php
header("Content-Type:application/Json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once '../../core/init.php';

$HASH = new Hash;
// echo  $HASH->encryptAES('cns-api-root-acccount-list');

# Check Request Method Origin
if($_SERVER['REQUEST_METHOD'] === 'POST'):

  # Get API Headers 
  $headers = Functions::getRequestHeaders();
  if($headers):
      $token       = Functions::getBearerAuthValue($headers);
      // $token       = $HASH->decryptAES($token);
      $access_data = CNS_ROOT_AccountController::checkToken($token);

      # Check Valid Token :: Access Data
      if($access_data):

          if (Input::checkInput('request', 'post', 1) && Input::checkInput('webToken', 'post', 1)):
            // $_REQUEST_ = Input::get('request', 'post');
            $_REQUEST_ = $HASH->decryptAES(Input::get('request', 'post'));
            
            if ($_REQUEST_):
              switch ($_REQUEST_):

                case 'cns-api-root-acccount-creation':
                  $form = \CNS_ROOT_AccountController::create();
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;

                case 'cns-api-root-acccount-update':
                  $form = \CNS_ROOT_AccountController::edit();
                  if ($form->ERRORS == false):
                    $response['status']  = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status']  = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;

                case 'cns-api-root-acccount-list':
                  $_LIST_DATA_ = \CNS_ROOT_AccountController::getAccounts("");
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

                          
                case 'cns-api-root-acccount-data':
                  if(Input::checkInput('_id_', 'post', 1)):
                    $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
                    $_DATA_ = \CNS_ROOT_AccountController::getAccountByID($_ID_);
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

                case 'vwa-api-account-agent-activate': 
                  Input::put('update-status', 'post', 'ACTIVE');
                  $form = \CNS_ROOT_AccountController::changeStatus();
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;
                
                case 'vwa-api-account-agent-deactivate':
                  Input::put('update-status', 'post', 'DEACTIVE');
                  $form = \CNS_ROOT_AccountController::changeStatus();
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;

                case 'vwa-api-account-agent-reset-password':
                  $form = \CNS_ROOT_AccountController::resetPassword();
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;

                case 'vwa-api-customer-acccount-restore': 
                  Input::put('account-status', 'post', 'A');
                  $form = \CNS_ROOT_AccountController::changeStatus();
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
                  Input::put('account-status', 'post', 'S');
                  $form = \CNS_ROOT_AccountController::changeStatus();
                  if ($form->ERRORS == false):
                    $response['status']  = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status']  = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;

                case 'cns-api-root-acccount-type-list':
                  $_filter_condtion_ = " AND cns_views_access_level.cns_platform = 0 AND cns_views_access_level.cns_platform_product = 0 ";
                  $_LIST_DATA_ = \CNS_AccessController::get_list_access_level($_filter_condtion_);
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
