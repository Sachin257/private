<?php

function get_employee_last_check_in_out($employees_id, $project_guid) {
    $employee_check_in_out_status_arr = array();
    $current_date_timestamp = date('U');
    if (count($employees_id) && $project_guid) {
        foreach ($employees_id as $employee_id) {
            $employee_check_in_out_obj = null;
            $params = array();
            $params['user_guid'] = $employee_id;
            $params['checkin_in_out_site_guid'] = $project_guid;
            $params['current_checkout_day'] = date('d-m-Y', $current_date_timestamp);
            $params['limit'] = 1;
            $entitys = get_employee_check_in_out($params);
            $employee_check_in_out_obj = ($entitys && $entitys[0]) ? $entitys[0] : null;
            if ($employee_check_in_out_obj) {
                $employee_check_in_out_status_arr[$employee_check_in_out_obj->user_guid]['full_name'] = $employee_check_in_out_obj->user_full_name;
                $employee_check_in_out_status_arr[$employee_check_in_out_obj->user_guid]['check_in_timetamp'] = $employee_check_in_out_obj->checkin_timestamp;
                $employee_check_in_out_status_arr[$employee_check_in_out_obj->user_guid]['check_out_timetamp'] = $employee_check_in_out_obj->checkout_timestamp;
            }
            $response = check_employee_eligiblity_to_checkin($project_guid, $employee_id);
            $employee_check_in_out_status_arr[$employee_id]['check_in_out_status'] = (isset($response['message'])) ? $response['message'] : "";
        }
    }
    return $employee_check_in_out_status_arr;
}

function get_employee_profile_completion_status($employee) {
    $emergency_contact = get_emergency_contact_by_user_guid($contractor->guid);
    if ($employee->state == "" || $employee->town == "" || $employee->postcode == "" || $employee->lastname == "" || $employee->street1 == "" || (count($emergency_contact) == 0)) {
        return true;
    }
    return false;
}

function check_and_create_paint_alerts($paint_guid){
    $paint = get_entity($paint_guid);
    if((int)$paint->quantity < (int)$paint->threshold){
        $search_arr = array(
		'types' => 'object',
		'subtypes' => 'material_alerts',
		'limit' => ELGG_ENTITIES_NO_VALUE
        );

	$search_arr['metadata_name_value_pairs'][] = array(
			'name' => "is_active",
			'value' => 1,
			'operand' => '='
	);
        $search_arr['metadata_name_value_pairs'][] = array(
			'name' => "material_guid",
			'value' => $paint_guid,
			'operand' => '='
	);
        $alerts = elgg_get_entities_from_metadata($search_arr);
        if(!$alerts){
            $alert = new ElggObject();
            $alert->subtype = "material_alerts";
            $alert->title = $paint->title;
            $alert->material_guid = $paint->guid;
            $alert->material_type = "paint";
            $alert->quantity = $paint->quantity;
            $alert->is_active = 1;
            $alert->save();
        }
    }
}

function get_number_of_alerts(){
    $search_arr = array(
        'types' => 'object',
        'subtypes' => 'material_alerts',
        'count' => TRUE,
        'limit' => ELGG_ENTITIES_NO_VALUE
    );

    $search_arr['metadata_name_value_pairs'][] = array(
        'name' => "is_active",
        'value' => 1,
        'operand' => '='
    );
    $count = elgg_get_entities_from_metadata($search_arr);
    return $count;
}

function check_and_remove_paint_alerts($paint_guid){
    $paint = get_entity($paint_guid);
    if($paint->quantity > $paint->threshold){
        $search_arr = array(
		'types' => 'object',
		'subtypes' => 'material_alerts',
		'limit' => ELGG_ENTITIES_NO_VALUE
        );
	$search_arr['metadata_name_value_pairs'][] = array(
			'name' => "is_active",
			'value' => 1,
			'operand' => '='
	);
        $search_arr['metadata_name_value_pairs'][] = array(
			'name' => "material_guid",
			'value' => $paint_guid,
			'operand' => '='
	);
        $alerts = elgg_get_entities_from_metadata($search_arr);
        if($alerts){
            $alert = get_entity($alerts[0]->guid);
            $alert->is_active = 0;
            $alert->save();
        }
    }
}

function checkout_employee_from_site($site_guid, $user_guid) {
    $checkin_user = get_entity($user_guid);
    if ($checkin_user) {
        $current_date_timestamp = date('U');
        $employee_check_in_out_obj = null;
        if ($employee_check_in_out_obj = get_employee_current_checkin_status($user_guid, $current_date_timestamp, 0, $site_guid)) {
            $employee_check_in_out_id = $employee_check_in_out_obj->guid;
            if ($employee_check_in_out_id) {
                $employee_check_in_out = get_entity($employee_check_in_out_id);
                $current_date_timestamp = date('U');
                $employee_check_in_out->checkout_timestamp = $current_date_timestamp;
                $employee_check_in_out->save();
                return array("success" => 1, "message" => elgg_echo('checkout:success'), "check_in_out_timestamp" => $current_date_timestamp);
            } else {
                return array("error" => 1, "message" => elgg_echo('checkout:error'));
            }
        } else {
            return array("error" => 1, "message" => elgg_echo('checkout:error'));
        }
    } else {
        return array("error" => 1, "message" => elgg_echo('checkin:error:invalid'));
    }
}

function checkin_employee_to_site($site_guid, $user_guid) {
    $checkin_user = get_entity($user_guid);
    if ($checkin_user) {
        $current_date_timestamp = date('U');
        if (get_employee_current_checkin_status($user_guid, $current_date_timestamp, 1)) {
            return array("error" => 1, "message" => elgg_echo('checkin:error:already_checkedin'));
        } else {
            $response = check_employee_eligiblity_to_checkin($site_guid, $user_guid);
            if (isset($response['error']) && $response['error']) {
                return array("error" => 1, "message" => $response['message']);
            }
            $checkin_site = get_entity($site_guid);
            $employee_check_in_out = new ElggObject();
            $employee_check_in_out->subtype = "employee_check_in_out";
            $site_name = $checkin_site->title;
            $user_name = $checkin_user->username;
            $employee_check_in_out->title = $site_name . "_" . $user_name . "_" . $current_date_timestamp;
            $employee_check_in_out->description = $site_name . "by" . $checkin_user->name . " at " . date('D-m-y h:i:s', $current_date_timestamp);
            // owner is logged in user
            $employee_check_in_out->owner_guid = elgg_get_logged_in_user_guid();
            $employee_check_in_out->is_deleted = 0;
            $employee_check_in_out->access_id = ACCESS_PUBLIC;

            $employee_check_in_out->user_guid = $user_guid;
            $employee_check_in_out->checkin_in_out_site_guid = $site_guid;
            $employee_check_in_out->role_guid = $checkin_user->custom_profile_type;
            $employee_check_in_out->user_full_name = $checkin_user->name . ( $checkin_user->lastname ? " " . $checkin_user->lastname : "" );
            $employee_check_in_out->current_checkout_day = date('d-m-Y', $current_date_timestamp);
            $employee_check_in_out->checkin_timestamp = $current_date_timestamp;
            $employee_check_in_out->checkout_timestamp = 0;
            $employee_check_in_out->save();
            return array("success" => 1, "message" => elgg_echo('checkin:success'), "check_in_out_timestamp" => $current_date_timestamp);
        }
    } else {
        return array("error" => 1, "message" => elgg_echo('checkin:error:invalid'));
    }
}

function get_employee_current_checkin_status($user_guid, $current_date_timestamp, $count_flg = 0, $site_guid = 0) {
    $params = array();
    if ($count_flg) {
        $params['count'] = 1;
    }
    $params['user_guid'] = $user_guid;
    if ($site_guid) {
        $params['checkin_in_out_site_guid'] = $site_guid;
    }
    $params['current_checkout_day'] = date('d-m-Y', $current_date_timestamp);
    $params['checkout_timestamp'] = 0;
    $params['limit'] = 1;
    if ($count_flg) {
        $count = get_employee_check_in_out($params);
        return $count;
    } else {
        $entitys = get_employee_check_in_out($params);
        //print '<pre>';print_r($entitys);exit;
        return ($entitys && count($entitys)) ? $entitys[0] : false;
    }
}

function get_employee_check_in_out($params = array()) {
    $select_arr = array(
        'types' => 'object',
        'subtypes' => 'employee_check_in_out',
        'limit' => false,
    );
    if (isset($params['guid']) && $params['guid']) {
        $select_arr['guid'] = $params['guid'];
    }

    if (isset($params['limit']) && $params['limit']) {
        $select_arr['limit'] = $params['limit'];
    }

    if (isset($params['offset']) && $params['offset']) {
        $select_arr['offset'] = $params['offset'];
    }

    if (isset($params['count']) && $params['count']) {
        $select_arr['count'] = TRUE;
    }

    if (isset($params['checkin_in_out_site_guid']) && $params['checkin_in_out_site_guid']) {
        $select_arr['metadata_name_value_pairs'][] = array(
            'name' => "checkin_in_out_site_guid",
            'value' => $params['checkin_in_out_site_guid']
        );
    }

    if (isset($params['user_guid']) && $params['user_guid']) {
        $select_arr['metadata_name_value_pairs'][] = array(
            'name' => "user_guid",
            'value' => $params['user_guid']
        );
    }

    if (isset($params['current_checkout_day']) && $params['current_checkout_day']) {
        $select_arr['metadata_name_value_pairs'][] = array(
            'name' => "current_checkout_day",
            'value' => $params['current_checkout_day'],
            'operand' => '='
        );
    }
    if (isset($params['role_guid']) && $params['role_guid']) {
        $select_arr['metadata_name_value_pairs'][] = array(
            'name' => "role_guid",
            'value' => $params['role_guid']
        );
    }
    if (isset($params['checkout_timestamp'])) {
        $select_arr['metadata_name_value_pairs'][] = array(
            'name' => "checkout_timestamp",
            'value' => $params['checkout_timestamp']
        );
    }
    //print '<pre>';print_r($select_arr);print '</pre>';
    $entitys = elgg_get_entities_from_metadata($select_arr);
    //print '<pre>';print_r($entitys);exit;
    return $entitys;
}

function set_object_details($params, $guid) {
    global $CONFIG;
    if ($guid) {
        $query = "update {$CONFIG->dbprefix}objects_entity o
		set  o.title = '{$params['title']}'";
        if (isset($params['description']) && $params['description'] != "") {
            $query .= ", o.description = '{$params['description']}'";
        }
        $query .= " where o.guid= $guid ";
        //echo $query;exit;
        $result = update_data($query);
        return $result;
    }
    return false;
}

function get_entity_name($entity_guid, $type = "") {
    $entity = get_entity($entity_guid);
    if ($type == "trading_name") {
        return ($entity) ? ($entity->trading_name) : false;
    } else {
        return ($entity) ? ($entity->title) : false;
    }
}

function get_users_projects($page_user_id) {
    $options = array(
        "relationship" => "employee_of_project",
        "relationship_guid" => $page_user_id,
        "limit" => ELGG_ENTITIES_NO_VALUE
    );
    //print '<pre>';print_r(elgg_get_entities_from_relationship($options));exit;
    $entitys = elgg_get_entities_from_relationship($options);
    if ($entitys && count($entitys)) {
        //print '<pre>';print_r($entitys);print '</pre>';exit;
        return $entitys;
    }
    return false;
}

function get_company_of_project($project_id) {
    $options = array(
        "relationship" => "project_of_company",
        "relationship_guid" => $project_id,
        "limit" => ELGG_ENTITIES_NO_VALUE
    );
    //print '<pre>';print_r(elgg_get_entities_from_relationship($options));exit;
    $company = elgg_get_entities_from_relationship($options);
    return $company;
}

function get_image_path($image) {
    $site = elgg_get_site_entity();
    $image_path = elgg_get_site_url() . 'mod/twitter_bootstrap/vendors/bootstrap/img/' . $image;
    return $image_path;
}

function get_unique_username($title, $guid = 0) {
    global $CONFIG;
    $name = preg_replace("/[^a-zA-Z0-9]/", "", strtolower($title));
    $query = 'SELECT u . guid
				FROM ' . $CONFIG->dbprefix . 'users_entity u
				WHERE (u.username = "' . sanitise_string($title) . '" )';
    if ($guid) {
        $query .= ' and u.guid !=' . $guid;
    }
    //echo $query;exit;
    $entitys = get_data($query, 'entity_row_to_elggstar');
    if ($entitys && count($entitys)) {
        $name = $name . ((count($entitys)) + 1);
    }
    return $name;
}

function get_unique_name($title, $guid = 0) {
    global $CONFIG;
    $name = preg_replace("/[^a-zA-Z0-9]/", "", strtolower($title));
    $query = 'SELECT o.guid
				FROM ' . $CONFIG->dbprefix . 'objects_entity o
				WHERE (o.title = "' . sanitise_string($title) . '" )';
    if ($guid) {
        $query .= ' and o.guid !=' . $guid;
    }
    //echo $query;exit;
    //error_log("unique name query---".$query , 0);
    $entitys = get_data($query, 'entity_row_to_elggstar');
    if ($entitys && count($entitys)) {
        $name = $name . ((count($entitys)) + 1);
        //error_log("------unique name ---".$name , 0);
    }
    return $name;
}

function get_user_profile_data($user) {
    $profile_type_obj = null;
    $custom_profile_type = $user->custom_profile_type;
    if ($custom_profile_type) {
        $profile_type_obj = get_entity($custom_profile_type);
    }
    return $profile_type_obj;
}

function insert_html_mail_template($body) {
    $site = elgg_get_site_entity();
    $html_body = elgg_view("sytick/email", array('body' => $body, 'site' => $site->name));
    return $html_body;
}

function get_sites_of_projects($project_id, $page_limit = 5) {
    $select_arr = array(
        'types' => 'object',
        'subtypes' => 'sites',
        'limit' => false,
    );
    if ($page_limit) {
        $select_arr['limit'] = $page_limit;
    }

    $select_arr['metadata_name_value_pairs'][] = array(
        'name' => "project_guid",
        'value' => $project_id,
        'operand' => '='
    );

    //if(! elgg_is_admin_logged_in())
    //{
    $select_arr['metadata_name_value_pairs'][] = array(
        'name' => "is_deleted",
        'value' => 0,
        'operand' => '='
    );
    //}
    $sites = elgg_get_entities_from_metadata($select_arr);
    //print '<pre>';print_r($sites);exit;
    return $sites;
}

function get_sites_by_name($name) {
    //echo($name);
    $select_arr = array(
        'types' => 'object',
        'subtypes' => 'sites',
        'limit' => false,
    );
    if ($page_limit) {
        $select_arr['limit'] = $page_limit;
    }

    $select_arr['metadata_name_value_pairs'][] = array(
        'name' => "site_name",
        'value' => $name,
    );

    //if(! elgg_is_admin_logged_in())
    //{
    $select_arr['metadata_name_value_pairs'][] = array(
        'name' => "is_deleted",
        'value' => 0,
        'operand' => '='
    );
    //}
    /* print '<pre>';print_r($select_arr); */
    $sites = elgg_get_entities_from_metadata($select_arr);
    //print '<pre>';print_r($projects);exit;
    return ($sites && count($sites)) ? $sites[0] : false;
}

function get_sites_search($search, $guid_str = "") {
    global $CONFIG;

    $query = 'SELECT o . guid
				FROM ' . $CONFIG->dbprefix . 'objects_entity o
				JOIN  ' . $CONFIG->dbprefix . 'entities e ON e.guid = o.guid
				JOIN  ' . $CONFIG->dbprefix . 'entity_subtypes es ON es.id = e.subtype
				AND es.subtype = "sites"
				WHERE (o.title like "%' . sanitise_string($search) . '%" )';
    if ($guid_str != "") {
        $query .= ' and o.guid in (' . $guid_str . ')';
    }
    //echo $query;exit;
    $entitys = get_data($query, 'entity_row_to_elggstar');
    if (empty($entitys)) {
        return false;
    } else {
        //print '<pre>';print_r($entitys);exit;
        $guid_arr = array();
        if (count($entitys)) {
            foreach ($entitys as $_entitys) {
                $guid_arr[] = $_entitys->guid;
            }
            //print '<pre>';print_r($guid_arr);
        }
        return $guid_arr;
    }
}

function get_sites($page_limit = 5) {
    $select_arr = array(
        'types' => 'object',
        'subtypes' => 'sites',
        'limit' => false,
    );
    if ($page_limit) {
        $select_arr['limit'] = $page_limit;
    }

    //if(! elgg_is_admin_logged_in())
    //{
    $select_arr['metadata_name_value_pairs'][] = array(
        'name' => "is_deleted",
        'value' => 0,
        'operand' => '='
    );
    //}
    $sites = elgg_get_entities_from_metadata($select_arr);
    //print '<pre>';print_r($sites);exit;
    return $sites;
}

function get_sites_of_company($company_id, $page_limit = 5) {
    if ($company_id) {
        $options = array(
            "relationship" => "site_of_company",
            "relationship_guid" => $company_id,
            "inverse_relationship" => true,
            "limit" => ELGG_ENTITIES_NO_VALUE
        );
        if ($page_limit) {
            $options['limit'] = $page_limit;
        }

        //print '<pre>';print_r(elgg_get_entities_from_relationship($options));exit;
        $sites = elgg_get_entities_from_relationship($options);
        //print '<pre>';print_r($projects );print '</pre>';exit;
        return $sites;
    } else {
        return false;
    }
}

function get_file_by_sites_guid($sites_guid) {
    $options = array(
        "relationship" => "file_of_sites",
        "relationship_guid" => $sites_guid,
        "inverse_relationship" => true,
        "limit" => ELGG_ENTITIES_NO_VALUE
    );

    return elgg_get_entities_from_relationship($options);
}

function get_sites_current_sitesmanagers($site_id) {
    global $CONFIG;
    $sitemanagers_ids = array();
    $relation = 'sitemanager_of_site';
    $query = "SELECT guid_two from {$CONFIG->dbprefix}entity_relationships
	where guid_one='$site_id' and relationship='$relation' ";
    $entitys = get_data($query, 'entity_row_to_elggstar');
    if (count($entitys)) {
        foreach ($entitys as $key => $_entitys) {
            $sitemanagers_ids[] = $_entitys->guid_two;
        }
    }
    return $sitemanagers_ids;
}

function check_unique_site_name($site_name, $guid) {
    global $CONFIG;

    $query = 'SELECT count(*) as cnt
				FROM ' . $CONFIG->dbprefix . 'objects_entity o
				JOIN  ' . $CONFIG->dbprefix . 'entities e ON e.guid = o.guid
				JOIN  ' . $CONFIG->dbprefix . 'entity_subtypes es ON es.id = e.subtype
				AND es.subtype = "sites"
				WHERE o.title = "' . sanitise_string($site_name) . '"';
    if ($guid) {
        $query .= " and o.guid != $guid";
    }
    //$dblink = get_db_link('read');
    //echo $query;exit;
    //$entitys = execute_query($query, $dblink);
    $entity = get_data_row($query, 'entity_row_to_elggstar');
    //print '<pre>';print_r($entitys);exit;
    if (empty($entitys))
        return true;
    else
        return false;
}

function set_user_display_name($name, $guid) {
    global $CONFIG;
    if ($guid) {
        $query = "update {$CONFIG->dbprefix}users_entity u
		set  u.name = '$name'
		where u.guid= $guid ";
        $result = update_data($query);
        return $result;
    }
    return false;
}

function get_employees_of_company_by_type($company_id, $profile_type = 0, $page_limit = 0) {
    //echo $profile_type;
    if ($company_id) {
        $options = array(
            "relationship" => "employee_of_company",
            "relationship_guid" => $company_id,
            "limit" => ELGG_ENTITIES_NO_VALUE
        );
        if ($page_limit) {
            $options["limit"] = $page_limit;
        }
        //print '<pre>';print_r(elgg_get_entities_from_relationship($options));exit;
        $employees = elgg_get_entities_from_relationship($options);
        //print '<pre>';print_r($employees);exit;
        if ($employees && count($employees)) {
            $user_ids = array();
            foreach ($employees as $_employees) {
                $user_ids[] = $_employees->guid;
                //echo  $_employees->guid." ".$_employees->username." ".$_employees->custom_profile_type."|";
            }
            //print '<pre>';print_r($user_ids);exit;
            $select_arr = array(
                'types' => 'user'
            );
            $select_arr['guid'] = $user_ids;
            if ($profile_type !== 0) {
                $profile_type_arr = get_custom_profile_types($profile_type);
                $user_profile_type_guid = ($profile_type_arr && isset($profile_type_arr['guid']) ) ? $profile_type_arr['guid'] : 0;
            }
            if ($user_profile_type_guid) {
                $select_arr['metadata_name_value_pairs'][] = array(
                    'name' => "custom_profile_type",
                    'value' => $user_profile_type_guid
                );
            }
            $users = elgg_get_entities_from_metadata($select_arr);
            return $users;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function check_username_exists($username, $guid = 0) {
    global $CONFIG, $USERNAME_TO_GUID_MAP_CACHE;

    // Fixes #6052. Username is frequently sniffed from the path info, which,
    // unlike $_GET, is not URL decoded. If the username was not URL encoded,
    // this is harmless.
    $username = rawurldecode($username);

    $username = sanitise_string($username);

    // Caching
    if ((isset($USERNAME_TO_GUID_MAP_CACHE[$username])) && (_elgg_retrieve_cached_entity($USERNAME_TO_GUID_MAP_CACHE[$username]))) {
        return _elgg_retrieve_cached_entity($USERNAME_TO_GUID_MAP_CACHE[$username]);
    }

    $query = "SELECT e.* from {$CONFIG->dbprefix}users_entity u
	join {$CONFIG->dbprefix}entities e on e.guid=u.guid
	where u.username='$username' ";

    if ($guid) {
        $query .= " and u.guid != $guid";
    }
    $entity = get_data_row($query, 'entity_row_to_elggstar');
    if ($entity) {
        $USERNAME_TO_GUID_MAP_CACHE[$username] = $entity->guid;
    } else {
        $entity = false;
    }

    return $entity;
}

function check_useremail_exists($email, $guid = 0) {
    global $CONFIG;

    $query = "SELECT e.* from {$CONFIG->dbprefix}users_entity u
	join {$CONFIG->dbprefix}entities e on e.guid=u.guid
	where u.email = '$email' ";

    if ($guid) {
        $query .= " and u.guid != $guid";
    }
    $entity = get_data_row($query, 'entity_row_to_elggstar');
    if (!$entity) {
        $entity = false;
    }
    return $entity;
}

function get_company_of_employee($employee_id) {
    $options = array(
        "relationship" => "employee_of_company",
        "relationship_guid" => $employee_id,
        "inverse_relationship" => true,
        "limit" => ELGG_ENTITIES_NO_VALUE
    );
    //print '<pre>';print_r(elgg_get_entities_from_relationship($options));exit;
    $companys = elgg_get_entities_from_relationship($options);
    return ($companys && $companys[0]) ? $companys[0] : false;
}

function send_employee_creation_email_of_company($company, $user) {
    //echo '<pre>';print_r($user);echo '</pre>';
    $site = elgg_get_site_entity();
    // Send invitation email
    $role = get_entity($user->custom_profile_type);
    //echo '<pre>';print_r($role);echo '</pre>';
    $code = "";
    if ($user instanceof ElggUser) {
        // generate code
        $code = "officeelgg";
        $user->setPrivateSetting('passwd_conf_code', $code);
    }
    $link = "{$site->url}sytick/activateemployee?k=" . base64_encode($user->guid) . "&c=$code";
    $subject = elgg_echo('employee:create:subject', array($user->name, $site->name, $company->title));
    //$body = elgg_echo('employee:create:body', array($user->name, $site->name, $company->trading_name, $role->metadata_label, $link, $site->name, $site->url));
    //echo $subject;
    //echo $body;
    //$html_body = insert_html_mail_template($body);
    $vars = array("username" => $user->name,
        "sitename" => $site->name,
        "companyname" => $company->trading_name,
        "role" => $role->metadata_label,
        "link" => $link,
        "siteurl" => $site->url);
    $html_body = elgg_view("sytick/create_employee_email", $vars);
//	error_log("user activation link ---".$link , 0);
    $result = elgg_send_email($site->email, $user->email, $subject, $html_body, NULL);
    //echo '<pre>';print_r($result);exit;
}

function check_unique_company_employee($contact_email, $company_id) {
    $change_user = get_user_by_email_noaccess($contact_email);
    //print_r($change_user);die($contact_email);
    if (($change_user) && isset($change_user[0])) {
        if ($company_id) {
            //echo ($change_user[0]->guid."--".$company_id);exit;
            $options = array(
                "relationship" => "employee_of_company",
                "inverse_relationship" => true,
                "relationship_guid" => $change_user[0]->guid,
            );

            // Each qualification type should only have one lesson.
            $company_obj = elgg_get_entities_from_relationship($options);
            //print_r($company_obj);die($contact_email);
            if (count($company_obj) == 0 || ($company_obj[0]->guid == $company_id)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return true;
    }
}

function get_file_by_company_guid($company_guid) {
    $options = array(
        "relationship" => "file_of_company",
        "relationship_guid" => $company_guid,
        "inverse_relationship" => true,
        "limit" => ELGG_ENTITIES_NO_VALUE
    );

    return elgg_get_entities_from_relationship($options);
}

function get_site_manager_by_proj_guid($proj_guid) {
    $options = array(
        "relationship" => "site_manager_of_project",
        "relationship_guid" => $proj_guid,
        "limit" => ELGG_ENTITIES_NO_VALUE
    );

    return elgg_get_entities_from_relationship($options);
}

function get_material_id_by_proj_guid($proj_guid) {
    $options = array(
        "relationship" => "material_of_project",
        "relationship_guid" => $proj_guid,
        "limit" => ELGG_ENTITIES_NO_VALUE
    );

    return elgg_get_entities_from_relationship($options);
}

function get_projects_by_site_manager_guid($emp_guid) {
    $options = array(
        "relationship" => "site_manager_of_project",
        "relationship_guid" => $emp_guid,
        "inverse_relationship" => TRUE,
        "limit" => ELGG_ENTITIES_NO_VALUE
    );
    return elgg_get_entities_from_relationship($options);
}

function get_whs_manager_by_proj_guid($proj_guid) {
    $options = array(
        "relationship" => "whs_manager_of_project",
        "relationship_guid" => $proj_guid,
        "limit" => ELGG_ENTITIES_NO_VALUE
    );

    return elgg_get_entities_from_relationship($options);
}

function get_projects_by_whs_manager_guid($emp_guid) {
    $options = array(
        "relationship" => "whs_manager_of_project",
        "relationship_guid" => $emp_guid,
        "inverse_relationship" => TRUE,
        "limit" => ELGG_ENTITIES_NO_VALUE
    );
    return elgg_get_entities_from_relationship($options);
}

function get_ind_manager_by_proj_guid($proj_guid) {
    $options = array(
        "relationship" => "ind_manager_of_project",
        "relationship_guid" => $proj_guid,
        "limit" => ELGG_ENTITIES_NO_VALUE
    );

    return elgg_get_entities_from_relationship($options);
}

function get_projects_by_ind_manager_guid($emp_guid) {
    $options = array(
        "relationship" => "ind_manager_of_project",
        "relationship_guid" => $emp_guid,
        "inverse_relationship" => TRUE,
        "limit" => ELGG_ENTITIES_NO_VALUE
    );
    return elgg_get_entities_from_relationship($options);
}

function get_security_person_by_proj_guid($proj_guid) {
    $options = array(
        "relationship" => "security_person_of_project",
        "relationship_guid" => $proj_guid,
        "limit" => ELGG_ENTITIES_NO_VALUE
    );

    return elgg_get_entities_from_relationship($options);
}

function get_projects_by_security_person_guid($s_guid) {
    $options = array(
        "relationship" => "security_person_of_project",
        "relationship_guid" => $s_guid,
        "inverse_relationship" => TRUE,
        "limit" => ELGG_ENTITIES_NO_VALUE
    );
    return elgg_get_entities_from_relationship($options);
}

function get_project_by_name($name) {
    //echo($name);	
    $params = array('project_name' => $name);
    $projects = get_projects($params);
    //print '<pre>';print_r($projects);exit;
    return ($projects && count($projects)) ? $projects[0] : false;
}

function get_project_search($search, $guid_str = "") {
    global $CONFIG;
    $query = 'SELECT o . guid
				FROM ' . $CONFIG->dbprefix . 'objects_entity o
				WHERE (o.title like "%' . sanitise_string($search) . '%" )';
    if ($guid_str != "") {
        $query .= ' and o.guid in (' . $guid_str . ')';
    }
    $entitys = get_data($query, 'entity_row_to_elggstar');
    if (empty($entitys)) {
        return array();
    } else {
        $guid_arr = array();
        if (count($entitys)) {
            foreach ($entitys as $_entitys) {
                $guid_arr[] = $_entitys->guid;
            }
        }
        return $guid_arr;
    }
}

function get_material_type_search($search, $guid_str = "") {
    global $CONFIG;

    $query = 'SELECT o . guid
				FROM ' . $CONFIG->dbprefix . 'objects_entity o
				WHERE (o.title like "%' . sanitise_string($search) . '%" )';
    if ($guid_str != "") {
        $query .= ' and o.guid in (' . $guid_str . ')';
    }
    //echo $query;exit;
    $entitys = get_data($query, 'entity_row_to_elggstar');
    if (empty($entitys)) {
        return false;
    } else {
        //print '<pre>';print_r($entitys);exit;
        $guid_arr = array();
        if (count($entitys)) {
            foreach ($entitys as $_entitys) {
                $guid_arr[] = $_entitys->guid;
            }
            //print '<pre>';print_r($guid_arr);
        }
        return $guid_arr;
    }
}

function get_paint_search($search, $guid_str = "") {
    global $CONFIG;

    $query = 'SELECT o . guid
				FROM ' . $CONFIG->dbprefix . 'objects_entity o
				WHERE (o.title like "%' . sanitise_string($search) . '%" )';
    if ($guid_str != "") {
        $query .= ' and o.guid in (' . $guid_str . ')';
    }
    //echo $query;exit;
    $entitys = get_data($query, 'entity_row_to_elggstar');
    if (empty($entitys)) {
        return false;
    } else {
        //print '<pre>';print_r($entitys);exit;
        $guid_arr = array();
        if (count($entitys)) {
            foreach ($entitys as $_entitys) {
                $guid_arr[] = $_entitys->guid;
            }
        }
        return $guid_arr;
    }
}

function project_general_search() {
    if (!elgg_is_admin_logged_in()) {
        $company = get_company_of_manager(elgg_get_logged_in_user_guid());
        $company_id = ($company) ? $company->guid : 0;
    }
    //print '<pre>';print_r($company_id );print '</pre>';exit;
    $project_ids = array();
    if ($company_id) {
        $projects = get_projects_of_company($company_id);
    } else {
        $projects = get_projects();
    }
    //print '<pre>';print_r($projects );print '</pre>';exit;
    if (count($projects)) {
        foreach ($projects as $_project) {
            $project_ids[] = $_project->guid;
        }
    }
    return $project_ids;
}

function induction_general_search() {
    if (!elgg_is_admin_logged_in()) {
        $page_user = elgg_get_logged_in_user_entity();
        $user_profile_type = get_custom_profile_types($page_user->custom_profile_type, 'guid');
        $user_profile_type_label = ($user_profile_type && isset($user_profile_type['label'])) ? $user_profile_type['label'] : "";
        if ($user_profile_type_label == MANAGER_PROFILE_TYPE) {
            $company = get_company_of_manager($page_user->guid);
            $company_id = ($company) ? $company->guid : 0;
        } else {
            $company = get_company_of_employee($page_user->guid);
            $company_id = ($company) ? $company->guid : 0;
        }
        //echo $page_user->guid;
    }
//print '<pre>';print_r($company_id );print '</pre>';exit;
    $induction_ids = array();
    if ($company_id) {
        //$inductions = get_inductions_of_company($company_id);
        $inductions = get_inductions(array("company_guid" => $company_id));
    } else {
        $inductions = get_inductions();
    }
    if (count($inductions)) {
        foreach ($inductions as $_induction) {
            $induction_ids[] = $_induction->guid;
        }
    }
    return $induction_ids;
}

function user_general_search() {
    $managers = get_users(MANAGER_PROFILE_TYPE);
    $user_ids = array();
    if (count($managers)) {
        foreach ($managers as $_manager) {
            $user_ids[] = $_manager->guid;
        }
    }
    $contractors = get_users(CONTRACTOR_PROFILE_TYPE);
    if (count($contractors)) {
        foreach ($contractors as $contractor) {
            $user_ids[] = $contractor->guid;
        }
    }
    $induction_managers = get_users(INDUCTION_MANAGER_PROFILE_TYPE);
    if (count($induction_managers)) {
        foreach ($induction_managers as $induction_manager) {
            $user_ids[] = $induction_manager->guid;
        }
    }
    $project_managers = get_users(PROJECT_MANAGER_PROFILE_TYPE);
    if (count($project_managers)) {
        foreach ($project_managers as $project_manager) {
            $user_ids[] = $project_manager->guid;
        }
    }
    $site_managers = get_users(SITE_MANAGER_PROFILE_TYPE);
    if (count($site_managers)) {
        foreach ($site_managers as $site_manager) {
            $user_ids[] = $site_manager->guid;
        }
    }
    $security_persons = get_users(SECURITY_PERSON_PROFILE_TYPE);
    if (count($security_persons)) {
        foreach ($security_persons as $security_person) {
            $user_ids[] = $security_person->guid;
        }
    }
    return $user_ids;
}

function company_general_search() {
    if (!elgg_is_admin_logged_in()) {
        $company = get_company_of_manager(elgg_get_logged_in_user_guid());
        $company_id = ($company) ? $company->guid : 0;
        if ($company->company_type == CONSTRUCTION_TYPE_COMPANY) {
            if ($company_type == CONSTRUCTION_TYPE_COMPANY) {
                $search_arr['guid'] = $company_id;
                $search_arr['company_type'] = CONSTRUCTION_TYPE_COMPANY;
            } else if ($company_type == CONTRACTING_TYPE_COMPANY) {
                $search_arr['owner_guid'] = elgg_get_logged_in_user_guid();
                $search_arr['company_type'] = CONTRACTING_TYPE_COMPANY;
            }
        } else if ($company->company_type == CONTRACTING_TYPE_COMPANY) {
            $search_arr['guid'] = $company_id;
            $search_arr['company_type'] = CONTRACTING_TYPE_COMPANY;
        }
    } else {
        if ($company_type) {
            $search_arr['company_type'] = $company_type;
        }
    }
    //print '<pre>';print_r($search_arr);print '</pre>';exit;
    $companies = get_companies($search_arr);
    //print '<pre>';print_r($companies);print '</pre>';exit;
    if (count($companies)) {
        foreach ($companies as $_companies) {
            $company_ids[] = $_companies->guid;
        }
    }
    return $company_ids;
}

function get_company_search($search, $guid_str = "") {
    global $CONFIG;

    $query = 'SELECT o . guid
				FROM ' . $CONFIG->dbprefix . 'objects_entity o
				WHERE (o.title like "%' . sanitise_string($search) . '%" )';
    if ($guid_str != "") {
        $query .= ' and o.guid in (' . $guid_str . ')';
    }
    //echo $query;exit;
    $entitys = get_data($query, 'entity_row_to_elggstar');
    if (empty($entitys)) {
        return false;
    } else {
        //print '<pre>';print_r($entitys);exit;
        $guid_arr = array();
        if (count($entitys)) {
            foreach ($entitys as $_entitys) {
                $guid_arr[] = $_entitys->guid;
            }
            //print '<pre>';print_r($guid_arr);
        }
        return $guid_arr;
    }
}

function get_workers($params = array()) {
    global $CONFIG;
    $select_arr = array(
        'types' => 'user',
    );

    if (isset($params['limit']) && $params['limit']) {
        $select_arr['limit'] = $params['limit'];
    }

    if (isset($params['offset']) && $params['offset']) {
        $select_arr['offset'] = $params['offset'];
    }

    if (isset($params['count']) && $params['count']) {
        $select_arr['count'] = TRUE;
    }
    $select_arr['joins'] = array("join {$CONFIG->dbprefix}users_entity u on e.guid = u.guid");
    if (isset($params['guid']) && $params['guid']) {
        $select_arr['wheres'] = array("u.guid in (" . implode(",", $params['guid']) . ")");
    }
    $select_arr['order_by'] = "u.name asc";

    $workers = elgg_get_entities($select_arr);
    //print '<pre>';print_r($select_arr);exit;
    //print '<pre>';print_r($workers);exit;
    return $workers;
}

function get_projects($params = array()) {
    $select_arr = array(
        'types' => 'object',
        'subtypes' => 'project',
    );
    if (isset($params['guid']) && $params['guid']) {
        $select_arr['guid'] = $params['guid'];
    }

    if (isset($params['limit']) && $params['limit']) {
        $select_arr['limit'] = $params['limit'];
    }

    if (isset($params['offset']) && $params['offset']) {
        $select_arr['offset'] = $params['offset'];
    }

    if (isset($params['count']) && $params['count']) {
        $select_arr['count'] = TRUE;
    }
    if (isset($params['project_name']) && $params['project_name']) {
        $select_arr['metadata_name_value_pairs'][] = array(
            'name' => "project_name",
            'value' => $params['project_name']
        );
    }
    $projects = elgg_get_entities_from_metadata($select_arr);
    return $projects;
}

function get_daily_log_by_project_guid($project_guid) {
    $options = array(
        "relationship" => "project_of_daily_log",
        "relationship_guid" => $project_guid,
        "limit" => ELGG_ENTITIES_NO_VALUE
    );

    return elgg_get_entities_from_relationship($options);
}

function check_unique_project_name($project_name, $guid) {
    global $CONFIG;

    $query = 'SELECT e . *
				FROM ' . $CONFIG->dbprefix . 'objects_entity o
				JOIN  ' . $CONFIG->dbprefix . 'entities e ON e.guid = o.guid
				JOIN  ' . $CONFIG->dbprefix . 'entity_subtypes es ON es.id = e.subtype
				AND es.subtype = "project"
				WHERE o.title = "' . sanitise_string($project_name) . '"';
    if ($guid) {
        $query .= " and o.guid != $guid";
    }
    $entitys = get_data($query, 'entity_row_to_elggstar');
    if (empty($entitys))
        return true;
    else
        return false;
}

function get_entity_guid_by_name($nm) {
    global $CONFIG;
    $query = "SELECT guid from {$CONFIG->dbprefix}objects_entity
	where title='$nm' ";
    return get_data($query, 'entity_row_to_elggstar');
}

function get_title_by_guid($guid) {
    global $CONFIG;
    $query = "SELECT title from {$CONFIG->dbprefix}objects_entity
	where guid='$guid' ";
    return get_data($query, 'entity_row_to_elggstar');
}

function get_user_search($search, $guid_str = "") {
    global $CONFIG;

    $query = 'SELECT u . guid
				FROM ' . $CONFIG->dbprefix . 'users_entity u
				WHERE (u.name like "%' . sanitise_string($search) . '%"
						or u.email like "%' . sanitise_string($search) . '%" )';
    if ($guid_str != "") {
        $query .= ' and u.guid in (' . $guid_str . ')';
    }
    //echo $query;	exit;
    $entitys = get_data($query, 'entity_row_to_elggstar');
    if (empty($entitys)) {
        return false;
    } else {
        $guid_arr = array();
        if (count($entitys)) {
            foreach ($entitys as $_entitys) {
                $guid_arr[] = $_entitys->guid;
            }
            //print '<pre>';print_r($guid_arr);
        }
        return $guid_arr;
    }
}

function get_users($user_type, $page_limit = 0, $enabled = 'yes') {
    $select_arr = array(
        'types' => 'user'
    );
    $select_arr['limit'] = $page_limit;
    $select_arr['enabled'] = $enabled;
    $profile_type_arr = get_custom_profile_types($user_type);
    $user_profile_type_guid = ($profile_type_arr && isset($profile_type_arr['guid']) ) ? $profile_type_arr['guid'] : 0;
    if ($user_profile_type_guid) {
        $select_arr['metadata_name_value_pairs'][] = array(
            'name' => "custom_profile_type",
            'value' => $user_profile_type_guid
        );
    }
    $users = elgg_get_entities_from_metadata($select_arr);
    return $users;
}

function get_manager_of_company($company_id) {
    if ($company_id) {
        $options = array(
            "relationship" => "manager_of_company",
            "relationship_guid" => $company_id,
            "limit" => ELGG_ENTITIES_NO_VALUE
        );
        //print '<pre>';print_r(elgg_get_entities_from_relationship($options));exit;
        $managers = elgg_get_entities_from_relationship($options);
        return $managers;
    } else {
        return false;
    }
}

function get_companies_arr_list($company_type = '') {
    $params = array();
    if ($company_type != "")
        $params['company_type'] = $company_type;
    $params['limit'] = ELGG_ENTITIES_NO_VALUE;
    //print '<pre>';print_r($params);exit;
    $entitys = get_companies($params);
    $companies_arr[] = "";
    if ($entitys && count($entitys)) {
        foreach ($entitys as $company) {
            $companies_arr[$company->guid] = $company->title;
        }
    }

    return $companies_arr;
}

function get_companies($params = array()) {
    $select_arr = array(
        'types' => 'object',
        'subtypes' => 'company',
    );

    if (isset($params['guid']) && $params['guid']) {
        $select_arr['guid'] = $params['guid'];
    }
    if (isset($params['owner_guid']) && $params['owner_guid']) {
        $select_arr['owner_guid'] = $params['owner_guid'];
    }

    if (isset($params['limit'])) {
        $select_arr['limit'] = $params['limit'];
    }

    if (isset($params['offset']) && $params['offset']) {
        $select_arr['offset'] = $params['offset'];
    }

    if (isset($params['count']) && $params['count']) {
        $select_arr['count'] = TRUE;
    }

    if (isset($params['company_type']) && $params['company_type']) {
        $select_arr['metadata_name_value_pairs'][] = array(
            'name' => "company_type",
            'value' => $params['company_type']
        );
    }
    if (isset($params['contact_id']) && $params['contact_id']) {
        $select_arr['metadata_name_value_pairs'][] = array(
            'name' => "contact_id",
            'value' => $params['contact_id']
        );
    }
    if (isset($params['status']) && $params['status']) {
        $select_arr['metadata_name_value_pairs'][] = array(
            'name' => "status",
            'value' => $params['status']
        );
    }
    if (isset($params['abn']) && $params['abn']) {
        $select_arr['metadata_name_value_pairs'][] = array(
            'name' => "abn",
            'value' => $params['abn']
        );
    }
    if (isset($params['name']) && $params['name']) {
        $select_arr['metadata_name_value_pairs'][] = array(
            'name' => "name",
            'value' => $params['name']
        );
    }
    //if(! elgg_is_admin_logged_in()) {
    $select_arr['metadata_name_value_pairs'][] = array(
        'name' => "is_deleted",
        'value' => 0,
        'operand' => '='
    );
    //} 
    //print '<pre>';print_r($select_arr);print '</pre>';//exit;
    $entitys = elgg_get_entities_from_metadata($select_arr);
    //print '<pre>';print_r($entitys);print '</pre>';exit;
    return $entitys;
}

function check_unique_company_primary_contact($contact_email, $company_id) {
    $change_user = get_user_by_email_noaccess($contact_email);
    //print_r($change_user);die($contact_email);	
    if (($change_user) && isset($change_user[0])) {
        if ($company_id) {
            //echo ($change_user[0]->guid."--".$company_id);exit;
            $options = array(
                "relationship" => "manager_of_company",
                "inverse_relationship" => true,
                "relationship_guid" => $change_user[0]->guid,
            );

            // Each qualification type should only have one lesson.
            $company_obj = elgg_get_entities_from_relationship($options);
            //print_r($company_obj);die($contact_email);
            if (count($company_obj) == 0 || ($company_obj[0]->guid == $company_id)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return true;
    }
}

function get_company_from_primary_contact($contact_id) {
    $params = array();
    if ($contact_id != "")
        $params = array('contact_id' => $contact_id);
    $companies = get_companies($params);
    if ($companies && count($companies)) {
        return $companies[0]->guid;
    }
    return false;
}

function get_custom_profile_types($profile_type = "", $filter_type = "") {
    $custom_profile_type_arr = array();
    $select_arr = array(
        'types' => 'object',
        'subtypes' => 'custom_profile_type',
    );
    if ($profile_type != "") {
        if ($filter_type == "") {
            $select_arr['metadata_name_value_pairs'][] = array(
                'name' => "metadata_label",
                'value' => $profile_type
            );
        } else if ($filter_type == "guid") {
            $select_arr['guid'] = $profile_type;
        }
    }
    $custom_profile_types = elgg_get_entities_from_metadata($select_arr);
    if (count($custom_profile_types)) {
        foreach ($custom_profile_types as $custom_profile_type) {
            // An array of all qualification types.
            $_custom_profile_type_arr = array();
            $_custom_profile_type_arr['guid'] = $custom_profile_type->guid;
            $_custom_profile_type_arr['label'] = $custom_profile_type->metadata_label;
            $_custom_profile_type_arr['name'] = $custom_profile_type->metadata_name;
            $custom_profile_type_arr[] = $_custom_profile_type_arr;
        }
        //print '<pre>';print_r($custom_profile_type_arr);exit;
        if ($profile_type != "") {
            return $custom_profile_type_arr[0];
        } else {
            return $custom_profile_type_arr;
        }
    } else {
        return false;
    }
}

function sytick_profile_array_decoder(&$v) {
    $v = _elgg_html_decode($v);
}

function is_unique_company_primary_contact($contact_id) {
    $params = array();
    $params = array('contact_id' => $contact_id, 'count' => 1);
    $companies = get_companies($params);
    if ($companies) {
        return false;
    }
    return true;
}

function create_manager($manager_arr, $manager_profile_type_guid, $company, $manager_id = 0) {
    $company_id = $company->guid;
    extract($manager_arr);
    $username = substr($email, 0, strpos($email, '@'));
    //$username = strtolower($username);
    //$username = preg_replace("/[^0-9a-zA-Z]/", "", $username);
    if (strlen($username) < 5) {
        $to_add = 5 - strlen($username);
        /* for($i = 1 ; $i< $to_add; $i++)
          {
          $username = $username."0";
          }
          $username = $username."1"; */
        $username = str_pad($username, $to_add, "0", STR_PAD_RIGHT);
    }
    $username = get_unique_username($username, $guid);
    $password = substr(md5(rand()), 0, 6);
    $friend_guid = "";
    $invitecode = "";
    $guid = register_user($username, $password, $name, $email, false, $friend_guid, $invitecode);
    if ($guid) {
        $new_user = get_entity($guid);
        $new_user->custom_profile_type = $manager_profile_type_guid;
        $new_user->street1 = $street1;
        $new_user->town = $town;
        $new_user->state = $state;
        $new_user->postcode = $postcode;
        $new_user->country = $country;
        $new_user->enabled = "no";
        $new_user->save();
    }
    //print '<pre>';print_r($new_user);print '</pre>';
    if ($company_id && $guid) {
        add_entity_relationship($company_id, "manager_of_company", $guid);
        //$company->contact_id = $guid;
        //$company->save();
        send_company_creation_email_to_contact($company, $new_user);
    }
    return $guid;
}

/**
 * create a company manager
 * @method create_company_manager 
 * @param {object} $company
 * @param {array} $manage_arr
 * @return {boolean}
 */
function create_company_manager_as_primary_contact($company, $manager_arr) {
    $company_id = $company->guid;
    $contact_id = ($company->contact_id) ? $company->contact_id : 0;
    $profile_type_arr = get_custom_profile_types(MANAGER_PROFILE_TYPE);
    $manager_profile_type_guid = ($profile_type_arr && isset($profile_type_arr['guid']) ) ? $profile_type_arr['guid'] : 0;
    extract($manager_arr);
    if ($contact_id == 0) {
        //  create a new manager - primary contact	
        $guid = create_manager($manager_arr, $manager_profile_type_guid, $company);
        $company->contact_id = $guid;
        $company->save();
    } else {
        $manager = get_entity($contact_id);
        $manager_email = $manager->email;
        //echo $manager_email ." ".$email;die("here");
        if ($manager_email != $email) {
            // change manager - primary contact
            $change_user = get_user_by_email_noaccess($email);
            $change_user = ($change_user) && isset($change_user[0]) ? $change_user[0] : false;
            //print '<pre>';print_r($change_user);exit;
            //echo $contact_id ." ".$change_user->guid;die("here");
            if ($change_user &&
                    $change_user->custom_profile_type == $manager_profile_type_guid && (is_unique_company_primary_contact($change_user->guid))) {
                // changed user details already a manager with no primary contact company
                $guid = $change_user->guid;
                if ($company_id && $guid) {
                    add_entity_relationship($company_id, "manager_of_company", $guid);
                    $company->contact_id = $guid;
                    $company->save();
                }
            } elseif (!$change_user) {
                // new user as primary contact manager of company
                //print '<pre>';print_r($company);exit;
                //echo $contact_id ." ".$change_user->guid;die("here");
                $guid = create_manager($manager_arr, $manager_profile_type_guid, $company, $manager->guid);
                $company->contact_id = $guid;
                $company->save();
            } else {
                return false;
            }
        } else {
            // update existing primary contact details
            $manager->name = $name;
            $manager->street1 = $street1;
            $manager->town = $town;
            $manager->state = $state;
            $manager->postcode = $postcode;
            $manager->country = $country;
            $manager->save();
            set_user_display_name($name, $manager->guid);
        }
    }
    return true;
}

/**
 * send company creation mail
 * @param {object} $company
 * @return null
 */
function send_company_creation_email_to_contact($company, $user) {

    $site = elgg_get_site_entity();
    // Send invitation email
    //$user = get_entity($company->contact_id);
    $code = "";
    if ($user instanceof ElggUser) {
        // generate code
        $code = generate_random_cleartext_password();
        $user->setPrivateSetting('passwd_conf_code', $code);
    }
    $link = "{$site->url}sytick/activatemanager?k=" . base64_encode($user->guid) . "&c=$code";
    $subject = elgg_echo('company:create:subject', array($company->title, $site->name));
    //$body = elgg_echo('company:create:body', array($user->name,$company->trading_name, $link, $site->name, $site->url));
    //$html_body = insert_html_mail_template($body);
    $vars = array("username" => $user->name,
        "sitename" => $site->name,
        "companyname" => $company->trading_name,
        "role" => $role->metadata_label,
        "link" => $link,
        "siteurl" => $site->url);
    $html_body = elgg_view("sytick/create_manager_email", $vars);
    $result = elgg_send_email($site->email, $user->email, $subject, $html_body, NULL);
    //print $body;print '<pre>';print_r($result);exit;
}

function get_unvalidated_user_count($user_type) {
    $count = 0;
    $options = array(
        'type' => 'user',
        'wheres' => uservalidationbyemail_get_unvalidated_users_sql_where(),
        'count' => TRUE,
    );
    $profile_type_arr = get_custom_profile_types($user_type);
    $user_profile_type_guid = ($profile_type_arr && isset($profile_type_arr['guid']) ) ? $profile_type_arr['guid'] : 0;
    if ($user_profile_type_guid) {
        $options['metadata_name_value_pairs'][] = array(
            'name' => "custom_profile_type",
            'value' => $user_profile_type_guid
        );
    }
    $count = elgg_get_entities_from_metadata($options);
    return $count;
}

/**
 * get_users_by_type
 * @method get usera list by type
 * @param {string} $company_type
 * @param {int} $limit
 * @return {array of object}
 */
function get_users_by_type($user_type, $page_limit = 5, $enabled = 'yes') {
    $users_arr = array();
    $select_arr = array(
        'types' => 'user'
    );
    if ($page_limit) {
        $select_arr['limit'] = $page_limit;
    }
    $select_arr['enabled'] = $enabled;
    $profile_type_arr = get_custom_profile_types($user_type);
    $user_profile_type_guid = ($profile_type_arr && isset($profile_type_arr['guid']) ) ? $profile_type_arr['guid'] : 0;
    if ($user_profile_type_guid) {
        $select_arr['metadata_name_value_pairs'][] = array(
            'name' => "custom_profile_type",
            'value' => $user_profile_type_guid
        );
    }
    $users = elgg_get_entities_from_metadata($select_arr);
    foreach ($users as $_user) {
        // An array of all qualification types.
        $users_arr[$_user->guid]['guid'] = $_user->guid;
        $users_arr[$_user->guid]['name'] = $_user->name;
    }
    //print '<pre>';print_r($users_arr);exit;
    return $users_arr;
}

/**
 * get_companies_by_type
 * @method get company list by type
 * @param {string} $company_type
 * @param {int} $limit
 * @return {array of object}
 */
function get_number_of_companies_by_type($type) {
    $params = array();
    $params = array('company_type' => $type, 'count' => 1);
    $companies = get_companies($params);
    return $companies;
}

function count_inactive_companies($companies) {
    $count = 0;
    foreach ($companies as $company) {
        $manager = get_entity($company->contact_id);
        // print "<pre>";print_r($manager->enabled);exit;
        if (!$manager->enabled) {
            $count = $count + 1;
        }
    }
    return $count;
}

function get_companies_by_type($company_type, $page_limit = 5, $status = 0) {
    $companies_arr = array();
    $params = array();
    $params = array('company_type' => $company_type, 'status' => $status, 'limit' => $page_limit);
    $companies = get_companies($params);
    foreach ($companies as $company) {
        // An array of all qualification types.
        $_companies_arr = array();
        $_companies_arr['guid'] = $company->guid;
        $_companies_arr['title'] = $company->title;
        $_companies_arr['trading_name'] = $company->description;
        $_companies_arr['abn'] = $company->abn;
        $_companies_arr['name'] = $company->name;
        $_companies_arr['company_type'] = $company->company_type;
        $_companies_arr['status'] = $company->status;
        $companies_arr[] = $_companies_arr;
    }
    //print '<pre>';print_r($companies_arr);exit;
    return $companies_arr;
}

/**
 * validate_certificate_id
 * @method Validate certificate_id
 * @param {string} $certificate_id
 * @return {boolean}
 */
function validate_certificate_id($certificate_id, $guid = 0) {
    $certificates = elgg_get_entities_from_metadata(array(
        'types' => 'object',
        'subtypes' => 'certificate',
        'limit' => false,
        'metadata_name_value_pairs' => array(
            'name' => "certificate_id",
            'value' => $certificate_id,
            'operand' => '='
        ),
    ));
    if ($certificates[0]->guid == $guid) {
        return true;
    }
    if (empty($certificates))
        return true;
    else
        return false;
}

/**
 * get_file_by_certificate_guid
 * @method
 * @param $certificate_guid
 * @return object
 */
function get_file_by_certificate_guid($certificate_guid) {
    $options = array(
        "relationship" => "file_of_certificate",
        "relationship_guid" => $certificate_guid,
        "inverse_relationship" => true,
        "limit" => ELGG_ENTITIES_NO_VALUE
    );

    return elgg_get_entities_from_relationship($options);
}

/**
 * get_sanitised_input url
 * @param {string} $params
 * @return string
 */
function get_sanitised_input($params) {
    return sanitise_string(get_input($params));
}

/**
 * get_user_profile url
 * @param {object} $user
 * @return url
 */
function get_user_login_url() {
    $forward_url = '';
    if (elgg_is_admin_logged_in()) {
        $forward_url = elgg_get_site_url() . "user/admin";
    } elseif (elgg_is_logged_in()) {
        $user = elgg_get_logged_in_user_entity();
        // case option once profile and certification is ready - stilltobeimplemented
        $user_profile_type = get_custom_profile_types($user->custom_profile_type, 'guid');
        $user_profile_type_label = ($user_profile_type && isset($user_profile_type['label'])) ? $user_profile_type['label'] : "";
        //print '<pre>';print_r($user_profile_type);exit;		
        if ($user_profile_type_label == CONTRACTOR_PROFILE_TYPE) {
            $forward_url = get_contractor_forward_url($user);
        } else {
            $forward_url = elgg_get_site_url() . "user/" . $user->username;
        }
    }

    return $forward_url;
}

function get_contractor_forward_url($contractor) {
    $emergency_contact = get_emergency_contact_by_user_guid($contractor->guid);
    $trade_cert = get_certificate_by_type(CERTIFICATE_TYPE_TRADE, $page_user->guid);
    $license_cert = get_certificate_by_type(CERTIFICATE_TYPE_LICENSE, $page_user->guid);
    $insurance_cert = get_certificate_by_type(CERTIFICATE_TYPE_INSURANCE, $page_user->guid);
    if (!$contractor->state) {
        $forward_url = elgg_get_site_url() . "user/" . $contractor->username . "/edit";
    } elseif (!$contractor->town) {
        $forward_url = elgg_get_site_url() . "user/" . $contractor->username . "/edit";
    } elseif (!$contractor->postcode) {
        $forward_url = elgg_get_site_url() . "user/" . $contractor->username . "/edit";
    } elseif (!$contractor->lastname) {
        $forward_url = elgg_get_site_url() . "user/" . $contractor->username . "/edit";
    } elseif (!$contractor->street1) {
        $forward_url = elgg_get_site_url() . "user/" . $contractor->username . "/edit";
    } elseif (!$emergency_contact) {
        $forward_url = elgg_get_site_url() . "user/" . $contractor->username . "/emergency";
    } elseif (!$trade_cert && !$license_cert && !$insurance_cert) {
        $forward_url = elgg_get_site_url() . "user/" . $contractor->username . "/certification";
    } else {
        $forward_url = elgg_get_site_url() . "user/" . $contractor->username;
    }
    return $forward_url;
}

/**
 * get_user_profile url
 * @param {object} $user
 * @return url
 */
function get_user_profile_url($user) {

    if ($user->username) {
        return "/user/" . $user->username;
    }
    return "#";
}

/**
 * Check company title is unique
 * @param {string} $title
 * @return {boolean}
 */
function validate_company_title($title, $guid = 0) {
    global $CONFIG;

    $query = 'SELECT e . *
				FROM ' . $CONFIG->dbprefix . 'objects_entity o
				JOIN  ' . $CONFIG->dbprefix . 'entities e ON e.guid = o.guid
				JOIN  ' . $CONFIG->dbprefix . 'entity_subtypes es ON es.id = e.subtype
				AND es.subtype = "company"
				WHERE o.title = "' . sanitise_string($title) . '"';
    if ($guid) {
        $query .= " and o.guid != $guid";
    }
    $entitys = get_data($query, 'entity_row_to_elggstar');
    if (empty($entitys))
        return true;
    else
        return false;
}

/**
 * Check material type title is unique
 * @param {string} $title
 * @return {boolean}
 */
function validate_material_type_title($title, $guid = 0) {
    global $CONFIG;

    $query = 'SELECT e . *
				FROM ' . $CONFIG->dbprefix . 'objects_entity o
				JOIN  ' . $CONFIG->dbprefix . 'entities e ON e.guid = o.guid
				JOIN  ' . $CONFIG->dbprefix . 'entity_subtypes es ON es.id = e.subtype
				AND es.subtype = "material_type"
				WHERE o.title = "' . sanitise_string($title) . '"';
    if ($guid) {
        $query .= " and o.guid != $guid";
    }
    $entitys = get_data($query, 'entity_row_to_elggstar');
    if (empty($entitys))
        return true;
    else
        return false;
}

function get_material_type_id_values() {
    $search_arr = array(
        'types' => 'object',
        'subtypes' => 'material_type',
        'limit' => ELGG_ENTITIES_NO_VALUE
    );
    $search_arr['metadata_name_value_pairs'][] = array(
        'name' => "is_deleted",
        'value' => 0,
        'operand' => '='
    );
    $material_type_entities = elgg_get_entities_from_metadata($search_arr);
    $material_id_values = array("" => "select");
    if (count($material_type_entities)) {
        foreach ($material_type_entities as $material_type_entitie) {
            $material_id_values[$material_type_entitie->guid] = $material_type_entitie->title;
        }
    }
    return $material_id_values;
}

/**
 * validate_abn_input
 * @method Validate the abn, check if it's been used befor or not, and if it's 11 digital number
 * @param {string} $abn
 * @return {boolean}
 */
function validate_company_abn($abn, $guid = 0) {
    $flg = false;
    $params = array();
    $params = array('abn' => $abn);
    $company = get_companies($params);
    if (empty($company)) {
        $flg = true;
    } else {
        if ($guid && $company[0]->guid == $guid) {
            $flg = true;
        }
    }
    return $flg;
}

/**
 * get_company_by_name
 * @method
 * @param $company
 * @return object.
 */
function get_company_by_name($company) {
    //echo $company."<br />";
    $companys = null;
    $params = array('name' => $company);
    $companys = get_companies($params);
    //print '<pre>';print_r($companys[0]->name);exit;
    return ($companys) ? $companys[0] : false;
}

/**
 * get_certificate_by_type
 * @method
 * @param $type
 * @return array.
 */
function get_certificate_by_type($type = 0, $user_guid, $page_limit = 0) {
    //echo $type."<br />";
    $certificates_arr = array();
    $select_arr = array(
        'types' => 'object',
        'subtypes' => 'certificate',
        'owner_guid' => $user_guid,
    );
    if ($page_limit) {
        $select_arr['limit'] = $page_limit;
    }
    if ($type) {
        $select_arr['metadata_name_value_pairs'][] = array(
            'name' => "certificate_type",
            'value' => $type
        );
    }
//	if(! elgg_is_admin_logged_in())
//	{
    $select_arr['metadata_name_value_pairs'][] = array(
        'name' => "is_deleted",
        'value' => 0,
        'operand' => '='
    );
    //}
    $certificates = elgg_get_entities_from_metadata($select_arr);
    foreach ($certificates as $certificate) {
        // An array of all qualification types.
        $certificates_arr[$certificate->guid]['guid'] = $certificate->guid;
        $certificates_arr[$certificate->guid]['title'] = $certificate->title;
        $certificates_arr[$certificate->guid]['content'] = $certificate->description;
        $certificates_arr[$certificate->guid]['date_of_issue'] = $certificate->date_of_issue;
        $certificates_arr[$certificate->guid]['date_of_expiry'] = $certificate->date_of_expiry;
        $certificates_arr[$certificate->guid]['certificate_id'] = $certificate->certificate_id;
        $certificates_arr[$certificate->guid]['certificate_type'] = $certificate->certificate_type;
    }
    //print '<pre>';print_r($certificates_arr);//exit;
    return $certificates_arr;
}

/**
 * get_emergency_contact_by_user_guid
 * @method
 * @param $user_guid
 * @return array of objects.
 */
function get_emergency_contact_by_user_guid($user_guid) {
    $options = array(
        "relationship" => "emergency_contact_of_user",
        "relationship_guid" => $user_guid,
        "inverse_relationship" => true,
        "limit" => ELGG_ENTITIES_NO_VALUE
    );

    return elgg_get_entities_from_relationship($options);
}

/**
 * Get an array of users from an email address
 *
 * @param string $email Email address.
 *
 * @return array
 */
function get_user_by_email_noaccess($email) {
    global $CONFIG;

    $email = sanitise_string($email);

    $query = "SELECT e.* from {$CONFIG->dbprefix}entities e
	join {$CONFIG->dbprefix}users_entity u on e.guid=u.guid
	where email='$email' ";

    return get_data($query, 'entity_row_to_elggstar');
}

/**
 * Get user by username
 *
 * @param string $username The user's username
 *
 * @return ElggUser|false Depending on success
 */
function get_user_by_username_noaccess($username) {
    global $CONFIG, $USERNAME_TO_GUID_MAP_CACHE;

    // Fixes #6052. Username is frequently sniffed from the path info, which,
    // unlike $_GET, is not URL decoded. If the username was not URL encoded,
    // this is harmless.
    $username = rawurldecode($username);

    $username = sanitise_string($username);

    // Caching
    if ((isset($USERNAME_TO_GUID_MAP_CACHE[$username])) && (_elgg_retrieve_cached_entity($USERNAME_TO_GUID_MAP_CACHE[$username]))) {
        return _elgg_retrieve_cached_entity($USERNAME_TO_GUID_MAP_CACHE[$username]);
    }

    $query = "SELECT e.* from {$CONFIG->dbprefix}users_entity u
			join {$CONFIG->dbprefix}entities e on e.guid=u.guid
			where u.username='$username' ";

    $entity = get_data_row($query, 'entity_row_to_elggstar');
    if ($entity) {
        $USERNAME_TO_GUID_MAP_CACHE[$username] = $entity->guid;
    } else {
        $entity = false;
    }

    return $entity;
}

/**
 * Generate and send a password request email to a given user's registered email address.
 *
 * @param int $user_guid User GUID
 *
 * @return bool
 */
function send_new_password_request_sytick($user_guid) {
    $user_guid = (int) $user_guid;

    $user = get_entity($user_guid);
    if ($user instanceof ElggUser) {
        // generate code
        $code = generate_random_cleartext_password();
        $user->setPrivateSetting('passwd_conf_code', $code);

        // generate link
        $link = elgg_get_site_url() . "sytick/resetpassword?u=$user_guid&c=$code";

        // generate email
        $site = elgg_get_site_entity();
        $vars = array("username" => $user->name,
            "sitename" => $site->name,
            "ip_address" => $_SERVER['REMOTE_ADDR'],
            "link" => $link,
            "siteurl" => $site->url);
        $email = elgg_echo('email:resetreq:body', array($user->name, $_SERVER['REMOTE_ADDR'], $link));
        $html_body = elgg_view("sytick/forgot_password_email", $vars);
        return notify_user($user->guid, elgg_get_site_entity()->guid, elgg_echo('email:resetreq:subject'), $html_body, array(), 'email');
    }

    return false;
}

/**
 * Validate and execute a password reset for a user.
 *
 * @param int    $user_guid The user id
 * @param string $conf_code Confirmation code as sent in the request email.
 *
 * @return mixed
 */
function execute_new_password_request_sytick($user_guid, $conf_code, $password) {
    global $CONFIG;

    $user_guid = (int) $user_guid;
    $user = get_entity($user_guid);

    if ($user instanceof ElggUser) {
        $saved_code = $user->getPrivateSetting('passwd_conf_code');

        if ($saved_code && $saved_code == $conf_code) {
            //$password = generate_random_cleartext_password();

            if (force_user_password_reset($user_guid, $password)) {
                remove_private_setting($user_guid, 'passwd_conf_code');
                // clean the logins failures
                reset_login_failure_count($user_guid);

                $email = elgg_echo('email:resetpassword:body', array($user->name, $password));

                /* return notify_user($user->guid, $CONFIG->site->guid,
                  elgg_echo('email:resetpassword:subject'), $email, array(), 'email'); */
                return true;
            }
        }
    }

    return FALSE;
}

function get_employees_of_company($company_id) {

    if ($company_id) {
        $options = array(
            "relationship" => "employee_of_company",
            "relationship_guid" => $company_id,
            "limit" => ELGG_ENTITIES_NO_VALUE
        );
        $employees = elgg_get_entities_from_relationship($options);
        return $employees;
    } else {
        return NULL;
    }
}
