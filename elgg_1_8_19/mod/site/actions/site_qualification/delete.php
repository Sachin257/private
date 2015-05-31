<?php
// get the form inputs
$organization_guid = get_input('organization_guid');
$site_guid = get_input('guid');
$qualification_type_guid = get_input('qualification_type_guid');
$lesson_guid = get_input('lesson_guid');
$user = elgg_get_logged_in_user_entity();

if ($lesson_guid){
	$entity = get_entity($lesson_guid);
	if (elgg_instanceof($entity, 'object', 'lesson')) {
		if (check_entity_relationship($user->guid, 'manager_of_organization', $organization_guid)) {
			$lesson = $entity;
			$qualification_type = get_entity($qualification_type_guid);			
		} else {
			register_error(elgg_echo('site:error:site_not_found'));
			forward(get_input('forward', REFERER));
		}
	} else {
		register_error(elgg_echo('site:error:site_not_found'));
		forward(get_input('forward', REFERER));
	}
	$lesson->is_deleted = 1;
	$lesson_guid = $lesson->save();
	$qualification_type->is_deleted = 1;
	$qualification_type_guid = $qualification_type->save();	
} 

if (!$lesson_guid) {
	remove_entity_relationship($qualification_type_guid, 'qualification_type_of_site', $site_guid);
}

system_message("site:message:site_deleted");
forward('site/view?guid=' . $site_guid . '&organization_guid=' . $organization_guid);