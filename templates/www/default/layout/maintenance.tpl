<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link href='http://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
	<title>{if $oSeo instanceof Seo}{$oSeo->getMetaTitle()}{else}{$oMod->getMetaData('title')} | {$aConfig.web_title}{/if}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="allow-search" content="Yes">
	<meta name="ROBOTS" content = "All">
	{if $oSeo instanceof Seo}
	<meta name="keywords" content="{$oSeo->getMetaKeywords()}" />
	<meta name="description" content="{$oSeo->getMetaDescription()}" />
	{else}
	<meta name="keywords" content="{$oMod->getMetaData('keywords')}" />
	<meta name="description" content="{$oMod->getMetaData('description')}" />
	{/if}
	<link rel="shortcut icon" href="/contents/{$sDomain}/images/{$aConfig.web_ico}"/>

	{if $oMod instanceof AbstractUserModule}
	<link rel="stylesheet" type="text/css" href="{#CSS_PATH#}_/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="{#CSS_PATH#}_/font-awesome.min.css.css" />
	{/if}
	<link href="{#CSS_PATH#}style.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="{#CSS_PATH#}_/_.css" />
	{$aConfig.custom_script}
</head>
<body>
	<div id="header">
		<div class="top-header">
			<div class="wrapper">
				<div class="left">
				</div>
				<div class="right">
					{if $aConfig.facebook_link || $aConfig.twitter_link || $aConfig.youtube_link || $aConfig.google_link || $aConfig.linkedin_link}
					<div class="social-media">
						{loc k=follow_us}
						{if $aConfig.facebook_link}<a href="#" id="facebook"></a>{/if}
						{if $aConfig.facebook_link}<a href="#" id="twitter"></a>{/if}
						{if $aConfig.facebook_link}<a href="#" id="youtube"></a>{/if}
						{if $aConfig.facebook_link}<a href="#" id="google"></a>{/if}
						{if $aConfig.facebook_link}<a href="#" id="linkedin"></a>{/if}
					</div>
					{/if}
				</div>
			</div>
		</div>
		<div class="wrapper">
			<div class="clearfix">
				<div id="logo" class="left"><a href="{$oMod->getBasePage()}"><img class="float_left" src="/contents/{$sDomain}/images/{$aConfig.web_logo}" alt="{$aConfig.web_title}"></a></div>
				<div class="contact-us right">
					{if $sLang == 'cn'}
		        		{$aConfig.tagline_cn}
		        	{else}
		        		{$aConfig.tagline_en}
		        	{/if}
				</div>
			</div>
		</div>
	</div>
	<div>
		{$aConfig.content_maintenance}
	</div>
	<div id="footer">
		<div class="copyright">
			{if $sLang == 'cn'}
        		{$aConfig.copyright_cn}
        	{else}
        		{$aConfig.copyright_en}
        	{/if}
		</div>
	</div>
	<!-- javascript -->
	<script type="text/javascript" src="{#JS_PATH#}jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="{#JS_PATH#}jquery.placeholder.js"></script>
	<script type="text/javascript" src="{#JS_PATH#}jquery.carouFredSel-6.2.0-packed.js"></script>
	<script type="text/javascript" src="{#JS_PATH#}tabs.js"></script>
	<script type="text/javascript" src="{#JS_PATH#}header.js"></script>

	<!-- JS Slider on Homepage -->	
	<script type="text/javascript" src="{#JS_PATH#}_/_.js"></script>
	{if isset($aSlidingBanner) && $aSlidingBanner|@count > 0}
	<link rel="stylesheet" href="{#CSS_PATH#}supersized.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="{#CSS_PATH#}supersized.shutter.css" type="text/css" media="screen" />
	<script type="text/javascript" src="{#JS_PATH#}jquery.easing.min.js"></script>	
	<script type="text/javascript" src="{#JS_PATH#}supersized.3.2.7.min.js"></script>
	<script type="text/javascript" src="{#JS_PATH#}supersized.shutter.min.js"></script>
	{literal}
	<script type="text/javascript">
		jQuery(function($){
			$.supersized({
				slide_interval			:	3000,
				transition				:	1,
				transition_speed		:	700,
				slide_links				:	'blank',
				slides 					:	[
												{/literal}{foreach from=$aSlidingBanner item=oSlidingBanner}{literal}
												{image : '{/literal}{$oSlidingBanner->getPictureUrl()}{literal}'},
												{/literal}{/foreach}{literal}
											]
			});
		});		
	</script>
	{/literal}
	{/if}
	
   <link rel="stylesheet" type="text/css" href="{#CSS_PATH#}_/colorbox.css" />
   <script type="text/javascript" src="{#JS_PATH#}_/jquery.colorbox-min.js"></script>
	{literal}<script type="text/javascript">
	    //<![CDATA[
	    $(document).ready(function() {
	    	$(".colorbox").colorbox({innerWidth : '60%',innerHeight : '80%'});
	    	$(".colorboxiframe").colorbox({innerWidth : '400',innerHeight : '400',iframe : true});
	    });
	    //]]>
	</script>{/literal}
</body>
{if $bSuccessSub}{$bSuccessSub}{/if}
</html>