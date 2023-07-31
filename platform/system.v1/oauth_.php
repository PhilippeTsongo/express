<?php
require_once 'core/init.php';

$_OAUTH_ = Input::get('oauth_', 'get');
$_OAUTH_JSON_STRING_ = base64_decode( $_OAUTH_ );
$_OAUTH_ARRAY_ = json_decode( $_OAUTH_JSON_STRING_ );
if( $_OAUTH_ARRAY_->status == 200):
    if(Input::checkInput('resource_', 'get', 1) && Input::get('resource_', 'get') == 'LOGOUT'):
        session_destroy();
        session_unset();
        session_regenerate_id(true);
        Redirect::to(DNSIGNIN);
    else:
        Session::put(Config::get('session/session_name'), $_OAUTH_ARRAY_->authData->auth_token);
        Session::put(Config::get('session/session_platform'), $_OAUTH_ARRAY_->authData->auth_platform);
        Session::put(Config::get('session/session_time'), $_OAUTH_ARRAY_->authData->auth_generated_datetime);
        Session::put(Config::get('session/session_time_exp'), $_OAUTH_ARRAY_->authData->auth_expiration_datetime);
        Session::put(Config::get('session/session_data'), $_OAUTH_ARRAY_->userData);
        // Session::put($_OAUTH_ARRAY_->authData->auth_token, AppData::cns_auth_access($_OAUTH_ARRAY_->authData->auth_token));
        Redirect::to(DNADMIN.'?st=success');
    endif;
endif;
Redirect::to(DNSIGNIN);

echo json_encode($_SESSION);