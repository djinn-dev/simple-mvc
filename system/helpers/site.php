<?php

if(!function_exists('siteUrl'))
{
	/**
	 * Generate absolute path by URI
	 *
	 * @param string $uri
	 * @return string
	 */
	function siteUrl(string $uri = '') : string
	{
		global $siteDetails;

		return $siteDetails['rootUrl'] . $uri;
	}
}

if(!function_exists('getSiteTitle'))
{
	/**
	 * Get Site Title From Config
	 *
	 * @return string
	 */
	function getSiteTitle() : string
	{
		global $siteDetails;

		return $siteDetails['siteTitle'];
	}
}

if(!function_exists('getSiteTagline'))
{
	/**
	 * Get Site Tagline From Config
	 *
	 * @return string
	 */
	function getSiteTagline() : string
	{
		global $siteDetails;

		return $siteDetails['siteTagline'];
	}
}