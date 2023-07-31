<?php
header("Content-Type:application/Json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once '../../core/init.php';

$HASH = new Hash;
// echo $HASH->encryptAES("cns-api-b2b-ship-update");

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

        
        //echo json_encode($_REQUEST_);

        if ($_REQUEST_):
          switch ($_REQUEST_):

            # B2B SHIPS
            case 'cns-api-b2b-ship-creation':
              $form = \CNS_SHIPController::createShip($access_data);
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            //SHIPS LIST
            case 'cns-api-b2b-ship-list':
              $_filter_condtion_ = "";

              $_filter_condtion_ = " AND cns_express_ship.cns_platform = $access_data->cns_platform " ; //AND cns_express_ship.cns_b2b = $access_data->cns_b2b  ";
              $_startdate_ = !Input::checkInput('filter-start-date', 'post', 1) ? "" : Str::data_in(strtotime(Input::get('filter-start-date', 'post')));
              $_enddate_ = !Input::checkInput('filter-end-date', 'post', 1) ? "" : Str::data_in(strtotime(Input::get('filter-end-date', 'post')));
              $_keyword_ = !Input::checkInput('filter-keyword', 'post', 1) ? "" : Str::data_in(Input::get('filter-keyword', 'post'));
              $_source_firstname_ = !Input::checkInput('filter-source-firstname', 'post', 1) ? "" : Str::data_in(Input::get('filter-source-firstname', 'post'));
              $_destination_firstname_ = !Input::checkInput('filter-destination-firstname', 'post', 1) ? "" : Str::data_in(Input::get('filter-destination-firstname', 'post'));

              if ($_startdate_ != '')
                $_filter_condtion_ .= " AND cns_express_ship.creation_datetime >= $_startdate_ ";
              if ($_enddate_ != '')
                $_filter_condtion_ .= " AND cns_express_ship.creation_datetime <= $_enddate_ ";
              if ($_keyword_ != '')
              $_filter_condtion_ .= " AND (cns_express_ship.code LIKE  '%$_keyword_%')";
              if ($_source_firstname_ != '')
              $_filter_condtion_ .= " AND (cns_express_ship.source_firstname LIKE  '%$_source_firstname_%')";
              if ($_destination_firstname_ != '')
              $_filter_condtion_ .= " AND (cns_express_ship.destination_firstname LIKE  '%$_destination_firstname_%')";

              $_LIST_DATA_ = \CNS_SHIPController::getShips($_filter_condtion_);
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

            //SHIP GET DATA
            case 'cns-api-b2b-ship-data':
              if (Input::checkInput('_id_', 'post', 1)):
                $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
                $_DATA_ = \CNS_SHIPController::getInfoShipByID($_ID_);
                $_LIST_DATA_ = \CNS_SHIPController::getShipStatusLogsList($_ID_);
                $_LIST_DATA_ITEM = \CNS_SHIPController::getInfoShipItemByID($_ID_);
                $_LIST_DATA_UNIT = \CNS_SHIPController::getShipUnits();
                $_LIST_DATA_CURRENCY = \CNS_SHIPController::get_data_currency_list_options();

                

                if ($_DATA_):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                  $response['data'] = $_DATA_;
                  $response['data']['logs'] = $_LIST_DATA_;
                  $response['data']['items'] = $_LIST_DATA_ITEM;
                  $response['data']['units'] = $_LIST_DATA_UNIT;
                  $response['data']['currency'] = $_LIST_DATA_CURRENCY;

                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
              else:
                $response['status'] = FAILLURE;
                $response['message'] = "Required param";
              endif;
              Json::echo ($response);
              break;

            //SHIP CHANGE STATUS
            case 'cns-api-b2b-ship-status':
              $form = \CNS_SHIPController::change_status_ship($access_data);
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            //SHIP STATUS LOGS LIST
            case 'cns-api-b2b-ship-status-list':
              if (Input::checkInput('_id_', 'post', 1)):
                $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
                $_LIST_DATA_ = \CNS_SHIPController::getShipStatusLogsList($_ID_);
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

            //SHIP EDIT
            case 'cns-api-b2b-ship-update':
              $form = \CNS_SHIPController::editShip($access_data);
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

























              //CLUSTER DATA LIST OPTIONS

              #COUNTRY LIST OPTION
              case 'cns-api-data-country-list-options':
                $_filter_condtion_ = " AND cns_data_country.status = 'ACTIVE' ";
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_data_country_list_options($_filter_condtion_);
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

              #SOURCE COUNTRY LIST OPTION
              case 'cns-api-data-source-country-list-options':
                $_filter_condtion_ = "";
                $cns_b2b = $access_data->cns_b2b;
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_data_source_country_list_options($_filter_condtion_ , $cns_b2b);
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

              #DESTINATION COUNTRY LIST OPTION
              case 'cns-api-data-destination-country-list-options':
                $_filter_condtion_ = "";
                $cns_b2b = $access_data->cns_b2b;
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_data_destination_country_list_options($_filter_condtion_ , $cns_b2b);
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

              #UNIT LIST OPTION
              case 'cns-api-data-unit-list-options':
                $_filter_condtion_ = "";
                $cns_b2b = $access_data->cns_b2b;
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_data_unit_list_options($_filter_condtion_, $cns_b2b);
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

              #CURRENCY LIST OPTION
              case 'cns-api-data-currency-list-options':
                $_filter_condtion_ = "";
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_data_currency_list_options($_filter_condtion_);
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


              #ITEM LIST OPTION
              case 'cns-api-data-item-list-options':
                $_filter_condtion_ = "";
                $cns_b2b = $access_data->cns_b2b;
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_data_item_list_options($_filter_condtion_ , $cns_b2b);
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

              #SHIP LIST OPTION
              case 'cns-api-data-shipment-list-options':
                $_filter_condtion_ = "";
                $cns_b2b = $access_data->cns_b2b;
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_data_ship_list_options($_filter_condtion_ , $cns_b2b);
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

              #PACKAGE LIST OPTION
              case 'cns-api-data-package-list-options':
                $_filter_condtion_ = "";
                $cns_b2b = $access_data->cns_b2b;
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_data_package_list_options($_filter_condtion_ , $cns_b2b);
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
                
              #PACKAGE TYPE LIST OPTION
              case 'cns-api-data-package-type-list-options':
                $_filter_condtion_ = "";
                $cns_b2b = $access_data->cns_b2b;
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_data_package_type_list_options($_filter_condtion_ , $cns_b2b);
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

      endif;
    endif;
  endif;
endif;
// endif;
?>