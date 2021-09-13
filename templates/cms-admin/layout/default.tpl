{include file='core/header.tpl'}
<div class="container" style="min-height: 500px;">
	<div class="row-fluid">
		{*include file='core/menu.tpl'*}
		<div class="modal fade" id="myForm"></div>
		{include file="core/feedback.tpl" source=$oMod->getModule()}
		{include file=$oMod->getTemplateName()}
	</div>
</div>
<hr>
{include file='core/footer.tpl'}