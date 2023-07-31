<?php
header("Content-Type:application/Json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once '../../core/init.php';

$HASH = new Hash;
// echo  $HASH->encryptAES('cns-api-root-platform-package-list');


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

                case 'cns-api-root-platform-list':
                  $_LIST_DATA_ = \CNS_B2B_PlatformController::getPlatforms("");
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

                case 'cns-api-root-platform-data':
                  if(Input::checkInput('_id_', 'post', 1)):
                    $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
                    $_DATA_ = \CNS_B2B_PlatformController::getPlatformByID($_ID_);
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



                case 'cns-api-root-platform-product-creation':
                  $form = \CNS_B2B_PlatformController::create_platform_product($access_data->id);
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;

                case 'cns-api-root-platform-product-update':
                  $form = \CNS_B2B_PlatformController::edit_platform_product(($access_data->id));
                  if ($form->ERRORS == false):
                    $response['status']  = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status']  = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;

                case 'cns-api-root-platform-product-list':
                  $_filter_condtion_ = " ";

                  $_platform_ = !Input::checkInput('ctaplatform', 'post', 1)?"": Str::data_in( Input::get('ctaplatform', 'post') ) ; 
                  if ($_platform_ != ''):
                    $_platform_ = $HASH->decryptAES( $_platform_  );
                    $_filter_condtion_ .= " AND cns_cluster_platform_product.cns_platform = $_platform_ ";
                  endif;

                  $_LIST_DATA_ = \CNS_B2B_PlatformController::get_platform_product($_filter_condtion_);
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
 
                case 'cns-api-root-platform-product-data':
                  if(Input::checkInput('_id_', 'post', 1)):
                    $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
                    $_DATA_ = \CNS_B2B_PlatformController::get_platform_product_by_ID($_ID_);
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

                case 'cns-api-root-platform-product-activate': 
                  Input::put('update-status', 'post', 'ACTIVE');
                  $form = \CNS_B2B_PlatformController::change_status_platform_product();
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;
                
                case 'cns-api-root-platform-product-deactivate':
                  Input::put('update-status', 'post', 'DEACTIVE');
                  $form = \CNS_B2B_PlatformController::change_status_platform_product();
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;



                
                case 'cns-api-root-platform-package-creation':
                  $form = \CNS_B2B_PlatformController::create_platform_package($access_data->id);
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;

                case 'cns-api-root-platform-package-update':
                  $form = \CNS_B2B_PlatformController::edit_platform_package(($access_data->id));
                  if ($form->ERRORS == false):
                    $response['status']  = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status']  = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;

                case 'cns-api-root-platform-package-list':
                  $_filter_condtion_ = " ";
                  
                  $_platform_ = !Input::checkInput('ctaplatform', 'post', 1)?"": Str::data_in( Input::get('ctaplatform', 'post') ) ; 
                  if ($_platform_ != ''):
                    $_platform_ = $HASH->decryptAES( $_platform_  );
                    $_filter_condtion_ .= " AND cns_cluster_platform_package.cns_platform = $_platform_ ";
                  endif;

                  $_software_ = !Input::checkInput('ctasoftware', 'post', 1)?"": Str::data_in( Input::get('ctasoftware', 'post') ) ; 
                  if ($_software_ != ''):
                    $_software_ = $HASH->decryptAES( $_software_  );
                    $_filter_condtion_ .= " AND cns_cluster_platform_package.cns_platform_product = $_software_ ";
                  endif;

                  $_LIST_DATA_ = \CNS_B2B_PlatformController::get_platform_product_package($_filter_condtion_);
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

                
                case 'cns-api-root-platform-package-activate': 
                  Input::put('update-status', 'post', 'ACTIVE');
                  $form = \CNS_B2B_PlatformController::change_status_package();
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;
                
                case 'cns-api-root-platform-package-deactivate':
                  Input::put('update-status', 'post', 'DEACTIVE');
                  $form = \CNS_B2B_PlatformController::change_status_package();
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = FAILLURE;
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
