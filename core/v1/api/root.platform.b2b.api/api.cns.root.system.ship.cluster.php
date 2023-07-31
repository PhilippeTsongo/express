<?php
header("Content-Type:application/Json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once '../../core/init.php';


$HASH = new Hash;
// echo $HASH->encryptAES("cns-api-data-city-list-option");


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

            # B2B PARTNERS
            case 'cns-api-b2b-partner-creation':
              $form = \CNS_SHIP_CLUSTERController::record_partner($access_data);
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-partner-update':
              $form = \CNS_SHIP_CLUSTERController::edit_partner($access_data);
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-partner-list':

              $_filter_condtion_ = " AND cns_express_partners.cns_platform = $access_data->cns_platform AND cns_express_partners.cns_b2b = $access_data->cns_b2b  ";
              $_startdate_ = !Input::checkInput('filter-start-date', 'post', 1) ? "" : Str::data_in(strtotime(Input::get('filter-start-date', 'post')));
              $_enddate_ = !Input::checkInput('filter-end-date', 'post', 1) ? "" : Str::data_in(strtotime(Input::get('filter-end-date', 'post')));
              $_keyword_ = !Input::checkInput('filter-keyword', 'post', 1) ? "" : Str::data_in(Input::get('filter-keyword', 'post'));
              if ($_startdate_ != '')
                $_filter_condtion_ .= " AND cns_express_partners.creation_datetime >= $_startdate_ ";
              if ($_enddate_ != '')
                $_filter_condtion_ .= " AND cns_express_partners.creation_datetime <= $_enddate_ ";
              if ($_keyword_ != '')
              $_filter_condtion_ .= " AND (cns_express_partners.name LIKE  '%$_keyword_%')";

              $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::getPartners($_filter_condtion_);
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

            case 'cns-api-b2b-partner-data':
              if (Input::checkInput('_id_', 'post', 1)):
                $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
                $_DATA_ = \CNS_SHIP_CLUSTERController::getInfoPartnerByID($_ID_);
                if ($_DATA_):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                  $response['data'] = $_DATA_;
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

            case 'cns-api-b2b-partner-activate':
              Input::put('partner-status', 'post', 'ACTIVE');
              $form = \CNS_SHIP_CLUSTERController::change_status_partner();
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-partner-deactivate':
              Input::put('partner-status', 'post', 'DEACTIVE');
              $form = \CNS_SHIP_CLUSTERController::change_status_partner();
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-partner-delete':
              Input::put('update-status', 'post', 'DELETED');
              $form = \CNS_SHIP_CLUSTERController::delete_partner($access_data->id);
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            #DELIVERY AGENT
            case 'cns-api-b2b-delivery-agent-creation':
              $form = \CNS_SHIP_CLUSTERController::record_delivery_agent($access_data);
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-delivery-agent-update':
              $form = \CNS_SHIP_CLUSTERController::edit_delivery_agent($access_data);
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            //Delivery agent list
            case 'cns-api-b2b-delivery-agent-list':
              $_filter_condtion_ = " AND cns_express_delivery_agent.cns_platform = $access_data->cns_platform AND cns_express_delivery_agent.cns_b2b = $access_data->cns_b2b  ";

              $_startdate_ = !Input::checkInput('filter-start-date', 'post', 1) ? "" : Str::data_in(strtotime(Input::get('filter-start-date', 'post')));
              $_enddate_ = !Input::checkInput('filter-end-date', 'post', 1) ? "" : Str::data_in(strtotime(Input::get('filter-end-date', 'post')));
              $_keyword_ = !Input::checkInput('filter-keyword', 'post', 1) ? "" : Str::data_in(Input::get('filter-keyword', 'post'));
              if ($_startdate_ != '')
                $_filter_condtion_ .= " AND cns_express_delivery_agent.creation_datetime >= $_startdate_ ";
              if ($_enddate_ != '')
                $_filter_condtion_ .= " AND cns_express_delivery_agent.creation_datetime <= $_enddate_ ";
              if ($_keyword_ != '')
                $_filter_condtion_ .= " AND (cns_express_delivery_agent.firstname LIKE  '%$_keyword_%')";

              $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::getDeliveryAgents($_filter_condtion_);
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

            case 'cns-api-b2b-delivery-agent-data':
              if (Input::checkInput('_id_', 'post', 1)):
                $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
                $_DATA_ = \CNS_SHIP_CLUSTERController::getInfoDeliveryAgentByID($_ID_);
                if ($_DATA_):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                  $response['data'] = $_DATA_;
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

            case 'cns-api-b2b-delivery-agent-activate':
              Input::put('status', 'post', 'ACTIVE');
              $form = \CNS_SHIP_CLUSTERController::change_status_delivery_agent();
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-delivery-agent-deactivate':
              Input::put('status', 'post', 'DEACTIVE');
              $form = \CNS_SHIP_CLUSTERController::change_status_delivery_agent();
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-delivery-agent-delete':
              Input::put('update-status', 'post', 'DELETED');
              $form = \CNS_SHIP_CLUSTERController::delete_delivery_agent($access_data->id);
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;



            #SHIP CUSTOMERS LIST
              case 'cns-api-b2b-customer-list':
                $_filter_condtion_ = " ";
                $_startdate_ = !Input::checkInput('filter-start-date', 'post', 1) ? "" : Str::data_in(strtotime(Input::get('filter-start-date', 'post')));
                $_enddate_ = !Input::checkInput('filter-end-date', 'post', 1) ? "" : Str::data_in(strtotime(Input::get('filter-end-date', 'post')));
                $_keyword_ = !Input::checkInput('filter-keyword', 'post', 1) ? "" : Str::data_in(Input::get('filter-keyword', 'post'));
                if ($_startdate_ != '')
                  $_filter_condtion_ .= " AND cns_b2c_customer.creation_datetime >= $_startdate_ ";
                if ($_enddate_ != '')
                  $_filter_condtion_ .= " AND cns_b2c_customer.creation_datetime <= $_enddate_ ";
                if ($_keyword_ != '')
                $_filter_condtion_ .= " AND (cns_b2c_customer.firstname LIKE  '%$_keyword_%')";

                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::getCustomers($_filter_condtion_);
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





            # ITEM TYPE
            case 'cns-api-b2b-item-type-creation':
              $form = \CNS_SHIP_CLUSTERController::record_item_type($access_data);
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-item-type-update':
              $form = \CNS_SHIP_CLUSTERController::edit_item_type($access_data);
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-item-type-list':

              $_filter_condtion_ = " AND cns_express_item_type.cns_platform = $access_data->cns_platform AND cns_express_item_type.cns_b2b = $access_data->cns_b2b  ";
              $_startdate_ = !Input::checkInput('filter-start-date', 'post', 1) ? "" : Str::data_in(strtotime(Input::get('filter-start-date', 'post')));
              $_enddate_ = !Input::checkInput('filter-end-date', 'post', 1) ? "" : Str::data_in(strtotime(Input::get('filter-end-date', 'post')));
              $_keyword_ = !Input::checkInput('filter-keyword', 'post', 1) ? "" : Str::data_in(Input::get('filter-keyword', 'post'));
              if ($_startdate_ != '')
                $_filter_condtion_ .= " AND cns_express_item_type.creation_datetime >= $_startdate_ ";
              if ($_enddate_ != '')
                $_filter_condtion_ .= " AND cns_express_item_type.creation_datetime <= $_enddate_ ";
              if ($_keyword_ != '')
              $_filter_condtion_ .= " AND (cns_express_item_type.name LIKE  '%$_keyword_%')";

              $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::getItemTypes($_filter_condtion_);
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

            case 'cns-api-b2b-item-type-data':
              if (Input::checkInput('_id_', 'post', 1)):
                $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
                $_DATA_ = \CNS_SHIP_CLUSTERController::getInfoItemTypeByID($_ID_);
                if ($_DATA_):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                  $response['data'] = $_DATA_;
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

            case 'cns-api-b2b-item-type-activate':
              Input::put('item-type-status', 'post', 'ACTIVE');
              $form = \CNS_SHIP_CLUSTERController::change_status_item_type();
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-item-type-deactivate':
              Input::put('item-type-status', 'post', 'DEACTIVE');
              $form = \CNS_SHIP_CLUSTERController::change_status_item_type();
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-item-type-delete':
              Input::put('update-status', 'post', 'DELETED');
              $form = \CNS_SHIP_CLUSTERController::delete_item_type($access_data->id);
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            # PACKAGE TYPE
            case 'cns-api-b2b-package-type-creation':
              $form = \CNS_SHIP_CLUSTERController::record_package_type($access_data);
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-package-type-update':
              $form = \CNS_SHIP_CLUSTERController::edit_package_type($access_data);
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-package-type-list':
              $_filter_condtion_ = "";
              $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::getPackageTypes($_filter_condtion_);
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

            case 'cns-api-b2b-package-type-data':
              if (Input::checkInput('_id_', 'post', 1)):
                $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
                $_DATA_ = \CNS_SHIP_CLUSTERController::getInfoPackageTypeByID($_ID_);
                if ($_DATA_):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                  $response['data'] = $_DATA_;
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

            case 'cns-api-b2b-package-type-activate':
              Input::put('package-type-status', 'post', 'ACTIVE');
              $form = \CNS_SHIP_CLUSTERController::change_status_package_type();
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-package-type-deactivate':
              Input::put('package-type-status', 'post', 'DEACTIVE');
              $form = \CNS_SHIP_CLUSTERController::change_status_package_type();
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;

            case 'cns-api-b2b-package-type-delete':
              Input::put('update-status', 'post', 'DELETED');
              $form = \CNS_SHIP_CLUSTERController::delete_package_type($access_data->id);
              if ($form->ERRORS == false):
                $response['status'] = SUCCESS;
                $response['message'] = 'Operation success!';
              else:
                $response['status'] = FAILLURE;
                $response['message'] = $form->ERRORS_SCRIPT;
              endif;
              Json::echo ($response);
              break;


              # SHIP COST
              case 'cns-api-b2b-ship-cost-creation':
                $form = \CNS_SHIP_CLUSTERController::record_ship_cost($access_data);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-b2b-ship-cost-update':
                $form = \CNS_SHIP_CLUSTERController::edit_ship_cost($access_data);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-b2b-ship-cost-list':

                $_filter_condtion_ = " AND cns_express_ship_cost.cns_platform = $access_data->cns_platform AND cns_express_ship_cost.cns_b2b = $access_data->cns_b2b  ";
                $_startdate_ = !Input::checkInput('filter-start-date', 'post', 1) ? "" : Str::data_in(strtotime(Input::get('filter-start-date', 'post')));
                $_enddate_ = !Input::checkInput('filter-end-date', 'post', 1) ? "" : Str::data_in(strtotime(Input::get('filter-end-date', 'post')));
                $_keyword_ = !Input::checkInput('filter-keyword', 'post', 1) ? "" : Str::data_in(Input::get('filter-keyword', 'post'));
                if ($_startdate_ != '')
                  $_filter_condtion_ .= " AND cns_express_ship_cost.creation_datetime >= $_startdate_ ";
                if ($_enddate_ != '')
                  $_filter_condtion_ .= " AND cns_express_ship_cost.creation_datetime <= $_enddate_ ";
                if ($_keyword_ != '')
                $_filter_condtion_ .= " AND (cns_express_ship_cost.price LIKE  '%$_keyword_%')";


                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::getShipCosts($_filter_condtion_);
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
  
              case 'cns-api-b2b-ship-cost-data-d':
                if (Input::checkInput('_id_', 'post', 1)):
                  $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
                  $_DATA_ = \CNS_SHIP_CLUSTERController::getInfoShipCostByID($_ID_);
                  if ($_DATA_):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                    $response['data'] = $_DATA_;
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
  
              case 'cns-api-b2b-ship-cost-activate':
                Input::put('ship-cost-status', 'post', 'ACTIVE');
                $form = \CNS_SHIP_CLUSTERController::change_status_ship_cost();
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-b2b-ship-cost-deactivate':
                Input::put('ship-cost-status', 'post', 'DEACTIVE');
                $form = \CNS_SHIP_CLUSTERController::change_status_ship_cost();
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;

              case 'cns-api-b2b-ship-cost-delete':
                Input::put('update-status', 'post', 'DELETED');
                $form = \CNS_SHIP_CLUSTERController::delete_ship_cost($access_data->id);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;


            # SHIP COST
              // case 'cns-api-b2b-ship-cost-creation':
              //   $form = \CNS_SHIP_CLUSTERController::record_ship_cost($access_data);
              //   if ($form->ERRORS == false):
              //     $response['status'] = SUCCESS;
              //     $response['message'] = 'Operation success!';
              //   else:
              //     $response['status'] = FAILLURE;
              //     $response['message'] = $form->ERRORS_SCRIPT;
              //   endif;
              //   Json::echo ($response);
              //   break;
  
              // case 'cns-api-b2b-ship-cost-update':
              //   $form = \CNS_SHIP_CLUSTERController::edit_ship_cost($access_data);
              //   if ($form->ERRORS == false):
              //     $response['status'] = SUCCESS;
              //     $response['message'] = 'Operation success!';
              //   else:
              //     $response['status'] = FAILLURE;
              //     $response['message'] = $form->ERRORS_SCRIPT;
              //   endif;
              //   Json::echo ($response);
              //   break;
  
              // case 'cns-api-b2b-ship-cost-list':
              //   $_filter_condtion_ = "";
              //   $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::getShipCosts($_filter_condtion_);
              //   if ($_LIST_DATA_):
              //     $response['status'] = SUCCESS;
              //     $response['message'] = 'SUCCESS';
              //     $response['data'] = $_LIST_DATA_;
              //   else:
              //     $response['status'] = FAILLURE;
              //     $response['message'] = 'EMPTY';
              //   endif;
              //   Json::echo ($response);
              //   break;
  
              // case 'cns-api-b2b-ship-cost-data-d':
              //   if (Input::checkInput('_id_', 'post', 1)):
              //     $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
              //     $_DATA_ = \CNS_SHIP_CLUSTERController::getInfoShipCostByID($_ID_);
              //     if ($_DATA_):
              //       $response['status'] = SUCCESS;
              //       $response['message'] = 'Operation success!';
              //       $response['data'] = $_DATA_;
              //     else:
              //       $response['status'] = FAILLURE;
              //       $response['message'] = $form->ERRORS_SCRIPT;
              //     endif;
              //   else:
              //     $response['status'] = FAILLURE;
              //     $response['message'] = "Required param";
              //   endif;
              //   Json::echo ($response);
              //   break;
  
              // case 'cns-api-b2b-ship-cost-activate':
              //   Input::put('ship-cost-status', 'post', 'ACTIVE');
              //   $form = \CNS_SHIP_CLUSTERController::change_status_ship_cost();
              //   if ($form->ERRORS == false):
              //     $response['status'] = SUCCESS;
              //     $response['message'] = 'Operation success!';
              //   else:
              //     $response['status'] = FAILLURE;
              //     $response['message'] = $form->ERRORS_SCRIPT;
              //   endif;
              //   Json::echo ($response);
              //   break;
  
              // case 'cns-api-b2b-ship-cost-deactivate':
              //   Input::put('ship-cost-status', 'post', 'DEACTIVE');
              //   $form = \CNS_SHIP_CLUSTERController::change_status_ship_cost();
              //   if ($form->ERRORS == false):
              //     $response['status'] = SUCCESS;
              //     $response['message'] = 'Operation success!';
              //   else:
              //     $response['status'] = FAILLURE;
              //     $response['message'] = $form->ERRORS_SCRIPT;
              //   endif;
              //   Json::echo ($response);
              // break;
                


              
              

              # SHIP PURPOSE
              case 'cns-api-b2b-ship-purpose-creation':
                $form = \CNS_SHIP_CLUSTERController::record_ship_purpose($access_data);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-b2b-ship-purpose-update':
                $form = \CNS_SHIP_CLUSTERController::edit_ship_purpose($access_data);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-b2b-ship-purpose-list':
                $_filter_condtion_ = "";
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::getShipPurposes($_filter_condtion_);
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
  
              case 'cns-api-b2b-ship-purpose-data':
                if (Input::checkInput('_id_', 'post', 1)):
                  $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
                  $_DATA_ = \CNS_SHIP_CLUSTERController::getInfoShipPurposeByID($_ID_);
                  if ($_DATA_):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                    $response['data'] = $_DATA_;
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
  
              case 'cns-api-b2b-ship-purpose-activate':
                Input::put('ship-purpose-status', 'post', 'ACTIVE');
                $form = \CNS_SHIP_CLUSTERController::change_status_ship_purpose();
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-b2b-ship-purpose-deactivate':
                Input::put('ship-purpose-status', 'post', 'DEACTIVE');
                $form = \CNS_SHIP_CLUSTERController::change_status_ship_purpose();
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;

              case 'cns-api-b2b-ship-purpose-delete':
                Input::put('update-status', 'post', 'DELETED');
                $form = \CNS_SHIP_CLUSTERController::delete_ship_purpose($access_data->id);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
            

                # SHIP ITEM
              case 'cns-api-b2b-ship-item-creation':
                $form = \CNS_SHIP_CLUSTERController::record_ship_item($access_data);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-b2b-ship-item-update':
                $form = \CNS_SHIP_CLUSTERController::edit_ship_item($access_data);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-b2b-ship-item-list':

                $_filter_condtion_ = " AND cns_express_ship_item.cns_platform = $access_data->cns_platform AND cns_express_ship_item.cns_b2b = $access_data->cns_b2b  ";
                $_startdate_ = !Input::checkInput('filter-start-date', 'post', 1) ? "" : Str::data_in(strtotime(Input::get('filter-start-date', 'post')));
                $_enddate_ = !Input::checkInput('filter-end-date', 'post', 1) ? "" : Str::data_in(strtotime(Input::get('filter-end-date', 'post')));
                $_keyword_ = !Input::checkInput('filter-keyword', 'post', 1) ? "" : Str::data_in(Input::get('filter-keyword', 'post'));

                if ($_startdate_ != '')
                  $_filter_condtion_ .= " AND cns_express_ship_item.creation_datetime >= $_startdate_ ";
                if ($_enddate_ != '')
                  $_filter_condtion_ .= " AND cns_express_ship_item.creation_datetime <= $_enddate_ ";
                if ($_keyword_ != '')
                $_filter_condtion_ .= " AND (cns_express_ship_item.name LIKE  '%$_keyword_%')";

                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::getShipItems($_filter_condtion_);
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
  
              case 'cns-api-b2b-ship-item-data':
                if (Input::checkInput('_id_', 'post', 1)):
                  $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
                  $_DATA_ = \CNS_SHIP_CLUSTERController::getInfoShipItemByID($_ID_);
                  if ($_DATA_):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                    $response['data'] = $_DATA_;
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
  
              case 'cns-api-b2b-ship-item-activate':
                Input::put('ship-item-status', 'post', 'ACTIVE');
                $form = \CNS_SHIP_CLUSTERController::change_status_ship_item();
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-b2b-ship-item-deactivate':
                Input::put('ship-item-status', 'post', 'DEACTIVE');
                $form = \CNS_SHIP_CLUSTERController::change_status_ship_item();
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;

              case 'cns-api-b2b-ship-item-deleted':
                Input::put('update-status', 'post', 'DELETED');
                $form = \CNS_SHIP_CLUSTERController::delete_ship_item($access_data->id);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;



              # PRODUCT PROHIBITED
              case 'cns-api-b2b-product-prohibited-creation':
                $form = \CNS_SHIP_CLUSTERController::record_product_prohibited($access_data);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-b2b-product-prohibited-update':
                $form = \CNS_SHIP_CLUSTERController::edit_product_prohibited($access_data);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-b2b-product-prohibited-list':
                $_filter_condtion_ = "";
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::getProductProhibited($_filter_condtion_);
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
  
              case 'cns-api-b2b-product-prohibited-data':
                if (Input::checkInput('_id_', 'post', 1)):
                  $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
                  $_DATA_ = \CNS_SHIP_CLUSTERController::getInfoProductProhibitedByID($_ID_);
                  if ($_DATA_):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                    $response['data'] = $_DATA_;
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
  
              case 'cns-api-b2b-product-prohibited-activate':
                Input::put('product-prohibited-status', 'post', 'ACTIVE');
                $form = \CNS_SHIP_CLUSTERController::change_status_product_prohibited();
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-b2b-product-prohibited-deactivate':
                Input::put('product-prohibited-status', 'post', 'DEACTIVE');
                $form = \CNS_SHIP_CLUSTERController::change_status_product_prohibited();
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;

              case 'cns-api-b2b-product-prohibited-delete':
                Input::put('update-status', 'post', 'DELETED');
                $form = \CNS_SHIP_CLUSTERController::delete_product_prohibited($access_data->id);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;

              
              # SHIP COST ITEM
              case 'cns-api-b2b-ship-cost-item-creation':
                $form = \CNS_SHIP_CLUSTERController::record_ship_cost_item($access_data);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-b2b-ship-cost-item-update':
                $form = \CNS_SHIP_CLUSTERController::edit_ship_cost_item($access_data);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-b2b-ship-cost-item-list':
                $_filter_condtion_ = "";
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::getShipCostItems($_filter_condtion_);
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
  
              case 'cns-api-b2b-ship-cost-item-data':
                if (Input::checkInput('_id_', 'post', 1)):
                  $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
                  $_DATA_ = \CNS_SHIP_CLUSTERController::getInfoShipCostItemByID($_ID_);
                  if ($_DATA_):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                    $response['data'] = $_DATA_;
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
  
              case 'cns-api-b2b-ship-cost-item-activate':
                Input::put('ship-cost-item-status', 'post', 'ACTIVE');
                $form = \CNS_SHIP_CLUSTERController::change_status_ship_cost_item();
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-b2b-ship-cost-item-deactivate':
                Input::put('ship-cost-item-status', 'post', 'DEACTIVE');
                $form = \CNS_SHIP_CLUSTERController::change_status_ship_cost_item();
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;

              case 'cns-api-b2b-ship-cost-item-delete':
                Input::put('update-status', 'post', 'DELETED');
                $form = \CNS_SHIP_CLUSTERController::delete_ship_cost_item($access_data->id);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;


              # B2B INFO
              case 'cns-api-b2b-info-creation':
                $form = \CNS_SHIP_CLUSTERController::record_b2b_info($access_data);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-b2b-info-update':
                $form = \CNS_SHIP_CLUSTERController::edit_b2b_info($access_data);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-b2b-info-list':
                $_filter_condtion_ = "";
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::getB2bInfo($_filter_condtion_);
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
  
              case 'cns-api-b2b-info-data':
                if (Input::checkInput('_id_', 'post', 1)):
                  $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
                  $_DATA_ = \CNS_SHIP_CLUSTERController::getInfoB2bInfoByID($_ID_);
                  if ($_DATA_):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                    $response['data'] = $_DATA_;
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
  
              case 'cns-api-b2b-info-activate':
                Input::put('b2b-info-status', 'post', 'ACTIVE');
                $form = \CNS_SHIP_CLUSTERController::change_status_b2b_info();
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-b2b-info-deactivate':
                Input::put('b2b-info-status', 'post', 'DEACTIVE');
                $form = \CNS_SHIP_CLUSTERController::change_status_b2b_info();
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;

              case 'cns-api-b2b-info-delete':
                Input::put('update-status', 'post', 'DELETED');
                $form = \CNS_SHIP_CLUSTERController::delete_b2b_info($access_data->id);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  


              # SHIP PACKAGE
              case 'cns-api-ship-package-creation':
                $form = \CNS_SHIP_CLUSTERController::record_ship_package($access_data);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-ship-package-update':
                $form = \CNS_SHIP_CLUSTERController::edit_ship_package($access_data);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-ship-package-list':
                $_filter_condtion_ = "";
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::getShipPackages($_filter_condtion_);
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
  
              case 'cns-api-ship-package-data':
                if (Input::checkInput('_id_', 'post', 1)):
                  $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
                  $_DATA_ = \CNS_SHIP_CLUSTERController::getInfoShipPackageByID($_ID_);
                  if ($_DATA_):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                    $response['data'] = $_DATA_;
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
  
              case 'cns-api-ship-package-activate':
                Input::put('ship-package-status', 'post', 'ACTIVE');
                $form = \CNS_SHIP_CLUSTERController::change_status_ship_package();
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-ship-package-deactivate':
                Input::put('ship-package-status', 'post', 'DEACTIVE');
                $form = \CNS_SHIP_CLUSTERController::change_status_ship_package();
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;

              case 'cns-api-ship-package-delete':
                Input::put('update-status', 'post', 'DELETED');
                $form = \CNS_SHIP_CLUSTERController::delete_ship_package($access_data->id);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;



              # SOURCE COUNTRY
              case 'cns-api-source-country-creation':
                $form = \CNS_SHIP_CLUSTERController::record_source_country($access_data);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-source-country-update':
                $form = \CNS_SHIP_CLUSTERController::edit_source_country($access_data);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-source-country-list':
                $_filter_condtion_ = "";
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::getSourceCountry($_filter_condtion_);
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
  
              case 'cns-api-source-country-data':
                if (Input::checkInput('_id_', 'post', 1)):
                  $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
                  $_DATA_ = \CNS_SHIP_CLUSTERController::getInfoSourceCountryByID($_ID_);
                  if ($_DATA_):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                    $response['data'] = $_DATA_;
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
  
              case 'cns-api-source-country-activate':
                Input::put('source-country-status', 'post', 'ACTIVE');
                $form = \CNS_SHIP_CLUSTERController::change_status_source_country();
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-source-country-deactivate':
                Input::put('source-country-status', 'post', 'DEACTIVE');
                $form = \CNS_SHIP_CLUSTERController::change_status_source_country();
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;

              case 'cns-api-source-country-delete':
                Input::put('update-status', 'post', 'DELETED');
                $form = \CNS_SHIP_CLUSTERController::delete_source_country($access_data->id);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;



              # DESTINATION COUNTRY
              case 'cns-api-destination-country-creation':
                $form = \CNS_SHIP_CLUSTERController::record_destination_country($access_data);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-destination-country-update':
                $form = \CNS_SHIP_CLUSTERController::edit_destination_country($access_data);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-destination-country-list':
                $_filter_condtion_ = "";
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::getDestinationCountry($_filter_condtion_);
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
  
              case 'cns-api-destination-country-data':
                if (Input::checkInput('_id_', 'post', 1)):
                  $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
                  $_DATA_ = \CNS_SHIP_CLUSTERController::getInfoDestinationCountryByID($_ID_);
                  if ($_DATA_):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                    $response['data'] = $_DATA_;
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
  
              case 'cns-api-destination-country-activate':
                Input::put('destination-country-status', 'post', 'ACTIVE');
                $form = \CNS_SHIP_CLUSTERController::change_status_destination_country();
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-destination-country-deactivate':
                Input::put('destination-country-status', 'post', 'DEACTIVE');
                $form = \CNS_SHIP_CLUSTERController::change_status_destination_country();
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;

              case 'cns-api-destination-country-delete':
                Input::put('update-status', 'post', 'DELETED');
                $form = \CNS_SHIP_CLUSTERController::delete_destination_country($access_data->id);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;



              # SHIP UNIT
              case 'cns-api-ship-unit-creation':
                $form = \CNS_SHIP_CLUSTERController::record_ship_unit($access_data);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-ship-unit-update':
                $form = \CNS_SHIP_CLUSTERController::edit_ship_unit($access_data);
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-ship-unit-list':

                $_filter_condtion_ = " AND cns_express_ship_unit.cns_platform = $access_data->cns_platform AND cns_express_ship_unit.cns_b2b = $access_data->cns_b2b  ";
                $_startdate_ = !Input::checkInput('filter-start-date', 'post', 1) ? "" : Str::data_in(strtotime(Input::get('filter-start-date', 'post')));
                $_enddate_ = !Input::checkInput('filter-end-date', 'post', 1) ? "" : Str::data_in(strtotime(Input::get('filter-end-date', 'post')));
                $_keyword_ = !Input::checkInput('filter-keyword', 'post', 1) ? "" : Str::data_in(Input::get('filter-keyword', 'post'));
                if ($_startdate_ != '')
                  $_filter_condtion_ .= " AND cns_express_ship_unit.creation_datetime >= $_startdate_ ";
                if ($_enddate_ != '')
                  $_filter_condtion_ .= " AND cns_express_ship_unit.creation_datetime <= $_enddate_ ";
                if ($_keyword_ != '')
                $_filter_condtion_ .= " AND (cns_express_ship_unit.name LIKE  '%$_keyword_%')";

                $cns_b2b = $access_data->cns_b2b;
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::getShipUnits($_filter_condtion_ , $cns_b2b);
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
  
              case 'cns-api-ship-unit-data':
                if (Input::checkInput('_id_', 'post', 1)):
                  $_ID_ = $HASH->decryptAES(Input::get('_id_', 'post'));
                  $_DATA_ = \CNS_SHIP_CLUSTERController::getInfoShipUnitByID($_ID_);
                  if ($_DATA_):
                    $response['status'] = SUCCESS;
                    $response['message'] = 'Operation success!';
                    $response['data'] = $_DATA_;
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
  
              case 'cns-api-ship-unit-activate':
                Input::put('ship-unit-status', 'post', 'ACTIVE');
                $form = \CNS_SHIP_CLUSTERController::change_status_ship_unit();
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;
  
              case 'cns-api-ship-unit-deactivate':
                Input::put('ship-unit-status', 'post', 'DEACTIVE');
                $form = \CNS_SHIP_CLUSTERController::change_status_ship_unit();
                if ($form->ERRORS == false):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'Operation success!';
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = $form->ERRORS_SCRIPT;
                endif;
                Json::echo ($response);
                break;

              case 'cns-api-ship-unit-delete':
                Input::put('update-status', 'post', 'DELETED');
                $form = \CNS_SHIP_CLUSTERController::delete_ship_unit($access_data->id);
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
               
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_data_source_country_list_options($_filter_condtion_);
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
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_data_destination_country_list_options($_filter_condtion_);
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
                
              #PROVINCE LIST OPTION
              case 'cns-api-data-province-list-option':
                $_filter_condition_ = "";
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_data_province_list_options($_filter_condition_);
                if ($_LIST_DATA_):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'SUCCESS';
                  $response['data']['province'] = $_LIST_DATA_;
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = 'EMPTY';
                endif;
                Json::echo($response);
                break;

              #CITIES LIST OPTION
              case 'cns-api-data-city-list-option':
                $_filter_condition_ = "";
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_data_city_list_options($_filter_condition_);
                if ($_LIST_DATA_):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'SUCCESS';
                  $response['data']['city'] = $_LIST_DATA_;
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = 'EMPTY';
                endif;
                Json::echo($response);
                break;


              #UNIT LIST OPTION
              case 'cns-api-data-unit-list-options':
                $_filter_condtion_ = "";
                $cns_b2b = $access_data->cns_b2b;
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_data_unit_list_options($_filter_condtion_);
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
                

              # Source Pickup Type
              case 'cns-api-data-source-pickup-type':
                $_filter_condtion_ = " AND cns_express_ship_pickup_types.category = 'SOURCE' ";
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_data_pickup_types_list_options($_filter_condtion_);
                if ($_LIST_DATA_):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'SUCCESS';
                  $response['data']['pickuptype']['source'] = $_LIST_DATA_;
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = 'EMPTY';
                endif;
                Json::echo ($response);
                break;

              # Destination Pickup Type
              case 'cns-api-data-destination-pickup-type':
                $_filter_condtion_ = " AND cns_express_ship_pickup_types.category = 'DESTINATION' ";
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_data_pickup_types_list_options($_filter_condtion_);
                if ($_LIST_DATA_):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'SUCCESS';
                  $response['data']['pickuptype']['destination'] = $_LIST_DATA_;
                else:
                  $response['status'] = FAILLURE;
                  $response['message'] = 'EMPTY';
                endif;
                Json::echo ($response);
                break;



              # ship purpose
              case 'cns-api-data-ship-purpose':
                $_filter_condtion_ = "";
                $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_data_ship_purpose_list_options($_filter_condtion_);
                $response['data']['shippurpose'] = $_LIST_DATA_;
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



              #STAT TOTAL 
              case 'cns-api-data-stat-total':
                $_filter_condtion_ = " ";
                // $_filter_condtion_ = " AND cns_b2b = $_CNSHEADERS_->CNSB2B ";
                $_LIST_DATA_ = \CNS_STATS::cns_express_stats_dashboard_count_total($_filter_condtion_);
                $_LIST_DATA_5_LAST_SHIP_ = \CNS_STATS::cns_stats_express_dashboard_5_last_ship($_filter_condtion_);

                if ($_LIST_DATA_):
                  $response['status'] = SUCCESS;
                  $response['message'] = 'SUCCESS';
                  $response['data'] = $_LIST_DATA_;
                  $response['ship'] = $_LIST_DATA_5_LAST_SHIP_;
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