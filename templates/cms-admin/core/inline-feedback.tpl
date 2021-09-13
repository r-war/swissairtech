{if isset($error_inline) && $error_inline|@count > 0}
	<script type="text/javascript">
	$( document ).ready(function() {
		{foreach from=$error_inline key=idx item=message}
			// var id = document.getElementsByName("{$idx}");
			var id = $("#{$idx}");
			$(id).parent().parent().addClass('error');
			$(id).after('<span class="help-inline">{$message}</span>');
		{/foreach}
	});		
	</script>
{/if}