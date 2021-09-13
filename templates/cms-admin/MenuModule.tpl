<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/ckfinder/ckfinder.js"></script>
<script src="{#JS_PATH#}jquery.autocomplete.js" type="text/javascript"></script>
<script>
{literal}
	function showMenuType()
	{
		var type = $('#menuType').val();
		$('#typeUrl').hide();
		$('#typePage').hide();
		$('#typeModule').hide();
		$('#typeCategory').hide();
		$('#typePromo').hide();
		
		if(type == 1) $('#typeUrl').show();
		else if(type == 2) $('#typePage').show();
		else if(type == 3) $('#typeModule').show();
		else if(type == 4) $('#typeCategory').show();
		else if(type == 5) $('#typePromo').show();
	}
	
	function showPageType()
	{
		var type = $('#pageType').val();
		$('#existingPage').hide();
		$('#newPage').hide();
		
		if(type == 1) $('#existingPage').show();
		else if(type == 2){
			$('#newPage').show();
			$('#pageName').val($('#menuName').val());
		} 
	}
{/literal}	
</script>
{include file="core/add_search.tpl"}
{if $oParentMenu instanceof Menu}
<div class="row-fluid">
	<ul class="breadcrumb" style="margin-bottom: 10px;">
    	{assign var=sMode value='mode='|cat:$smarty.get.mode}
	    <li>
	    <a href="{$oMod->getBasePage($oMod->getModule(),$sMode)}">{$oMod->getName()}</a> <span class="divider">/</span>
	    </li>
	    {assign var=oParent value=$oParentMenu->getMenuRelatedByParentId()}
	    {if $oParent instanceof Menu}
	    {assign var=sUrl value=$sMode|cat:'&sub='|cat:$oParent->getId()}
	    <li>
	    <a href="{$oMod->getBasePage($oMod->getModule(),$sUrl)}">{$oParent->getName()}</a> <span class="divider">/</span>
	    </li>
	    {/if}
	    <li class="active">{$oParentMenu->getName()}</li>
    </ul>
</div>
{/if}
<form name="theForm" action="{$oMod->getPage($oMod->getModule())}" method="POST">
<table cellspacing="0" cellpadding="0" border="0" id="listing" class="table table-striped table-bordered dataTable">
<thead>
<tr>
	<th width="20px" class="center"><input type="checkbox" class="checkbox" id="checkAll" onclick="ToggleCheck(document.theForm)"/></th>
	{include file='core/sortable.tpl' title='#' field='menu.INDEX' oSortable=$_sortable}
	{include file='core/sortable.tpl' title='name' field='menu.NAME' oSortable=$_sortable}
	{include file='core/sortable.tpl' title='url' field='menu.URL' oSortable=$_sortable}
	<th width="320px">{loc k=options}</th>
</tr>
</thead>
{foreach from=$aMenu key=idx item=oObj}
{assign var=sSelectUrl value='select='|cat:$oObj->getPrimaryKey()}
{assign var=sSubUrl value='sub='|cat:$oObj->getPrimaryKey()}
{assign var=sBannerUrl value='back=menu&mode='|@cat:$oObj->getUrl($oMod,'www',false)}
<tr>
	<td class="center"><input type="checkbox" class="checkbox" name="c[]" value="{$oObj->getPrimaryKey()}" id="c"/></td>
	<td>{$oObj->getIndex()}</td>
	<td>{$oObj->getName()}</td>
	<td>{$oObj->getUrl($oMod,'www')}</td>
	<td class="center">
		{*if !$oObj->getParentId() && $bMulti && $oObj->getType() != 4}
			<input name="sub_{$oObj->getName()}" type="button" value="Sub Menu ({$oObj->countSub()})" class="btn btn-primary" onclick="redirect('{$oMod->getPage($oMod->getModule(),$sSubUrl)}')"/>
		{/if*}
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
{if $aMenu|@count > 0}
<tr>
	<td colspan="5">
	<input type="submit" value="{loc k=delete_checked}" name="deleteChecked" class="btn" onclick="return confirm('{loc k=confirm_delete_checked}?');"/>
	</td>
</tr>
{/if}
</table>
{include file="core/page_list.tpl" oPager=$_pager}
</form>