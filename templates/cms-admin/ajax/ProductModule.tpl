{if $sAjax == 'form'}
<script>
	function redirect2(url)
	{
		document.location=url;
	}
</script>

	<form id="form" action="{$oMod->getPage($oMod->getModule(),'select='|@cat:$oProduct->getPrimaryKey())}" method="POST" enctype="multipart/form-data">
	<div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">{loc k=form} {$oMod->getName()}</h3>
	</div>
	<div class="modal-body">
	{include file="core/feedback.tpl" source=$oMod->getModule()}
		<div class="form-unit form-horizontal">
		 <div class="control-group">
		     <label class="control-label">{loc k=category}</label>
		     <div class="controls">
		       	{foreach from=$aCategory item=oObj}
		       		<div class="pull-left" style="padding-right: 20px;">
		       		{if $oObj->haveSub()}
		       			<b><i>{$oObj->getName()}</i></b>
		       			<div style="padding-left: 10px;">
		       			{assign var=aSub value=$oObj->getSub()}
		       			{foreach from=$aSub item=oSub}
				       		{if $oSub->haveSub()}
				       			<b><i>{$oSub->getName()}</i></b>
				       			<div style="padding-left: 10px;">
				       			{assign var=aSubSub value=$oSub->getSub()}
				       			{foreach from=$aSubSub item=oSubSub}
									<label class="checkbox">
										<input type="checkbox" name="category[]" value="{$oSubSub->getId()}" id="{$oSubSub->getId()}" {if in_array($oSubSub->getId(),$aCategoryArray) || ( $oCategory instanceof Category && $oCategory->getId() == $oSubSub->getId()) }checked="checked"{/if}/> {$oSubSub->getName()}
								    </label>
				       			{/foreach}
				       			</div>
				       		{else}
								<label class="checkbox">
									<input type="checkbox" name="category[]" value="{$oSub->getId()}" id="{$oSub->getId()}" {if in_array($oSub->getId(),$aCategoryArray) || ( $oCategory instanceof Category && $oCategory->getId() == $oSub->getId()) }checked="checked"{/if}/> {$oSub->getName()}
							    </label>
				       		{/if}
		       			{/foreach}
		       			</div>
		       		{else}
						<label class="checkbox">
					      <input type="checkbox" name="category[]" value="{$oObj->getId()}" id="{$oObj->getId()}" {if in_array($oObj->getId(),$aCategoryArray) || ( $oCategory instanceof Category && $oCategory->getId() == $oObj->getId())}checked="checked"{/if}> <b><i>{$oObj->getName()}</i></b>
					    </label>
		       		{/if}
		       		</div>
		       	{/foreach}
		     	<span id="category"></span>
		     </div>
			</div>
			{*
			<div class="control-group">
		     <label class="control-label">Show Product
		     </label>
		     <div class="controls">
		       <select name="oProduct-active">
		       		<option value="1" {if $oProduct->getActive() == 1}selected="selected"{/if}>Show</option>
		       		<option value="0" {if $oProduct->getActive() == 0}selected="selected"{/if}>Hide</option>
		       </select>
		     </div>
		   </div>
		   *}
			<div class="control-group">
		     <label class="control-label">{loc k=index}
		     	<a href="#" data-toggle="tooltip" title="" data-original-title="{loc k=index_desc}" class="help"><i class="icon-question-sign"></i></a>
		     </label>
		     <div class="controls">
		       <input type="text" name="oProduct-index" value="{$oProduct->getIndex()}" class="span12"/>
		     </div>
		   </div>
	      <div class="control-group">
		     <label class="control-label" for="name"></label>
		     <div class="controls">
		       <b>English</b>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=name}</label>
		     <div class="controls">
		       <input type="text" name="name" id="name" value="{$oProduct->getName('en')}" class="span12" onchange="updateValue('name2',this.value);"/>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=description}</label>
		     <div class="controls">
		     	<input type="hidden" id="fixDescription" value="1"/>
		     	{fckeditor
					name=description
					value=$oProduct->getDescription()
				}
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label" for="name"></label>
		     <div class="controls">
		       <b>Chinese</b>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label" for="name">{loc k=name}</label>
		     <div class="controls">
		       <input type="text" name="namecn" id="name" value="{$oProduct->getName('cn')}" class="span12"/>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label" for="description">{loc k=description}</label>
		     <div class="controls">
		     <input type="hidden" id="fixDescriptionCn" value="1"/>
		       {fckeditor
					name=descriptioncn
					value=$oProduct->getDescription('cn')
				}
		     </div>
		   </div>
		   <div class="clearfix"></div>
		</div>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="save" value="1"/>
		{assign var=sUrl value='sub='|@cat:$oProduct->getId()}
		{if !$oProduct->isNew()}<input name="redirect" type="button" value="{loc k=picture}" class="btn btn-info pull-left" onclick="redirect2('{$oMod->getBasePage(ProductPicture,$sUrl)}'); return false;"/>{/if}
		<input type="submit" id="submit_button" value="{loc k=save}" class="btn btn-primary"/>
		{if !$oProduct->isNew()}<input name="delete" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oProduct->getPrimaryKey()}','{val v=$oProduct->getName() parsequote=true}')"/>{/if}
		<a href="{$sUri}" class="btn">Close</a>
	</div>
	</form>
{/if}