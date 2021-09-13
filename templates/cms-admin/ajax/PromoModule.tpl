{if $sAjax == 'product'}
	{foreach from=$aData item='aProduct'}
	{$aProduct|@json_encode}|{$aProduct.name}
	{/foreach}
{else if $sAjax == 'form'}
	<script type="text/javascript">
	{literal}
	jQuery(document).ready(function () {
		$('#start_date').simpleDatepicker();
		$('#end_date').simpleDatepicker();
	});
	{/literal}
	</script>
	{assign var=sUrl value='select='|@cat:$oPromo->getPrimaryKey()}
	{if ( $oPromoAttribute instanceof PromoProduct || $oPromoAttribute instanceof PromoCoupon) && !$oPromoAttribute->isNew()}
		{assign var=sUrl value=$sUrl|@cat:'&selectattr='|@cat:$oPromoAttribute->getPrimaryKey()}
	{/if}
	<form id="form" action="{$oMod->getPage($oMod->getModule(),$sUrl)}" method="POST" enctype="multipart/form-data">
	<div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">{loc k=form} {$oMod->getName()}</h3>
	</div>
	<div class="modal-body">
	{include file="core/feedback.tpl" source=$oMod->getModule()}
		<div class="form-unit form-horizontal">
		   {if $bAttr}
		  	{if $oPromo->getDiscType() == 1}
			   <div class="control-group">
			     <label class="control-label">{loc k=name}</label>
			     <div class="controls">
			       <input class="span12" type="text" id="name" name="name" value="{$oPromoAttribute->getName()}" />
			       <input type="hidden" id="productid"  name="productid" value="{$oPromoAttribute->getProductId()}" />
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
			    <script type="text/javascript">updateProduct('{$oMod->getCurrentPage()}');</script>
		  	{elseif $oPromo->getDiscType() == 2}
			   <div class="control-group">
			     <label class="control-label">{loc k=code}</label>
			     <div class="controls">
			       <input type="text" name="oPromoAttribute-code" value="{$oPromoAttribute->getCode()}" />
			       <input type="hidden" name="oPromoAttribute-unlimited" value="0" />
			       <label class="checkbox help-inline" style="padding-left: 25px;">
						<input {if $oPromoAttribute->getUnlimited()}checked="checked"{/if} type="checkbox" name="oPromoAttribute-unlimited" value="1" style="vertical-align: baseline;"/>&nbsp;{loc k=unlimited_desc}
					</label>
			     </div>
			   </div>
			{/if}
		  {else}
		   <div class="control-group">
		     <label class="control-label">{loc k=start_date}</label>
		     <div class="controls">
		       <input type="text" name="oPromo-start_date" value="{$oPromo->getStartDate('m/d/Y')}" id="start_date"/>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=end_date}</label>
		     <div class="controls">
		       <input type="text" name="oPromo-end_date" value="{$oPromo->getEndDate('m/d/Y')}" id="end_date"/>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=name}</label>
		     <div class="controls">
		       <input type="text" name="oPromo-name" value="{$oPromo->getName()}" id="name"/>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=description}</label>
		     <div class="controls">
		     	<textarea rows="3" name="description" id="description">{$oPromo->getDescription()}</textarea>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=disc_type}</label>
		     <div class="controls">
		       <select name="oPromo-disc_type" onchange="showMin();" id="disc_type">
					<option value="1" {if $oPromo->getDiscType() == 1} selected="selected" {/if}>{loc k=promo_product}</option>
					<option value="2" {if $oPromo->getDiscType() == 2} selected="selected" {/if}>{loc k=promo_coupon}</option>
		       </select>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=disc_amount}</label>
		     <div class="controls">
		   		<div class="input-prepend input-append">
					<span class="add-on" id="fixed">{$oMod->getCurrency()}</span><input type="text" id="disc_amount" class="input-small" name="oPromo-disc_amount" value="{$oPromo->getDiscAmount()}"><span class="add-on" id="percent" style="display: none;">%</span>
				</div>
					<label class="checkbox help-inline" style="padding-left: 25px;">
						<input {if $oPromo->getPercent()}checked="checked"{/if} onchange="showDisc();" type="checkbox" name="oPromo-percent" value="1" id="is_percent"/> {loc k=is_percent}
					</label>
		     </div>
		   </div>
		   <div class="control-group" style="display:none;" id="idMin">
		     <label class="control-label">{loc k=min_amount}</label>
		     <div class="controls">
		   		<div class="input-prepend input-append">
					<span class="add-on">{$oMod->getCurrency()}</span><input type="text" id="appendedPrependedInput" class="input-small" name="oPromo-min_amount" value="{$oPromo->getMinAmount()}">
				</div>
		     </div>
		   </div>
		   {/if}
		   <div class="clearfix"></div>
		</div>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="save" value="1"/>
		<input type="submit" value="{loc k=save}" class="btn btn-primary"/>
		{if $bAttr}
			{if $oPromo->getDiscType() == 1}
				<input type="button" value="{loc k=add_all_products}" class="btn btn-primary" onclick="redirect('{$oMod->getPage($oMod->getModule(),'saveall=1')}')"/>
			{/if}
	     	{if !$oPromoAttribute->isNew()}<input name="delete" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDeleteAttr('{$oPromoAttribute->getPrimaryKey()}','{val v=$oPromoAttribute->getName() parsequote=true}')"/>{/if}
		{else}
			{if !$oPromo->isNew()}<input name="delete" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oPromo->getPrimaryKey()}','{val v=$oPromo->getName() parsequote=true}')"/>{/if}
		{/if}
		<a href="{$sUri}" class="btn">Close</a>
	</div>
	</form>
	<script>showDisc();showMin();</script>
{/if}