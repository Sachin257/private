<?php
// make sure only logged in users can see this page
gatekeeper();
elgg_load_js('msdropdown.js');
elgg_load_css('msdropdown.css');
$title = elgg_echo('securityperson:dashboard:title');
$select = elgg_echo("entity:select");
$manager = get_user_by_username_noaccess($segments[0]);
if (! $manager ) {
	register_error(elgg_echo('profile:notfound'));
	forward( REFERER);
}
$vars = array();

$logo_url =  get_image_path("stad_logo.png");
$vars['image_url'] = $logo_url;
$company = get_company_of_employee($page_user->guid);
$company_id = ($company) ? $company->guid :0;
$current_date_timestamp = date('U');
$employee_check_in_out = get_employee_current_checkin_status($page_user->guid, $current_date_timestamp);
$vars['user'] = $page_user;
if($employee_check_in_out){
	$site_guid = $employee_check_in_out->checkin_in_out_site_guid;
	$check_in_site = get_entity($site_guid);
	$vars['check_in_out_site'] = $check_in_site; 
	$vars['company'] = $company;
	$content = elgg_view("security_person/check_in_out_index", $vars);
        $body_class = "tb_checkin_dashboard";
} else {
	elgg_load_js('twitter_bootstrap.fancybox');
	elgg_load_css('twitter_bootstrap.fancybox');
	elgg_load_js('lessonviewer.bootbox');
	$projects = get_projects_by_security_person_guid($page_user->guid);
	$project_id_values = array(""=>"$select");
	if(count($projects))
	{
		foreach($projects as $project)
		{
			$project_id_values[$project->guid] = $project->title;
		}			
	} 
	$vars['projects'] = $project_id_values;
	$content = elgg_view_form("security_person/dashboard", array("id" => "security_dashboard" ) , $vars);
        $body_class = "tb_security_checkin";
}
//print "<pre>";print_r($employee_check_in_out);exit;
// layout the page
$body = elgg_view_layout('one_column', array('content' => $content));

// draw the page
echo elgg_view_page($title, $body, "default", array("class"=>$body_class));