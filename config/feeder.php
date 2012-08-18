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

return array(
	'drivers' => array(
		'rss2' => array(
			'namespaces' => array(
				'content' => 'http://purl.org/rss/1.0/modules/content',
				'wfw'     => 'http://wellformedweb.org/CommentAPI/',
				'dc'      => 'http://purl.org/dc/elements/1.1/',
				'atom'    => 'http://www.w3.org/2005/Atom',
				'sy'      => 'http://purl.org/rss/1.0/modules/syndication/',
				'slash'   => 'http://purl.org/rss/1.0/modules/slash/',
			),
			'generate' => array('generator'),
			'required' => array('description', 'link', 'title'),
		),
	),
	'format_output' => true,
	'update' => array(
		'frequency' => 'hourly',
		'period'    => 1,
	),
);