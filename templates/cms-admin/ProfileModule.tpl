<div class="form-unit">
<form name="theForm" action="{$oMod->getPage($oMod->getModule())}" method="POST" class="form-horizontal">
 <fieldset>
 <legend>{loc k=form} {$oMod->getName()}</legend>
   <div class="control-group">
     <label class="control-label">{loc k=username}</label>
     <div class="controls">
       <input type="text" class="uneditable-input" value="{$oLoginAdmin->getUsername()}" />
     </div>
   </div>
{*   
   <div class="control-group">
     <label class="control-label">Retail {loc k=name}</label>
     <div class="controls">
       <input type="text" class="uneditable-input" name="name" id="name" value="{$oLoginAdmin->getName()}" />
     </div>
   </div>
   <div class="control-group">
     <label class="control-label">{loc k=email}</label>
     <div class="controls">
       <input type="text" class="uneditable-input" name="email" id="email" value="{$oLoginAdmin->getEmail()}" />
     </div>
   </div>
   <div class="control-group">
     <label class="control-label">{loc k=phone}</label>
     <div class="controls">
       <input type="text" class="uneditable-input" name="phone" id="phone" value="{$oLoginAdmin->getPhone()}" />
     </div>
   </div>
   <div class="control-group">
     <label class="control-label">{loc k=address}</label>
     <div class="controls">
       <textarea rows="" cols="uneditable-input" name="address" id="address">{$oLoginAdmin->getAddress()}</textarea>
     </div>
   </div>
*}
   <div class="control-group">
     <div class="controls">Fill below fields to change your password !</div>
   </div>
   <div class="control-group">
     <label class="control-label">{loc k=password}</label>
     <div class="controls">
       <input type="password" class="" name="password">
     </div>
   </div>
   <div class="control-group">
     <label class="control-label">{loc k=new_password}</label>
     <div class="controls">
       <input type="password" class="" name="new_password">
     </div>
   </div>
   <div class="control-group">
     <label class="control-label">{loc k=password_confirm}</label>
     <div class="controls">
       <input type="password" class="" name="password_confirm">
     </div>
   </div>
   
   
   <div class="form-actions">
		<input type="submit" name="save" value="{loc k=save}" class="btn btn-primary"/>
     	<input name="cancel" type="button" value="{loc k=cancel}" class="btn" onclick="redirect('{$oMod->getPage($oMod->getModule())}')"/>
   </div>
 </fieldset>
</div>
</form>