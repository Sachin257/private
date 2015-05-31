<?php
/**
 * Delete project entity
 *
 * @package sytick
 */

$project_guid = get_sanitised_input('guid');
$project = get_entity($project_guid);
$offset = get_sanitised_input('offset');
if (elgg_instanceof($project, 'object', 'project') && $project->canEdit()) {
	$project->is_deleted = 1;
	$project->access_id = ACCESS_PRIVATE;
	if ($project->save()) {
		system_message(elgg_echo('project:message:deleted'));
		forward("/project/all/$offset");
	} else {
		register_error(elgg_echo('project:error:cannot_delete'));
	}
} else {
	register_error(elgg_echo('project:error:not_found'));
}

forward("/project/all/$offset");