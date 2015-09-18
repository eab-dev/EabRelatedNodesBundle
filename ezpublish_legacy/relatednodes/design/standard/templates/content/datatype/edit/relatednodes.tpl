{def
    $attribute_base = first_set( $attribute_base, 'ContentObjectAttribute' )
    $input_prefix = concat( $attribute_base, '_', $attribute.id, '_' )
}

{if $attribute.content|count}
    <table class="list" cellspacing="0">
        <tr class="bglight">
            <th class="tight"><img src={'toggle-button-16x16.gif'|ezimage} alt="{'Invert selection.'|i18n( 'design/standard/content/datatype' )}" onclick="ezjs_toggleCheckboxes( document.editform, '{$attribute_base}_selection[{$attribute.id}][]' ); return false;" title="{'Invert selection.'|i18n( 'design/standard/content/datatype' )}" /></th>
            <th>Path</th>
            <th>Name</th>
            <th>Order</th>
        </tr>
        {foreach $attribute.content as $index => $node_id}
        <tr>
            <td>
                <input type="checkbox" name="{$attribute_base}_selection[{$attribute.id}][]" value="{$node_id}" />
                <input type="hidden" value="{$node_id}" name="{$input_prefix}related_nodes[{$index}]" />
            </td>
            <td>
                {def $node = fetch( 'content', 'node', hash( 'node_id', $node_id ) )}
                <a href={$selected_node.url_alias|ezurl} target="_blank">/{$selected_node.url_alias|wash}</a>
            </td>
            <td>
                {$node.name|wash}
                {undef $node}
            </td>
            <td>
                <input size="2" type="text" name="{$attribute_base}_priority[{$attribute.id}][{$node_id}]" value="{$index}" />
            </td>
        </tr>
        {/foreach}
    </table>
{else}
    <p>{'There are no related nodes.'|i18n( 'design/standard/content/datatype' )}</p>
{/if}

<input class="button" type="submit" name="CustomActionButton[{$attribute.id}_browse_related_nodes][{$tag_id|wash}][{$field_id|wash}]" value="{'Browse for nodes'|i18n( 'design/standard/content/datatype' )}"/>
{if $attribute.content|count}
    <input class="button" type="submit" name="CustomActionButton[{$attribute.id}_remove_related_nodes]" value="{'Remove selected'|i18n( 'design/standard/content/datatype' )}" />
    <input class="button" type="submit" name="CustomActionButton[{$attribute.id}_sort_related_nodes]" value="{'Update order'|i18n( 'design/standard/content/datatype' )}" />
{else}
    <input class="button-disabled" type="submit" name="CustomActionButton[{$attribute.id}_remove_related_nodes]" value="{'Remove selected'|i18n( 'design/standard/content/datatype' )}" disabled="disabled" />
    <input class="button-disabled" type="submit" name="CustomActionButton[{$attribute.id}_sort_related_nodes]" value="{'Update order'|i18n( 'design/standard/content/datatype' )}" disabled="disabled" />
{/if}


