<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>{$aConfig.web_title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<div style="padding:0px;margin:20px 0px 20px 0px;font-family:tahoma;font-size:13px;line-height: 140%;">
	<div align="center">
		<div align="left" style="width: 700px;border-width: 1px;background-color:#FFFFFF;border-color: #BED1BD;border-style: solid;">
		<table cellpadding="20" cellspacing="0" border="0" width="100%">
		<tr>
			<td style="border-width: 0px 0px 1px 0px;border-color: #BED1BD;border-style: solid;background-color: #FFFFFF;">
			<table cellpadding="5" cellspacing="0" border="0" width="100%">
			<tr>
				<td>
					<a href="{$oMod->getBaseDomain()}" target="_blank"><img src="{$oMod->getBaseDomain()}/contents/{$oMod->getBaseDomain(false)}/images/{$aConfig.web_logo}"  style="max-width:650px; max-height:100px" border="0"/></a>
				</td>
		         <td style="vertical-align: baseline; text-align: right;">

	                {if $aConfig.facebook_link}<a href="{$aConfig.facebook_link}" target="_blank"><img src="{$oMod->getBaseDomain()}/templates/www/default/images/icon-facebook_on.png"></a>{/if}
                    {if $aConfig.twitter_link}<a href="{$aConfig.twitter_link}" target="_blank"><img src="{$oMod->getBaseDomain()}/templates/www/default/images/icon-twitter_on.png"></a>{/if}
                    {if $aConfig.youtube_link}<a href="{$aConfig.youtube_link}" target="_blank"><img src="{$oMod->getBaseDomain()}/templates/www/default/images/icon-youtube_on.png"></a>{/if}
                    {if $aConfig.google_link}<a href="{$aConfig.google_link}" target="_blank"><img src="{$oMod->getBaseDomain()}/templates/www/default/images/icon-google_on.png"></a>{/if}
                    {if $aConfig.linkedin_link}<a href="{$aConfig.linkedin_link}" target="_blank"><img src="{$oMod->getBaseDomain()}/templates/www/default/images/icon-linkedin_on.png"></a>{/if}


                    {if $aConfig.pinterest_link}<a href="{$aConfig.pinterest_link}" target="_blank"><img src="{$oMod->getBaseDomain()}/templates/www/default/images/ico-pinterest.png"></a>{/if}
                    {if $aConfig.instagram_link}<a href="{$aConfig.instagram_link}" target="_blank"><img src="{$oMod->getBaseDomain()}/templates/www/default/images/ico-instagram.png"></a>{/if}
                    {if $aConfig.blogger_link}<a href="{$aConfig.blogger_link}" target="_blank"><img src="{$oMod->getBaseDomain()}/templates/www/default/images/icon-blogger.png"></a>{/if}
				</td>
			</tr>
			</table>
			</td>
		</tr>
		<tr>
			<th style="padding:0px;font-size:20px;text-align:left;padding: 10px 30px;border-width: 0px 0px 1px 0px;border-color: #BED1BD;border-style: solid;color:#000; background-color: #E8C30B">
				{$sTitle}
			</th>
		</tr>		<tr>
			<td style="border-width: 0px 0px 1px 0px;border-color: #BED1BD;border-style: solid;">
				Dear {$oOrder->getName()},
				<br/><br/>
				{if $oOrder->getStatus() == 1}
					{if $oOrder->getPoa()}
						{$aConfig.content_success_buy_poa}
					{elseif $oOrder->getPayment() == '2'}
						{$aConfig.content_success_buy_transfer}
					{elseif $oOrder->getPayment() == '1'}
						{$aConfig.content_success_buy_cc}
					{/if}
				{elseif $oOrder->getStatus() == 4}
					{$aConfig.content_delivered_order}
				{elseif $oOrder->getStatus() == 9}
					{if $oOrder->getExtra()}
						{$oOrder->getExtra()}
					{else}
						{$aConfig.content_canceled_order}
					{/if}
				{/if}
				<br/><br/>
				<div style="width:100%;background-color:#6e6e6e;font-size:110%;font-weight:bold;color:#fff;padding:5px;padding-left:8px">This is the details of your order :</div>
				<table width="100%" class="leftalign" style="border-collapse: collapse; border-spacing: 0;margin-bottom: 1em;">
				    <tr>
				        <td style=" border: medium none;padding: 5px 10px;text-align: left;vertical-align: middle;">Name</td>
				        <td style=" border: medium none;padding: 5px 10px;text-align: left;vertical-align: middle;" width="5px">:</td>
				        <td style=" border: medium none;padding: 5px 10px;text-align: left;vertical-align: middle;">{$oOrder->getName()}</td>
				        <td style=" border: medium none;padding: 5px 10px;text-align: left;vertical-align: middle;">Address</td>
				        <td style=" border: medium none;padding: 5px 10px;text-align: left;vertical-align: middle;" width="5px">:</td>
				        <td style=" border: medium none;padding: 5px 10px;text-align: left;vertical-align: middle;">{$oOrder->getAddress()|@nl2br}</td>
				    </tr>
				    <tr>
				        <td style=" border: medium none;padding: 5px 10px;text-align: left;vertical-align: middle;">Email</td>
				        <td style=" border: medium none;padding: 5px 10px;text-align: left;vertical-align: middle;">:</td>
				        <td style=" border: medium none;padding: 5px 10px;text-align: left;vertical-align: middle;">{$oOrder->getEmail()}</td>
				        <td style=" border: medium none;padding: 5px 10px;text-align: left;vertical-align: middle;">City</td>
				        <td style=" border: medium none;padding: 5px 10px;text-align: left;vertical-align: middle;">:</td>
				        <td style=" border: medium none;padding: 5px 10px;text-align: left;vertical-align: middle;">{$oOrder->getCountry()}, {$oOrder->getPostal()}</td>
				    </tr>
				    <tr>
				        <td style=" border: medium none;padding: 5px 10px;text-align: left;vertical-align: middle;">Phone</td>
				        <td style=" border: medium none;padding: 5px 10px;text-align: left;vertical-align: middle;">:</td>
				        <td style=" border: medium none;padding: 5px 10px;text-align: left;vertical-align: middle;">{$oOrder->getPhone()}</td>
				        <td style=" border: medium none;padding: 5px 10px;text-align: left;vertical-align: middle;">Status</td>
				        <td style=" border: medium none;padding: 5px 10px;text-align: left;vertical-align: middle;">:</td>
				        <td style=" border: medium none;padding: 5px 10px;text-align: left;vertical-align: middle;">{$oOrder->getStatusView()}</td>
				    </tr>
			    </table>
				<table width="100%" style="border-collapse: collapse; border-spacing: 0;margin-bottom: 1em;">
				    <tr>
				        <th style="border: none;border-bottom: dashed thin #DEDEDE;text-align: center;padding: 5px 10px;font-size:0.9em;">Product</th>
				        <th style="border: none;border-bottom: dashed thin #DEDEDE;text-align: center;padding: 5px 10px;font-size:0.9em;">Qty</th>
				        <th style="border: none;border-bottom: dashed thin #DEDEDE;text-align: center;padding: 5px 10px;font-size:0.9em;">Price</th>
				        <th style="border: none;border-bottom: dashed thin #DEDEDE;text-align: center;padding: 5px 10px;font-size:0.9em;">Sub Total</th>
				    </tr>
				    {foreach from=$aOrderDetail item=oOrderDetail}
				    <tr style="{cycle values='height: 100px;,height: 100px;background-color: #F7F7F7;'}">
				        <td style=" border: medium none;padding: 5px 10px;text-align: center;vertical-align: middle;">
				        	<p style="font-size: 0.9em; margin: 0; text-align: center;width: 300px;">{$oOrderDetail->getProductName()}</p>
				        </td>
				        <td style=" border: medium none;padding: 5px 10px;text-align: center;vertical-align: middle;">{$oOrderDetail->getQty()}</td>
				        <td style=" border: medium none;padding: 5px 10px;text-align: center;vertical-align: middle;">{$oOrderDetail->getPriceView()}</td>
				        <td style=" border: medium none;padding: 5px 10px;text-align: center;vertical-align: middle;">{$oOrderDetail->getSubTotalView()}</td>
				    </tr>
				    {/foreach}
				    <tr>
				    	<td style="height:2px; padding: 0; border: medium none;padding: 5px 10px;text-align: center;vertical-align: middle;" colspan="5"></td>
					</tr>
					<tr class="subtotal">
				    	<td style="text-align:right;border-top: thin dashed #DEDEDE;padding: 5px 10px;vertical-align: middle;" colspan="3">Sub Total</td>
						<td style="text-align:right;border-top: thin dashed #DEDEDE;padding: 5px 10px;vertical-align: middle;"><strong>{$oOrder->getPriceView()}</strong></td>
					</tr>
					{if $oOrder->getDisc()}
					<tr class="subtotal">
				    	<td style="text-align:right;border-top: thin dashed #DEDEDE;padding: 5px 10px;vertical-align: middle;" colspan="3">Discount</td>
						<td style="text-align:right;border-top: thin dashed #DEDEDE;padding: 5px 10px;vertical-align: middle;"><strong>- {$oOrder->getDiscView()}</strong></td>
					</tr>
					{/if}
					<tr class="subtotal">
				    	<td style="text-align:right;border-top: thin dashed #DEDEDE;padding: 5px 10px;vertical-align: middle;" colspan="3">Shipping Cost</td>
						<td style="text-align:right;border-top: thin dashed #DEDEDE;padding: 5px 10px;vertical-align: middle;"><strong>{$oOrder->getShippingCostView()}</strong></td>
					</tr> 
					<tr class="subtotal">
				    	<td style="text-align:right;border-top: thin dashed #DEDEDE;padding: 5px 10px;vertical-align: middle;" colspan="3"><b>Grand Total</b></td>
						<td style="text-align:right;border-top: thin dashed #DEDEDE;padding: 5px 10px;vertical-align: middle;"><strong>{$oOrder->getTotalView()}</strong></td>
					</tr>                    
				</table>
				Thank you, <br/>
 				{$aConfig.web_title}
			</td>
		</tr>
		<tr>
			<td>
			<table cellpadding="5" cellspacing="0" border="0" width="100%">
			<tr>
				<td align="right">
					{$aConfig.copyright|@nl2br}
				</td>
			</tr>
			</table>
			</td>
		</tr>
		</table>
		</div>
	</div>
</div>
</body>
</html>