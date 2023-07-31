<?php
header("Content-Type:application/Json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once '../../core/init.php';

$HASH = new Hash;
// echo $HASH->encryptAES('cns-api-b2b-user-acccount-update-address-information');

# Check Request Method Origin
if ($_SERVER['REQUEST_METHOD'] === 'POST'):

  # Get API Headers 
  $headers = Functions::getRequestHeaders();
  if ($headers):

    $token = Functions::getBearerAuthValue($headers);
    $access_data = CNS_B2B_USERS_AccountController::checkToken($token);

    # Check Valid Token :: Access Data
    if ($access_data):

      if (Input::checkInput('request', 'post', 1) && Input::checkInput('webToken', 'post', 1)):
        // $_REQUEST_ = Input::get('request', 'post');
        $_REQUEST_ = $HASH->decryptAES(Input::get('request', 'post'));

        if ($_REQUEST_):
          switch ($_REQUEST_):

            case 'cns-api-b2b-user-acccount-creation':
              $form = \CNS_B2B_USERS_AccountController::create($access_data->cns_platform, $access_data->cns_b2b);
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-user-acccount-update-basic-information':
              $form = \CNS_B2B_USERS_AccountController::edit_basic_information();
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-user-acccount-update-address-information':
              $form = \CNS_B2B_USERS_AccountController::edit_address_information();
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-user-acccount-update-social-media-information':
              $form = \CNS_B2B_USERS_AccountController::edit_b2b_social_media_information();
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-user-acccount-list':
              $_filter_condtion_ = " AND cns_cluster_account_b2b_users.cns_platform = $access_data->cns_platform AND cns_cluster_account_b2b_users.cns_b2b = $access_data->cns_b2b  ";

              $_startdate_ = !Input::checkInput('filter-start-date', 'post', 1) ? "" : Str::data_in(strtotime(Input::get('filter-start-date', 'post')));
              $_enddate_ = !Input::checkInput('filter-end-date', 'post', 1) ? "" : Str::data_in(strtotime(Input::get('filter-end-date', 'post')));
              $_keyword_ = !Input::checkInput('filter-keyword', 'post', 1) ? "" : Str::data_in(Input::get('filter-keyword', 'post'));
              if ($_startdate_ != '')
                $_filter_condtion_ .= " AND cns_cluster_account_b2b_users.join_date >= $_startdate_ ";
              if ($_enddate_ != '')
                $_filter_condtion_ .= " AND cns_cluster_account_b2b_users.join_date <= $_enddate_ ";
              if ($_keyword_ != '')
                $_filter_condtion_ .= " AND (cns_cluster_account_b2b_users.firstname LIKE  '%$_keyword_%' OR cns_cluster_account_b2b_users.lastname LIKE  '%$_keyword_%' OR cns_cluster_account_b2b_users.email LIKE  '%$_keyword_%' OR cns_cluster_account_b2b_users.telephone LIKE  '%$_keyword_%') ";

              $_status_ = !Input::checkInput('filter-status', 'post', 1) ? "" : Str::data_in(Input::get('filter-status', 'post'));
              if ($_status_ != ''):
                $_status_ = $HASH->decryptAES($_status_);
                $_status_ = $_status_ == 2 ? 'DEACTIVE' : 'ACTIVE';
                $_filter_condtion_ .= " AND cns_cluster_account_b2b_users.status = '$_status_' ";
              endif;

              // $_account_type_ = !Input::checkInput('filter-type', 'post', 1) ? "" : Str::data_in(Input::get('filter-type', 'post'));
              // if ($_account_type_ != ''):
              //   $_account_type_ = $HASH->decryptAES($_account_type_);
              //   $_filter_condtion_ .= " AND cns_cluster_account_b2b_users.account_type = $_account_type_ ";
              // endif;

              $_LIST_DATA_ = \CNS_B2B_USERS_AccountController::getAccounts($_filter_condtion_);
              if ($_LIST_DATA_):
                $response['status'] = SUCCESS;
                $response['message'] = 'SUCCESS';
                $response['data'] = $_LIST_DATA_;
              else:
                $response['status'] = FAILLURE;
                $response['message'] = 'EMPTY';
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-user-acccount-data':
              if (Input::checkInput('_id_', 'post', 1)):
                $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
                $_LIST_DATA_ = \CNS_B2B_USERS_AccountController::getAccountProfile($_ID_);
                if ($_LIST_DATA_):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'SUCCESS';
                  $response['data'] = $_LIST_DATA_;
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = 'EMPTY';
                endif;
              else:
                $response['status'] = FAILLURE;
                $response['message'] = "Required param";
              endif;
              Json::echo ($response);
              break;

            
            //  case 'cns-api-b2b-user-acccount-update':
            //   $form = \CNS_B2B_USERS_AccountController::edit_basic_information($access_data);
            //   if ($form->ERRORS == false):
            //     $response['status'] = SUCCESS;
            //     $response['message'] = 'Operation success!';
            //   else:
            //     $response['status'] = FAILLURE;
            //     $response['message'] = $form->ERRORS_SCRIPT;
            //   endif;
            //   Json::echo ($response);
            //   break;

            case 'cns-api-b2b-user-acccount-profile':
              $_LIST_DATA_ = \CNS_B2B_USERS_AccountController::getAccountProfile($access_data->id);
              if ($_LIST_DATA_):
                $response['status'] = SUCCESS;
                $response['message'] = 'SUCCESS';
                $response['data'] = $_LIST_DATA_;
              else:
                $response['status'] = FAILLURE;
                $response['message'] = 'EMPTY';
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-user-acccount-company-profile':
              $_LIST_DATA_ = \CNS_B2B_AccountController::getAccountByID($access_data->cns_b2b);
              if ($_LIST_DATA_):
                $response['status'] = SUCCESS;
                $response['message'] = 'SUCCESS';
                $response['data'] = $_LIST_DATA_;
              else:
                $response['status'] = FAILLURE;
                $response['message'] = 'EMPTY';
              endif;
              Json::echo ($response);
              break;


            case 'cns-api-b2b-acccount-update-basic-information':
              $form = \CNS_B2B_AccountController::edit_b2b_basic_information($access_data->cns_b2b);
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-acccount-update-social-media-information':
              $form = \CNS_B2B_AccountController::edit_b2b_social_media_information($access_data->cns_b2b);
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-user-acccount-activate':
              Input::put('account-status', 'post', 'ACTIVE');
              $form = \CNS_B2B_USERS_AccountController::changeStatus();
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-user-acccount-deactivate':
              Input::put('account-status', 'post', 'DEACTIVE');
              $form = \CNS_B2B_USERS_AccountController::changeStatus();
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-user-acccount-reset-password':
              $form = \CNS_B2B_USERS_AccountController::resetPassword($access_data->cns_platform);
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-user-acccount-restore':
              Input::put('account-status', 'post', 'ACTIVE');
              $form = \CNS_B2B_USERS_AccountController::changeStatus();
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-user-acccount-suspend':
              Input::put('account-status', 'post', 'SUSPENDED');
              $form = \CNS_B2B_USERS_AccountController::changeStatus();
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-user-acccount-delete':
              Input::put('account-status', 'post', 'DELETED');
              $form = \CNS_B2B_USERS_AccountController::changeStatus();
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-root-acccount-type-list':
              $_filter_condtion_ = " AND cns_views_access_level.cns_platform = 0 AND cns_views_access_level.cns_platform_product = 0 ";
              $_LIST_DATA_ = \CNS_AccessController::get_list_access_level($_filter_condtion_);
              if ($_LIST_DATA_):
                $response['status'] = SUCCESS;
                $response['message'] = 'SUCCESS';
                $response['data'] = $_LIST_DATA_;
              else:
                $response['status'] = FAILLURE;
                $response['message'] = 'EMPTY';
              endif;
              Json::echo ($response);
              break;

            default:
              $response['status'] = 1011;
              $response['message'] = 'INVALID_REQUEST';
              Json::echo ($response);
              break;
          endswitch;

        else:
          $response['status'] = 1011;
          $response['message'] = 'INVALID_REQUEST';
          Json::echo ($response);
        endif;
      else:
        $response['status'] = 1011;
        $response['message'] = 'INVALID_REQUEST';
        Json::echo ($response);
      endif;
    else:
      $response['status'] = 1011;
      $response['message'] = 'INVALID_REQUEST_AUTH';
      Json::echo ($response);
    endif;
  else:
    $response['status'] = 1011;
    $response['message'] = 'INVALID_REQUEST_AUTH';
    Json::echo ($response);
  endif;
endif;
?>