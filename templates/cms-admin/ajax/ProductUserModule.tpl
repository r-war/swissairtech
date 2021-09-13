{if $sAjax == 'product' || $sAjax == 'user'}
	{foreach from=$aData item='aProduct'}
	{$aProduct|@json_encode}|{$aProduct.name}
	{/foreach}
{else if $sAjax == 'form'}
	<form id="form" action="{$oMod->getPage($oMod->getModule(),'select='|@cat:$oProductUser->getPrimaryKey())}" method="POST">
	<div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">{loc k=form} {$oMod->getName()}</h3>
	</div>
	<div class="modal-body">
	{include file="core/feedback.tpl" source=$oMod->getModule()}
		<div class="form-unit form-horizontal">
		   <div class="control-group">
		     <label class="control-label">{loc k=user}</label>
		     <div class="controls">
		       <input class="span12" type="text" id="user" name="user" value="{$oProductUser->getUserName()}" />
		       <input type="hidden" id="userid"  name="userid" value="{$oProductUser->getUserId()}" />
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=product}</label>
		     <div class="controls">
		       <input class="span12" type="text" id="name" name="name" value="{$oProductUser->getProductName()}" />
		       <input type="hidden" id="productid"  name="productid" value="{$oProductUser->getProductId()}" />
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">&nbsp;</label>
		     <div class="controls">
		       <span class="help-inline">
		       	Type some keywords that matches with user name and property name and select from list. 
		       	</span>
		     </div>
		   </div>
		   <div class="clearfix"></div>
		</div>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="save" value="1"/>
		<input type="submit" value="{loc k=save}" class="btn btn-primary"/>
		{if !$oProductUser->isNew()}<input name="delete" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oProductUser->getPrimaryKey()}','{val v=$oProductUser->getName() parsequote=true}')"/>{/if}
		<a href="{$sUri}" class="btn">Close</a>
	</div>
	</form>
	<script type="text/javascript">updateProduct('{$oMod->getCurrentPage()}');</script>
	<script type="text/javascript">updateUser('{$oMod->getCurrentPage()}');</script>
{/if}