<?php

namespace Eab\RelatedNodesBundle\Core\Persistence\Legacy\Content\FieldValue\Converter;

use eZ\Publish\Core\Persistence\Legacy\Content\FieldValue\Converter\TextLine as TextLineConverter;

/**
 * RelatedNodes field value converter class
 */
class RelatedNodesConverter extends TextLineConverter
{
    /**
     * Factory for current class
     *
     * @note Class should instead be configured as service if it gains dependencies.
     *
     * @return TextLine
     */
    public static function create()
    {
        return new self;
    }
}
