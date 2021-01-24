<?php
// Error Handling
if(!isset($routes) || empty($routes))
{
	throw new Exception('Routes config array is missing/empty.');
}

// Set Pathing
$variables = [];
$methodName = 'index';
$url = $_SERVER['REQUEST_URI'];
if($url == '/')
{
	// Load Default Controller
	$className = ucfirst($routes['default_controller']);
}
else
{
	// Handle Custom/Wildcard Routes
	unset($routes['default_controller']);
	if(!empty($routes))
	{
		$replacements = [
			'(:any)' => '([a-zA-Z0-9_-]+)',
			'(:num)' => '([0-9]+)',
			'(:alpha)' => '([a-zA-Z_-]+)',
		];
		foreach($routes as $key => $val)
		{
			$regex = strtr(str_replace('/', '\/', $key), $replacements);
			if(preg_match('/' . $regex . '/', $url))
			{
				$url = preg_replace('/' . $regex . '/', $val, $url);
				break;
			}
		}
	}

	// Turn URL into Usable Array
	$path = explode('/', $url);
	$path = array_filter($path, fn($value) => !is_null($value) && $value !== '');

	// Set Class Name and Handle Dashes
	$className = ucfirst($path[1]);
	$className = str_replace('-', '_', $className);
	unset($path[1]);

	if(isset($path[2]))
	{
		// Set Method Name and Handle Dashes
		$methodName = $path[2];
		$methodName = str_replace('-', '_', $methodName);
		unset($path[2]);

		// Handle URL Variables
		if(!empty($path))
		{
			$variables = array_values($path);
		}
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
if(!empty($variables))
{
	$route->$methodName(...$variables);
}
else
{
	$route->$methodName();
}