<?php
// get organization

// get the form inputs
$organization_guid = intval(get_input('organization_guid'));
$site_guid = get_input('guid');
$title = get_input('title');
$body = get_input('description');
$address = get_input('address');
$job_description = get_input('job_description');
$general_contacts = get_input('general_contacts');
$emergency_contacts = get_input('emergency_contacts');
$out_of_hours_contacts = get_input('out_of_hours_contacts');
$map_url = get_input('map_url');

if ($site_guid){
	$entity = get_entity($site_guid);
	if (elgg_instanceof($entity, 'object', 'site') && $entity->canEdit()) {
		$site = $entity;
	} else {
		register_error(elgg_echo('site:error:post_not_found'));
		forward(get_input('forward', REFERER));
	}
} else {
	// create a new site object
	$site = new ElggObject();
}

$site->subtype = "site";
$site->title = $title;
$site->description = $body;
$site->is_deleted = 0;

// for now make all sites public
$site->access_id = ACCESS_PUBLIC;

// owner is logged in user
$site->owner_guid = elgg_get_logged_in_user_guid();

// save other fields as metadata
$site->address = $address;
$site->job_description = $job_description;
$site->general_contacts = $general_contacts;
$site->emergency_contacts = $emergency_contacts;
$site->out_of_hours_contacts = $out_of_hours_contacts;
$site->map_url = $map_url;

// save to database and get id of the new site
$site_guid = $site->save();

if ($site_guid && $organization_guid) {
	add_entity_relationship($site_guid, "site_of_organization", $organization_guid);			
}


// if the site was saved, we want to display the new site
// otherwise, we want to register an error and forward back to the form
if ($site_guid) {		
   	system_message("organizations:message:site_saved");
   	forward('organizations/view/' . $organization_guid);
} else {
   register_error("site:error:cannot_save");
   forward(REFERER); // REFERER is a global variable that defines the previous page
}