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

class Feed_Atom extends Feed_Driver
{

	protected $content_type = 'application/atom+xml';

	protected function create_base_element()
	{

		$feed = $this->document->createElement('feed');

		$xmlns        = $this->document->createAttribute('xmlns');
		$xmlns->value = 'http://www.w3.org/2005/Atom';

		$xml_lang        = $this->document->createAttribute('xml:lang');
		$xml_lang->value = str_replace('_', '-', \Fuel::$locale);

		$xml_base        = $this->document->createAttribute('xml:base');
		$xml_base->value = \Uri::base(false);

		$feed->appendChild($xmlns);
		$feed->appendChild($xml_lang);
		$feed->appendChild($xml_base);
		$this->document->appendChild($feed);

		return $feed;

	}

	/**
	 * Create <generator> in <feed>.
	 *
	 * @return	void
	 */
	public function generator()
	{

		$this->add_tag('generator', $this->generator['name'], array('uri' => $this->generator['uri'], 'version' => $this->generator['version']));

	}

	/**
	 * Create <id> in <feed>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function id($value=null)
	{

		$value or $value = \Uri::current();
		$this->add_tag('id', $value);

	}

	/**
	 * Create <link> in <feed>.
	 *
	 * @param	string	$value
	 * @param	string	$rel
	 * @return	void
	 */
	public function link($value=null, $rel)
	{

		switch($rel) {
			case 'alternate':
				$value or $value = \Uri::Base(false);
				$type = 'text/html';

				break;
			case 'self':
				$value or $value = \Uri::current();
				$type = $this->content_type;
				break;
			default:
				throw new InvalidOptionException('Invalid option "'.$rel.'".');
				break;
		}

		$this->add_tag('link', false, array('rel' => $rel, 'type' => $type, 'href' => $value));

	}

	/**
	 * Create <subtitle> in <feed>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function subtitle($value)
	{

		$this->add_tag('subtitle', $value, array('type' => 'text'));

	}

	/**
	 * Create <title> in <feed>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function title($value)
	{

		$this->add_tag('title', $value, array('type' => 'text'));

	}

	/**
	 * Create <updated> in <feed>.
	 *
	 * @param	string	$value
	 * @return	void
	 */
	public function updated(\Date $value=null)
	{

		$value or $value = \Date::forge();
		$this->add_tag('updated', date(DATE_ATOM, $value->get_timestamp()));

	}

}