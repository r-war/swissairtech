{if isset($info_messages.$source) && is_array($info_messages.$source) && $info_messages.$source|@count > 0}
<div class="alert alert-info">
    {foreach from=$info_messages.$source key=idx item=message}
        {if $idx > 0}<br/>{/if}{$message}
    {/foreach}
</div>
{/if}
{if ((isset($info_messages.$source) && is_array($info_messages.$source) && $info_messages.$source|@count > 0) && isset($error_messages.$source) && is_array($error_messages.$source) && $error_messages.$source|@count > 0)}
<br/>
{/if}
{if isset($error_messages.$source) && is_array($error_messages.$source) && $error_messages.$source|@count > 0}
<div class="alert alert-danger" role="alert">
    {foreach from=$error_messages.$source key=idx item=message}
        {if $idx > 0}<br/>{/if}{$message}
    {/foreach}
</div>
{/if}