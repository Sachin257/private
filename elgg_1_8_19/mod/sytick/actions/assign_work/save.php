<?php

// get the form inputs
$project_guid = get_input('start_date');
$assign_date = get_input('date');
$shift = get_input('shift');
$nopieces = get_input('nopieces');
$project = get_entity($project_guid);

$assign_work = new ElggObject();

$assign_work->subtype = "assign_work";
$assign_work->title = $project->title ."-". $assign_date;
$assign_work->nopieces = $nopieces;
$assign_work->shift = $shift;
$assign_work->date = $assign_date;
$assign_work->project = $project_guid;

$assign_work->access_id = ACCESS_PUBLIC;
$assign_work->owner_guid = elgg_get_logged_in_user_guid();
$assign_work_guid = $assign_work->save();

if ($assign_work_guid) {
    system_message(elgg_echo("paint:message:saved"));
    forward('assign_work/all');
} else {
    register_error(elgg_echo("paint:error:cannot_save"));
    forward(REFERER); // REFERER is a global variable that defines the previous page
}