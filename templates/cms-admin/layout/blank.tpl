{if $sAjax == 'form'}
	{include file="core/inline-feedback.tpl"}
	<script type="text/javascript" src="{#JS_PATH#}form-script.js"></script>
{/if}
{include file=$oMod->getTemplateName()}