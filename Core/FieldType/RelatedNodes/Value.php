<?php

namespace Eab\RelatedNodesBundle\Core\FieldType\RelatedNodes;

use eZ\Publish\Core\FieldType\Value as BaseValue;

/**
 * Value for RelatedNodes field type
 */
class Value extends BaseValue
{
    /**
     * Related location ids
     *
     * @var mixed[]
     */
    public $locationIds;

    /**
     * Construct a new Value object and initialize it $text
     *
     * @param int[] locationIds
     */
    public function __construct( $locationIds = array() )
    {
        $this->locationIds = $locationIds;
    }

    public function __toString()
    {
        return implode( ',', $this->$locationIds );
    }
}
