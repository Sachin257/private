<?php
// make sure only logged in users can see this page
gatekeeper();
// set the title
// for distributed plugins, be sure to use elgg_echo() for internationalization
$title = elgg_echo('tentative:work');

// start building the main column of the page
$content = elgg_view_title($title);
$content .= elgg_view_form("tentative_work/save", array("id" => "frm_tentative_work", 'enctype' => 'multipart/form-data'), $vars);
$sidebar = "";

//print "<pre>";print_r($vars);exit;
// layout the page
$body = elgg_view_layout('one_column', array('content' => $content));
// draw the page
echo elgg_view_page($title, $body);
?>