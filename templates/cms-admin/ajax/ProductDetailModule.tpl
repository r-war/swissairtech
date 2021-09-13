{if $sAjax == 'form'}
	<form id="form" action="{$oMod->getPage($oMod->getModule(),'select='|@cat:$oProductDetail->getPrimaryKey())}" method="POST" enctype="multipart/form-data">
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
		       <input type="text" name="oProductDetail-index" value="{$oProductDetail->getIndex()}" />
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{$oProduct->getName1()|@default:Options}</label>
		     <div class="controls">
		       <input type="text" name="oProductDetail-name" id="name" value="{$oProductDetail->getName()}" />
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{$oProduct->getName2()|@default:Options}</label>
		     <div class="controls">
		       <input type="text" name="oProductDetail-name2" id="name2" value="{$oProductDetail->getName2()}" />
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=sku}
		    	<a href="#" data-toggle="tooltip" title="" data-original-title="Detail Keeping Unit, unique code for each product" class="help"><i class="icon-question-sign"></i></a> 	
		 	 </label>
		     <div class="controls">
		       <input type="text" name="oProductDetail-sku" id="sku" value="{$oProductDetail->getSku()}" />
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=price}</label>
		     <div class="controls">
		   		<div class="input-prepend input-append">
					<span class="add-on">{$oMod->getCurrency()}</span><input type="text" class="input-medium" name="oProductDetail-price" id="price" value="{$oProductDetail->getPrice()}">
				</div>
		     </div>
		   </div>
   		   <div class="control-group">
		     <label class="control-label">{loc k=stock}</label>
		     <div class="controls">
		   		<div class="input-prepend input-append">
					<input type="text" id="appendedPrependedInput" class="input-small" name="oProductDetail-stock" id="detail" value="{$oProductDetail->getStock()}" style="text-align: right"><span class="add-on">{loc k=units}</span>
				</div>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=netweight}</label>
		     <div class="controls">
		   		<div class="input-prepend input-append">
					<input type="text" id="appendedPrependedInput" class="input-small" name="oProductDetail-netweight" id="detail" value="{$oProductDetail->getNetweight()}" style="text-align: right"><span class="add-on">{loc k=grams}</span>
				</div>
		     </div>
		   </div>
		   <div class="clearfix"></div>
		</div>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="save" value="1"/>
		<input type="submit" value="{loc k=save}" class="btn btn-primary"/>
		{if !$oProductDetail->isNew()}<input name="delete" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oProductDetail->getPrimaryKey()}','{val v=$oProductDetail->getName() parsequote=true}')"/>{/if}
		<a href="{$sUri}" class="btn">Close</a>
	</div>
	</form>
{/if}