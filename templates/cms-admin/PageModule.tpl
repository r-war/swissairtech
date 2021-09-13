<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/ckfinder/ckfinder.js"></script>
{include file="core/add_search.tpl"}
<form name="theForm" action="{$oMod->getPage($oMod->getModule())}" method="POST">
<table cellspacing="0" cellpadding="0" border="0" id="listing" class="table table-striped table-bordered dataTable">
<thead>
<tr>
	<th width="20px" class="center"><input type="checkbox" class="checkbox" id="checkAll" onclick="ToggleCheck(document.theForm)"/></th>
	{include file='core/sortable.tpl' title='name' field='page.NAME' oSortable=$_sortable}
	<th>{loc k=url}</th>
	<th width="300px">{loc k=options}</th>
</tr>
</thead>
{foreach from=$aPage key=idx item=oObj}
{assign var=sSelectUrl value='select='|cat:$oObj->getPrimaryKey()}
{assign var=sSubUrl value='sub='|cat:$oObj->getPrimaryKey()}
{assign var=sBannerUrl value='back=page&mode='|cat:$oMod->getBasePage('Page',null,true)|@cat:$oObj->getUrl()}
<tr>
	<td class="center"><input type="checkbox" class="checkbox" name="c[]" value="{$oObj->getPrimaryKey()}" id="c"/></td>
	<td>{$oObj->getName()}</td>
	<td>{$oMod->getBaseDomain()}{$oMod->getBasePage('Page',null,true)}{$oObj->getUrl()}</td>
	<td class="center">
		<a href="{$oMod->getBasePage(PageTab,$sSubUrl)}" role="button" class="btn btn-primary" title="Page Tab">Page Tab</a>
		<a href="{$oMod->getPage($oMod->getModule(),$sSelectUrl)}" role="button" class="btn btn-primary" data-toggle="modal" data-target="#myForm">{loc k=edit}</a>
		{*<a href="{$oMod->getPage(Banner,$sBannerUrl)}" role="button" class="btn btn-info">{loc k=banner}</a>*}
		<input name="delete_{$oObj->getName()}" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oObj->getPrimaryKey()}','{val v=$oObj->getName() parsequote=true}')"/>
	</td>
</tr>
{foreachelse}
<tr>
	<td colspan="6" class="center">
	{loc k=no_data}
	</td>
</tr>
{/foreach}
{if $aPage|@count > 0}
<tr>
	<td colspan="5">
	<input type="submit" value="{loc k=delete_checked}" name="deleteChecked" class="btn" onclick="return confirm('{loc k=confirm_delete_checked}?');"/>
	</td>
</tr>
{/if}
</table>
{include file="core/page_list.tpl" oPager=$_pager}
</form>