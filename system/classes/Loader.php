<?php


/**
 * Class Loader
 *
 * System to load various parts of the framework.
 */
class Loader
{
	/**
	 * @var object Handles `$this` reference.
	 */
	private object $_ref;

	/**
	 * Loader constructor.
	 *
	 * Instantiates loader reference to `$this`.
	 *
	 * @param object $ref
	 */
	public function __construct(object &$ref)
	{
		$this->_ref =& $ref;
	}

	/**
	 * Load Library
	 *
	 * Require necessary file and start class instance.
	 *
	 * @param string $libraryName
	 * @return object
	 */
	public function library(string $libraryName) : object
	{
		if(property_exists($this->_ref, $libraryName))
		{
			throw new Exception('Library already loaded in current instance.');
		}
		elseif(!file_exists(APP_PATH . '/libraries/' . $libraryName . '.php'))
		{
			throw new Exception('Library requested does not exist.');
		}
		else
		{
			require APP_PATH . '/libraries/' . $libraryName . '.php';
			$this->_ref->$libraryName = new $libraryName($this->_ref);
		}

		return $this->_ref;
	}

	/**
	 * Load Model
	 *
	 * Require necessary file and start class instance.
	 *
	 * @param string $modelName
	 * @return object
	 */
	public function model(string $modelName) : object
	{
		if(property_exists($this->_ref, $modelName))
		{
			throw new Exception('Model already loaded in current instance.');
		}
		elseif(!file_exists(APP_PATH . '/models/' . $modelName . '.php'))
		{
			throw new Exception('Model requested does not exist.');
		}
		else
		{
			require APP_PATH . '/models/' . $modelName . '.php';
			$this->_ref->$modelName = new $modelName($this->_ref);
		}

		return $this->_ref;
	}

	/**
	 * Load View
	 *
	 * Require necessary file.
	 *
	 * @param string $viewName
	 * @return void
	 */
	public function view(string $viewName)
	{
		if(!file_exists(APP_PATH . '/views/' . $viewName . '.php'))
		{
			throw new Exception('View requested does not exist.');
		}
		else
		{
			require APP_PATH . '/views/' . $viewName . '.php';
		}
	}
}