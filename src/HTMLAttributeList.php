<?php

declare( strict_types = 1 );
namespace WaughJ\HTMLAttributeList;

use WaughJ\HTMLAttribute\HTMLAttribute;

class HTMLAttributeList
{
	// $attributes is hash map o' attribute keys & values.
	// Optional $valid_attributes is a whitelist indiced array o' attribute keys to allow.
	// All pairs in $attributes not in $valid_attributes are ignored.
	// If $valid_attributes is null, as default, all $attributes are accepted.
	public function __construct( array $attributes, $valid_attributes = null )
	{
		$this->attributes = [];

		// If no valid attributes given, make all attribute keys valid;
		if ( !is_array( $valid_attributes ) )
		{
			$valid_attributes = array_keys( $attributes );
		}

		foreach ( $attributes as $attribute_key => $attribute_value )
		{
			if ( in_array( $attribute_key, $valid_attributes ) )
			{
				$this->attributes[ $attribute_key ] = new HTMLAttribute( $attribute_key, ( string )( $attribute_value ) );
			}
		}
	}

	public function __toString()
	{
		return $this->getAttributesText();
	}

	// Returns HTML text with spaces 'tween attributes & starting with a space.
	public function getAttributesText() : string
	{
		return ( !empty( $this->attributes ) )
			? ' ' . implode( ' ', $this->attributes )
			: '';
	}

	// Returns classic, indiced array o' Attribute value strings.
	public function getAttributeValues() : array
	{
		$array = [];
		foreach ( $this->attributes as $attribute )
		{
			$array[] = $attribute->getValue();
		}
		return $array;
	}

	// Returns hash map / associative array o' attribute value strings.
	public function getAttributeValuesMap() : array
	{
		$hash = [];
		foreach ( $this->attributes as $attribute )
		{
			$hash[ $attribute->getKey() ] = $attribute->getValue();
		}
		return $hash;
	}

	// Returns hash map / associative array o' Attribute objects.
	public function getAttributes() : array
	{
		return $this->attributes;
	}

	// Returns indiced array o' Attribute objects.
	public function getAttributeList() : array
	{
		return array_values( $this->attributes );
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

	public function setAttribute( string $key, string $value ) : HTMLAttributeList // Keep class immutable.
	{
		$new_attributes = $this->getAttributeValuesMap(); // Make copy o’ my attributes so it isn’t changed.
		$new_attributes[ $key ] = $value;
		return new HTMLAttributeList( $new_attributes );
	}

	public function removeAttribute( string $key ) : HTMLAttributeList // Keep class immutable.
	{
		$new_attributes = $this->getAttributeValuesMap(); // Make copy o’ my attributes so it isn’t changed.
		unset( $new_attributes[ $key ] );
		return new HTMLAttributeList( $new_attributes );
	}

	public function appendToAttribute( string $key, string $added_value ) : HTMLAttributeList // Keep class immutable.
	{
		$new_attributes = $this->getAttributeValuesMap(); // Make copy o’ my attributes so it isn’t changed.
		$new_attributes[ $key ] = ( $this->hasAttribute( $key ) )
			? $new_attributes[ $key ] . ' ' . $added_value
			: $added_value;
		return new HTMLAttributeList( $new_attributes );
	}

	public function removeFromAttribute( string $key, string $removed_value ) : HTMLAttributeList // Keep class immutable.
	{
		$new_attributes = $this->getAttributeValuesMap(); // Make copy o’ my attributes so it isn’t changed.
		$new_attributes[ $key ] = trim( str_replace( $removed_value, '', $new_attributes[ $key ] ) );
		if ( empty( $new_attributes[ $key ] ) )
		{
			unset( $new_attributes[ $key ] );
		}
		return new HTMLAttributeList( $new_attributes );
	}

	private $attributes;
}
