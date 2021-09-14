{if $sAjax == 'form'}
	<script type="text/javascript">
	{literal}
	jQuery(document).ready(function () {
		$('#date').simpleDatepicker();
	});
	{/literal}
	</script>
	{assign var=sUrl value='select='|@cat:$oNews->getPrimaryKey()}
	<form id="form" action="{$oMod->getPage($oMod->getModule(),$sUrl)}" method="POST" enctype="multipart/form-data">
	<div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">{loc k=form} {$oMod->getName()}</h3>
	</div>
	<div class="modal-body">
	{include file="core/feedback.tpl" source=$oMod->getModule()}
		<div class="form-unit form-horizontal">
		   {*
		   {if !$oNews->isNew()}
		    <div class="control-group">
		     <label class="control-label">{loc k=url}</label>
		     <div class="controls">
		     	<div class="input-prepend input-append">
					<span class="add-on">{$oMod->getBaseDomain()}{$oMod->getBasePage('News',null,true)}/</span><input type="text" id="appendedPrependedInput" class="input-medium" value="{$oNews->getCode()}" name="oNews-code" />
				</div>
		     </div>
		   </div>
		   {/if}
		   *}
		   
		   {if $smarty.get.mode == 'sliding'}
		   	<div class="control-group">
		     <label class="control-label" for="name">Heading 1</label>
		     <div class="controls">
		       <input type="text" name="oNews-name" id="name" value="{$oNews->getName()}" class="span12"/>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label" for="shortdescription">Sub Heading</label>
		     <div class="controls">
		       <input type="text" name="shortDescription" id="shortdescription" value="{$oNews->getShortDescription()}" class="span12"/>
			</div>
		   </div>	
		   <div class="control-group">
		     <label class="control-label" for="description">description</label>
		     <div class="controls">
		       <input type="text" name="description" id="description" value="{$oNews->getDescription()}" class="span12"/>
		     </div>
		   {else}
		   {if $smarty.get.mode != 'Products'}
		   	<div class="control-group">
		     <label class="control-label">{loc k=date}</label>
		     <div class="controls">
		       <input type="text" name="oNews-date" value="{$oNews->getDate('m/d/Y')}" id="date"/>
		     </div>
		   </div>
		   {/if}
		   <div class="control-group">
		     <label class="control-label">{loc k=picture}</label>
		     <div class="controls">
		       <input type="file" name="file" />
		       <span class="help-inline" style="margin-left: 50px"><a href="{$oNews->getPictureUrl()}" target="_blank">{$oNews->getPicture()}</a></span>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label" for="name">{loc k=name}</label>
		     <div class="controls">
		       <input type="text" name="oNews-name" id="name" value="{$oNews->getName()}" class="span12"/>
		     </div>
		   </div>
			{if $smarty.get.mode != 'Products'}
		   <div class="control-group">
		     <label class="control-label" for="shortdescription">{loc k=shortDescription}</label>
		     <div class="controls">
		     <input type="hidden" id="fixShortDescription" value="1"/>
		       {fckeditor name=shortDescription value=$oNews->getShortDescription()}
		     </div>
		   </div>
		   {/if}	
		   <div class="control-group">
		     <label class="control-label" for="description">{loc k=description}</label>
		     <div class="controls">
		     <input type="hidden" id="fixDescription" value="1"/>
		       {fckeditor name=description value=$oNews->getDescription()}
		     </div>
		   </div>		   
		   {/if}
		   <div class="clearfix"></div>
		</div>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="oNews-type" value="{$smarty.get.mode}">
		<input type="hidden" name="save" value="1"/>
		<input type="submit" value="{loc k=save}" class="btn btn-primary"/>
		<input name="delete" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oNews->getPrimaryKey()}','{val v=$oNews->getName() parsequote=true}')"/>
		<a href="{$sUri}" class="btn">Close</a>
	</div>
	</form>
{/if}