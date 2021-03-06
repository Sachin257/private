<?php
// make sure only logged in users can see this page
gatekeeper();

global $order_from_types;
global $units;

$name = $_GET["name"];
$from = $_GET["from"];

// set the title
// for distributed plugins, be sure to use elgg_echo() for internationalization
$title = elgg_echo('painting_project:add');

// start building the main column of the page
$content = elgg_view_title($title);
$vars["material_id_values"] = get_material_type_id_values();
$vars["order_from_types"] = $order_from_types;
$vars["units"] = $units;
if ($name !== "") {
    $vars["entity"]->title = $name;
}
if ($from !== "") {
    $vars["entity"]->order_from_types = $from;
}
// add the form to this section
$content .= elgg_view_form("painting_project/save", array("id" => "frm_paint_project", 'enctype' => 'multipart/form-data'), $vars);
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