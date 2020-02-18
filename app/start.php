<?php
ob_start();
session_start();
/*
 * ---------------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ---------------------------------------------------------------
 */

define('DIR_PATH', dirname(__DIR__));
define('DS', DIRECTORY_SEPARATOR);
define('CORE_PATH', DIR_PATH . DS . 'app' . DS );

// Is the system path correct?
if ( ! is_dir(CORE_PATH))
{
	exit("Your system folder path does not appear to be set correctly.");
}

// Require Config values
require_once CORE_PATH . 'config.php';