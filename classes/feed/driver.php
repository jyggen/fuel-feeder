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

abstract class Feed_Driver extends Driver
{

	protected $content_type;

	public function __construct()
	{

		// Create a new DOMDocument
		$this->document = new \DOMDocument('1.0', 'utf-8');

		// Nice output (linebreaks etc.)
		$this->document->formatOutput = \Config::get('feeder.format_output', true);

		// Create the base element
		$this->base = $this->create_base_element();

		// Setup namespaces
		$this->set_namespaces();

	}

	/**
	 * Add the item object to the feed.
	 *
	 * @return	object	Item_Rss2
	 */
	public function add_item() {

		$item    = Item::forge($this->get_driver(), $this->document);
		$element = $item->get_base_element();
		$channel = $this->base;

		$channel->appendChild($element);

		return $item;

	}

	/**
	 * Returns the feed as XML in a Response object with correct Content-Type.
	 *
	 * @return	object	\Response
	 */
	public function response()
	{

		$response = \Response::forge();

		$response->set_header('Content-Type', $this->content_type);
		$response->body($this);

		return $response;

	}

	/**
	 * Return as XML when the object is converted to string.
	 *
	 * @return	string
	 */
	public function __toString()
	{

		return $this->document->saveXML();

	}

}