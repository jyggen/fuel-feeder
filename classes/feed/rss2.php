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
	 * Create <atom:link> in <channel>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function atom_link($value=null, $type='application/rss+xml')
	{

		$value or $value = \Uri::current();
		$this->add_tag('atom:link', false, array('href' => $value, 'rel' => 'self', 'type' => $type));

	}

	/**
	 * Create <description> in <channel>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function description($value)
	{

		$this->add_tag('description', $value);

	}

	/**
	 * Create <generator> in <channel>.
	 *
	 * @return	void
	 */
	public function generator($value=null)
	{

		$value or $value = $this->generator['uri'];
		$this->add_tag('generator', $value);

	}

	/**
	 * Create <language> in <channel>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function language($value=null)
	{

		$value or $value = \Config::get('language');
		$this->add_tag('language', $value);

	}

	/**
	 * Create <link> in <channel>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function link($value=null)
	{

		$value or $value = \Uri::base();
		$this->add_tag('link', $value);

	}

	/**
	 * Create <lastBuildDate> in <channel>.
	 *
	 * @param	\Date	$value
	 * @return	void
	 */
	public function last_build_date(\Date $value=null)
	{

		$value or $value = \Date::forge();
		$this->add_tag('lastBuildDate', date(DATE_RSS, $value->get_timestamp()));

	}

	/**
	 * Create <sy:updateFrequency> in <channel>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function sy_update_frequency($value=null)
	{

		$value or $value = \Config::get('feeder.update.frequency');
		$this->add_tag('sy:updateFrequency', $value);

	}

	/**
	 * Create <sy:updatePeriod> in <channel>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function sy_update_period($value=null)
	{

		$value or $value = \Config::get('feeder.update.period');
		$this->add_tag('sy:updatePeriod', $value);

	}

	/**
	 * Create <title> in <channel>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function title($value)
	{

		$this->add_tag('title', $value);

	}

}