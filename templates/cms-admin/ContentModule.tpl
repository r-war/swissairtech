<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/ckfinder/ckfinder.js"></script>
<div class="form-unit">
<form action="{$oMod->getPage($oMod->getModule())}?&key={$sSelectKey}" method="POST" class="form-horizontal">
 <fieldset>
 <legend>{loc k=form} {$oMod->getName()}</legend>
   <div class="control-group">
     <label class="control-label">{loc k=name}</label>
     <div class="controls">
		<select onchange="redirect(this.value);" class="span12">
			{foreach from=$aKey key=sKey item=sName}
				<option {if $sKey == $smarty.get.key}selected="selected"{/if} value="{$oMod->getPage($oMod->getModule())}?&key={$sKey}">{$sName}</option>
			{/foreach}
		</select>
     </div>
   </div>
   <div class="control-group">
     <label class="control-label">{loc k=description}</label>
     <div class="controls">
       {fckeditor
			name=description
			value=$oConfiguration->getValue()
		}
     </div>
   </div>
   <div class="form-actions">
		<input type="submit" name="save" value="{loc k=save}" class="btn btn-primary"/>
     	<input name="cancel" type="button" value="{loc k=cancel}" class="btn" onclick="redirect('{$oMod->getPage($oMod->getModule())}')"/>
   </div>
 </fieldset>
</form>
</div>