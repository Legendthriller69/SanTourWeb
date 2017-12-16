<?php
namespace SanTourWeb;

use SanTourWeb\Library\Router;

session_start();

// Constants
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)));
define('APPPATH', realpath(ROOT.DS.'app'));
define('LIBPATH', realpath(ROOT.DS.'library'));
define('ASSETSPATH', realpath(ROOT.DS.'assets'));

define('ABSURL', 'http://localhost/SanTourWeb');

define('DEBUG_LEVEL', 2);

require LIBPATH.DS.'autoload.php';
require LIBPATH.DS.'function.php';
require __DIR__.DS.'vendor/autoload.php';

define('FIREBASE_URL', 'https://santour-e9abc.firebaseio.com/');

$_SESSION['lang'] = (isset($_SESSION['lang'])) ? $_SESSION['lang'] : 'fr';

//Load Router
$rooter = new Router();
$rooter->SetErrorReporting();

//Run
$rooter->CallHook();