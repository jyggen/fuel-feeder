# Feeder

Feeder is a Fuel package that generates RSS feeds.

## Installing

Simply add `feeder` to your config.php `always_loaded.packages` config option.

## Usage
Initialize a new feed object:

	$feed = new Feeder\Feed;

You could also supply an argument which will be used as the feed title:

	$feed = new Feeder\Feed('Latest Posts');

Next step is to set a few attributes. There's two required attributes: `title` and `description`.

	$feed->setAttr('description', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.');
	$feed->setAttr('title', 'Latest Posts');           // This would override the one set during init.
	$feed->setAttr('link', 'http://www.example.com/'); // We could also define our own attributes.

You could also set the attributes directly. However, this will only work with required/generated attributes.

	$feed->title       = 'Latest Posts';
	$feed->description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

Feeder will automatically generate a few attributes for you. You can override these with `setAttr()` or the above method. Feeder will generate these attributes based on your config and the request:

* atom:link
* generator
* lastBuildDate
* language
* sy:updatePeriod