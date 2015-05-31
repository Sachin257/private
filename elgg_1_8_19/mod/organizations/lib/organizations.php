<?php

/**
 * get_organization_by_guid
 * @method
 * @param {integer} $organization_guid
 * @return {object} organization entity.
 */
function get_organization_by_guid($organization_guid) {
	$entity = get_entity($organization_guid);
	
	if (elgg_instanceof($entity, 'object', 'organization')) {
		return $entity;
	} else {
		return false;
	}
}

/**
 * 
 */ 
function user_is_organization_contractor($user, $organization) {
	$sites_of_organization = get_sites_of_organization($organization);

	foreach ($sites_of_organization as $site) {
		if (check_entity_relationship ($user->guid, "contractor_of_site", $site->guid)) {
			return true;
		}
	}
	
	return false;
}

/**
 *
 */
function get_sites_of_organization($organization) {
	$options = array(
		"relationship" => "site_of_organization", 
		"relationship_guid" => $organization->guid, 
		"inverse_relationship" => true, 
		"limit" => ELGG_ENTITIES_NO_VALUE
	);

	return elgg_get_entities_from_relationship($options);
}

/**
 * validate_abn_input
 * @method Validate the abn, check if it's been used befor or not, and if it's 11 digital number
 * @param {string} $abn
 * @return {boolean}
 */
function validate_abn_input($abn) {
	$organizations = elgg_get_entities_from_relationship(array(
				      'types' => 'object',
				      'subtypes' => 'organization',
				      'limit' => false,           
				      'metadata_name_value_pairs' => array(
				            'name' => "abn",
				            'value' => $abn,
				            'operand' => '='
				        ),          
					));

	if (empty($organizations) && is_numeric($abn) && strlen($abn) == 11)
		return true;
	else
		return false;
}
?>