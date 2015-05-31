<?php
$certificate_guid = get_input('guid');
$certificate = get_entity($certificate_guid);

if (elgg_instanceof($certificate, 'object', 'certificate') && $certificate->canEdit()) {
	$certificate->is_deleted = 1;
	$certificate->access_id = ACCESS_PRIVATE;
	if ($certificate->save()) {
		system_message(elgg_echo('certificate:message:deleted'));
		forward(REFERER);
	} else {
		register_error(elgg_echo('certificate:error:cannot_delete'));
	}
} else {
	register_error(elgg_echo('certificate:none'));
}

forward(REFERER);