{if $sAjax == 'form'}
<form id="form" action="{$oMod->getPage($oMod->getModule(),'select='|@cat:$oTestimonial->getPrimaryKey())}" method="POST">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">{loc k=form} {$oMod->getName()}</h3>
	</div>
	<div class="modal-body">
		{include file="core/feedback.tpl" source=$oMod->getModule()}
		<div class="form-unit form-horizontal">
		  <div class="control-group">
		    <label class="control-label">{loc k=picture}</label>
		    <div class="controls">
		      <input type="file" name="file" />
		      <span class="help-inline" style="margin-left: 50px"><a href="{$oTestimonial->getPictureUrl()}" target="_blank">{$oTestimonial->getPicture()}</a></span>
		    </div>
		  </div>
			<div class="control-group">
				<label class="control-label" for="name">Author</label>
				<div class="controls">
					<input type="text" class="input-block-level" name="oTestimonial-name" id="name" value="{$oTestimonial->getName()}" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="name">Description</label>
				<div class="controls">
					<textarea name="oTestimonial-description" class="input-block-level">{$oTestimonial->getDescription()}</textarea>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">{loc k=active}</label>
				<div class="controls">
					<select name="oTestimonial-active" id="active">
						<option value="1" {if $oTestimonial->getActive() == true} selected="selected" {/if}>{loc k=yes}</option>
						<option value="0" {if $oTestimonial->getActive() == false} selected="selected" {/if}>{loc k=no}</option>
					</select>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="save" value="1"/>


		<input type="submit" name="save" value="{loc k=save}" class="btn btn-primary"/>


     	{if !$oTestimonial->isNew()}<input name="delete" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oTestimonial->getPrimaryKey()}','{val v=$oTestimonial->getName() parsequote=true}')"/>{/if}


     	<a href="{$sUri}" class="btn">Close</a>
	</div>
</form>
{/if}