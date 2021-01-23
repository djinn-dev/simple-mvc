<?php
// Set File Pathing
define('SYSTEM_PATH', dirname(__FILE__));
define('APP_PATH', SYSTEM_PATH . '/../application');

// Load Required Files
require_once SYSTEM_PATH . '/loaders/config.php';
require_once SYSTEM_PATH . '/loaders/classes.php';
require_once SYSTEM_PATH . '/loaders/composer.php';
require_once SYSTEM_PATH . '/loaders/abstracts.php';
require_once SYSTEM_PATH . '/loaders/controllers.php';
