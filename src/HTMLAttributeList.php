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
				$this->attributes[ $attribute_key ] = new HTMLAttribute( $attribute_key, $attribute_value );
			}
		}

		public function __toString()
		{
			return $this->GetAttributesText();
		}

		// Returns HTML text with spaces 'tween attributes & starting with a space.
		public function GetAttributesText() : string
		{
			return ( !empty( $this->attributes ) ) ? ' ' . implode( ' ', $this->attributes ) : '';
		}

		// Returns classic, indiced array o' Attribute objects.
		public function GetAttributeValues() : array
		{
			$array = [];
			foreach ( $this->attributes as $attribute )
			{
				array_push( $array, $attribute->GetValue() );
			}
			return $array;
		}

		// Returns hash map / associative array o' Attribute objects.
		public function GetAttributes() : array
		{
			return $this->attributes;
		}

		// Get HTML text o' attribute
		public function GetAttributeText( string $attribute_key ) : string
		{
			$attribute = $this->GetAttribute( $attribute_key );
			return ( $attribute ) ? $attribute->GetText() : '';
		}

		public function GetAttributeValue( string $attribute_key ) : ?string
		{
			$attribute = $this->GetAttribute( $attribute_key );
			return ( $attribute ) ? $attribute->GetValue() : null;
		}

		public function GetAttribute( string $attribute_key ) : ?HTMLAttribute
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
