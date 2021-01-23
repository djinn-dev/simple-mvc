<?php
// Error Handling
if(!isset($routes) || empty($routes))
{
	throw new Exception('Routes config array is missing/empty.');
}

// Set Pathing
$path = [];
$methodName = 'index';
if($_SERVER['REQUEST_URI'] == '/')
{
	$className = ucfirst($routes['default_controller']);
}
else
{
	$path = explode('/', $_SERVER['REQUEST_URI']);
	$path = array_filter($path, fn($value) => !is_null($value) && $value !== '');

	$className = ucfirst($path[1]);

	if(isset($path[2]))
	{
		$methodName = $path[2];
	}
}

// Load Controller
$filename = APP_PATH . '/controllers/' . $className . '.php';
if(!file_exists($filename))
{
	throw new Exception('Route does not exist. Please check your URL and try again.');
}
require_once $filename;

// Run Controller
$route = new $className();
if(sizeof($path) > 2)
{
	unset($path[1]);
	unset($path[2]);

	$route->$methodName(...array_values($path));
}
else
{
	$route->$methodName();
}