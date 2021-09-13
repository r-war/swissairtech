{if $sAjax == 'form'}
	<form id="form" action="{$oMod->getPage($oMod->getModule(),'select='|@cat:$oPage->getPrimaryKey())}" method="POST" enctype="multipart/form-data">
	<div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">{loc k=form} {$oMod->getName()}</h3>
	</div>
	<div class="modal-body">
	{include file="core/feedback.tpl" source=$oMod->getModule()}
		<div class="form-unit form-horizontal">
		   {if !$oPage->isNew()}
		    <div class="control-group">
		     <label class="control-label" for="code">{loc k=url}</label>
		     <div class="controls">
		     	<div class="input-prepend input-append">
					<span class="add-on">{$oMod->getBaseDomain()}{$oMod->getBasePage('Page',null,true)}/</span><input type="text" class="input-large" value="{$oPage->getCode()}" name="oPage-code" id="code" /><span class="add-on">.html</span>
				</div>
		     </div>
		   </div>
		   {/if}
		   <div class="control-group">
		     <label class="control-label" for="name">{loc k=name}</label>
		     <div class="controls">
		       <input type="text" name="oPage-name" id="name" value="{$oPage->getName('en')}" class="span12"/>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label" for="description">{loc k=description}</label>
		     <div class="controls">
		     <input type="hidden" id="fixDescription" value="1"/>
		       {fckeditor
					name=description
					value=$oPage->getDescription('en')}
		     </div>
		   </div>
		   {*
		   <div class="control-group">
		     <label class="control-label" for="name"></label>
		     <div class="controls">
		       <b>Japanese</b>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label" for="name">{loc k=name}</label>
		     <div class="controls">
		       <input type="text" name="namecn" id="name" value="{$oPage->getName('jp')}" class="span12"/>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label" for="description">{loc k=description}</label>
		     <div class="controls">
		     <input type="hidden" id="fixDescriptionCn" value="1"/>
		       {fckeditor
					name=descriptioncn
					value=$oPage->getDescription('jp')
				}
		     </div>
		   </div>
		   *}
		   <div class="control-group">
		     <label class="control-label">Picture Banner
		     	<a href="#" data-toggle="tooltip" title="" data-original-title="Make sure size is fitted enough within the area used on this image (970px x 200px)" class="help"><i class="icon-question-sign"></i></a>
		     </label>
		     <div class="controls">
		       <input type="file" class="" name="picture" id="picture"/>
		       <span class="help-inline" style="margin-left: 50px"><a href="{$oPage->getPictureUrl()}" target="_blank">{$oPage->getPicture()}</a></span>
		     </div>
		   </div>
		   <div class="clearfix"></div>
		</div>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="save" value="1"/>
		<input type="submit" value="{loc k=save}" class="btn btn-primary"/>
		{if !$oPage->isNew()}<input name="delete" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oPage->getPrimaryKey()}','{val v=$oPage->getName() parsequote=true}')"/>{/if}
		<a href="{$sUri}" class="btn">Close</a><br />
	</div>
	</form>
{/if}