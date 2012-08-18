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

	public static function _init()
	{

		\Config::load('feeder', true);

	}

	public static function forge($driver='rss2')
	{

		$class  = 'Feeder\\Feed_'.ucfirst($driver);
		$driver = new $class();

		return $driver;

	}

}