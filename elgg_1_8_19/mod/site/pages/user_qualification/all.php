<?php
/**
* View a contractor qualifications for selected site.
*/
$site_guid = get_input('site_guid');
$contractor_guid = get_input('user_guid');

$options_organization= array(
	'relationship' => 'site_of_organization',
    'types' => 'object',
    'subtypes' => 'organization',
    'relationship_guid' => $site_guid, 
    'inverse_relationship' => false,    
);

$organizations = elgg_get_entities_from_relationship($options_organization);
$organization_guid = $organizations[0]->guid;

$user = elgg_get_logged_in_user_entity();

// Check if the organization exists and that the user has privelage to see it.
if ($organization_guid && $site_guid){
	$entity_organization = get_entity($organization_guid);
	$entity_site = get_entity($site_guid);
	$entity_contractor = get_entity($contractor_guid);
	if (elgg_instanceof($entity_organization, 'object', 'organization') && elgg_instanceof($entity_site, 'object', 'site')) {
		if (check_entity_relationship($user->guid, 'manager_of_organization', $organization_guid)) {
			$is_organization_manager = true; 
			$organization = $entity_organization;
			$site = $entity_site;
			$contractor = $entity_contractor;
		} else if (check_entity_relationship($user->guid, 'contractor_of_site', $site)) {
			$is_organization_manager = false;
			$is_contractor = true; 
			$organization = $entity_organization;
			$site = $entity_site;
			$contractor = $entity_contractor;
		} else {
			register_error(elgg_echo('site:error:organization_not_found'));
			forward(get_input('forward', REFERER));
		}
	} else {
		register_error(elgg_echo('site:error:organization_not_found'));
		forward(get_input('forward', REFERER));
	}
}

if ($is_contractor)
	$title = elgg_echo('site:title:all_qualifications');

if ($is_organization_manager)
	$title = elgg_echo('site:title:all_qualifications');

$body = elgg_view_title($title);
$body .= elgg_view('output/url', array(
				'href' => 'profile/' . $contractor->username,
				'text' => $contractor->name,
				'class' => 'organization-description',
			));

$body .= '<div class="organization-description">' . $contractor->description . '</div>';

$options_qualification_type= array(
	"relationship" => "qualification_type_of_site",
    'types' => 'object',
    'subtypes' => 'qualification_type',
    "relationship_guid" => $site->guid, 
    'inverse_relationship' => true,    
);

$qualification_types = elgg_get_entities_from_relationship($options_qualification_type);

foreach($qualification_types as $qualification_type) {
	$view_user_qualification = "";
	$qualifications = array();
	$options_qualifications = array();	

	unset($qualifications);
	unset($options_qualifications);
	$options_qualifications= array(
	    'types' => 'object',
	    'subtypes' => 'qualification',
	    'owner_guid' => $contractor_guid,
	    'relationship_guid' => $qualification_type->guid,
	    'inverse_relationship' => true
	);

	$qualifications = elgg_get_entities_from_relationship($options_qualifications);

	$can_edit_qualification = false;
	$qualification_is_visible = false;
	$user_has_qualification = false;

	if (!empty($qualifications)) {
		$user_has_qualification = true;
	}	

	if ($is_organization_manager) {
		$can_edit_qualification = true;
		$qualification_is_visible = true;
	} else {
		if ($is_contractor)  {
			$qualification_is_visible = true;
		}
	}
		
	// Only display qualification buttons if the user is manager of organization
	if ($can_edit_qualification) {
		if ($user_has_qualification) {
			// View user qualification button HTML.
			$view_url_user_qualification = "qualification/view/{$qualifications[0]->guid}";
			$view_user_qualification = elgg_view('output/url', array(
				'href' => $view_url_user_qualification,
				'text' => elgg_echo('site:view:view_user_qualification'),
				'class' => 'elgg-button elgg-button-delete float-alt'
			));

			// Validate button HTML.
			$validate_user_qualification = "action/user_qualification/validate?qualification_guid={$qualifications[0]->guid}&contractor_guid=$contractor_guid&site_guid={$site['guid']}&organization_guid={$organization['guid']}";
			$validate = elgg_view('output/confirmlink', array(
				'href' => $validate_user_qualification,
				'text' => elgg_echo('site:view:validate_user_qualification'),
				'class' => 'elgg-button elgg-button-delete float-alt'
			));			
		}
		else {

		}	
	}
	 else {
	}
		
	if ($qualification_is_visible && $qualification_type->is_deleted != 1) {
		if ($user_has_qualification) {
				$qualification_validation = array();
				$options_qualification_validation = array();	

				unset($qualification_validation);
				unset($options_qualification_validation);

				$options_qualification_validation = array(
					'relationship' => 'validated_by',
				    'relationship_guid' => $qualifications[0]->guid, 
				    'inverse_relationship' => false,
				);

				$qualification_validation = elgg_get_entities_from_relationship($options_qualification_validation);
				($qualification->expired_date != 0 && time() - $qualifications[0]->expired_date) > (0) ? $expired = ' - <span style="background-color:#FF0000;">' . elgg_echo('site:view:qualification:expired') . '</span>' : $expired = '' ;
				if (!empty($qualification_validation)) {
								
					$body .= 
						'<div class="general-list-row" style="background-color:#90EE90;">
							<div class="list-item-title">' . $qualification_type->title . $expired . '</div>
							<div class="list-item-options">' . 
								$view_user_qualification . ' &nbsp; ' . elgg_echo("site:view:validated") . '
							</div>					
						</div>';
				}
				else {			
					$body .= 
						'<div class="general-list-row" style="background-color:#FFFF99;">
							<div class="list-item-title">' . $qualification_type->title . $expired . '</div>
							<div class="list-item-options">' . 
								$view_user_qualification . ' &nbsp; ' . $validate . '
							</div>					
						</div>';
				}			
		}
		else {
			$body .= 
				'<div class="general-list-row" style="background-color:#FF7F50;color:white">
					<div class="list-item-title">' . $qualification_type->title . '</div>
				</div>';
		}
	}
}

$body = elgg_view_layout('one_column', array('content' => $body));
 
echo elgg_view_page($title, $body);