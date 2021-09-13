<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/ckfinder/ckfinder.js"></script>
<script src="{#JS_PATH#}jquery.autocomplete.js" type="text/javascript"></script>
<script type="text/javascript">
{literal}
function showDisc() {

	$('#fixed').hide();
	$('#percent').hide();

	if($('#is_percent').is(':checked'))
		$('#percent').show();
	else
		$('#fixed').show();
}

function showMin() {
	if($('#disc_type').val() == 1)
		$('#idMin').hide();
	else
		$('#idMin').show();
		
}

{/literal}
</script>
{include file="core/add_search.tpl"}
{if $smarty.get.attr == 1}
<div class="row-fluid">
	<ul class="breadcrumb">
	    <li>
	    <a href="{$oMod->getBasePage('Promo')}">{loc k=promo}</a> <span class="divider">/</span>
	    </li>
	    {if $oPromo instanceof Promo}
		    {if $smarty.get.attr == 1 && isset($smarty.get.selectattr) && !$oPromoAttribute->isNew()}
		    {assign var=sSubParentUrl value='select='|cat:$oPromo->getPrimaryKey()|cat:'&attr=1'}
		    <li>
		    <a href="{$oMod->getBasePage('Promo',$sSubParentUrl)}">{$oPromo->getName()}</a> <span class="divider">/</span>
		    </li>
		    <li class="active">{$oPromoAttribute->getName()}</li>
		    {else}
		    <li class="active">{$oPromo->getName()}</li>
		    {/if}
		{/if}
    </ul>
</div>
{/if}
<form name="theForm" action="{$oMod->getPage($oMod->getModule())}" method="POST">
{if !$bAttr}
<table cellspacing="0" cellpadding="0" border="0" id="listing" class="table table-striped table-bordered dataTable">
<thead>
<tr>
	<th width="20px" class="center"><input type="checkbox" class="checkbox" id="checkAll" onclick="ToggleCheck(document.theForm)"/></th>
	{include file='core/sortable.tpl' title='start_date' field='promo.START_DATE' oSortable=$_sortable}
	{include file='core/sortable.tpl' title='end_date' field='promo.END_DATE' oSortable=$_sortable}
	{include file='core/sortable.tpl' title='name' field='promo.NAME' oSortable=$_sortable}
	{include file='core/sortable.tpl' title='type' field='promo.DISC_TYPE' oSortable=$_sortable}
	<th width="220px">{loc k=options}</th>
</tr>
</thead>
{foreach from=$aPromo key=idx item=oObj}
{assign var=sSelectUrl value='select='|cat:$oObj->getPrimaryKey()}
{assign var=sAttributesUrl value=$sSelectUrl|cat:'&attr=1'}
<tr class="{if $oObj->getPrimaryKey() == $oPromo->getPrimaryKey()}highlight{/if}">
	<td class="center"><input type="checkbox" class="checkbox" name="c[]" value="{$oObj->getPrimaryKey()}" id="c"/></td>
	<td>{$oObj->getStartDate('d M Y')}</td>
	<td>{$oObj->getEndDate('d M Y')}</td>
	<td>{$oObj->getName()}</td>
	<td>{$oObj->getDiscTypeView()}</td>
	<td class="center">
		<input name="attributes_{$oObj->getName()}" type="button" value="{if $oObj->getDiscType() == 1}{loc k=product}{elseif $oObj->getDiscType() == 2}{loc k=coupon}{/if}" class="btn btn-primary" onclick="redirect('{$oMod->getPage($oMod->getModule(),$sAttributesUrl)}')"/>
		<a href="{$oMod->getPage($oMod->getModule(),$sSelectUrl)}" role="button" class="btn btn-primary" data-toggle="modal" data-target="#myForm">{loc k=edit}</a>
		<input name="delete_{$oObj->getName()}" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oObj->getPrimaryKey()}','{val v=$oObj->getName() parsequote=true}')"/>
	</td>
</tr>
{foreachelse}
<tr>
	<td colspan="9" class="center">
	{loc k=no_data}
	</td>
</tr>
{/foreach}
{if $aPromo|@count > 0}
<tr>
	<td colspan="9">
	<input type="submit" value="{loc k=delete_checked}" name="deleteChecked" class="btn" onclick="return confirm('{loc k=confirm_delete_checked}?');"/>
	</td>
</tr>
{/if}
</table>
{else}
<table cellspacing="0" cellpadding="0" border="0" id="listing" class="table table-striped table-bordered dataTable">
<thead>
<tr>
	<th width="20px" class="center"><input type="checkbox" class="checkbox" id="checkAll" onclick="ToggleCheck(document.theForm)"/></th>
  	{if $oPromo->getDiscType() == 1}
		{include file='core/sortable.tpl' title='name' field='product.NAME' oSortable=$_sortable}
	{elseif $oPromo->getDiscType() == 2}
		{include file='core/sortable.tpl' title='code' field='promo_coupon.CODE' oSortable=$_sortable}
		{include file='core/sortable.tpl' title='unlimited' field='promo_coupon.UNLIMITED' oSortable=$_sortable}
		{include file='core/sortable.tpl' title='used' field='promo_coupon.USED' oSortable=$_sortable}
	{/if}
	<th width="200px">{loc k=options}</th>
</tr>
</thead>
{foreach from=$aPromoAttribute key=idx item=oObj}
{assign var=sSelectUrl value='selectattr='|cat:$oObj->getPrimaryKey()}
<tr class="{if $oObj->getPrimaryKey() == $oPromo->getPrimaryKey()}highlight{/if}">
	<td class="center"><input type="checkbox" class="checkbox" name="c[]" value="{$oObj->getPrimaryKey()}" id="c"/></td>
  	{if $oPromo->getDiscType() == 1}
  		<td>{$oObj->getName()}</td>
  	{elseif $oPromo->getDiscType() == 2}
  		<td>{$oObj->getCode()}</td>
  		<td>{$oObj->getUnlimitedView()}</td>
  		<td>{$oObj->getUsed()}</td>
	{/if}	
	<td class="center">
		<a href="{$oMod->getPage($oMod->getModule(),$sSelectUrl)}" role="button" class="btn btn-primary" data-toggle="modal" data-target="#myForm">{loc k=edit}</a>
		<input name="delete_{$oObj->getName()}" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDeleteAttr('{$oObj->getPrimaryKey()}','{val v=$oObj->getName() parsequote=true}')"/>
	</td>
</tr>
{foreachelse}
<tr>
	<td colspan="9" class="center">
	{loc k=no_data}
	</td>
</tr>
{/foreach}
{if $aPromoAttribute|@count > 0}
<tr>
	<td colspan="9">
	<input type="submit" value="{loc k=delete_checked}" name="deleteCheckedAttr" class="btn" onclick="return confirm('{loc k=confirm_delete_checked}?');"/>
	</td>
</tr>
{/if}
</table>
{/if}
{include file="core/page_list.tpl" oPager=$_pager}
</form>
<script>showDisc();showMin();</script>