{if $sAjax == 'form'}
	<form id="form" action="{$oMod->getPage($oMod->getModule(),'select='|@cat:$oAdminType->getPrimaryKey())}" method="POST">
	  <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">{loc k=form} {$oMod->getName()}</h3>
	  </div>
	  <div class="modal-body">
	  	{include file="core/feedback.tpl" source=$oMod->getModule()}
		<div class="form-unit form-horizontal">
		   <div class="control-group">
		     <label class="control-label" for="name">Name</label>
		     <div class="controls">
		       <input type="text" class="" name="oAdminType-name" id="name" value="{$oAdminType->getName()}" />
		     </div>
		   </div>
		   <div class="control-group">
		     <label class="control-label">Access Privileges</label>
		     <div class="controls">
		     	<table cellspacing="0" cellpadding="0" border="0" class="table table-striped table-bordered">
				{foreach from=$aPrivileges key=sGroup item=aModule}
					<tr>
						<td>{$sGroup}</td>
						<td>
							{foreach from=$aModule key=sModule item=sName}
								<label class="checkbox">
									<input type="checkbox" name="privileges[]" value="{$sModule}" {if in_array($sModule,$aCheckedPrivileges)}checked="checked"{/if}> {$sName}
								</label>
							{/foreach}
						</td>
					</tr>
				{/foreach}
				</table>
		     </div>
		   </div>
		   <div class="clearfix"></div>
		</div>
	  </div>
	  <div class="modal-footer">
		<input type="hidden" name="save" value="1"/>
		<input type="submit" value="{loc k=save}" class="btn btn-primary"/>
	 	{if !$oAdminType->isNew()}<input name="delete" type="button" value="{loc k=delete}" class="btn btn-danger" onclick="doDelete('{$oAdminType->getPrimaryKey()}','{val v=$oAdminType->getName() parsequote=true}')"/>{/if}
	 	<a href="{$sUri}" class="btn">Close</a>
	  </div>
	</form>
{/if}
