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

abstract class Item_Driver
{

	protected $document, $item;

	abstract protected function createElement();

	public function __construct($document)
	{

		$this->document = $document;
		$this->element  = $this->createElement();

	}

	public function getElement()
	{

		return $this->element;

	}

	/**
	 * Add the specified tag to the item.
	 *
	 * @param	string	$tag
	 * @param	string	$value
	 * @param	array	$attr
	 * @param	string	$namespace
	 * @return	void
	 */
	protected function addTag($tag, $value, $attr=array(), $namespace=null)
	{

		$node = $this->document->createTextNode($value);

		if(is_null($namespace)) {

			$tag = $this->document->createElement($tag);

		} else {

			$tag = $this->document->createElementNS($namespace, $tag);

		}

		$tag->appendChild($node);
		$this->element->appendChild($tag);

	}

}