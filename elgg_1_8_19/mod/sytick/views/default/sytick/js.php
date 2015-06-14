elgg.provide('elgg.sytick');

elgg.sytick.init = function() {
	/*
	jQuery( "#resend_email" ).live( "keyup", function(event) {		
		var email = jQuery(this).val();
		//console.log(email);
		var class_str =  jQuery(this).attr('id') + "_err";
		if( validate_email(email)){
			jQuery("."+class_str).html("");
		} else {
			jQuery("."+class_str).html(elgg.echo("registration:notemail"));
		}	
	});
	*/
	var resend_flg = true;
	jQuery("#btn_resend").live("click", function (event) {
		var class_str =  "resend_email_err";
		if(jQuery( "#resend_email" ).val() != "" && resend_flg)
		  {
		  		resend_flg = false;
			  	var obj_form = jQuery(this).closest('form');
			  	var postData = obj_form.serialize();
			    var formURL = '/action/sytick/ajax/home';
			    jQuery.ajax( {
			    	type: "POST",
			    	url : formURL,
			    	data : postData+"&process=resend",		
			    })
			    .done(function(data) {
			        //console.log( "success"+data );
			        if(data)
		        	{
			        	var obj_data = jQuery.parseJSON( data );
			        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
			        	if(call_status != -1 )
		        		{
			        		//var succ = obj_data.system_messages.success;
		        			//jQuery("."+class_str).html(succ[0]); 
		        			show_messages(elgg.echo("registration:user:activation:success"));
		        			jQuery( "#resend_email" ).val("");
		        		} else {
		        			//show_messages(obj_data.system_messages.error);
		        			var err = obj_data.system_messages.error;
		        			jQuery("."+class_str).html(err[0]);        			
		        		}		        	
		        	}
			    })
			    .fail(function() {
			      //alert( "error" );
			    })
			    .always(function() {
			      //alert( "complete" );
			      resend_flg = true;			    	
			    });
		  }
		event.preventDefault();
	});
        
        
        jQuery("#paintingProjectAdd").live("click", function(e){
            $("#projectNameModal").modal();
        
        });
        
        jQuery("#btn_project_name").live("click", function(e){
            var name = jQuery("#projName").val();
            console.log(name);
            if(name !== "")
            {
            window.location.href = "/painting_project/add?name="+name;
            }
            else{
                $(".projName_err").html("Enter a name for project.");
            }
        });
 
        
	var request_flg = true;
	jQuery("#btn_request").live("click", function (event) {
		var class_str =  "username_err";
		if(jQuery( "#username" ).val() != "" && request_flg)
		  {
		  		request_flg = false;
			  	var obj_form = jQuery(this).closest('form');
			  	var postData = obj_form.serialize();
			    var formURL = '/action/sytick/ajax/home';
			    jQuery.ajax( {
			    	type: "POST",
			    	url : formURL,
			    	data : postData+"&process=requestnewpassword",		
			    })
			    .done(function(data) {
			        //console.log( "success"+data );
			        if(data)
		        	{
			        	var obj_data = jQuery.parseJSON( data );
			        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
			        	if(call_status != -1 )
		        		{
		        			show_messages(obj_data.system_messages.success);
		        			jQuery( "#username" ).val("");
		        		} else {
		        			//show_messages(obj_data.system_messages.error);
		        			var err = obj_data.system_messages.error;
		        			jQuery("."+class_str).html(err[0]);        			
		        		}		        	
		        	}
			    })
			    .fail(function() {
			      //alert( "error" );
			    })
			    .always(function() {
			      //alert( "complete" );	
			      request_flg = true;		    	
			    });
		  }
		event.preventDefault();
	});
	
	var reset_flg = true;
	jQuery("#btn_reset").live("click", function (event) {
		var pass = jQuery( "#password" ).val();
		if(pass == "")
		{
			var class_str =  "password_err";
			jQuery("."+class_str).html(elgg.echo("resetpassword:password:blank"));
		}
		if( pass.length < 6 )
		{
			var class_str =  "password_err";
			jQuery("."+class_str).html(elgg.echo("resetpassword:password:blank"));
		}
		if(jQuery( "#password" ).val() !=  jQuery( "#password2" ).val())
		{
			var class_str =  "password2_err";
			jQuery("."+class_str).html(elgg.echo("user:password:fail:notsame"));
		}
		var flg = true;		  
	  	jQuery( ".error_msg" ).each(function( index ) {
		  //console.log( index + ": " + $( this ).html() );
		  var str = jQuery( this ).html();
		  var newStr = str.replace(/\s+/g, '');
		  if(newStr != "" )
		  {
			  flg = false; 
		  }			  
	  	});
		if( ( jQuery( "#password" ).val() != "" &&  jQuery( "#password2" ).val() != "")
			 && reset_flg && flg)
		  {
		  		reset_flg = false;
			  	var obj_form = jQuery(this).closest('form');
			  	var postData = obj_form.serialize();
			    var formURL = '/action/sytick/ajax/home';
			    jQuery.ajax( {
			    	type: "POST",
			    	url : formURL,
			    	data : postData+"&process=resetpassword",		
			    })
			    .done(function(data) {
			        //console.log( "success"+data );
			        if(data)
		        	{
			        	var obj_data = jQuery.parseJSON( data );
			        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
			        	if(call_status != -1 )
		        		{
		        			show_messages(obj_data.system_messages.success);
		        			jQuery( "#password" ).val("");
		        			jQuery( "#password2" ).val("");
		        		} else {
		        			show_messages(obj_data.system_messages.error);
		        			//var err = obj_data.system_messages.error;
		        			//jQuery("."+class_str).html(err[0]);        			
		        		}		        	
		        	}
			    })
			    .fail(function() {
			      //alert( "error" );
			    })
			    .always(function() {
			      //alert( "complete" );	
			      reset_flg = true;		    	
			    });
		  }
		event.preventDefault();
	});
	

	jQuery("#btn_medical_save").live("click", function (event) {
		var class_str =  "description_err";
                var allergy = $("input[name='allergy_flg']:checked").val();
                var medical = $("input[name='medical_flg']:checked").val();
                if(medical == "0" && allergy == "0")
                {
                    var obj_form = jQuery(this).closest('form');
		    var formURL = '/action/user/save';
		    obj_form.attr('action',formURL);
                }       else if(jQuery( "#description" ).val() != "")
		{			
			var obj_form = jQuery(this).closest('form');
                        var formURL = '/action/user/save';
                        obj_form.attr('action',formURL);
		}	else {
			jQuery("."+class_str).html(elgg.echo("profile:medical:error"));
			return false;
			event.preventDefault();
		}
	});
	
	jQuery("#allergy_lbl , #medical_lbl").live("click", function (event) {
		var field_id = jQuery(this).attr('for');
		if(jQuery(this).hasClass('checked'))
		{
			jQuery("#"+field_id).removeAttr('checked');
			jQuery(this).removeClass('checked');
			jQuery("#"+field_id).val(0);
			jQuery('[name="'+field_id+'"]').val(0);
		} else {
			jQuery("#"+field_id).attr('checked',"checked");
			jQuery(this).addClass('checked');
			jQuery("#"+field_id).val(1);
			jQuery('[name="'+field_id+'"]').val(1);
		}
	});
	
	jQuery("#btn_save").live("click", function (event) {	
		var flg = true;	
		var email = jQuery('#email').val();		
		if( ! validate_email(email)){
			jQuery(".email_err").html(elgg.echo("profile:emailerror"));
			flg = false;
		} else {
			jQuery(".email_err").html("");
		}
		if( jQuery('#name').val() == ""){
			jQuery(".name_err").html(elgg.echo("profile:nameerror"));
			flg = false;
		} else {
			jQuery(".name_err").html("");
		}
		if( jQuery('#lastname').val() == ""){
			jQuery(".lastname_err").html(elgg.echo("profile:lastnameerror"));
			flg = false;
		} else {
			jQuery(".lastname_err").html("");
		}
		if( jQuery('#street1').val() == ""){
			jQuery(".street1_err").html(elgg.echo("profile:street1error"));
			flg = false;
		} else {
			jQuery(".street1_err").html("");
		}
		if( jQuery('#town').val() == ""){
			jQuery(".town_err").html(elgg.echo("profile:townerror"));
			flg = false;
		} else {
			jQuery(".town_err").html("");
		}
		if( jQuery('#state').val() == ""){
			jQuery(".state_err").html(elgg.echo("profile:stateerror"));
			flg = false;
		} else {
			jQuery(".state_err").html("");
		}
		if( jQuery('#postcode').val() == ""){
			jQuery(".postcode_err").html(elgg.echo("profile:postcodeerror"));
			flg = false;
		} else {
			jQuery(".postcode_err").html("");
		}
		if(flg  == false)
		{
			event.preventDefault();
			return false;
		}
	});
	
	jQuery("#btn_trade_add, #btn_license_add , #btn_insurance_add ").live("click", function (event) {
		flag_issue = 0;
        flag_exp = 0;
		jQuery('#certificate_type').val("");	
        jQuery('#date_of_issue').val("");
        jQuery('#date_of_expiry').val("");
        jQuery('#certificate_id').val("");
        jQuery('#comments').val("");
        jQuery('#file_guid').val("");
        jQuery('#guid').val("");	
        jQuery('#certificate_upload').val("");	
        //jQuery('#user_guid').val(obj_data.output.user_guid);
		jQuery('#certificate_type').val(jQuery(this).attr('data:id'));	
		jQuery('#btn_cert_save').val(elgg.echo("certificate:add"));	
		$('#myCertificateModal').modal();
	});
	
	jQuery("#btn_cert_save").live("click", function (event) {	
		var cert_flg = true;
		if( jQuery('#date_of_issue').val() == ""){
			jQuery(".date_of_issue_err").html(elgg.echo("certificate:date_of_issue:error"));
			cert_flg = false;
		} else {
			jQuery(".date_of_issue_err").html("");
		}
		if( jQuery('#date_of_expiry').val() == ""){
			jQuery(".date_of_expiry_err").html(elgg.echo("certificate:date_of_expiry:error"));
			cert_flg = false;
		} else {
			jQuery(".date_of_expiry_err").html("");
		}
		if( jQuery('#certificate_id').val() == ""){
			jQuery(".certificate_id_err").html(elgg.echo("certificate:certificate_id:error"));
			cert_flg = false;
		} else {
			jQuery(".certificate_id_err").html("");
		}
		if(jQuery('#guid').val() == "") {
			if( jQuery('#certificate_upload').val() == ""){
				jQuery(".certificate_upload_err").html(elgg.echo("certificate:certificate_upload:error"));
				cert_flg = false;
			} else {
				jQuery(".certificate_upload_err").html("");
			}
		} else {
			if( jQuery('#certificate_upload').val() == "" && jQuery('#file_guid').val() == "" ){
				jQuery(".certificate_upload_err").html(elgg.echo("certificate:certificate_upload:error"));
				cert_flg = false;
			} else {
				jQuery(".certificate_upload_err").html("");
			}
		}
		if(cert_flg  == false)
		{
			event.preventDefault();
			return false;
		} else {
			jQuery(this).closest('form').submit();			 
		}
	});
	jQuery('#frm_cert_type').ajaxForm({
	    success: function(data) {
	        //console.log(data);
	        if(data)
        	{
	        	var obj_data = jQuery.parseJSON( data );
	        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
	        	if(call_status != -1 )
        		{
        			show_messages(obj_data.system_messages.success);
        			window.location.reload();
        		} else {
        			//show_messages(obj_data.system_messages.error);     
        			if(obj_data.output.error_field){
        				var field = obj_data.output.error_field;
        				jQuery("."+field+"_err").html(obj_data.system_messages.error[0]);
        				
        			}			
        		}		        	
        	}
	    },
	    beforeSend: function( xhr ) {
	    	jQuery('#btn_cert_save').attr("disabled","disabled");
		    jQuery('.ajx-submit-load').removeClass('disp-none');
		},
		complete: function(xhr) {
			jQuery('#btn_cert_save').removeAttr("disabled");
			jQuery('.ajx-submit-load').addClass('disp-none');
		}
	});
	
	 var flag_issue = 0;
        $("#date_of_issue_lnk").click(function(){
            if(flag_issue == 0)
            {
            $("#date_of_issue").focus();
            flag_issue = 1;
            }
            else
            {
            $("#date_of_issue").blur();
            flag_issue = 0;
            }
        }); 
        
      
        
        var flag_exp = 0;
        $("#date_of_expiry_lnk").click(function(){
            if(flag_exp == 0)
            {
            $("#date_of_expiry").focus();
            flag_exp = 1;
            }
            else
            {
            $("#date_of_expiry").blur();
            flag_exp = 0;
            }
        });
	
	jQuery("#btn_company_save").live("click", function (event) {	
		var company_flg = true;
		if( jQuery('#entity_name').val() == ""){
			jQuery(".entity_name_err").html(elgg.echo("company:title:error"));
			company_flg = false;
		} else {
			jQuery(".entity_name_err").html("");
		}
		if( jQuery('#contact').val() == ""){
			jQuery(".contact_err").html(elgg.echo("company:contact:error"));
			company_flg = false;
		} else {
			jQuery(".contact_err").html("");
		}
		if( jQuery('#contact_email').val() == ""){
			jQuery(".contact_email_err").html(elgg.echo("registration:notemail"));
			company_flg = false;
		} else {
			jQuery(".contact_email_err").html("");
		}
		var email = jQuery('#contact_email').val();
		if( validate_email(email)){
			jQuery(".contact_email_err").html("");			
		} else {
			jQuery(".contact_email_err").html(elgg.echo("registration:notemail"));
			company_flg = false;
		}
		if( jQuery('#street_address').val() == ""){
			jQuery(".street_address_err").html(elgg.echo("company:street_address:error"));
			company_flg = false;
		} else {
			jQuery(".street_address_err").html("");
		}
		if( jQuery('#town').val() == ""){
			jQuery(".town_err").html(elgg.echo("profile:townerror"));
			company_flg = false;
		} else {
			jQuery(".town_err").html("");
		}
		if( jQuery('#state').val() == ""){
			jQuery(".state_err").html(elgg.echo("profile:stateerror"));
			company_flg = false;
		} else {
			jQuery(".state_err").html("");
		}
		if( jQuery('#postcode').val() == ""){
			jQuery(".postcode_err").html(elgg.echo("profile:postcodeerror"));
			company_flg = false;
		} else {
			jQuery(".postcode_err").html("");
		}		
		if( jQuery('#contact_postal_address').val() == ""){
			jQuery(".contact_postal_address_err").html(elgg.echo("company:street_address:error"));
			company_flg = false;
		} else {
			jQuery(".contact_postal_address_err").html("");
		}
		if( jQuery('#contact_town').val() == ""){
			jQuery(".contact_town_err").html(elgg.echo("profile:townerror"));
			company_flg = false;
		} else {
			jQuery(".contact_town_err").html("");
		}
		if( jQuery('#contact_state').val() == ""){
			jQuery(".contact_state_err").html(elgg.echo("profile:stateerror"));
			company_flg = false;
		} else {
			jQuery(".contact_state_err").html("");
		}
		if( jQuery('#contact_postcode').val() == ""){
			jQuery(".contact_postcode_err").html(elgg.echo("profile:postcodeerror"));
			company_flg = false;
		} else {
			jQuery(".contact_postcode_err").html("");
		}
		jQuery( ".error_msg" ).each(function( index ) {
			  //console.log( index + ": " + $( this ).html() );
			  var str = jQuery( this ).html();
			  var newStr = str.replace(/\s+/g, '');
			  if(newStr != "" )
			  {
				  company_flg = false; 
			  }			  
		  });
		if(company_flg  == false)
		{
			//console.log("err");
			event.preventDefault();
			return false;
		} else {
			//console.log("submit");
			//jQuery(this).closest('form').submit();		
			return true;	 
		}
	});
	
	jQuery('#frm_company_edit').ajaxForm({
	    success: function(data) {
	        //console.log(data);
	        if(data)
        	{
	        	var obj_data = jQuery.parseJSON( data );
	        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
	        	if(call_status != -1 )
        		{
        			window.location.href="/company/all/"+jQuery('#company_type').val();        			       	        			        			
        		} else {
        			//show_messages(obj_data.system_messages.error); 
        			if(obj_data.output.error_field){
        				var field = obj_data.output.error_field;
        				jQuery("."+field+"_err").html(obj_data.system_messages.error[0]);        				
        			} else {
        				show_messages(obj_data.system_messages.error);
        			}       						
        		}		        	
        	}
	    },
		beforeSend: function( xhr ) {
	    	jQuery('#btn_company_save').attr("disabled","disabled");
		    jQuery('.ajx-submit-load').removeClass('disp-none');
		},
		complete: function(xhr) {
			jQuery('#btn_company_save').removeAttr("disabled");
			jQuery('.ajx-submit-load').addClass('disp-none');
		}
	});
	
	jQuery("#same_as_company").live("change", function (event) {
		if(jQuery(this).attr('checked') == "checked")
		{
			//console.log("checked");
			jQuery('#contact_postal_address').val(jQuery('#street_address').val());
			jQuery('#contact_town').val(jQuery('#town').val());
			jQuery('#contact_state').val(jQuery('#state').val());
			jQuery('#contact_postcode').val(jQuery('#postcode').val());
			jQuery('#contact_country').val(jQuery('#country').val());
		} else {
			jQuery('#contact_postal_address').val("");
			jQuery('#contact_town').val("");
			jQuery('#contact_state').val("");
			jQuery('#contact_postcode').val("");
			jQuery('#contact_country').val("");
		}
	});	
	
	jQuery(".ind_duplicate").live("click", function (event) {
              var ind_guid = jQuery(this).attr("ind_guid");
              var __elgg_ts =	elgg.security.token.__elgg_ts;
	      var __elgg_token =	elgg.security.token.__elgg_token;
              window.location.href = "/action/induction/duplicate/?guid="+ind_guid+"&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token;
              
         });
        
	jQuery("#entity_name").live("blur", function (event) {
		  if(jQuery(this).val() != "")
		  {
			   	var postData = jQuery(this).attr('id')+"="+jQuery(this).val();
			   	if(jQuery('#guid').length && jQuery('#guid').val() != "")
			   	{
			   		postData = postData + "&guid="+jQuery('#guid').val();
			   	}
			   	var __elgg_ts =	elgg.security.token.__elgg_ts;
			 	var __elgg_token =	elgg.security.token.__elgg_token;
			    jQuery.ajax( {
			    	type: "POST",
			    	url : '/action/sytick/ajax/home',
			    	data : postData+"&process=companyuniquechk&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,		
			    })
			    .done(function(data) {
			        //console.log( "success"+data );
			        if(data)
		        	{
			        	var obj_data = jQuery.parseJSON( data );
			        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
			        	if(call_status != -1 )
		        		{
			        		 jQuery(".entity_name_err").html("");
		        		} else {
		        			//alert(obj_data.system_messages.error);
		        			jQuery(".entity_name_err").html(obj_data.system_messages.error[0]);	        			
		        		}		        	
		        	}
			    })
			    .fail(function() {
			      //alert( "error" );
			    })
			    .always(function() {
			      //alert( "complete" );			    	
			    });
		  }	  
	  });
	   jQuery("#abn").live("focus", function (event) {
                $("#btn_company_save").attr('disabled', 'disabled');
           });
           
	  jQuery("#abn").live("blur", function (event) {
		  if(jQuery(this).val() != "")
		  {
                                $('#entity_name').attr("readonly", true);
                                $('#trading_name').attr("readonly", true);
                                $('#postcode').attr("readonly", true);
                                $("#entity_name").val("");
                             $("#trading_name").val("");
                             $("#postcode").val("");
			   	var postData = jQuery(this).attr('id')+"="+jQuery(this).val();
			   	if(jQuery('#guid').length && jQuery('#guid').val() != "")
			   	{
			   		postData = postData + "&guid="+jQuery('#guid').val();
			   	}
			   	var __elgg_ts =	elgg.security.token.__elgg_ts;
			 	var __elgg_token =	elgg.security.token.__elgg_token;
			    jQuery.ajax( {
			    	type: "POST",
			    	url : '/action/sytick/ajax/home',
			    	data : postData+"&process=abnuniquechk&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,                                
			    })
			    .done(function(data) {
			        //console.log(data);
			        if(data)
		        	{
                               
			        	var obj_data = jQuery.parseJSON( data );
			        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
			        	if(call_status != -1 )
		        		{
			        		 jQuery(".abn_err").html("");
                             $("#entity_name").val(obj_data.output.companyname);
                             $("#trading_name").val(obj_data.output.tradingname);
                             $("#postcode").val(obj_data.output.postcode);
                             $("#btn_company_save").removeAttr('disabled');
		        		} else {
		        			//alert(obj_data.system_messages.error);
		        			jQuery(".abn_err").html(obj_data.system_messages.error[0]);	        			
		        		}	        	
		        	}
			    })
			    .fail(function() {
			      //alert( "error" );
			    })
			    .always(function() {
                                $('#entity_name').attr("readonly", false);
                                $('#trading_name').attr("readonly", false);
                                $('#postcode').attr("readonly", false);
			      //alert( "complete" );			    	
			    });
		  }	  
	  });
	  jQuery("#general_search").live("blur", function (event) {
               document.getElementById("search_results").style.display = "none";
          });
          
          
          jQuery("#general_search").live("keyup", function (event) {
          
		  if(jQuery(this).val() != "" && event.which != 13)
		  {
			   	var postData = jQuery(this).attr('id')+"="+ encodeURIComponent(jQuery(this).val());
			   	var __elgg_ts =	elgg.security.token.__elgg_ts;
			 	var __elgg_token =	elgg.security.token.__elgg_token;
			    jQuery.ajax( {
			    	type: "POST",
			    	url : '/action/sytick/ajax/home',
			    	data : postData+"&process=searchdropdown&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,		
			    })
			    .done(function(data) {
			        if(data)
		        	{
			        	var obj_data = jQuery.parseJSON( data );
			        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
			        	if(call_status != -1 )
		        		{
                                             $( "#search_results" ).empty();
			        	     $( "#search_results" ).append(obj_data.output.search_result); 
                                             document.getElementById("search_results").style.display = "";
		        		} else {
		        						
		        		}		        	
		        	}
			    })
			    .fail(function() {
			      //alert( "error" );
			    })
			    .always(function() {
			      //alert( "complete" );			    	
			    });
		  }
                  else if(event.which == 13)
                  {
                    general_search();
                  }
                  else{
                    $( "#search_results" ).empty();
                  }
                  
	  });
          
         function general_search()
         {
             var search = jQuery("#general_search").val();
             window.location.assign("/search?search_content="+search);
         }
         
         var search_type = "";
         var limit = 0;
         jQuery(".tab").live("click", function (event) {
                 var search = jQuery("#general_search").val();
                 search_type = jQuery(this).attr('id');
                 limit = 5;
                 if(search_type)
                 {
                 var postData = "general_search="+ search;
			   	var __elgg_ts =	elgg.security.token.__elgg_ts;
			 	var __elgg_token =	elgg.security.token.__elgg_token;
			    jQuery.ajax( {
			    	type: "POST",
			    	url : '/action/sytick/ajax/home',
			    	data : postData+"&process="+search_type+"&limit="+limit+"&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,		
			    })
			    .done(function(data) {
			        //console.log( "success"+data );
			        if(data)
		        	{
			        	var obj_data = jQuery.parseJSON( data );
			        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
			        	if(call_status != -1 )
		        		{
			        	     $( "#results" ).empty();
                                             $( "#results" ).append(obj_data.output.html);
		        		} 	        	
		        	}
			    })
			    .fail(function() {
			      //alert( "error" );
			    })
			    .always(function() {
			      //alert( "complete" );			    	
			    });
                 
                 }
         });
         

         var elementExists = document.getElementById("search_project");
         
         if(elementExists != null)
         {
            $(window).scroll(function(){ 
                 if(search_type != "search_all")
                 {
                    if($(window).scrollTop() == ($(document).height() - $(window).height()))
                        {
                         limit = limit +5;
                         var search = jQuery("#general_search").val();
                         document.getElementsByClassName(search_type)[0].style.display = "";
                       if(search_type)
                       {
                           var postData = "general_search="+ search;
                                    var __elgg_ts =	elgg.security.token.__elgg_ts;
                                    var __elgg_token =	elgg.security.token.__elgg_token;
                                jQuery.ajax( {
                                    type: "POST",
                                    url : '/action/sytick/ajax/home',
                                    data : postData+"&process="+search_type+"_add&limit="+limit+"&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,		
                                })
                                .done(function(data) {
                                    //console.log( "success"+data );
                                    if(data)
                                    {
                                            var obj_data = jQuery.parseJSON( data );
                                            var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
                                            if(call_status != -1 )
                                            {
                                                 
                                                 $(  obj_data.output.html ).insertBefore("."+search_type);
                                            } 	        	
                                    }
                                })
                                .fail(function() {
                                  //alert( "error" );
                                })
                                .always(function() {
                                    document.getElementsByClassName(search_type)[0].style.display = "none";
                                    //alert( "complete" );			    	
                                });

                     }
                        }
                    }
            });
         }
          
	  jQuery("#contact_email").live("blur", function (event) {
		  if(jQuery(this).val() != "")
		  {
			   	var postData = jQuery(this).attr('id')+"="+ encodeURIComponent(jQuery(this).val());
			   	if(jQuery('#guid').length && jQuery('#guid').val() != "")
			   	{
			   		postData = postData + "&guid="+jQuery('#guid').val();
			   	}
			   	if(jQuery('#contact_id').length && jQuery('#contact_id').val() != "")
			   	{
			   		postData = postData + "&contact_guid="+jQuery('#contact_id').val();
			   	}
			   	var __elgg_ts =	elgg.security.token.__elgg_ts;
			 	var __elgg_token =	elgg.security.token.__elgg_token;
			    jQuery.ajax( {
			    	type: "POST",
			    	url : '/action/sytick/ajax/home',
			    	data : postData+"&process=companycontactuniquechk&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,		
			    })
			    .done(function(data) {
			        //console.log( "success"+data );
			        if(data)
		        	{
			        	var obj_data = jQuery.parseJSON( data );
			        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
			        	if(call_status != -1 )
		        		{
			        		 jQuery(".contact_email_err").html("");
		        		} else {
		        			//alert(obj_data.system_messages.error);
		        			jQuery(".contact_email_err").html(obj_data.system_messages.error[0]);	        			
		        		}		        	
		        	}
			    })
			    .fail(function() {
			      //alert( "error" );
			    })
			    .always(function() {
			      //alert( "complete" );			    	
			    });
		  }	  
	  });
	
	var cert_edit_flg = true;
	jQuery(".edit_certi").live("click", function (event) {		
		cert_edit_flg = false;
		jQuery('#certificate_type').val("");		
        jQuery('#date_of_issue').val("");
        jQuery('#date_of_expiry').val("");
        jQuery('#certificate_id').val("");
        jQuery('#comments').val("");
        jQuery('#file_guid').val("");
        jQuery('#guid').val("");	
        jQuery('#certificate_upload').val("");	
	  	var postData = "guid="+ jQuery(this).attr('data:guid');
	   	var __elgg_ts =	elgg.security.token.__elgg_ts;
	 	var __elgg_token =	elgg.security.token.__elgg_token;
	    jQuery.ajax( {
	    	type: "POST",
	    	url : '/action/sytick/ajax/home',
	    	data : postData+"&process=editcert&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,		
	    })
	    .done(function(data) {
	        //console.log( "success"+data );
	        if(data)
        	{
	        	var obj_data = jQuery.parseJSON( data );
	        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
	        	if(call_status != -1 )
        		{        			
        			//show_messages(obj_data.system_messages.success);
        			//console.log( data );
        			jQuery('#certificate_type').val(obj_data.output.certificate_type);		
        			jQuery('#date_of_issue').val(obj_data.output.date_of_issue);
        			jQuery('#date_of_expiry').val(obj_data.output.date_of_expiry);
        			jQuery('#certificate_id').val(obj_data.output.certificate_id);
        			jQuery('#comments').val(obj_data.output.comments);
        			jQuery('#file_guid').val(obj_data.output.file_guid);
        			jQuery('#guid').val(obj_data.output.guid);	
        			jQuery('#user_guid').val(obj_data.output.user_guid);	
        			jQuery('#btn_cert_save').val(elgg.echo("entity:update"));
					$('#myCertificateModal').modal();
        		} else {
        			show_messages(obj_data.system_messages.error);        			     			
        		}		        	
        	}
	    })
	    .fail(function() {
	      //alert( "error" );
	    })
	    .always(function() {
	      //alert( "complete" );	
	      cert_edit_flg = true;		    	
	    });
		event.preventDefault();
	});
	
	var ias = null;
	jQuery(".upld_pic").live("click", function (event) {
		jQuery('.crop_err').html("");	
		jQuery("#webcam-upload").hide();
		jQuery("#profile_pic_upld").show();	
		profile_pic_modal("normal");
	});
	
	function profile_pic_modal(type)
	{
		$('#myProfilePicModal').modal().on('shown.bs.modal', function ()
		{
			if(type == "normal") {
				select_normal_crop_area();
			}  
		
		})
		.on('hide.bs.modal', function () {
		   if(ias != null )  {
		   	ias.cancelSelection();
		   	}
		});
	}
        
        jQuery(".take_pic").live("click", function (event) {
		jQuery('.crop_err').html("");
        if(jQuery("#webcam-upload").length)
        {
        	$( "#webcam-upload" ).remove();
        }
        guid =  $(this).attr('guid');
        upload_or_take_pic(guid);
		jQuery("#webcam-upload").show();
		jQuery("#profile_pic_upld").hide();
		profile_pic_modal("");
		if(ias != null )  {
	   		ias.cancelSelection();
	   	}
	});
        
        function upload_or_take_pic(guid)
	{
		var postData = "guid="+ guid;
	   	var __elgg_ts =	elgg.security.token.__elgg_ts;
	 	var __elgg_token =	elgg.security.token.__elgg_token;
	 	jQuery.ajax( {
	    	type: "POST",
	    	url : '/action/sytick/ajax/home',
	    	data : postData+"&process=profile_pic_upload&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,
	    	beforeSend: function(){
	    	  if(ias != null )  {
		   		ias.cancelSelection();
		   	  } 
		    },		
	    })
	    .done(function(data) {
	        if(data)
        	{
	        	var obj_data = jQuery.parseJSON( data );
	        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
	        	if(call_status != -1 )
        		{
        			console.log(data);	
        			if(obj_data.output.result_html)
        			{      
                        jQuery(".modal-body").append(obj_data.output.result_html);        				
        			} 	 
        			if(ias != null )  {
				   		ias.cancelSelection();
				   	}     			
        		} else {
        			var err = obj_data.system_messages.error; 
        			show_messages(err);          					
        			return false;  			     			
        		}		        	
        	}
	    });
	}
	
	function image_selection_end (img, selection)
	{
		// console.log('width: ' + selection.width + '; height: ' + selection.height);					        
		jQuery('#x1').val(selection.x1);
		jQuery('#x2').val(selection.x2);
		jQuery('#y1').val(selection.y1);
		jQuery('#y2').val(selection.y2);
	}
	
	function select_normal_crop_area()
	{
		if( jQuery('#x1').val() != "" && jQuery('#x2').val() != ""
			 && jQuery('#y1').val() != "" && jQuery('#y2').val() != ""){
				var params = {
					selectionOpacity: 0,
					aspectRatio: '1:1',
					instance: true,
					onSelectEnd: image_selection_end
				};			
				params.x1 = jQuery('#x1').val();
				params.x2 = jQuery('#x2').val();
				params.y1 = jQuery('#y1').val();
				params.y2 = jQuery('#y2').val();	
			
				ias = jQuery('#user-avatar-cropper').imgAreaSelect(params);
				
			}  
	}
	
	jQuery("#btn_profile_pic_save").live("click", function (event) {
		if( jQuery('#x1').val() == "" || jQuery('#x2').val() == ""
			 || jQuery('#y1').val() == "" || jQuery('#y2').val() == ""){
			 jQuery('.crop_err').html(elgg.echo("crop:error"));
			 event.preventDefault();
			 return false;
		 } else {
		 	//alert( jQuery('#x1').val() + " -- " + jQuery('#x2').val() +" -- "+ jQuery('#y1').val()+" -- "+jQuery('#y2').val() );
		 	jQuery('#frm_profile_crop').submit();
		 }
	});
	
		
	/*jQuery("#btn_upload").live("click", function (event) {*/
	jQuery("#avatar").live("change", function (event) {
		if(jQuery('#avatar').val() == "" ) {
			jQuery('.crop_err').html(elgg.echo("upload:error"));  	
	    } else{
	    	jQuery('#frm_upload_pic').submit();
	    }
		event.preventDefault();
	});
	
	jQuery('#frm_upload_pic').ajaxForm({
	    success: function(data) {
	        //console.log(data);
	        if(data)
        	{
	        	var obj_data = jQuery.parseJSON( data );
	        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
	        	if(call_status != -1 )
        		{
        			jQuery('.crop_err').html(elgg.echo("upload:success"));
        			//window.location.reload();
        			var master_url = obj_data.output.master_pic_url;
        			jQuery('#user-avatar-cropper').attr('src', master_url);
        			ias = jQuery('#user-avatar-cropper').imgAreaSelect({instance: true, onSelectEnd: image_selection_end});        	        			        			
        		} else {
        			//show_messages(obj_data.system_messages.error); 
        			jQuery('.crop_err').html(obj_data.system_messages.error[0]);        						
        		}		        	
        	}
	    },
		complete: function(xhr) {
			
		}
	});
	

		
	var cam_capture_flg = true;
	jQuery("#avatar-upload").live("click", function (event) {
		if(cam_capture_flg)
		  {
		  		cam_capture_flg = false;
			  	var obj_form = jQuery(this).closest('form');
			  	var postData = obj_form.serialize();
			    var formURL = obj_form.attr('action');
			    jQuery.ajax( {
			    	type: "POST",
			    	url : formURL,
			    	data : postData,
			    	beforeSend: function(){
			    	  jQuery('.ajx-submit-load').removeClass('disp-none'); 
			    	  if(ias != null )  {
					   	ias.cancelSelection();
				      }  
				    },		
			    })
			    .done(function(data) {
			        //console.log( "success"+data );
			        if(data)
		        	{
			        	var obj_data = jQuery.parseJSON( data );
			        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
			        	if(call_status != -1 )
		        		{
		        			jQuery('.crop_err').html(elgg.echo("upload:success"));
		        			//window.location.reload();
		        			var master_url = obj_data.output.master_pic_url;
		        			jQuery('#user-avatar-cropper').attr('src', master_url);
		        			jQuery("#webcam-upload").hide();
		        			jQuery('#avatar').hide();
							jQuery("#profile_pic_upld").show();	
							jQuery('#frm_upload_pic').find('.elgg-foot').removeClass('column_right');							
		        			ias = jQuery('#user-avatar-cropper').imgAreaSelect({instance: true, onSelectEnd: image_selection_end}); 
		        			select_normal_crop_area();       	        			        			
		        		} else {
		        			//show_messages(obj_data.system_messages.error); 
		        			jQuery('.crop_err').html(obj_data.system_messages.error[0]);        						
		        		}		        	
		        	}
			    })
			    .fail(function() {
			      //alert( "error" );
			    })
			    .always(function() {
			      //alert( "complete" );
			      cam_capture_flg = true;	
			      jQuery('.ajx-submit-load').addClass('disp-none');		    	
			    });
		  }
		event.preventDefault();
	});
	
	var activate_mngr_flg = true;
	jQuery("#btn_activate_manager").live("click", function (event) {
		var pass = jQuery( "#password" ).val();
		if(pass == "")
		{
			var class_str =  "password_err";
			jQuery("."+class_str).html(elgg.echo("resetpassword:password:blank"));
		}
		if( pass.length < 6 )
		{
			var class_str =  "password_err";
			jQuery("."+class_str).html(elgg.echo("resetpassword:password:blank"));
		}
		if(jQuery( "#password" ).val() !=  jQuery( "#password2" ).val())
		{
			var class_str =  "password2_err";
			jQuery("."+class_str).html(elgg.echo("user:password:fail:notsame"));
		}
		var flg = true;		  
	  	jQuery( ".error_msg" ).each(function( index ) {
		  //console.log( index + ": " + $( this ).html() );
		  var str = jQuery( this ).html();
		  var newStr = str.replace(/\s+/g, '');
		  if(newStr != "" )
		  {
			  flg = false; 
		  }			  
	  	});
		if( ( jQuery( "#password" ).val() != "" &&  jQuery( "#password2" ).val() != "")
			 && activate_mngr_flg && flg)
		  {
		  		activate_mngr_flg = false;
			  	var obj_form = jQuery(this).closest('form');
			  	var postData = obj_form.serialize();
			    var formURL = '/action/sytick/ajax/home';
			    jQuery.ajax( {
			    	type: "POST",
			    	url : formURL,
			    	data : postData+"&process=activatemanager",		
			    })
			    .done(function(data) {
			        //console.log( "success"+data );
			        if(data)
		        	{
			        	var obj_data = jQuery.parseJSON( data );
			        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
			        	if(call_status != -1 )
		        		{
		        			show_messages(obj_data.system_messages.success);
		        			//alert(obj_data.system_messages.success); 
			        		var forward_url = (obj_data.output && obj_data.output.forward_url) ?  obj_data.output.forward_url :"";
			        		if(forward_url != "")
		        			{
			        			window.location.href = forward_url;
		        			}
			        		jQuery( "#password" ).val("");
		        			jQuery( "#password2" ).val("");		        			
		        		} else {
		        			show_messages(obj_data.system_messages.error);
		        			//var err = obj_data.system_messages.error;
		        			//jQuery("."+class_str).html(err[0]);        			
		        		}		        	
		        	}
			    })
			    .fail(function() {
			      //alert( "error" );
			    })
			    .always(function() {
			      //alert( "complete" );	
			      activate_mngr_flg = true;		    	
			    });
		  }
		event.preventDefault();
	});
	
	jQuery("#manager_email").live("keyup", function (event) {
		  if(jQuery(this).val() != "")
		  {
			   	var postData = jQuery(this).attr('id')+"="+ encodeURIComponent(jQuery(this).val());
			   	if(jQuery('#guid').length && jQuery('#guid').val() != "")
			   	{
			   		postData = postData + "&guid="+jQuery('#guid').val();
			   	}
			   	if(jQuery('#company_id').length && jQuery('#company_id').val() != "")
			   	{
			   		postData = postData + "&company_id="+jQuery('#company_id').val();
			   	}
			   	var __elgg_ts =	elgg.security.token.__elgg_ts;
			 	var __elgg_token =	elgg.security.token.__elgg_token;
			    jQuery.ajax( {
			    	type: "POST",
			    	url : '/action/sytick/ajax/home',
			    	data : postData+"&process=manageruniquechk&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,		
			    })
			    .done(function(data) {
			        //console.log( "success"+data );
			        if(data)
		        	{
			        	var obj_data = jQuery.parseJSON( data );
			        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
			        	if(call_status != -1 )
		        		{
			        		 jQuery(".manager_email_err").html("");
		        		} else {
		        			//alert(obj_data.system_messages.error);
		        			jQuery(".manager_email_err").html(obj_data.system_messages.error[0]);	        			
		        		}		        	
		        	}
			    })
			    .fail(function() {
			      //alert( "error" );
			    })
			    .always(function() {
			      //alert( "complete" );			    	
			    });
		  }	  
	  });
	
	jQuery("#btn_manager_save").live("click", function (event) {	
		var manager_flg = true; 
		if( jQuery('#contact').val() == ""){
			jQuery(".contact_err").html(elgg.echo("company:contact:error"));
			manager_flg = false;
		} else {
			jQuery(".contact_err").html("");
		}
		if( jQuery('#manager_email').val() == ""){
			jQuery(".manager_email_err").html(elgg.echo("registration:notemail"));
			manager_flg = false;
		} else {
			jQuery(".manager_email_err").html("");
		}
		var email = jQuery('#manager_email').val();
		if( validate_email(email)){
			jQuery(".manager_email_err").html("");			
		} else {
			jQuery(".manager_email_err").html(elgg.echo("registration:notemail"));
			manager_flg = false;
		}
		if( jQuery('#contact_postal_address').val() == ""){
			jQuery(".contact_postal_address_err").html(elgg.echo("company:street_address:error"));
			manager_flg = false;
		} else {
			jQuery(".contact_postal_address_err").html("");
		}
		if( jQuery('#contact_town').val() == ""){
			jQuery(".contact_town_err").html(elgg.echo("profile:townerror"));
			manager_flg = false;
		} else {
			jQuery(".contact_town_err").html("");
		}
		if( jQuery('#contact_state').val() == ""){
			jQuery(".contact_state_err").html(elgg.echo("profile:stateerror"));
			manager_flg = false;
		} else {
			jQuery(".contact_state_err").html("");
		}
		if( jQuery('#contact_postcode').val() == ""){
			jQuery(".contact_postcode_err").html(elgg.echo("profile:postcodeerror"));
			manager_flg = false;
		} else {
			jQuery(".contact_postcode_err").html("");
		}
		if( jQuery('#company_id').val() == ""){
			show_messages(elgg.echo("manager:company:error"))
			manager_flg = false;
		} 
		jQuery( ".error_msg" ).each(function( index ) {
			  //console.log( index + ": " + $( this ).html() );
			  var str = jQuery( this ).html();
			  var newStr = str.replace(/\s+/g, '');
			  if(newStr != "" )
			  {
				  manager_flg = false; 
			  }			  
		  });
		if(manager_flg  == false)
		{
			//console.log("err");
			event.preventDefault();
			return false;
		} else {
			//console.log("submit");
			jQuery(this).closest('form').submit();			 
		}
	});
	
	function manager_search(){
		if( jQuery('#s').val() != ""){
			window.location.href = "/manager/all?s="+encodeURIComponent(jQuery('#s').val())
		}  else{
        	 window.location.href = "/manager/all";
        }
	}
	
	
	jQuery("#btn_filter").live("click", function (event) {	
		manager_search();	
	});
	
	    
	jQuery("#frm_manager_search").live("submit", function (event) {	
		manager_search();	
		event.preventDefault();
		return false;	
	});
	
    function security_person_search(){
		if( jQuery('#s').val() != ""){
			window.location.href = "/security_person/all?s="+encodeURIComponent(jQuery('#s').val())
		} else{
           window.location.href = "/security_person/all";
        }
	}
	
	jQuery("#btn_securityperson_filter").live("click", function (event) {	
		security_person_search();	
	});
	
	
        
   function project_manager_search(){
		if( jQuery('#s').val() != ""){
			window.location.href = "/project_manager/all?s="+encodeURIComponent(jQuery('#s').val())
		}
        else{
                window.location.href = "/project_manager/all";
        }
	}
	
	jQuery("#btn_projectmanager_filter").live("click", function (event) {	
		project_manager_search();	
	});
        
    jQuery("#frm_projectmanager_search").live("submit", function (event) {	
		project_manager_search();	
		event.preventDefault();
		return false;	
	});
        
    jQuery("#frm_securityperson_search").live("submit", function (event) {	
		security_person_search();	
		event.preventDefault();
		return false;	
	});        
        
    jQuery("#frm_company_search").live("submit", function (event) {	
		company_search();	
		event.preventDefault();
		return false;	
	});   
        
        
    jQuery("#frm_material_type_search").live("submit", function (event) {	
		material_type_search();	
		event.preventDefault();
		return false;	
	});
        
        jQuery("#frm_paint_search").live("submit", function (event) {	
		paint_search();	
		event.preventDefault();
		return false;	
	});
        jQuery("#frm_painting_project_search").live("submit", function (event) {	
		painting_project_search();	
		event.preventDefault();
		return false;	
	});
        
	jQuery("#frm_manager_search").live("submit", function (event) {	
		manager_search();	
		event.preventDefault();
		return false;	
	});

        $("#uniq_project").live("change", function(e){
          console.log($(this).find(":selected").text());
          if ($(this).val() !== "")
          {
              var ser = $(this).find(":selected").text();
              window.location.href = "/painting_project/all?s="+encodeURIComponent(ser);
          }
        });
        $( document ).ready(function() {
            
            if($("#abn").val() == "")
            {
                $("#btn_company_save").attr('disabled', 'disabled');
            }
            
            
       $(".custom-select-default").each(function(){
            $(this).wrap("<span class='select-wrapper'></span>");
            $(this).after("<span class='holder'></span>");
        });
    });
        
     $(".custom-select-default").change(function(){
            var selectedOption = $(this).find(":selected").text();
            console.log(selectedOption);
            $(this).next(".holder").html(selectedOption);
        }).trigger('change');
                
    $( document ).ready(function() {
       $(".custom-select").each(function(){
       var selectedOption = $(this).find(":selected").text();
           $(this).wrap("<span class='select-wrapper'></span>");
           $(this).after("<span class='holder'></span>");
           $(this).next(".holder").html(selectedOption);
        });
    });
           
           
          $(".custom-select").change(function(){
            var selectedOption = $(this).find(":selected").text();
            console.log("change",selectedOption);
            $(this).next(".holder").html(selectedOption);
            if ($(this).attr('id')  == "prj_company_id") {
            if(jQuery(this).val() != "" && elgg.is_admin_logged_in())
		  {
			   	var postData = jQuery(this).attr('id')+"="+jQuery(this).val();
			   	var __elgg_ts =	elgg.security.token.__elgg_ts;
			 	var __elgg_token =	elgg.security.token.__elgg_token;
                                jQuery('#manager_id, #ind_manager_id, #security_person_id').next(".holder").text('');
			    jQuery.ajax( {
			    	type: "POST",
			    	url : '/action/sytick/ajax/home',
			    	data : postData+"&process=getmanagers&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,		
			    })
			    .done(function(data) {
			        //console.log( "success"+data );
			        if(data)
		        	{
			        	var obj_data = jQuery.parseJSON( data );
			        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
			        	jQuery('#manager_id').empty();
                                        //jQuery('#whs_manager_id').empty();
                                        jQuery('#ind_manager_id').empty();
                                        jQuery('#security_person_id').empty();
			        	if(call_status != -1 )
		        		{
		        			//console.log( obj_data.output )
		        			var mgr_arr =obj_data.output.manager_id;
                                                var ind_mgr_arr =obj_data.output.ind_manager_id;
                                                var security_person_arr = obj_data.output.security_person_id;
                                                 jQuery('#manager_id').append( $('<option></option>').val("").html("") );
                                                 jQuery('#ind_manager_id').append( $('<option></option>').val("").html("") );
                                                 jQuery('#security_person_id').append( $('<option></option>').val("").html("") );
		        			if(mgr_arr.length){
			        			$.each(mgr_arr, function(i, item) {
								    jQuery('#manager_id').append( $('<option></option>').val(item.guid).html(item.name) )
								});
			        			//$.each(mgr_arr, function(i, item) {
							//	    jQuery('#whs_manager_id').append( $('<option></option>').val(item.guid).html(item.name) )
							//	});                                                               
                                                        $.each(ind_mgr_arr, function(i, item) {
								    jQuery('#ind_manager_id').append( $('<option></option>').val(item.guid).html(item.name) )
								});
                                                        $.each(security_person_arr, function(i, item) {
								    jQuery('#security_person_id').append( $('<option></option>').val(item.guid).html(item.name) )
								});
                                                                }
			        		 jQuery(".prj_company_id_err").html("");
		        		} else {
		        			//alert(obj_data.system_messages.error);
		        			jQuery(".prj_company_id_err").html(obj_data.system_messages.error[0]);	        			
		        		}		        	
		        	}
			    })
			    .fail(function() {
			      //alert( "error" );
			    })
			    .always(function() {
			      //alert( "complete" );			    	
			    });
		  }
            }
        })
       
                 
  //  document.getElementById("uploadBtn").onchange = function () {
   // document.getElementById("uploadFile").value = this.value;
//};
    
     jQuery("#btn_material_type_save").live("click", function (event) {	
		var material_type_flg = true;          
                if(jQuery('#material_title').val() != "")
		  {
			var postData = "title="+jQuery('#material_title').val();
			if(jQuery('#guid').length && jQuery('#guid').val() != "")
			    {
			   	postData = postData + "&guid="+jQuery('#guid').val();
			    }
			var __elgg_ts =	elgg.security.token.__elgg_ts;
			var __elgg_token =	elgg.security.token.__elgg_token;
			jQuery.ajax( {
			    	type: "POST",
			    	url : '/action/sytick/ajax/home',
			    	data : postData+"&process=titleuniquechk&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,                                
                                }).done(function(data){
			        if(data)
		        	{
			        	var obj_data = jQuery.parseJSON( data );
			        	var call_status = obj_data.output.namestatus;
			        	if(call_status != -1 )
		        		{
			        		 jQuery(".material_type_name_err").html("");
		        		} else {
		        			jQuery(".material_type_name_err").html("Title already taken");	        			
                                                material_type_flg = false;
		        		}	        	
		        	}
			    })
		  }        
		if( jQuery('#material_title').val() == null || jQuery('#material_title').val() == ""){
			jQuery(".material_type_name_err").html(elgg.echo("material_type:name:error"));
			material_type_flg = false;
		} else {
			jQuery(".material_type_name_err").html("");
		}
		if( jQuery('#perimeter').val() == ""){
			jQuery(".perimeter_err").html(elgg.echo("material_type:perimeter:error"));
			material_type_flg = false;
		} else {
			jQuery(".perimeter_err").html("");
		}
                if( !$.isNumeric(jQuery('#perimeter').val()) || jQuery('#perimeter').val() <= 0 ){
			jQuery(".perimeter_err").html(elgg.echo("paint:price:notnumber:error"));
			material_type_flg = false;
		} else {
			jQuery(".perimeter_err").html("");
		}
                if( !$.isNumeric(jQuery('#price').val()) || jQuery('#price').val() < 0 ){
			jQuery(".price_err").html(elgg.echo("paint:price:notnumber:error"));
			material_type_flg = false;
		} else {
			jQuery(".price_err").html("");
		}
		if(material_type_flg  == false)
		{
			event.preventDefault();
			return false;
		} 
	});
        
        jQuery("#btn_item_save").live("click", function (event) {	
		var item_flg = true;
                if( jQuery('#inventory_type').val() == null || jQuery('#inventory_type').val() == ""){
			jQuery(".inventory_type_err").html(elgg.echo("inventory_type:error"));
			item_flg = false;
		} else {
			jQuery(".inventory_type_err").html("");
		}
                if( jQuery('#item_code').val() == null || jQuery('#item_code').val() == ""){
			jQuery(".item_code_err").html(elgg.echo("item:code:error"));
			item_flg = false;
		} else {
			jQuery(".item_code_err").html("");
		}
                if( jQuery('#item_name').val() == null || jQuery('#item_name').val() == ""){
			jQuery(".item_name_err").html(elgg.echo("item:name:error"));
			item_flg = false;
		} else {
			jQuery(".item_name_err").html("");
		}
                if( jQuery('#item_length').val() == null || jQuery('#item_length').val() == ""){
			jQuery(".item_length_err").html(elgg.echo("item:length:error"));
			item_flg = false;
		} else {
			jQuery(".item_length_err").html("");
		}
                if( !$.isNumeric(jQuery('#item_length').val()) || jQuery('#item_length').val() <= 0 ){
			jQuery(".item_length_err").html(elgg.echo("paint:price:notnumber:error"));
			item_flg = false;
		} else {
			jQuery(".item_length_err").html("");
		}
                if( !$.isNumeric(jQuery('#item_weight').val()) || jQuery('#item_weight').val() <= 0 ){
			jQuery(".item_weight_err").html(elgg.echo("paint:price:notnumber:error"));
			item_flg = false;
		} else {
			jQuery(".item_weight_err").html("");
		}
		if( jQuery('#item_price').val() == ""){
			jQuery(".item_price_err").html(elgg.echo("paint:price:error"));
			item_flg = false;
		} else {
			jQuery(".item_price_err").html("");
		}
                if( !$.isNumeric(jQuery('#item_price').val()) || jQuery('#item_price').val() <= 0 ){
			jQuery(".item_price_err").html(elgg.echo("paint:price:notnumber:error"));
			item_flg = false;
		} else {
			jQuery(".item_price_err").html("");
		}
		if(item_flg  == false)
		{
                        event.preventDefault();
			return false;
		} 
	});
        
        
        jQuery("#btn_paint_used_save").live("click", function (event) {	
		var paint_flg = true;
		if( jQuery('#paint_name').val() == null || jQuery('#paint_name').val() == ""){
			jQuery(".paint_id_name_err").html("Select a valid paint.");
			paint_flg = false;
		} else {
			jQuery(".paint_id_name_err").html("");
		}
                if( jQuery('#paint_name').val() == null || jQuery('#paint_name').val() == ""){
			jQuery(".paint_id_name_err").html("Select a valid paint.");
			paint_flg = false;
		} else {
			jQuery(".paint_id_name_err").html("");
		}
                if( parseInt(jQuery('#paint_amount').val()) > parseInt(jQuery('#paint_quantity').val()) ){
                        jQuery(".paint_amount_err").html('Amount used cannot be greater than current stock.');
                        paint_flg = false;
                } else {
                        jQuery(".paint_amount_err").html("");
                }
                if( !$.isNumeric(jQuery('#paint_amount').val()) || jQuery('#paint_amount').val() < 0 ){
			jQuery(".paint_amount_err").html(elgg.echo("paint:price:notnumber:error"));
			paint_flg = false;
		} else if(paint_flg){
			jQuery(".paint_amount_err").html("");
		}
                if( !$.isNumeric(jQuery('#paint_amount1').val()) || jQuery('#paint_amount1').val() < 0 ){
			jQuery(".paint_amount_err").html(elgg.echo("paint:price:notnumber:error"));
			paint_flg = false;
		} else if(paint_flg){
			jQuery(".paint_amount_err").html("");
		}
		if(paint_flg  == false){
                    event.preventDefault();
                    return false;
		} 
	});

          jQuery("#btn_paint_save").live("click", function (event) {	
		var paint_flg = true;
		if( jQuery('#paint_name').val() == null || jQuery('#paint_name').val() == ""){
			jQuery(".paint_name_err").html(elgg.echo("paint:name:error"));
			paint_flg = false;
		} else {
			jQuery(".paint_name_err").html("");
		}
                if( jQuery('#paint_id').val() == null || jQuery('#paint_id').val() == ""){
			jQuery(".paint_id_err").html(elgg.echo("paint:id:error"));
			paint_flg = false;
		} else {
			jQuery(".paint_id_err").html("");
		}
                if( jQuery('#paint_color').val() == null || jQuery('#paint_color').val() == ""){
			jQuery(".paint_color_err").html(elgg.echo("paint:color:error"));
			paint_flg = false;
		} else {
			jQuery(".paint_color_err").html("");
		}
		if( jQuery('#paint_price').val() == ""){
			jQuery(".paint_price_err").html(elgg.echo("paint:price:error"));
			paint_flg = false;
		} else {
			jQuery(".paint_price_err").html("");
		}
                if( !$.isNumeric(jQuery('#paint_price').val()) || jQuery('#paint_price').val() <= 0 ){
			jQuery(".paint_price_err").html(elgg.echo("paint:price:notnumber:error"));
			paint_flg = false;
		} else {
			jQuery(".paint_price_err").html("");
		}
                if( !$.isNumeric(jQuery('#paint_quantity').val()) || jQuery('#paint_quantity').val() < 0 ){
			jQuery(".paint_quantity_err").html(elgg.echo("paint:price:notnumber:error"));
			paint_flg = false;
		} else {
			jQuery(".paint_quantity_err").html("");
		}
                if(jQuery('#paint_additional').length > 0){
                    if( !$.isNumeric(jQuery('#paint_additional').val()) || jQuery('#paint_additional').val() < 0 ){
                        jQuery(".paint_additional_err").html(elgg.echo("paint:price:notnumber:error"));
                        paint_flg = false;
                    } else {
                        jQuery(".paint_additional_err").html("");
                    }
                }
                if( !$.isNumeric(jQuery('#alert_threshold').val()) || jQuery('#alert_threshold').val() < 0 ){
                    jQuery(".alert_threshold_err").html(elgg.echo("paint:price:notnumber:error"));
                    paint_flg = false;
                } else {
                    jQuery(".alert_threshold_err").html("");
                }
		if(paint_flg  == false){
                    event.preventDefault();
                    return false;
		} 
	});
              
          jQuery("#btn_paint_project_save").live("click", function (event) {	
		var paint_flg = true;
		if( jQuery('#paint_project_name').val() == null || jQuery('#paint_project_name').val() == ""){
			jQuery(".paint_name_err").html(elgg.echo("paint:name:error"));
			paint_flg = false;
		} else {
			jQuery(".paint_name_err").html("");
		}
                if( jQuery('#material_id').val() == null || jQuery('#material_id').val() == ""){
			jQuery(".material_id_err").html(elgg.echo("No option choosed."));
			paint_flg = false;
		} else {
			jQuery(".material_id_err").html("");
		}
                if( !$.isNumeric(jQuery('#nopieces').val()) || jQuery('#nopieces').val() <= 0 ){
			jQuery(".nopieces_err").html(elgg.echo("paint:price:notnumber:error"));
			paint_flg = false;
		} else {
			jQuery(".nopieces_err").html("");
		}
                if( !$.isNumeric(jQuery('#lengthperpiece').val()) || jQuery('#lengthperpiece').val() < 0 ){
			jQuery(".lengthperpiece_err").html(elgg.echo("paint:price:notnumber:error"));
			paint_flg = false;
		} else {
			jQuery(".lengthperpiece_err").html("");
		}
		if(paint_flg  == false)
		{
			event.preventDefault();
			return false;
		} 
	});
	
	  jQuery("#btn_project_save").live("click", function (event) {	
		var proj_flg = true;
		
		if( jQuery('#project_name').val() == ""){
			jQuery(".project_name_err").html(elgg.echo("project:title:error"));
			proj_flg = false;
		} else {
			jQuery(".project_name_err").html("");
		}
		if( jQuery('#customer').val() == ""){
			jQuery(".customer_err").html(elgg.echo("project:cusotmer:error"));
			proj_flg = false;
		} else {
			jQuery(".customer_err").html("");
		}
                if( jQuery('#start_date').val() == ""){
			jQuery(".start_date_err").html(elgg.echo("project:start_date:error"));
			proj_flg = false;
		} else {
			jQuery(".start_date_err").html("");
		}
		if( jQuery('#final_date').val() == ""){
			jQuery(".final_date_err").html(elgg.echo("project:final_date:error"));
			proj_flg = false;
		} else {
			jQuery(".final_date_err").html("");
		}                
		if(proj_flg  == false)
		{
			event.preventDefault();
			return false;
		} 
	});
        
        
	jQuery('#frm_project').ajaxForm({
	    success: function(data) {
	        //console.log(data);
	        if(data)
        	{
	        	var obj_data = jQuery.parseJSON( data );
	        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
	        	if(call_status != -1 )
        		{
        			//show_messages(obj_data.system_messages.success);
        			window.location.href = "/project/all";
        		} else {        			     
        			if(obj_data.output.error_field){
        				var field = obj_data.output.error_field;
        				jQuery("."+field+"_err").html(obj_data.system_messages.error[0]);        				
        			} else {
        				show_messages(obj_data.system_messages.error);
        			}		
        		}		        	
        	}
	    },
		beforeSend: function( xhr ) {
	    	jQuery('#btn_project_save').attr("disabled","disabled");
		    jQuery('.ajx-submit-load').removeClass('disp-none');
		},
		complete: function(xhr) {
			jQuery('#btn_project_save').removeAttr("disabled");
			jQuery('.ajx-submit-load').addClass('disp-none');
		}
	});
	
	function project_search(){
		if( jQuery('#s').val() != ""){
			window.location.href = "/project/all?s="+encodeURIComponent(jQuery('#s').val())
		} else{
           window.location.href = "/project/all";
        }
	}
	
	jQuery("#btn_prj_filter").live("click", function (event) {	
		project_search();	
	});
        function in_out_search(){
                var urldoc =  document.URL;
                if(urldoc.indexOf('?') === -1)
                    {   
                    }
                else{
                         var location = $.inArray('?',urldoc);
                         urldoc = urldoc.substr(0, location );    
                    }
               
		if( jQuery('#s').val() != ""){
			window.location.href = urldoc + "?s="+encodeURIComponent(jQuery('#s').val())
		} else{
                        window.location.href = urldoc;
                    }
	}
	
	jQuery("#btn_in_out_filter").live("click", function (event) {	
		in_out_search();	
	});
        jQuery("#frm_in_out_search").live("submit", function (event) {	
		in_out_search();	
		event.preventDefault();
		return false;	
	});
        	
    function paint_search(){
		if( jQuery('#s').val() != ""){
			window.location.href = "/paint/all?s="+encodeURIComponent(jQuery('#s').val())
		} else{
            window.location.href = "/paint/all";
        }
	}
    function painting_project_search(){
		if( jQuery('#s').val() != ""){
			window.location.href = "/painting_project/all?s="+encodeURIComponent(jQuery('#s').val())
		} else{
            window.location.href = "/painting_project/all";
        }
	}
        
    jQuery("#btn_paint_filter").live("click", function (event) {	
		paint_search();	
	});
        
    jQuery("#btn_painting_project_filter").live("click", function (event) {	
		painting_project_search();	
	});
        
        
    function material_type_search(){
		if( jQuery('#s').val() != ""){
			window.location.href = "/material_type/all?s="+encodeURIComponent(jQuery('#s').val())
		} else{
            window.location.href = "/material_type/all";
        }
	}
        
    jQuery("#btn_material_type_filter").live("click", function (event) {	
		material_type_search();	
	});
        

    function company_search(){
		if( jQuery('#s').val() != ""){
			window.location.href = "/company/all?s="+encodeURIComponent(jQuery('#s').val())
		} else{
           window.location.href = "/company/all";
        }
	}
        
    jQuery("#btn_company_filter").live("click", function (event) {	
		company_search();	
	});
              
	jQuery("#frm_projects_search").live("submit", function (event) {	
		project_search();	
		event.preventDefault();
		return false;	
	});
	
	jQuery("#btn_employee_save").live("click", function (event) {	
		var employee_flg = true; 
		if( jQuery('#custom_profile_type').val() == ""){
			jQuery(".custom_profile_type_err").html(elgg.echo("employee:role:error"));
			employee_flg = false;
		} else {
			jQuery(".custom_profile_type_err").html("");
		}
		if( jQuery('#name').val() == ""){
			jQuery(".name_err").html(elgg.echo("employee:name:error"));
			employee_flg = false;
		} else {
			jQuery(".name_err").html("");
		}
		if( jQuery('#employee_email').val() == ""){
			jQuery(".employee_email_err").html(elgg.echo("registration:notemail"));
			employee_flg = false;
		} else {
			jQuery(".employee_email_err").html("");
		}
		var email = jQuery('#employee_email').val();
		if( validate_email(email)){
			jQuery(".employee_email_err").html("");			
		} else {
			jQuery(".employee_email_err").html(elgg.echo("registration:notemail"));
			employee_flg = false;
		}
		if( jQuery('#street1').val() == ""){
			jQuery(".street1_err").html(elgg.echo("company:street_address:error"));
			employee_flg = false;
		} else {
			jQuery(".street1_err").html("");
		}
		if( jQuery('#town').val() == ""){
			jQuery(".town_err").html(elgg.echo("profile:townerror"));
			employee_flg = false;
		} else {
			jQuery(".town_err").html("");
		}
		if( jQuery('#state').val() == ""){
			jQuery(".state_err").html(elgg.echo("profile:stateerror"));
			employee_flg = false;
		} else {
			jQuery(".state_err").html("");
		}
		if( jQuery('#postcode').val() == ""){
			jQuery(".postcode_err").html(elgg.echo("profile:postcodeerror"));
			employee_flg = false;
		} else {
			jQuery(".postcode_err").html("");
		}
		if( jQuery('#company_id').val() == ""){
			show_messages(elgg.echo("manager:company:error"))
			employee_flg = false;
		} 
		jQuery( ".error_msg" ).each(function( index ) {
			  //console.log( index + ": " + $( this ).html() );
			  var str = jQuery( this ).html();
			  var newStr = str.replace(/\s+/g, '');
			  if(newStr != "" )
			  {
				  employee_flg = false; 
			  }			  
		  });
		if(employee_flg  == false)
		{
			//console.log("err");
			event.preventDefault();
			return false;
		} else {
			//console.log("submit");
			jQuery(this).closest('form').submit();			 
		}
	});
	
	jQuery("#employee_email").live("blur", function (event) {
		  if(jQuery(this).val() != "")
		  {
			   	var postData = jQuery(this).attr('id')+"="+ encodeURIComponent(jQuery(this).val());
			   	if(jQuery('#guid').length && jQuery('#guid').val() != "")
			   	{
			   		postData = postData + "&guid="+jQuery('#guid').val();
			   	}
			   	if(jQuery('#company_id').length && jQuery('#company_id').val() != "")
			   	{
			   		postData = postData + "&company_id="+jQuery('#company_id').val();
			   	}
			   	var __elgg_ts =	elgg.security.token.__elgg_ts;
			 	var __elgg_token =	elgg.security.token.__elgg_token;
			    jQuery.ajax( {
			    	type: "POST",
			    	url : '/action/sytick/ajax/home',
			    	data : postData+"&process=employeeuniquechk&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,		
			    })
			    .done(function(data) {
			        //console.log( "success"+data );
			        if(data)
		        	{
			        	var obj_data = jQuery.parseJSON( data );
			        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
			        	if(call_status != -1 )
		        		{
			        		 jQuery(".employee_email_err").html("");
		        		} else {
		        			//alert(obj_data.system_messages.error);
		        			jQuery(".employee_email_err").html(obj_data.system_messages.error[0]);	        			
		        		}		        	
		        	}
			    })
			    .fail(function() {
			      //alert( "error" );
			    })
			    .always(function() {
			      //alert( "complete" );			    	
			    });
		  }	  
	  });
	
	
	
	var activate_employee_flg = true;
	jQuery("#btn_activate_employee").live("click", function (event) {
		var pass = jQuery( "#password" ).val();
		if(pass == "")
		{
			var class_str =  "password_err";
			jQuery("."+class_str).html(elgg.echo("resetpassword:password:blank"));
		}
		if( pass.length < 6 )
		{
			var class_str =  "password_err";
			jQuery("."+class_str).html(elgg.echo("resetpassword:password:blank"));
		}
		if(jQuery( "#password" ).val() !=  jQuery( "#password2" ).val())
		{
			var class_str =  "password2_err";
			jQuery("."+class_str).html(elgg.echo("user:password:fail:notsame"));
		}
		var flg = true;		  
	  	jQuery( ".error_msg" ).each(function( index ) {
		  //console.log( index + ": " + $( this ).html() );
		  var str = jQuery( this ).html();
		  var newStr = str.replace(/\s+/g, '');
		  if(newStr != "" )
		  {
			  flg = false; 
		  }			  
	  	});
		if( ( jQuery( "#password" ).val() != "" &&  jQuery( "#password2" ).val() != "")
			 && activate_employee_flg  && flg)
		  {
		  		activate_employee_flg = false;
			  	var obj_form = jQuery(this).closest('form');
			  	var postData = obj_form.serialize();
			    var formURL = '/action/sytick/ajax/home';
			    jQuery.ajax( {
			    	type: "POST",
			    	url : formURL,
			    	data : postData+"&process=activateemployee",		
			    })
			    .done(function(data) {
			        //console.log( "success"+data );
			        if(data)
		        	{
			        	var obj_data = jQuery.parseJSON( data );
			        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
			        	if(call_status != -1 )
		        		{
		        			show_messages(obj_data.system_messages.success);
		        			//alert(obj_data.system_messages.success); 
			        		var forward_url = (obj_data.output && obj_data.output.forward_url) ?  obj_data.output.forward_url :"";
			        		if(forward_url != "")
		        			{
			        			window.location.href = forward_url;
		        			}
			        		jQuery( "#password" ).val("");
		        			jQuery( "#password2" ).val("");		        			
		        		} else {
		        			show_messages(obj_data.system_messages.error);
		        			//var err = obj_data.system_messages.error;
		        			//jQuery("."+class_str).html(err[0]);        			
		        		}		        	
		        	}
			    })
			    .fail(function() {
			      //alert( "error" );
			    })
			    .always(function() {
			      //alert( "complete" );	
			      activate_employee_flg = true;		    	
			    });
		  }
		event.preventDefault();
	});
	
	function inductionmanager_search(){
		if( jQuery('#s').val() != ""){
			window.location.href = "/inductionmanager/all?s="+encodeURIComponent(jQuery('#s').val())
		}else{
        	 window.location.href = "/inductionmanager/all";
        }
	}
	
	jQuery("#btn_inductionmanager_filter").live("click", function (event) {	
		inductionmanager_search();	
	});
	
	jQuery("#frm_inductionmanager_search").live("submit", function (event) {	
		inductionmanager_search();	
		event.preventDefault();
		return false;	
	});
	
	function sitemanager_search(){
		if( jQuery('#s').val() != ""){
			window.location.href = "/sitemanager/all?s="+encodeURIComponent(jQuery('#s').val())
		} else{
          window.location.href = "/sitemanager/all";
       }
	}
	
	jQuery("#btn_sitemanager_filter").live("click", function (event) {	
		sitemanager_search();	
	});
	
	jQuery("#frm_sitemanager_search").live("submit", function (event) {	
		sitemanager_search();	
		event.preventDefault();
		return false;	
	});
	
	function contractor_search(){
		if( jQuery('#s').val() != ""){
			window.location.href = "/contractor/all?s="+encodeURIComponent(jQuery('#s').val())
		} else {
          window.location.href = "/contractor/all";
        }
	}
	
	jQuery("#btn_contractor_filter").live("click", function (event) {	
		contractor_search();	
	});
	
	jQuery("#frm_contractor_search").live("submit", function (event) {	
		contractor_search();	
		event.preventDefault();
		return false;	
	});
        function employee_search(){
		if( jQuery('#s').val() != ""){
			window.location.href = "/employee/all?s="+encodeURIComponent(jQuery('#s').val())
		} else {
          window.location.href = "/employee/all";
        }
	}
	
	jQuery("#btn_employee_filter").live("click", function (event) {	
		employee_search();	
	});
	
	jQuery("#frm_employee_search").live("submit", function (event) {	
		employee_search();	
		event.preventDefault();
		return false;	
	});
	
	
	jQuery("#btn_sites_save").live("click", function (event) {	
		var site_flg = true;
		if( jQuery('#sites_company_id').val()*1){
			jQuery(".sites_company_id_err").html("");
		} else {			
			jQuery(".sites_company_id_err").html(elgg.echo("manager:company:error"));
			site_flg = false;
		}
		//console.log(jQuery('#project_id').val());
		if( jQuery('#project_id').val()*1){
			jQuery(".project_id_err").html("");
		} else {			
			jQuery(".project_id_err").html(elgg.echo("site:project:error"));
			site_flg = false;
		}
		/*console.log(jQuery('#sitemanager_id').val()); 
		if( jQuery('#sitemanager_id').val() == null || jQuery('#sitemanager_id').val() == ""){
			jQuery(".sitemanager_id_err").html(elgg.echo("site:manager:error"));
			site_flg = false;
		} else {
			jQuery(".sitemanager_id_err").html("");
		}*/
		if( jQuery('#site_name').val() == ""){
			jQuery(".site_name_err").html(elgg.echo("project:title:error"));
			site_flg = false;
		} else {
			jQuery(".site_name_err").html("");
		}
		if(!(jQuery('#file_guid').length))
		{
			if( jQuery('#site_layout').val() == ""){
				jQuery(".site_layout_err").html(elgg.echo("site:layout:error"));
				site_flg = false;
			} else {
				jQuery(".site_layout_err").html("");
			}	
		}	
		/*console.log(jQuery('#documenttype_id').val());
		if( jQuery('#documenttype_id').val() == null || jQuery('#documenttype_id').val() == ""){
			jQuery(".documenttype_id_err").html(elgg.echo("site:documenttype:error"));
			site_flg = false;
		} else {
			jQuery(".documenttype_id_err").html("");
		}*/
		if(site_flg  == false)
		{
			event.preventDefault();
			return false;
		} 
	});
	jQuery('#frm_sites').ajaxForm({
	    success: function(data) {
	        //console.log(data);
	        if(data)
        	{
	        	var obj_data = jQuery.parseJSON( data );
	        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
	        	if(call_status != -1 )
        		{
        			//show_messages(obj_data.system_messages.success);
        			window.location.href = "/sites/all";
        		} else {        			     
        			if(obj_data.output.error_field){
        				var field = obj_data.output.error_field;
        				jQuery("."+field+"_err").html(obj_data.system_messages.error[0]);        				
        			} else {
        				show_messages(obj_data.system_messages.error);
        			}		
        		}		        	
        	}
	    },
		beforeSend: function( xhr ) {
	    	jQuery('#btn_sites_save').attr("disabled","disabled");
		    jQuery('.ajx-submit-load').removeClass('disp-none');
		},
		complete: function(xhr) {
			jQuery('#btn_sites_save').removeAttr("disabled");
			jQuery('.ajx-submit-load').addClass('disp-none');
		}
	});
	
	function sites_search(){
		if( jQuery('#s').val() != ""){
			window.location.href = "/sites/all?s="+encodeURIComponent(jQuery('#s').val())
		} else{
           window.location.href = "/sites/all";
        }
	}
	
	jQuery("#btn_sites_filter").live("click", function (event) {	
		sites_search();	
	});
	
	jQuery("#frm_sites_search").live("submit", function (event) {	
		sites_search();	
		event.preventDefault();
		return false;	
	});
        
        jQuery("#inventory_type_select").live("change", function (event) {
	         if(jQuery(this).val() != "" && jQuery(this).val() != "")
                    {
                        $("#item_name").next(".holder").html("");
                        var postData = "inventory_type="+jQuery(this).val();
                        var __elgg_ts =	elgg.security.token.__elgg_ts;
			var __elgg_token =	elgg.security.token.__elgg_token;
                        jQuery.ajax( {
			    type: "POST",
			    url : '/action/sytick/ajax/home',
			    data : postData+"&process=getItemsFromType&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,		
			}).done(function(data) {
			        //console.log( "success"+data );
			        if(data)
		        	{
			        	var obj_data = jQuery.parseJSON( data );
			        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
			        	jQuery('#item_name').empty();
			        	if(call_status != -1 )
		        		{	        			
		        			var roles_arr =obj_data.output.roles;
		        			if(roles_arr.length){
                                                jQuery('#item_name').append( $('<option></option>').val("").html("") )
			        			$.each(roles_arr, function(i, item) {
                                                                    console.log(item);
                                                                    console.log(item.title);
								    jQuery('#item_name').append( $('<option></option>').val(item.guid).html(item.title) );
								});
							}
		        		} else {
		        			alert(obj_data.system_messages.error);
		        		}		        	
		        	}
			    });    
                    }
        
         });
         
        jQuery("#paint_id_name").on("change", function (event) {
	         if(jQuery(this).val() != "")
                    {
                        $("#item_name").next(".holder").html("");
                        var postData = "paint_guid="+jQuery(this).val();
                        var __elgg_ts =	elgg.security.token.__elgg_ts;
			var __elgg_token =	elgg.security.token.__elgg_token;
                        jQuery.ajax( {
			    type: "POST",
			    url : '/action/sytick/ajax/home',
			    data : postData+"&process=get_paint_details&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,		
			}).done(function(data) {
			        if(data){
			        	var obj_data = jQuery.parseJSON( data );
			        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
			        	if(call_status != -1 ){	        			
		        			$("#paint_name").val(obj_data.output.paint_name);
                                                $("#paint_id").val(obj_data.output.paint_id);
                                                $("#paint_color").val(obj_data.output.colour);
                                                $("#paint_quantity").val(obj_data.output.quantity);
		        		} else {
                                                $(".paint_id_name_err").text("You may have lost your connection.");
		        			$("#paint_name").val("");
                                                $("#paint_id").val("");
                                                $("#paint_color").val("");
                                                $("#paint_quantity").val("");
		        		}		        	
		        	}
			    });    
                    }else{
                        $("#paint_name").val("");
                        $("#paint_id").val("");
                        $("#paint_color").val("");
                        $("#paint_quantity").val("");
                    }
         });
         
         jQuery(".respond_alert").on("click", function(){
            var alert =  $(this).attr("data-guid");
            if($(this).text() == "No"){
                $(this).text("Yes");
            
            var postData = "alert="+alert;
            var __elgg_ts = elgg.security.token.__elgg_ts;
            var __elgg_token =	elgg.security.token.__elgg_token;
                        jQuery.ajax( {
			    type: "POST",
			    url : '/action/sytick/ajax/home',
			    data : postData+"&process=change_alert_response&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,		
			}).done(function(data) {
			        if(data){
                                    var obj_data = jQuery.parseJSON( data );
                                    var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
                                    if(call_status != -1 ){	        			
                                  
                                    }		        	
		        	}
			    });  
              }
         });
         
	jQuery("#sites_company_id, #quest_company_id, #induct_company_id").live("change", function (event) {
		  if(jQuery(this).val() != "" && elgg.is_admin_logged_in())
		  {
                                $("#project_id").next(".holder").html("");
			   	var postData = "company_id="+jQuery(this).val();
			   	if(jQuery('#guid').length && jQuery('#guid').val() != "")
			   	{
			   		postData = postData + "&guid="+jQuery('#guid').val();
			   	}
			   	var __elgg_ts =	elgg.security.token.__elgg_ts;
			 	var __elgg_token =	elgg.security.token.__elgg_token;
			    jQuery.ajax( {
			    	type: "POST",
			    	url : '/action/sytick/ajax/home',
			    	data : postData+"&process=getsitesformfields&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,		
			    })
			    .done(function(data) {
			        //console.log( "success"+data );
			        if(data)
		        	{
			        	var obj_data = jQuery.parseJSON( data );
			        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
			        	jQuery('#project_id').empty();
			        	if(jQuery("#admin_sitemanager").length) jQuery('#admin_sitemanager').empty();
			        	if(call_status != -1 )
		        		{
		        			//console.log( obj_data.output )
                                                jQuery('#project_id').append( $('<option></option>').val("").html("") );
		        			var mgr_arr =obj_data.output.project_id;
		        			if(mgr_arr.length){
			        			$.each(mgr_arr, function(i, item) {
								    jQuery('#project_id').append( $('<option></option>').val(item.guid).html(item.name) )
								});
							}
							var sitemgr_field = obj_data.output.sitemanger_field;
			        		if(jQuery("#admin_sitemanager").length) jQuery("#admin_sitemanager").append(sitemgr_field);
		        		} else {
		        			alert(obj_data.system_messages.error);
		        			//jQuery(".sites_company_id_err").html(obj_data.system_messages.error[0]);	        			
		        		}		        	
		        	}
			    })
			    .fail(function() {
			      //alert( "error" );
			    })
			    .always(function() {
			      //alert( "complete" );			    	
			    });
		  }	  
	  });
	  
	  jQuery("#btn_change_password").live("click", function (event) {	
			var chng_pass_flg = true;	
	        var crnt_pswd = jQuery('#current_password').val();
	        var new_pswd = jQuery('#password').val();
	        var rpt_pswd = jQuery('#password2').val();
			if( crnt_pswd == ""){
				jQuery(".current_password_err").html(elgg.echo("change_pswd:error:crnt_pswd:empty"));
				chng_pass_flg = false;
			} else {
				jQuery(".current_password_err").html("");
			}
			if( new_pswd == ""){
				jQuery(".new_password_err").html(elgg.echo("change_pswd:error:new_pswd:empty"));
				chng_pass_flg = false;
			} else {
				jQuery(".new_password_err").html("");
			}			
			if( rpt_pswd == ""){				
				jQuery(".repeat_password_err").html(elgg.echo("change_pswd:error:rpt_pswd:empty"));				
				chng_pass_flg = false;
			} else {
				if( rpt_pswd != new_pswd){
					jQuery(".repeat_password_err").html(elgg.echo("change_pswd:error:pswd_mismatch"));
					chng_pass_flg = false;
				} else {
					jQuery(".repeat_password_err").html("");
				}
			}
			
	        if(chng_pass_flg  == false)
			{
				event.preventDefault();
				return false;
			}
	});
	
    jQuery("#prj_wrkrs_add").live("click", function (event) {	
        jQuery('#contracting_company_id').val("");      
		if(jQuery("#dv_prj_mangrs").length) jQuery('#dv_prj_mangrs').empty();
        if(jQuery("#dv_contractors").length) jQuery('#dv_contractors').empty();
		$('#wrkrs_add_popup').modal();	
	});
        
        
	var attend_flg = false;
	jQuery(".attend-questionnaire").live("click", function (event) {
		attend_questionnaire( jQuery(this).attr('data:guid'));		
	});
	
	function attend_questionnaire(guid)
	{
		if(attend_flg) { return false;}
		attend_flg	= true;			
		var postData = "guid="+ guid;
	   	var __elgg_ts =	elgg.security.token.__elgg_ts;
	 	var __elgg_token =	elgg.security.token.__elgg_token;
	 	jQuery.ajax( {
	    	type: "POST",
	    	url : '/action/sytick/ajax/home',
	    	data : postData+"&process=attendquestionnaire&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,		
	    })
	    .done(function(data) {
	        //console.log( "success"+data );
	        if(data)
        	{
        		jQuery("#attendQuestion").empty();
	        	var obj_data = jQuery.parseJSON( data );
	        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
	        	if(call_status != -1 )
        		{
        			jQuery('#ques_nos').show();
        			//console.log(obj_data.output.question_type);
        		   jQuery("#attendQuestion").append(obj_data.output.question_html);
        		   //console.log(jQuery("#question_type_"+obj_data.output.question_type));
        		   jQuery("#question_type_"+obj_data.output.question_type).css("display","block");        		   
        		   if(obj_data.output.nos && jQuery('#curr_ques').length){
        		   		jQuery('#curr_ques').html(obj_data.output.nos);
        		   }
        		   if(obj_data.output.total_cnt && jQuery('#total_ques').length){
        		   		jQuery('#total_ques').html(obj_data.output.total_cnt);
        		   }
        		   $('#myAttendQuestionModal').modal({backdrop:'static'});				      			
        		} else {
        			show_messages(elgg.echo("question:error:cannot_attend"));        			     			
        		}		        	
        	}
	    })
	    .fail(function() {
	      //alert( "error" );
	    })
	    .always(function() {
	      //alert( "complete" );	
	      attend_flg= false;		    	
	    });
	}
	
	var next_quest_flg = false;
	jQuery("#btn_quest_attend").live("click", function (event) {
		var next_question_flg = true;	
		if(jQuery('#attend_question_type').val() == 1) {
			//condition for multiple answer
			//console.log($('input[type="checkbox"]').length);
			//console.log($('input[type="checkbox"]:checked').length );
			//console.log($('#question_type_1  input:text').length);
			if($('input[type="checkbox"]:checked').length ==0 ) {
				jQuery(".question_type_1_err").html(elgg.echo("question:multiple:type:answer:error"));
				next_question_flg = false;
			} 
		} else if(jQuery('#attend_question_type').val() == 2) {
			// condition for yes/no option
			//console.log($('input[type="radio"]').length);
			//console.log($('input[type="radio"]:checked').length );
			//console.log($('#question_type_2  input:text').length);
			if($('input[type="radio"]:checked').length ==0 ) {
				jQuery(".question_type_2_err").html(elgg.echo("question:multiple:type:answer:error"));
				next_question_flg = false;
			} else {
				jQuery(".question_type_2_err").html("");
			}
		}		
		if(next_question_flg  == false)
		{
			return false;
		}
		if(next_quest_flg) { return false;}
		next_quest_flg = true;		
		var obj_form = jQuery("#frm_take_test");
	  	var postData = obj_form.serialize();
	    var formURL = obj_form.attr('action');
	    jQuery.ajax( {
	    	type: "POST",
	    	url : '/action/sytick/ajax/home',
	    	data : postData+"&process=taketest",		
	    })
	    .done(function(data) {
	        //console.log( "success"+data );
	        if(data)
        	{
        		jQuery("#attendQuestion").empty();
	        	var obj_data = jQuery.parseJSON( data );
	        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
	        	if(call_status != -1 )
        		{
	        		//var succ = obj_data.system_messages.success;
	        		  jQuery('#ques_nos').show();
	        		   if(obj_data.output.is_complete){        		   		
	        		   		jQuery('#ques_nos').hide();
	        		   }
	        		   if(obj_data.output.nos && jQuery('#curr_ques').length){
	        		   		jQuery('#curr_ques').html(obj_data.output.nos);
	        		   }
	        		   if(obj_data.output.total_cnt && jQuery('#total_ques').length){
	        		   		jQuery('#total_ques').html(obj_data.output.total_cnt);
	        		   }
	        		jQuery("#attendQuestion").append(obj_data.output.question_html);
        		   jQuery("#question_type_"+obj_data.output.question_type).css("display","block");
					     			
        		} else {
        			show_messages(obj_data.system_messages.error);
        			//var err = obj_data.system_messages.error;        			        			
        		}		        	
        	}
	    })
	    .fail(function() {
	      //alert( "error" );
	    })
	    .always(function() {
	      //alert( "complete" );
	      next_quest_flg = false;			    	
	    });
		event.preventDefault();	
	});
	
	jQuery("#btn_induction_save").live("click", function (event) {	
		var induction_flg = true;
		if( jQuery('#induct_company_id').val()*1){
			jQuery(".induct_company_id").html("");
		} else {			
			jQuery(".induct_company_id_err").html(elgg.echo("manager:company:error"));
			induction_flg = false;
		}
		//console.log(jQuery('#project_id').val());
		if( jQuery('#project_id').val()*1){
			jQuery(".project_id_err").html("");
		} else {			
			jQuery(".project_id_err").html(elgg.echo("site:project:error"));
			induction_flg = false;
		}
		if( jQuery('#induction_name').val() == ""){
			jQuery(".induction_name_err").html(elgg.echo("induction:title:error"));
			induction_flg = false;
		} else {
			jQuery(".induction_name_err").html("");
		}	
		if($('input[type="checkbox"]:checked').length ==0 ) {
			jQuery(".role_id_err").html(elgg.echo("induction:role:error"));
			induction_flg = false;
		} else {
			jQuery(".role_id_err").html("");
		}
                
		if(induction_flg  == false)
		{
			event.preventDefault();
			return false;
		} 
	});
	
	function induction_search(){
		if( jQuery('#s').val() != ""){
			window.location.href = "/induction/all?s="+encodeURIComponent(jQuery('#s').val())
		} else{
           window.location.href = "/induction/all";
        }
	}
	
	
	jQuery("#btn_induct_filter").live("click", function (event) {	
		induction_search();	
	});
	
	    
	jQuery("#frm_induction_search").live("submit", function (event) {	
		induction_search();	
		event.preventDefault();
		return false;	
	});
	
	
	jQuery(".ind-down-sort").live("click", function (event) {	
		re_order_screen(jQuery(this).attr('data:guid'), jQuery(this).attr('data:induction:guid'), jQuery(this).attr('data:order'),0 );	
	});
	
	
	jQuery(".ind-upsort-sort").live("click", function (event) {	
		re_order_screen(jQuery(this).attr('data:guid'), jQuery(this).attr('data:induction:guid'), jQuery(this).attr('data:order'),1);	
	});
	var re_order_ind_flg = true;
	function re_order_screen(guid, induction_guid, order, type){
		if(re_order_ind_flg = false ) return false;
		re_order_ind_flg = false;
		var postData = "guid="+ guid;
		postData += "&induction_guid="+ induction_guid;
		postData += "&order="+ order;
		postData += "&type="+type;
	   	var __elgg_ts =	elgg.security.token.__elgg_ts;
	 	var __elgg_token =	elgg.security.token.__elgg_token;
	    jQuery.ajax( {
	    	type: "POST",
	    	url : '/action/sytick/ajax/home',
	    	data : postData+"&process=reorderscreen&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,		
	    })
	    .done(function(data) {
	        //console.log( "success"+data );
	        if(data)
        	{
	        	var obj_data = jQuery.parseJSON( data );
	        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
	        	if(call_status != -1 )
        		{        			
        			show_messages(elgg.echo("screen:order:success")); 
        			window.location.reload();       			
        		} else {
        			show_messages(elgg.echo("screen:error:cannot_order"));        			     			
        		}		        	
        	}
	    })
	    .fail(function() {
	      //alert( "error" );
	    })
	    .always(function() {
	      //alert( "complete" );	
	      re_order_ind_flg = true;		    	
	 	})
	}
	
	var attend_ind_flg	= false;	
	jQuery(".induction_attend").live("click", function (event) {	
		//alert(jQuery(this).attr('data:induction_guid'));
		attend_induction(jQuery(this).attr('data:induction_guid'));	
		event.preventDefault();
		return false;
	});
        
        jQuery(".induction_result").live("click", function (event) {	
		result_induction(jQuery(this).attr('data:induction_guid'));	
		event.preventDefault();
		return false;
	});
	
        
        
        function result_induction(induction_guid)
	{
		jQuery("#inductionResult").empty();
		var postData = "guid="+ induction_guid;
	   	var __elgg_ts =	elgg.security.token.__elgg_ts;
	 	var __elgg_token =	elgg.security.token.__elgg_token;
	 	jQuery.ajax( {
	    	type: "POST",
	    	url : '/action/sytick/ajax/home',
	    	data : postData+"&process=resultinduction&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,		
	    })
	    .done(function(data) {
	        if(data)
        	{
        		jQuery("#attendQuestion").empty();
	        	var obj_data = jQuery.parseJSON( data );
	        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
	        	if(call_status != -1 )
        		{
        			//console.log(data);	
        			if(obj_data.output.number_of_results)
        			{       
                                        jQuery("#inductionResult").append(obj_data.output.result_html);
                                        $('#myInductionResultModal').modal();
        				
        			} 	      			
        		} else {
        			var err = obj_data.system_messages.error; 
        			show_messages(err);          					
        			return false;  			     			
        		}		        	
        	}
	    });
	}
        

        
        
        
	function attend_induction(induction_guid)
	{
		if(attend_ind_flg) { return false;}
		attend_ind_flg	= true;			
		var postData = "guid="+ induction_guid;
	   	var __elgg_ts =	elgg.security.token.__elgg_ts;
	 	var __elgg_token =	elgg.security.token.__elgg_token;
	 	jQuery.ajax( {
	    	type: "POST",
	    	url : '/action/sytick/ajax/home',
	    	data : postData+"&process=attendinduction&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,		
	    })
	    .done(function(data) {
	        //console.log( "success"+data );
	        if(data)
        	{
        		jQuery("#attendQuestion").empty();
	        	var obj_data = jQuery.parseJSON( data );
	        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
	        	if(call_status != -1 )
        		{
        			//console.log(data);	
        			if(obj_data.output.is_screen_or_question == 1)
        			{
        				// show screens
        				//alert(1);
        				if(obj_data.output.resume_restart == 1) {
	        				bootbox.dialog({
							  message: elgg.echo("entity:resume_restart:body"),
							  title: elgg.echo("entity:resume_restart:title"),
							  buttons: {
							    resume: {
							      label: elgg.echo("entity:resume"),
							      className: "btn-resume",
							      callback: function() {
							        attend_screens( obj_data.output.induction_guid, obj_data.output.induction_name ,  obj_data.output.title, 2);
							      }
							    },
							    restart: {
							      label: elgg.echo("entity:restart"),
							      className: "btn-restart",
							      callback: function() {
							        attend_screens( obj_data.output.induction_guid, obj_data.output.induction_name ,  obj_data.output.title, 1);
							      }
							    }
							  }
							});
						} else { 
        					attend_screens( obj_data.output.induction_guid, obj_data.output.induction_name ,  obj_data.output.title, 0);
        				}
        				//attend_questionnaire( obj_data.output.induction_guid );
        			} else if(obj_data.output.is_screen_or_question == 2)
        			{
        				//alert(2);
        				// show Question
        				$.fancybox.cancel();
        				attend_questionnaire( obj_data.output.induction_guid );
        			} else {
        				//alert(3);
        				$.fancybox.cancel();
        				show_messages(elgg.echo("question:error:cannot_attend")); 
        				return false;  
        			}		      			
        		} else {
        			var err = obj_data.system_messages.error; 
        			show_messages(err);          					
        			return false;  			     			
        		}		        	
        	}
	    })
	    .fail(function() {
	      //alert( "error" );
	    })
	    .always(function() {
	      //alert( "complete" );	
	      attend_ind_flg= false;		    	
	    });
	}
	
	var is_quest_flg = true;
	function attend_screens(induction_guid, induction_name, title, resume_restart_flg)
	{
		prev_url = "/induction/attend/"+induction_name;	
		if(resume_restart_flg == 1)	
		{
			prev_url = prev_url+"?restart=1"
		} else if(resume_restart_flg == 2)	
		{
			prev_url = prev_url+"?restart=2"
		}
		$.fancybox.open([	 
		{ 
			href :prev_url 	 
		}],	 
		{	 
			width		: '100%',
			height		: '100%',
			//maxWidth	: 1024,
			//maxHeight	: 768,	 
			type   : 'iframe',                        
			fitToView : true,	 
		 	autoSize : false, 
		 	closeBtn	: false,
		 	helpers : {
				overlay : {closeClick : false}
			},
			'afterClose' : function () {
				//attend_questionnaire( induction_guid );	
			}	 
		});
	}
	
	jQuery("#contracting_company_id").live("change", function (event) {
		  if(jQuery(this).val() != "")
		  {
			   	var postData = "company_guid="+jQuery(this).val();	
		   		if(jQuery("#project_guid").val() != "")
			   	{
			   		postData = postData + "&project_guid=" + jQuery("#project_guid").val();
			   	}		   	
			   	var __elgg_ts =	elgg.security.token.__elgg_ts;
			 	var __elgg_token =	elgg.security.token.__elgg_token;			 	
			    jQuery.ajax( {
			    	type: "POST",
			    	url : '/action/sytick/ajax/home',
			    	data : postData+"&process=getaddworkerformfields&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,		
			    })
			    .done(function(data) {
			        //console.log( "success"+data );
			        if(data)
		        	{
			        	var obj_data = jQuery.parseJSON( data );
			        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
			        	if(jQuery("#dv_prj_mangrs").length) jQuery('#dv_prj_mangrs').empty();
			        	if(jQuery("#dv_contractors").length) jQuery('#dv_contractors').empty();
			        	if(call_status != -1 )
		        		{		        			
							var prjmgr_field = obj_data.output.prjmanger_field;
			        		if(jQuery("#dv_prj_mangrs").length) jQuery("#dv_prj_mangrs").append(prjmgr_field);
			        		var contractors_field = obj_data.output.contractors_field;
			        		if(jQuery("#dv_contractors").length) jQuery("#dv_contractors").append(contractors_field);
		        		} else {
		        			//alert(obj_data.system_messages.error);
		        			jQuery(".contracting_company_err").html(obj_data.system_messages.error[0]);	        			
		        		}		        	
		        	}
			    })
			    .fail(function() {
			      //alert( "error" );
			    })
			    .always(function() {
			      //alert( "complete" );			    	
			    });
		  }	  
	  });
          
          
        jQuery("#add_dailywork").live("click", function(event){
            $("#daily_log_add").modal();
        
        });
	  
	var add_worker_flg = true;
	jQuery("#btn_daily_save").live("click", function (event) {
                   var daily_falg = true; 
                   if($("#paint_id").val() == "" )
                    {
                        daily_falg = false;
                        jQuery(".paint_err").html("Select a paint");
                    }
                   if($("#nopieces").val() == ""  )
                   {
                        daily_falg = false;
                        jQuery(".nopieces_err").html("Enter no: pieces");
                        
                   }
                   if( !$.isNumeric(jQuery('#nopieces').val()) || jQuery('#nopieces').val() <= 0 )
                   {
			jQuery(".nopieces_err").html(elgg.echo("paint:price:notnumber:error"));
			daily_falg = false;
		   }
                   if($("#employee_name").val() == "")
                   {
                        jQuery(".employee_name_err").html(elgg.echo("Enter employee name."));
			daily_falg = false;
                   }
        
		if(daily_falg == true)
		  {
		  		add_worker_flg = false;
		  		jQuery('.ajx-submit-load').removeClass('disp-none');
			  	var obj_form = jQuery(this).closest('form');
			  	var postData = obj_form.serialize();
			    var formURL = '/action/sytick/ajax/home';
			    jQuery.ajax( {
			    	type: "POST",
			    	url : formURL,
			    	data : postData+"&process=addDailyWork",		
			    })
			    .done(function(data) {
			        //console.log( "success"+data );
			        if(data)
		        	{
			        	var obj_data = jQuery.parseJSON( data );
			        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
			        	if(call_status != -1 )
		        		{
		        			show_messages(obj_data.system_messages.success);
		        			window.location.reload();
		        		} else {
		        			show_messages(obj_data.system_messages.error);
		        			//var err = obj_data.system_messages.error;
		        			//jQuery("."+class_str).html(err[0]);        			
		        		}		        	
		        	}
			    })
			    .fail(function() {
			      //alert( "error" );
			    })
			    .always(function() {
			      //alert( "complete" );
			      jQuery('.ajx-submit-load').addClass('disp-none');	
			      add_worker_flg = true;		    	
			    });
		  }
		event.preventDefault();
	});
	
	var activate_ind_flg = true;
	jQuery(".induction_activate").live("click", function (event) {
		activate_ind_flg = false;
	  	var postData = "induction_guid="+jQuery(this).attr('data:guid');	
   		var formURL = '/action/sytick/ajax/home';
   		var __elgg_ts =	elgg.security.token.__elgg_ts;
		var __elgg_token =	elgg.security.token.__elgg_token;	
	    jQuery.ajax( {
	    	type: "POST",
	    	url : formURL,
	    	data : postData+"&process=activateinduction&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,		
	    })
	    .done(function(data) {
	        //console.log( "success"+data );
	        if(data)
        	{
	        	var obj_data = jQuery.parseJSON( data );
	        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
	        	if(call_status != -1 )
        		{
        			show_messages(obj_data.system_messages.success);
        			window.location.reload();
        		} else {
        			show_messages(obj_data.system_messages.error);
        			//var err = obj_data.system_messages.error;
        			//jQuery("."+class_str).html(err[0]);        			
        		}		        	
        	}
	    })
	    .fail(function() {
	      //alert( "error" );
	    })
	    .always(function() {
	      //alert( "complete" );
	      activate_ind_flg = true;		    	
	    });
		event.preventDefault();
	});	
	
	var check_in_flg = true;
	jQuery("#btn_site_checkin").live("click", function (event) {
		if(check_in_flg == false) { return false;}
		check_in_flg = false;
		if(jQuery('#chkin_sp_project_id').val() == "" )
		{
			jQuery(".sp_project_id_err").html(elgg.echo("security:checkin:error:site_select"));
			return;	  
		}
		jQuery(".sp_project_id_err").html("");	
	  	employee_check_in(jQuery(this).attr('data:user:guid'), jQuery(this).attr('data:site:guid'),1) 
		event.preventDefault();
	});
	
	function employee_check_in(employee_guid, site_guid,security_flg) 
	{
		var postData = "site_guid=" + site_guid;	
	  	postData = postData+"&user_guid=" + employee_guid;
   		var formURL = '/action/sytick/ajax/home';
   		var __elgg_ts =	elgg.security.token.__elgg_ts;
		var __elgg_token =	elgg.security.token.__elgg_token;	
	    jQuery.ajax( {
	    	type: "POST",
	    	url : formURL,
	    	data : postData+"&process=securitycheckin&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,		
	    })
	    .done(function(data) {
	        console.log( "success"+data );
	        if(data)
        	{
	        	var obj_data = jQuery.parseJSON( data );
	        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
	        	if(call_status != -1 )
        		{
        			var message = obj_data.output.message
        			show_messages(message);
        			var str_time = obj_data.output.check_in_out_time;
        			jQuery('#spn_checkin-in_out_time_'+employee_guid).html('@'+str_time);
        			var in_count = jQuery('.check_in_count_spn').html();
        			var out_count = jQuery('.check_out_count_spn').html();
        			if( (out_count*1) > 0) {
        				 jQuery('.check_out_count_spn').html( ((out_count*1)-1)  )
        			}
        			jQuery('.check_in_count_spn').html( ((in_count*1)+1)  )        			
        			if(security_flg)  {
        				window.location.href = "/";
        			}
        		} else {
        			show_messages(obj_data.system_messages.error);
        			//var err = obj_data.system_messages.error;
        			//jQuery("."+class_str).html(err[0]);        			
        		}		        	
        	}
	    })
	    .fail(function() {
	      //alert( "error" );
	    })
	    .always(function() {
	      //alert( "complete" );
	      check_in_flg = true;		    	
	    });
	}
	
	
    
   
    jQuery("#chkin_sp_project_id").live("change", function (event) {	
		$('#btn_site_checkin').attr('data:site:guid',$(this).val());	
		var postData = "site_guid=" +  jQuery(this).val();	
	  	postData = postData+"&user_guid=" + jQuery(this).attr('data:user:guid');
   		var formURL = '/action/sytick/ajax/home';
   		var __elgg_ts =	elgg.security.token.__elgg_ts;
		var __elgg_token =	elgg.security.token.__elgg_token;
		$(".bootstrap-messages").fadeOut();	
		jQuery.ajax( {
	    	type: "POST",
	    	url : formURL,
	    	data : postData+"&process=pendinginduction&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,	
	    	beforeSend: function(){
	    	  $("#pending_induction_list").hide();  
		      check_in_flg = false;	 
		      jQuery('.ajx-submit-load').removeClass('disp-none');  
		    },	
	    })
	    .done(function(data) {
	        console.log( "success"+data );
	        if(data)
        	{
	        	var obj_data = jQuery.parseJSON( data );
	        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
	        	if(call_status != -1 )
        		{
        			var message = obj_data.output.message
        			show_messages(message);  
        			$("#pending_induction_list").html(obj_data.output.result_html);  
        			$("#pending_induction_list").show();     			
        		} else {
        			//show_messages(obj_data.system_messages.error);
        			check_in_flg = true;
        			//var err = obj_data.system_messages.error;
        			//jQuery("."+class_str).html(err[0]);        			
        		}		        	
        	}
	    })
	    .fail(function() {
	      //alert( "error" );
	    })
	    .always(function() {
	      //alert( "complete" );
	      jQuery('.ajx-submit-load').addClass('disp-none');  	    	
	    });
		
	});     
	
	
	var check_out_flg = true;
	jQuery("#security_checkout").live("click", function (event) {
		if(check_out_flg == false) { return false;}
		check_out_flg = false;
		employee_check_out(jQuery(this).attr('data:user:guid'), jQuery(this).attr('data:site:guid'),1) 
		event.preventDefault();
	});
	
	function employee_check_out(employee_guid, site_guid,security_flg)
	{
		var postData = "site_guid=" + site_guid;	
	  	postData = postData+"&user_guid=" + employee_guid;
   		var formURL = '/action/sytick/ajax/home';
   		var __elgg_ts =	elgg.security.token.__elgg_ts;
		var __elgg_token =	elgg.security.token.__elgg_token;	
	    jQuery.ajax( {
	    	type: "POST",
	    	url : formURL,
	    	data : postData+"&process=securitycheckout&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,		
	    })
	    .done(function(data) {
	        console.log( "success"+data );
	        if(data)
        	{
	        	var obj_data = jQuery.parseJSON( data );
	        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
	        	if(call_status != -1 )
        		{
        			var message = obj_data.output.message
        			show_messages(message);
        			var str_time = obj_data.output.check_in_out_time;
        			jQuery('#spn_checkin-in_out_time_'+employee_guid).html('@'+str_time);
        			var in_count = jQuery('.check_in_count_spn').html();
        			var out_count = jQuery('.check_out_count_spn').html();
        			if( (in_count*1) > 0) {
        				 jQuery('.check_in_count_spn').html( ((in_count*1)-1)  )
        			}
        			jQuery('.check_out_count_spn').html( ((out_count*1)+1)  ) 
        			if(security_flg)  {
        				window.location.href = "/";
        			} 
        		} else {
        			show_messages(obj_data.system_messages.error);
        			//var err = obj_data.system_messages.error;
        			//jQuery("."+class_str).html(err[0]);        			
        		}		        	
        	}
	    })
	    .fail(function() {
	      //alert( "error" );
	    })
	    .always(function() {
	      //alert( "complete" );
	      check_out_flg = true;		    	
	    });
	}
	
	$(".check_in_out_chk").on('switchChange.bootstrapSwitch', function(event, state) {
		//console.log(this); // DOM element
		//console.log(event); // jQuery event	
		var security_flg = 0;
		var employee_guid = jQuery(this).attr('data:user:guid');
		var chkin_site_guid = jQuery(this).attr('data:site:guid');
		//console.log(elgg.get_logged_in_user_guid());
		//console.log(employee_guid);
		if(elgg.get_logged_in_user_guid() == employee_guid) {
			security_flg = 1;
		}	
		//console.log(security_flg);
		if(state) {
			console.log(state); // checkin | false
			if(check_in_flg == false) { return false;}
			check_in_flg = false;		
			employee_check_in(employee_guid, chkin_site_guid,security_flg) 
		} else {
			console.log(state); // true | checkout
			if(check_out_flg == false) { return false;}
			check_out_flg = false;
			employee_check_out(employee_guid, chkin_site_guid ,security_flg); 
		}
	}); 
        
};

elgg.register_hook_handler('init', 'system', elgg.sytick.init);