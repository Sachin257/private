elgg.provide('elgg.qualifications');

elgg.qualifications.init = function() {
	jQuery( "#lnk_qualification_add" ).live( "click", function(event) {
	  	jQuery('.dv_qual_type').slideToggle();
	  	//console.log(elgg.security.token.__elgg_ts);
		//console.log(elgg.security.token.__elgg_token);	
		//console.log(elgg.get_logged_in_user_guid());
	  	return false;
	  	event.preventDefault();
	});
	jQuery("#btn_qual_type_send").live("click", function (event) {
		var __elgg_ts =	elgg.security.token.__elgg_ts;
		var __elgg_token =	elgg.security.token.__elgg_token;
		var qualification_type = jQuery('#qualification_type').val();
		if(qualification_type != "") {
			$.ajax({
				type: 'GET',
				url: 'qualification_type/add',
				data: { qualification_type : qualification_type,__elgg_ts:__elgg_ts,__elgg_token:__elgg_token }
			}).done(function(response) {
				console.log(response)				
			}).always(function() {
				jQuery('#qualification_type').val("");
				jQuery('.dv_qual_type').slideToggle();
			});			
		}
		else {
			
		}
	});
};

elgg.register_hook_handler('init', 'system', elgg.qualifications.init);