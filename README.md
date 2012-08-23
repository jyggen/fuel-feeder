# Feeder

Feeder is a Fuel package that helps you create Atom and RSS feeds.

## Installing

Simply add `feeder` to your config.php `always_loaded.packages` config option.

## Drivers

* [Atom](https://github.com/jyggen/fuel-feeder/wiki/Driver:-Atom)
* [RSS 0.92](https://github.com/jyggen/fuel-feeder/wiki/Driver:-RSS-0.92)
* [RSS 1 RDF](https://github.com/jyggen/fuel-feeder/wiki/Driver:-RSS-1-RDF)
* [RSS2](https://github.com/jyggen/fuel-feeder/wiki/Driver:-RSS2)

## Usage

Forge a new Feed object using one of the drivers. See each driver's documentation for more detailed information about everything below (helpers, generated tags etc.).

	$feed = Feeder\Feed::forge('rss2');

Next step is to add a few tags. Each driver have a number of required tags which must be set to generate a valid feed. Each driver also have their own tag methods (helpers) to simplify the creation of predefined tags which can (and should) be used. Feeder will automatically generate some tags for you based on things like current configuration and request information.

	$feed->title('Latest Posts');
	$feed->description('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');

You could also set up your own tags with `Feed::addTag()`. This method is internally used by helpers. Automatically generated tags will not be generated if they've already been created with `Feed::addTag()` or their helper.

	$feed->addTag('title', 'Latest Posts');
	$feed->addTag('myAwesomeTag', 'http://www.example.com/', array('rel' => 'self')); // Third argument is an array with attributes.

Next up, you'd want to populate your feed with some items. Items are created with `Feed::addItem()`. This method will return a Item object, and it works the same way as a Feed object with `Item::addTag()` and helpers.

	$item = $feed->addItem();
	$item->title('My Post');
	$item->description('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');

Finally you want to output your feed to the browser. To do this you return `Feed::response()` from your controller and FuelPHP will take care of the rest. This method will automatically convert your feed into a XML document and return a Response object with proper Content-Type headers.

	return $feed->response();