<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once '../../core/init.php';

$response = array();
$response['status'] = BAD_REQUEST;
$response['message'] = "Bad Request";

// echo $HASH->encryptAES("SHIPDOCS");

if (Input::checkInput('type', 'get', '1')):
    $gateway = Input::get('type', 'get');

    switch ($gateway):
        case 'cnsship':

            if (Input::checkInput('resource', 'get', '1')):
                $request = Input::get('resource', 'get');
                switch ($request):

                    case 'data':

                        # check if the method is Get
                        if ($_SERVER['REQUEST_METHOD'] === 'POST'):
                            $headers = AppHeaders::getRequestHeaders();
                            if ($headers):

                                // echo $HASH->encryptAES("SHIP-CREATION");
                                // echo '   -   ';

                                # AUTH CNSWEB
                                $AuthToken = AppHeaders::getCNSWEBAuthValue($headers);
                                $plainToken = $HASH->decryptAES($AuthToken);
                                $_plain_auth_block_ = explode(":::", $plainToken);
                                $_CLIENT_IP_ = (@$_plain_auth_block_[1]);
                                $_CNS_PLATFORM_ = (@$_plain_auth_block_[2]);
                                $_CNS_USER_TOKEN_ = $HASH->decryptAES(@$_plain_auth_block_[3]);

                                # CNS HEADERS
                                $_CNSHEADERS_ = (object) [
                                    "AUTHORIZATION" => AppHeaders::getCNSWEBAuthValue($headers),
                                    "CNSPLATFORM" => $_CNS_PLATFORM_,
                                    "CNSSOFTWARE" => AppHeaders::getHeadersCNSTokenSoftware(),
                                    "CNSB2B" => AppHeaders::getHeadersCNSTokenB2B(),
                                    "CNSREQ" => AppHeaders::getHeadersCNSTokenReq(),
                                    "CNSREQID" => AppHeaders::getHeadersCNSTokenReqID(),
                                    "CNSREQNAME" => AppHeaders::getHeadersCNSTokenReqName(),
                                    "CNSREQURL" => AppHeaders::getHeadersCNSTokenReqUrl(),
                                ];

                                // echo $_CNSHEADERS_->CNSREQID;
                                # Check If Platform Exists
                                if (($_CNS_PLATFORM_DATA_ = CNS_B2B_USERS_AccountController::checkPlatformExist($_CNS_PLATFORM_))):
                                    $_CNSHEADERS_->CNSPLATFORM = 1; //$_CNS_PLATFORM_DATA_->id;
                                    $_CNSHEADERS_->CNSB2B = $_CNSHEADERS_->CNSB2B == "" ? 0 : $HASH->decryptAES($_CNSHEADERS_->CNSB2B);
                                    $_CNSHEADERS_->CNSREQID = $_CNSHEADERS_->CNSREQID == "" ? 0 : $HASH->decryptAES($_CNSHEADERS_->CNSREQID);
                                    $_CNSHEADERS_->CNSSOFTWARE = $_CNSHEADERS_->CNSSOFTWARE == "" ? 0 : $HASH->decryptAES($_CNSHEADERS_->CNSSOFTWARE);
                                    $_CNSHEADERS_->CNSREQ = $_CNSHEADERS_->CNSREQ == "" ? "" : $HASH->decryptAES($_CNSHEADERS_->CNSREQ);

                                    // echo $_CNSHEADERS_->CNSREQID . 'HEY THERE!';

                                    # CONNECTED USER
                                    $_CNSUSER_ = CNS_B2C_Controller::checkToken($_CNS_USER_TOKEN_);
                                    $_CNSB2C_ = 0;
                                    if ($_CNS_USER_TOKEN_ && $_CNSUSER_ && $_CNSUSER_->id > 0):
                                        $_CNSB2C_ = $_CNSUSER_->id;
                                    endif;

                                    # CNS BODY
                                    $_CNSBODY_ = AppData::getBodyData();

                                    $response['status'] = SUCCESS;
                                    $response['message'] = 'SUCCESS';

                                    # @PAGE HOME
                                    if ($_CNSHEADERS_->CNSREQ == "HOME"):

                                    endif;

                                    // Json::echo ($_CNSHEADERS_->CNSREQ);


                                    # @SHIP DOCS
                                    if ($_CNSHEADERS_->CNSREQ == "SHIPDOCS"):
                                        $_ID_ = $_CNSHEADERS_->CNSREQID;

                                        if ($_ID_ > 0):

                                            $_DATA_ = \CNS_SHIPController::getInfoShipByID($_ID_);
                                            $_LIST_DATA_ = \CNS_SHIPController::getShipStatusLogsListWeb($_ID_);
                                            $_DATA_ITEM = \CNS_SHIPController::getInfoShipItemByID($_ID_);

                                            if ($_DATA_):
                                                $response['status'] = SUCCESS;
                                                $response['message'] = 'Operation success!';
                                                $response['data'] = $_DATA_;
                                                $response['data_item'] = $_DATA_ITEM;
                                                $response['data']['shipstatus'] = $_LIST_DATA_;
                                            else:
                                                $response['status'] = FAILLURE;
                                                $response['message'] = "NOT_FOUND";
                                            endif;
                                        else:
                                            $response['status'] = FAILLURE;
                                            $response['message'] = "Required param.....";
                                        endif;

                                    else:
                                        # @PAGE B2C ACCOUNT
                                        if ($_CNSHEADERS_->CNSREQ == "B2CACCOUNT" || $_CNSHEADERS_->CNSREQ == "CLIENT_HOME" ):

                                            # Products
                                            if ($_CNSB2C_ > 0):
                                                $_filter_condtion_ = " ";
                                                $_CNS_B2C = $_CNSUSER_->id;
                                                $_LIST_SHIPS_ = \CNS_SHIPController::getB2CShips($_filter_condtion_, $_CNS_B2C);

                                                if ($_LIST_SHIPS_):
                                                    $response['status'] = SUCCESS;
                                                    $response['message'] = 'Operation success!';
                                                    $response['data']['account']['ships'] = $_LIST_SHIPS_;
                                                else:
                                                    $response['status'] = NOT_FOUND;
                                                    $response['message'] = 'Data not found';
                                                    $response['data']['account']['ships'] = array();
                                                endif;
                                            else:
                                                $response['status'] = FORBIDDEN;
                                                $response['message'] = 'Forbidden, user not authetenticated';
                                                $response['data']['account']['ships'] = array();
                                            endif;

                                        endif;

                                        # @SHIP DATA
                                        if ($_CNSHEADERS_->CNSREQ == "B2CSHIPDATA" || $_CNSHEADERS_->CNSREQ == "DETAIL_SHIP" ):
                                            $_ID_ = $_CNSHEADERS_->CNSREQID;

                                            if ($_ID_ > 0):

                                                $_DATA_ = \CNS_SHIPController::getInfoShipByID($_ID_);
                                                $_LIST_DATA_ = \CNS_SHIPController::getShipStatusLogsListWeb($_ID_);
                                                $_DATA_ITEM = \CNS_SHIPController::getInfoShipItemByID($_ID_);

                                                if ($_DATA_):
                                                    $response['status'] = SUCCESS;
                                                    $response['message'] = 'Operation success!';
                                                    $response['data']['account']['ship'] = $_DATA_;
                                                    $response['data']['account']['ship_status'] = $_LIST_DATA_;
                                                    $response['data']['item'] = $_DATA_ITEM;

                                                else:
                                                    $response['status'] = FAILLURE;
                                                    $response['message'] = "NOT_FOUND";
                                                endif;
                                            else:
                                                $response['status'] = FAILLURE;
                                                $response['message'] = "Required param";
                                            endif;
                                        endif;

                                        # @COMMON

                                        # Currency
                                        $_filter_condtion_ = " AND cns_data_currency.status = 'ACTIVE' ";
                                        $_LIST_DATA_CURRENCY__ = \CNS_SHIPController::get_data_currency_list_options($_filter_condtion_);
                                        $response['data']['currency'] = $_LIST_DATA_CURRENCY__;

                                        # B2B Info
                                        $_filter_condtion_ = " AND cns_b2b = 1 ";
                                        // if ($_CNSHEADERS_->CNSB2B != 0)
                                        //         $_filter_condtion_ = " AND cns_b2b = $_CNSHEADERS_->CNSB2B ";
                                        $_LIST_DATA_INFO_ = \CNS_SHIPController::cns_ship_company_data($_filter_condtion_);
                                        // $response['data']['info'] = $_LIST_DATA_INFO_;

                                        # Language
                                        $_LIST_DATA_LANGUAGE_ = array(
                                            array(
                                                'token_auth' => $HASH->encryptAES(1),
                                                'name' => 'French'
                                            ),
                                            array(
                                                'token_auth' => $HASH->encryptAES(2),
                                                'name' => 'English'
                                            )
                                        );


                                        #SOURCE COUNTRY LIST OPTION
                                        $_filter_condtion_ = " AND status = 'ACTIVE' ";
                                        // $_filter_condtion_ = " AND cns_b2b = $_CNSHEADERS_->CNSB2B ";
                                        $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_source_country_list_options($_filter_condtion_);
                                        $response['data']['sourcecountry'] = $_LIST_DATA_;


                                        #DESTINATION COUNTRY LIST OPTION
                                        $_filter_condtion_ = " AND status = 'ACTIVE' ";
                                        // $_filter_condtion_ = " AND cns_b2b = $_CNSHEADERS_->CNSB2B ";
                                        $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_destination_country_list_options($_filter_condtion_);
                                        $response['data']['destinationcountry'] = $_LIST_DATA_;




                                        #SOURCE PROVINCE LIST OPTION
                                        $_filter_condtion_ = "  ";
                                        // $_filter_condtion_ = " AND cns_b2b = $_CNSHEADERS_->CNSB2B ";
                                        $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_data_province_list_options($_filter_condtion_);
                                        $response['data']['province'] = $_LIST_DATA_;


                                        #DESTINATION CITY LIST OPTION
                                        $_filter_condtion_ = " ";
                                        // $_filter_condtion_ = " AND cns_b2b = $_CNSHEADERS_->CNSB2B ";
                                        $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_data_city_list_options($_filter_condtion_);
                                        $response['data']['city'] = $_LIST_DATA_;

                                        # PURPOSE
                                        $_filter_condtion_ = "";
                                        $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_data_ship_purpose_list_options($_filter_condtion_);
                                        $response['data']['shippurpose'] = $_LIST_DATA_;


                                        #SHIP ITEM TYPE LIST OPTION
                                        $_filter_condtion_ = " ";
                                        $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_data_item_type_list_options($_filter_condtion_);
                                        $response['data']['itemtype'] = $_LIST_DATA_;

                                        #SHIP ITEM UNIT LIST OPTION
                                        $_filter_condtion_ = " ";
                                        $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_data_item_unit_list_options($_filter_condtion_);
                                        $response['data']['itemunit'] = $_LIST_DATA_;

                                        #SHIP PICKUP TYPES LIST OPTION
                                        $_filter_condtion_ = " AND cns_express_ship_pickup_types.category = 'SOURCE' ";
                                        $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_data_pickup_types_list_options($_filter_condtion_);
                                        $response['data']['pickuptype']['source'] = $_LIST_DATA_;

                                        #SHIP PICKUP TYPES LIST OPTION
                                        $_filter_condtion_ = "  AND cns_express_ship_pickup_types.category = 'DESTINATION' ";
                                        $_LIST_DATA_ = \CNS_SHIP_CLUSTERController::get_data_pickup_types_list_options($_filter_condtion_);
                                        $response['data']['pickuptype']['destination'] = $_LIST_DATA_;

                                        //B2B Ship list

                                    endif;



                                else:
                                    $response['status'] = NOT_FOUND;
                                    $response['message'] = "Invalid Authentification";
                                endif;
                            else:
                                $response['status'] = FORBIDDEN;
                                $response['message'] = "Forbidden";
                            endif;
                        else:
                            $response['status'] = BAD_REQUEST_METHOD;
                            $response['message'] = "Method Not Allowed";
                        endif;

                        break;


                    case 'ship':
                        // $_USERIP_ = "10.10.10.10"; 
                        // $_CNSPLATFORMCODE_ = "CNSPTF.200450"; 
                        // $_CNS_USER_AUTH_ = $HASH->encryptAES("a3fc4ec05aaa3a85861900316812e02525035b8a09ec3b046227d3ee1c7148a3");
                        // $_AUTHORIZATION_ = $HASH->encryptAES(rand(100, 999) . date('md') . ":::" . $_USERIP_ . ":::" . $_CNSPLATFORMCODE_ . ":::" . $_CNS_USER_AUTH_ . ":::" . date('dhism'));

                        // echo $_AUTHORIZATION_;
                        // echo '   ) -   ';



                        # check if the method is Get
                        if ($_SERVER['REQUEST_METHOD'] === 'POST'):
                            $headers = AppHeaders::getRequestHeaders();
                            if ($headers):

                                # AUTH CNSWEB
                                $AuthToken = AppHeaders::getCNSWEBAuthValue($headers);
                                $plainToken = $HASH->decryptAES($AuthToken);
                                $_plain_auth_block_ = explode(":::", $plainToken);
                                $_CLIENT_IP_ = (@$_plain_auth_block_[1]);
                                $_CNS_PLATFORM_ = (@$_plain_auth_block_[2]);
                                $_CNS_USER_TOKEN_ = $HASH->decryptAES(@$_plain_auth_block_[3]);

                                // Json::echo($_plain_auth_block_);

                                # CNS HEADERS
                                $_CNSHEADERS_ = (object) [
                                    "AUTHORIZATION" => AppHeaders::getCNSWEBAuthValue($headers),
                                    "CNSPLATFORM" => $_CNS_PLATFORM_,
                                    "CNSSOFTWARE" => AppHeaders::getHeadersCNSTokenSoftware(),
                                    "CNSB2B" => AppHeaders::getHeadersCNSTokenB2B(),
                                    "CNSREQ" => AppHeaders::getHeadersCNSTokenReq(),
                                    "CNSREQID" => AppHeaders::getHeadersCNSTokenReqID(),
                                    "CNSREQNAME" => AppHeaders::getHeadersCNSTokenReqName(),
                                    "CNSREQURL" => AppHeaders::getHeadersCNSTokenReqUrl(),
                                ];

                                # Check If Platform Exists
                                if (($_CNS_PLATFORM_DATA_ = CNS_B2B_USERS_AccountController::checkPlatformExist($_CNS_PLATFORM_))):
                                    $_CNSHEADERS_->CNSPLATFORM = 1; //$_CNS_PLATFORM_DATA_->id;
                                    $_CNSHEADERS_->CNSB2B = 1; // $_CNSHEADERS_->CNSB2B == "" ? 0 : $HASH->decryptAES($_CNSHEADERS_->CNSB2B);
                                    $_CNSHEADERS_->CNSREQID = $_CNSHEADERS_->CNSREQID == "" ? 0 : $HASH->decryptAES($_CNSHEADERS_->CNSREQID);
                                    $_CNSHEADERS_->CNSSOFTWARE = $_CNSHEADERS_->CNSSOFTWARE == "" ? 0 : $HASH->decryptAES($_CNSHEADERS_->CNSSOFTWARE);
                                    $_CNSHEADERS_->CNSREQ = $_CNSHEADERS_->CNSREQ == "" ? "" : $HASH->decryptAES($_CNSHEADERS_->CNSREQ);

                                    # CONNECTED USER
                                    $_CNSUSER_ = CNS_B2C_Controller::checkToken($_CNS_USER_TOKEN_);
                                    $_CNSB2C_ = 0;
                                    if ($_CNS_USER_TOKEN_ && $_CNSUSER_ && $_CNSUSER_->id > 0):
                                        $_CNSB2C_ = $_CNSUSER_->id;
                                        $_CNSUSER_->cns_b2b = $_CNSHEADERS_->CNSB2B;
                                    endif;

                                    $_CNSHEADERS_->_CNSB2C_ = $_CNSB2C_;

                                    // echo " -- --- ) " . $_CNS_USER_TOKEN_ . " -- ---";

                                    # CNS BODY
                                    $_CNSBODY_ = AppData::getBodyData();
                                    $_POST = $_CNSBODY_->DATA;

                                    // Json::echo($_POST);

                                    $response['status'] = SUCCESS;
                                    $response['message'] = 'SUCCESS';

                                    # @PAGE SHIP CREATION 
                                    if ($_CNSHEADERS_->CNSREQ == "CREATE_SHIPMENT"):

                                        $form = \CNS_SHIPController::createShip($_CNSHEADERS_);
                                        if ($form->ERRORS == false):
                                            $response['status'] = SUCCESS;
                                            $response['message'] = 'Your submission request has been done successfully! We are redirecting...';
                                            $response['ctiship'] = $form->SHIPTOKEN;
                                        else:
                                            $response['status'] = FAILLURE;
                                            $response['message'] = $form->ERRORS_SCRIPT;
                                        endif;


                                    endif;


                                else:
                                    $response['status'] = NOT_FOUND;
                                    $response['message'] = "Invalid Authentification";
                                endif;
                            else:
                                $response['status'] = FORBIDDEN;
                                $response['message'] = "Forbidden";
                            endif;
                        else:
                            $response['status'] = BAD_REQUEST_METHOD;
                            $response['message'] = "Method Not Allowed";
                        endif;

                        break;



                    case 'currency':

                        # check if the method is Get
                        if ($_SERVER['REQUEST_METHOD'] === 'POST'):
                            $headers = Functions::getRequestHeaders();
                            if ($headers):

                                $token = Functions::getBasicAuthValue($headers);
                                $plain_token = base64_decode($token);
                                $plain_token = explode(":::", $plain_token);
                                $platform = base64_decode(@$plain_token[1]);

                                # Check If Platform Exists
                                if (($platform_data = CNS_B2B_USERS_AccountController::checkPlatformExist($platform))):

                                    $_filter_condtion_ = " AND cns_data_currency.status = 'ACTIVE' ";
                                    $_LIST_DATA_ = \CNS_CLUSTER_DataController::get_data_currency_list_options($_filter_condtion_);
                                    if ($_LIST_DATA_):
                                        $response['status'] = SUCCESS;
                                        $response['message'] = 'SUCCESS';
                                        $response['data'] = $_LIST_DATA_;
                                    else:
                                        $response['status'] = FAILLURE;
                                        $response['message'] = 'EMPTY';
                                    endif;
                                else:
                                    $response['status'] = NOT_FOUND;
                                    $response['message'] = "Invalid Authentification";
                                endif;
                            else:
                                $response['status'] = FORBIDDEN;
                                $response['message'] = "Forbidden";
                            endif;
                        else:
                            $response['status'] = BAD_REQUEST_METHOD;
                            $response['message'] = "Method Not Allowed";
                        endif;

                        break;



                    case 'language':

                        # check if the method is Get
                        if ($_SERVER['REQUEST_METHOD'] === 'POST'):
                            $headers = Functions::getRequestHeaders();
                            if ($headers):

                                $token = Functions::getBasicAuthValue($headers);
                                $plain_token = base64_decode($token);
                                $plain_token = explode(":::", $plain_token);
                                $platform = base64_decode(@$plain_token[1]);

                                # Check If Platform Exists
                                if (($platform_data = CNS_B2B_USERS_AccountController::checkPlatformExist($platform))):

                                    $_LIST_DATA_ = array(
                                        array(
                                            'token_auth' => $HASH->encryptAES(1),
                                            'name' => 'French'
                                        ),
                                        array(
                                            'token_auth' => $HASH->encryptAES(2),
                                            'name' => 'English'
                                        )
                                    );

                                    if ($_LIST_DATA_):
                                        $response['status'] = SUCCESS;
                                        $response['message'] = 'SUCCESS';
                                        $response['data'] = $_LIST_DATA_;
                                    else:
                                        $response['status'] = FAILLURE;
                                        $response['message'] = 'EMPTY';
                                    endif;
                                else:
                                    $response['status'] = NOT_FOUND;
                                    $response['message'] = "Invalid Authentification";
                                endif;
                            else:
                                $response['status'] = FORBIDDEN;
                                $response['message'] = "Forbidden";
                            endif;
                        else:
                            $response['status'] = BAD_REQUEST_METHOD;
                            $response['message'] = "Method Not Allowed";
                        endif;

                        break;

                endswitch;
            endif;
            break;

        default:
            $response['status'] = BAD_REQUEST;
            $response['message'] = "invalid gateway request";
            break;
    endswitch;
else:
endif;

echo json_encode($response);