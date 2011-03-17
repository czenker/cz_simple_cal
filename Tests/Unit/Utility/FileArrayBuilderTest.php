<?php

/**
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Utility_FileArrayBuilderTest extends tx_phpunit_testcase {
	
	/**
	 * test when no files are given
	 */
	public function testOnEmptyData() {
		$images = Tx_CzSimpleCal_Utility_FileArrayBuilder::build('', '/foo/bar');
		
		$this->assertTrue(is_array($images), 'an array is returned');
		$this->assertEquals(0, count($images), 'array is empty');
	}
	
	/**
	 * test when one file is given but no alternative text or caption
	 */
	public function testOnOneImageWithoutEverything() {
		$images = Tx_CzSimpleCal_Utility_FileArrayBuilder::build('baz.jpg', 'foo/bar/');
		
		$this->assertTrue(is_array($images), 'an array is returned');
		$this->assertEquals(1, count($images), 'array has one entry');
		
		$image = current($images);
		
		$this->assertEquals('baz.jpg', $image->getFile(), 'filename is correctly set');
		$this->assertEquals('foo/bar/', $image->getPath(), 'path is correctly set');
		$this->assertNull($image->getAlternateText(), 'alternate text is empty');
		$this->assertNull($image->getCaption(), 'caption is empty');
	}
	
	/**
	 * test when two images with caption and alternative text are given
	 */
	public function testOnTwoImagesWithAlternateAndCaption() {
		$images = Tx_CzSimpleCal_Utility_FileArrayBuilder::build('baz.jpg,bar.png', 'foo/bar/', "hello\nworld", "42\nfoobar");
		
		$this->assertTrue(is_array($images), 'an array is returned');
		$this->assertEquals(2, count($images), 'array has two entries');
		
		$image = current($images);
		$this->assertEquals('baz.jpg', $image->getFile(), 'image #1: filename is correctly set');
		$this->assertEquals('foo/bar/', $image->getPath(), 'image #1: path is correctly set');
		$this->assertSame('hello', $image->getAlternateText(), 'image #1: alternate text correctly set');
		$this->assertSame('42', $image->getCaption(), 'image #1: caption correctly set');
		
		$image = next($images);
		$this->assertEquals('bar.png', $image->getFile(), 'image #2: filename is correctly set');
		$this->assertEquals('foo/bar/', $image->getPath(), 'image #2: path is correctly set');
		$this->assertSame('world', $image->getAlternateText(), 'image #2: alternate text correctly set');
		$this->assertSame('foobar', $image->getCaption(), 'image #2: caption correctly set');
	}
	
	/**
	 * test if captions an alternate texts are assigned correctly if some image does not have one 
	 */
	public function testTwoImagesWithMissingAlternateTextAndCaptions() {
		$images = Tx_CzSimpleCal_Utility_FileArrayBuilder::build('baz.jpg,bar.png', 'foo/bar/', "\nworld", "\nfoobar");
		
		$this->assertTrue(is_array($images), 'an array is returned');
		$this->assertEquals(2, count($images), 'array has two entries');
		
		$image = current($images);
		$this->assertEquals('baz.jpg', $image->getFile(), 'image #1: filename is correctly set');
		$this->assertEquals('foo/bar/', $image->getPath(), 'image #1: path is correctly set');
		$this->assertNull($image->getAlternateText(), 'image #1: alternate text null');
		$this->assertNull($image->getCaption(), 'image #1: caption null');
		
		$image = next($images);
		$this->assertEquals('bar.png', $image->getFile(), 'image #2: filename is correctly set');
		$this->assertEquals('foo/bar/', $image->getPath(), 'image #2: path is correctly set');
		$this->assertSame('world', $image->getAlternateText(), 'image #2: alternate text correctly set');
		$this->assertSame('foobar', $image->getCaption(), 'image #2: caption correctly set');
	}
	
	/**
	 * test that everything works alright no matter if a path-spec is finished with a slash or not
	 */
	public function testIfPathEndsWithSlash() {
		$images = Tx_CzSimpleCal_Utility_FileArrayBuilder::build('baz.jpg', 'foo/bar/');
		$image = current($images);
		$this->assertEquals('foo/bar/', $image->getPath(), 'ok if already finished with slash');
		
		$images = Tx_CzSimpleCal_Utility_FileArrayBuilder::build('baz.jpg', 'foo/bar');
		$image = current($images);
		$this->assertEquals('foo/bar/', $image->getPath(), 'ok if not finished with slash');
		
		$images = Tx_CzSimpleCal_Utility_FileArrayBuilder::build('baz.jpg', '/foo/bar/');
		$image = current($images);
		$this->assertEquals('/foo/bar/', $image->getPath(), 'leading slash is not removed');
		
	}
	
}
