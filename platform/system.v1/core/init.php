<?php 

ob_start();
session_start();
// ini_set('session.save_path',realpath(dirname('sessions')));
//error_reporting(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_reporting( E_ALL ^ E_DEPRECATED );

//------------------//
// CONFIGURE HTTPS //

if($_SERVER['HTTP_HOST'] != 'localhost' && $_SERVER['HTTP_HOST'] != '127.0.0.1'){
    $http = 'http';
    if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
        //$redirect = $http.'://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        //header('HTTP/1.1 301 Moved Permanently');
        //header('Location: ' . $redirect);
        //exit();
    }
}else{
    $http = 'http';
}
// for test //
// $http = 'http';

function def(){
	define("DN",Config::get('url/home'));
	define("_","/");
	define("P",".php");
	define("PL",".php");
	define("CNS",".php");
	define("CT","Controller");
	define("CTRL",'./app'._.'controller'.PL);
	define("ROUTES",'./views'._.'routes'.PL);
	define("DNSIGNIN",DN._.'login');
	define("view_session_off_","views/app_session_off/");
	define("view_session_off","views/app_session_off");
	define("_PATH_","/");
	define("_VIEWS_","views/");
	define("_PATH_VIEWS_","./views/");
	define('Controller_NS','app\Http\Controllers\\');  // NS => Namespace
	define('Url_NS','app\Http\Url\\');
	define("DNADMIN",DN);
	define("DNWEB",DN);
	define("LOGO_HA",DN._.'images/logo/healafrica.png');
}
// Initialize Global Date Class >> Timezone
require 'classes/Dates.php';
// Initialize Global Functions
require_once 'functions/global.php';
// $_SESSION['user_ID'] = 156;

$GLOBALS['config'] = array(
	'mysql' => array(
		// DB Local
		 'host' => 'localhost',
		 'username' => 'root',
		 'password' => '',
		 'db' => 'cns_express_db',
		 'port' => '3306'
	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cdv' => 'cdv_hash',
		'vendor' => 'vendor_hash',
		'customer' => 'customer_hash',
		'cookie_expiry' => 604800,
		'browser_token_expiry' => 60*60*12,
	),
	'var' => array(
		'browser_token_name' => 'TimBrowse',
		'browser_token_ID' => 'TimBrowserID',
	),
	'session' => array(
		'admin' 		=> 'storeuserID',
		'session_platform' => 'platform_ID',
		'session_access'  => 'storeuserID',
		'session_name'  => 'storeuserID',
		'session_data'  => 'user_data',
		'session_time'  => 'user_session_time',
		'session_time_exp'  => 'user_session_time_exp',
		'customer' 		=> 'customer_session',
		'token_name' 	=> 'token'
	),
	'submit' => array(
		'method' => ''
	),
	'token' => array(
		//'smskey' => "63e6292c250db86b80b8ac64a71e154e46622b79"
	),
	'url' => array(
		'app_dir'   => "",
		'home'      => "$http://{$_SERVER['HTTP_HOST']}/cns.express/platform/system.v1",  // Local
		// 'home' => "$http://{$_SERVER['HTTP_HOST']}",  // Live & Test
		'admin_dir' => "",
	),
	'mail' => array(
		'gmail'  => "$http://{$_SERVER['HTTP_HOST']}/mail_gmail",
	),
	'time' => array(
		'date_time' => Dates::get('Y-m-d h:i:s'),
		'day_date_time' => Dates::get('D, Y-m-d h:i:s a'),
		'date' => Dates::get('Y-m-d'),
		'time' => Dates::get('h:i:s'),
		'timestamp' => $time,
		'seconds' => $time,
		'browser_token_expiry' => 60*60*12,
	),
	'webservice_api' => array(
		'authorization_key' => "vCP2W+1en9dmpI/VI2WMxuflU5WbHvhnffjw",
	),
	'root' => array(
        'json_properties' => $_SERVER['DOCUMENT_ROOT'] . "/cns.express/resource/json/properties.json", // Local
        // 'json_properties' => "/opt/lampp/htdocs/cns/resource/json/properties.json" // Live
    ),
	'dev' => array(
		'devMode' => true
	)
);

$uri = $_SERVER['REQUEST_URI'];
$uri_array = explode('?',$uri);
if(count($uri_array)>1){
    $uri_get = $uri_array[1];
    $uri_get_array = explode('&',$uri_get);
    for($i=0;$i<count($uri_get_array);$i++){
        $uri_get_el = $uri_get_array[$i];
        $uri_get_el = explode('=',$uri_get_el);
        if($uri_get_el){
            $_GET[$uri_get_el[0]] = @$uri_get_el[1];
        }
    }
}

// Load Classes
spl_autoload_register (function ($class) {
	
		$pathArray = explode("\\", $class);
		if(count($pathArray)>1){
			require_once $class . '.php';
		}else{
			require_once 'classes/'.$class . '.php';
		}
});

//Initialize Define
def();

$db       = DB::getInstance();
$AppClass = new \App();
$HASH	  = new Hash();

$init = (object)[
		'db_status'=>$db->connected(),
		'app_token'=>microtime(true)
	];

$appData = new AppData();
$appData->setDBStatus($db->connected());

/* START LOGIN CHECKING*/
$userClass = new \User();
$sessionName = Config::get('session/session_name');
if(Session::exists($sessionName)){
}else{
}

$session_user      = new User();
$session_user_type = new UserType();
if($session_user->isLoggedIn()){
	$_CNS_USER_AUTH_ = Session::get(Config::get('session/session_name'));
	$_CNS_USER_      = (Object) Session::get(Config::get('session/session_data'));

	$_CNS_USER_->language = $_CNS_USER_->language == 'fr-lang' || $_CNS_USER_->language == 'eng-lang' ? $_CNS_USER_->language: 'fr-lang';

    $GLOBALS['_Dictionary'] = new \Properties($_CNS_USER_->language);
    $main_                  = 'admin/'; //AppData::cns_platform_map_root_main( Session::get(Config::get('session/session_platform')) );
}
$GLOBALS['_Dictionary'] = new \Properties('fr-lang');

 ?>
