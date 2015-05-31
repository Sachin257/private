<?php
	elgg_push_breadcrumb(elgg_echo('breadcrumb:organizations'), '/organizations/all');

	$organizations = elgg_get_entities(array(
		'type' => 'object',
		'subtype' => 'organization',
		"limit" => ELGG_ENTITIES_NO_VALUE,
	));

	$current_user = elgg_get_logged_in_user_entity();

	$can_add_organization = true; // Users will have to pay for this.
	
	// Create link for adding a new organization.
	$add_link = elgg_view('output/url', array(
		'href' => "organizations/add",
		'text' => elgg_echo('organizations:all:add_organization'),
		'class' => 'elgg-button elgg-button-add float-alt'
	));
	
	if ($can_add_organization)
		$title = elgg_echo('organizations:title:all_organizations');
	
	$body = elgg_view_title($title . '<div class="title-button-container">' . $add_link . '</div>');
	
	foreach($organizations as $organization){
		
		if (check_entity_relationship ($current_user->guid, "manager_of_organization", $organization->guid)) {
			$can_edit_organization = true;
			$organization_is_visible = true;
		} else {
			if (user_is_organization_contractor($current_user, $organization))  {
				$can_edit_organization = false;
				$organization_is_visible = true;
			} else {
				$can_edit_organization = false;					
				$organization_is_visible = false;			
			}
		}
			
		// Only display the delete, edit screen and edit info links if this user is the owner.
		if ($can_edit_organization) {
			
			// Delete button HTML.
			$delete_url = "action/organizations/delete?guid={$organization['guid']}";
			$delete_link = elgg_view('output/confirmlink', array(
				'href' => $delete_url,
				'text' => elgg_echo('organizations:all:delete_organization'),
				'class' => 'elgg-button elgg-button-delete float-alt'
			));
			
			// Edit info button HTML.
			$edit_info_url = "organizations/edit/{$organization['guid']}";
			$edit_info_link = elgg_view('output/url', array(
				'href' => $edit_info_url,
				'text' => elgg_echo('organizations:all:edit_organization'),
				'class' => 'elgg-button elgg-button-edit-information float-alt'
			));
		} else {
			$delete_link = $view_sites_link = $edit_info_link = '';
		}
		
		if ($organization_is_visible && $organization->is_deleted != 1){
			$body .= 
				'<div class="general-list-row">
					<div class="list-item-title">
						<a href="/organizations/view/' . $organization["guid"] . ' ">' . $organization->title . '</a>
					</div> 
					<div class="list-item-options">' . 
						$view_sites_link . ' &nbsp; ' . $edit_info_link . ' &nbsp; ' . $delete_link . '
					</div>
				</div>'; 
		}
	}
	
	$body = elgg_view_layout('one_column', array('content' => $body));
	 
	echo elgg_view_page($title, $body);
?>