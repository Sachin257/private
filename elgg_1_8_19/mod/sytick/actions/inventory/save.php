<?php
// get the form inputs
$item_guid = get_input('guid');
$inventory_type = get_input("inventory_type");
$title = get_input('title');
$unique_id = get_input('item_code');
$length = get_input('length');
$weight = get_input("weight");
$price = get_input('price');
global $inventory_types;


if ($item_guid){
	$entity = get_entity($item_guid);
	if (elgg_instanceof($entity, 'object', $inventory_types[$inventory_type]) && $entity->canEdit()) {
		$item = $entity;
	} else {
		register_error(elgg_echo('item:error:cannot_edit'));
		forward(get_input('forward', REFERER));
	}
} else {
	// create a new qualification_type object
	$item = new ElggObject();
}

$item->subtype = $inventory_types[$inventory_type];
$item->title = $title;
$item->item_code = $unique_id;
$item->length = $length;
$item->weight = $weight;
$item->price = $price;


$item->is_deleted = 0;

// for now make all qualification public
$item->access_id = ACCESS_PUBLIC;

// owner is logged in user
$item->owner_guid = elgg_get_logged_in_user_guid();

// save to database and get id of the new qualification_type
$item_guid = $item->save();

// if the qualification was saved, we want to display the new qualification
// otherwise, we want to register an error and forward back to the form
if ($item_guid) {		
   	system_message(elgg_echo("item:message:saved"));
   	forward('inventory/all');
} else {
   register_error(elgg_echo("item:error:cannot_save"));
   forward(REFERER); // REFERER is a global variable that defines the previous page
}