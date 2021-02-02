<?php

if(!function_exists('getUri'))
{
	/**
	 * Get Full URI without $_GET Variables
	 *
	 * @return string
	 */
	function getUri(): string
	{
		global $siteDetails;

		// Remove Domain from rootURL
		$path = preg_replace('/(http|https)\:\/\/[\w]+([^\/].?([\w]+)){1,}/',
							 '',
							 $siteDetails['rootUrl']);

		$request = $_SERVER['REQUEST_URI'];

		// Remove Site Path from URI
		if($path !== '/')
		{
			$request = str_replace($path, '', $_SERVER['REQUEST_URI']);
		}

		// Clean URI
		$uri = trim($request, '/');
		$uriSplit = explode('?', $uri);

		return $uriSplit[0];
	}
}

if(!function_exists('getUriPart'))
{
	/**
	 * Get a specific part of the URI
	 *
	 * @param int $part
	 * @return string
	 */
	function getUriPart(int $part): string
	{
		// Get Handled URI
		$uri = getUri();

		// Separate URI into Parts
		$uriParts = explode('/', $uri);

		// Return Requested Part
		if(isset($uriParts[$part]))
		{
			return $uriParts[$part];
		}

		// Default if Nothing Found
		return '';
	}
}