<form action="{$oMod->getPage($oMod->getModule())}" method="POST" class="form-horizontal" enctype="multipart/form-data">
<div class="form-unit">
 <fieldset>
 <legend>{loc k=form} {$oMod->getName()}
 	{if $sMainHelp != ''}
		<a href="#" data-toggle="tooltip" title="" data-original-title="{$sMainHelp}" class="help"><i class="icon-question-sign"></i></a>
	{/if}
 	</legend>
   {foreach from=$aKey key=sKey item=sName}
   <div class="control-group">
	<label class="control-label" for="{$sKey}">
     		{if is_array($sName)}{$sName.name}{else}{$sName}{/if}
     		
     		{if is_array($sName) && $sName.help != ''}
			<a href="#" data-toggle="tooltip" title="" data-original-title="{$sName.help}" class="help"><i class="icon-question-sign"></i></a>
			{/if}
	</label>
	     <div class="controls">
	     	<div>
				{if is_array($sName) && $sName.type == 'toogle'}
					<select name="{$sKey}" id="{$sKey}">
						<option {if $oMod->getConfigurationValue($sKey) == '1'}selected=""{/if} value="1">Yes</option>
						<option {if $oMod->getConfigurationValue($sKey) != '1'}selected=""{/if} value="0">No</option>
					</select>
				{elseif is_array($sName) && $sName.type != 'input'}
					{if $sName.type == 'textarea'}
						<textarea rows="3" class="span12" name="{$sKey}" id="{$sKey}" {if $sName.style != ''}style="{$sName.style}"{/if}>{$oMod->getConfigurationValue($sKey)}</textarea>
					{else if $sName.type == 'picture'}
						<input type="file" class="" name="{$sKey}" id="{$sKey}"/>
						<span class="help-inline" style="margin-left: 50px"><a href="/contents/{$sDomain}/images/{$oMod->getConfigurationValue($sKey)}" target="_blank">{$oMod->getConfigurationValue($sKey)}</a></span>
					{/if}
				{else}
					<input type="text" class="span12" name="{$sKey}" id="{$sKey}" value="{$oMod->getConfigurationValue($sKey)}" />
				{/if}
			</div>
	     </div>
	</div>   
	{/foreach}
	<div class="form-actions">
		<input type="submit" name="save" value="{loc k=save}" class="btn btn-primary"/>
   </div>
 </fieldset>
</div>
</form>