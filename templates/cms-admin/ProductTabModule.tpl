<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/ckfinder/ckfinder.js"></script>
{include file="core/add_search.tpl"}
<div class="row-fluid">
	<ul class="breadcrumb">
	    <li>
	    <a href="{$oMod->getBasePage('Category')}">{loc k=category}</a> <span class="divider">/</span>
	    </li>
	    {assign var=oCategory value=$oProduct->getCategory()}
	    {if $oCategory instanceof Category}
	    {assign var=sSubParentUrl value='sub='|cat:$oCategory->getPrimaryKey()}
	    <li>
	    <a href="{$oMod->getBasePage('Product',$sSubParentUrl)}">{$oCategory->getName()}</a> <span class="divider">/</span>
	    </li>
	    {/if}
	    <li class="active">{$oProduct->getName()} - Extra Description / Product Tab</li>
    </ul>
</div>
<form action="{$oMod->getPage($oMod->getModule())}" method="POST">
<table cellspacing="0" cellpadding="0" border="0" id="listing" class="table table-striped table-bordered dataTable">
<thead>
<tr>
	<th width="20px" class="center"><input type="checkbox" class="checkbox" id="checkAll" onclick="ToggleCheck(document.theForm)"/></th>
	{include file='core/sortable.tpl' title='#' field='product_tab.INDEX' oSortable=$_sortable}
	{include file='core/sortable.tpl' title='name' field='product_tab.NAME' oSortable=$_sortable}
	<th width="230px">{loc k=options}</th>
</tr>
</thead>
{foreach from=$aProductTab key=idx item=oObj}
{assign var=sSelectUrl value='select='|cat:$oObj->getPrimaryKey()}
<tr>
	<td class="center"><input type="checkbox" class="checkbox" name="c[]" value="{$oObj->getPrimaryKey()}" id="c"/></td>
	<td>{$oObj->getIndex()}</td>
	<td>{$oObj->getName()}</td>
	<td class="center">
		<a href="{$oMod->getPage($oMod->getModule(),$sSelectUrl)}" role="button" class="btn btn-primary" data-toggle="modal" data-target="#myForm">{loc k=edit}</a>
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
{if $aProductTab|@count > 0}
<tr>
	<td colspan="5">
	<input type="submit" value="{loc k=delete_checked}" name="deleteChecked" class="btn" onclick="return confirm('{loc k=confirm_delete_checked}?');"/>
	</td>
</tr>
{/if}
</table>
{include file="core/page_list.tpl" oPager=$_pager}
</form>