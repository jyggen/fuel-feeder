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

class Item_Rss2 extends Item_Driver
{

	protected function create_base_element()
	{

		$element = $this->document->createElement('item');

		return $element;

	}

	/**
	 * Create <category> in <item>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function category($value)
	{

		$this->add_tag('category', $value, array(), true);

	}

	/**
	 * Create <comments> in <item>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function comments($value)
	{

		$this->add_tag('comments', $value);

	}

	/**
	 * Create <content:encoded> in <item>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function content_encoded($value)
	{

		$this->add_tag('content:encoded', $value, array(), true);

	}

	/**
	 * Create <dc:creator> in <item>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function dc_creator($value)
	{

		$this->add_tag('dc:creator', $value);

	}

	/**
	 * Create <description> in <item>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function description($value)
	{

		$this->add_tag('description', $value, array(), true);

	}

	/**
	 * Create <guid> in <item>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function guid($value, $isPermaLink=false)
	{

		$this->add_tag('guid', $value, array('isPermaLink' => $isPermaLink));

	}

	/**
	 * Create <link> in <item>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function link($value)
	{

		$this->add_tag('link', $value);

	}

	/**
	 * Create <pubDate> in <item>.
	 *
	 * @param	\Date	$value
	 * @return	void
	 */
	public function pub_date(\Date $value)
	{

		/**
		 * Would love to use Date::format() here, but %z in strftime is weird on Windows.
		 * Also, the DATE_RSS constant is pretty nice :)
		 */
		$this->add_tag('pubDate', date(DATE_RSS, $value->get_timestamp()));

	}

	/**
	 * Create <slash:comments> in <item>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function slash_comments($value)
	{

		$this->add_tag('slash:comments', $value);

	}

	/**
	 * Create <title> in <item>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function title($value)
	{

		$this->add_tag('title', $value);

	}

	/**
	 * Create <wfw:commentRss> in <item>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function wfw_comment_rss($value)
	{

		$this->add_tag('wfw:commentRss', $value);

	}

}