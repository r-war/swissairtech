{if $sAjax == 'form'}
	<script type="text/javascript">
	{literal}
	jQuery(document).ready(function () {
		$('#date').simpleDatepicker();
	});
	{/literal}
	</script>
	{assign var=sUrl value='select='|@cat:$oEvent->getPrimaryKey()}
	<form id="form" action="{$oMod->getPage($oMod->getModule(),$sUrl)}" method="POST" enctype="multipart/form-data">
	<div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">{loc k=form} {$oMod->getName()}</h3>
	</div>
	<div class="modal-body">
	{include file="core/feedback.tpl" source=$oMod->getModule()}
		<div class="form-unit form-horizontal">
		  <div class="control-group">
		     <label class="control-label">{loc k=date}</label>
		     <div class="controls">
		       <input type="text" name="oEvent-date" value="{$oEvent->getDate('m/d/Y')}" id="date"/>
		     </div>
		   </div>
		   {if !$oEvent->isNew()}
		    <div class="control-group">
		     <label class="control-label">{loc k=url}</label>
		     <div class="controls">
		     	<div class="input-prepend input-append">
					<span class="add-on">{$oMod->getBaseDomain()}{$oMod->getBasePage('Event',null,true)}/</span><input type="text" id="appendedPrependedInput" class="input-medium" value="{$oEvent->getCode()}" name="oEvent-code" /><span class="add-on">.html</span>
				</div>
		     </div>
		   </div>
		   {/if}   

		   <div class="control-group">
		     <label class="control-label">{loc k=picture}</label>
		     <div class="controls">
		       <input type="file" name="file" />
		       <span class="help-inline" style="margin-left: 50px"><a href="{$oEvent->getPictureUrl()}" target="_blank">{$oEvent->getPicture()}</a></span>
		     </div>
		   </div>
		   
		   <div class="control-group">
		     <label class="control-label" for="name"></label>
		     <div class="controls">
		       <b>English</b>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label" for="name">{loc k=name}</label>
		     <div class="controls">
		       <input type="text" name="name" id="name" value="{$oEvent->getName('en')}" class="span12"/>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label" for="description">{loc k=description}</label>
		     <div class="controls">
		     <input type="hidden" id="fixDescription" value="1"/>
		       {fckeditor
					name=description
					value=$oEvent->getDescription('en')
				}
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label" for="name"></label>
		     <div class="controls">
		       <b>Italian</b>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label" for="name">{loc k=name}</label>
		     <div class="controls">
		       <input type="text" name="namecn" id="name" value="{$oEvent->getName('it')}" class="span12"/>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label" for="description">{loc k=description}</label>
		     <div class="controls">
		     <input type="hidden" id="fixDescriptionCn" value="1"/>
		       {fckeditor
					name=descriptioncn
					value=$oEvent->getDescription('it')
				}
		     </div>
		   </div>
		   <div class="clearfix"></div>
		</div>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="save" value="1"/>
		<input type="submit" value="{loc k=save}" class="btn btn-primary"/>
		<input name="delete" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oEvent->getPrimaryKey()}','{val v=$oEvent->getName() parsequote=true}')"/>
		<a href="{$sUri}" class="btn">Close</a>
	</div>
	</form>
{/if}