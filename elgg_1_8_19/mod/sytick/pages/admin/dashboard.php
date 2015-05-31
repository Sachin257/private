<?php
    // make sure only logged in users can see this page
    admin_gatekeeper();
    $title = elgg_echo('admin:dashboard:title');

    $vars = array();
    $options = array(
        'type' => 'object',
        'subtype' => 'painting_project',
        'count' => TRUE,
    );
    $options['metadata_name_value_pairs'][] = array(
        'name' => "is_deleted",
        'value' => 0,
        'operand' => '='
    );
    $vars["painting_projects"] = elgg_get_entities_from_metadata($options);
    $options = array(
        'type' => 'object',
        'subtype' => 'paint',
        'count' => TRUE,
    );
    $options['metadata_name_value_pairs'][] = array(
        'name' => "is_deleted",
        'value' => 0,
        'operand' => '='
    );
    $vars["paints"] = elgg_get_entities_from_metadata($options);

// add the form to this section
    $content = elgg_view("admin/sytick_dashboard", $vars);

    // layout the page
    $body = elgg_view_layout('one_column', array('content' => $content));

    // draw the page
    echo elgg_view_page($title, $body);

