{if $sAjax == 'product'}
	{foreach from=$aData item='aProduct'}
	{$aProduct|@json_encode}|{$aProduct.name}
	{/foreach}
{else if $sAjax == 'form'}
	<form id="form" action="{$oMod->getPage($oMod->getModule(),'select='|@cat:$oProductFeatured->getPrimaryKey())}" method="POST">
	<div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">{loc k=form} {$oMod->getName()}</h3>
	</div>
	<div class="modal-body">
	{include file="core/feedback.tpl" source=$oMod->getModule()}
		<div class="form-unit form-horizontal">
		   <div class="control-group">
		     <label class="control-label">{loc k=index}
		     	<a href="#" data-toggle="tooltip" title="" data-original-title="{loc k=index_desc}" class="help"><i class="icon-question-sign"></i></a>
		     </label>
		     <div class="controls">
		       <input type="text" name="oProductFeatured-index" value="{$oProductFeatured->getIndex()}" />
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=name}</label>
		     <div class="controls">
		       <input class="span12" type="text" id="name"  name="name" value="{$oProductFeatured->getName()}" />
		       <input type="hidden" id="productid"  name="productid" value="{$oProductFeatured->getProductId()}" />
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">&nbsp;</label>
		     <div class="controls">
		       <span class="help-inline">
		       	Type some keywords that matches with product name and select the product from product list. 
		       	</span>
		     </div>
		   </div>
		   <div class="clearfix"></div>
		</div>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="save" value="1"/>
		<input type="submit" value="{loc k=save}" class="btn btn-primary"/>
		{if !$oProductFeatured->isNew()}<input name="delete" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oProductFeatured->getPrimaryKey()}','{val v=$oProductFeatured->getName() parsequote=true}')"/>{/if}
		<a href="{$sUri}" class="btn">Close</a>
	</div>
	</form>
	<script type="text/javascript">updateProduct('{$oMod->getCurrentPage()}');</script>
{/if}