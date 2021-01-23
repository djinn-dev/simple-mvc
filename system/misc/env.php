<?php
// Handle Debugging and Environment Constants
if(in_array($_SERVER['SERVER_ADDR'], isset($devServers) ? $devServers : []))
{
	define('IS_DEV', true);
	define('IS_LIVE', false);

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
}
else
{
	define('IS_DEV', false);
	define('IS_LIVE', true);

	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
	error_reporting(0);
}