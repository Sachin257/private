<?php
// need to restrict for company managers and admin
gatekeeper();
// set the title
$title = elgg_echo('employee:title:add');

$code = "officeelgg";






// start building the main column of the page
$cid = get_input("cid");
if($cid) {
	$vars["company_id"] = $cid;
}

$profile_type_guid = "";
$profile_type_label = "";
$profile_type_name = "";
if(isset($segments[1]) && $segments[1])
{
	$profile_type_guid = $segments[1];
	$profile_type = get_entity($profile_type_guid);
	if($profile_type){
		//print '<pre>';print_r($profile_type);exit;
		$profile_type_label = $profile_type->metadata_label;
		$profile_type_name = $profile_type->metadata_name;
		$title = $title ." - ".$profile_type_label;
	}
}
$content = "";//elgg_view_title($title,array("class"=>"manager_h2"));
$body_title = elgg_view_title($title ,array('class'=>"companytitle"));

$profile_type_arr = get_custom_profile_types();
$profile_type_values = array(""=>"");

if($profile_type_guid)
{
	$vars["profile_type_id"] = $profile_type_guid;
}   else {	
	if(elgg_is_admin_logged_in()){
		foreach($profile_type_arr as $profile_type){
			if($profile_type['label'] != MANAGER_PROFILE_TYPE  )
			{
				$profile_type_values[$profile_type['guid']] = $profile_type['label'];
			}
		}
	}	
	$vars["profile_type_values"] = $profile_type_values;
}
//print '<pre>';print_r($profile_type_values);exit;

// add the form to this section
$content .= elgg_view_form("employee/save", array(), $vars);

// layout the page
$body = elgg_view_layout('one_column', array('title' => $body_title, 'content' => $content));

// draw the page
echo elgg_view_page($title, $body, "default", array("class"=>"empl_addctr"));
