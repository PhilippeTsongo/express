<?php
header("Content-Type:application/Json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once '../../core/init.php';

$HASH = new Hash;
// echo  $HASH->encryptAES('cns-api-data-store-collection-list');

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

                # STORE CATEGORY
                case 'cns-api-data-store-category-list':
                  $_filter_condtion_ = " AND cns_data_store_category.cns_platform = $access_data->cns_platform AND cns_data_store_category.cns_platform_product = $access_data->cns_platform_product  ";
                  $_LIST_DATA_ = \CNS_CLUSTER_DataController::get_data_store_category_list($_filter_condtion_);
                  if ( $_LIST_DATA_ ):
                    $response['status']  = SUCCESS;
                    $response['message'] = 'SUCCESS  -- ' . $_filter_condtion_;
                    $response['data']    = $_LIST_DATA_;
                  else:
                    $response['status']  = FAILLURE;
                    $response['message'] = 'EMPTY';
                  endif;
                  Json::echo($response);
                  break;

                case 'cns-api-data-store-category-list-options':
                  $_filter_condtion_ = " AND cns_data_store_category.cns_platform = $access_data->cns_platform AND cns_data_store_category.cns_platform_product = $access_data->cns_platform_product  ";
                  $_filter_condtion_+= " AND cns_data_store_category.cns_b2b = $access_data->cns_b2b AND cns_data_store_category.status = 'ACTIVE' ";
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

                # STORE SUB CATEGORY
                case 'cns-api-data-store-sub-category-list':
                  $_filter_condtion_ = " AND cns_data_store_sub_category.cns_platform = $access_data->cns_platform AND cns_data_store_sub_category.cns_platform_product = $access_data->cns_platform_product  ";
                  
                  $_category_ = !Input::checkInput('filter-category', 'post', 1)?"": Str::data_in( Input::get('filter-category', 'post') ) ; 
                  if ($_category_ != ''):
                    $_category_ = $HASH->decryptAES( $_category_  );
                    $_filter_condtion_ .= " AND cns_data_store_sub_category.store_category = $_category_ ";
                  endif;

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
                  $_filter_condtion_ = " AND cns_data_store_sub_category.cns_platform = $access_data->cns_platform AND cns_data_store_sub_category.cns_platform_product = $access_data->cns_platform_product  ";
                  $_filter_condtion_+= " AND cns_data_store_sub_category.status = 'ACTIVE' ";
                         
                  $_category_ = !Input::checkInput('filter-category', 'post', 1)?"": Str::data_in( Input::get('filter-category', 'post') ) ; 
                  if ($_category_ != ''):
                    $_category_ = $HASH->decryptAES( $_category_  );
                    $_filter_condtion_ .= " AND cns_data_store_sub_category.store_category = $_category_ ";
                  endif;

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

                # STORE COLLECTIONS
                case 'cns-api-data-store-collection-list':
                  $_filter_condtion_ = " AND cns_data_store_collection.cns_platform = $access_data->cns_platform AND cns_data_store_collection.cns_platform_product = $access_data->cns_platform_product  ";
                  
                  $_category_ = !Input::checkInput('filter-category', 'post', 1)?"": Str::data_in( Input::get('filter-category', 'post') ) ; 
                  $_sub_category_ = !Input::checkInput('filter-subcategory', 'post', 1)?"": Str::data_in( Input::get('filter-subcategory', 'post') ) ; 
                  if ($_category_ != ''):
                    $_category_ = $HASH->decryptAES( $_category_  );
                    $_filter_condtion_ .= " AND cns_data_store_collection.store_category = $_category_ ";
                  endif;
                  if ($_sub_category_ != ''):
                    $_sub_category_ = $HASH->decryptAES( $_sub_category_  );
                    $_filter_condtion_ .= " AND cns_data_store_collection.store_sub_category = $_sub_category_ ";
                  endif;

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
                  $_filter_condtion_ = " AND cns_data_store_collection.cns_platform = $access_data->cns_platform AND cns_data_store_collection.cns_platform_product = $access_data->cns_platform_product  ";
                  $_filter_condtion_+= " AND cns_data_store_collection.status = 'ACTIVE' ";
                  
                  $_category_ = !Input::checkInput('filter-category', 'post', 1)?"": Str::data_in( Input::get('filter-category', 'post') ) ; 
                  $_sub_category_ = !Input::checkInput('filter-subcategory', 'post', 1)?"": Str::data_in( Input::get('filter-subcategory', 'post') ) ; 
                  if ($_category_ != ''):
                    $_category_ = $HASH->decryptAES( $_category_  );
                    $_filter_condtion_ .= " AND cns_data_store_collection.store_category = $_category_ ";
                  endif;
                  if ($_sub_category_ != ''):
                    $_sub_category_ = $HASH->decryptAES( $_sub_category_  );
                    $_filter_condtion_ .= " AND cns_data_store_collection.store_sub_category = $_sub_category_ ";
                  endif;
                  
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

                  
                case 'cns-api-data-country-list-options':
                  $_filter_condtion_ = " AND cns_data_country.status = 'ACTIVE' ";
                  $_LIST_DATA_ = \CNS_CLUSTER_DataController::get_data_country_list_options($_filter_condtion_);
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

                # STORE COLLECTIONS
                case 'cns-api-data-province-list-options':
                  $_filter_condtion_ = " AND cns_data_province.status = 'ACTIVE' ";
                  
                  $_country_ = !Input::checkInput('filter-country', 'post', 1)?"": Str::data_in( Input::get('filter-country', 'post') ) ; 
                  if ($_country_ != ''):
                    $_country_ = $HASH->decryptAES( $_country_  );
                    $_filter_condtion_ .= " AND cns_data_province.country = $_country_ ";
                  endif;

                  $_LIST_DATA_ = \CNS_CLUSTER_DataController::get_data_province_list_options($_filter_condtion_);
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

                case 'cns-api-data-city-list-options':
                  $_filter_condtion_ = " AND cns_data_city.status = 'ACTIVE' ";

                  $_country_ = !Input::checkInput('filter-country', 'post', 1)?"": Str::data_in( Input::get('filter-country', 'post') ) ; 
                  $_province_ = !Input::checkInput('filter-province', 'post', 1)?"": Str::data_in( Input::get('filter-province', 'post') ) ; 
                  if ($_country_ != ''):
                    $_country_ = $HASH->decryptAES( $_country_  );
                    $_filter_condtion_ .= " AND cns_data_city.country = $_country_ ";
                  endif;
                  if ($_province_ != ''):
                    $_province_ = $HASH->decryptAES( $_province_  );
                    $_filter_condtion_ .= " AND cns_data_city.province = $_province_ ";
                  endif;

                  $_LIST_DATA_ = \CNS_CLUSTER_DataController::get_data_city_list_options($_filter_condtion_);
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

                case 'cns-api-data-currency-list-options':
                  $_filter_condtion_ = " AND cns_data_currency.status = 'ACTIVE' ";
                  $_LIST_DATA_ = \CNS_CLUSTER_DataController::get_data_currency_list_options($_filter_condtion_);
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

                case 'cns-api-data-language-list-options':
        
                  $_LIST_DATA_ = array(
                    array(
                      'token_auth' => 'fr_lang',
                      'name' => 'French'
                    ),
                    array(
                      'token_auth' => 'eng_lang',
                      'name' => 'English'
                    )
                  );

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
