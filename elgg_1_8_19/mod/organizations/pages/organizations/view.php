<?php
	$user = elgg_get_logged_in_user_entity();

	// Get the organization guid for the organization.
	$organization_guid = intval($segments[1]);

	// Check if the organization exists and that the user has privelage to see it.
	if ($organization_guid){
		$entity = get_entity($organization_guid);
		if (elgg_instanceof($entity, 'object', 'organization')) {
			if (check_entity_relationship($user->guid, 'manager_of_organization', $organization_guid)) {
				$is_organization_manager = true; 
				$organization = $entity;
			} else if (user_is_organization_contractor($user, $organization_guid)) {
				$is_organization_manager = false; 
				$organization = $entity;
			} else {
				register_error(elgg_echo('organizations:message:organization_not_found'));
				forward(get_input('forward', REFERER));
			}
		} else {
			register_error(elgg_echo('organizations:message:organization_not_found'));
			forward(get_input('forward', REFERER));
		}
	}

	elgg_push_breadcrumb(elgg_echo('breadcrumb:organizations'), '/organizations/all');
	elgg_push_breadcrumb(elgg_echo($organization->title), '/organizations/view/' . $organization->guid);
		
	$body = elgg_view_title($organization->title . elgg_echo('organizations:title:view_organization'));

// Show organization details.
 
	$body .= '<div class="row"><div class="span4">';
	if ( $organization->abn != '') {
		$body .=  '<strong><div class="organization-description">' . elgg_echo('organizations:extra:abn') . ': ' . substr($organization->abn, 0, 2) . ' ' . chunk_split(substr($organization->abn, 2, 9), 3, ' ') . '</div></strong>';
	}

	if ( $organization->description != '') {
		$body .= '<div class="organization-description">' . $organization->description . '</div>';
	}
	
	if ( $organization->address != '') {
		$body .= elgg_echo('organizations:extra:address') . ': ' . elgg_view('output/longtext', array('name' => 'address', 'value' => $organization->address)) . '</br>'; 
	}
	
	if ( $organization->tel != '') {
		$body .= elgg_echo('organizations:extra:tel') . ': ' . elgg_view('output/text', array('name' => 'tel', 'value' => $organization->tel)) . '</br>'; 
	}
	
	if ( $organization->fax != '') {
		$body .= elgg_echo('organizations:extra:fax') . ': ' . elgg_view('output/text', array('name' => 'fax', 'value' => $organization->fax)) . '</br>';
	}
 
 	if ( $organization->email != '') {
		$body .= elgg_echo('organizations:extra:email') . ': ' . elgg_view('output/text', array('name' => 'email', 'value' => $organization->email)) . '</br>';
	}
	
 	if ( $organization->website != '') {
		$body .= elgg_echo('organizations:extra:website') . ': ' . elgg_view('output/url', array('name' => 'website', 'value' => $organization->website, 'target' => '_blank')) . '</br>' ;
	}
	
	$body .= '</div></div>';
	
	if ($is_organization_manager) {
		// Create link for adding a new site.
		$add_link = elgg_view('output/url', array(
			'href' => "site/add/{$organization['guid']}",
			'text' => elgg_echo('organizations:view:add_site'),
			'class' => 'elgg-button elgg-button-add float-alt'
		));
	} else {
		$add_link = '';	
	}
	
	$title = elgg_echo('organizations:title:all_sites');
	
	$body .= elgg_view_title($title . '<div class="title-button-container">' . $add_link . '</div>');
	
	$options = array(
		"relationship" => "site_of_organization", 
		"inverse_relationship" => true, 
		"relationship_guid" => $organization->guid, 
		"limit" => ELGG_ENTITIES_NO_VALUE
	);
	
	$sites = elgg_get_entities_from_relationship($options);
		
	foreach($sites as $site) {
		if ($is_organization_manager) {
			$can_edit_site = true;
			$site_is_visible = true;
		} else {
			if (check_entity_relationship ($user->guid, "contractor_of_site", $organization->guid))  {
				$can_edit_site = false;
				$organization_is_visible = true;
			} else {
				$can_edit_site = false;					
				$organization_is_visible = false;			
			}
		}
			
		// Only display the delete, edit screen and edit info links if this user is the owner.
		if ($can_edit_site) {
			
			// Delete button HTML.
			$delete_url = "action/site/delete?guid={$site['guid']}&organization_guid={$organization['guid']}";
			$delete_link = elgg_view('output/confirmlink', array(
				'href' => $delete_url,
				'text' => elgg_echo('organizations:view:delete_site'),
				'class' => 'elgg-button elgg-button-delete float-alt'
			));
			
			// Edit info button HTML.
			$edit_info_url = "site/edit/{$site['guid']}?organization_guid={$organization->guid}";
			$edit_info_link = elgg_view('output/url', array(
				'href' => $edit_info_url,
				'text' => elgg_echo('organizations:view:edit_site'),
				'class' => 'elgg-button elgg-button-edit-information float-alt'
			));
		} else {
			$delete_link = $edit_info_link = '';
		}
		
		$site_is_visible = true;
		
		if ($site_is_visible && $site->is_deleted != 1){
			$body .= 
				'<div class="general-list-row">
					<div class="list-item-title">
						<a href="/site/view?guid=' . $site["guid"] . '&organization_guid=' . $organization["guid"] . '">' . $site->title . '</a> 
					</div>
					<div class="list-item-options">' . 
						$edit_info_link . ' &nbsp; ' . $delete_link . '
					</div>
				</div>'; 
		}
	}
	
	$body = elgg_view_layout('one_column', array('content' => $body));
	//$body .= elgg_view_title($title . '<div style="float: right">' . $add_link . '</div>');
	 
	echo elgg_view_page($title, $body);
?>