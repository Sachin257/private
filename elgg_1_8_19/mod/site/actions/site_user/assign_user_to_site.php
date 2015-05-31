<?php
// get the form inputs
$organization_guid = get_input('organization_guid');
$site_guid = get_input('site_guid');
$contractor_guid = get_input('contractor_guid');
$user = get_loggedin_user();
$user_guid = get_loggedin_userid();

if ($organization_guid){
	$entity = get_entity($organization_guid);
	if (elgg_instanceof($entity, 'object', 'organization')) {
		if (check_entity_relationship($user->guid, 'manager_of_organization', $organization_guid)) {
				add_entity_relationship($contractor_guid, "contractor_of_site", $site_guid);		
		} else {
			register_error(elgg_echo('site:error:site_not_found'));
			forward(get_input('forward', REFERER));
		}
	} else {
		register_error(elgg_echo('site:error:site_not_found'));
		forward(get_input('forward', REFERER));
	}
} 

system_message("site:message:assigned");
forward('site_user/all?site_guid=' . $site_guid . '&organization_guid=' . $organization_guid);