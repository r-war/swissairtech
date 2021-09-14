<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/ckfinder/ckfinder.js"></script>

{include file="core/add_search.tpl"}
{if $smarty.get.back}
<div class="row-fluid">
	<ul class="breadcrumb" style="margin-bottom: 10px;">
	    <li><a href="{$oMod->getBasePage($smarty.get.back)}{if $smarty.get.back == menu}?mode=main{/if}">{loc k=$smarty.get.back}</a> <span class="divider">/</span></li>
	    <li class="active">Banner</li>
    </ul>
</div>
{/if}
<form name="theForm" action="{$oMod->getPage($oMod->getModule())}" method="POST">
<table cellspacing="0" cellpadding="0" border="0" id="listing" class="table table-striped table-bordered dataTable">
<thead>
<tr>
	<th width="20px" class="center"><input type="checkbox" class="checkbox" id="checkAll" onclick="ToggleCheck(document.theForm)"/></th>
	{include file='core/sortable.tpl' title='#' field='banner.INDEX' oSortable=$_sortable}
	{include file='core/sortable.tpl' title='name' field='banner.FILE' oSortable=$_sortable}
	{include file='core/sortable.tpl' title='url' field='banner.URL' oSortable=$_sortable}
	<th width="200px">{loc k=options}</th>
</tr>
</thead>
{foreach from=$aBanner key=idx item=oObj}
{assign var=sSelectUrl value='select='|cat:$oObj->getPrimaryKey()}
{assign var=sSubUrl value='sub='|cat:$oObj->getPrimaryKey()}
<tr>
	<td class="center"><input type="checkbox" class="checkbox" name="c[]" value="{$oObj->getPrimaryKey()}" id="c"/></td>
	<td>{$oObj->getIndex()}</td>
	<td><a href="{$oObj->getPictureUrl()}" target="_blank">{$oObj->getPicture()}</a></td>
	<td>{$oObj->getUrl()}</td>
	<td class="center">
		<a href="{$oMod->getPage($oMod->getModule(),$sSelectUrl)}" role="button" class="btn btn-primary" data-toggle="modal" data-target="#myForm">{loc k=edit}</a>
		<input name="delete_{$oObj->getPicture()}" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oObj->getPrimaryKey()}','{val v=$oObj->getPicture() parsequote=true}')"/>
	</td>
</tr>
{foreachelse}
<tr>
	<td colspan="6" class="center">
	{loc k=no_data}
	</td>
</tr>
{/foreach}
{if $aBanner|@count > 0}
<tr>
	<td colspan="5">
	<input type="submit" value="{loc k=delete_checked}" name="deleteChecked" class="btn" onclick="return confirm('{loc k=confirm_delete_checked}?');"/>
	</td>
</tr>
{/if}
</table>
{include file="core/page_list.tpl" oPager=$_pager}
</form>