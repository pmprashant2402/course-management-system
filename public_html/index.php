<?php

/*

@author : Prashant Mishra
Project: Course Management system
Date: 28/03/2021

like server here we have public_html folder and inside that we have index.php.
This is first page which will load when you will run the project.
.htaccess is used.

here we are magic funcion autload, which will load the class by default.

*/


error_reporting(E_ALL);
ini_set('display_errors', 1);
//Define autoloader
function __autoload($className)
{
    if (file_exists($className . '.php')) {
        require_once $className . '.php';
        return true;
    }
    return false;
}

function dd($data)
{
    echo '<pre>';
    print_r($data);
    die();
}


define('ROOT_PATH', dirname(dirname($_SERVER['SCRIPT_FILENAME'])) . '/');
define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . '/');
define('BASE_PATH', __DIR__ . '/');
define('ENV', 'DEVELOPMENT');
define('PUBLIC_DIR', 'public_html');
define('DEFAULT_CONTROLLER', 'Default');
define('DEFAULT_METHOD', 'index');
define('EXT', '.php');
define('SUCCESS', '1');
define('FAILED', '0');

$path = substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], PUBLIC_DIR) + strlen(PUBLIC_DIR));
if (ENV == 'DEVELOPMENT') {
    $path = substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], PUBLIC_DIR) + strlen(PUBLIC_DIR));
}
define('BASE_URL', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'] . substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], PUBLIC_DIR) + strlen(PUBLIC_DIR)));
define('REQUEST_URL', $path);
require_once( ROOT_PATH . 'config/Routes.php');

$routes = new Routes($path);
try {
    __autoload($routes->controllerPath);
    $obj = new $routes->controllerName();
    $obj->{$routes->functionName}();
} catch (\Exception $ex) {
    echo $ex->getMessage();
}