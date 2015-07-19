<?php
// make sure only logged in users can see this page
gatekeeper();
global $order_from_types;
// set the title
// for distributed plugins, be sure to use elgg_echo() for internationalization
$title = elgg_echo('assign:work');

// start building the main column of the page
$content = elgg_view_title($title);
$vars["order_from_types"] = $order_from_types;
$content .= elgg_view_form("assign_work/save", array("id" => "frm_assign_work", 'enctype' => 'multipart/form-data'), $vars);
$sidebar = "";

//print "<pre>";print_r($vars);exit;
// layout the page
$body = elgg_view_layout('one_column', array('content' => $content));
// draw the page
echo elgg_view_page($title, $body);
?>