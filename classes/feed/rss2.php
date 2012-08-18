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

	protected $content_type = 'application/rss+xml';

	protected function create_base_element()
	{

		$rss     = $this->document->createElement('rss');
		$channel = $this->document->createElement('channel');

		// Append version attribute to the root element.
		$version        = $this->document->createAttribute('version');
		$version->value = '2.0';



		$rss->appendChild($version);
		$rss->appendChild($channel);
		$this->document->appendChild($rss);

		return $channel;

	}

	/**
	 * Create <atom:link> in <channel>. Should be a link to where this feed is located.
	 * This tag will be automatically created by Feeder with the current request URL.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function atom_link($value, $type='application/rss+xml')
	{

		$this->add_tag('atom:link', false, array('href' => $value, 'rel' => 'self', 'type' => $type));

	}

	/**
	 * Create <description> in <channel>. Should be a description of what you're "feeding".
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function description($value)
	{

		$this->add_tag('description', $value);

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

		$this->add_tag('generator', $value);

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

		$this->add_tag('language', $value);

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

		$this->add_tag('link', $value);

	}

	/**
	 * Create <lastBuildDate> in <channel>. Should be when this feed was last updated.
	 * This tag will be automatically created by Feeder with the current timestamp if missing.
	 *
	 * @param	\Date	$value
	 * @return	void
	 */
	public function last_build_date(\Date $value)
	{

		/**
		 * Would love to use Date::format() here, but %z in strftime is weird on Windows.
		 * Also, the DATE_RSS constant is pretty nice :)
		 */
		$this->add_tag('lastBuildDate', date(DATE_RSS, $value->get_timestamp()));

	}

	/**
	 * Create <sy:updateFrequency> in <channel>. This is how often the feed is typically updated.
	 * This tag will be automatically created by Feeder with the value of feeder.update.frequency if missing.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function sy_update_frequency($value)
	{

		$this->add_tag('sy:updateFrequency', $value);

	}

	/**
	 * Create <sy:updatePeriod> in <channel>. This is used to set the interval or units used by <sy:updateFrequency>.
	 * This tag will be automatically created by Feeder with the value of feeder.update.period if missing.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function sy_update_period($value)
	{

		$this->add_tag('sy:updatePeriod', $value);

	}

	/**
	 * Create <title> in <channel>. Should be the title of your feed.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function title($value)
	{

		$this->add_tag('title', $value);

	}

}