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
class MissingNamespaceException extends \FuelException {}


/**
 * Driver Class
 *
 * This abstract class contains common functionality used by all drivers to work with DOMDocument objects.
 *
 * @package   Feeder
 */
abstract class Driver
{

	/**
	 * Create the base elements and return the node which all future tags should be appended to.
	 *
	 * @return	DOMElement
	 */
	abstract protected function createBaseElement();

	protected $base, $document;

	/**
	 * Add the specified tag to the item.
	 *
	 * @param	string	$tag
	 * @param	string	$value
	 * @param	array	$attr
	 * @param	bool	$cdata
	 * @return	void
	 */
	protected function addTag($tag, $value=false, $attr=array(), $cdata=false)
	{

		// Check if the tag belongs to a namespace
		if(strpos($tag, ':')) {

			list($prefix, $tag) = explode(':', $tag);

			// Get the namespace URI of the prefix
			$namespace = $this->getNamespace($prefix);

			// If the prefix is unknown throw an exception
			if(!$namespace = $this->getNamespace($prefix)) {

				throw new MissingNamespaceException('Missing namespace for prefix "'.$prefix.'".');

			}

			// Create the element in its namespace
			$tag = $this->document->createElementNS($namespace, $tag);

		} else {

			// Create the element
			$tag = $this->document->createElement($tag);

		}

		// If the tag should contain a value
		if($value) {

			// Escape the value (as CDATA if requested) and append it to the tag
			$node = ($cdata) ? $this->document->createCDATASection($value) : $this->document->createTextNode($value);
			$tag->appendChild($node);

		}

		// If the tag should contain any attributes, loop through them
		if(!empty($attr)) {

			foreach($attr as $k => $v)
			{

				// Convert any bool to string
				if($v === true) { $v = 'true'; }
				if($v === false) { $v = 'false'; }

				// Create the attribute, set the value and append it to the tag
				$attribute        = $this->document->createAttribute($k);
				$attribute->value = $v;

				$tag->appendChild($attribute);

			}

		}

		// Append the new tag to the base element
		$this->base->appendChild($tag);

	}

	/**
	 * Get the currently used base element.
	 *
	 * @return	DOMElement
	 */
	public function getBaseElement()
	{

		return $this->base;

	}

	/**
	 * Get the currently used document.
	 *
	 * @return	DOMDocument
	 */
	public function getDocument()
	{

		return $this->document;

	}

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
	 * Get the namespace URI of the prefix.
	 *
	 * @param	string	$prefix
	 * @return	mixed
	 */
	protected function getNamespace($prefix)
	{

		$namespaces = \Config::get('feeder.namespaces.'.$this->getDriver().'.'.$prefix);

		return (is_null($namespaces)) ? false : $namespaces;

	}

	/**
	 * Return all namespaces available for the current driver.
	 *
	 * @return	mixed
	 */
	protected function getNamespaces()
	{

		$namespaces = \Config::get('feeder.namespaces.'.$this->getDriver());

		return (is_null($namespaces)) ? false : $namespaces;


	}

	/**
	 * Add namespace declarations to the document.
	 *
	 * @return	void
	 */
	protected function setNamespaces()
	{

		if($namespaces = $this->getNamespaces())
		{

			foreach($namespaces as $ns => $url)
			{

				$this->document->createAttributeNS($url, $ns.':attr');

			}

		}

	}

}
