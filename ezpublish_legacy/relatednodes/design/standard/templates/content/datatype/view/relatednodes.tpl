{if $attribute.content|count}
<ul>
{foreach $attribute.content as $index => $node_id}
    {def $node = fetch( 'content', 'node', hash( 'node_id', $node_id ) )}
    <li><a href={$node.url_alias|ezurl}>{$node.name|wash}</a></li>
    {undef $node}
{/foreach}
</ul>
{/if}
