<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/ckfinder/ckfinder.js"></script>
{include file="core/add_search.tpl"}
{if $oParentCategory instanceof Category}
<div class="row-fluid">
	<ul class="breadcrumb" style="margin-bottom: 10px;">
	    <li>
		    <a href="{$oMod->getBasePage('Category')}">{loc k=category}</a> <span class="divider">/</span>
	    </li>
	    {assign var=oParent value=$oParentCategory->getParent()}
	    {if $oParent instanceof Category}
	    {assign var=sParentUrl value='sub='|cat:$oParent->getPrimaryKey()}
	    <li>
	    <a href="{$oMod->getBasePage('Category',$sParentUrl)}">{$oParent->getName()}</a> <span class="divider">/</span>
	    </li>
	    {/if}	
	    <li class="active">{$oParentCategory->getName()}</li>
    </ul>
</div>
{/if}
<form name="theForm" action="{$oMod->getPage($oMod->getModule())}" method="POST">
<table cellspacing="0" cellpadding="0" border="0" id="listing" class="table table-striped table-bordered dataTable">
<thead>
<tr>
	<th width="20px" class="center"><input type="checkbox" class="checkbox" id="checkAll" onclick="ToggleCheck(document.theForm)"/></th>
	{include file='core/sortable.tpl' title='#' field='category.INDEX' oSortable=$_sortable}
	{include file='core/sortable.tpl' title='name' field='category.NAME' oSortable=$_sortable}
	{*<th>{loc k=picture}</th>*}
	<th width="330px">{loc k=options}</th>
</tr>
</thead>
{foreach from=$aCategory key=idx item=oObj}
{assign var=sSelectUrl value='select='|cat:$oObj->getPrimaryKey()}
{assign var=sSubUrl value='sub='|cat:$oObj->getPrimaryKey()}
<tr>
	<td class="center"><input type="checkbox" class="checkbox" name="c[]" value="{$oObj->getPrimaryKey()}" id="c"/></td>
	<td>{$oObj->getIndex()}</td>
	<td>{$oObj->getName()}</td>
	{*<td><a href="{$oObj->getPictureUrl()}" target="_blank">{$oObj->getPicture()}</a></td>*}
	<td class="center">
		{if !$oObj->haveSub()}
		<input name="sub_{$oObj->getName()}" type="button" value="{loc k=product}" class="btn btn-primary" onclick="redirect('{$oMod->getPage('Product',$sSubUrl)}')"/>
		{/if}
		{if $oObj->canHaveSub()}
		<input name="sub_{$oObj->getName()}" type="button" value="{loc k=sub_category}" class="btn btn-primary" onclick="redirect('{$oMod->getPage('Category',$sSubUrl)}')"/>
		{/if}
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
{if $aCategory|@count > 0}
<tr>
	<td colspan="5">
	<input type="submit" value="{loc k=delete_checked}" name="deleteChecked" class="btn" onclick="return confirm('{loc k=confirm_delete_checked}?');"/>
	</td>
</tr>
{/if}
</table>
{include file="core/page_list.tpl" oPager=$_pager}
</form>