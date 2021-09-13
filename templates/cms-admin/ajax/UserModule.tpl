{if $sAjax == 'form'}
	<form id="form" action="{$oMod->getPage($oMod->getModule(),'select='|@cat:$oUser->getPrimaryKey())}" method="POST">
	<div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">{loc k=form} {$oMod->getName()}</h3>
	</div>
	<div class="modal-body">
	{include file="core/feedback.tpl" source=$oMod->getModule()}
		<div class="form-unit form-horizontal">
		   <div class="control-group">
		     <label class="control-label">{loc k=email}</label>
		     <div class="controls">
		       <input type="text" class="" name="oUser-email" id="email" value="{$oUser->getEmail()}" />
		     </div>
		   </div>
		   {if !$oUser->isNew()}
		   <div class="control-group">
		     <label class="control-label">{loc k=password}</label>
		     <div class="controls">
		       <input type="password" class="" name="password" id="password">
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=password_confirm}</label>
		     <div class="controls">
		       <input type="password" class="" name="password_confirm" id="password_confirm">
		     </div>
		   </div>
		   {/if}
		   <div class="control-group">
		     <label class="control-label">{loc k=name}</label>
		     <div class="controls">
		       <input type="text" class="" name="oUser-name" id="name" value="{$oUser->getName()}" />
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=phone}</label>
		     <div class="controls">
		       <input type="text" class="" name="oUser-phone" id="phone" value="{$oUser->getPhone()}" />
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=address}</label>
		     <div class="controls">
		       <textarea rows="" cols="" name="oUser-address" id="address">{$oUser->getAddress()}</textarea>
		     </div>
		   </div>
		    <div class="control-group">
		     <label class="control-label">{loc k=postal}</label>
		     <div class="controls">
		       <input type="text" class="" name="oUser-postal" id="postal" value="{$oUser->getPostal()}" />
		     </div>
		   </div>
		    <div class="control-group">
		     <label class="control-label">{loc k=country}</label>
		     <div class="controls">
		       {assign var=aCountry value=$oMod->getCountrys()}
			      <select name="oUser-country" id="country">
					{foreach from=$aCountry item=sCountry}
						<option value="{$sCountry}" {if $oUser->getCountry() == $sCountry}selected="selected"{/if}>{$sCountry}</option>
					{/foreach}
			      </select>
		     </div>
		   </div>
   			<div class="clearfix"></div>
		</div>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="save" value="1"/>
		<input type="submit" value="{loc k=save}" class="btn btn-primary"/>
		{if !$oUser->isNew()}<input name="delete" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oUser->getPrimaryKey()}','{val v=$oUser->getEmail() parsequote=true}')"/>{/if}
		<a href="{$sUri}" class="btn">Close</a>
	</div>
	</form>
{/if}