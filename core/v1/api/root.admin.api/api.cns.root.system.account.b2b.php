<?php
header("Content-Type:application/Json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once '../../core/init.php';

$HASH = new Hash;
// echo 'En: '.  $HASH->encryptAES('cns-api-b2b-acccount-list-options');

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

                case 'cns-api-b2b-acccount-creation':
                  $form = \CNS_B2B_AccountController::create();
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;

                case 'cns-api-b2b-acccount-update':
                  $form = \CNS_B2B_AccountController::edit();
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
                  $_filter_condtion_ = " ";
                  
                  $_platform_ = !Input::checkInput('ctaplatform', 'post', 1)?"": Str::data_in( Input::get('ctaplatform', 'post') ) ; 
                  if ($_platform_ != ''):
                    $_platform_ = $HASH->decryptAES( $_platform_  );
                    $_filter_condtion_ .= " AND cns_cluster_account_b2b.cns_platform = $_platform_ ";
                  endif;

                  $_software_ = !Input::checkInput('ctasoftware', 'post', 1)?"": Str::data_in( Input::get('ctasoftware', 'post') ) ; 
                  if ($_software_ != ''):
                    $_software_ = $HASH->decryptAES( $_software_  );
                    $_filter_condtion_ .= " AND cns_cluster_account_b2b.cns_platform_product = $_software_ ";
                  endif;

                  $_package_ = !Input::checkInput('ctapackage', 'post', 1)?"": Str::data_in( Input::get('ctapackage', 'post') ) ; 
                  if ($_package_ != ''):
                    $_package_ = $HASH->decryptAES( $_package_  );
                    // $_filter_condtion_ .= " AND cns_cluster_account_b2b.cns_platform_package = $_package_ ";
                  endif;

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

                
                case 'cns-api-b2b-acccount-list-options':
                  $_filter_condtion_ = " ";
                  
                  $_platform_ = !Input::checkInput('ctaplatform', 'post', 1)?"": Str::data_in( Input::get('ctaplatform', 'post') ) ; 
                  if ($_platform_ != ''):
                    $_platform_ = $HASH->decryptAES( $_platform_  );
                    $_filter_condtion_ .= " AND cns_cluster_account_b2b.cns_platform = $_platform_ ";
                  endif;

                  $_software_ = !Input::checkInput('ctasoftware', 'post', 1)?"": Str::data_in( Input::get('ctasoftware', 'post') ) ; 
                  if ($_software_ != ''):
                    $_software_ = $HASH->decryptAES( $_software_  );
                    $_filter_condtion_ .= " AND cns_cluster_account_b2b.cns_platform_product = $_software_ ";
                  endif;

                  $_package_ = !Input::checkInput('ctapackage', 'post', 1)?"": Str::data_in( Input::get('ctapackage', 'post') ) ; 
                  if ($_package_ != ''):
                    $_package_ = $HASH->decryptAES( $_package_  );
                    // $_filter_condtion_ .= " AND cns_cluster_account_b2b.cns_platform_package = $_package_ ";
                  endif;

                  $_LIST_DATA_ = \CNS_B2B_AccountController::getAccountsOptions($_filter_condtion_);
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

                case 'cns-api-b2b-acccount-data':
                  if(Input::checkInput('_id_', 'post', 1)):
                    $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
                    $_DATA_ = \CNS_B2B_AccountController::getAccountByID($_ID_);
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

                case 'cns-api-b2b-acccount-activate': 
                  Input::put('account-status', 'post', 'ACTIVE');
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
                  Input::put('account-status', 'post', 'DEACTIVE');
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


                case 'cns-api-b2b-acccount-restore': 
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
                
                case 'cns-api-b2b-acccount-suspend':
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

                case 'cns-api-b2b-acccount-type-list':
                  $_LIST_DATA_ = \CNS_B2B_AccountController::getAccountTypes("");
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
