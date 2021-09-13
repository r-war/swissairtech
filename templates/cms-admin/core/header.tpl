<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>{$oMod->getMetaData('title')} | {$oMod->getConfigurationValue(web_title)}</title>
		<meta name="keywords" content="{$oMod->getMetaData('keywords')}">
		<meta name="description" content="{$oMod->getMetaData('description')}">
		<meta name="author" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="/favicon.png"/>
		<link rel="stylesheet" type="text/css" href="{#CSS_PATH#}bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="{#CSS_PATH#}bootstrap-responsive.min.css">
		<link rel="stylesheet" type="text/css" href="{#CSS_PATH#}style.css">
		<script type="text/javascript" src="{#JS_PATH#}jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="{#JS_PATH#}jquery.form.js"></script>
		<script type="text/javascript" src="{#JS_PATH#}bootstrap.min.js"></script>
		<script type="text/javascript" src="{#JS_PATH#}cal.js"></script>
		<script type="text/javascript" src="{#JS_PATH#}script.js"></script>
		<link rel="shortcut icon" href="{#IMG_PATH#}icon.jpg" type="image/x-icon" />

		<script type="text/javascript" src="{#JS_PATH#}checkAll.js"></script>
		<script type="text/javascript">
		{literal}
			function doDelete(id,name)
			{
			{/literal}
				if(confirm("{loc k=confirm_delete} \'" + name + "\'?"))
			{literal}
				{
			{/literal}		
					redirect('{$oMod->getPage($oMod->getModule())}&delete=' + id);
			{literal}
				}
			}
			function doDeleteAttr(id,name)
			{
			{/literal}
				if(confirm("{loc k=confirm_delete} \'" + name + "\'?"))
			{literal}
				{
			{/literal}		
					redirect('{$oMod->getPage($oMod->getModule())}&deleteattr=' + id);
			{literal}
				}
			}
		{/literal}
		</script>
	</head>
	<body>
		{include file="core/inline-feedback.tpl"}
		<div class="navbar navbar-fixed-top">
	      <div class="navbar-inner">
	        <div class="container">
	          {if $oMod->isAdminLogin()}
	          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </a>
	          {/if}
	          <a class="brand" href="#{*$oMod->getBasePage()*}" style="padding-left: 0px;">
				{$oMod->getName()}
	          </a>
	          {if $oMod->isAdminLogin()}
	          <div class="btn-group pull-right">
	            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
	              <i class="icon-tasks"></i> {$oLoginAdmin->getUsername()}
	              <span class="caret"></span>
	            </a>
	            <ul class="dropdown-menu">
	              <li><a href="{$oMod->getBasePage('Profile')}"><i class="icon-edit"></i> {loc k=profile}</a></li>
	              <li><a href="{$oMod->getBasePage()}?logout=1"><i class="icon-off"></i> {loc k=sign_out}</a></li>
	            </ul>
	          </div>
	          <div class="nav-collapse">
	          	{include file="core/header_menu.tpl"}
	          </div>
	          {/if}
	        </div>
	      </div>
	    </div>