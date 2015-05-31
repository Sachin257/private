<?php

// Get the organization for display in the bread crumbs.
$organization = get_organization_by_guid(intval(get_input("organization_guid")));

if ($organization === false) {
	register_error(elgg_echo('site:error:organization_not_found'));
	forward(get_input('forward', REFERER));
}

// Get the site, and check if it exists.
$site = get_site_by_guid(get_input('guid'));
if ($site === false) {
	register_error(elgg_echo('site:error:site_not_found'));
	forward(get_input('forward', REFERER));
}

elgg_push_breadcrumb(elgg_echo('breadcrumb:organizations'), '/organizations/all');
elgg_push_breadcrumb(elgg_echo($organization->title), '/organizations/view/' . $organization->guid);
elgg_push_breadcrumb(elgg_echo($site->title), '/site/view/?guid=' . $site->guid . '&organization_guid=' . $organization->guid);


/**
 * LIST SITE DETAILS
 */
$user = elgg_get_logged_in_user_entity();

// Check if user has enough privileges to view site details.
if (!user_can_view_site($user, $site)) {
	register_error(elgg_echo('site:error:unable_to_view_site'));
	forward(get_input('forward', REFERER));
}

// Check if user has enough privileges to edit the site.
if (user_can_edit_site($user, $site)) {
	$user_can_edit_site = true;
} else {
	$user_can_edit_site = false;
}

// Check if the user is a contractor.
if (user_is_contractor_of_site($user, $site)) {
	$user_is_contractor_of_site = true;
} else {
	$user_is_contractor_of_site = false;
}

elgg_load_js('googlemaps');

// Create title and attach to body.
$title = elgg_echo('site:title:site_details');
$body = elgg_view_title($site->title);

// Show site details.
$body .= '<div class="row"><div class="span4">';

if ( $site->description != '') {
	$body .= '<div class="organization-description">' . $site->description . '</div>';
}

if ( $site->address != '') {
	$body .= elgg_echo('site:extra:address') . ':' . elgg_view('output/longtext', array('name' => 'number', 'value' => $site->address)) . '</br>'; 
}

if ( $site->job_description != '') {
	$body .= elgg_echo('site:extra:job_description') . ':' . elgg_view('output/longtext', array('name' => 'job_description', 'value' => $site->job_description)) . '</br>'; 
}

if ( $site->general_contacts != '') {
	$body .= elgg_echo('site:extra:general_contacts') . ':' . elgg_view('output/text', array('name' => 'general_contacts', 'value' => $site->general_contacts)) . '</br>';
}

if ( $site->emergency_contacts != '') {
	$body .= elgg_echo('site:extra:emergency_contacts') . ':' . elgg_view('output/text', array('name' => 'emergency_contacts', 'value' => $site->emergency_contacts)) . '</br>';
}

if ( $site->out_of_hours_contacts != '') {
	$body .= elgg_echo('site:extra:out_of_hours_contacts') . ':' . elgg_view('output/text', array('name' => 'out_of_hours_contacts', 'value' => $site->out_of_hours_contacts)) . '</br>' ;
}

$body .= '</div>';

$body .= '<div class="span8">';

if ($site->map_url != '') {

$body .= '<div id="site-map-canvas"></div>'.
'<script>
  function initialize() {
	var map_canvas = document.getElementById("site-map-canvas");
	var myLatlng = new google.maps.LatLng('.$site->map_url.');
	var map_options = {
	  center: myLatlng,
	  zoom: 17,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	var map = new google.maps.Map(map_canvas, map_options);
	var marker = new google.maps.Marker({
		  position: myLatlng,
		  map: map,
		  title: \''.$site->title.'\'
	  });
  }
  google.maps.event.addDomListener(window, \'load\', initialize);
</script>';
}

$body .= '</div></div>';	

/**
 * LIST OF QUALIFICATION TYPES
 */
$title = elgg_echo('site:title:all_required__qualification_types');

// Only add lesson/qualification buttons if the user is allowed to use them.
if ($user_can_edit_site){
	// Create link for adding a new qualification.
	$add_qualification_link = elgg_view('output/url', array(
		'href' => "site_qualification/add?site_guid={$site['guid']}&organization_guid={$organization->guid}",
		'text' => elgg_echo('site:view:add_qualification_type'),
		'class' => 'elgg-button elgg-button-add float-alt'
	));
	
	// Create link for adding a new lesson.
	$add_lesson_link = elgg_view('output/url', array(
		'href' => "lesson/add?site_guid={$site['guid']}&organization_guid={$organization->guid}",
		'text' => elgg_echo('site:view:add_lesson'),
		'class' => 'elgg-button elgg-button-add float-alt'
	));	
	
	$body .= elgg_view_title(
		$title . '<div class="title-button-container">' . 
			$add_lesson_link . ' &nbsp;' . 
			$add_qualification_link . 
		'</div>'
	);

	// Get all qualification types for the site.
	$options = array(
		"relationship" => "qualification_type_of_site",
		'types' => 'object',
		'subtypes' => 'qualification_type',
		"relationship_guid" => $site->guid, 
		'inverse_relationship' => true,    
	);
	
	$qualification_types = elgg_get_entities_from_relationship($options);
	
	// Show each qualification type.
	foreach($qualification_types as $qualification_type) {
		$view_link = '';
		$edit_screens_link = '';
		$edit_info_link_lesson = '';
		$edit_info_link = '';
		$delete_link = '';
		$is_active_link = '';
		$options_user_qualifications = array();
		unset($options_user_qualifications);
		$user_qualifications = array();
		unset($user_qualifications);
	
		// Delete button HTML.
		$delete_url = "action/site_qualification/delete?guid={$site['guid']}&qualification_type_guid={$qualification_type['guid']}";
		$delete_link = elgg_view('output/confirmlink', array(
			'href' => $delete_url,
			'text' => elgg_echo('site:view:delete_qualification_type'),
			'class' => 'elgg-button elgg-button-delete float-alt'
		));
		
		// Check if the qualification type has a lesson.
		$lesson = get_lesson_of_qualification_type($qualification_type);
		
		if ($lesson !== false) {
			
			// Get the most recent lesson_version for the given lesson (active and unactive).
			$lesson_version_active = get_latest_lesson_version($lesson, 1);
			$lesson_version_inactive = get_latest_lesson_version($lesson, 0);
			
			if ($lesson->is_active == 0) {
				// Edit screens button HTML.
				$edit_screens_url = '/lesson/screen_list/' . $lesson_version_inactive->guid . '?site_guid=' . $site->guid . '&organization_guid=' . $organization->guid;
				$edit_screens_link = elgg_view('output/url', array(
					'href' => $edit_screens_url,
					'text' => elgg_echo('site:view:edit_screens'),
					'class' => 'elgg-button elgg-button-delete float-alt'
				));
			}
			
			// Edit info button HTML.
			$edit_info_url = "lesson/edit/{$lesson['guid']}&site_guid={$site->guid}&organization_guid={$organization->guid}";
			$edit_info_link = elgg_view('output/url', array(
				'href' => $edit_info_url,
				'text' => elgg_echo('site:view:edit_lesson'),
				'class' => 'elgg-button elgg-button-edit-information float-alt'
			));
			
			if (intval($lesson->is_active) == 1)
				$action = "deactivate";
			else
				$action = "activate";
				
			// Activate/deactivate button HTML.
			$is_active_url = "action/lesson/toggle_lesson_is_active?guid={$lesson['guid']}&toggle_action={$action}";
			$is_active_link = elgg_view('output/url', array(
				'href' => $is_active_url,
				'text' => elgg_echo($action),
				'class' => 'elgg-button elgg-button-edit-screens float-alt',
				'is_action' => TRUE
			));
			
			if (intval($lesson->is_active) == 0)
				$is_active_link .= ' &nbsp; ';
		} 
		
		if ($qualification_type->is_deleted != 1){
			$body .= 
				'<div class="general-list-row">
					<div class="list-item-title">' . $qualification_type->title . '</div> 
					<div class="list-item-options">' . 
						$is_active_link . $edit_screens_link . ' &nbsp; ' . $edit_info_link . ' &nbsp; ' . $delete_link . '
					</div>
				</div>'; 
		}
	}
	
	if (!$qualification_types) {
		$body .= 
			'<div class="general-list-row">
				<div class="list-item-title">' . elgg_echo("site:view:no_qualification_types") .'</div> 
			</div>'; 	
	}
	$body .= "<br /><br />";

	/**
	 * LIST OF CONTRACTORS ALLOWED TO WORK ON SITE.
	 */
	// Create link for adding a new contractor.
	$add_link_contractor = elgg_view('output/url', array(
		'href' => "site_user/add?site_guid={$site['guid']}&organization_guid={$organization->guid}",
		'text' => elgg_echo('site:view:add_contractor'),
		'class' => 'elgg-button elgg-button-add float-alt'
	));

	// Create link for adding a new contractor.
	$assign_contractor = elgg_view('output/url', array(
		'href' => "site_user/all?site_guid={$site['guid']}&organization_guid={$organization->guid}",
		'text' => elgg_echo('site:view:assign_contractor'),
		'class' => 'elgg-button elgg-button-add float-alt'
	));	

	$title = elgg_echo('site:title:all_contractors');

	$options_qualification_type= array(
		"relationship" => "qualification_type_of_site",
	    'types' => 'object',
	    'subtypes' => 'qualification_type',
	    "relationship_guid" => $site->guid, 
	    'inverse_relationship' => true,    
	);

	$qualification_types = elgg_get_entities_from_relationship($options_qualification_type);
	
	$body .= elgg_view_title($title . '<div class="title-button-container">' . $assign_contractor . ' &nbsp; ' . $add_link_contractor . '</div>');
	
	$options= array(
		"relationship" => "contractor_of_site",
		"relationship_guid" => $site->guid,
		'inverse_relationship' => true,
	);

	$contractors = elgg_get_entities_from_relationship($options);
	
	foreach($contractors as $contractor) {
		$user_has_qualification = true;
		$user_has_verified_qualification = true;
		$user_qualified = "";

		foreach($qualification_types as $qualification_type) {
			$qualifications = array();
			$options_qualifications = array();	

			unset($qualifications);
			unset($options_qualifications);
			$options_qualifications= array(
			    'types' => 'object',
			    'subtypes' => 'qualification',
			    'owner_guid' => $contractor->guid,
			    'relationship_guid' => $qualification_type->guid,
			    'inverse_relationship' => true
			);

			$qualifications = elgg_get_entities_from_relationship($options_qualifications);
			if (empty($qualifications)) {
				$user_has_qualification = false;
			}

			if ($user_has_qualification){
				// Get user qualification status.
				$user_qualifications_verification = get_user_qualification_status($qualifications[0]);

				if (!$user_qualifications_verification['is_validated'])
					$user_has_verified_qualification = false;
				if ($user_qualifications_verification['is_expired'])
					$user_has_verified_qualification = false;
			}			
		}
		if ($user_has_qualification && $user_has_verified_qualification)
			$user_qualified = '<span style="background-color:#90EE90;">' .  elgg_echo('site:view:qualified') . '</span>';
		
		$user_qualification_url = "/user_qualification/all?user_guid={$contractor->guid}&site_guid={$site->guid}";
		
		$body .= 
			'<div class="general-list-row">
				<div class="list-item-title"><a href = "' . $user_qualification_url . '">' . $contractor->name . '</a></div> 
				<div class="list-item-options">' . 
					$user_qualified
				. '</div>
			</div>'; 
	}
	
	if (!$contractors) {
		$body .= 
			'<div class="general-list-row">
				<div class="list-item-title">' . 
					elgg_echo("site:view:no_contractors1") . 
				'</div>' .
			'</div>' .
			'<div class="general-list-row">' .
				'<div class="list-item-title">' .
					elgg_echo("site:view:no_contractors2") .
					elgg_echo("site:view:add_contractor") . 
					elgg_echo("site:view:no_contractors3") . 
					elgg_echo("site:view:assign_contractor") . 
					elgg_echo("site:view:no_contractors4") . 
				'</div> 
			</div>'; 	
	}
}

/**
 * List of qualifications contractors have done/must do.
 */
if ($user_is_contractor_of_site) {
	$body .= elgg_view_title(elgg_echo('site:title:all_required__qualification_types'));
	$qualification_types = get_site_qualification_types($site);
	foreach ($qualification_types as $qualification_type) {
		$view_link = '';
		$view_user_qualification_status_validation = '';
		$view_user_qualification_status_expiration = '';

		// Check if the qualification type has a lesson.
		$lesson = get_lesson_of_qualification_type($qualification_type);

		// Check if the user has any qualifications for this qualification type.
		$user_qualifications = get_user_qualifications_by_qualification_type($user, $qualification_type);

		if ($lesson !== false) {
			// Get the most recent lesson_version for the given lesson (active and unactive).
			$lesson_version_active = get_latest_lesson_version($lesson, 1);
			$lesson_version_inactive = get_latest_lesson_version($lesson, 0);
			
			if ($lesson->is_active == 1) {
				// View button HTML.
				$view_url = "mod/lesson/lessonviewer/user.php?lesson_version_guid={$lesson_version_active['guid']}&sort_index=0&screen_guid={$screen['guid']}&site_guid={$site->guid}&organization_guid={$organization->guid}";
				$view_link = elgg_view('output/url', array(
					'href' => $view_url,
					'text' => elgg_echo('site:view:view_lesson'),
					'class' => 'elgg-button elgg-button-delete float-alt'
				));
			}
		} else {
			if (!empty($user_qualifications)) {
				// View button HTML.
				$view_url = "/qualification/view/{$user_qualifications[0]->guid}";
				$view_link = elgg_view('output/url', array(
					'href' => $view_url,
					'text' => elgg_echo('site:view:view_qualification'),
					'class' => 'elgg-button elgg-button-delete float-alt'
				));
				// Get user qualification status.
				$user_qualifications_status = get_user_qualification_status($user_qualifications[0]);

				if ($user_qualifications_status['is_validated'])
					$view_user_qualification_status_validation = elgg_echo('site:view:validated');
				else
					$view_user_qualification_status_validation = elgg_echo('site:view:not_validated');

				if ($user_qualifications_status['is_expired'])
					$view_user_qualification_status_expiration = elgg_echo('site:view:qualification:expired');			
			}

			else {
				// View button HTML.
				$view_url = "/qualification/add?qualification_type_guid={$qualification_type->guid}&site_guid={$site->guid}&organization_guid={$organization->guid}";
				$view_link = elgg_view('output/url', array(
					'href' => $view_url,
					'text' => elgg_echo('site:view:add_qualification'),
					'class' => 'elgg-button elgg-button-delete float-alt'
				));
			}
		}

		if ($qualification_type->is_deleted != 1){
			$body .= 
				'<div class="general-list-row">
					<div class="list-item-title">' . $qualification_type->title . ' &nbsp; ' . $view_user_qualification_status_validation . ' &nbsp; ' . $view_user_qualification_status_expiration . '</div> 
					<div class="list-item-options">' . 
						$view_link . ' 
					</div>
				</div>'; 
		}		
	}
}

$body = elgg_view_layout('one_column', array('content' => $body));
 
echo elgg_view_page($title, $body);