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

	/**
	 * Add the specified tag to the XML.
	 *
	 * @param	string	$tag
	 * @param	string	$value
	 * @return	void
	 */
	abstract public function addTag($tag, $value);

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