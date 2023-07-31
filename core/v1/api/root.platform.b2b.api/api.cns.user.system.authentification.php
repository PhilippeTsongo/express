<?php
header("Content-Type:application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once '../../core/init.php';

$response = array();
$response['status'] = BAD_REQUEST;
$response['message'] = "Bad Request";

// $kernData = CNS_B2B_USERS_AccountController::checkToken("eb97a804249a3e132ae1844bb64cd0da15fc79d2e476c955b6abf31c1c82b847");
// echo json_encode( $kernData  );

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

                                $token = Functions::getBasicAuthValue($headers);
                                $plain_token = base64_decode($token);
                                $plain_token = explode("::", $plain_token);
                                $email = @$plain_token[1];
                                $password = @$plain_token[2];
                                $platform = @$plain_token[3];
                                $salt = CNS_B2B_USERS_AccountController::getAccountSalt($email);
                                $password = CNS_B2B_USERS_AccountController::hashPasswordWithSalt($password, $salt);

                                # Check If Platform Exists
                                if( ($platform_data = CNS_B2B_USERS_AccountController::checkPlatformExist($platform)) ):

                                    # check if accountExist 
                                    if (CNS_B2B_USERS_AccountController::checkAccountExist($email, $password, $platform_data->id)):

                                        $account_data = CNS_B2B_USERS_AccountController::getAccountData($email, $password);

                                        if ($account_data->status == "ACTIVE"):

                                            // if (strtotime(date("Y-m-d H:i:s")) <= ($account_data->auth_exipration_datetime)):
                                            //     $response['status'] = UNAUTHORIZED;
                                            //     $response['message'] = "Account User aldready logged in, please logout first";

                                            // else:
                                                $access_token = CNS_B2B_USERS_AccountController::hashPassword(md5(time() . rand() . $account_data->account_code . 'CNS'));
                                                $generated_time = strtotime(date("Y-m-d H:i:s"));
                                                $expiration_time = Dates::date_calculation_from_today($__diff_number_days__ = '+24 hours'); //  + 72 hours
                                                $token_data = array(
                                                    "auth_token" => $access_token,
                                                    "auth_generated_datetime" => $generated_time,
                                                    "auth_exipration_datetime" => $expiration_time,
                                                    "last_access" => time(),
                                                    "last_login" => time(),
                                                    "account_session" => 1,
                                                );
                                                $condition_data = array(
                                                    "id" => $account_data->id
                                                );

                                                if (CNS_B2B_USERS_AccountController::updateEntries($token_data, $condition_data)):
                                                    $response['status'] = SUCCESS;
                                                    $response['message'] = "Authenticated successfully";
                                                    $response['authData'] = array(
                                                        "auth_token" => $access_token,
                                                        "auth_generated_datetime" => $generated_time,
                                                        "auth_expiration_datetime" => $expiration_time,
                                                        "auth_platform" => Hash::encryptAuthToken($account_data->platform_root),
                                                    );
                                                    $response['userData'] = CNS_B2B_USERS_AccountController::getSessionAccountProfile($account_data->id);


                                                    /** EMAIL */
                                                    $_DATA_ = array(
                                                        'firstname' => $response['userData']->firstname,
                                                        'email' =>  $response['userData']->email,
                                                        // 'password' => $_client_password,
                                                        // 'b2b' => $_cns_b2bname,
                                                        // 'link' => "http://eshop.cnsplateforme.com/account",

                                                    );
                                                    CNS_EMAIL::send('CNSEMAIL.00006',  $_DATA_);

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

                                $token = Functions::getBearerAuthValue($headers);
                                $access_data = CNS_B2B_USERS_AccountController::checkToken($token);
                                if ($access_data):

                                    if (strtotime(date("Y-m-d H:i:s")) <= ($access_data->auth_exipration_datetime)):
                                        $expiration_time = time();
                                        $token_data = array(
                                            "auth_exipration_datetime" => $expiration_time,
                                            "last_access" => time(),
                                            "last_logout" => time(),
                                            "account_session" => 0,
                                        );
                                        $condition_data = array(
                                            "id" => $access_data->id
                                        );

                                        if (CNS_B2B_USERS_AccountController::updateEntries($token_data, $condition_data)):
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

                    case 'authentification_access':
                        if ($_SERVER['REQUEST_METHOD'] === 'POST'):
                            $headers = Functions::getRequestHeaders();
                            if ($headers):

                                $token = Functions::getBearerAuthValue($headers);
                                $access_data = CNS_B2B_USERS_AccountController::checkToken($token);
                                if ($access_data):

                                    if (strtotime(date("Y-m-d H:i:s")) <= ($access_data->auth_exipration_datetime)):
                                        $response['data'] = CNS_B2B_USERS_AccountController::getSessionAccountAccess($access_data);
                                        $response['status'] = SUCCESS;
                                        $response['message'] = "Successfully";
                                       
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