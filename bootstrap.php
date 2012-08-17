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

Autoloader::add_classes(array(
	'Feeder\\Feed' => __DIR__.'/classes/feed.php',

	'Feeder\\Feed_Driver' => __DIR__.'/classes/feed/driver.php',
	'Feeder\\Feed_Rss2'   => __DIR__.'/classes/feed/rss2.php',
));