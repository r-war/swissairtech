<form action="{$oMod->getPage($oMod->getModule())}" method="POST" class="nomargin" id="formSearch" enctype="multipart/form-data">
<div class="row-fluid">
	<div class="span8">
		{if !$bHideAdd}<a href="{$oMod->getPage($oMod->getModule())}" role="button" class="btn btn-info" data-toggle="modal" data-target="#myForm"><i class="icon-plus"></i> {loc k=add_new}</a>{/if}
		{if $bDownload}<a href="{$oMod->getCurrentPage()}?&dl=1" role="button" class="btn btn-info" target="_blank"><i class="icon-download-alt"></i> {loc k=download_all_data}</a>{/if}
		<a href="{$oMod->getPage($oMod->getModule())}" role="button" class="btn" title="Refresh List"><i class="icon-refresh"></i></a>
		{if $bUploadFile}<input type="file" name="uploadfile"><input type="submit" class="btn" value="Import"/> {/if}
	</div>
	<div class="span4">
		<label class="pull-right input-prepend input-append">
			<span class="add-on"><i class="icon-search"></i></span>
			<input type="text" name="keywords" id="keywords" value="{$oParam->get('keywords')}" placeholder="Type keywords then enter">
			{if $oParam->get('keywords') != ''}<span class="add-on" onclick="clearForm(); return false;"><i class="icon-remove"></i></span>{/if}
		</label>
	</div>
</div>
</form>