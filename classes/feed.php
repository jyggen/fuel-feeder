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

	protected $attributes = array();

	public function __construct()
	{

	}

	/**
	 * Set a value for the attribute "lastBuildDate". This attribute is automatically generated if missing.
	 *
	 * @param	\Fuel\Core\Date	$value
	 * @return	void
	 */
	public function buildDate(\Fuel\Core\Date $value)
	{

		$this->setAttr('lastBuildDate', $value);

	}

	/**
	 * Set a value for the attribute "description".
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function description($value)
	{

		$this->setAttr('description', $value);

	}

	/**
	 * Set a value for the attribute "title".
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function title($value)
	{

		$this->setAttr('title', $value);

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



	}

}