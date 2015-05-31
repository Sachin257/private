<?php
/**
 * Delete document_type entity
 *
 * @package sytick
 */

$company_guid = get_sanitised_input('guid');
$company = get_entity($company_guid);
$offset = get_sanitised_input('offset');
$company_type = get_sanitised_input('company_type');
if (elgg_instanceof($company, 'object', 'company') && $company->canEdit()) {
	$company->is_deleted = 1;
	$company->access_id = ACCESS_PRIVATE;
	if ($company->save()) {
		system_message(elgg_echo('company:message:deleted'));
		forward("/company/all/$company_type/$offset");
	} else {
		register_error(elgg_echo('company:error:cannot_delete'));
	}
} else {
	register_error(elgg_echo('company:none'));
}

forward("/company/all/$company_type/$offset");