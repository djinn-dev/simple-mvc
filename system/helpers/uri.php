<?php

if(!function_exists('getUri'))
{
	/**
	 * Get Full URI without $_GET Variables
	 *
	 * @return string
	 */
	function getUri() : string
	{
		$uri = trim($_SERVER['REQUEST_URI'], '/');
		$uriSplit = explode('?', $uri);

		return $uriSplit[0];
	}
}

if(!function_exists('getUriPart'))
{
	function getUriPart(int $part): string
	{
		$uri = getUri();
		$uriParts = explode('/', $uri);

		if(isset($uriParts[$part]))
		{
			return $uriParts[$part];
		}

		return '';
	}
}