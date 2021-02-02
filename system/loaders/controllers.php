<?php
// Error Handling
if(!isset($routes) || empty($routes))
{
	throw new Exception('Routes config array is missing/empty.');
}

// Set Pathing Variables
$methodName = 'index';
$className = '';
$filePath = APP_PATH . '/controllers/';
$variables = [];

// Set Pathing
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
	$defaultClass = ucfirst($routes['default_controller']);
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
	$urlParts = explode('/', $uri);
	$urlParts = array_filter($urlParts, fn($value) => !is_null($value) && $value !== '');

	// Set Class Name/Path & Method Name
	foreach($urlParts as $key => $part)
	{
		// Handle Dashes
		$part = str_replace('-', '_', $part);

		// Check for Files
		$nextKey = $key + 1;
		if(isset($urlParts[$nextKey]) && file_exists($filePath . $part . '/' . ucfirst($urlParts[$nextKey]) . '.php'))
		{
			$className = ucfirst($urlParts[$nextKey]);
			$filePath .= $part . '/';
			$nextKey += 1;
		}
		elseif(file_exists($filePath . ucfirst($part) . '.php'))
		{
			$className = ucfirst($part);
		}
		elseif(file_exists($filePath . $part . '/' . $defaultClass . '.php'))
		{
			$className = $defaultClass;
			$filePath .= $part . '/';
		}
		unset($urlParts[$key]);

		// Check if Class FOund
		if($className)
		{
			if(isset($urlParts[$nextKey]))
			{
				// Set Method Name and Handle Dashes
				$methodName = $urlParts[$nextKey];
				$methodName = str_replace('-', '_', $methodName);
				unset($urlParts[$nextKey]);

				// Handle URL Variables
				if(!empty($urlParts))
				{
					$variables = array_values($urlParts);
				}
			}

			// Leave loop
			break;
		}

		// Concatenate path before next loop
		$filePath .= $part . '/';
	}
}

// Load Controller
if(!$className)
{
	throw new Exception('Route does not exist. Please check your URL and try again.');
}
require_once $filePath . $className . '.php';

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