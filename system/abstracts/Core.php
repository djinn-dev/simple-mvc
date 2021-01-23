<?php


/**
 * Class Core Abstract
 *
 * Define base system setup for all classes.
 */
abstract class Core
{
	/**
	 * @var object|Loader Used to load various parts of the system.
	 */
	protected object $load;

	/**
	 * Core constructor.
	 *
	 * Run things needed for all classes.
	 */
	public function __construct()
	{
		$this->load = new Loader($this);
	}
}