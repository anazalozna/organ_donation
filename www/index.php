<?php
/**
 * Created by Ana Zalozna
 * Date: 21/01/17
 * Time: 10:10 PM

    php.net was a big help
 */

require_once("config.php");

if(Config::get('global')['debug']){
	error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

//composer
require_once('./vendor/autoload.php');

//autoloads classes
spl_autoload_register(function ($className) {
	require_once("./system/$className.php");
});

//Routing
$route = new Router();
$route->setUrl($_SERVER['REQUEST_URI']);
$route->run();

session_start();

//Run controller
App::getInstance()->setRoute($route);
App::getInstance()->execute();