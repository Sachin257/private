<?php
// get the form inputs
$paint_guid = get_input('guid');
$title = get_input('title');
$unique_id = get_input('paint_id');
$colour = get_input('colour');
$price = get_input('price');
$quantity = (int) get_input('quantity') + (int) get_input('additional');
$threshold = get_input('alert_threshold');
$flag = FALSE;
if ($paint_guid){
	$entity = get_entity($paint_guid);
	if (elgg_instanceof($entity, 'object', 'paint') && $entity->canEdit()) {
		$paint = $entity;
                $flag = TRUE;
	} else {
		register_error(elgg_echo('paint:error:cannot_edit'));
		forward(get_input('forward', REFERER));
	}
} else {
	// create a new qualification_type object
	$paint = new ElggObject();
}

$paint->subtype = "paint";
$paint->title = $title;
$paint->paint_id = $unique_id;
$paint->colour = $colour;
$paint->price = $price;
$paint->quantity = $quantity + $additional;
$paint->threshold = $threshold;

$paint->is_deleted = 0;

// for now make all qualification public
$paint->access_id = ACCESS_PUBLIC;

// owner is logged in user
$paint->owner_guid = elgg_get_logged_in_user_guid();

// save to database and get id of the new qualification_type
$paint_guid = $paint->save();
if($flag){
    check_and_remove_paint_alerts($paint_guid);
}

// if the qualification was saved, we want to display the new qualification
// otherwise, we want to register an error and forward back to the form
if ($paint_guid) {		
   	system_message(elgg_echo("paint:message:saved"));
   	forward('paint/all');
} else {
   register_error(elgg_echo("paint:error:cannot_save"));
   forward(REFERER); // REFERER is a global variable that defines the previous page
}