<?php
    gatekeeper();
    $title = get_sanitised_input('project_name');
    $customer = get_sanitised_input('customer');
    $start_date = get_sanitised_input('start_date');
    $final_date = get_sanitised_input('final_date');
    $guid = get_sanitised_input('guid');

    if (!check_unique_project_name($title, $guid)) {
        $result['output']['error_field'] = "project_name";
        $result['system_messages']['error'] = array(elgg_echo('project:name:not_unique'));
        $result['system_messages']['success'] = array();
        $result['status'] = -1;
        echo json_encode($result);
        exit;
    }
    if ($guid) {
        $entity = get_entity($guid);
        if (elgg_instanceof($entity, 'object', 'project')) {
            $project = $entity;
        } else {
            register_error(elgg_echo('project:error:not_found'));
            forward(REFERER);
        }
    } else {
        $project = new ElggObject();
        $project->subtype = "project";
        $project->owner_guid = elgg_get_logged_in_user_guid();
    }

    $project->title = $title;
    $project->access_id = ACCESS_PUBLIC;
    $project->company_guid = $company_guid;
    $name = preg_replace("/[^a-zA-Z0-9]/", "", strtolower($title));
    $project->project_name = $name;
    $project->customer = $customer;
    $project->start_date = $start_date;
    $project->final_date = $final_date;
    $project->is_deleted = 0;
    $project_guid = $project->save();
    if ($project_guid) {
        system_message(elgg_echo("project:message:saved"));
        forward(REFERER);
    } else {
        register_error(elgg_echo("project:message:not_saved"));
        forward(REFERER);
    }

