<?php
// get the form inputs
$organization_guid = get_input('organization_guid');
$site_guid = get_input('guid');
$user = elgg_get_logged_in_user_entity();

if ($site_guid){
	$entity = get_entity($site_guid);
	if (elgg_instanceof($entity, 'object', 'site')) {
		if (check_entity_relationship($user->guid, 'manager_of_organization', $organization_guid)) {
			$site = $entity;				
		} else {
			register_error(elgg_echo('site:error:site_not_found'));
			forward(get_input('forward', REFERER));
		}
	} else {
		register_error(elgg_echo('site:error:site_not_found'));
		forward(get_input('forward', REFERER));
	}
} 

$site->is_deleted = 1;
$site_guid = $site->save();

system_message("site:message:site_deleted");
forward("organizations/view/".$organization_guid);