<?php

use PHPUnit\Framework\TestCase;
use WaughJ\HTMLAttribute\HTMLAttribute;
use WaughJ\HTMLAttributeList\HTMLAttributeList;

class HTMLAttributeListTest extends TestCase
{
	public function testIsThereAnySyntaxError() : void
	{
		$attribute = $this->getDemoObject();
		$this->assertTrue( is_object( $attribute ) );
	}

	public function testAttributesText() : void
	{
		$attribute = $this->getDemoObject();
		$this->assertEquals( $attribute->getAttributesText(), ' class="footer" id="main-footer"' );
	}

	public function testAttributesValues() : void
	{
		$attributes = $this->getDemoObject();
		$values = $attributes->getAttributeValues();
		$this->assertEquals( count( $values ), count( self::DEMO_ATTS ) );
		$this->assertEquals( $values, self::DEMO_VALUES );
	}

	public function testAttributesValuesMap() : void
	{
		$attributes = $this->getDemoObject();
		$values = $attributes->getAttributeValuesMap();
		$this->assertEquals( count( $values ), count( self::DEMO_ATTS ) );
		$this->assertEquals( $values, self::DEMO_ATTS );
	}

	public function testAttributesObjects() : void
	{
		$attributes = $this->getDemoObject();
		$objects = $attributes->getAttributes();
		$this->assertEquals( count( $objects ), 2 );
		$expected_list = [ 'class' => new HTMLAttribute( 'class', 'footer' ), 'id' => new HTMLAttribute( 'id', 'main-footer' ) ];
		$this->assertEquals( $objects, $expected_list );
	}

	public function testAttributeText() : void
	{
		$attributes = $this->getDemoObject();
		foreach ( self::DEMO_ATTS as $key => $val )
		{
			$attribute_text = $attributes->getAttributeText( $key );
			$expected_text = $key . '="' . $val . '"';
			$this->assertEquals( $attribute_text, $expected_text );
		}
	}

	public function testAttributeValue() : void
	{
		$attributes = $this->getDemoObject();
		foreach ( self::DEMO_ATTS as $key => $val )
		{
			$value = $attributes->getAttributeValue( $key );
			$this->assertEquals( $value, $val );
		}
	}

	public function testAttributeObject() : void
	{
		$attributes = $this->getDemoObject();
		foreach ( self::DEMO_ATTS as $key => $val )
		{
			$class_object = $attributes->getAttribute( $key );
			$expected_object = new HTMLAttribute( $key, $val );
			$this->assertEquals( $class_object, $expected_object );
		}
	}

	public function testHasAttribute() : void
	{
		$attributes = $this->getDemoObject();
		$this->assertEquals( $attributes->hasAttribute( 'class' ), true );
		$this->assertEquals( $attributes->hasAttribute( 'porko' ), false );
	}

	public function testValidAttributes() : void
	{
		$attributes = new HTMLAttributeList( [ 'class' => 'footer', 'id' => 'main-footer', 'food' => 'pork', 'something' => 'something' ], [ 'class', 'id' ] );
		$this->assertEquals( $attributes->hasAttribute( 'pork' ), false );
		$this->assertEquals( $attributes->hasAttribute( 'something' ), false );
		$this->assertEquals( $attributes->hasAttribute( 'class' ), true );
		$this->assertEquals( $attributes->hasAttribute( 'id' ), true );
	}

	public function testAttributeList() : void
	{
		$attributes = new HTMLAttributeList( [ 'class' => 'footer', 'id' => 'main-footer', 'food' => 'pork', 'something' => 'something' ], [ 'class', 'id' ] );
		$this->assertEquals( $attributes->getAttributeList()[ 0 ], new HTMLAttribute( 'class', 'footer' ) );
	}

	public function testSetAttribute() : void
	{
		$attributes1 = new HTMLAttributeList( [ 'class' => 'footer', 'id' => 'main-footer', 'food' => 'pork', 'something' => 'something' ], [ 'class', 'id' ] );
		$attributes2 = $attributes1->setAttribute( 'width', 200 )->setAttribute( 'class', 'header' );
		$this->assertEquals( $attributes1->hasAttribute( 'width' ), false );
		$this->assertEquals( $attributes2->hasAttribute( 'width' ), true );
		$this->assertEquals( $attributes1->getAttributeValue( 'class' ), 'footer' );
		$this->assertEquals( $attributes2->getAttributeValue( 'class' ), 'header' );
		$this->assertEquals( $attributes2->getAttributeValue( 'id' ), 'main-footer' );
	}

	public function testRemoveAttribute() : void
	{
		$attributes1 = new HTMLAttributeList( [ 'class' => 'footer', 'id' => 'main-footer', 'food' => 'pork', 'something' => 'something' ], [ 'class', 'id' ] );
		$attributes2 = $attributes1->removeAttribute( 'id' );
		$this->assertEquals( $attributes1->hasAttribute( 'id' ), true );
		$this->assertEquals( $attributes2->hasAttribute( 'id' ), false );
		$this->assertEquals( $attributes2->getAttributeValue( 'class' ), 'footer' );
	}

	public function testAppendToAttribute() : void
	{
		$attributes1 = new HTMLAttributeList( [ 'class' => 'footer', 'id' => 'main-footer', 'food' => 'pork', 'something' => 'something' ], [ 'class', 'id' ] );
		$attributes2 = $attributes1->appendToAttribute( 'class', 'main-footer' );
		$this->assertEquals( 'footer', $attributes1->getAttributeValue( 'class' ) );
		$this->assertEquals( 'footer main-footer', $attributes2->getAttributeValue( 'class' ) );
	}

	public function testRemoveFromAttribute() : void
	{
		$attributes1 = new HTMLAttributeList( [ 'class' => 'footer main-footer', 'id' => 'main-footer', 'food' => 'pork', 'something' => 'something' ], [ 'class', 'id' ] );
		$attributes2 = $attributes1->removeFromAttribute( 'class', 'main-footer' );
		$attributes3 = $attributes2->removeFromAttribute( 'class', 'footer' );
		$this->assertEquals( 'footer main-footer', $attributes1->getAttributeValue( 'class' ) );
		$this->assertEquals( 'footer', $attributes2->getAttributeValue( 'class' ) );
		$this->assertEquals( $attributes3->hasAttribute( 'class' ), false );
		$this->assertEquals( 'main-footer', $attributes3->getAttributeValue( 'id' ) );
	}

	private function getDemoObject() : HTMLAttributeList
	{
		return new HTMLAttributeList( self::DEMO_ATTS );
	}

	const DEMO_KEYS = [ 'class', 'id' ];
	const DEMO_VALUES = [ 'footer', 'main-footer' ];
	const DEMO_ATTS = [ self::DEMO_KEYS[ 0 ] => self::DEMO_VALUES[ 0 ], self::DEMO_KEYS[ 1 ] => self::DEMO_VALUES[ 1 ] ];
}
