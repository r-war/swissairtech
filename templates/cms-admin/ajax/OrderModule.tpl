{if $sAjax == 'form'}
	{assign var=sUrl value='select='|@cat:$oOrderHeader->getPrimaryKey()}
	<form id="form" action="{$oMod->getPage($oMod->getModule(),$sUrl)}" method="POST" enctype="multipart/form-data">
	<div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">{loc k=form} {$oMod->getName()}</h3>
	</div>
	<div class="modal-body">
	{include file="core/feedback.tpl" source=$oMod->getModule()}
		<div class="form-unit form-horizontal">
		  <div class="control-group">
		     <label class="control-label">{loc k=status}</label>
		     <div class="controls">
		       <input type="text" class="uneditable-input" value="{$oOrderHeader->getStatusView()}">
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=date}</label>
		     <div class="controls">
		       <input type="text" class="uneditable-input" value="{$oOrderHeader->getDate('d F Y H:i:s')}">
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=payment}</label>
		     <div class="controls">
		       <input type="text" class="uneditable-input" value="{$oOrderHeader->getPaymentViewNumeric()}">
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=name}</label>
		     <div class="controls">
		       <input type="text" class="uneditable-input" value="{$oOrderHeader->getName()}">
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=email}</label>
		     <div class="controls">
		       <input type="text" class="uneditable-input" value="{$oOrderHeader->getEmail()}">
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=phone}</label>
		     <div class="controls">
		       <input type="text" class="uneditable-input" value="{$oOrderHeader->getPhone()}">
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=address}</label>
		     <div class="controls">
		       <textarea rows="" cols="" >{$oOrderHeader->getAddress()}</textarea>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=city}</label>
		     <div class="controls">
		       <input type="text" class="uneditable-input" value="{$oOrderHeader->getCountry()}">
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=postal}</label>
		     <div class="controls">
		       <input type="text" class="uneditable-input" value="{$oOrderHeader->getPostal()}">
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">Remarks</label>
		     <div class="controls">
		       <textarea rows="" cols="" name="notes">{$oOrderHeader->getNotes()}</textarea>
		     </div>
		   </div>
		   <div class="control-group">
				{assign var=aShoppingCart value=$oOrderHeader->getOrderDetails()}
				{if $aShoppingCart|@count > 0}
				<table cellspacing="0" cellpadding="0" border="0" id="listing" class="table table-striped table-bordered dataTable">
				    <tr>
				        <th>Product</th>
				        <th>Qty</th>
				        <th>Price</th>
				        <th>Sub Total</th>
				    </tr>
				    {foreach from=$aShoppingCart item=oOrderDetail}
				    <tr class="{cycle values='odd,even'}">
				        <td class="cart-prod">
				        	<p>{$oOrderDetail->getProductName()}</p>
				        </td>
				        <td>{$oOrderDetail->getQty()}</td>
				        <td>{$oOrderDetail->getPriceView()}</td>
				        <td>{$oOrderDetail->getSubTotalView()}</td>
				    </tr>
				    {/foreach}
				    <tr>
				    	<td style="height:2px; padding: 0;" colspan="5"></td>
					</tr>
					<tr class="subtotal">
				    	<td style="text-align:right;" colspan="3">
				    		{*[Base Price = {$oOrderHeader->getBeforeGstView()} + GST 7% = {$oOrderHeader->getGstView()}]*}
				    		Sub Total</td>
						<td style="text-align:right;"><strong>{$oOrderHeader->getPriceView()}</strong></td>
					</tr>
					{if $oOrderHeader->getDisc()}
					<tr class="subtotal">
				    	<td style="text-align:right;" colspan="3">
				    	{assign var=oPromoCoupon value=$oOrderHeader->getPromoCoupon()}
				    	{if $oPromoCoupon instanceof PromoCoupon} [COUPON : {$oPromoCoupon->getCode()}]{/if}
				    			Discount</td>
						<td style="text-align:right;"><strong>- {$oOrderHeader->getDiscView()}</strong></td>
					</tr>
					{/if}
					<tr class="subtotal">
				    	<td style="text-align:right;" colspan="3">Shipping Cost</td>
						<td style="text-align:right;"><strong>{$oOrderHeader->getShippingCostView()}</strong></td>
					</tr> 
					<tr class="subtotal">
				    	<td style="text-align:right;" colspan="3"><b>Grand Total</b></td>
						<td style="text-align:right;"><strong>{$oOrderHeader->getTotalView()}</strong></td>
					</tr>                    
				</table>
				{/if}
		   </div>
		   <div class="clearfix"></div>
		</div>
	</div>
	<div class="modal-footer">
   		{if $oOrderHeader->getStatus() == 1}
   			<input type="hidden" name="approve" value="1"/>
			<input type="submit" value="{loc k=paid}" class="btn btn-primary"/>
		{elseif $oOrderHeader->getStatus() == 2}
			<input type="hidden" name="process" value="1"/>
			<input type="submit" value="{loc k=processed}" class="btn btn-primary"/>
		{elseif $oOrderHeader->getStatus() == 3}
			<input type="hidden" name="deliver" value="1"/>
			<input type="submit" value="{loc k=delivered}" class="btn btn-primary"/>
		{/if}
		{if $oOrderHeader->getStatus() < 9}
			{assign var=sCancelUrl value='cancel='|@cat:{$oOrderHeader->getId()}}
			<input type="button" value="{loc k=cancel} Order" class="btn btn-primary" onclick="redirect('{$oMod->getPage(Order,$sCancelUrl)}'); return false;"/>
		{/if}
     	{if !$oOrderHeader->isNew()}<input name="delete" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oOrderHeader->getPrimaryKey()}','{val v=$oOrderHeader->getId() parsequote=true}')"/>{/if}
     	<input name="print" type="button" value="{loc k=print}" class="btn" onclick="window.open('{$oMod->getBasePage('Print')}?id={$oOrderHeader->getId()}')"/>
		<a href="{$sUri}" class="btn">Close</a>
	</div>
	</form>
{/if}