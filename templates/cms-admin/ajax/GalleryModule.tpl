{if $sAjax == 'form'}
<script>
	function redirect2(url)
	{
		document.location=url;
	}
</script>

	<form id="form" action="{$oMod->getPage($oMod->getModule(),'select='|@cat:$oGallery->getPrimaryKey())}" method="POST" enctype="multipart/form-data">
	<div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">{loc k=form} {$oMod->getName()}</h3>
	</div>
	<div class="modal-body">
	{include file="core/feedback.tpl" source=$oMod->getModule()}
		<div class="form-unit form-horizontal">
			<div class="control-group">
		     <label class="control-label">{loc k=index}
		     	<a href="#" data-toggle="tooltip" title="" data-original-title="{loc k=index_desc}" class="help"><i class="icon-question-sign"></i></a>
		     </label>
		     <div class="controls">
		       <input type="text" name="oGallery-index" value="{$oGallery->getIndex()}" class="span12"/>
		     </div>
		   </div>
		   	<!--
	      <div class="control-group">
		     <label class="control-label" for="name"></label>
		     <div class="controls">
		       <b>English</b>
		     </div>
		   	</div>
		   	-->
		   <div class="control-group">
		     <label class="control-label">{loc k=name}</label>
		     <div class="controls">
		       <input type="text" name="name" id="name" value="{$oGallery->getName('en')}" class="span12" onchange="updateValue('name2',this.value);"/>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=description}</label>
		     <div class="controls">
		     	<input type="hidden" id="fixDescription" value="1"/>
		     	{fckeditor name=description	value=$oGallery->getDescription('en')}
		     </div>
		   </div>
		   <!--
		   <div class="control-group">
		     <label class="control-label" for="name"></label>
		     <div class="controls">
		       <b>Chinese</b>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label" for="name">{loc k=name}</label>
		     <div class="controls">
		       <input type="text" name="namecn" id="name" value="{$oGallery->getName('cn')}" class="span12"/>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label" for="description">{loc k=description}</label>
		     <div class="controls">
		     <input type="hidden" id="fixDescriptionCn" value="1"/>
		       {fckeditor
					name=descriptioncn
					value=$oGallery->getDescription('cn')
				}
		     </div>
		   </div>
		   <div class="clearfix"></div>
		   -->
		</div>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="save" value="1"/>
		{assign var=sUrl value='sub='|@cat:$oGallery->getId()}
		{if !$oGallery->isNew()}<input name="redirect" type="button" value="{loc k=picture}" class="btn btn-info pull-left" onclick="redirect2('{$oMod->getBasePage(GalleryPicture,$sUrl)}'); return false;"/>{/if}
		<input type="submit" id="submit_button" value="{loc k=save}" class="btn btn-primary"/>
		{if !$oGallery->isNew()}<input name="delete" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oGallery->getPrimaryKey()}','{val v=$oGallery->getName() parsequote=true}')"/>{/if}
		<a href="{$sUri}" class="btn">Close</a>
	</div>
	</form>
{/if}