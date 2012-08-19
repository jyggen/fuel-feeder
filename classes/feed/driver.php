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

	protected $content_type, $items;
	protected $generator = 'https://github.com/jyggen/fuel-feeder';

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
	public function add_item()
	{

		$item          = Item::forge($this->get_driver(), $this->document);
		$element       = $item->get_base_element();
		$this->items[] = $element;

		return $item;

	}

	protected function generate_tags()
	{

		$generate = \Config::get('feeder.drivers.'.$this->get_driver().'.generate');

		if(!is_null($generate))
		{

			foreach($generate as $tag)
			{

				if(!$this->tag_exists($tag))
				{

					$method = $this->tag_to_method($tag);
					$this->$method();

				}

			}

		}

	}

	/**
	 * Returns the feed as XML in a Response object with correct Content-Type.
	 *
	 * @return	object	\Response
	 */
	public function response()
	{

		$this->generate_tags();
		$this->validate_feed();

		foreach($this->items as $item)
		{

			$this->base->appendChild($item);

		}

		$response = \Response::forge();

		$response->set_header('Content-Type', $this->content_type);
		$response->body($this);

		return $response;

	}

	protected function validate_feed()
	{

		$required = \Config::get('feeder.drivers.'.$this->get_driver().'.required');

		if(!is_null($required))
		{

			foreach($required as $tag)
			{

				if(!$this->tag_exists($tag))
				{

					throw new MissingTagException('Missing tag '.htmlentities('<'.$tag.'>').' in feed.');

				}

			}

		}

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