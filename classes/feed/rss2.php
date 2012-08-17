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

class Feed_Rss2 extends Feed_Driver
{

	protected $contentType = 'application/rss+xml';

	public function __construct()
	{

		parent::__construct();

		// Create the root element.
		$rss = $this->feed->createElement('rss');

		$this->feed->appendChild($rss);

		// Append version attribute to the root element.
		$version        = $this->feed->createAttribute('version');
		$version->value = '2.0';

		$rss->appendChild($version);

		// Create namespaces for the feed.
		$this->feed->createAttributeNS('http://purl.org/rss/1.0/modules/content', 'content:attr');
		$this->feed->createAttributeNS('http://wellformedweb.org/CommentAPI/', 'wfw:attr');
		$this->feed->createAttributeNS('http://purl.org/dc/elements/1.1/', 'dc:attr');
		$this->feed->createAttributeNS('http://www.w3.org/2005/Atom', 'atom:attr');
		$this->feed->createAttributeNS('http://purl.org/rss/1.0/modules/syndication/', 'sy:attr');
		$this->feed->createAttributeNS('http://purl.org/rss/1.0/modules/slash/', 'slash:attr');

		// Create channel element and append it to root.
		$channel = $this->feed->createElement('channel');

		$rss->appendChild($channel);

	}

}