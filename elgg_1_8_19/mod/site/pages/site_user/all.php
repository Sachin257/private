<?php
	elgg_load_library("elgg:site");
	elgg_load_library("elgg:organizations");

	// Get the organization for display in the bread crumbs.
	$organization = get_organization_by_guid(intval(get_input("organization_guid")));

	if ($organization === false) {
		register_error(elgg_echo('site:error:organization_not_found'));
		forward(get_input('forward', REFERER));
	}

	// Get the site, and check if it exists.
	$site = get_site_by_guid(get_input('site_guid'));
	if ($site === false) {
		register_error(elgg_echo('site:error:site_not_found'));
		forward(get_input('forward', REFERER));
	}

	elgg_push_breadcrumb(elgg_echo('breadcrumb:organizations'), '/organizations/all');
	elgg_push_breadcrumb(elgg_echo($organization->title), '/organizations/view/' . $organization->guid);
	elgg_push_breadcrumb(elgg_echo($site->title), '/site/view/?guid=' . $site->guid . '&organization_guid=' . $organization->guid);

	/**
	 * LIST OF ALL CONTRACTORS
	 */

	$title = elgg_echo('site:title:contractors');

	$body = elgg_view_title($title);

	$options= array(
		"types" => "user",
	);

	$contractors = elgg_get_entities_from_relationship($options);

	foreach($contractors as $contractor) {
		$view_user_qualification_status_validation = true;
		$view_user_qualification_status_expiration = true;
		$user_qualified = '';
		$view_button = '';
		$view_button_link = '';

		if (check_entity_relationship($contractor->guid, "contractor_of_site", $site->guid)) {
			// Unassign contractor from site button HTML.
			$view_button_link = "action/site_user/unassign_user_from_site?&contractor_guid={$contractor['guid']}&site_guid={$site['guid']}&organization_guid={$organization['guid']}";
			$view_button = elgg_view('output/confirmlink', array(
				'href' => $view_button_link,
				'text' => elgg_echo('site:view:unassign_user_from_site'),
				'class' => 'elgg-button elgg-button-delete float-alt'
			));
		}
		else {
			// Assign contractor to site button HTML.
			$view_button_link = "action/site_user/assign_user_to_site?&contractor_guid={$contractor['guid']}&site_guid={$site['guid']}&organization_guid={$organization['guid']}";
			$view_button = elgg_view('output/confirmlink', array(
				'href' => $view_button_link,
				'text' => elgg_echo('site:view:assign_user_to_site'),
				'class' => 'elgg-button elgg-button-delete float-alt'
			));
		}	

		$qualification_types = get_site_qualification_types($site);
		foreach ($qualification_types as $qualification_type) {
			// Check if the user has any qualifications for this qualification type.
			$user_qualifications = get_user_qualifications_by_qualification_type($contractor, $qualification_type);
				
			if (!empty($user_qualifications)) {
				// Get user qualification status.
				$user_qualifications_status = get_user_qualification_status($user_qualifications[0]);
				if (!$user_qualifications_status['is_validated'])
					$view_user_qualification_status_validation = false;

				if ($user_qualifications_status['is_expired'])
					$view_user_qualification_status_expiration = false;			
			}
			else {
					$view_user_qualification_status_validation = false;
					$view_user_qualification_status_expiration = false;
			}	
		}
		if ($view_user_qualification_status_validation && $view_user_qualification_status_expiration)
			$user_qualified = '<span style="background-color:#90EE90;">' .  elgg_echo('site:view:qualified') . '</span>';
		
		$user_qualification_url = "/user_qualification/all?user_guid={$contractor->guid}&site_guid={$site->guid}";
			
		$body .= 
			'<div class="general-list-row">
				<div class="list-item-title"><a href = "' . $user_qualification_url . '">' . $contractor->name . '</a></div> 
				<div class="list-item-options">'  . 
					$user_qualified . ' &nbsp; ' . $view_button
				. '</div>
			</div>';		
	}

	if (!$contractors) {
		$body .= 
			'<div class="general-list-row">
				<div class="list-item-title">' . elgg_echo("site:view:no_contractors") . '</div> 
			</div>'; 	
	}
	$body = elgg_view_layout('one_column', array('content' => $body));
	 
	echo elgg_view_page($title, $body);
?>