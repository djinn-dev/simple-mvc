<?php
// Load system... That's it, super simple.
try
{
	require_once '../system/base.php';
}
catch(Exception $exception)
{
	echo $exception;
}