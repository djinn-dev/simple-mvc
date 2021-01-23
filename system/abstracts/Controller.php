<?php


/**
 * Class Controller Abstract
 *
 * Define base system setup for controller classes.
 */
abstract class Controller Extends Core
{
	/**
	 * Force index in every controller.
	 *
	 * @return mixed
	 */
	public abstract function index();
}