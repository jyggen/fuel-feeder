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

class Item_Atom extends Item_Driver
{

	protected function create_base_element()
	{

		$element = $this->document->createElement('entry');

		return $element;

	}

	/**
	 * Create <link> in <entry>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function link($value)
	{

		$this->add_tag('link', false, array('rel' => 'alternate', 'type' => 'text/html', 'href' => $value));

	}

	/**
	 * Create <title> in <entry>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function title($value)
	{

		$this->add_tag('title', $value, array('type' => 'html'), true);

	}

}