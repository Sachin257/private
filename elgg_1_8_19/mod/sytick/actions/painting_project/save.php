<?php

// get the form inputs
$paint_guid = get_input('guid');
$title = get_input('title');
$material_id = get_input('material_id');
$order_from_id = get_input('order_from');
$nopieces = get_input('nopieces');
$lengthperpiece = get_input('lengthperpiece');
$unit = get_input("unit");
switch ($unit){
    case 1:
        $lengthperpiece /= 12;
        break;
    case 2:
        $lengthperpiece = $lengthperpiece * 3.280;
        break;
    case 3:
        $lengthperpiece = $lengthperpiece * 3.280 / 100;
        break;
    case 4:
        $lengthperpiece = $lengthperpiece * 3.280 / 1000;
        break;
    default:
        break;
}
$flag = "";
if($paint_guid !== "")
{
    $flag = "OK";
}

if ($paint_guid) {
    $entity = get_entity($paint_guid);
    if (elgg_instanceof($entity, 'object', 'painting_project') && $entity->canEdit()) {
        $paint = $entity;
    } else {
        register_error(elgg_echo('paint:error:cannot_edit'));
        forward(get_input('forward', REFERER));
    }
} else {
    $paint = new ElggObject();
}

$paint->subtype = "painting_project";
$paint->title = $title;
$paint->nopieces = $nopieces;
$paint->nopiecesleft = $nopieces;
$paint->lengthperpiece = $lengthperpiece;
$paint->material_id = $material_id;
$paint->order_from = $order_from_id;

$paint->is_deleted = 0;
$paint->access_id = ACCESS_PUBLIC;
$paint->owner_guid = elgg_get_logged_in_user_guid();
$paint_guid = $paint->save();

if ($paint_guid) {
    system_message(elgg_echo("paint:message:saved"));
    if ($flag == "" ){
    forward('painting_project/all');
    }  else {
        forward("painting_project/add?name=$title"."&from=$order_from_id");
    }
} else {
    register_error(elgg_echo("paint:error:cannot_save"));
    forward(REFERER); // REFERER is a global variable that defines the previous page
}
