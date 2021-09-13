{if $sAjax == 'form'}
	<form id="form" action="{$oMod->getPage($oMod->getModule(),'select='|@cat:$oBanner->getPrimaryKey())}" method="POST" enctype="multipart/form-data">
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
		       <input type="text" name="oBanner-index" value="{$oBanner->getIndex()}" />
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=picture}
		     	<a href="#" data-toggle="tooltip" title="" data-original-title="Make sure size is fitted enough within the area used on this image" class="help"><i class="icon-question-sign"></i></a>
		     </label>
		     <div class="controls">
		       <input type="file" class="" name="picture" id="picture"/>
		       <span class="help-inline" style="margin-left: 50px"><a href="{$oBanner->getPictureUrl()}" target="_blank">{$oBanner->getPicture()}</a></span>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">&nbsp;</label>
		     <div class="controls">
		       <span class="help-inline">
		       	{if $smarty.get.mode == 'sliding'}
			       	Recommended image width size is 1920 pixel.
			    	{else}   	
			       	Recommended Image width size is 940 pixel.
			    	{/if}
		       	</span>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=url}</label>
		     <div class="controls">
		       <input type="text" class="span12" name="oBanner-url" value="{$oBanner->getUrl()}" />
           {*
	       		<input type="hidden" name="oBanner-new_tab" value="0" />
		       <label class="checkbox help-inline" style="padding-left: 25px;">
					<input type="checkbox" name="oBanner-new_tab" value="true" {if $oBanner->getNewTab()}checked="checked"{/if}> {loc k=open_in_new_tab}
				</label>
           *}
		     </div>
		   </div>
			<div class="control-group">
		     <label class="control-label">{loc k=name}</label>
		     <div class="controls">
		       <input type="text" name="oBanner-name" value="{$oBanner->getName()}" class="span12"/>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=description}</label>
		     <div class="controls">
		     	<input type="text" name="oBanner-description" value="{$oBanner->getDescription()}" class="span12"/>
		     </div>
		   </div>
		   <div class="clearfix"></div>
		</div>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="save" value="1"/>
		<input type="submit" value="{loc k=save}" class="btn btn-primary"/>
		{if !$oBanner->isNew()}<input name="delete" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oBanner->getPrimaryKey()}','{val v=$oBanner->getPicture() parsequote=true}')"/>{/if}
		<a href="{$sUri}" class="btn">Close</a>
	</div>
	</form>
{/if}