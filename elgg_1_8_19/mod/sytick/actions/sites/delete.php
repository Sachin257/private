<?php
/**
 * Delete project entity
 *
 * @package sytick
 */

$sites_guid = get_sanitised_input('guid');
$site = get_entity($sites_guid);
$offset = get_sanitised_input('offset');
if (elgg_instanceof($site, 'object', 'sites') ) {
	$site->is_deleted = 1;
	$site->access_id = ACCESS_PRIVATE;
	if ($site->save()) {
		system_message(elgg_echo('sites:message:deleted'));
		forward("/sites/all/$offset");
	} else {
		register_error(elgg_echo('sites:error:cannot_delete'));
	}
} else {
	register_error(elgg_echo('sites:error:not_found'));
}

forward("/sites/all/$offset");