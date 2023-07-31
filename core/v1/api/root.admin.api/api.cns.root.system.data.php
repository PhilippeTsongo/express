<?php
header("Content-Type:application/Json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once '../../core/init.php';

$HASH = new Hash;
// echo  $HASH->encryptAES('cns-api-b2b-platform-cluster-logistic-material-delete');

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

                # STORE CATEGORY
                case 'cns-api-data-store-category-creation':
                  $form = \CNS_CLUSTER_DataController::create_data_store_category($access_data->id);
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;

                case 'cns-api-data-store-category-update':
                  $form = \CNS_CLUSTER_DataController::edit_data_store_category($access_data->id);
                  if ($form->ERRORS == false):
                    $response['status']  = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status']  = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;

                case 'cns-api-data-store-category-list':
                  $_filter_condtion_ = " AND cns_data_store_category.cns_platform = $access_data->cns_platform AND cns_data_store_category.cns_platform_product = $access_data->cns_platform_product  ";
                  $_LIST_DATA_ = \CNS_CLUSTER_DataController::get_data_store_category_list($_filter_condtion_);
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

                case 'cns-api-data-store-category-list-options':
                  $_filter_condtion_ = " AND cns_data_store_category.cns_platform = $access_data->cns_platform AND cns_data_store_category.cns_platform_product = $access_data->cns_platform_product  ";
                  $_LIST_DATA_ = \CNS_CLUSTER_DataController::get_data_store_category_list_options($_filter_condtion_);
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

                case 'cns-api-data-store-category-activate': 
                  Input::put('account-status', 'post', 'ACTIVE');
                  $form = \CNS_CLUSTER_DataController::change_status_data_store_category($access_data->id);
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;
                
                case 'cns-api-data-store-category-deactivate':
                  Input::put('account-status', 'post', 'DEACTIVE');
                  $form = \CNS_CLUSTER_DataController::change_status_data_store_category($access_data->id);
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;


                # STORE SUB CATEGORY
                case 'cns-api-data-store-sub-category-creation':
                  $form = \CNS_CLUSTER_DataController::create_data_store_sub_category($access_data->id);
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;

                case 'cns-api-data-store-sub-category-update':
                  $form = \CNS_CLUSTER_DataController::edit_data_store_sub_category($access_data->id);
                  if ($form->ERRORS == false):
                    $response['status']  = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status']  = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;

                case 'cns-api-data-store-sub-category-list':
                  $_filter_condtion_ = " AND cns_data_store_category.cns_platform = $access_data->cns_platform AND cns_data_store_category.cns_platform_product = $access_data->cns_platform_product  ";
                  $_LIST_DATA_ = \CNS_CLUSTER_DataController::get_data_store_sub_category_list($_filter_condtion_);
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

                case 'cns-api-data-store-sub-category-list-options':
                  $_filter_condtion_ = " AND cns_data_store_category.cns_platform = $access_data->cns_platform AND cns_data_store_category.cns_platform_product = $access_data->cns_platform_product  ";
                  $_LIST_DATA_ = \CNS_CLUSTER_DataController::get_data_store_sub_category_list($_filter_condtion_);
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

                case 'cns-api-data-store-sub-category-activate': 
                  Input::put('update-status', 'post', 'ACTIVE');
                  $form = \CNS_CLUSTER_DataController::change_status_data_store_sub_category($access_data->id);
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;
                
                case 'cns-api-data-store-sub-category-deactivate':
                  Input::put('update-status', 'post', 'DEACTIVE');
                  $form = \CNS_CLUSTER_DataController::change_status_data_store_sub_category($access_data->id);
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;



                # STORE COLLECTIONS
                case 'cns-api-data-store-collection-creation':
                  $form = \CNS_CLUSTER_DataController::create_data_store_collection($access_data->id);
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;

                case 'cns-api-data-store-collection-update':
                  $form = \CNS_CLUSTER_DataController::edit_data_store_collection($access_data->id);
                  if ($form->ERRORS == false):
                    $response['status']  = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status']  = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;

                case 'cns-api-data-store-collection-list':
                  $_filter_condtion_ = " AND cns_data_store_category.cns_platform = $access_data->cns_platform AND cns_data_store_category.cns_platform_product = $access_data->cns_platform_product  ";
                  $_LIST_DATA_ = \CNS_CLUSTER_DataController::get_data_store_collection_list($_filter_condtion_);
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

                case 'cns-api-data-store-collectiony-list-options':
                  $_filter_condtion_ = " AND cns_data_store_category.cns_platform = $access_data->cns_platform AND cns_data_store_category.cns_platform_product = $access_data->cns_platform_product  ";
                  $_LIST_DATA_ = \CNS_CLUSTER_DataController::get_data_store_collection_list($_filter_condtion_);
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

                case 'cns-api-data-store-collection-activate': 
                  Input::put('update-status', 'post', 'ACTIVE');
                  $form = \CNS_CLUSTER_DataController::change_status_data_store_collection($access_data->id);
                  if ($form->ERRORS == false):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                  else:
                    $response['status'] = FAILLURE;
                    $response['message'] = $form->ERRORS_SCRIPT;
                  endif;
                  Json::echo($response);
                  break;
                
                case 'cns-api-data-store-collection-deactivate':
                  Input::put('update-status', 'post', 'DEACTIVE');
                  $form = \CNS_CLUSTER_DataController::change_status_data_store_collection($access_data->id);
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
