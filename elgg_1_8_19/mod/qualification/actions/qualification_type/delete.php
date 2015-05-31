<?php
/**
 * Delete qualification_type entity
 *
 * @package qualification
 */

$qualification_type_guid = get_input('guid');
$qualification_type = get_entity($qualification_type_guid);

if (elgg_instanceof($qualification_type, 'object', 'qualification_type') && $qualification_type->canEdit()) {
	$container = get_entity($qualification_type->container_guid);
	if ($qualification_type->delete()) {
		system_message(elgg_echo('qualification:message:deleted_post'));
		if (elgg_instanceof($container, 'group')) {
			forward("qualification_type/all");
		} else {
			forward("qualification_type/all");
		}
	} else {
		register_error(elgg_echo('qualification:error:cannot_delete_post'));
	}
} else {
	register_error(elgg_echo('qualification:error:post_not_found'));
}

forward("qualification_type/all");