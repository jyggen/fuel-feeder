# Feeder

Feeder is a Fuel package that generates RSS feeds.

## Installing

Simply add `feeder` to your config.php `always_loaded.packages` config option.

## Usage
**Notice:** This is the planned usage and was written before any development, so it will probably (most likely) change. I'd like to stupify it (easier to work with) but make it stricter (only one way to do each task). Feel free to send me feedback!

Initialize a new feed object:

	$feed = new Feeder\Feed;

Next step is to set a few attributes. There's two required attributes: `title` and `description`.

	$feed->title('Latest Posts');
	$feed->description('Lorem ipsum dolor sit amet, consectetur adipiscing elit.');

You could also set the attributes with `Feed::setAttr()`. This is also the way to go if you want to define your own attributes.

	$feed->setAttr('title', 'Latest Posts');
	$feed->setAttr('link', 'http://www.example.com/');

Feeder will automatically generate the following attributes for you:

* atom:link
* generator
* lastBuildDate
* language
* sy:updateFrequency
* sy:updatePeriod

You can override these with `Feed::setAttr()` or their own method (see documentation, e.g. `Feed::generator()`, `Feed::builDate()`). These attributes are based upon your Feeder config and current request information (`atom:link` is `Uri::current()` etc.).

Next up, you'd want to populate your feed with some items. Let's create one:

	$item = new Feeder\Item;

The Item object works the same way as the Feed object, so you use the same method to append data.

	$item       = new Feeder\Item('Awesome Post'); // Title as an argument, remember?
	$item->link = 'http://www.example.com/awesome-post.html';

	$item->setAttr('description', 'Duis auctor scelerisque purus, eu pretium lectus sagittis vitae.');
	$item->setAttr('dc:creator', 'John Doe');

To add this item to the feed you can do any of these two:

	$feed->addItem($item);
	$feed->items[] = $item;

Finally, let's return the feed as the response from the controller with `Feed:response()`! This method will automatically convert your feed into an XML and return ito as an `Response` object with proper HTTP headers (basically what `Controller_Rest::response()` does but simplified).