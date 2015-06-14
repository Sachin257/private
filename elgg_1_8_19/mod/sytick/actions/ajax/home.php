<?php
$result = array();
$process = get_input("process");
switch($process){
	case "securitycheckout":
		$site_guid = get_input('site_guid');
		$user_guid = get_input('user_guid');
		if($site_guid && $user_guid) {
			$response = checkout_employee_from_site($site_guid, $user_guid);
			if($response['error']) {
				register_error($response['message']);
				forward(REFERER);
			} elseif($response['success']) {
				$result['check_in_out_time'] = ($response['check_in_out_timestamp']) ? date('H:i',$response['check_in_out_timestamp']) : date('H:i',date('U')) ;
				$result['message']= $response['message'];
				//system_message($response['message']);
			}			
		} else {
			register_error(elgg_echo('checkin:error:invalid') );
			forward(REFERER);
		}
		break;
	case "securitycheckin":
		$site_guid = get_input('site_guid');
		$user_guid = get_input('user_guid');
		if($site_guid && $user_guid) {
			$response = checkin_employee_to_site($site_guid, $user_guid);
			if($response['error']) {
				register_error($response['message']);
				forward(REFERER);
			} elseif($response['success']) {
				$result['check_in_out_time'] = ($response['check_in_out_timestamp']) ? date('H:i',$response['check_in_out_timestamp']) : date('H:i',date('U')) ;
				$result['message']= $response['message'];				
				//system_message($response['message']);
			}			
		} else {
			register_error(elgg_echo('checkin:error:invalid') );
			forward(REFERER);
		}
		break;
	case "addDailyWork":
		$paint_guid = get_input('paint_id');
                $no_of_pieces = get_input('nopieces');
		$project_guid = get_input("project_guid");
                $employee = get_input('employee_name');
                $shift = get_input("shift");
                $project = get_entity($project_guid);
                if(!isset($project->nopiecesleft)){
                    $project->nopiecesleft = $project->nopieces;
                }
                if($project->nopiecesleft < $no_of_pieces){
                    $result['status'] = -1;
                    register_error("Please check your entry and try again");
                    break;
                }
                
                $entity = get_entity($paint_guid);
                if (elgg_instanceof($entity, 'object', 'paint')) {
		$paint = $entity;
                
                $title = $project->title;
                $title = $title.date("Y-m-d");
                $dailyWork = new ElggObject();
                $dailyWork->subtype = "dailyWork";
                $dailyWork->owner_guid = elgg_get_logged_in_user_guid();
                $dailyWork->title = $title;
                $dailyWork->nopieces = $no_of_pieces;
                $dailyWork->access_id = ACCESS_PUBLIC;
                $dailyWork->paint_quantity_used = $paint_used;
                $dailyWork->paint_used = $paint_guid;
                $dailyWork->proj_guid = $project_guid;
                $dailyWork->employee = $employee;
                $dailyWork->shift = $shift;
                $dailyWork->is_deleted = 0;
                $dailyWork_guid = $dailyWork->save();
                if($dailyWork_guid)
                {
                    add_entity_relationship($project->guid, "project_of_daily_log", $dailyWork_guid);
                    $project->nopiecesleft = $project->nopiecesleft - $no_of_pieces;
                }
                } 
                else {
                        register_error(elgg_echo('paint:notfound'));
                        forward(get_input('forward', REFERER));
                }
		break;
	case "getaddworkerformfields":
		// check username
		$company_id = get_sanitised_input('company_guid');
		$project_guid = get_input('project_guid');
		if($company_id)
		{			
			$prjmanagers = get_employees_of_company_by_type($company_id, PROJECT_MANAGER_PROFILE_TYPE);
			$prjmanager_id_values = array();
			$prjmanager_ids = array();
			if(count($prjmanagers))
			{
				foreach($prjmanagers as $prjmanager)
				{
					$prjmanager_id_values[$prjmanager->name] = $prjmanager->guid;
					$prjmanager_ids[] = $prjmanager->guid;
				}
			}
			$current_prjmanagers = ($project_guid) ? get_projects_current_employees($company_id, $project_guid, PROJECT_MANAGER_PROFILE_TYPE, $prjmanager_ids) :  false;
			//print '<pre>';print_r($current_prjmanagers);die();
			$result['prjmanger_field'] = elgg_view("input/checkboxes", array(
					"name" => "prj_mgrs_of_prj",
					"id" => "prj_mgrs_of_prj",
					"options" => $prjmanager_id_values,
					'value' => $current_prjmanagers
			));			
			$contractors = get_employees_of_company_by_type($company_id, CONTRACTOR_PROFILE_TYPE);
			$contractors_id_values = array();
			$contractors_ids = array();
			if(count($contractors))
			{
				foreach($contractors as $contractor)
				{
					$contractors_id_values[$contractor->name] = $contractor->guid;
					$contractors_ids[] = $contractor->guid;
				}
			}
			$current_contractors = ($project_guid) ? get_projects_current_employees($company_id, $project_guid, CONTRACTOR_PROFILE_TYPE, $contractors_ids) :  false;
			$result['contractors_field'] = elgg_view("input/checkboxes", array(
					"name" => "contactors_of_prj",
					"id" => "contactors_of_prj",
					"options" => $contractors_id_values,
					'value' => $current_contractors
			));				
		} else
		{
			register_error(elgg_echo('company:none'));
			forward(REFERER);
		}
		break;
        case "change_alert_response":
                $alert_id = get_input('alert');
                $alert = get_entity($alert_id);
                $alert->response = 1;
                $alert->save();
                break;
	case "getsitesformfields":
		// check username
		$company_id = get_sanitised_input('company_id');
		$guid = get_input('guid');
		if($company_id)
		{
			$project_id_values = array();
			$projects = get_projects_of_company($company_id);
			if(count($projects)){
				foreach($projects as $project)
				{
					$project_id_values[] = array("guid"=>$project->guid, "name"=>$project->title);
				}
				$result['project_id'] = $project_id_values;
			} 
			$sitemanagers = get_employees_of_company_by_type($company_id, SITE_MANAGER_PROFILE_TYPE);
			$sitemanager_id_values = array();
			if(count($sitemanagers))
			{
				foreach($sitemanagers as $sitemanager)
				{
					$sitemanager_id_values[$sitemanager->name] = $sitemanager->guid;
				}
			}
			$current_sitemanagers = ($guid) ? get_sites_current_sitesmanagers($guid) :  false;
			$result['sitemanger_field'] = elgg_view("input/checkboxes", array(
												"name" => "sitemanager_id",	
												"id" => "sitemanager_id",		
												"options" => $sitemanager_id_values,
												'value' => $current_sitemanagers
											));  
			
		} else
		{
			register_error(elgg_echo('company:none'));
			forward(REFERER);
		}
		break;
        case "getItemsFromType":
                $inventory_type = get_sanitised_input('inventory_type');
                if($inventory_type == "paint"){
                    $search_arr = array(
                    'types' => 'object',
                    'subtypes' => 'paint',
                    'limit' => ELGG_ENTITIES_NO_VALUE
                     );

                    $search_arr['metadata_name_value_pairs'][] = array(
                                    'name' => "is_deleted",
                                    'value' => 0,
                                    'operand' => '='
                    );
                $entities = elgg_get_entities_from_metadata($search_arr);
                }else{
                    echo $inventory_type;exit;
                }
                $result['roles'] = $entities;
                break;
        case "get_paint_details":
                $paint_guid = get_sanitised_input('paint_guid');
                $paint = get_entity($paint_guid);
                $result['paint_name'] = $paint->title;
                $result['paint_id'] = $paint->paint_id;
                $result['colour'] = $paint->colour;
                $result['quantity'] = $paint->quantity;
                break;
	case "activateemployee":
		$user_guid = get_input('u');
		$code = get_input('c');
		$password = get_sanitised_input('password');
		$password2 = get_sanitised_input('password2');
		if (trim($password) == "" || trim($password2) == "") {
			register_error(elgg_echo('RegistrationException:EmptyPassword'));
			forward();exit;
		}
		if (strcmp($password, $password2) != 0) {
			register_error(elgg_echo('RegistrationException:PasswordMismatch'));
			forward();exit;
		}
		if (execute_new_password_request_sytick($user_guid, $code, $password)) {
			system_message(elgg_echo('activate:employee:success'));
			$user = get_entity($user_guid);
			$user->enabled ='yes';
			$user->save();			
			try {
				login($user);
				// re-register at least the core language file for users with language other than site default
				register_translations(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/languages/");
			} catch (LoginException $e) {
				register_error($e->getMessage());
				forward(REFERER);exit;
			}
				
			// elgg_echo() caches the language and does not provide a way to change the language.
			// @todo we need to use the config object to store this so that the current language
			// can be changed. Refs #4171
			if ($user->language) {
				$message = elgg_echo('loginok', array(), $user->language);
			} else {
				$message = elgg_echo('loginok');
			}
				
			if (isset($_SESSION['last_forward_from'])) {
				unset($_SESSION['last_forward_from']);
			}
				
			$forward_url = get_user_login_url();
				
			
			$result['message'] = $message;
			$result['forward_url'] = $forward_url;
		} else {
			register_error(elgg_echo('user:password:fail'));
			forward(REFERER);exit;
		}
		break;
	case "employeeuniquechk":
		// check username
		$contact_email = get_sanitised_input('employee_email');
		$guid = get_input('guid');
		$company_id = get_input('company_id');
		if (empty($contact_email)){
			register_error(elgg_echo('registration:notemail'));
			forward(REFERER);
		}
		if(!$guid)
		{
			$users = get_user_by_email_noaccess($contact_email);
			if(($users) && isset($users[0])) {
				register_error(elgg_echo('manager:error:save'));
				forward(REFERER);
			}
		}
		if(!check_unique_company_employee($contact_email, $company_id))
		{
			register_error(elgg_echo('company:employee:unique:error'));
			forward(REFERER);
		}
		break;
        case "profile_pic_upload":
                $user_guid = get_sanitised_input('guid');
                $page_user = get_entity($user_guid);
                $vars["entity"] = $page_user;
		$result['result_html'] = elgg_view('user/sidebar/profile_pic_upload', $vars);
                break;
	case "manageruniquechk":
		// check username
		$contact_email = get_sanitised_input('manager_email');
		$guid = get_input('guid');
		$company_id = get_input('company_id');
		if (empty($contact_email)){
			register_error(elgg_echo('registration:notemail'));
			forward(REFERER);
		}
		if(!$guid)
		{
			$users = get_user_by_email_noaccess($contact_email);
			if(($users) && isset($users[0])) {
				register_error(elgg_echo('manager:error:save'));
				forward(REFERER);
			}			
		}
		if(!check_unique_company_primary_contact($contact_email, $company_id))
		{
			register_error(elgg_echo('company:contact:unique:error'));
			forward(REFERER);
		}
		break;
	case "activatemanager":
		$user_guid = get_input('u');
		$code = get_input('c');
		$password = get_sanitised_input('password');
		$password2 = get_sanitised_input('password2');
		if (trim($password) == "" || trim($password2) == "") {
			register_error(elgg_echo('RegistrationException:EmptyPassword'));
			forward();exit;
		}
		if (strcmp($password, $password2) != 0) {
			register_error(elgg_echo('RegistrationException:PasswordMismatch'));
			forward();exit;
		}
		if (execute_new_password_request_sytick($user_guid, $code, $password)) {
			system_message(elgg_echo('activate:manager:success'));			
			$user = get_entity($user_guid);
			$user->enabled ='yes';
			$user->save();
			$company_id = get_company_from_primary_contact($user_guid);
			if($company_id)
			{
				$company = get_entity($company_id);
				$company->status = 1;
				$company->save();
			}
			try {
				login($user);
				// re-register at least the core language file for users with language other than site default
				register_translations(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/languages/");
			} catch (LoginException $e) {
				register_error($e->getMessage());
				forward(REFERER);exit;
			}
			
			// elgg_echo() caches the language and does not provide a way to change the language.
			// @todo we need to use the config object to store this so that the current language
			// can be changed. Refs #4171
			if ($user->language) {
				$message = elgg_echo('loginok', array(), $user->language);
			} else {
				$message = elgg_echo('loginok');
			}
			
			if (isset($_SESSION['last_forward_from'])) {
				unset($_SESSION['last_forward_from']);
			}
			
			$forward_url = get_user_login_url();
			
			//system_message($message);
			//forward($forward_url);
			$result['message'] = $message;
			$result['forward_url'] = $forward_url;			
		} else {
			register_error(elgg_echo('user:password:fail'));
			forward(REFERER);exit;
		}		
		break;
	case "searchdropdown":
                $search = get_sanitised_input('general_search');
                $company_ids = company_general_search();
                $result_company = get_company_search($search , join($company_ids,",") );
                $vars['result_company'] = array_slice($result_company, 0, 2);
                
                $project_ids = project_general_search();
                $result_project = get_project_search($search , join($project_ids,",") );
                $vars['result_project'] = array_slice($result_project, 0, 2);
                
                $user_ids = user_general_search();
                $result_users = get_user_search($search,join($user_ids,",") );
                $vars['result_users'] = array_slice($result_users, 0, 2);
                
                $induction_ids = induction_general_search();
                $result_induction = get_induction_search($search,join($induction_ids,",") );
                $vars['result_induction'] = array_slice($result_induction, 0, 2);
                $result['search_result'] = elgg_view("sytick/search_dropdown", $vars);
                //print '<pre>';print_r($result['search_result']);print '</pre>';exit;
                break;
            
        case "search_all":
                $search = get_sanitised_input('general_search');         
                $company_ids = company_general_search();
                $result_company = get_company_search($search , join($company_ids,",") );
                $result_company = array_slice($result_company, 0, 4);
                $comapnies =array();
                foreach($result_company as $company)
                {
                    $companies[] = get_entity($company);
                }
                $vars['companies'] = $companies;
                //print "<pre>";print_r($companies);print "</pre>";exit;

                $project_ids = project_general_search();
                $result_project = get_project_search($search , join($project_ids,",") );
                $result_project = array_slice($result_project, 0, 4);
                $projects = array();
                foreach ($result_project as $project)
                {
                    $projects[] = get_entity($project);
                }
                //print "<pre>";print_r($projects);print "</pre>";exit;
                $vars['projects'] = $projects;

                $user_ids = user_general_search();
                $result_users = get_user_search($search,join($user_ids,",") );
                $result_users = array_slice($result_users, 0, 4);
                $users =array();
                foreach($result_users as $user)
                {
                    $users[] = get_entity($user);
                }
                $vars['users'] =$users;

                $induction_ids = induction_general_search();
                $result_induction = get_induction_search($search,join($induction_ids,",") );
                $result_induction = array_slice($result_induction, 0, 4);
                $inductions = array();
                foreach($result_induction as $induction)
                {
                    $inductions[] = get_entity($induction);
                }
                $vars['inductions'] = $inductions;
                $result['html'] = elgg_view('search/all', $vars);
                break;
        case "search_project":
                $search = get_sanitised_input('general_search');
                $limit = get_sanitised_input('limit');
                $project_ids = project_general_search();
                $result_project = get_project_search($search , join($project_ids,",") );
                $result_project = array_slice($result_project, 0, $limit);
                $projects = array();
                foreach ($result_project as $project)
                {
                    $projects[] = get_entity($project);
                }
                $vars['projects'] = $projects;
                $result['html'] = elgg_view('search/all', $vars);
                break;
        case "search_project_add":
                $search = get_sanitised_input('general_search');
                $limit = get_sanitised_input('limit');
                $offset = $limit - 5;
                $project_ids = project_general_search();
                $result_project = get_project_search($search , join($project_ids,",") );
                $result_project = array_slice($result_project, $offset, 5);
                $projects = array();
                foreach ($result_project as $project)
                {
                    $projects[] = get_entity($project);
                }
                $vars['projects'] = $projects;
                $result['html'] = "";
                if($vars['projects'])
                {
                $result['html'] = elgg_view('search/projects', $vars);
                }
                break;
        case "search_user":
                $search = get_sanitised_input('general_search');
                $limit = get_sanitised_input('limit');
                $user_ids = user_general_search();
                $result_users = get_user_search($search,join($user_ids,",") );
                $result_users = array_slice($result_users, 0, $limit);
                $users =array();
                foreach($result_users as $user)
                {
                    $users[] = get_entity($user);
                }
                $vars['users'] =$users;            
                $result['html'] = elgg_view('search/all', $vars);
                break;
        case "search_user_add":
                $search = get_sanitised_input('general_search');
                $limit = get_sanitised_input('limit');
                $offset = $limit - 5;
                $user_ids = user_general_search();
                $result_users = get_user_search($search,join($user_ids,",") );
                $result_users = array_slice($result_users, $offset, 5);
                $users =array();
                foreach($result_users as $user)
                {
                    $users[] = get_entity($user);
                }
                $vars['users'] =$users;
                $result['html'] = "";
                if($vars['users'])
                {
                $result['html'] = elgg_view('search/users', $vars);
                }
                break;
        case "search_company":
                $search = get_sanitised_input('general_search');
                $limit = get_sanitised_input('limit');
                $company_ids = company_general_search();
                $result_company = get_company_search($search , join($company_ids,",") );
                $result_company = array_slice($result_company, 0, $limit);
                $comapnies =array();
                foreach($result_company as $company)
                {
                    $companies[] = get_entity($company);
                }
                $vars['companies'] = $companies;
                $result['html'] = elgg_view('search/all', $vars);
                break;
        case "search_company_add":
                $search = get_sanitised_input('general_search');
                $limit = get_sanitised_input('limit');
                $offset = $limit - 5;
                $company_ids = company_general_search();
                $result_company = get_company_search($search , join($company_ids,",") );
                $result_company = array_slice($result_company, $offset, 5);
                $comapnies =array();
                foreach($result_company as $company)
                {
                    $companies[] = get_entity($company);
                }
                $vars['companies'] = $companies;
                $result['html'] = '';
                if($vars['companies'])
                {
                $result['html'] = elgg_view('search/companies', $vars);
                }
                break;
        case "search_induction":
                $search = get_sanitised_input('general_search');
                $limit = get_sanitised_input('limit');
                $induction_ids = induction_general_search();
                $result_induction = get_induction_search($search,join($induction_ids,",") );
                $result_induction = array_slice($result_induction, 0, $limit);
                $inductions = array();
                foreach($result_induction as $induction)
                {
                    $inductions[] = get_entity($induction);
                }
                $vars['inductions'] = $inductions;            
                $result['html'] = elgg_view('search/all', $vars);
                break;
        case "search_induction_add":
                $search = get_sanitised_input('general_search');
                $limit = get_sanitised_input('limit');
                $offset = $limit - 5;
                $induction_ids = induction_general_search();
                $result_induction = get_induction_search($search,join($induction_ids,",") );
                $result_induction = array_slice($result_induction, $offset , 5);
                $inductions = array();
                foreach($result_induction as $induction)
                {
                    $inductions[] = get_entity($induction);
                }
                $vars['inductions'] = $inductions; 
                $result['html'] = '';
                if($vars['inductions'])
                {
                $result['html'] = elgg_view('search/inductions', $vars);
                }
                break;
	case "titleuniquechk":
		$entity_name = get_sanitised_input('title');
		$guid = get_input('guid');
                $result["namestatus"] = 1;
		if(!validate_material_type_title($entity_name, $guid))
		{
                    $result["namestatus"] = -1;
		}
		break;
	case "companyuniquechk":
		// check username
		$entity_name = get_sanitised_input('entity_name');
		$guid = get_input('guid');
		if (empty($entity_name)){
			register_error(elgg_echo('company:title:error'));
			forward(REFERER);
		}
		if(!validate_company_title($entity_name, $guid))
		{
			register_error(elgg_echo('company:title:unique:error'));
			forward(REFERER);
		}
		break;
	case "register" :
		elgg_make_sticky_form('register');		
		// Get variables
		$username = get_sanitised_input('username');
                if(strlen($username) < 5)
                    {
                        $to_add = 5 - strlen($username);
			$username = str_pad($username, $to_add, "0", STR_PAD_RIGHT);
                    }
                $username = get_unique_username($username);
		$password = get_sanitised_input('password', null, false);
		$email = get_sanitised_input('email');
		$name = get_sanitised_input('name');
		$friend_guid = (int) get_input('friend_guid', 0);
		$invitecode = get_input('invitecode');		
		if (elgg_get_config('allow_registration')) {
			try {	
				$guid = register_user($username, $password, $name, $email, false, $friend_guid, $invitecode);
				if ($guid) {
					$new_user = get_entity($guid);
					// change to add contractor registration through registration form
					$contractor_arr = get_custom_profile_types(CONTRACTOR_PROFILE_TYPE);
					if(isset($contractor_arr) && isset($contractor_arr['guid']) && $contractor_arr['guid']){
						$new_user->custom_profile_type = $contractor_arr['guid'];
						$new_user->save();
					}
                                        $params = array(
							'user' => $new_user,
							'password' => $password,
							'friend_guid' => $friend_guid,
							'invitecode' => $invitecode
					);		
					// @todo should registration be allowed no matter what the plugins return?
					if (!elgg_trigger_plugin_hook('register', 'user', $params, TRUE)) {
						$ia = elgg_set_ignore_access(true);
						$new_user->delete();
						elgg_set_ignore_access($ia);
						// @todo this is a generic messages. We could have plugins
						// throw a RegistrationException, but that is very odd
						// for the plugin hooks system.
						throw new RegistrationException(elgg_echo('registerbad'));
					}		
					elgg_clear_sticky_form('register');
					system_message(elgg_echo("registerok", array(elgg_get_site_entity()->name)));
		
					// if exception thrown, this probably means there is a validation
					// plugin that has disabled the user
					try {
						login($new_user);
					} catch (LoginException $e) {
						// do nothing
					}		
					// Forward on success, assume everything else is an error...
					forward();
				} else {
					register_error(elgg_echo("registerbad"));
				}
			} catch (RegistrationException $r) {
				register_error($r->getMessage());
			}
		} else {
			register_error(elgg_echo('registerdisabled'));
		}		
		forward(REFERER);
		break;
	case "resetpassword":
		$user_guid = get_input('u');
		$code = get_input('c');
		$password = get_sanitised_input('password');
		$password2 = get_sanitised_input('password2');
		if (trim($password) == "" || trim($password2) == "") {
			register_error(elgg_echo('RegistrationException:EmptyPassword'));
			forward();
		}
		if (strcmp($password, $password2) != 0) {
			register_error(elgg_echo('RegistrationException:PasswordMismatch'));
			forward();
		}
		if (execute_new_password_request_sytick($user_guid, $code, $password)) {
			system_message(elgg_echo('user:password:success'));
		} else {
			register_error(elgg_echo('user:password:fail'));
		}		
		forward();	
		break;		
	case "requestnewpassword":
		$username = get_sanitised_input('username');		
		// allow email addresses
		if (strpos($username, '@') !== false && ($users = get_user_by_email($username))) {
			$username = $users[0]->username;
		}		
		$user = get_user_by_username($username);
		if ($user) {
			if (send_new_password_request_sytick($user->guid)) {
				system_message(elgg_echo('user:password:resetreq:success'));
			} else {
				register_error(elgg_echo('user:password:resetreq:fail'));
			}
		} else {
			register_error(elgg_echo('user:username:notfound', array($username)));
		}		
		forward();
		
		break;
	case "resend":
		$resend_email = get_sanitised_input('resend_email');
		if (empty($resend_email)) {
			register_error(elgg_echo('registration:notemail'));
			forward();
		}
		$users = get_user_by_email_noaccess($resend_email);
		$username = ($users[0] && $users[0]->username) ? $users[0]->username :"";
		if($username == "")
		{
			register_error(elgg_echo('registration:baduser'));
			forward(REFERER);
		}
		$user = get_user_by_username_noaccess($username);
		if (!$user) {
			register_error(elgg_echo('registration:baduser'));
			forward(REFERER);
		}
		$user_id = $user->guid;
		$is_validated = elgg_get_user_validation_status($user_id);
		if ($is_validated == TRUE) {
			register_error(elgg_echo('registeration:user:activated'));
			forward(REFERER);
		}
		if ( !uservalidationbyemail_request_validation($user_id, true)) {
			register_error(elgg_echo('registeration:user:activated'));
			forward(REFERER);
		} 
		break;
	case "spamchk":
		// check username
		$captcha = get_sanitised_input('sirisana_input');
		$siritupu = get_sanitised_input('sirisana_input');
		if (empty($siritupu)){
			register_error(elgg_echo('sirikinasa:isblank'));
			forward(REFERER);
		}
		if (!include_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/gutwacaptcha/securimage.php"))
		{
			register_error(elgg_echo('Please check your Elgg captcha path for all required files.'));
			forward(REFERER);
		}
		$securimage = new Securimage();
		if ($securimage->check($captcha) == false) {
			$errors['captcha_error'] = register_error(elgg_echo('gutwacaptcha:required'));		
			// Forward on success, assume everything else is an error...
			forward(REFERER); // Get our of here !Huh huh
		}
		break;
	case "validate":
		// check username
		//$user_id = elgg_get_logged_in_user_guid();		
		$username = get_sanitised_input('username');
		$password = get_sanitised_input('password', null, false);
		$persistent = (bool) get_input("persistent");
		$ouput = false;
		if (empty($username) || empty($password)) {
			register_error(elgg_echo('login:empty'));
			forward();
		}
		if (strpos($username, '@') !== false && ($users = get_user_by_email($username))) {
			$username = $users[0]->username;
		}
		$ouput = elgg_authenticate($username, $password);
		if ($ouput !== true) {
			register_error($ouput);
			forward(REFERER);
		}
		$user = get_user_by_username($username);
		if (!$user) {
			register_error(elgg_echo('login:baduser'));
			forward(REFERER);
		}
		try {
			login($user, $persistent);
			// re-register at least the core language file for users with language other than site default
			register_translations(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . "/languages/");
		} catch (LoginException $e) {
			register_error($e->getMessage());
			forward(REFERER);
		}
		
		// elgg_echo() caches the language and does not provide a way to change the language.
		// @todo we need to use the config object to store this so that the current language
		// can be changed. Refs #4171
		if ($user->language) {
			$message = elgg_echo('loginok', array(), $user->language);
		} else {
			$message = elgg_echo('loginok');
		}
		
		if (isset($_SESSION['last_forward_from'])) {
			unset($_SESSION['last_forward_from']);
		}
		
		$forward_url = get_user_login_url();
		
		//system_message($message);
		//forward($forward_url);
		$result['message'] = $message;
		$result['forward_url'] = $forward_url;
		
		break;
	case "page":
			// check username
			$page = get_input('page');
			if (empty($page)){
				register_error(elgg_echo('page:notfound'));
				forward(REFERER);
			}
			$page = strtolower($page);
			
			$title = elgg_echo("expages:$page");
			$object = elgg_get_entities(array(
					'type' => 'object',
					'subtype' => $page,
					'limit' => 1,
			));
			$content = "";
			if ($object) {
				$content = elgg_view('output/longtext', array('value' => $object[0]->description));
			} else {
				register_error(elgg_echo('page:notfound'));
				forward(REFERER);
			}
			$result['title'] = $title;
			$result['content'] = $content;
		break;
}
echo json_encode($result);