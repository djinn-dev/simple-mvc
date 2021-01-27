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
		global $siteDetails;

		$root = preg_replace('/(http|https)\:\/\/[\w]+([^\/].?([\w]+)){1,}/',
					'',
					$siteDetails['rootUrl']);
		$request = str_replace($root, '', $_SERVER['REQUEST_URI']);

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
		$uri = getUri();
		$uriParts = explode('/', $uri);

		if(isset($uriParts[$part]))
		{
			return $uriParts[$part];
		}

		return '';
	}
}
