function redirect(url)
{
    document.location=url;
}

function doDeleteUrl(url,name)
{
	if(confirm("Delete " + name + " ?"))
	{
		redirect(url);
	}
}

function clearForm()
{
	$('#keywords').val(null);
	$('#formSearch').submit();
}


$( document ).ready(function() {
	$(function(){
		$("a[data-toggle=modal]").click(function (e) {
		  lv_target = $(this).attr('data-target');
		  lv_url = $(this).attr('href') + '&ajax=form';
		  $(lv_target).load(lv_url)});
	});

	$('.help').tooltip({placement:'right'});
});

function updateValue(id,value)
{
	$('#'+id).val(value);
}

