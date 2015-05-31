<?php
// get the form inputs
$qualification_type_guid = get_input('guid');
$title = get_input('title');
$body = get_input('description');

if ($qualification_type_guid){
	$entity = get_entity($qualification_type_guid);
	if (elgg_instanceof($entity, 'object', 'qualification_type') && $entity->canEdit()) {
		$qualification_type = $entity;
	} else {
		register_error(elgg_echo('qualification:error:cannot_edit_post'));
		forward(get_input('forward', REFERER));
	}
} else {
	// create a new qualification_type object
	$qualification_type = new ElggObject();
}

$qualification_type->subtype = "qualification_type";
$qualification_type->title = $title;
$qualification_type->description = $body;

// for now make all qualification public
$qualification_type->access_id = ACCESS_PUBLIC;

// owner is logged in user
$qualification_type->owner_guid = elgg_get_logged_in_user_guid();

// save other fields as metadata
$qualification_type->category = 'general';

// save to database and get id of the new qualification_type
$qualification_type_guid = $qualification_type->save();

// if the qualification was saved, we want to display the new qualification
// otherwise, we want to register an error and forward back to the form
if ($qualification_type_guid) {		
   	system_message(elgg_echo("qualification:message:saved"));
   	forward('qualification_type/all');
} else {
   register_error(elgg_echo("qualification:error:cannot_save"));
   forward(REFERER); // REFERER is a global variable that defines the previous page
}