<?php
// need to restrict for company managers and admin
gatekeeper();
// set the title

// start building the main column of the page
$content = "";//elgg_view_title($title);

$body_title = elgg_view_title($title ,array('class'=>"companytitle"));

$vars["date"] = date("Y-m-d");

$content .= elgg_view_form("project/save", array("id"=>"frm_project", 'enctype' => 'multipart/form-data'), $vars);

// layout the page
$body = elgg_view_layout('one_column', array('title' => $body_title, 'content' => $content));

// draw the page
echo elgg_view_page($title, $body);