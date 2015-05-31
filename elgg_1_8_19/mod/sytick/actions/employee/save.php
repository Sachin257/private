<?php
$name = get_sanitised_input('name');
$email = get_sanitised_input('email');
$street1 = get_sanitised_input('street1');
$town = get_sanitised_input('town');
$state = get_sanitised_input('state');
$postcode = get_sanitised_input('postcode');
$country = get_sanitised_input('country');
$custom_profile_type = get_sanitised_input('custom_profile_type');


$guid = get_sanitised_input('guid');

$username = substr($email, 0, strpos($email,'@'));

if(strlen($username) < 5)
{
	$to_add = 5 - strlen($username);
	$username = str_pad($username, $to_add, "0", STR_PAD_RIGHT);
}
$username = get_unique_username($username , $guid);
//die($username);
if(check_useremail_exists($email, $guid))
{
	register_error(elgg_echo('manager:error:save'));
	forward(REFERER);
}

if(check_username_exists($username, $guid))
{
	register_error(elgg_echo('manager:error:save'));
	forward(REFERER);
}

if($guid)
{
	$entity = get_entity($guid);
	if (!$entity || !($entity instanceof ElggUser)) {
		register_error(elgg_echo('profile:error:save'));
		forward(REFERER);
	} else {
		//print $name;
		$employee = $entity;
		$employee->name = $name;
		$employee->street1 = $street1;
		$employee->town = $town;
		$employee->state = $state;
		$employee->postcode = $postcode;
		$employee->country = $country;
		$employee->save();
		set_user_display_name($name,$guid);
		system_message(elgg_echo("employee:message:updated"));
		forward(REFERER);
	}
} else {
		
			// register a employee			
			$password = substr(md5(rand()),0, 6);
			$friend_guid = "";
			$invitecode = "";
			if (elgg_get_config('allow_registration')) {
				$guid = register_user($username, $password, $name, $email, false, $friend_guid, $invitecode);
				if ($guid) {
					$new_user = get_entity($guid);
					$new_user->custom_profile_type = $custom_profile_type;
					$new_user->street1 = $street1;
					$new_user->town = $town;
					$new_user->state = $state;
					$new_user->postcode = $postcode;
					$new_user->country = $country;
					$new_user->enabled = "no";
					$new_user->save();
				}
                                        $code = "officeelgg";
					send_employee_creation_email_of_company($company, $new_user);
                                        $link = "{$site->url}sytick/activateemployee?k=".base64_encode($new_user->guid)."&c=$code";
                                        print_r($link);exit;
				
			} else {
				register_error(elgg_echo('registerdisabled'));
			}
			system_message(elgg_echo("employee:message:saved"));
			forward(REFERER);
		
}
