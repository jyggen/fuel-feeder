# Feeder

Feeder is a Fuel package that generates RSS feeds.

## Installing

Simply add `feeder` to your config.php `always_loaded.packages` config option.

## Usage
**Notice:** This is the planned usage and was written before any development, so it will probably (most likely) change. I would probably need to stupify it but make it stricter. Feel free to send me feedback!

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

Feeder will automatically generate a few attributes based on your config and the current request. You can override these with `setAttr()` or the above method.

* atom:link
* generator
* lastBuildDate
* language
* sy:updatePeriod

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

All items added? Let's send it to the browser through a Response object and FuelPHP will take care of the rest.

	return new Response($feed);
