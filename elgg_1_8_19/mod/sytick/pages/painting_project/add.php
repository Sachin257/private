<?php
// make sure only logged in users can see this page
gatekeeper();

$name = $_GET["name"];

// set the title
// for distributed plugins, be sure to use elgg_echo() for internationalization
$title = elgg_echo('painting_project:add');

// start building the main column of the page
$content = elgg_view_title($title);
$vars["material_id_values"] = get_material_type_id_values();
if($name !== "")
{
$vars["entity"]->title = $name;
}
// add the form to this section
$content .= elgg_view_form("painting_project/save", array("id"=>"frm_paint_project", 'enctype' => 'multipart/form-data'), $vars);
//print_r(elgg_view_form("paint/save"));exit;
// optionally, add the content for the sidebar
$sidebar = "";

//print "<pre>";print_r($vars);exit;
// layout the page
$body = elgg_view_layout('one_column', array(
		'content' => $content
));
// draw the page
echo elgg_view_page($title, $body);
?>