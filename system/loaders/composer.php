<?php
// Set File Pathing
define('COMPOSER_PATH', SYSTEM_PATH . '/../vendor');

if(file_exists(COMPOSER_PATH . '/autoload.php'))
{
	require_once COMPOSER_PATH . '/autoload.php';
}