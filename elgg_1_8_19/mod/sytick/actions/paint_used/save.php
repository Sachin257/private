<?php

// get the form inputs
$paint_guid = get_input('paint_id_name');
$quantity = get_input('paint_amount') - get_input('paint_amount1') ;
$colour = get_input('colour');
$unique_id = get_input('paint_id');
$name = get_input('title');


if ($paint_guid){
	$entity = get_entity($paint_guid);
	if (elgg_instanceof($entity, 'object', 'paint') && $entity->canEdit()) {
		$paint = $entity;
	} else {
		register_error(elgg_echo('paint:error:cannot_edit'));
		forward('paint_used/all');
	}
}

if($paint->quantity < $quantity){
    register_error(elgg_echo('paint:error:cannot_edit'));
    forward('paint_used/all');
}else{
    $paint->quantity = $paint->quantity - $quantity;
    $paint->save();
}

check_and_create_paint_alerts($paint_guid);
   
$paint_used = new ElggObject();    
$paint_used->subtype = "paint_used";
$paint_used->title = $name;
$paint_used->paint_guid = $paint_guid;
$paint_used->paint_used_id = $unique_id;
$paint_used->colour = $colour;
$paint_used->quantity = $quantity;

$paint_used->is_deleted = 0;

// for now make all qualification public
$paint_used->access_id = ACCESS_PUBLIC;

// owner is logged in user
$paint_used->owner_guid = elgg_get_logged_in_user_guid();

// save to database and get id of the new qualification_type
$paint_used_guid = $paint_used->save();

// if the qualification was saved, we want to display the new qualification
// otherwise, we want to register an error and forward back to the form
if ($paint_used_guid) {
    system_message(elgg_echo("paint_used:message:saved"));
    forward('paint_used/all');
} else {
    register_error(elgg_echo("paint_used:error:cannot_save"));
    forward(REFERER); // REFERER is a global variable that defines the previous page
}