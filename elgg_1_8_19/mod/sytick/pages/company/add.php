<?php
// make sure only logged in users can see this page
gatekeeper();
// set the title
$vars["company_type"] = ($segments[1]) ? $segments[1] : 1;
$company_type =  (isset($segments[1]) && ($segments[1] == 2)) ?  elgg_echo('company:title:contracting') : elgg_echo('company:title:construction');
$title = elgg_echo('company:title:add', array($company_type));

// start building the main column of the page
$content = "";//elgg_view_title($title,array('class'=>"companytitle"));
$body_title = elgg_view_title($title ,array('class'=>"companytitle"));


// add the form to this section
$content .= elgg_view_form("company/save", array(), $vars);

// layout the page
$body = elgg_view_layout('one_column', array('title' => $body_title, 'content' => $content));

// draw the page
echo elgg_view_page($title, $body);