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

class Feed
{

	protected $feed     = array();
	protected $required = array('description', 'title');

	public function __construct()
	{

	}

	/**
	 * Helper to set a value for the attribute "lastBuildDate". Automatically generated if missing.
	 *
	 * @param	\Date	$value
	 * @return	void
	 */
	public function buildDate(\Date $value)
	{

		/**
		 * Would love to use Date::format() here, but %z in strftime is weird on Windows.
		 * Also, the DATE_RSS constant is pretty nice :)
		 */
		$this->setAttr('lastBuildDate', date(DATE_RSS, $value->get_timestamp()));

	}

	/**
	 * Helper to set a value for the attribute "description".
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function description($value)
	{

		$this->setAttr('description', $value);

	}

	/**
	 * Helper to set a value for the attribute "title".
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function title($value)
	{

		$this->setAttr('title', $value);

	}

	/**
	 * Returns the feed as XML in a Response object with correct Content-Type.
	 *
	 * @return	object	\Response
	 */
	public function response()
	{

		$response         = \Response::forge();
		$response->status = 200;

		$response->set_header('Content-Type', 'application/xml');
		$response->body($this);

		return $response;

	}

	/**
	 * Set a value for the specified attribute.
	 *
	 * @param	string	$attr
	 * @param	string	$value
	 * @return	void
	 */
	public function setAttr($attr, $value)
	{

		$this->feed[$attr] = $value;

	}

	/**
	 * Return as XML when the object is converted to string.
	 *
	 * @return	string
	 */
	public function __toString()
	{

		return \Format::forge($this->feed)->to_xml();

	}

}