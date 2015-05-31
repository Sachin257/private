<?php
/**
 * site English language file.
 *
 */

$english = array(
	'site' => 'Sites',
	'site:sites' => 'Sites',
	'site:revisions' => 'Revisions',
	'site:archives' => 'Archives',
	'site:site' => 'Site',
	'site:mine' => 'My sites',
	'item:object:site' => 'Sites',

	'site:title:user_sites' => '%s\'s sites',
	'site:title:all_sites' => 'All site sites',
	'site:title:friends' => 'Friends\' sites',

	'site:group' => 'Group site',
	'site:enablesite' => 'Enable group site',
	'site:write' => 'Write an site',

	// Editing
	'site:add' => 'Add a site',
	'site:edit' => 'Edit site',
	'site:excerpt' => 'Excerpt',
	'site:body' => 'Body',
	'site:save_status' => 'Last saved: ',
	'site:never' => 'Never',

	// Statuses
	'site:status' => 'Status',
	'site:status:draft' => 'Draft',
	'site:status:published' => 'Published',
	'site:status:unsaved_draft' => 'Unsaved Draft',

	'site:revision' => 'Revision',
	'site:auto_saved_revision' => 'Auto Saved Revision',

	// messages
	'site:message:saved' => 'Site saved.',
	'site:error:cannot_save' => 'Cannot save site.',
	'site:error:cannot_write_to_container' => 'Insufficient access to save site to group.',
	'site:messages:warning:draft' => 'There is an unsaved draft of this post!',
	'site:edit_revision_notice' => '(Old version)',
	'site:message:site_deleted' => 'Site deleted.',
	'site:error:cannot_delete_post' => 'Cannot delete site.',
	'site:none' => 'No sites',
	'site:error:missing:title' => 'Please enter a site title!',
	'site:error:missing:description' => 'Please enter the body of your site!',
	'site:error:cannot_edit_post' => 'This site may not exist or you may not have permissions to edit it.',
	'site:error:revision_not_found' => 'Cannot find this revision.',

	'site:error:number_exists' => 'The number you entered does exist.',

	// river
	'river:create:object:site' => '%s published an site %s',
	'river:comment:object:site' => '%s commented on the site %s',

	// notifications
	'site:newpost' => 'A new site',
	'site:notification' =>
'
%s made a new site.

%s
%s

View and comment on the new site:
%s
',

	// widget
	'site:widget' => 'Sites',
	'site:widget:description' => 'Display your latest sites',
	'site:moresites' => 'More sites',
	'site:numbertodisplay' => 'Number of sites to display',
	'site:nosites' => 'No sites',

	// extra data
	'site:extra:address' => 'Address',
	'site:extra:job_description' => 'Job Description',
	'site:extra:general_contacts' => 'General Contacts',
	'site:extra:emergency_contacts' => 'Emergency Contacts',
	'site:extra:out_of_hours_contacts' => 'Out of Hours Contacts',
	'site:extra:map_url' => 'Map position (Latitude,Longitude)',
	'site:view:view_map' => 'View Map',

	'site:extra:view_lessons' => 'View Inductions',
	'site:extra:delete' => 'Delete Site',

	'site:title:all_qualifications' => 'Qualifications',
	'site:view:add_qualification_type' => 'Add Qualification',
	'site:view:add_lesson' => 'Add Induction',
	'site:title:all_qualification_types' => 'All Qualifications',
	'site:title:all_required__qualification_types' => 'Required Qualifications & Inductions',
	'site:view:delete_qualification_type' => 'Delete',
	'site:view:edit_qualification_type' => 'Edit Qualification',
	'site:view:view_qualification' => 'View Qualification',
	'site:view:view_lesson' => 'View Induction',
	'site:view:add_qualification' => 'Add Qualification',	
	'site:view:delete_lesson' => 'Delete Induction',
	'site:view:edit_lesson' => 'Edit Information',
	'site:view:view_user_qualification' => 'View User Qualification',
	'site:view:validate_user_qualification' => 'Validate Qualification',
	'site:view:validated' => '(Validated)',
	'site:view:not_validated' => '(Not Validated)',
	'site:view:no_contractors1' => 'This site does not yet contain any contractors.',
	'site:view:no_contractors2' => 'You can register new contractors via "',
	'site:view:no_contractors3' => '" button or via "',
	'site:view:no_contractors4' => '" button from existing members.',
	'site:view:no_qualification_types' => 'This site does not yet contain any required material.',
	
	// Toggle added stuff
	
	'site:title:contractors' => 'All Contractors',
	'site:title:all_contractors' => 'Contractors on this site',
	'site:view:edit_screens' => 'Edit Screens',
	'site:view:qualification:expired' => '(Expired)',
	'site:view:qualified' => 'Qualified',
	'site:view:add_contractor' => 'Add Contractor',
	'site:view:assign_contractor' => 'Assign Contractor',
	'site:view:assign_user_to_site' => 'Assign to site',
	'site:view:unassign_user_from_site' => 'Unassign from site',

	'site_user:add:full_name' => 'Full name',
	'site_user:add:username' => 'Username',
	'site_user:add:password1' => 'Password',
	'site_user:add:password2' => 'Confirm Password',
	'site_user:add:email' => 'Email',

	'site:message:validated' => 'Qualification Validated',
	'site:message:assigned' => 'User assigned to site',
	'site:message:unassigned' => 'User Unassigned from site',
);

add_translation('en', $english);
