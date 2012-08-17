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

		// Create channel and items elements.
		$channel = $this->feed->createElement('channel');
		$items   = $this->feed->createElement('items');

		$channel->appendChild($items);
		$rss->appendChild($channel);

	}

	/**
	 * Create <atom:link> in <channel>. Should be a link to where this feed is located.
	 * This tag will be automatically created by Feeder with the current request URL.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function atomLink($value)
	{

		$this->addTag('atom:link', $value, 'http://www.w3.org/2005/Atom');

	}

	/**
	 * Create <description> in <channel>. Should be a description of what you're "feeding".
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function description($value)
	{

		$this->addTag('description', $value);

	}

	/**
	 * Create <generator> in <channel>. Program used to generate the channel.
	 * This tag will be automatically created by Feeder to give itself some credit.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function generator($value)
	{

		$this->addTag('generator', $value);

	}

	/**
	 * Create <language> in <channel>. Should be the language of the feed.
	 * This tag will be automatically created by Feeder with the value of config.language if missing.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function language($value)
	{

		$this->addTag('language', $value);

	}

	/**
	 * Create <link> in <channel>. Should be a link to where the data is located or just the base URL.
	 * This tag will be automatically created by Feeder with the base URL of your application.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function link($value)
	{

		$this->addTag('link', $value);

	}

	/**
	 * Create <lastBuildDate> in <channel>. Should be when this feed was last updated.
	 * This tag will be automatically created by Feeder with the current timestamp if missing.
	 *
	 * @param	\Date	$value
	 * @return	void
	 */
	public function lastBuildDate(\Date $value)
	{

		/**
		 * Would love to use Date::format() here, but %z in strftime is weird on Windows.
		 * Also, the DATE_RSS constant is pretty nice :)
		 */
		$this->addTag('lastBuildDate', date(DATE_RSS, $value->get_timestamp()));

	}

	/**
	 * Create <sy:updateFrequency> in <channel>. This is how often the feed is typically updated.
	 * This tag will be automatically created by Feeder with the value of feeder.update.frequency if missing.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function syUpdateFrequency($value)
	{

		$this->addTag('sy:updateFrequency', $value, 'http://purl.org/rss/1.0/modules/syndication/');

	}

	/**
	 * Create <sy:updatePeriod> in <channel>. This is used to set the interval or units used by <sy:updateFrequency>.
	 * This tag will be automatically created by Feeder with the value of feeder.update.period if missing.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function syUpdatePeriod($value)
	{

		$this->addTag('sy:updatePeriod', $value, 'http://purl.org/rss/1.0/modules/syndication/');

	}

	/**
	 * Create <title> in <channel>. Should be the title of your feed.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function title($value)
	{

		$this->addTag('title', $value);

	}

	/**
	 * Add the specified tag in <channel>.
	 *
	 * @param	string	$tag
	 * @param	string	$value
	 * @param	string	$namespace
	 * @return	void
	 */
	public function AddTag($tag, $value, $namespace=null)
	{

		$channel = $this->getChannel();

		if(is_null($namespace)) {

			$element = $this->feed->createElement($tag, $value);

		} else {

			$element = $this->feed->createElementNS($namespace, $tag, $value);

		}

		$channel->appendChild($element);

	}

	/**
	 * Get the tag <channel> from the feed.
	 *
	 * @return	\DOMElement
	 */
	protected function getChannel()
	{

		$channel = $this->feed->getElementsByTagName('channel')->item(0);

		if(is_null($channel)) {

			throw new MissingTagException(htmlentities('Missing tag <channel> in feed.'));

		} else return $channel;

	}

}