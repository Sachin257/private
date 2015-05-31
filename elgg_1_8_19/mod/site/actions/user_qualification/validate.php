<?php
// get the form inputs
$qualification_guid = get_input('qualification_guid');
$organization_guid = get_input('organization_guid');
$site_guid = get_input('site_guid');
$contractor_guid = get_input('contractor_guid');
$user = get_loggedin_user();
$user_guid = get_loggedin_userid();

if ($qualification_guid){
	$entity = get_entity($qualification_guid);
	if (elgg_instanceof($entity, 'object', 'qualification')) {
		if (check_entity_relationship($user->guid, 'manager_of_organization', $organization_guid)) {
			add_entity_relationship($qualification_guid, "validated_by", $user_guid);
		} else {
			register_error(elgg_echo('site:error:site_not_found'));
			forward(get_input('forward', REFERER));
		}
	} else {
		register_error(elgg_echo('site:error:site_not_found'));
		forward(get_input('forward', REFERER));
	}
} 

system_message("site:message:validated");
forward('user_qualification/all?user_guid=' . $contractor_guid . '&site_guid=' . $site_guid);