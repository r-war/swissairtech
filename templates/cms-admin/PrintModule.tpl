<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>{$oMod->getConfigurationValue('web_title')} - {$oMod->getMetaData('title')}</title>
		<meta name="keywords" content="{$oMod->getMetaData('keywords')}">
		<meta name="description" content="{$oMod->getMetaData('description')}">
		<meta name="author" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="/favicon.png"/>
		<link rel="stylesheet" type="text/css" href="{#CSS_PATH#}bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="{#CSS_PATH#}bootstrap-responsive.min.css">
		<link rel="stylesheet" type="text/css" href="{#CSS_PATH#}datepicker.css">
		<link rel="stylesheet" type="text/css" href="{#CSS_PATH#}style.css">
		<script type="text/javascript" src="{#JS_PATH#}jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="{#JS_PATH#}bootstrap.min.js"></script>
		<script type="text/javascript" src="{#JS_PATH#}bootstrap-datepicker.js"></script>
		<script type="text/javascript" src="{#JS_PATH#}script.js"></script>
		<link rel="shortcut icon" href="{#CSS_PATH#}icon.jpg" type="image/x-icon" />

		<script type="text/javascript" src="{#JS_PATH#}checkAll.js"></script>
		<script type="text/javascript">
		{literal}
			function doDelete(id,name)
			{
			{/literal}
				if(confirm("{loc k=confirm_delete} \'" + name + "\'?"))
			{literal}
				{
			{/literal}		
					redirect('{$oMod->getPage($oMod->getModule())}&delete=' + id);
			{literal}
				}
			}
		{/literal}
		</script>
	</head>
	<body style="padding: 10px;">

{if $oOrderHeader instanceof OrderHeader}
<div class="form-unit">
<form action="{$oMod->getPage($oMod->getModule())}&select={$oOrderHeader->getPrimaryKey()}" method="POST" class="form-horizontal">
 <fieldset>
 <legend>{$oOrderHeader->getOrderId()}</legend>
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
		        	<img src="{$oOrderDetail->getThumbnailUrl(100)}" /><br />
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
		    	<td style="text-align:right;" colspan="3">Sub Total</td>
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
 </fieldset>
</form>
</div>
{/if}
<script>window.print();</script>
  </body>
</html>