<?php
//Global Configuration File

//**This is global configuration file which contains all the necessary php scripts and headers and required variables**//
//** to be used in different files and will be called back in header file.**//

/* Error Handlers */

//Errors and notices
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);//E_ALL
//error_reporting(0); //Hide All errors

//Enable gzip Compression
// if (!in_array('ob_gzhandler', ob_list_handlers())) {
//     ob_start('ob_gzhandler');
// } else {
//     ob_start();
// }

//Including the DB file
include_once 'db.config.php';

//Declaring default Date and Time Zone for Date Time Stamps
date_default_timezone_set('Asia/Kolkata');

//Allow Cross Access from Origin
header("Access-Control-Allow-Origin: *");

//Initialize the global session
if (!isset($_SESSION))
    session_start();

/* Global Declarations */
$title_constant = "";
$base_URI = "";
$base_API_Endpoint = "";
$site_status = ""; // PRODUCTION or DEVELOPMENT
$now = "";
$server_protocol = ""; ///HTTP or HTTPS
$site_host = ""; //localhost or live
$sid = ""; //Session ID

$user_id = "";

//Define BASE DIRECTORY
if(!defined('BASE_PATH'))
    define('BASE_PATH', dirname(__DIR__, 2));

/* AltoRouter */
require_once BASE_PATH . '/app/tools/router/AltoRouter/AltoRouter.php';

//Make Router Global
global $router, $db_conn, $term;

//Initialize AltoRouter
$router = new AltoRouter();

//Get Location of User
// $ip_address = $_SERVER['REMOTE_ADDR'];//$_SERVER['REMOTE_ADDR']
/*Get user ip address details with geoplugin.net*/
// $geopluginURL = 'http://www.geoplugin.net/php.gp?ip='.$ip_address;
// $addrDetailsArr = unserialize(file_get_contents($geopluginURL));
/*Get City name by return array*/
// $city = $addrDetailsArr['geoplugin_city'];
/*Get Country name by return array*/
// $country_name = $addrDetailsArr['geoplugin_countryName'];
// $country_code = $addrDetailsArr['geoplugin_countryCode'];

//** Define Base Routes for Services **//

//* Varaible Values * //

//Variable Assigns
$title_constant = "1Riel - Real Estate Marketplace";

$server_protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https' ? 'https' : 'http';

$server_protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://'; //Set the Protocol

$site_host = $_SERVER["HTTP_HOST"]; //Find the Current Host

$base_API_Endpoint = "/api/web/v1/requests/"; //All API requests are passed here

$site_status = "DEVELOPMENT"; //Current status of the Project | 'DEVELOPMENT' OR 'PRODUCTION'

if ($site_status === 'DEVELOPMENT') //If Site is still under development
{
    if ($site_host === 'localhost') //If the Site Host is localhost
    {
        $base_URI = $server_protocol . 'localhost/1riel'; //Local Demo Website
        $router->setBasePath('/1riel'); //Local Demo Path
    } else {
        $base_URI = $server_protocol . 'dev.1riel.com/'; //Our Demo Website or Preproduction URL
        $router->setBasePath(''); //Our Demo Website or Preproduction URL
    }
} else {
    $base_URI = $server_protocol . '1riel.com'; //Live Production Website
    $router->setBasePath(''); //Live Production Website
}

//Date & Time
$now = Date('d/m/Y H:i:s');
$current_date = explode(' ', $now)[0];
$current_time = explode(' ', $now)[1];

//$current_page = strtoupper(str_replace('-',' ',end(explode('/', trim($_SERVER["REQUEST_URI"], '/')))));

// print_r($_SESSION);exit;

// print_r($_SESSION);

//Values from SESSION
// $user_id = $_SESSION['uid'];

$current_url = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

/* Global Session Handlers */

$urlArray = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $urlArray);
$numSegments = count($segments);
$currentSegment = $segments[$numSegments - 1];

/* Handle Payment Gateways */

/* Razorpay */

//Razorpay Global Values
$keyId = 'rzp_test_jrtb9Rs7LXvqvV';
$keySecret = 'sJJBuvBXFhvAuOO9znOEmaYW';
$displayCurrency = 'INR';

/* Stripe */

//Stripe Global Values


// print_r($_GET);


//Handle User Sessions
if (!empty($_SESSION)) {

    //Get the Context form SESSION
    $term = $_SESSION['context'];

    $context = $_GET['context'];
    $route = $_GET['route'];

    // print_r($_REQUEST);

    if ($currentSegment === 'login')
        header('Location:' . $router->generate('dashboard') . '?context=' . $term . '&route=home');

    if ($currentSegment === 'dashboard')
        if (empty($context) || (empty($route)))
            header('Location:' . $router->generate('dashboard') . '?context=' . $term . '&route=home');
} else {

    if ($currentSegment === 'dashboard')
        header('Location:' . $router->generate('user-login'));
}
