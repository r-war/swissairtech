{include file="core/add_search.tpl"}
<form name="theForm" action="{$oMod->getPage($oMod->getModule())}" method="POST">
<table cellspacing="0" cellpadding="0" border="0" id="listing" class="table table-striped table-bordered dataTable">
<thead>
<tr>
	<th width="20px" class="center"><input type="checkbox" class="checkbox" id="checkAll" onclick="ToggleCheck(document.theForm)"/></th>
	{include file='core/sortable.tpl' title='URL Matched' field='seo.URL' oSortable=$_sortable}
	{include file='core/sortable.tpl' title='Page Title' field='seo.META_TITLE' oSortable=$_sortable}
	<th width="200px">{loc k=options}</th>
</tr>
</thead>
{foreach from=$aSeo key=idx item=oObj}
{assign var=sSelectUrl value='select='|cat:$oObj->getPrimaryKey()}
<tr>
	<td class="center"><input type="checkbox" class="checkbox" name="c[]" value="{$oObj->getPrimaryKey()}" id="c"/></td>
	<td>{$oObj->getUrl()}</td>
	<td>{$oObj->getMetaTitle()}</td>
	<td class="center">
		<a href="{$oMod->getPage($oMod->getModule(),$sSelectUrl)}" role="button" class="btn btn-primary" data-toggle="modal" data-target="#myForm">{loc k=edit}</a>
		<input name="delete_{$oObj->getUrl()}" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oObj->getPrimaryKey()}','{val v=$oObj->getUrl() parsequote=true}')"/>
	</td>
</tr>
{foreachelse}
<tr>
	<td colspan="6" class="center">
	{loc k=no_data}
	</td>
</tr>
{/foreach}
{if $aSeo|@count > 0}
<tr>
	<td colspan="5">
	<input type="submit" value="{loc k=delete_checked}" name="deleteChecked" class="btn" onclick="return confirm('{loc k=confirm_delete_checked}?');"/>
	</td>
</tr>
{/if}
</table>
{include file="core/page_list.tpl" oPager=$_pager}
</form>