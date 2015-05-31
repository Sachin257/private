<?php
/**
 * Organizations English language file.
 *
 */

$english = array(
	'Organisations' => 'Companies', // how menu item appears // set in start.php - elgg_echo('Organisations')
	'organizations:title:all_organizations' => 'Companies',
	'organizations:title:add_organization' => 'Create Company',
	'organizations:title:edit_organization' => 'Edit Company',	
	'organizations:title:view_organization' => ' (Company)',
	'organizations:title:all_sites' => 'Company Sites',
	
	'organizations:message:organization_deleted' => 'Company deleted',
	'organizations:message:organization_saved' => 'Company information saved',
	'organizations:message:organization_not_saved' => 'Company information was not saved',		
	'organizations:message:organization_not_found' => 'Company not found',
	
	'organizations:all:add_organization' => 'Add Company',
	'organizations:all:edit_organization' => 'Edit Info',
	'organizations:all:delete_organization' => 'Delete',
	'organizations:all:view_sites' => 'View Sites',
	
	'organizations:save:title' => 'Title',	
	'organizations:save:description' => 'Description',		
	'organizations:save:save' => 'Save',
	
	'organizations:view:add_site' => 'Add Site',
	'organizations:view:view_site' => 'View Site',
	'organizations:view:edit_site' => 'Edit Site',
	'organizations:view:delete_site' => 'Delete Site',

	// widget
	'organizations:widget' => 'Companies',
	'organizations:widget:description' => 'Display your latest companies',
	'organizations:moreorganizations' => 'More companies',
	'organizations:numbertodisplay' => 'Number of companies to display',
	'organizations:noorganizations' => 'No companies',

	// extra data
	'organizations:extra:abn' => 'ABN',
	'organizations:extra:address' => 'Address',
	'organizations:extra:tel' => 'Tel',
	'organizations:extra:fax' => 'Fax',
	'organizations:extra:email' => 'Email',
	'organizations:extra:website' => 'Website',

	// validation messages
	'organizations:message:abn_validation' => 'ABN should be a unique 11 digit number.'
);

add_translation('en', $english);
