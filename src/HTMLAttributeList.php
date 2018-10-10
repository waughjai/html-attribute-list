<?php

declare( strict_types = 1 );
namespace WaughJ\HTMLAttributeList
{
	use WaughJ\HTMLAttribute\HTMLAttribute;

	class HTMLAttributeList
	{
		public function __construct( array $attributes, ?array $valid_attributes = null )
		{
			$this->attributes = [];
			foreach ( $attributes as $attribute_key => $attribute_value )
			{
				$this->attributes[ $attribute_key ] = new HTMLAttribute( $attribute_key, ( string )( $attribute_value ) );
			}
		}

		public function __toString()
		{
			return $this->getAttributesText();
		}

		// Returns HTML text with spaces 'tween attributes & starting with a space.
		public function getAttributesText() : string
		{
			return ( !empty( $this->attributes ) ) ? ' ' . implode( ' ', $this->attributes ) : '';
		}

		// Returns classic, indiced array o' Attribute objects.
		public function getAttributeValues() : array
		{
			$array = [];
			foreach ( $this->attributes as $attribute )
			{
				array_push( $array, $attribute->getValue() );
			}
			return $array;
		}

		// Returns hash map / associative array o' Attribute objects.
		public function getAttributes() : array
		{
			return $this->attributes;
		}

		// Get HTML text o' attribute
		public function getAttributeText( string $attribute_key ) : string
		{
			$attribute = $this->getAttribute( $attribute_key );
			return ( $attribute ) ? $attribute->getText() : '';
		}

		public function getAttributeValue( string $attribute_key ) : ?string
		{
			$attribute = $this->getAttribute( $attribute_key );
			return ( $attribute ) ? $attribute->getValue() : null;
		}

		public function getAttribute( string $attribute_key ) : ?HTMLAttribute
		{
			if ( $this->hasAttribute( $attribute_key ) )
			{
				return $this->attributes[ $attribute_key ];
			}
			return null;
		}

		public function hasAttribute( string $attribute_key ) : bool
		{
			return isset( $this->attributes[ $attribute_key ] );
		}

		private $attributes;
	}
}
