<?php
// Set up enviroment
$temp_enviroment = 'development';
define('ENVIRONMENT', $temp_enviroment);

if (defined('ENVIRONMENT'))
{
	switch (ENVIRONMENT)
	{
		case 'development':
			error_reporting(E_ALL);
		break;
		case 'production':
			error_reporting(0);
		break;
		default:
			exit('The application environment is not set correctly.');
	}
}

/**********************************************************************************************/
/***************************************** KEEP IT SIMPLE *************************************/
/**********************************************************************************************/
if(ENVIRONMENT == 'production')
{
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'test_adm');
	define('DB_USER', 'test_adm');
	define('DB_PASSWORD', 'hAP!334hsdsad2');
	define('DB_PORT', '3306');
}
else
{
	define('DB_HOST', 'localhost');
	define('DB_NAME', 'test_adm');
	define('DB_USER', 'test_adm');
	define('DB_PASSWORD', 'hAP!334hsdsad2');
	define('DB_PORT', '3306');
}


define('CORE', CORE_PATH .'core/');
define('FUNCTIONS', CORE_PATH.'functions/');
define('MODELS', CORE_PATH.'models/');
define('VIEWS', CORE_PATH.'views/');
define('CONTROLLERS', CORE_PATH.'controllers/');

define('AUTOLOAD', serialize(array(FUNCTIONS, MODELS, VIEWS, CONTROLLERS)));

// Require Class autoloader
require_once CORE_PATH . '/autoload.php';

$Router = new Router(); 