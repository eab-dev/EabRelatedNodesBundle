<div class="block">

    <div class="element">
        <label>{'Default value'|i18n( 'design/standard/class/datatype' )}:</label>
        {section show=$class_attribute.data_text1}
            <p>{$class_attribute.data_text1|wash}</p>
        {section-else}
            <p><i>{'Empty'|i18n( 'design/standard/class/datatype' )}</i></p>
        {/section}
    </div>

    <div class="element">
        <label>{'Max string length'|i18n( 'design/standard/class/datatype' )}:</label>
        <p>{$class_attribute.data_int1}&nbsp;{'characters'|i18n( 'design/standard/class/datatype' )}</p>
    </div>

</div>
