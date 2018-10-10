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
		$this->assertEquals( $attribute->GetAttributesText(), ' class="footer" id="main-footer"' );
	}

	public function testAttributesValues() : void
	{
		$attributes = $this->getDemoObject();
		$values = $attributes->GetAttributeValues();
		$this->assertEquals( count( $values ), count( self::DEMO_ATTS ) );
		$this->assertEquals( $values, self::DEMO_VALUES );
	}

	public function testAttributesObjects() : void
	{
		$attributes = $this->getDemoObject();
		$objects = $attributes->GetAttributes();
		$this->assertEquals( count( $objects ), 2 );
		$expected_list = [ 'class' => new HTMLAttribute( 'class', 'footer' ), 'id' => new HTMLAttribute( 'id', 'main-footer' ) ];
		$this->assertEquals( $objects, $expected_list );
	}

	public function testAttributeText() : void
	{
		$attributes = $this->getDemoObject();
		foreach ( self::DEMO_ATTS as $key => $val )
		{
			$attribute_text = $attributes->GetAttributeText( $key );
			$expected_text = $key . '="' . $val . '"';
			$this->assertEquals( $attribute_text, $expected_text );
		}
	}

	public function testAttributeValue() : void
	{
		$attributes = $this->getDemoObject();
		foreach ( self::DEMO_ATTS as $key => $val )
		{
			$value = $attributes->GetAttributeValue( $key );
			$this->assertEquals( $value, $val );
		}
	}

	public function testAttributeObject() : void
	{
		$attributes = $this->getDemoObject();
		foreach ( self::DEMO_ATTS as $key => $val )
		{
			$class_object = $attributes->GetAttribute( $key );
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

	private function getDemoObject() : HTMLAttributeList
	{
		return new HTMLAttributeList( self::DEMO_ATTS );
	}

	private const DEMO_KEYS = [ 'class', 'id' ];
	private const DEMO_VALUES = [ 'footer', 'main-footer' ];
	private const DEMO_ATTS = [ self::DEMO_KEYS[ 0 ] => self::DEMO_VALUES[ 0 ], self::DEMO_KEYS[ 1 ] => self::DEMO_VALUES[ 1 ] ];
}
