<?php
$user_guid = get_input('guid');
$name = strip_tags(get_input('name'));
$job_type = get_input('job_type');
//print '<pre>';print_r($all_jobs);print '</pre>';exit;
$po_user = null;
if ($user_guid){
	$entity = get_entity($user_guid);
	if (!$entity || !($entity instanceof ElggUser) || !$entity->canEdit()) {		
		register_error(elgg_echo('profile:error:save'));
		forward(REFERER);
	} else {
		$po_user = $entity;
	}
} else {
	register_error(elgg_echo('profile:error:save'));
	forward( REFERER );
}
$personal_flg = ($job_type) ? 1 : 0;

$profile_fields = elgg_get_config('profile_fields');
//print '<pre>';print_r($profile_fields);print '</pre>';
foreach ($profile_fields as $shortname => $valuetype) {
	// the decoding is a stop gap to prevent &amp;&amp; showing up in profile fields
	// because it is escaped on both input (get_input()) and output (view:output/text). see #561 and #1405.
	// must decode in utf8 or string corruption occurs. see #1567.
	$value = strip_tags(get_input($shortname));
	if($value != "") {
		if (is_array($value)) {
			array_walk_recursive($value, 'sytick_profile_array_decoder');
		} else {
			$value = _elgg_html_decode($value);
		}
                
		// limit to reasonable sizes
		// @todo - throwing away changes due to this is dumb!
		if (!is_array($value) && $valuetype != 'longtext' && elgg_strlen($value) > 250) {
			$error = elgg_echo('profile:field_too_long', array(elgg_echo("profile:{$shortname}")));
			register_error($error);
			forward(REFERER);
		}
	
		if ($value && $valuetype == 'url' && !preg_match('~^https?\://~i', $value)) {
			$value = "http://$value";
		}
	
		if ($valuetype == 'tags') {
			$value = string_to_tag_array($value);
		}
	
		$input[$shortname] = $value;
	}
}

//print '<pre>';print_r($input);print '</pre>';exit;

if ($name) {
	if (elgg_strlen($name) > 50) {
		register_error(elgg_echo('user:name:fail'));
		forward( REFERER );
	} elseif ($po_user->name != $name) {
		$po_user->name = $name;
		$po_user->save();
	}
}

//add job type relationships


//step :1 remove existing job_types
$existing_job_types = get_job_type_guids($user_guid);

foreach ($existing_job_types as $serial_num => $guid_job_type)
{
	remove_entity_relationship($guid_job_type->guid_one, 'job_type_of_user', $user_guid);
}
//print '<pre>';print_r($existing_job_types[0]->guid_one);print '</pre>';exit;

//step :2 save to database
add_entity_relationship($job_type, "job_type_of_user", $user_guid);
//exit;


// go through custom fields
if (sizeof($input) > 0) {
	foreach ($input as $shortname => $value) {
		$options = array(
				'guid' => $po_user->guid,
				'metadata_name' => $shortname,
				'limit' => false
		);
		elgg_delete_metadata($options);

		if (!is_null($value) && ($value !== '')) {
			// only create metadata for non empty values (0 is allowed) to prevent metadata records with empty string values #4858
				
			/*if (isset($accesslevel[$shortname])) {
				$access_id = (int) $accesslevel[$shortname];
			} else {
				// this should never be executed since the access level should always be set
				$access_id = ACCESS_DEFAULT;
			}*/
			$access_id = ACCESS_PUBLIC;
			if (is_array($value)) {
				$i = 0;
				foreach ($value as $interval) {
					$i++;
					$multiple = ($i > 1) ? TRUE : FALSE;
					create_metadata($po_user->guid, $shortname, $interval, 'text', $po_user->guid, $access_id, $multiple);
				}
			} else {
				create_metadata($po_user->getGUID(), $shortname, $value, 'text', $po_user->getGUID(), $access_id);
			}
		}
	}

	$po_user->save();

	// Notify of profile update
	elgg_trigger_event('profileupdate', $po_user->type, $po_user);

	elgg_clear_sticky_form('profile:edit');
	system_message(elgg_echo("profile:saved"));
	if($personal_flg) {
		forward("/user/".$po_user->username."/medical");
	} else {
		forward("/user/".$po_user->username."/emergency");
	} 
}

forward(REFERER);
