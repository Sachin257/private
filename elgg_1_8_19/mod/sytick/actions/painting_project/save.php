<?php

// get the form inputs
$paint_guid = get_input('guid');
$title = get_input('title');
$material_id = get_input('material_id');
$nopieces = get_input('nopieces');
$lengthperpiece = get_input('lengthperpiece');
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
$paint->lengthperpiece = $lengthperpiece;
$paint->material_id = $material_id;

$paint->is_deleted = 0;
$paint->access_id = ACCESS_PUBLIC;
$paint->owner_guid = elgg_get_logged_in_user_guid();
$paint_guid = $paint->save();
//if ($paint_guid) {
//    $old_material = get_material_id_by_proj_guid($paint_guid);
//    $old_material_id = $old_material->guid;
//    if ($old_material_id != $material_id || $old_material_id=="") {
//        remove_entity_relationship($old_material_id, "material_of_project", $paint_guid);
//        add_entity_relationship($material_id, "material_of_project", $paint_guid);
//    }
//} else {
//    if ($material_id) {
//        add_entity_relationship($material_id, "material_of_project", $paint_guid);
//    }
//}
if ($paint_guid) {
    system_message(elgg_echo("paint:message:saved"));
    if ($flag == "" ){
    forward('painting_project/all');
    }  else {
        forward("painting_project/add?name=$title");
    }
} else {
    register_error(elgg_echo("paint:error:cannot_save"));
    forward(REFERER); // REFERER is a global variable that defines the previous page
}