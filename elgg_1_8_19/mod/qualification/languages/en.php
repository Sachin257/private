<?php
/**
 * qualification English language file.
 *
 */

$english = array(
	'qualification' => 'Qualifications',
	'qualification:qualifications' => 'Qualifications',
	'qualification:revisions' => 'Revisions',
	'qualification:archives' => 'Archives',
	'qualification:qualification' => 'Qualification',
	'qualification:mine' => 'My qualification',
	'item:object:qualification' => 'Qualifications',

	'qualification:title:user_qualifications' => '%s\'s qualifications',
	'qualification:title:all_qualifications' => 'All site qualifications',
	'qualification:title:friends' => 'Friends\' qualifications',

	'qualification:group' => 'Group qualification',
	'qualification:enablequalification' => 'Enable group qualification',
	'qualification:write' => 'Write an qualification',

	// Editing
	'qualification:add' => 'Add a qualification',
	'qualification:edit' => 'Edit qualification',
	'qualification:excerpt' => 'Excerpt',
	'qualification:body' => 'Body',
	'qualification:save_status' => 'Last saved: ',
	'qualification:never' => 'Never',

	// Statuses
	'qualification:status' => 'Status',
	'qualification:status:draft' => 'Draft',
	'qualification:status:published' => 'Published',
	'qualification:status:unsaved_draft' => 'Unsaved Draft',

	'qualification:revision' => 'Revision',
	'qualification:auto_saved_revision' => 'Auto Saved Revision',

	// messages
	'qualification:message:saved' => 'Qualification saved.',
	'qualification:error:cannot_save' => 'Cannot save qualification.',
	'qualification:error:cannot_write_to_container' => 'Insufficient access to save qualification to group.',
	'qualification:messages:warning:draft' => 'There is an unsaved draft of this post!',
	'qualification:edit_revision_notice' => '(Old version)',
	'qualification:message:deleted_post' => 'Qualification deleted.',
	'qualification:error:cannot_delete_post' => 'Cannot delete qualification.',
	'qualification:none' => 'No qualifications',
	'qualification:error:missing:title' => 'Please enter a qualification title!',
	'qualification:error:missing:description' => 'Please enter the body of your qualification!',
	'qualification:error:cannot_edit_post' => 'This qualification may not exist or you may not have permissions to edit it.',
	'qualification:error:revision_not_found' => 'Cannot find this revision.',

	'qualification:error:number_exists' => 'The number you entered does exist.',

	// river
	'river:create:object:qualification' => '%s published an qualification %s',
	'river:comment:object:qualification' => '%s commented on the qualification %s',

	// notifications
	'qualification:newpost' => 'A new qualification',
	'qualification:notification' =>
'
%s made a new qualification.

%s
%s

View and comment on the new qualification:
%s
',

	// widget
	'qualification:widget' => 'Qualifications',
	'qualification:widget:description' => 'Display your latest qualifications',
	'qualification:morequalifications' => 'More qualifications',
	'qualification:numbertodisplay' => 'Number of qualifications to display',
	'qualification:noqualifications' => 'No qualifications',

	// extra data
	'qualification:extra:type' => 'Qualification Type',
	'qualification:extra:number' => 'Qualification Number',
	'qualification:extra:granted_date' => 'Granted Date',
	'qualification:extra:expired_date' => 'Expired Date',
	'qualification:extra:organization' => 'Organisation',
	'qualification:extra:document' => 'Qualification Image',
	'qualification:extra:validated_by' => 'Validated By',
	'qualification:extra:not_validated' => 'Not validated',
);

add_translation('en', $english);
