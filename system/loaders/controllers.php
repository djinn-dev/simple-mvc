<?php
// Error Handling
if(!isset($routes) || empty($routes))
{
	throw new Exception('Routes config array is missing/empty.');
}

// Set Pathing
$variables = [];
$methodName = 'index';
$uri = getUri();
if($uri == '')
{
	// Load Default Controller
	$className = ucfirst($routes['default_controller']);
}
else
{
	$replacements = [
		'(:any)' => '([a-zA-Z0-9_-]+)',
		'(:num)' => '([0-9]+)',
		'(:alpha)' => '([a-zA-Z_-]+)',
	];

	// Handle Redirects
	if(!empty($redirects))
	{
		foreach($redirects as $key => $val)
		{
			$regex = strtr(str_replace('/', '\/', $key), $replacements);
			if(preg_match('/^' . $regex . '$/', $uri))
			{
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: " . siteUrl($val));
				exit;
			}
		}
	}

	// Handle Custom/Wildcard Routes
	unset($routes['default_controller']);
	if(!empty($routes))
	{
		foreach($routes as $key => $val)
		{
			$regex = strtr(str_replace('/', '\/', $key), $replacements);
			if(preg_match('/^' . $regex . '$/', $uri))
			{
				$uri = preg_replace('/' . $regex . '/', $val, $uri);
				break;
			}
		}
	}

	// Turn URL into Usable Array
	$path = explode('/', $uri);
	$path = array_filter($path, fn($value) => !is_null($value) && $value !== '');

	// Set Class Name and Handle Dashes
	$className = ucfirst($path[0]);
	$className = str_replace('-', '_', $className);
	unset($path[0]);

	if(isset($path[1]))
	{
		// Set Method Name and Handle Dashes
		$methodName = $path[1];
		$methodName = str_replace('-', '_', $methodName);
		unset($path[1]);

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