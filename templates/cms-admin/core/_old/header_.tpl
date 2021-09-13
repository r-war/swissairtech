<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>{#WEB_TITLE#}{if !empty($module_name)} - {$module_name}{/if}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<meta name="keywords" content="">

<link rel="shortcut icon" href="/favicon.png"/>
{*
<script type="text/javascript" src="{#JS_PATH#}jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="{#JS_PATH#}jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="classes/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="classes/ckfinder/ckfinder.js"></script>
<link rel="stylesheet" type="text/css" href="{#CSS_PATH#}jquery-ui-1.8.16.custom.css">
*}
{*
<link href="{#KENDOUI_PATH#}styles/kendo.common.min.css" rel="stylesheet" />
<link href="{#KENDOUI_PATH#}styles/kendo.default.min.css" rel="stylesheet" />
<script src="{#KENDOUI_PATH#}js/jquery.min.js"></script>
<script src="{#KENDOUI_PATH#}js/kendo.web.min.js"></script>
<link rel="stylesheet" type="text/css" href="{#CSS_PATH#}admin.css">
<script type="text/javascript" src="{#JS_PATH#}script.js"></script>
*}
<script type="text/javascript" src="{#JS_PATH#}jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="{#JS_PATH#}bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="{#CSS_PATH#}bootstrap.min.css">
<link rel="shortcut icon" href="{#CSS_PATH#}icon.jpg" type="image/x-icon" />
</head>
{*
<script>
{literal}
$(function() {
	$( "input:submit, input:button, button" ).button();
	$( "#datepicker" ).datepicker();
});
{/literal}
</script>
*}
<body>
<div class="navbar navbar-fixed-top">
 <div class="navbar">
  <div class="navbar-inner">
   <div class="container">
      <a class="brand" href="#">
	    {*<div id="logo"><a href="/index.html"><img src="/templates/web/images/logo.png" alt="Logo PT. MS Kemakmuran" title="PT. MS Kemakmuran"/></a></div>*}
	    Admin Panel
	  </a>
	  <ul class="nav">
	   <li class="active"><a href="#">Link 1</a></li>
	   <li><a href="#">Link 2</a></li>
	   <li><a href="#">Link 3</a></li>
	   <li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Link 4<b class="caret"></b></a>
		    <ul class="dropdown-menu">
			   <li><a href="#">Child 1</a></li>
			   <li><a href="#">Child 2</a></li>
		    </ul>
       </li>
	  </ul>
   </div>
  </div>
 </div>
</div>

<div align="center">
	<div class="body">
		
