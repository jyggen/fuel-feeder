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


class MissingTagException extends \FuelException {}


class Feed
{

	public static function forge($driver='rss2')
	{

		$class  = 'Feeder\\Feed_'.ucfirst($driver);
		$driver = new $class();

		return $driver;

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

}