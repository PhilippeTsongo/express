<?php 

ob_start();
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
		// $redirect = $http.'://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		// header('HTTP/1.1 301 Moved Permanently');
		// header('Location: ' . $redirect);
		// exit();
	}
} else {
	$http = 'http';
}
// for test //
// $http = 'http';

function def()
{
	define("CT", "Controller");
	define("_", "/");
	define("view_session_off_", "views/app_session_off/");
	define("view_session_off", "views/app_session_off");
	define("P", ".php");
	define("PL", ".php");
	define("_PATH_", "/");
	define("_VIEWS_", "resources/views/");
	define("_PATH_VIEWS_", "./views/");
	define("DN", Config::get('url/home'));
	define('Controller_NS', 'app\Http\Controllers\\'); // NS => Namespace
	define('Url_NS', 'app\Http\Url\\');
	define("DNADMIN", DN . _ . Config::get('url/bk_dir'));
	define("SUCCESS", 200);
	define("BAD_REQUEST", 400);
	define("UNAUTHORIZED", 401);
	define("NOTSIGNEDIN", 402);
	define("NOT_FOUND", 404);
	define("FORBIDDEN", 403);
	define("BAD_REQUEST_METHOD", 405);
	define("NOT_REGISTERED", 406);
	define("FAILLURE", 500);
	define("TIMEZONECODE", "GMT+2");
	define("LOGFILE", "callback.log.txt");
	define("VIEW_TICKET_QR_IMAGE", DNADMIN . _ . 'data_system/ticket_qr/');
	define("ROOT_TICKET_QR_IMAGE", Config::get('filepath/ticket_qr/'));
	define("ROOT_TICKET_DESIGN_IMAGE", Config::get('filepath/ticket_design/'));
	define("EMAILFILE", Config::get('filepath/email_body'));
	define("SHIPQRFILE", Config::get('filepath/shipqr'));
}
// Initialize Global Date Class >> Timezone
require 'classes/Dates.php';

// Initialize Global Functions
require_once 'functions/global.php';


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
		'subscriber' => 'gino_hash',
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
		'session_name' => 'cns_user_ID',
		'admin' => 'cns_user_ID',
		'vendor' => 'vendor_session',
		'customer' => 'customer_session',
		'subscriber' => 'cns_hash',
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
		// 'home' => "$http://{$_SERVER['HTTP_HOST']}/cns/core/cns.platform.core.v1/",// Local
		'home' => "$http://{$_SERVER['HTTP_HOST']}",  // Live & Test
		'bk_dir' => "webservices",
		'web' => 'http://afriexpressglobal.cnsplateforme.com/user/login'

	),

	'webservice_api' => array(
		'authorization_key' => 'CNS.545854nd_fjhfdfjhhjfdhfdhfh40gyrXIMf1QvhnicUWQ',
	),
	'time' => array(
		'date_time' => Dates::get('D, Y-m-d h:i:s a'),
		'timestamp' => $time,
		'seconds' => $time,
		'browser_token_expiry' => 60 * 60 * 12,
	),
	'dev' => array(
		'devMode' => true
	),
	'rate' => array(
		'service_charge_commission' => 5
	),
	'logs' => array(
		'logs' => $_SERVER['DOCUMENT_ROOT'] . '/cns/core/cns.platform.core.v1/logs/logs.log',
	),
	'filepath' => array(
		// 'email_body' => $_SERVER['DOCUMENT_ROOT'] . '/cns.express/resource/email/', // Local
		'email_body' => '/opt/lampp/htdocs/cns.express/resource/email/', //Live & Test

		// 'shipqr' => $_SERVER['DOCUMENT_ROOT'] . '/cns.express/cloud/images/qr/', // Local
		'shipqr' => '/opt/lampp/htdocs/cns.express/cloud/images/qr/', //Live & Test
	)
);


// Load Classes
spl_autoload_register(function ($class) {

	$pathArray = explode("\\", $class);
	if (count($pathArray) > 1) {
		require_once $class . '.php';
	} else {
		require_once 'classes/' . $class . '.php';
	}

});

//Initialize Define
def();

require 'phpqrcode/qrlib.php';
$db = DB::getInstance();

$init = (object) [
	'db_status' => $db->connected(),
	'app_token' => microtime(true)
];

$appData = new AppData();
$HASH = new Hash();
$appData->setDBStatus($db->connected());

/* Logout */

if (Input::checkInput('logout', 'get', 0)) {
	$sessionName = Config::get('session/vendor');
	$cookieName = Config::get('remember/vendor');
}



?>