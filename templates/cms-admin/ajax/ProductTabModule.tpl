{if $sAjax == 'form'}
	<form id="form" action="{$oMod->getPage($oMod->getModule(),'select='|@cat:$oProductTab->getPrimaryKey())}" method="POST" enctype="multipart/form-data">
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
		       <input type="text" name="oProductTab-index" value="{$oProductTab->getIndex()}" />
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=name}</label>
		     <div class="controls">
		       <input type="text" name="oProductTab-name" id="name" value="{$oProductTab->getName()}" />
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=description}</label>
		     <div class="controls">
		     	<input type="hidden" id="fixDescription" value="1"/>
		     	{fckeditor
					name=description
					value=$oProductTab->getDescription()
				}
		     </div>
		   </div>
		   <div class="clearfix"></div>
		</div>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="save" value="1"/>
		<input type="submit" value="{loc k=save}" class="btn btn-primary"/>
		{if !$oProductTab->isNew()}<input name="delete" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oProductTab->getPrimaryKey()}','{val v=$oProductTab->getName() parsequote=true}')"/>{/if}
		<a href="{$sUri}" class="btn">Close</a>
	</div>
	</form>
{/if}