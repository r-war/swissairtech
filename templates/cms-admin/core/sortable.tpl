{if $oSortable instanceof Sortable}
	<th width="{$width}" {if $colspan}colspan={$colspan}{/if} 
	{if $oSortable->isAscending($field)}
	class="sorting_asc"
	{elseif $oSortable->isDescending($field)}
	class="sorting_desc"
	{else}
	class="sorting"
	{/if}
	 onclick="redirect('{$oMod->getPage($oMod->getModule(),$oSortable->getURL($field))}')">{loc k=$title}</th>
{else}
	<th width="{$width}">{loc k=$title}</th>
{/if}