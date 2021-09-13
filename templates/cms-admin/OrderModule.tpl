{if $bReviewCancel}
	<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="/ckfinder/ckfinder.js"></script>
	<form action="{$oMod->getPage($oMod->getModule())}" method="POST" class="form-horizontal" enctype="multipart/form-data">
	<div class="form-unit">
	 <fieldset>
	 <legend>{loc k=form} Cancel Order Message</legend>
	   <div class="control-group">
		<label class="control-label">Order</label>
		     <div class="controls">
				<div><input type="text" class="span12" value="{$oMod->getName()}" disabled=""/></div>
		     </div>
		</div>   
	   <div class="control-group">
	     <label class="control-label">Cancel Message</label>
	     <div class="controls">
	       {fckeditor
				name=extra
				value={$sDefaultMessage}
			}
	     </div>
	   </div> 
	   <div class="control-group">
	     <label class="control-label">Remarks (Internal only)</label>
	     <div class="controls">
	       <textarea rows="" cols="" name="notes" class="span12">{$oOrderHeader->getNotes()}</textarea>
	     </div>
	   </div>	   
		<div class="form-actions">
			<input type="hidden" name="submitcancel" value="{$oOrderHeader->getId()}"/>
			<input type="submit" name="save" value="Submit Cancel" class="btn btn-danger"/>
	   </div>
	 </fieldset>
	</div>
	</form>

{/if}
{include file="core/add_search.tpl" bHideAdd = true}
<form name="theForm" action="{$oMod->getPage($oMod->getModule())}" method="POST">
<table cellspacing="0" cellpadding="0" border="0" id="listing" class="table table-striped table-bordered dataTable">
<thead>
<tr>
	<th width="20px" class="center"><input type="checkbox" class="checkbox" id="checkAll" onclick="ToggleCheck(document.theForm)"/></th>
	{include file='core/sortable.tpl' title='order_id' field='order_header.ORDER_ID' oSortable=$_sortable}
	{include file='core/sortable.tpl' title='date' field='order_header.DATE' oSortable=$_sortable}
	{include file='core/sortable.tpl' title='name' field='order_header.NAME' oSortable=$_sortable}
	{include file='core/sortable.tpl' title='email' field='order_header.EMAIL' oSortable=$_sortable}
	{if $smarty.get.mode == 'all'}{include file='core/sortable.tpl' title='status' field='order_header.STATUS' oSortable=$_sortable}{/if}
	<th width="180px">{loc k=options}</th>
</tr>
</thead>
{foreach from=$aOrderHeader key=idx item=oObj}
{assign var=sSelectUrl value='select='|cat:$oObj->getPrimaryKey()}
<tr>
	<td class="center"><input type="checkbox" class="checkbox" name="c[]" value="{$oObj->getPrimaryKey()}" id="c"/></td>
	<td>{$oObj->getOrderId()}</td>
	<td>{$oObj->getDate('d F Y')}</td>
	<td>{$oObj->getName()}</td>
	<td>{$oObj->getEmail()}</td>
	{if $smarty.get.mode == 'all'}<td>{$oObj->getStatusView()}</td>{/if}
	<td class="center">
		<a href="{$oMod->getPage($oMod->getModule(),$sSelectUrl)}" role="button" class="btn btn-primary" data-toggle="modal" data-target="#myForm">{loc k=edit}</a>
		<input name="delete_{$oObj->getId()}" type="button" value="{loc k=delete}" class="btn" onclick="doDelete('{$oObj->getPrimaryKey()}','{val v=$oObj->getId() parsequote=true}')"/>
	</td>
</tr>
{foreachelse}
<tr>
	<td colspan="7" class="center">
	{loc k=no_data}
	</td>
</tr>
{/foreach}
{if $aOrderHeader|@count > 0}
<tr>
	<td colspan="7">
	<input type="submit" value="{loc k=delete_checked}" name="deleteChecked" class="btn" onclick="return confirm('{loc k=confirm_delete_checked}?');"/>
	</td>
</tr>
{/if}
</table>
{include file="core/page_list.tpl" oPager=$_pager}
</form>