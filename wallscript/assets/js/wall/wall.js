var def_txt = "What's on your mind?";

$(document).ready(function(){
	
	set_def_text();
	
	$('#link_tab').click(function() {
		$('#main_comment_share').hide();
		$('#main_link_share').show();
	});
	
	$('#main_comment_tab').click(function() {
		$('#main_comment_share').show();
		$('#main_link_share').hide();
	});
	
	$('#main_share_btn').click(function() {
		
		comment = $('#main_comment').val();
		
		if(comment != def_txt) {
			
			$('#main_box_loader').show();
			
			$.ajax({
				 data: 'comment='+comment+'&form=main_comment_req',
				 url:  "/home/new_share",
				 type: "POST",
				 success: function(results) { $('#comment_history').prepend(results); set_def_text('a');},
				 complete: function(results) { $('#main_box_loader').hide(); }
			});
		}
		
	});
	
	$('#main_comment').focus(function() {set_def_text('r');});
	$('#main_comment').blur(function() {set_def_text();});
	
	/*
	$('#link_share_btn').click(function() {
		
		comment = $('#main_link').val();
		
		if(comment != def_txt) {
			
			$('#main_box_loader').show();
			
			$.ajax({
				 data: 'url='+comment+'&form=main_comment_req',
				 url:  "/home/get_link",
				 type: "POST",
				 success: function(results) { $('#comment_history').prepend(results); set_def_text('a');},
				 complete: function(results) { $('#main_box_loader').hide(); }
			});
		}
		
	});
	*/
	
	// delete event
	$('#link_share_btn').livequery("click", function(){
	 
		if(!isValidURL($('#main_link').val()))
		{
			alert('Please enter a valid url.');
			return false;
		}
		else
		{
			$('#link_box_loader').show();
			comment = $('#main_link').val();
			
			$.ajax({
				 data: 'url='+comment+'&form=main_comment_req',
				 url:  "/home/get_link",
				 type: "POST",
				 success: function(results) {
					 
					 if(results.match(/^--VID--/)) {
						 res = results.replace(/^--VID--/,'');
						 $('#comment_history').prepend(res);
					 }
					 else {
						 if(results != '') {
							 $('#hold_post').html('');
							 $('#hold_post').prepend(results);
							 $('#hold_post').show();
							 
							 $('.images img').hide();
							 $('#load').hide();
							 $('img#1').fadeIn();
							 $('#cur_image').val(1);
						 }
					 }
				 },
				 complete: function(results) { $('#link_box_loader').hide(); }
			});
		}
	});	
	
	// next image
	$('#next_prev_img').livequery("click", function(){
	 
		var firstimage = $('#cur_image').val();
		$('#cur_image').val(1);
		$('img#'+firstimage).hide();
		
		if(firstimage <= $('#total_images').val())
		{
			firstimage = parseInt(firstimage)+parseInt(1);
			$('#cur_image').val(firstimage);
			$('img#'+firstimage).show();
		}
	});
	
	// prev image
	$('#prev_prev_img').livequery("click", function(){
	 
		var firstimage = $('#cur_image').val();
	 
		$('img#'+firstimage).hide();
		if(firstimage>0)
		{
			firstimage = parseInt(firstimage)-parseInt(1);
			$('#cur_image').val(firstimage);
			$('img#'+firstimage).show();
		}
	 
	});	
	
	// watermark input fields
	jQuery(function($){
	   $("#main_link").Watermark("http://");
	});
	jQuery(function($){
	 
		$("#main_link").Watermark("watermark","#369");
	 
	});
	
	function UseData() {
	  $.Watermark.HideAll();
	  $.Watermark.ShowAll();
	}
});

function set_def_text(flag) {
	if(flag && flag == 'r')
		$('#main_comment').val('');
	else if(flag && flag == 'a')
		$('#main_comment').val(def_txt);
	else if($('#main_comment').val() == '')
		$('#main_comment').val(def_txt);
}

function isValidURL(url){
	var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

	if(RegExp.test(url)){
		return true;
	}else{
		return false;
	}
}