{include file="core/add_search.tpl" bDownload=true}
<form name="theForm" action="{$oMod->getPage($oMod->getModule())}" method="POST">
<table cellspacing="0" cellpadding="0" border="0" id="listing" class="table table-striped table-bordered dataTable">
<thead>
<tr>
	<th width="20px" class="center"><input type="checkbox" class="checkbox" id="checkAll" onclick="ToggleCheck(document.theForm)"/></th>
	{include file='core/sortable.tpl' title='email' field='user.EMAIL' oSortable=$_sortable}
	{include file='core/sortable.tpl' title='name' field='user.NAME' oSortable=$_sortable}
	{include file='core/sortable.tpl' title='address' field='user.ADDRESS' oSortable=$_sortable}
	<th width="250px">{loc k=options}</th>
</tr>
</thead>
{foreach from=$aUser key=idx item=oObj}
{assign var=sSelectUrl value='select='|cat:$oObj->getPrimaryKey()}
{assign var=sPropertyUrl value='userid='|cat:$oObj->getPrimaryKey()}
<tr>
	<td class="center"><input type="checkbox" class="checkbox" name="c[]" value="{$oObj->getPrimaryKey()}" id="c"/></td>
	<td>{$oObj->getEmail()}</td>
	<td>{$oObj->getName()}</td>
	<td>{$oObj->getAddress()}</td>
	<td class="center">
	    <a href="{$oMod->getBasePage(ProductUser,$sPropertyUrl)}" role="button" class="btn btn-primary" >{loc k=product} {if $oObj->countProperty() > 0}({$oObj->countProperty()}){/if}</a>
		<a href="{$oMod->getPage($oMod->getModule(),$sSelectUrl)}" role="button" class="btn btn-primary" data-toggle="modal" data-target="#myForm">{loc k=edit}</a>
		<input name="delete_{$oObj->getEmail()}" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oObj->getPrimaryKey()}','{val v=$oObj->getEmail() parsequote=true}')"/>
	</td>
</tr>
{foreachelse}
<tr>
	<td colspan="6" class="center">
	{loc k=no_data}
	</td>
</tr>
{/foreach}
{if $aUser|@count > 0}
<tr>
	<td colspan="5">
	<input type="submit" value="{loc k=delete_checked}" name="deleteChecked" class="btn" onclick="return confirm('{loc k=confirm_delete_checked}?');"/>
	</td>
</tr>
{/if}
</table>
{include file="core/page_list.tpl" oPager=$_pager}
</form>