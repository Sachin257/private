<?php

// get the form inputs
$tentative_work_guid = get_input('guid');
$tentative_date = get_input('date');
$shift = get_input('shift');
$color = get_input('color');
$description = get_input('description');
if ($tentative_work_guid){
    $entity = get_entity($tentative_work_guid);
    if (elgg_instanceof($entity, 'object', 'tentative_work') && $entity->canEdit()) {
        $tentative_work = $entity;
        $flag = TRUE;
    } else {
        register_error(elgg_echo('paint:error:cannot_edit'));
        forward(get_input('forward', REFERER));
    }
} else {
    // create a new qualification_type object
    $tentative_work = new ElggObject();
}

$tentative_work->subtype = "tentative_work";
$tentative_work->title = $color . "-" . $tentative_date;
$tentative_work->color = $color;
$tentative_work->shift = $shift;
$tentative_work->date = $tentative_date;
$tentative_work->description = $description;

$tentative_work->access_id = ACCESS_PUBLIC;
$tentative_work->owner_guid = elgg_get_logged_in_user_guid();
$tentative_work_guid = $tentative_work->save();

if ($tentative_work_guid) {
    system_message(elgg_echo("entity:message:saved"));
    forward('tentative_work/all');
} else {
    register_error(elgg_echo("entity:error:cannot_save"));
    forward(REFERER); // REFERER is a global variable that defines the previous page
}