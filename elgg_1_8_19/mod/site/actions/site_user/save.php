<?php
/**
 * Elgg add action
 * Creates a user and adds them to a site.
 */
elgg_load_library("elgg:site");
elgg_load_library("elgg:organizations");

// Get variables
$username = get_input('username');
$password = get_input('password1', null, false);
$password2 = get_input('password2', null, false);
$email = get_input('email');
$name = get_input('name');
$site_guid = get_input('site_guid');
$organization_guid = get_input('organization_guid');

if ($site_guid){
	$entity = get_entity($site_guid);
	if (elgg_instanceof($entity, 'object', 'site')) {
		$site = $entity;
		if (!user_can_edit_site){
			register_error(elgg_echo('site_user:error:cannot_edit_site'));
			forward(REFERER);
		}
	} else {
		register_error(elgg_echo('site_user:error:site_not_found'));
		forward(REFERER);
	}
}

// no blank fields
if ($username == '' || $password == '' || $password2 == '' || $email == '' || $name == '') {
	register_error(elgg_echo('register:fields'));
	forward(REFERER);
}

if (strcmp($password, $password2) != 0) {
	register_error(elgg_echo('RegistrationException:PasswordMismatch'));
	forward(REFERER);
}

// For now, just try and register the user
try {
	$guid = register_user($username, $password, $name, $email, TRUE);

	if ($guid) {
		$new_user = get_entity($guid);

		$subject = elgg_echo('useradd:subject');
		$body = elgg_echo('useradd:body', array(
			$name,
			elgg_get_site_entity()->name,
			elgg_get_site_entity()->url,
			$username,
			$password,
		));

		//notify_user($new_user->guid, elgg_get_site_entity()->guid, $subject, $body);
		
		
		add_entity_relationship($guid, "contractor_of_site", $site->guid);

		system_message(elgg_echo("adduser:ok", array(elgg_get_site_entity()->name)));
	} else {
		register_error(elgg_echo("adduser:bad"));
	}
} catch (RegistrationException $r) {
	register_error($r->getMessage());
}

forward('site/view?guid=' . $site_guid . '&organization_guid=' . $organization_guid);