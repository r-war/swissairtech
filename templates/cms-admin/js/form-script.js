$( document ).ready(function() {

/*
	$('#form').ajaxForm(function(html) { 
        $('#myForm').html(html);
    }); 
*/
	$(function() {
	  $('#form').submit(function(event) {
	  	
	  	$('#form input[type=submit]').val(' Saving ... ');
	  	$('#form input[type=submit]').addClass('disabled');

	  	//ckeditor fix submit content on modal dialogue
	  	if($('#fixDescription').val() == 1)	  	{
		  	var value = CKEDITOR.instances['description'].getData();
		  	$('#description').html(value);
	  	}
	  	if($('#fixDescriptionCn').val() == 1)
	  	{
		  	var value = CKEDITOR.instances['descriptioncn'].getData();
		  	$('#descriptioncn').html(value);
	  	}
	  	if($('#fixDescriptionMy').val() == 1)
	  	{
		  	var value = CKEDITOR.instances['descriptionmy'].getData();
		  	$('#descriptionmy').html(value);
	  	}
	  	if($('#fixShortDescription').val() == 1)
	  	{
		  	var value = CKEDITOR.instances['shortDescription'].getData();
		  	$('#shortDescription').html(value);
	  	}
	  	if($('#fixPageDescription').val() == 1)
	  	{
		  	var value = CKEDITOR.instances['pageDescription'].getData();
		  	$('#pageDescription').html(value);
	  	}
	  	var form = $(this);
	  	var url = form.attr('action');
	  	if(url.match(/\?/)) url = url + '&ajax=form';
	  	else  url = url + '?ajax=form';
	  	 
	  	var options = { 
	        target:'#myForm',
	        url:url, 
    	}; 
	  	$(this).ajaxSubmit(options);  
	  	event.preventDefault();
	  	/*
	    var form = $(this);
	    $.ajax({
	      type: form.attr('method'),
	      url: form.attr('action')+'&ajax=form',
	      data: form.serialize()
	    }).done(function(html) {
	    	$('#myForm').html(html);
	    }).fail(function() {
	      	alert('Failed submit form, please try again !')
	    });
	    event.preventDefault();
	    */
	  });
	});
	$('.help').tooltip({placement:'right'});
});