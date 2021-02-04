<?php
// Load system... That's it, super simple.
try
{
	require_once dirname(__FILE__) . '/../system/base.php';
}
catch(Exception $exception)
{
	echo $exception;
}
