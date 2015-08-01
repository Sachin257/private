<?php
// need to restrict for company managers and admin
gatekeeper();
// set the title
$title = elgg_echo('manager:title:add');

// start building the main column of the page
$content = "";//elgg_view_title($title,array("class"=>"manager_h2"));
$body_title = elgg_view_title($title ,array('class'=>"companytitle"));

if(elgg_is_admin_logged_in()){
	$vars["company_id_values"] = get_companies_arr_list();
} else {
	$company = get_company_of_manager(elgg_get_logged_in_user_guid());
	$vars["company_id"] = ($company) ? $company->guid :0;
}

// add the form to this section
$content .= elgg_view_form("manager/save", array(), $vars);

// layout the page
$body = elgg_view_layout('one_column', array('title' => $body_title, 'content' => $content));

// draw the page
echo elgg_view_page($title, $body);