{if $aConfig.web_maintenance == 1}
	{include file='layout/maintenance.tpl'}
{else}
  {include file='core/header.tpl'}
  {include file=$oMod->getTemplateName()}
  {include file='core/footer.tpl'}
{/if}
