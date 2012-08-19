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
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function atom_link($value=null, $type='application/rss+xml')
	{

		if(is_null($value))
		{

			$value = \Uri::current();

		}

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
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function generator($value=null)
	{

		if(is_null($value))
		{

			$value = $this->generator;

		}

		$this->add_tag('generator', $value);

	}

	/**
	 * Create <language> in <channel>. Should be the language of the feed.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function language($value=null)
	{

		if(is_null($value))
		{

			$value = \Config::get('language');

		}

		$this->add_tag('language', $value);

	}

	/**
	 * Create <link> in <channel>. Should be a link to where the data is located or just the base URL.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function link($value=null)
	{

		if(is_null($value))
		{

			$value = \Uri::base();

		}

		$this->add_tag('link', $value);

	}

	/**
	 * Create <lastBuildDate> in <channel>. Should be when this feed was last updated.
	 *
	 * @param	\Date	$value
	 * @return	void
	 */
	public function last_build_date(\Date $value=null)
	{

		if(is_null($value))
		{

			$value = \Date::forge();

		}

		/**
		 * Would love to use Date::format() here, but %z in strftime is weird on Windows.
		 * Also, the DATE_RSS constant is pretty nice :)
		 */
		$this->add_tag('lastBuildDate', date(DATE_RSS, $value->get_timestamp()));

	}

	/**
	 * Create <sy:updateFrequency> in <channel>. This is how often the feed is typically updated.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function sy_update_frequency($value=null)
	{

		if(is_null($value))
		{

			$value = \Config::get('feeder.update.frequency');

		}

		$this->add_tag('sy:updateFrequency', $value);

	}

	/**
	 * Create <sy:updatePeriod> in <channel>. This is used to set the interval or units used by <sy:updateFrequency>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function sy_update_period($value=null)
	{

		if(is_null($value))
		{

			$value = \Config::get('feeder.update.period');

		}

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