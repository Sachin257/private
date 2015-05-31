<?php
// get the form inputs
$site_guid = get_input('guid');
$qualification_type_guid = get_input('qualification_type_guid');
$organization_guid = get_input('organization_guid');

if ($site_guid && $qualification_type_guid) {
	add_entity_relationship($qualification_type_guid, "qualification_type_of_site", $site_guid);		
}

// if the relationship was saved, we want to display site list
// otherwise, we want to register an error and forward back to the form
if ($site_guid) {		
   	system_message(elgg_echo("site:message:saved"));
   	forward('site/view?guid=' . $site_guid . '&organization_guid=' . $organization_guid);
} else {
   register_error(elgg_echo("site:error:cannot_save"));
   forward(REFERER); // REFERER is a global variable that defines the previous page
}