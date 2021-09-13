{if $sAjax == 'form'}
	<form id="form" action="{$oMod->getPage($oMod->getModule(),'select='|@cat:$oAdmin->getPrimaryKey())}" method="POST">
	<div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">{loc k=form} {$oMod->getName()}</h3>
	</div>
	<div class="modal-body">
	{include file="core/feedback.tpl" source=$oMod->getModule()}
		<div class="form-unit form-horizontal">
		   <div class="control-group">
		     <label class="control-label">{loc k=admin_type}</label>
		     <div class="controls">
		     	<select name="oAdmin-type_id">
		     		{foreach from=$aAdminType item=oAdminType}
		     			<option value="{$oAdminType->getPrimaryKey()}" {if $oAdmin->getTypeId() == $oAdminType->getPrimaryKey()}selected="selected"{/if}>{$oAdminType->getName()}</option>
		     		{/foreach}
		     	</select>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label" for="username">{loc k=username}</label>
		     <div class="controls">
		       <input type="text" class="" name="oAdmin-username" id="username" value="{$oAdmin->getUsername()}" />
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label" for="password">{loc k=password}</label>
		     <div class="controls">
		       <input type="password" class="" name="password" id="password">
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label" for="password_confirm">{loc k=password_confirm}</label>
		     <div class="controls">
		       <input type="password" class="" name="password_confirm" id="password_confirm">
		     </div>
		   </div>
{*
		   <div class="control-group">
		     <br/>
		     Please fill below data for user account with access to Internal Order
		   </div>
		   <div class="control-group">
		     <label class="control-label">Retail {loc k=name}</label>
		     <div class="controls">
		       <input type="text" class="" name="oAdmin-name" id="name" value="{$oAdmin->getName()}" />
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=email}</label>
		     <div class="controls">
		       <input type="text" class="" name="oAdmin-email" id="email" value="{$oAdmin->getEmail()}" />
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=phone}</label>
		     <div class="controls">
		       <input type="text" class="" name="oAdmin-phone" id="phone" value="{$oAdmin->getPhone()}" />
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=address}</label>
		     <div class="controls">
		       <textarea rows="" cols="" name="oAdmin-address" id="address">{$oAdmin->getAddress()}</textarea>
		     </div>
		   </div>
*}
   			<div class="clearfix"></div>
		</div>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="save" value="1"/>
		<input type="submit" value="{loc k=save}" class="btn btn-primary"/>
		{if !$oAdmin->isNew()}<input name="delete" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oAdmin->getPrimaryKey()}','{val v=$oAdmin->getUsername() parsequote=true}')"/>{/if}
		<a href="{$sUri}" class="btn">Close</a><br />
	</div>
	</form>
{/if}
