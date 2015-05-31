<?php
// get the form inputs
$material_type_guid = get_input('guid');
$title = get_input('title');
$perimeter = get_input("perimeter");
$price = get_input("price");
$body = get_input('description');

if ($material_type_guid){
	$entity = get_entity($material_type_guid);
	if (elgg_instanceof($entity, 'object', 'material_type') && $entity->canEdit()) {
		$material_type = $entity;
	} else {
		register_error(elgg_echo('material_type:error:cannot_edit'));
		forward(get_input('forward', REFERER));
	}
} else {
	// create a new qualification_type object
	$material_type = new ElggObject();
}

$material_type->subtype = "material_type";
$material_type->title = $title;
$material_type->perimeter = $perimeter;
$material_type->price = $price;
$material_type->description = $body;
$material_type->is_deleted = 0;

// for now make all qualification public
$material_type->access_id = ACCESS_PUBLIC;

// owner is logged in user
$material_type->owner_guid = elgg_get_logged_in_user_guid();

// save to database and get id of the new qualification_type
$material_type_guid = $material_type->save();

// if the qualification was saved, we want to display the new qualification
// otherwise, we want to register an error and forward back to the form
if ($material_type_guid) {		
   	system_message(elgg_echo("material_type:message:saved"));
   	forward('material_type/all');
} else {
   register_error(elgg_echo("material_type:error:cannot_save"));
   forward(REFERER); // REFERER is a global variable that defines the previous page
}