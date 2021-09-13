{if $sAjax == 'form'}
	<form id="form" action="{$oMod->getPage($oMod->getModule(),'select='|@cat:$oProductPrice->getPrimaryKey())}" method="POST" enctype="multipart/form-data">
	<div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">{loc k=form} {$oMod->getName()}</h3>
	</div>
	<div class="modal-body">
	{include file="core/feedback.tpl" source=$oMod->getModule()}
		<div class="form-unit form-horizontal">
		  <div class="control-group">
		     <label class="control-label">{loc k=min}</label>
		     <div class="controls">
					<input type="text" name="oProductPrice-min" id="stock" value="{$oProductPrice->getMin()}" style="text-align: right">
		     </div>
		   </div>
   		   <div class="control-group">
		     <label class="control-label">{loc k=price}</label>
		     <div class="controls">
		   		<div class="input-prepend input-append">
					<span class="add-on">{$oMod->getCurrency()}</span><input type="text" class="input-medium" name="oProductPrice-price" id="price" value="{$oProductPrice->getPrice()}">
				</div>
		     </div>
		   </div>
		   <div class="clearfix"></div>
		</div>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="save" value="1"/>
		<input type="submit" value="{loc k=save}" class="btn btn-primary"/>
		{if !$oProductPrice->isNew()}<input name="delete" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oProductPrice->getPrimaryKey()}','{val v=$oProductPrice->getMin() parsequote=true}')"/>{/if}
		<a href="{$sUri}" class="btn">Close</a>
	</div>
	</form>
{/if}