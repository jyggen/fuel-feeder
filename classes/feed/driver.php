<?php
/**
 * Feeder: A Feed/RSS generator for FuelPHP.
 *
 * @package		Feeder
 * @version		1.0
 * @author		Jonas Stendahl
 * @license		MIT License
 * @copyright	2012 Jonas Stendahl
 * @link		https://github.com/jyggen/fuel-feeder
 */

namespace Feeder;

abstract class Feed_Driver
{

	protected $contentType;
	protected $feed;
	protected $format;
	protected $required = array();

	public function __construct()
	{

		$this->feed               = new \DOMDocument('1.0', 'utf-8');
		$this->feed->formatOutput = true;

	}

	abstract public function addItem();
	abstract public function addTag($tag, $value, $namespace);

	/**
	 * Get the name of the current driver.
	 *
	 * @return	string
	 */
	protected function getDriver()
	{

		$driver = explode('_', get_class($this));
		$driver = strtolower($driver[count($driver)-1]);

		return $driver;

	}

	/**
	 * Returns the feed as XML in a Response object with correct Content-Type.
	 *
	 * @return	object	\Response
	 */
	public function response()
	{

		$response = \Response::forge();

		$response->set_header('Content-Type', $this->contentType);
		$response->body($this);

		return $response;

	}

	/**
	 * Return as XML when the object is converted to string.
	 *
	 * @return	string
	 */
	public function __toString()
	{

		return $this->feed->saveXML();

	}

}