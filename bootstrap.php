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
	'Feeder\\Driver'      => __DIR__.'/classes/driver.php',
	'Feeder\\Feed'        => __DIR__.'/classes/feed.php',
	'Feeder\\Feed_Atom'   => __DIR__.'/classes/feed/atom.php',
	'Feeder\\Feed_Driver' => __DIR__.'/classes/feed/driver.php',
	'Feeder\\Feed_Rss2'   => __DIR__.'/classes/feed/rss2.php',
	'Feeder\\Item'        => __DIR__.'/classes/item.php',
	'Feeder\\Item_Atom'   => __DIR__.'/classes/item/atom.php',
	'Feeder\\Item_Driver' => __DIR__.'/classes/item/driver.php',
	'Feeder\\Item_Rss2'   => __DIR__.'/classes/item/rss2.php',
));