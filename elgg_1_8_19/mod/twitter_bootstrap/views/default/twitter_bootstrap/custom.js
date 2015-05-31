function clear_message()
{
	setTimeout(function() {
		$(".bootstrap-messages").fadeOut();
	}, 4000);
}
clear_message();



//code found here http://stackoverflow.com/a/9262055/1543173
// Not sure of license.

$(document).scroll(function(){
/*
    // If has not activated (has no attribute "data-top"
    if (!$('.subnav').attr('data-top')) {
        // If already fixed, then do nothing
        if ($('.subnav').hasClass('subnav-fixed')) return;
        // Remember top position
        var offset = $('.subnav').offset()
        $('.subnav').attr('data-top', offset.top);
    }
    if ($('.subnav').attr('data-top') - $('.subnav').outerHeight() <= $(this).scrollTop())
        $('.subnav').addClass('subnav-fixed');
    else
        $('.subnav').removeClass('subnav-fixed');*/
});

//used for the access level tooltip
$(function ()  
{ $(".access-tooltip").tooltip();  
});  

//this is required to stop the bootstrap dropdown closing when clicked in
var elgg_ts =	"";
var elgg_token =	"";

$(function() { 
  // Fix input element click problem, without this it closes on click
  $('.dropdown input, .dropdown label').click(function(e) {
    e.stopPropagation();
  });
  
  $('.carousel').carousel();    
  
  $(document).ready(function(){
//            $(document).click();
//            $('#header_login_passwd').focus().click();
      setTimeout(function() {     
            $('#header_login_name').focus();
      }, 100);
      setTimeout(function() {     
      if($("#header_login_passwd").val() != "" || $("#header_login_name").val() != "" )
      {
          jQuery("#header_login").css("background","#cb4414");
          jQuery("#header_login").css("border-bottom","1px solid #942700");
          jQuery("#header_login").css("cursor","pointer");
      }
      else{
          jQuery("#header_login").css("background","#4d4d4d");
          jQuery("#header_login").css("border-bottom","none");
          jQuery("#header_login").css("cursor","auto");
      }

//      $('#header_login_name').focus();
      }, 500);
  
  $(document).on("change keyup paste mouseup input","#header_login_name, #header_login_passwd", function (event) {
//  jQuery("#header_login_name, #header_login_passwd").live("change keyup paste mouseup input", function (event) {
      if($("#header_login_passwd").val() !== "" && $("#header_login_name").val() !== "" )
      {
          jQuery("#header_login").css("background","#cb4414");
          jQuery("#header_login").css("border-bottom","1px solid #942700");
          jQuery("#header_login").css("cursor","pointer");
      }
      else{
          jQuery("#header_login").css("background","#4d4d4d");
          jQuery("#header_login").css("border-bottom","none");
          jQuery("#header_login").css("cursor","auto");
          
      }
      console.log("fasdf");
  });

  });
  
  jQuery("#header_login").live("click", function (event) {
	  //get_first_redirect_page();
	  //event.preventDefault();
	  //return;
	  if(jQuery("#header_login_name").val() != "" && jQuery("#header_login_passwd").val() != "")
	  {
		    var obj_form = jQuery(this).closest('form');
		  	var postData = obj_form.serialize();
		    var formURL = obj_form.attr("action");
		    jQuery.ajax( {
		    	type: "POST",
		    	url : '/action/sytick/ajax/home',
		    	data : postData+"&process=validate",		    	
		    	//dataType: "json"
		    })
		    .done(function(data) {
		        //alert( "success"+data );
		        if(data)
	        	{
		        	var obj_data = jQuery.parseJSON( data );
		        	var login_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
		        	if(login_status != -1 )
	        		{
		        		//alert(obj_data.system_messages.success); 
		        		var forward_url = (obj_data.output && obj_data.output.forward_url) ?  obj_data.output.forward_url :"";
		        		if(forward_url != "")
	        			{
		        			window.location.href = forward_url;
	        			}
		        		else {
		        			window.location.reload();
		        		}
	        		} else {
	        			//alert(obj_data.system_messages.error);
	        			show_messages(obj_data.system_messages.error);	
                                        jQuery("#header_login_name").val("");
                                        jQuery("#header_login_passwd").val("");
	        		}		        	
	        	}
		    })
		    .fail(function() {
		      //alert( "error" );
		    })
		    .always(function() {
		      //alert( "complete" );		    	
		    	clear_message();
		    });
	  }
	  event.preventDefault();
  });  
  
  jQuery("#side_coloumn_logo").live("click", function (event) {
	  //alert(elgg.forward());
	  if(elgg.is_admin_logged_in())
	  {
		  window.location.href = "/user/admin";
	  } else if(elgg.is_logged_in())
	  {
		  var user_obj = elgg.get_logged_in_user_entity();
		  //console.log(elgg.get_logged_in_user_entity());
		  window.location.href =  "/user/"+user_obj.username;
	  } else {
		  window.location.href =  "/";
	  }
  }); 
  
  
});

function show_messages(msg)
{
	var msg_div = '<div class="alert alert-success bootstrap-messages">';
	msg_div += '<a href="#" data-dismiss="alert" class="close">×</a>';
	msg_div +='<p>'+msg+'</p>';
	msg_div +='</div>';
	jQuery('.elgg-page-messages').html(msg_div);
}

jQuery(document).ready(function (){
   var popup_val = window.location.search.replace("?policy=", "");
   if(popup_val == "terms")
   {
       $(".terms").trigger('click');
   }
   else if(popup_val == "privacy"){
       $(".privacy").trigger('click');
   }
});

jQuery(".terms, .privacy, .cookie ").live("click", function (event) {
	  	var dv_title = jQuery(this).attr('class');
	 	var __elgg_ts =	elgg.security.token.__elgg_ts;
	  	var __elgg_token =	elgg.security.token.__elgg_token;
	    jQuery.ajax( {
	    	type: "POST",
	    	url : '/action/sytick/ajax/home',
	    	data : "process=page&page="+dv_title+"&__elgg_ts="+__elgg_ts+"&__elgg_token="+__elgg_token,		
	    })
	    .done(function(data) {
	        //console.log( "success"+data );
	        if(data)
	      	{
	        	var obj_data = jQuery.parseJSON( data );
	        	var call_status = (obj_data.status) ?  ((obj_data.status)*1) : 0;
	        	if(call_status != -1 )
        		{
	        		//alert(obj_data.output.title); 
	        		jQuery('#myModalLabelFooter').html(obj_data.output.title);
	        		jQuery('#myModalbodyFooter').html(obj_data.output.content);
	        		 $('#myModal').modal();
        		} else {
        			//alert(obj_data.system_messages.error);
        			show_messages(obj_data.system_messages.error);	        			
        		}
	      	}
	    })
	  
}); 

function validate_email(email)
{
	var reg = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/
	//console.log(email);
	if (reg.test(email)){
		return true;
  	} else {			  
		return false;
	}
}



