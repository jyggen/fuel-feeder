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

class Item_Rss2 extends Item_Driver
{

	/**
	 * Create <link> in <item>. Should be the link to your item.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function link($value)
	{

		$this->addTag('link', $value);

	}

	/**
	 * Create <title> in <item>. Should be the title of your item.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function title($value)
	{

		$this->addTag('title', $value);

	}

	protected function createElement()
	{

		$element = $this->document->createElement('item');

		return $element;

	}

}