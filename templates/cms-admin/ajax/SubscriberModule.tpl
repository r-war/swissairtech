{if $sAjax == 'form'}
	<form id="form" action="{$oMod->getPage($oMod->getModule(),'select='|@cat:$oSubscriber->getPrimaryKey())}" method="POST">
	<div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3 id="myModalLabel">{loc k=form} {$oMod->getName()}</h3>
	</div>
	<div class="modal-body">
	{include file="core/feedback.tpl" source=$oMod->getModule()}
		<div class="form-unit form-horizontal">
		   <div class="control-group">
		     <label class="control-label">{loc k=name}</label>
		     <div class="controls">
		       <input type="text" name="oSubscriber-name" id="name" value="{$oSubscriber->getName()}" class=""/>
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">{loc k=email}</label>
		     <div class="controls">
		       <input type="text" name="oSubscriber-email" id="email" value="{$oSubscriber->getEmail()}" class=""/>
		     </div>
		   </div>
			<div class="control-group">
		     <label class="control-label">{loc k=active}</label>
		     <div class="controls">
		       <select name="oSubscriber-active" id="active">
					<option value="1" {if $oSubscriber->getActive() == true} selected="selected" {/if}>{loc k=yes}</option>
					<option value="0" {if $oSubscriber->getActive() == false} selected="selected" {/if}>{loc k=no}</option>
		       </select>
		     </div>
		   </div>
		   <div class="clearfix"></div>
		</div>
	</div>
	<div class="modal-footer">
		<input type="hidden" name="save" value="1"/>
		<input type="submit" value="{loc k=save}" class="btn btn-primary"/>
		{if !$oSubscriber->isNew()}<input name="delete" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oSubscriber->getPrimaryKey()}','{val v=$oSubscriber->getName() parsequote=true}')"/>{/if}
		<a href="{$sUri}" class="btn">Close</a>
	</div>
	</form>
{/if}