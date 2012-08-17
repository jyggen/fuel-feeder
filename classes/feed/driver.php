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

class Feed_Driver
{

	protected $contentType;
	protected $feed;
	protected $format;
	protected $required = array();

	public function __construct()
	{

		$this->feed = new \DOMDocument('1.0', 'utf-8');

	}

	/**
	 * Set a value for the specified attribute.
	 *
	 * @param	string	$attr
	 * @param	string	$value
	 * @return	void
	 */
	#3abstract public function setAttr($attr, $value);

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