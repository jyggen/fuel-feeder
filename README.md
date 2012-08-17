# Feeder

Feeder is a Fuel package that generates RSS feeds.

## Installing

Simply add `feeder` to your config.php `always_loaded.packages` config option.

## Drivers

* Atom
* RSS 0.92
* RSS 1 RDF
* RSS2

## Usage

Forge a new feed object using the RSS 2.0 driver (which is the default):

	$feed = Feeder\Feed::forge('rss2');

Next step is to add a few tags. There's three required tags in RSS 2.0: `title`, `description` and `link`.

	$feed->title('Latest Posts');
	$feed->description('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');

You could also set the tags with `Feed::addTag()`. This is also the way to go if you want to define your own tags.

	$feed->addTag('title', 'Latest Posts');
	$feed->addTag('myAwesomeTag', 'http://www.example.com/');

Feeder will automatically generate the following tags for you:

* atom:link
* generator
* lastBuildDate
* language
* link
* sy:updateFrequency
* sy:updatePeriod

You can override these with `Feed::addTag()` or their own method (see documentation, e.g. `Feed::generator()`, `Feed::lastBuildDate()`). All generated tags are based upon your configuration and current request information (`atom:link` is `Uri::current()`, `link` is `Uri::base()` etc.).

Next up, you'd want to populate your feed with some items. Let's create one for RSS 2.0:

	$item = Feeder\Item::forge('rss2');

The Item object works the same way as the Feed object. To add this item to the feed you do this:

	$feed->addItem($item);

Finally, let's return the feed as the response from the controller. This will automatically convert your feed into an XML and return it as an `Response` with proper HTTP headers (basically what `Controller_Rest::response()` does but simplified).

	return $feed->response();