<?php
$error_message = '';
$form_error = false;
$form = (object) ['ERRORS' => false];

$request = Input::get('cnseshoprequest', 'get');
$url_struc['tree'] = Input::get('cnseshoprequest', 'get');
$url_struc['trunk'] = Input::get('trunk', 'get');
$url_struc['branch'] = Input::get('branch', 'get');
$url_struc['branch1'] = Input::get('branch1', 'get');
$url_struc['branch2'] = Input::get('branch2', 'get');
$var_branch = array();

if (Input::checkInput('branch', 'get', '1')) {
  $var_branch = explode('-', Input::get('branch', 'get'));
  $url_struc['branch'] = $var_branch[0];
}

$url_struc['branch-sub1'] = @$var_branch[1];
$url_struc['branch-sub2'] = @$var_branch[2];

if (Input::checkInput('request', 'post', '1')) {
  $post_request = Input::get('request', 'post');
  switch ($post_request) {
    case 'user_login':
      if (Input::checkInput('webToken', 'post', '1')) {
        $form = UserController::login();
        if ($form->ERRORS == false) {
          Redirect::to(DN . '/dashboard');
        } else {
        }
      }
      break;
  }
}

if (Input::checkInput('cnseshoprequest', 'get', '1')) {
  $post_request = Input::get('cnseshoprequest', 'get');
  switch ($post_request) {
    case 'logout':
      $db = DB::getInstance();
      $sessionName = Config::get('session/admin');
      $cookieName = Config::get('remember/session_name');
      $temp = Config::get('time/seconds');
      $user_ID = Session::get($sessionName);

        session_destroy();
        session_unset();
        session_regenerate_id(true);

        $sessionName = Config::get('session/vendor');
        $cookieName = Config::get('remember/vendor');

        if (isset($_COOKIE["$sessionName"])) {
          unset($_COOKIE["$sessionName"]);
          setcookie($sessionName, null, -1, '/');
          Cookie::delete($cookieName);
        }
      Redirect::to(DNWEB);
      break;

    case 'account':
      if (!$session_user->isLoggedIn()):
        Redirect::to(DNWEB);
      endif;
    case 'checkout':
      if (!$session_user->isLoggedIn()):
        Redirect::to(DNWEB);
      endif;
      break;
  }
}

if(Input::checkInput('oauth_', 'get', 1)):
  $_OAUTH_ = Input::get('oauth_', 'get');
  $_OAUTH_JSON_STRING_ = base64_decode( $_OAUTH_ );
  $_OAUTH_ARRAY_ = json_decode( $_OAUTH_JSON_STRING_ );
  $_OAUTH_REDIRECT_ = Input::checkInput('oredir_', 'get', 1)? base64_decode( Input::get('oredir_', 'get') ) : explode("?oauth_=", $_SERVER['REQUEST_URI'])[0];
  if( $_OAUTH_ARRAY_->status == 200):
      if(Input::checkInput('oauth_', 'get', 1) && Input::get('resource_', 'get') == 'LOGOUT'):
          session_destroy();
          session_unset();
          session_regenerate_id(true);
      else:
          Session::put(Config::get('session/session_name'), $_OAUTH_ARRAY_->authData->auth_token);
          Session::put(Config::get('session/session_time'), $_OAUTH_ARRAY_->authData->auth_generated_datetime);
          Session::put(Config::get('session/session_time_exp'), $_OAUTH_ARRAY_->authData->auth_exipration_datetime);
          Session::put(Config::get('session/session_data'), $_OAUTH_ARRAY_->userData);
      endif;
  endif;
  Redirect::to($_OAUTH_REDIRECT_);
endif;


?>