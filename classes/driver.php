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

	abstract protected function createBaseElement();

	protected $base, $document;

	/**
	 * Add the specified tag to the item.
	 *
	 * @param	string	$tag
	 * @param	string	$value
	 * @param	array	$attr
	 * @return	void
	 */
	protected function addTag($tag, $value=false, $attr=array(), $cdata=false)
	{

		if(strpos($tag, ':')) {

			list($prefix, $tag) = explode(':', $tag);

			$namespace = $this->getNamespace($prefix);

			if(!$namespace = $this->getNamespace($prefix)) {

				throw new MissingNamespaceException('Missing namespace for prefix "'.$prefix.'".');

			}

			$tag = $this->document->createElementNS($namespace, $tag);

		} else {

			$tag = $this->document->createElement($tag);

		}

		if($value) {

			$node = ($cdata) ? $this->document->createCDATASection($value) : $this->document->createTextNode($value);
			$tag->appendChild($node);

		}

		$this->base->appendChild($tag);

		if(!empty($attr)) {

			foreach($attr as $k => $v)
			{

				if($v === true) {

					$v = 'true';

				} else if($v === false) {

					$v = 'false';

				}

				$attribute        = $this->document->createAttribute($k);
				$attribute->value = $v;

				$tag->appendChild($attribute);

			}

		}

	}

	public function getBaseElement()
	{

		return $this->base;

	}

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

	protected function getNamespace($prefix)
	{

		$namespaces = \Config::get('feeder.namespaces.'.$this->getDriver().'.'.$prefix);

		return (is_null($namespaces)) ? false : $namespaces;

	}

	protected function getNamespaces()
	{

		$namespaces = \Config::get('feeder.namespaces.'.$this->getDriver());

		return (is_null($namespaces)) ? false : $namespaces;


	}

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