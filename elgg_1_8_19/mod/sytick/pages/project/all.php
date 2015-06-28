<?php
    gatekeeper();
    $title = elgg_echo('project:title:list');
    $limit = get_input('limit', STAD_PAGINATION_LIMIT);
    $offset = get_input('offset', 0);
    $s = get_sanitised_input('s');

    if ($segments[1]) {
        $offset = $segments[1];
    }
    $add_link .= "&nbsp;" . elgg_view('output/url', array(
                'href' => "/project/add/",
                'text' => elgg_echo('project:title:add'),
                'class' => 'elgg-button elgg-button-add float-alt'
            ));
    $body_title = elgg_view_title($title, array('class' => "companytitle"));
    $body = '<div class="title-button-container">' . $add_link . '</div>';
    $projects = get_projects();
    if (count($projects)) {
        foreach ($projects as $_project) {
            $project_ids[] = $_project->guid;
        }
    }    
    if (count($project_ids)) {
        if ($s != "") {
            $project_ids = get_project_search($s, join($project_ids, ","));
        }
        if (count($project_ids)) {
            $count = get_projects(array(
                "guid" => $project_ids,
                'limit' => $limit,
                'offset' => $offset,
                'count' => TRUE,
            ));
            $projects = get_projects(array(
                "guid" => $project_ids,
                'limit' => $limit,
                'offset' => $offset,
            ));
            $pagination = elgg_view('navigation/pagination', array(
                'base_url' => '/project/all',
                'offset' => $offset,
                'count' => $count,
                'limit' => $limit,
            ));
        } else {
            $projects = false;
            $pagination = "";
        }
    } else {
        $projects = false;
        $pagination = "";
    }

    $body .= elgg_view('project/list', array("projects" => $projects, "offset" => $offset));
    $body .= $pagination;


    $body = elgg_view_layout('one_column', array('title' => $body_title, 'content' => $body));

    echo elgg_view_page($title, $body);
