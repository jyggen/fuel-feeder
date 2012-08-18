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

	protected function createBaseElement()
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

		$this->addTag('category', $value, array(), true);

	}

	/**
	 * Create <comments> in <item>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function comments($value)
	{

		$this->addTag('comments', $value);

	}

	/**
	 * Create <content:encoded> in <item>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function contentEncoded($value)
	{

		$this->addTag('content:encoded', $value, array(), true);

	}

	/**
	 * Create <dc:creator> in <item>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function dcCreator($value)
	{

		$this->addTag('dc:creator', $value);

	}

	/**
	 * Create <description> in <item>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function description($value)
	{

		$this->addTag('description', $value, array(), true);

	}

	/**
	 * Create <guid> in <item>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function guid($value, $isPermaLink=false)
	{

		$this->addTag('guid', $value, array('isPermaLink' => $isPermaLink));

	}

	/**
	 * Create <link> in <item>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function link($value)
	{

		$this->addTag('link', $value);

	}

	/**
	 * Create <pubDate> in <item>.
	 *
	 * @param	\Date	$value
	 * @return	void
	 */
	public function pubDate(\Date $value)
	{

		/**
		 * Would love to use Date::format() here, but %z in strftime is weird on Windows.
		 * Also, the DATE_RSS constant is pretty nice :)
		 */
		$this->addTag('pubDate', date(DATE_RSS, $value->get_timestamp()));

	}

	/**
	 * Create <slash:comments> in <item>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function slashComments($value)
	{

		$this->addTag('slash:comments', $value);

	}

	/**
	 * Create <title> in <item>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function title($value)
	{

		$this->addTag('title', $value);

	}

	/**
	 * Create <wfw:commentRss> in <item>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function wfwCommentRss($value)
	{

		$this->addTag('wfw:commentRss', $value);

	}

}