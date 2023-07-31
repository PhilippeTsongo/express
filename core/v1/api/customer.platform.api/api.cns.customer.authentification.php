<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once '../../core/init.php';

$response = array();
$response['status'] = BAD_REQUEST;
$response['message'] = "Bad Request";

if (Input::checkInput('type', 'get', '1')):
    $gateway = Input::get('type', 'get');

    switch ($gateway):
        case 'account':

            if (Input::checkInput('resource', 'get', '1')):
                $request = Input::get('resource', 'get');
                switch ($request):
                    case 'authentification_sign_in':

                        # check if the method is Get
                        if ($_SERVER['REQUEST_METHOD'] === 'POST'):
                            $headers = Functions::getRequestHeaders();
                            if ($headers):

                                # AUTH CNSWEB
                                $AuthToken = AppHeaders::getCNSWEBAuthValue($headers);
                                $plainToken = $HASH->decryptAES($AuthToken);
                                $_plain_auth_block_ = explode(":::", $plainToken);
                                $_CLIENT_IP_ = (@$_plain_auth_block_[1]);
                                $_CNS_PLATFORM_ = (@$_plain_auth_block_[2]);

                                # CNS HEADERS
                                $_CNSHEADERS_ = (Object) [
                                    "AUTHORIZATION" => AppHeaders::getCNSWEBAuthValue($headers),
                                    "CNSPLATFORM" => $_CNS_PLATFORM_,
                                    "CNSSOFTWARE" => AppHeaders::getHeadersCNSTokenSoftware(),
                                    "CNSB2B" => AppHeaders::getHeadersCNSTokenB2B(),
                                    "CNSREQ" => AppHeaders::getHeadersCNSTokenReq(),
                                    "CNSREQID" => AppHeaders::getHeadersCNSTokenReqID(),
                                    "CNSREQNAME" => AppHeaders::getHeadersCNSTokenReqName(),
                                    "CNSREQURL" => AppHeaders::getHeadersCNSTokenReqUrl(),
                                    "CNSSIGNIN" => AppHeaders::getHeadersCNSTokenSignIn()
                                ];

                                # Check If Platform Exists
                                if (($platform_data = CNS_B2C_Controller::checkPlatformExist($_CNS_PLATFORM_)) && $_CNSHEADERS_->CNSSIGNIN != null):
                                    // $_CNSHEADERS_->CNSPLATFORM = 1; //$_CNS_PLATFORM_DATA_->id;
                                    $_CNSHEADERS_->CNSB2B = $_CNSHEADERS_->CNSB2B == "" ? 0 : $HASH->decryptAES($_CNSHEADERS_->CNSB2B);
                                    $_CNSHEADERS_->CNSREQID = $_CNSHEADERS_->CNSREQID == "" ? 0 : $HASH->decryptAES($_CNSHEADERS_->CNSREQID);
                                    $_CNSHEADERS_->CNSSOFTWARE = $_CNSHEADERS_->CNSSOFTWARE == "" ? 0 : $HASH->decryptAES($_CNSHEADERS_->CNSSOFTWARE);
                                    $_CNSHEADERS_->CNSB2B = Str::data_in($_CNSHEADERS_->CNSB2B);
                                    $_CNSHEADERS_->CNSSIGNIN = Hash::decrypt2bs64($_CNSHEADERS_->CNSSIGNIN);

                                    $plain_token = explode(":", $_CNSHEADERS_->CNSSIGNIN);
                                    $email = @$plain_token[1];
                                    $password = @$plain_token[2];

                                    $salt = CNS_B2C_Controller::getAccountSalt($email);
                                    $password = CNS_B2C_Controller::hashPasswordWithSalt($password, $salt);
                                    
                                    # check if accountExist 
                                    if (CNS_B2C_Controller::checkAccountExist($email, $password, $platform_data->id)):
 
                                        $account_data = CNS_B2C_Controller::getAccountData($email, $password);

                                        if ($account_data->status == "ACTIVE"):

                                            // if (strtotime(date("Y-m-d H:i:s")) <= ($account_data->auth_expiration_datetime)):
                                            //     $response['status'] = UNAUTHORIZED;
                                            //     $response['message'] = "Account User aldready logged in, please logout first  1111";
                                            // else:
                                            
                                                $access_token = CNS_B2C_Controller::hashPassword(md5(time() . rand() . $account_data->account_code . 'CNS'));
                                                $generated_time = strtotime(date("Y-m-d H:i:s"));
                                                $expiration_time = Dates::date_calculation_from_today($__diff_number_days__ = '+24 hours'); //  + 72 hours
                                                $token_data = array(
                                                    "auth_token" => $access_token,
                                                    "auth_generated_datetime" => $generated_time,
                                                    "auth_expiration_datetime" => $expiration_time,
                                                    "last_access" => time(),
                                                    "last_login" => time(),
                                                    "account_session" => 1,
                                                );
                                                $condition_data = array(
                                                    "id" => $account_data->id
                                                );

                                                if (CNS_B2C_Controller::updateEntries($token_data, $condition_data)):
                                                    $response['status'] = SUCCESS;
                                                    $response['message'] = "Authenticated successfully";
                                                    $response['authData'] = array(
                                                        "auth_token" => $access_token,
                                                        "auth_generated_datetime" => $generated_time,
                                                        "auth_exipration_datetime" => $expiration_time,
                                                    );
                                                    $response['userData'] = CNS_B2C_Controller::getSessionAccountProfile($account_data->id);
                                                else:
                                                    $response['status'] = FAILLURE;
                                                    $response['message'] = "Internal server error";
                                                endif;
                                            // endif;

                                        elseif ($account_data->status == "SUSPENDED"):
                                            $response['status'] = UNAUTHORIZED;
                                            $response['message'] = "Account is suspended";
                                        elseif ($account_data->status == "DEACTIVE"):
                                            $response['status'] = UNAUTHORIZED;
                                            $response['message'] = "Account is not activated";
                                        else:
                                            $response['status'] = UNAUTHORIZED;
                                            $response['message'] = "Invalid account";
                                        endif;
                                    else:
                                        $response['status'] = NOT_FOUND;
                                        $response['message'] = "Invalid password or username";
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

                    case 'authentification_sign_out':
                        if ($_SERVER['REQUEST_METHOD'] === 'POST'):
                            $headers = Functions::getRequestHeaders();
                            if ($headers):
                                
                                # AUTH CNSWEB
                                $AuthToken = AppHeaders::getCNSWEBAuthValue($headers);
                                $plainToken = $HASH->decryptAES($AuthToken);
                                $_plain_auth_block_ = explode(":::", $plainToken);
                                $_CLIENT_IP_ = (@$_plain_auth_block_[1]);
                                $_CNS_PLATFORM_ = (@$_plain_auth_block_[2]);
                                $_CNS_USER_TOKEN_ = $HASH->decryptAES(@$_plain_auth_block_[3]);

                                $access_data = CNS_B2C_Controller::checkToken($_CNS_USER_TOKEN_);
                                if ($access_data):

                                    if (strtotime(date("Y-m-d H:i:s")) <= ($access_data->auth_expiration_datetime)):
                                        $token_data = array(
                                            "auth_expiration_datetime" => time(),
                                            "last_access" => time(),
                                            "last_logout" => time(),
                                            "account_session" => 0,
                                        );
                                        $condition_data = array(
                                            "id" => $access_data->id
                                        );

                                        if (CNS_B2C_Controller::updateEntries($token_data, $condition_data)):
                                            $response['status'] = SUCCESS;
                                            $response['message'] = "Logout done successfully";
                                        else:
                                            $response['status'] = FAILLURE;
                                            $response['message'] = "Internal  server error";
                                        endif;
                                    else:
                                        $response['status'] = UNAUTHORIZED;
                                        $response['message'] = "Token Expired";
                                    endif;
                                else:
                                    $response['status'] = UNAUTHORIZED;
                                    $response['message'] = "invalid auth";
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


                    case 'authentification_sign_up':

                        # check if the method is Get
                        if ($_SERVER['REQUEST_METHOD'] === 'POST'):
                            $headers = Functions::getRequestHeaders();
                            if ($headers):

                                # AUTH CNSWEB
                                $AuthToken = AppHeaders::getCNSWEBAuthValue($headers);
                                $plainToken = $HASH->decryptAES($AuthToken);
                                $_plain_auth_block_ = explode(":::", $plainToken);
                                $_CLIENT_IP_ = (@$_plain_auth_block_[1]);
                                $_CNS_PLATFORM_ = (@$_plain_auth_block_[2]);

                                # CNS HEADERS
                                $_CNSHEADERS_ = (Object) [
                                    "AUTHORIZATION" => AppHeaders::getCNSWEBAuthValue($headers),
                                    "CNSPLATFORM" => $_CNS_PLATFORM_,
                                    "CNSSOFTWARE" => AppHeaders::getHeadersCNSTokenSoftware(),
                                    "CNSB2B" => AppHeaders::getHeadersCNSTokenB2B(),
                                    "CNSREQ" => AppHeaders::getHeadersCNSTokenReq(),
                                    "CNSREQID" => AppHeaders::getHeadersCNSTokenReqID(),
                                    "CNSREQNAME" => AppHeaders::getHeadersCNSTokenReqName(),
                                    "CNSREQURL" => AppHeaders::getHeadersCNSTokenReqUrl(),
                                    "CNSSIGNIN" => AppHeaders::getHeadersCNSTokenSignIn()
                                ];

                                # Check If Platform Exists
                                if (($platform_data = CNS_B2C_Controller::checkPlatformExist($_CNS_PLATFORM_))):
                                    // $_CNSHEADERS_->CNSPLATFORM = 1; //$_CNS_PLATFORM_DATA_->id;
                                    $_CNSHEADERS_->CNSB2B = $_CNSHEADERS_->CNSB2B == "" ? 0 : $HASH->decryptAES($_CNSHEADERS_->CNSB2B);
                                    $_CNSHEADERS_->CNSREQID = $_CNSHEADERS_->CNSREQID == "" ? 0 : $HASH->decryptAES($_CNSHEADERS_->CNSREQID);
                                    $_CNSHEADERS_->CNSSOFTWARE = $_CNSHEADERS_->CNSSOFTWARE == "" ? 0 : $HASH->decryptAES($_CNSHEADERS_->CNSSOFTWARE);
                                    $_CNSHEADERS_->CNSB2B = Str::data_in($_CNSHEADERS_->CNSB2B);
                                    $_CNSHEADERS_->CNSSIGNIN = Hash::decrypt2bs64($_CNSHEADERS_->CNSSIGNIN);

                                    $plain_token = explode(":", $_CNSHEADERS_->CNSSIGNIN);
                                    $email = @$plain_token[1];
                                    $password = @$plain_token[2];

                                    $_CNSBODY_ = AppData::getBodyData();
                                    $_CNSBODY_->password = $password;

                                    # Sign Up Customer
                                    $form = \CNS_B2C_Controller::signup_2bc($platform_data->id, $_CNSBODY_);
                                    if ($form->ERRORS == false):
                                        $response['status'] = SUCCESS;
                                        $response['message'] = 'Business Account Created Successfully! Welcome to CNS Platform';

                                        $access_token = CNS_B2C_Controller::hashPassword(md5(time() . rand() . 'CUSTOMER-CNS'));
                                        $generated_time = strtotime(date("Y-m-d H:i:s"));
                                        $expiration_time = Dates::date_calculation_from_today($__diff_number_days__ = '+24 hours'); //  + 72 hours
                                        $token_data = array(
                                            "auth_token" => $access_token,
                                            "auth_generated_datetime" => $generated_time,
                                            "auth_expiration_datetime" => $expiration_time,
                                            "last_access" => time(),
                                            "last_login" => time(),
                                            "account_session" => 1,
                                        );
                                        $condition_data = array(
                                            "id" => $form->CUSTOMERID
                                        );

                                        if (CNS_B2C_Controller::updateEntries($token_data, $condition_data)):
                                            $response['status'] = SUCCESS;
                                            $response['message'] = "Signed up successfully";
                                            $response['authData'] = array(
                                                "auth_token" => $access_token,
                                                "auth_generated_datetime" => $generated_time,
                                                "auth_exipration_datetime" => $expiration_time,
                                            );
                                            $response['userData'] = CNS_B2C_Controller::getSessionAccountProfile($form->CUSTOMERID);
                                        else:
                                            $response['status'] = FAILLURE;
                                            $response['message'] = "Internal server error";
                                        endif;
                                    else:
                                        $response['status'] = FAILLURE;
                                        $response['message'] = $form->ERRORS_SCRIPT;
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
            $response['message'] = "invalid payment gateway request";
            break;
    endswitch;
else:
endif;

echo json_encode($response);