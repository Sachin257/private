<?php
/**
 * get_site_by_guid
 * @method
 * @param {int} $site_guid
 * @return {object} $site object or false on error.
 */
function get_site_by_guid($site_guid) {
	// Get the screen entity object.
	$entity = get_entity(intval($site_guid));
	
	if (elgg_instanceof($entity, 'object', 'site')) {
		return $entity;
	} else {
		return false;
	}
}

/**
 * user_can_edit_site
 * For a given user and site, checks to see if the user has enough privileges to 
 * edit the site.
 * @method
 * @param {object} $user
 * @param {object} $site
 * @return {boolean} True if user can edit the site.
 */
function user_can_edit_site($user, $site) {
	if (user_is_manager_of_site_organization($user, $site))
		return true;
	else 
		return false;
}

/**
 * user_can_view_site
 * For a given user and site, checks to see if the user has enough privileges to 
 * view the site.
 * @method
 * @param {object} $user
 * @param {object} $site
 * @return {boolean} True if user can view the site.
 */
function user_can_view_site($user, $site) {
	if ((user_can_edit_site($user, $site)) || (user_is_contractor_of_site($user, $site)))
		return true;
	else 
		return false;
}

/**
 * user_is_contractor_of_site
 * For a given user and site, checks to see if the user is a contractor of that site. 
 * @method
 * @param {object} $user
 * @param {object} $site
 * @return {boolean} True if user is a contractor of that site.
 */
function user_is_contractor_of_site($user, $site) {
	if (check_entity_relationship($user->guid, 'contractor_of_site', $site->guid))
		return true;
	else 
		return false;
}

/**
 * user_is_manager_of_site_organization
 * Check if a given user is a manager for any organizations that are parents of the given site.
 * @param {object} $user 
 * @param {object} $site The site whose parent organizations will be checked.
 * @return {boolean} True if user is a manager of any organization checked.
 */
function user_is_manager_of_site_organization($user, $site) {
	$site_parent_organizations = get_site_parent_organizations($site);
	
	foreach ($site_parent_organizations as $organization) {
		if (check_entity_relationship($user->guid, 'manager_of_organization', $organization->guid))
			return true;
	}
	
	return false;
}

/**
 * get_site_parent_organizations
 * Gets an array of all parent organizations of a given site.
 * @method
 * @param {object} $site
 * @return {array} A list of parent organizations for the given site.
 */
function get_site_parent_organizations($site) {
	$options = array(
		"relationship" => "site_of_organization", 
		"relationship_guid" => $site->guid, 
		"limit" => ELGG_ENTITIES_NO_VALUE
	);
	
	return elgg_get_entities_from_relationship($options);
}

/**
 * get_user_qualifications_by_site
 * Gets an array of all qualification types of a given site and check if the given user has that qualification or not plus the status of that.
 * @method
 * @param {object} $site, {object} $user
 * @return {array} A list of qualifciation types + ({array} user qualifications + is_validated and is_expired(if exists)).
 */
function get_user_qualifications_by_site($site, $user) {
	$options_qualification_type= array(
		"relationship" => "qualification_type_of_site",
	    'types' => 'object',
	    'subtypes' => 'qualification_type',
	    "relationship_guid" => $site->guid, 
	    'inverse_relationship' => true,    
	);

	$qualification_types = elgg_get_entities_from_relationship($options_qualification_type);

	for ($i = 0; $i < sizeof($qualification_types); $i++) { 

		$user_has_qualification = false;
		$user_qualifications = array();
		$options_user_qualifications = array();	

		unset($user_qualifications);
		unset($options_user_qualifications);
		$options_user_qualifications= array(
		    'types' => 'object',
		    'subtypes' => 'qualification',
		    'owner_guid' => $user->guid,
		    'relationship_guid' => $qualification_types[$i]->guid,
		    'inverse_relationship' => true
		);

		$user_qualifications = elgg_get_entities_from_relationship($options_user_qualifications);
		if(!empty($user_qualifications))
			$user_has_qualification = true;
		if ($user_has_qualification) {

			for ($j = 0; $j < sizeof($user_qualifications); $j++) { 
				$qualification_validation = array();
				$options_qualification_validation = array();	

				unset($qualification_validation);
				unset($options_qualification_validation);

				$options_qualification_validation = array(
					'relationship' => 'validated_by',
				    'relationship_guid' => $user_qualifications[$j]->guid, 
				    'inverse_relationship' => false,
				);

				$qualification_validation = elgg_get_entities_from_relationship($options_qualification_validation);
				$user_qualifications[$j] = (array)$user_qualifications;
				$user_qualifications[$j]['verifications'] = array('is_validated' => false, 'is_expired' => false);

				if (!empty($qualification_validation))
					$user_qualifications[$j]['verifications']['is_validated'] = true;
			
				if (time() - $user_qualifications[$j][0]->expired_date > 0)
					$user_qualifications[$j]['verifications']['is_expired'] = true;

				$user_qualifications[$j] = (object)$user_qualifications[$j];
			}
			$qualification_types[$i] = (array)$qualification_types[$i];
			$qualification_types[$i]['qualifications'] = $user_qualifications;
			$qualification_types[$i] = (object)$qualification_types[$i];
		}
	}

	return $qualification_types;
}

/**
 * get_site_qualification_types
 * Gets an array of all qualification types of a given site.
 * @method
 * @param {object} $site
 * @return {array} A list of qualifciation types.
 */
function get_site_qualification_types($site) {
	$options= array(
		"relationship" => "qualification_type_of_site",
	    'types' => 'object',
	    'subtypes' => 'qualification_type',
	    "relationship_guid" => $site->guid, 
	    'inverse_relationship' => true,    
	);

	return elgg_get_entities_from_relationship($options);
}

/**
 * get_user_qualifications_by_qualification_type
 * Gets an array of all user qualifications of a given qualification type.
 * @method
 * @param {object} $user, {object} $qualification_type
 * @return {array} A list of qualifciations.
 */
function get_user_qualifications_by_qualification_type($user, $qualification_type) {
	$options= array(
	    'types' => 'object',
	    'subtypes' => 'qualification',
	    'owner_guid' => $user->guid,
	    'relationship_guid' => $qualification_type->guid,
	    'inverse_relationship' => true
	);

	return elgg_get_entities_from_relationship($options);
}

/**
 * get_user_qualification_status
 * Gets an array of user qualification status.
 * @method
 * @param {object} $qualification
 * @return {array} A list of qualifciations.
 */
function get_user_qualification_status($qualification) {
	$qualification_status = array('is_validated' => false , 'is_expired' => false);
	$options = array(
		'relationship' => 'validated_by',
	    'relationship_guid' => $qualification->guid, 
	    'inverse_relationship' => false,
	);

	$qualification_validation = elgg_get_entities_from_relationship($options);

	if (!empty($qualification_validation))
		$qualification_status['is_validated'] = true;
	if ($qualification->expired_date != 0 && time() - $qualification->expired_date > 0)
		$qualification_status['is_expired'] = true;

	return $qualification_status;
}
?>

