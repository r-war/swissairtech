{if $sAjax == 'form'}
	<form id="form" action="{$oMod->getPage($oMod->getModule(),'select='|@cat:$oSeo->getPrimaryKey())}" method="POST" enctype="multipart/form-data">
	<div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">{loc k=form} {$oMod->getName()}</h3>
	</div>
	<div class="modal-body">
	{include file="core/feedback.tpl" source=$oMod->getModule()}
		<div class="form-unit form-horizontal">
		    <div class="control-group">
		     <label class="control-label" for="code">URL Matched</label>
		     <div class="controls">
		     	<input type="text" name="oSeo-url" value="{$oSeo->getUrl()}" class="span12" id="url"/>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">Page Title</label>
		     <div class="controls">
				<div><textarea class="span12" name="oSeo-meta_title">{$oSeo->getMetaTitle()}</textarea></div>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">Meta Name Description</label>
		     <div class="controls">
				<div><textarea class="span12" name="oSeo-meta_description">{$oSeo->getMetaDescription()}</textarea></div>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">Meta Name Keywords</label>
		     <div class="controls">
				<div><textarea class="span12" name="oSeo-meta_keywords">{$oSeo->getMetaKeywords()}</textarea></div>
		     </div>
		   </div>
		   <div class="clearfix"></div>
		</div>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="save" value="1"/>
		<input type="submit" value="{loc k=save}" class="btn btn-primary"/>
		{if !$oSeo->isNew()}<input name="delete" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oSeo->getPrimaryKey()}','{val v=$oSeo->getUrl() parsequote=true}')"/>{/if}
		<a href="{$sUri}" class="btn">Close</a><br />
	</div>
	</form>
{/if}