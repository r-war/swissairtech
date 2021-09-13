<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/ckfinder/ckfinder.js"></script>
{include file="core/add_search.tpl"}
{if $oCategory instanceof Category}
<div class="row-fluid">
	<ul class="breadcrumb">
	    <li>
	    <a href="{$oMod->getBasePage('Category')}">{loc k=category}</a> <span class="divider">/</span>
	    </li>
	    {if $oCategory instanceof Category}
		    {assign var=oParent value=$oCategory->getParent()}
		    {if $oParent instanceof Category}
		    {assign var=sSubParentUrl value='sub='|cat:$oParent->getPrimaryKey()}
		    <li>
		    <a href="{$oMod->getBasePage('Category',$sSubParentUrl)}">{$oParent->getName()}</a> <span class="divider">/</span>
		    </li>
		    {/if}
		    <li class="active">{$oCategory->getName()}</li>
		{/if}
    </ul>
</div>
{/if}

<form name="theForm" action="{$oMod->getPage($oMod->getModule())}" method="POST">
<table cellspacing="0" cellpadding="0" border="0" id="listing" class="table table-striped table-bordered dataTable">
<thead>
<tr>
	<th width="20px" class="center"><input type="checkbox" class="checkbox" id="checkAll" onclick="ToggleCheck(document.theForm)"/></th>
	{include file='core/sortable.tpl' title='#' field='product.INDEX' oSortable=$_sortable}
	{include file='core/sortable.tpl' title='name' field='product.NAME' oSortable=$_sortable}
	<th width="350px">{loc k=options}</th>
</tr>
</thead>
{foreach from=$aProduct key=idx item=oObj}
{assign var=sSelectUrl value='select='|cat:$oObj->getPrimaryKey()}
{assign var=sSubUrl value='sub='|cat:$oObj->getPrimaryKey()}
{assign var=sRelatedUrl value='mode=product_'|cat:$oObj->getPrimaryKey()}
{assign var=sPropertyUrl value='productid='|cat:$oObj->getPrimaryKey()}
<tr>
	<td class="center"><input type="checkbox" class="checkbox" name="c[]" value="{$oObj->getPrimaryKey()}" id="c"/></td>
	<td>{$oObj->getIndex()}</td>
	<td>{$oObj->getName()}</td>
	<td class="center">
	    <a href="{$oMod->getBasePage(ProductPicture,$sSubUrl)}" role="button" class="btn btn-primary" title="Common picture always showed on every product detail">{loc k=picture}</a>
		<a href="{$oMod->getBasePage(ProductUser,$sPropertyUrl)}" role="button" class="btn btn-primary" >{loc k=user} {if $oObj->countUser() > 0}({$oObj->countUser()}){/if}</a>
		<a href="{$oMod->getPage($oMod->getModule(),$sSelectUrl)}" role="button" class="btn btn-primary" data-toggle="modal" data-target="#myForm">{loc k=edit}</a>
		<input name="delete_{$oObj->getCode()}" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oObj->getPrimaryKey()}','{val v=$oObj->getCode() parsequote=true}')"/>
	</td>
</tr>
{foreachelse}
<tr>
	<td colspan="9" class="center">
	{loc k=no_data}
	</td>
</tr>
{/foreach}
{if $aProduct|@count > 0}
<tr>
	<td colspan="9">
	<input type="submit" value="{loc k=delete_checked}" name="deleteChecked" class="btn" onclick="return confirm('{loc k=confirm_delete_checked}?');"/>
	</td>
</tr>
{/if}
</table>
{include file="core/page_list.tpl" oPager=$_pager}
</form>