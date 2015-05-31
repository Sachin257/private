<?php
// get the form inputs
$title = get_input('title');
$abn = get_input('abn');
$description = get_input('description');
$address = get_input('address');
$tel = get_input('tel');
$fax = get_input('fax');
$email = get_input('email');
$website = get_input('website');
$organization_guid = get_input('guid');
$user = elgg_get_logged_in_user_entity();

// Load library
elgg_load_library("elgg:organizations");

if ($organization_guid){
	$entity = get_entity($organization_guid);
	if (elgg_instanceof($entity, 'object', 'organization')) {
		if (check_entity_relationship($user->guid, 'manager_of_organization', $entity->guid)) {
			$organization = $entity;				
		} else {
			register_error(elgg_echo('organizations:message:organization_not_found'));
			forward(get_input('forward', REFERER));
		}

		if (validate_abn_input($abn)) {
			true;				
		} else {
			register_error(elgg_echo('organizations:message:abn_validation'));
			forward(get_input('forward', REFERER));
		}

	} else {
		register_error(elgg_echo('organizations:message:organization_not_found'));
		forward(get_input('forward', REFERER));
	}
} else {		
	// create a new lesson object
	$organization = new ElggObject();	
	$organization->subtype = "organization";
	$organization_guid = $organization->save();
	add_entity_relationship($user->guid, "manager_of_organization", $organization_guid);
}

$organization->title = $title;
$organization->abn = $abn;
$organization->description = $description;
$organization->address = $address;
$organization->tel = $tel;
$organization->fax = $fax;
$organization->email = $email;
$organization->website = $website;
$organization->is_deleted = 0;
$organization->access_id = ACCESS_PUBLIC;

// save to database and get id of the new organization
$organization_guid = $organization->save();

if (validate_abn_input($abn)) {
	true;				
} else {
	$organization->is_deleted = 1;
	$organization->abn = '';
	register_error(elgg_echo('organizations:message:abn_validation'));
	forward('organizations/edit/' . $organization_guid);
}	

// if the my_blog was saved, we want to display the new post
// otherwise, we want to register an error and forward back to the form
if ($organization_guid) {
   system_message("organizations:message:organization_saved");
   forward("organizations/all");
} else {
   register_error("organizations:message:organization_not_saved");
   forward(REFERER); // REFERER is a global variable that defines the previous page
}