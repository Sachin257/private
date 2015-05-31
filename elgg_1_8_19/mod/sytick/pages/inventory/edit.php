<?php

// make sure only logged in users can see this page 
gatekeeper();
global $inventory_types;
$title = elgg_echo('item:edit');
$content = elgg_view_title($title);

// Get the qualification entity from the id passed to the page.
$item = get_entity(intval($segments[1]));
$vars = array();
$vars["entity"] = $item;
$inventory_type = get_subtype_from_id($item->subtype);
$vars['key'] = array_search($inventory_type, $inventory_types);
$vars["inventory_types"] = $inventory_types;
// add the form to this section			
$content .= elgg_view_form("inventory/save", array(), $vars);

// optionally, add the content for the sidebar
$sidebar = "";

// layout the page
$body = elgg_view_layout('one_column', array(
    'content' => $content
        ));

// draw the page
echo elgg_view_page($title, $body);
?>