<?php
namespace Feeder;

class Test_Feeder extends \TestCase
{

	public function testFeedForge()
	{

		// Feed with Atom driver should forge an instance of Feed_Atom.
		$this->assertInstanceOf('Feeder\\Feed_Atom', Feed::forge('atom'));

		// Feed with Rss2 driver should forge an instance of Feed_Rss2.
		$this->assertInstanceOf('Feeder\\Feed_Rss2', Feed::forge('rss2'));

	}

	/**
	 * @depends testFeedForge
	 */
	public function testGetDocument()
	{

		// Forge instances of Feed_Atom and Feed_Rss2 and get their DOMDocument.
		$atom = Feed::forge('atom')->get_document();
		$rss2 = Feed::forge('rss2')->get_document();

		// get_document() should return an instance of DOMDocument.
		$this->assertInstanceOf('DOMDocument', $atom);
		$this->assertInstanceOf('DOMDocument', $rss2);

		// Output feed data as XML.
		$atom = $atom->saveXML();
		$rss2 = $rss2->saveXML();

		// saveXML() should not return false (fail).
		$this->assertNotEquals(false, $atom);
		$this->assertNotEquals(false, $rss2);

		// Remove unnecessary whitespaces from XML output.
		$atom = trim(preg_replace('/\s+/', ' ', $atom));
		$rss2 = trim(preg_replace('/\s+/', ' ', $rss2));

		// The XML should equal the following structures.
		$this->assertEquals('<?xml version="1.0" encoding="utf-8"?> <feed xmlns:thr="http://purl.org/syndication/thread/1.0" xmlns="http://www.w3.org/2005/Atom" xml:lang="en-US.utf8" xml:base=""/>', $atom);
		$this->assertEquals('<?xml version="1.0" encoding="utf-8"?> <rss xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:wfw="http://wellformedweb.org/CommentAPI/" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:sy="http://purl.org/rss/1.0/modules/syndication/" xmlns:slash="http://purl.org/rss/1.0/modules/slash/" version="2.0"> <channel/> </rss>', $rss2);

	}

	/**
	 * @depends testGetDocument
	 */
	public function testGetBaseElement()
	{

		// Forge instances of Feed_Atom and Feed_Rss2 get their base DOMElement.
		$atom = Feed::forge('atom')->get_base_element();
		$rss2 = Feed::forge('rss2')->get_base_element();

		// get_base_element() should return an instance of DOMElement.
		$this->assertInstanceOf('DOMElement', $atom);
		$this->assertInstanceOf('DOMElement', $rss2);

		// tagName of the element should equal the following values.
		$this->assertEquals('feed', $atom->tagName);
		$this->assertEquals('channel', $rss2->tagName);

	}


}
