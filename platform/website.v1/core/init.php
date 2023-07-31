<?php ob_start();
session_start();
// ini_set('session.save_path',realpath(dirname('sessions')));
//error_reporting(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_reporting(E_ALL ^ E_DEPRECATED);

//------------------//
// CONFIGURE HTTPS //

if ($_SERVER['HTTP_HOST'] != 'localhost' && $_SERVER['HTTP_HOST'] != '127.0.0.1') {
	$http = 'http';
	if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off") {
		//$redirect = $http.'://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		//header('HTTP/1.1 301 Moved Permanently');
		//header('Location: ' . $redirect);
		//exit();
	}
} else {
	$http = 'http';
}
// for test //
// $http = 'http';

function def()
{
	define("DN", Config::get('url/home'));
	define("_", "/");
	define("P", ".php");
	define("PL", ".php");
	define("CNS", ".php");
	define("CT", "Controller");
	define("CTRL", './app' . _ . 'controller' . PL);
	define("ROUTES", './views' . _ . 'routes' . PL);
	define("DNSIGNIN", DN . _ . 'login');
	define("view_session_off_", "views/app_session_off/");
	define("view_session_off", "views/app_session_off");
	define("_PATH_", "/");
	define("_VIEWS_", "views/");
	define("_PATH_VIEWS_", "./views/");
	define('Controller_NS', 'app\Http\Controllers\\'); // NS => Namespace
	define('Url_NS', 'app\Http\Url\\');
	define("DNADMIN", DN);
	define("DNROOT", DN);
	define("DNWEB", DN . cns_get_software_code() . cns_get_b2b_code());
	define("DNCLOUDIMAGE", Config::get('cloud/image'));
	// define("_APIURL_SHIPDOCS_", "http://127.0.0.1/cns.express/core/v1/cns/master/api/ship");
	define("_APIURL_SHIPDOCS_", "http://127.0.0.1:8081/cns.express/core/v1/cns/master/api/ship");
	define("SHIPQRFILE", Config::get('filepath/shipqr'));
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
		'browser_token_expiry' => 60 * 60 * 12,
	),
	'var' => array(
		'browser_token_name' => 'TimBrowse',
		'browser_token_ID' => 'TimBrowserID',
	),
	'session' => array(
		'admin' => 'user_ID',
		'session_name' => 'cnsu_auth',
		'session_data' => 'cnsu_data',
		'session_time' => 'cnsu_session_time',
		'session_time_exp' => 'cnsu_session_time_exp',
		'customer' => 'customer_session',
		'token_name' => 'token'
	),
	'submit' => array(
		'method' => ''
	),
	'token' => array(
		//'smskey' => "63e6292c250db86b80b8ac64a71e154e46622b79"
	),
	'url' => array(
		'app_dir' => "",
		'home' => "$http://{$_SERVER['HTTP_HOST']}/cns.express/platform/website.v1", // Local
		// 'home' => "$http://{$_SERVER['HTTP_HOST']}", //Live
		'admin_dir' => ""
	),
	'time' => array(
		'date_time' => Dates::get('Y-m-d h:i:s'),
		'day_date_time' => Dates::get('D, Y-m-d h:i:s a'),
		'date' => Dates::get('Y-m-d'),
		'time' => Dates::get('h:i:s'),
		'timestamp' => $time,
		'seconds' => $time,
		'browser_token_expiry' => 60 * 60 * 12,
	),
	'root' => array(
		'json_properties' => $_SERVER['DOCUMENT_ROOT'] . "/cns.express/resource/json/properties.json", // Lccal
		// 'json_properties' => "/opt/lampp/htdocs/cns.express/resource/json/properties.json" // Live
	),
	'cloud' => array(
		// 'image' => "$http://{$_SERVER['HTTP_HOST']}/cns.express/cloud/images/image/", // Lccal
		'image' => "http://cloud.cnsplateforme.com/" // Live
	),
	'dev' => array(
		'devMode' => true
	),
	'filepath' => array( 
		// 'shipqr' => $_SERVER['DOCUMENT_ROOT'] . '/cns.express/resource/data_system/shipqr/', // Local 
		// 'shipqr' => '/opt/lampp/htdocs/cns.express/resource/data_system/shipqr/', //Live & Test 

		
		// 'shipqr' => $_SERVER['DOCUMENT_ROOT'] . '/cns.express/cloud/images/qr/', // Local
		'shipqr' => '/opt/lampp/htdocs/cns.express/cloud/images/qr/', //Live & Test
	)
);

$uri = $_SERVER['REQUEST_URI'];
$uri_array = explode('?', $uri);
if (count($uri_array) > 1) {
	$uri_get = $uri_array[1];
	$uri_get_array = explode('&', $uri_get);
	for ($i = 0; $i < count($uri_get_array); $i++) {
		$uri_get_el = $uri_get_array[$i];
		$uri_get_el = explode('=', $uri_get_el);
		if ($uri_get_el) {
			$_GET[$uri_get_el[0]] = @$uri_get_el[1];
		}
	}
}

spl_autoload_register(function ($class) {
	$pathArray = explode("\\", $class);
	if (count($pathArray) > 1) {
		require_once $class . '.php';
	} else {
		require_once 'classes/' . $class . '.php';
	}
});

def();

$db = DB::getInstance();
$AppClass = new \App();
$HASH = new Hash();

$init = (object) [
	'db_status' => $db->connected(),
	'app_token' => microtime(true)
];

$appData = new AppData();
$appData->setDBStatus($db->connected());

/* START LOGIN CHECKING*/
$userClass = new \User();
$sessionName = Config::get('session/session_name');
if (Session::exists($sessionName)) {
} else {
	// Code
}
/* END LOGIN CHECKING*/

$session_user = new User();
$session_user_type = new UserType();
$_CNS_USER_AUTH_ = $HASH->encryptAES("");
$_CNS_USER_ = (object)array();
$_CNS_USER_->firstname = "";
$_CNS_USER_->lastname = ""; 
$_CNS_USER_->email = ""; 
$_CNS_USER_->telephone = ""; 

if ($session_user->isLoggedIn()) {
	$_CNS_USER_AUTH_ = $HASH->encryptAES(Session::get(Config::get('session/session_name')));
	$_CNS_USER_ = (Object) Session::get(Config::get('session/session_data'));

	// $_CNS_USER_->language = $_CNS_USER_->language == 'fr-lang' || $_CNS_USER_->language == 'eng-lang' ? $_CNS_USER_->language : 'fr-lang';

	// $GLOBALS['_Dictionary'] = new \Properties($_CNS_USER_->language);
	// $main_ = AppData::cns_platform_map_root_main(Session::get(Config::get('session/session_platform')));
}
$GLOBALS['_Dictionary'] = new \Properties('fr-lang');

$main_ = "web01/";




$__IMAGESPATH__  = DNADMIN . "/build/web01/assets";

$_CNSSOFTWAREWEB_ = "";
if (Input::checkInput('cnssoftware', 'get', 1) || Input::checkInput('cnsb2b', 'get', 1)):

	if (Input::checkInput('cnssoftware', 'get', 1) && Input::checkInput('cnsb2b', 'get', 1)):
		$_CNSSOFTWAREWEB_ = Input::get('cnssoftware', 'get');
	elseif (!Input::checkInput('cnssoftware', 'get', 1) && Input::checkInput('cnsb2b', 'get', 1)):
		$_CNSSOFTWAREWEB_ = Input::get('cnsb2b', 'get');
	endif;


	if ($_CNSSOFTWAREWEB_ == 'books'):
		Input::put('cnssoftware', 'books');
		Input::put('cnsb2b', '');
		$main_ = "web02/";
	elseif ($_CNSSOFTWAREWEB_ == 'cars'):
		Input::put('cnssoftware', 'books');
		Input::put('cnsb2b', '');
		$main_ = "web02/";
	endif;


endif;



$_CNS_ECHOP_ICON_ = "http://web.stock.cnsplateforme.com/img/logos/apple-touch-icon-114x114.png";
$_CNS_ESHOP_LOGO_ = "http://web.stock.cnsplateforme.com/img/logos/logo-white.png";
$_CNS_ESHOP_LOGO_WHITE_ = "http://web.store.cnsplateforme.com/img/logos/logo.png";







function cns_get_b2b_code()
{
	$cnsb2bcode = !Input::checkInput('cnsb2b', 'get', 1) ? "" : Input::get('cnsb2b', 'get');
	$cnsb2bcode = $cnsb2bcode == "" ? "" : "/" . $cnsb2bcode;
	return $cnsb2bcode;
}

function cns_get_software_code()
{
	$cnssoftwarecode = !Input::checkInput('cnssoftware', 'get', 1) ? "" : Input::get('cnssoftware', 'get');
	$cnssoftwarecode = $cnssoftwarecode == "" ? "" : "/" . $cnssoftwarecode;
	return $cnssoftwarecode;
}





function cns_get_b2b_in_url()
{
	$HASH = new \Hash();
	$cnsb2bcode = !Input::checkInput('cnsb2b', 'get', 1) ? "" : Input::get('cnsb2b', 'get');
	$cnsb2bcode = $cnsb2bcode == "" ? "" : ($cnsb2bcode);
	if ($cnsb2bcode == 'bcc')
		$cnsb2bcode = 28;
	return $HASH->encryptAES($cnsb2bcode);
}

function cns_get_software_in_url()
{
	$HASH = new \Hash();
	$cnssoftwarecode = !Input::checkInput('cnssoftware', 'get', 1) ? "" : Input::get('cnssoftware', 'get');
	$cnssoftwarecode = $cnssoftwarecode == "" ? "" : $HASH->encryptAES(1);
	return ($cnssoftwarecode);
}

function cns_get_product_id_in_url()
{
	$HASH = new \Hash();
	$cnseshopproduct = !Input::checkInput('token', 'get', 1) ? "" : Input::get('token', 'get');
	$cnseshopproduct = $cnseshopproduct == "" ? "" : $HASH->encryptAES(Hash::decryptToken($cnseshopproduct));
	return $cnseshopproduct;
}

function cns_get_product_name_in_url()
{
	$HASH = new \Hash();
	$cnseshopproductname = !Input::checkInput('cnseshopproductname', 'get', 1) ? "" : Input::get('cnseshopproductname', 'get');
	$cnseshopproductname = $cnseshopproductname == "" ? "" : $HASH->encryptAES($cnseshopproductname);
	return $cnseshopproductname;
}

function cns_get_request_in_url()
{
	$HASH = new \Hash();
	$cnsrequest = !Input::checkInput('cnseshoprequest', 'get', 1) ? "" : Input::get('cnseshoprequest', 'get');
	$cnsrequestpage = !Input::checkInput('cnspage', 'get', 1) ? "" : Input::get('cnspage', 'get');
	$cnsrequest = strtoupper($cnsrequest);
	$cnsrequestpage = strtoupper($cnsrequestpage);

	if ($cnsrequest == "ACCOUNT")
		$cnsrequest = "B2CACCOUNT";
	if($cnsrequestpage == "READBOOK")
		$cnsrequest = "B2CACCOUNTREADBOOK";

	$cnsrequest = $cnsrequest == "" ? "" : $HASH->encryptAES($cnsrequest);

	return $cnsrequest;
}

function cns_get_url()
{
	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
		$url = "https://";
	else
		$url = "http://";
	$url .= $_SERVER['HTTP_HOST'];
	$url .= $_SERVER['REQUEST_URI'];
	return $url;
}


function cns_get_dnweb()
{
	$dnweb = !Input::checkInput('cnseshoprequest', 'get', 1) ? "" : Input::get('cnseshoprequest', 'get');
	$cnssoftwarecode = strtoupper($dnweb);
	return $cnssoftwarecode;
}

# AUTHORIZATION
$_USERIP_ = Functions::getUserIP();
$_CNSPLATFORMCODE_ = 'CNSPTF.200450';
$_AUTHORIZATION_ = $HASH->encryptAES(rand(100, 999) . date('md') . ":::" . $_USERIP_ . ":::" . $_CNSPLATFORMCODE_ . ":::" . $_CNS_USER_AUTH_ . ":::" . date('dhism'));

define("_AUTHORIZATION_", $_AUTHORIZATION_);

# CNS B2B
$_CNSSOFTWARE_ = cns_get_software_in_url();

# CNS B2B
$_CNSB2B_ = cns_get_b2b_in_url();

# CNS B2B
$_CNSREQUEST_ = cns_get_request_in_url();

# CNS VISITED URL
$_CNSURL_ = cns_get_url();

# CNS B2B
$_CNSPRODUCTID_ = cns_get_product_id_in_url();

# CNS VISITED URL
$_CNSPRODUCTNAME_ = cns_get_product_name_in_url();

$_CNSESHOP_ = array(
	"KER" => array(
		"KEY01" => "$_AUTHORIZATION_",
		"KEY02" => $_CNSB2B_,
		"KEY03" => $_CNSREQUEST_,
		"KEY04" => $_CNSPRODUCTID_,
		"KEY05" => $_CNSPRODUCTNAME_,
		"KEY06" => $_CNSURL_,
		"KEY07" => $_CNSSOFTWARE_,
		"KEY08" => DN,
		"KEY09" => DNWEB,
		"KEY10" => DNCLOUDIMAGE,

		"KEY11" => $HASH->encryptAES("ADDCART"),
		"KEY12" => $HASH->encryptAES("LISTCART"),
		"KEY13" => $HASH->encryptAES("EDITCART"),
		"KEY14" => $HASH->encryptAES("DELETECART"),
		"KEY15" => $HASH->encryptAES("EMPTYCART"),
		"KEY16" => $HASH->encryptAES("ORDERCART"),
		"KEY17" => $HASH->encryptAES("LISTORDERCART"),
		"KEY18" => $HASH->encryptAES("ORDERPAYMENT"),
		"KEY19" => $HASH->encryptAES("ADDCARTORDERNOW"),
	),
	"NEL" => array(
		"COUNTRY" => 0,
		"CITY" => 0,
		"PROVINCE" => 0,
		"ADDRESS" => "",

		"CURRENCY" => "",
		"LANGUAGE" => "",
		"CLASS" => 0,
		"SUBCLASS" => 0,

		"CATEGORY" => "",
		"KEYWORD" => "",
		"DATE01" => "",
		"DATE02" => ""
	)
);

$_CNSESHOP_ = base64_encode(json_encode($_CNSESHOP_));


$_PRODUCTNAME_ = Input::checkInput('cnsb2b', 'get', 1) ? "" : Input::get('cnsb2b', 'get');
$_PRODUCTNAME_ = str_replace("-", " ", $_PRODUCTNAME_);

# PAY MODE
$_CNSPAYMODE_ = (Object) [
	"CNSPAY_MOMO_AIRTEL_MTN_RW_VW" => (Object) [
		"CTA" => $HASH->encryptAES(1),
		"ICON" => '<img src="https://valwallet.com/home/build/img/home/mtnmomo.jpg"
			style="width: 30%;" alt="">
			<img src="https://valwallet.com/home/build/img/home/airtelmomo.png"
			style="width: 33%;" alt="">'
	],
];
?>