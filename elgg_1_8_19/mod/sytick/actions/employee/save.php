<?php

// get the form inputs
$employee_guid = get_input('guid');
$title = get_input('title');
$address = get_input('street1');
$pass = get_input('pass');
$confpass = get_input('confpass');
$designation = get_input('designation');
$date_of_join = get_input('date_of_join');

if ($passs == $confpass) {
    if ($employee_guid) {
        $entity = get_entity($employee_guid);
        if (elgg_instanceof($entity, 'object', 'employee') && $entity->canEdit()) {
            $employee = $entity;
        } else {
            register_error(elgg_echo('employee:error:cannot_edit'));
            forward(get_input('forward', REFERER));
        }
    } else {
        $employee = new ElggObject();
    }

    $employee->subtype = "employee";
    $employee->title = $title;
    $employee->address = $address;
    $employee->password = $pass;
    $employee->designation = $designation;
    $employee->date_of_join = $date_of_join;
    
    $employee->access_id = ACCESS_PUBLIC;

    $employee->owner_guid = elgg_get_logged_in_user_guid();

    $employee_guid = $employee->save();

    if ($employee_guid) {
        system_message(elgg_echo("employee:message:saved"));
        forward('employee/all');
    } else {
        register_error(elgg_echo("employee:error:cannot_save"));
        forward(REFERER); // REFERER is a global variable that defines the previous page
    }
} else {
    register_error(elgg_echo("password:notmatch:error"));
    forward(REFERER);
}