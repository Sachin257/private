<?php
/**
 * Delete qualification entity
 *
 * @package qualification
 */

$qualification_guid = get_input('guid');
$qualification = get_entity($qualification_guid);

if (elgg_instanceof($qualification, 'object', 'qualification') && $qualification->canEdit()) {
	$container = get_entity($qualification->container_guid);
	if ($qualification->delete()) {
		system_message(elgg_echo('qualification:message:deleted_post'));
		if (elgg_instanceof($container, 'group')) {
			forward("qualification/all");
		} else {
			forward("qualification/all");
		}
	} else {
		register_error(elgg_echo('qualification:error:cannot_delete_post'));
	}
} else {
	register_error(elgg_echo('qualification:error:post_not_found'));
}

forward("qualification/all");