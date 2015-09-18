<?php

namespace Eab\RelatedNodesBundle\Core\FieldType\RelatedNodes;

use eZ\Publish\API\Repository\Exceptions\InvalidArgumentException;
use eZ\Publish\API\Repository\Values\Content\Location;
use eZ\Publish\Core\Base\Exceptions\InvalidArgumentType;
use eZ\Publish\Core\FieldType\FieldType;
use eZ\Publish\Core\FieldType\Value as BaseValue;
use eZ\Publish\SPI\FieldType\Value as SPIValue;

class Type extends FieldType
{
    /**
     * Inspect given $inputValue and convert it into a Value object
     *
     * @param Location|int|string $inputValue
     * @return Value
     */
    protected function createValueFromInput( $inputValue )
    {
        // ContentInfo
        if ( $inputValue instanceof Location ) {
            $inputValue = new Value( array( $inputValue->id ) );
        }
        // location id
        else if ( is_integer( $inputValue ) )
        {
            $inputValue = new Value( array( $inputValue ) );
        }
        // array of location ids
        else if ( is_array( $inputValue ) )
        {
            $inputValue = new Value( $inputValue );
        }
        return $inputValue;
    }

    /**
     * Returns the fallback default value of field type when no such default
     * value is provided in the field definition in content types.
     *
     * @return Value
     */
    public function getEmptyValue()
    {
        return new Value;
    }

    /**
     * Returns the field type identifier for this field type
     *
     * @return string
     */
    public function getFieldTypeIdentifier()
    {
        return "relatednodes";
    }

    /**
     * Throw an exception if value structure is not of expected format
     *
     * @throws InvalidArgumentException if the value does not match the expected structure
     * @param Value2 $value
     * @return void
     */
    protected function checkValueStructure( BaseValue $value )
    {
        if ( !is_array( $value->locationIds ) ) {
            throw new InvalidArgumentType(
                "\$value->locationIds",
                'array',
                $value->locationIds
            );
        }

        foreach ( $value->locationIds as $key => $locationId ) {
            if ( !is_integer( $locationId ) && !is_string( $locationId ) ) {
                throw new InvalidArgumentType(
                    "\$value->locationIds[$key]",
                    'string|int',
                    $locationId
                );
            }
        }
    }

    /**
     * Convert a hash to the Value defined by the field type
     * @param mixed $hash
     * @return Value $value
     */
    public function fromHash( $hash )
    {
        return new Value( unserialize( $hash ) );
    }

    /**
     * Convert a Value to a hash
     * @param Value $value
     * @return array
     */
    public function toHash( SPIValue $value )
    {
        return serialize( $value->locationIds );
    }

    /**
     * Returns the name of the given field value.
     *
     * @param \eZ\Publish\Core\FieldType\RelationList\Value $value
     * @return string
     */
    public function getName( SPIValue $value )
    {
        throw new \RuntimeException( '@todo Implement this method' );
    }

    protected function getSortInfo( BaseValue $value )
    {
        return false;
    }

}
