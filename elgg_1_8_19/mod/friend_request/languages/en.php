<?php
	$english = array(
		'friend_request' => "Associate Request",
		'friend_request:menu' => "Associate Requests",
		'friend_request:title' => "Associate Requests for: %s",
	
		'friend_request:new' => "New associate request",
		
		'friend_request:friend:add:pending' => "Associate request pending",
		
		'friend_request:newfriend:subject' => "%s wants to be your associate!",
		'friend_request:newfriend:body' => "%s wants to be your associate! But they are waiting for you to approve the request...so login now so you can approve the request!

You can view your pending associate requests at:
%s

Make sure you are logged into the website before clicking on the following link otherwise you will be redirected to the login page.

(You cannot reply to this email.)",
		
		// Actions
		// Add request
		'friend_request:add:failure' => "Sorry, because of a system error we were unable to complete your request. Please try again.",
		'friend_request:add:successful' => "You have requested to be associates with %s. They must approve your request before they will show on your associates list.",
		'friend_request:add:exists' => "You've already requested to be associates with %s.",
		
		// Approve request
		'friend_request:approve' => "Approve",
		'friend_request:approve:subject' => "%s has accepted your associate request",
		'friend_request:approve:message' => "Dear %s,
	
	%s has accepted your request to become an associate.",
		'friend_request:approve:successful' => "%s is now an associate",
		'friend_request:approve:fail' => "Error while creating associate relation with %s",
	
		// Decline request
		'friend_request:decline' => "Decline",
		'friend_request:decline:subject' => "%s has declined your associate request",
		'friend_request:decline:message' => "Dear %s,

%s has declined your request to become an associate.",
		'friend_request:decline:success' => "Associate request successfully declined",
		'friend_request:decline:fail' => "Error while declining Associate request, please try again",
		
		// Revoke request
		'friend_request:revoke' => "Revoke",
		'friend_request:revoke:success' => "Associate request successfully revoked",
		'friend_request:revoke:fail' => "Error while revoking Associate request, please try again",
	
		// Views
		// Received
		'friend_request:received:title' => "Received Associate requests",
		'friend_request:received:none' => "No requests pending your approval",
	
		// Sent
		'friend_request:sent:title' => "Sent Associate requests",
		'friend_request:sent:none' => "No sent requests pending approval",
	);
					
	add_translation("en", $english);