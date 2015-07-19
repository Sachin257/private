<?php
$contact = get_sanitised_input('contact');
$contact_email = get_sanitised_input('contact_email');
$contact_postal_address = get_sanitised_input('contact_postal_address');
$contact_town = get_sanitised_input('contact_town');
$contact_state = get_sanitised_input('contact_state');
$contact_postcode = get_sanitised_input('contact_postcode');
$contact_country= get_sanitised_input('contact_country');
$contact_id= get_sanitised_input('contact_id');

$company_guid = get_sanitised_input('company_id');

$guid = get_sanitised_input('guid');

$manager_arr['name'] =  $contact;
$manager_arr['email'] =  $contact_email;
$manager_arr['street1'] =  $contact_postal_address;
$manager_arr['town'] =  $contact_town;
$manager_arr['state'] =  $contact_state;
$manager_arr['postcode'] =  $contact_postcode;
$manager_arr['country'] =  $contact_country;

if(!check_unique_company_primary_contact($contact_email, $company_guid))
{
	register_error(elgg_echo('company:contact:unique:error'));
	forward(REFERER);
}
if($guid)
{
	$entity = get_entity($guid);
	if (!$entity || !($entity instanceof ElggUser)) {
		register_error(elgg_echo('profile:error:save'));
		forward(REFERER);
	} else {
		$manager = $entity;
		extract($manager_arr);
		$manager->name = $name;
		$manager->street1 = $street1;
		$manager->town = $town;
		$manager->state = $state;
		$manager->postcode = $postcode;
		$manager->country = $country;
		$manager->save();
		set_user_display_name($name,$guid);
		system_message(elgg_echo("manager:message:updated"));
		forward("/manager/all");
	}
} else {
	if ($company_guid){
		$company = get_entity($company_guid);
		if (elgg_instanceof($company, 'object', 'company')) {
			$profile_type_arr = get_custom_profile_types(MANAGER_PROFILE_TYPE);
			$manager_profile_type_guid = ($profile_type_arr && isset($profile_type_arr['guid']) ) ? $profile_type_arr['guid'] :0;
			$guid = 1;
			system_message(elgg_echo("manager:message:saved"));
			forward("/manager/all");
		} else {
			register_error(elgg_echo('company:error:company_not_found'));
			forward( REFERER);
		}
	} else {
		register_error(elgg_echo('company:error:company_not_found'));
		forward( REFERER);
	}
}
