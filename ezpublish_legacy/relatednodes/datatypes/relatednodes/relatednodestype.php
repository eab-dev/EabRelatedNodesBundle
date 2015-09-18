<?php

/*
 * Related Node datatype
 */

class RelatedNodesType extends eZDataType
{
    const DATA_TYPE_STRING = 'relatednodes';

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct( self::DATA_TYPE_STRING, 'Related Nodes', array( 'serialize_supported' => true ) );
    }

    function initializeObjectAttribute( $contentObjectAttribute, $currentVersion, $originalContentObjectAttribute )
    {
        if( $originalContentObjectAttribute->attribute( 'data_text' ) != null )
        {
            $contentObjectAttribute->setAttribute( 'data_text', $originalContentObjectAttribute->attribute( 'data_text' ) );
        }
    }

    /**
     * Validates input on content object level
     \return eZInputValidator::STATE_ACCEPTED or eZInputValidator::STATE_INVALID if
                     the values are accepted or not
    */
    function validateObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        return eZInputValidator::STATE_ACCEPTED;
    }

    /**
     * Set parameters from post data
     *
     * @param eZHTTPTool $http
     * @param string $base
     * @param eZContentObjectAttribute $contentObjectAttribute
     */
    function fetchObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        $data = $_REQUEST[ $base . '_' . $contentObjectAttribute->attribute( 'id' ) . '_related_nodes' ];
        $contentObjectAttribute->setAttribute( 'data_text', serialize( $data ) );
        return true;
    }

    /**
     * Return the content
     */
    function objectAttributeContent( $contentObjectAttribute )
    {
        return unserialize( $contentObjectAttribute->attribute( 'data_text' ) );
    }

    /**
     * Browse for a node
     */
    function customObjectAttributeHTTPAction( $http, $action, $contentObjectAttribute, $parameters )
    {
        $content = $contentObjectAttribute->content();

        switch( $action )
        {
            case "browse_related_nodes":
                $customActionButton = $http->postVariable( 'CustomActionButton' );
                $selectNodeCustomActionButton = $customActionButton[ $contentObjectAttribute->attribute( 'id' ) . '_browse_related_nodes' ];
                $module = $parameters[ 'module' ];
                $redirectionURI = $parameters['current-redirection-uri'];
                $browseParameters = array( 'action_name' => 'AddRelatedNodes',
                                           'browse_custom_action' => array( 'name' => 'CustomActionButton[' . $contentObjectAttribute->attribute( 'id' ) . '_set_related_nodes]',
                                                                            'value' => $contentObjectAttribute->attribute( 'id' ) ),
                                           'persistent_data' => array( 'HasObjectInput' => 0 ) ,
                                           'from_page' => $redirectionURI );
                eZContentBrowse::browse( $browseParameters, $module );
                break;
            case "set_related_nodes":
                if ( !$http->hasPostVariable( 'BrowseCancelButton' ) )
                {
                    $customActionButton = $http->postVariable( 'CustomActionButton' );
                    $values = $customActionButton[ $contentObjectAttribute->attribute( 'id' ) . '_set_related_nodes' ];
                    $selectedNodeIDs = $http->postVariable( "SelectedNodeIDArray" );

                    if( $selectedNodeIDs !== null )
                    {
                        foreach ( $selectedNodeIDs as $nodeID )
                        {
                            if ( !is_numeric( $nodeID ) )
                            {
                                eZDebug::writeError( "Related node ID (nodeID): '$nodeID', is not a numeric value.", __METHOD__ );
                                return;
                            }
                            if ( !in_array( $nodeID, $content ) )
                            {
                                $content[] = $nodeID;
                            }
                        }
                        $contentObjectAttribute->setContent( $content );
                        $contentObjectAttribute->store();
                    }
                }
                break;

            case "remove_related_nodes":
                $selectionBase = $parameters[ 'base_name' ] . '_selection';
                $selections = array();
                if ( $http->hasPostVariable( $selectionBase ) )
                {
                    $selectionMap = $http->postVariable( $selectionBase );
                    $selections = $selectionMap[ $contentObjectAttribute->attribute( 'id' ) ];
                }

                // Build new array by omitting selected nodes
                $newContent = array();
                foreach( $content as $nodeID )
                {
                    if ( !in_array( $nodeID, $selections ) )
                    {
                        $newContent[] = $nodeID;
                    }
                }
                $contentObjectAttribute->setAttribute( 'data_text', serialize( $newContent ) );
                $contentObjectAttribute->store();
                break;

            case "sort_related_nodes":
                $selectionBase = $parameters[ 'base_name' ] . '_priority';
                $priorities = array();
                if ( $http->hasPostVariable( $selectionBase ) )
                {
                    $selectionMap = $http->postVariable( $selectionBase );
                    $priorities = $selectionMap[ $contentObjectAttribute->attribute( 'id' ) ];
                }

                $cleanPriorities = array();
                foreach ( $priorities as $nodeID => $priority )
                {
                    if ( is_numeric( $priority ) )
                    {
                        // Use the new priority
                        $cleanPriorities[ $nodeID ] = $priority;
                    }
                    else
                    {
                        // The new priority is invalid so use the old priority
                        $cleanPriorities[ $nodeID ] = array_search( $nodeID, $content );
                    }
                }

                asort( $cleanPriorities );
                $keys = array_keys( $cleanPriorities );
                $contentObjectAttribute->setAttribute( 'data_text', serialize( $keys ) );
                $contentObjectAttribute->store();

                break;

            default:
                eZDebug::writeError( "Unknown custom HTTP action: " . $action, "RelatedNodesType" );
                break;
        }
    }

    /**
     * Return the meta data used for storing search indeces.
     */
    function metaData( $contentObjectAttribute )
    {
        return null;
    }

    function toString( $contentObjectAttribute )
    {
        return serialize( $contentObjectAttribute->attribute( 'data_text' ) );
    }

    function fromString( $contentObjectAttribute, $string )
    {
        // not yet implemented
        //return $contentObjectAttribute->attribute( 'data_text' );
    }

    /**
     * Return the value as it will be shown if this attribute is used in the object name pattern.
     */
    function title( $contentObjectAttribute, $name = null )
    {
        return 'Related Nodes';
    }

    function hasObjectAttributeContent( $contentObjectAttribute )
    {
        return $contentObjectAttribute->attribute( 'data_text' ) !== null;
    }

    function isIndexable()
    {
        return false;
    }
}

eZDataType::register( RelatedNodesType::DATA_TYPE_STRING, 'RelatedNodesType' );
