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
class InvalidOptionException extends \FuelException {}


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
	abstract protected function create_base_element();

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
	protected function add_tag($tag, $value=false, $attr=array(), $cdata=false)
	{

		// Check if the tag belongs to a namespace
		if(strpos($tag, ':')) {

			list($prefix, $tag) = explode(':', $tag);

			// Get the namespace URI of the prefix
			$namespace = $this->get_namespace($prefix);

			// If the prefix is unknown throw an exception
			if(!$namespace = $this->get_namespace($prefix)) {

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
	public function get_base_element()
	{

		return $this->base;

	}

	/**
	 * Get the currently used document.
	 *
	 * @return	DOMDocument
	 */
	public function get_document()
	{

		return $this->document;

	}

	/**
	 * Get the name of the current driver.
	 *
	 * @return	string
	 */
	protected function get_driver()
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
	protected function get_namespace($prefix)
	{

		$namespaces = \Config::get('feeder.drivers.'.$this->get_driver().'.namespaces.'.$prefix);

		return (is_null($namespaces)) ? false : $namespaces;

	}

	/**
	 * Return all namespaces available for the current driver.
	 *
	 * @return	mixed
	 */
	protected function get_namespaces()
	{

		$namespaces = \Config::get('feeder.drivers.'.$this->get_driver().'.namespaces');

		return (is_null($namespaces)) ? false : $namespaces;


	}

	/**
	 * Add namespace declarations to the document.
	 *
	 * @return	void
	 */
	protected function set_namespaces()
	{

		if($namespaces = $this->get_namespaces())
		{

			foreach($namespaces as $ns => $url)
			{

				$this->document->createAttributeNS($url, $ns.':attr');

			}

		}

	}

	protected function tag_exists($tag)
	{

		$nodes = array();
		foreach($this->base->childNodes as $node)
		{

			$nodes[$node->tagName][] = $node;

		}

		// If we require a specific attribute value
		if(strpos($tag, '#'))
		{

			list($tag, $attribute) = explode('#', $tag);

			if(array_key_exists($tag, $nodes))
			{

				foreach($nodes[$tag] as $node)
				{

					foreach($node->attributes as $attr)
					{

						if($attr->value == $attribute)
						{

							return true;

						}

					}

				}

			}

			return false;

		}
		else
		{

			return (array_key_exists($tag, $nodes));

		}

	}

	protected function tag_to_method($tag)
	{

		return str_replace(':', '_', \Inflector::underscore($tag));

	}

}
