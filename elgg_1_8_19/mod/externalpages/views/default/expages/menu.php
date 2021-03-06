<?php
/**
 * External pages menu
 *
 * @uses $vars['type']
 */

$type = $vars['type'];

//set the url
$url = $vars['url'] . "admin/site/expages?type=";
 
$pages = array('about', 'terms', 'privacy','cookie');
$tabs = array();
foreach ($pages as $page) {
	$tabs[] = array(
		'title' => elgg_echo("expages:$page"),
		'url' => "admin/appearance/expages?type=$page",
		'selected' => $page == $type,
	);
}

echo elgg_view('navigation/tabs', array('tabs' => $tabs, 'class' => 'elgg-form-settings'));
