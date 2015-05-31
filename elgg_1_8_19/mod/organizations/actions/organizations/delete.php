<?php
	// get the form inputs
	$organization_guid = get_input('guid');
	$user = elgg_get_logged_in_user_entity();
	
	if ($organization_guid){
		$entity = get_entity($organization_guid);
		if (elgg_instanceof($entity, 'object', 'organization')) {
			if (check_entity_relationship($user->guid, 'manager_of_organization', $organization_guid)) {
				$organization = $entity;				
			} else {
				register_error(elgg_echo('organizations:message:organization_not_found'));
				forward(get_input('forward', REFERER));
			}
		} else {
			register_error(elgg_echo('organizations:message:organization_not_found'));
			forward(get_input('forward', REFERER));
		}
	} 
	
	$organization->is_deleted = 1;
	$organization_guid = $organization->save();
 
   system_message("organizations:message:organization_deleted");
   forward("organizations/all");

?>