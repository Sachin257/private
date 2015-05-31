<?php
$user_guid = get_input('user_guid');
$emergency_contact_guid = get_input('guid');
$name = strip_tags(get_input('name'));
$email = strip_tags(get_input('email'));
$middlename =  strip_tags(get_input('middlename'));
$lastname =  strip_tags(get_input('lastname'));
$mobile =  strip_tags(get_input('mobile'));
$homephone =  strip_tags(get_input('homephone'));
$street1 =  strip_tags(get_input('street1'));
$street2 =  strip_tags(get_input('street2'));
$town =  strip_tags(get_input('town'));
$state =  strip_tags(get_input('state'));
$postcode =  strip_tags(get_input('postcode'));

if ($emergency_contact_guid){
	$entity = get_entity($emergency_contact_guid);
	if (elgg_instanceof($entity, 'object', 'emergency_contact') && $entity->canEdit()) {
		$emergency_contact = $entity;
	} else {
		register_error(elgg_echo('profile:emergency_contact:error:not_found'));
		forward( REFERER);
	}
} else {
	// create a new site object
	$emergency_contact = new ElggObject();
}

$emergency_contact->title = $name;
$emergency_contact->description = "emergencycontact";
$emergency_contact->subtype = "emergency_contact";
$emergency_contact->name = $name;
$emergency_contact->email = $email;
$emergency_contact->middlename = $middlename;
$emergency_contact->lastname = $lastname;
$emergency_contact->mobile = $mobile;
$emergency_contact->homephone = $homephone;
$emergency_contact->street1 = $street1;
$emergency_contact->street2 = $street2;
$emergency_contact->town = $town;
$emergency_contact->state = $state;
$emergency_contact->postcode = $postcode;

// owner is logged in user
$emergency_contact->owner_guid = $user_guid;//elgg_get_logged_in_user_guid();

// save other fields as metadata

// save to database and get id of the new site
$emergency_contact_guid = $emergency_contact->save();

if ($emergency_contact_guid && $user_guid) {
	add_entity_relationship($emergency_contact_guid, "emergency_contact_of_user", $user_guid);
}


// if the site was saved, we want to display the new site
// otherwise, we want to register an error and forward back to the form
if ($emergency_contact_guid) {
	system_message(elgg_echo("profile:emergency_contact:saved"));
	$po_user = get_entity($user_guid);
	forward("/user/".$po_user->username."/certification");//forward(REFERER);
} else {
	register_error(elgg_echo("profile:emergency_contact:not_saved"));
	forward(REFERER); // REFERER is a global variable that defines the previous page
}