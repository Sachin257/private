<?php
// need to restrict for company managers and admin
gatekeeper();
$title = get_sanitised_input('site_name');
$description = get_sanitised_input('site_description');

$company_guid = get_sanitised_input('company_id');

$guid = get_sanitised_input('guid');

$file_guid = get_input('file_guid');

$project_guid = get_input('project_id');

$new_sitemanager_guids = get_input('sitemanager_id');
$new_documenttype_guids = get_input('documenttype_id');

//print '<pre>';print_r($_POST);exit;

if(!check_unique_site_name($title, $guid))
{
	$result['output']['error_field'] = "site_name";
	$result['system_messages']['error'] = array( elgg_echo('site:name:not_unique') );
	$result['system_messages']['success'] = array();
	$result['status'] = -1;
	echo json_encode($result);
	exit;
}

if(!count($new_sitemanager_guids))
{
	$result['output']['error_field'] = "sitemanager_id";
	$result['system_messages']['error'] = array( elgg_echo('site:manager:error') );
	$result['system_messages']['success'] = array();
	$result['status'] = -1;
	echo json_encode($result);
	exit;
}

if(!count($new_documenttype_guids))
{
	$result['output']['error_field'] = "documenttype_id";
	$result['system_messages']['error'] = array( elgg_echo('site:documenttype:error') );
	$result['system_messages']['success'] = array();
	$result['status'] = -1;
	echo json_encode($result);
	exit;
}

$file_upload_field = "site_layout";
if (!empty($_FILES[$file_upload_field]['name']))
{
	if($_FILES[$file_upload_field]['size'] > SYTICK_MAX_IMG_SIZE ){
		$result['output']['error_field'] = $file_upload_field;
		$result['system_messages']['error'] =array( elgg_echo('certificate:error:image_size') );;
		$result['system_messages']['success'] = array();
		$result['status'] = -1;
		echo json_encode($result);
		exit;
	}
}
$current_sitemanager_guids = array();
$current_documenttype_guids = array();
$old_company_guid = 0;
$old_project_guid = 0;
if($guid)
{
	$entity = get_entity($guid);
	if (elgg_instanceof($entity, 'object', 'sites')) {
		$sites = $entity;
		$current_sitemanager_guids = get_sites_current_sitesmanagers($guid);
		$current_documenttype_guids = get_sites_current_documenttype($guid);
		$old_company_guid = $project->company_guid;
		$old_project_guid = $project->project_guid;
	} else {
		register_error(elgg_echo('site:error:not_found'));
		forward(REFERER);
	}
} else {
	$sites = new ElggObject();
	$sites->subtype = "sites";
	// owner is logged in user
	$sites->owner_guid = elgg_get_logged_in_user_guid();
}

$sites->title = $title;
$sites->description = $description;
$sites->access_id = ACCESS_PUBLIC;

$sites->project_guid = $project_guid;
$sites->company_guid = $company_guid;
$name =  preg_replace("/[^a-zA-Z0-9]/", "", strtolower($title));
$sites->site_name = $name;

$sites->is_deleted = 0;
//print '<pre>';print_r($project);die();
$sites_guid = $sites->save();

	
if ($sites->guid && $company_guid) {
	add_entity_relationship($sites->guid, "site_of_company", $company_guid);
	if($sites->company_guid != $old_company_guid)
	{
		// delete old company and relationship
		remove_entity_relationship($sites->guid, "site_of_company", $old_company_guid);
	}
}
if ($sites->guid && count($new_sitemanager_guids)) {
	foreach($new_sitemanager_guids as $_new_sitemanager_guid)
	{
		if(! in_array($_new_sitemanager_guid, $current_sitemanager_guids)   )
			add_entity_relationship($sites->guid, "sitemanager_of_site", $_new_sitemanager_guid);
	}
	$diff_sitemanager_arr = array_diff($current_sitemanager_guids, $new_sitemanager_guids);
	//print '<pre>';print_r($diff_sitemanager_arr);die();
	foreach($diff_sitemanager_arr as $_diff_sitemanager_guid)
	{
		if(! in_array($_diff_sitemanager_guid, $new_sitemanager_guids)   )
			remove_entity_relationship($sites->guid, "sitemanager_of_site", $_diff_sitemanager_guid);
	}
}

if ($sites->guid && count($new_documenttype_guids)) {
	foreach($new_documenttype_guids as $_new_documenttype_guid)
	{
		if(! in_array($_new_documenttype_guid, $current_documenttype_guids)   )
			add_entity_relationship($sites->guid, "required_document_of_site", $_new_documenttype_guid);
	}
	$diff_documenttype_arr = array_diff($current_documenttype_guids, $new_documenttype_guids);
	//print '<pre>';print_r($diff_sitemanager_arr);die();
	foreach($diff_documenttype_arr as $_diff_documenttype_guid)
	{
		if(! in_array($_diff_documenttype_guid, $new_documenttype_guids)   )
			remove_entity_relationship($sites->guid, "required_document_of_site", $_diff_documenttype_guid);
	}
}	

$prefix = "sites/";
if (!empty($_FILES[$file_upload_field]['name']))
{
	//$error = elgg_echo('file:nofile');
	//register_error($error);

	//Make a file
	$file = new FilePluginFile();
	$file->subtype = "file";

	$file_title = htmlspecialchars($_FILES[$file_upload_field]['name'], ENT_QUOTES, 'UTF-8');

	$file->title = $file_title;
	$file->description = $title;
	$file->access_id = ACCESS_PUBLIC;
	$file->owner_guid = elgg_get_logged_in_user_guid();

	// we have a file upload, so process it
	if (isset($_FILES[$file_upload_field]['name']) && !empty($_FILES[$file_upload_field]['name']))
	{
		$document = $_FILES[$file_upload_field]['name'];
		//Generate filename
                $img_time = time();
		$filestorename = elgg_strtolower($img_time.$_FILES[$file_upload_field]['name']);
		$file->setFilename($prefix . $filestorename);
		//Set Mimetype
		$mime_type = ElggFile::detectMimeType($_FILES[$file_upload_field]['tmp_name'], $_FILES[$file_upload_field]['type']);
		$file->setMimeType($mime_type);
		//Set attributes
		$file->originalfilename = $_FILES[$file_upload_field]['name'];
		$file->simpletype = file_get_simple_type($mime_type);
		// Open the file to guarantee the directory exists
		$file->open("write");
		$file->close();
		//Move file
		move_uploaded_file($_FILES[$file_upload_field]['tmp_name'], $file->getFilenameOnFilestore());
		//Save file
		$f_guid = $file->save();

		//Make thumbnails
		if ($f_guid && $file->simpletype == "image")
		{
			$file->icontime = $img_time;
			$thumbnail = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), DEFAULT_THUMB_PIC_WIDTH, DEFAULT_THUMB_PIC_HEIGHT, true);
			if ($thumbnail)
			{
				$thumb = new ElggFile();
				$thumb->setMimeType($_FILES[$file_upload_field]['type']);

				$thumb->setFilename($prefix."thumb".$filestorename);
				$thumb->open("write");
				$thumb->write($thumbnail);
				$thumb->close();

				$file->thumbnail = $prefix."thumb".$filestorename;
				unset($thumbnail);
			}
		}
	}
	if ($file->guid && $sites->guid) {
		add_entity_relationship($file->guid, "file_of_sites", $sites->guid);
		if($file->guid != $file_guid)
		{
			$old_file = get_entity($file_guid);
			$thumb_file = new ElggFile();
			$thumb_file->owner_guid = $old_file->owner_guid;
			$thumb_file->setFilename($old_file->thumbnail);
			$old_thumb_filepath = $thumb_file->getFilenameOnFilestore();
			if (!$thumb_file->delete()) {
				elgg_log("site thumb file remove failed. Remove $old_thumb_filepath manually, please.", 'WARNING');
			}
			if($old_file) {
				$old_filestorename =  $old_file->originalfilename;
				$old_filepath = $old_file->getFilenameOnFilestore();
				if (!$old_file->delete()) {
					elgg_log("site file remove failed. Remove $old_filepath manually, please.", 'WARNING');
				}
			}
			remove_entity_relationship($file_guid, "file_of_sites", $sites->guid);
		}
	}
}
if ($sites_guid) {
	system_message(elgg_echo("sites:message:saved"));
	forward(REFERER);
} else {
	register_error(elgg_echo("sites:message:not_saved"));
	forward(REFERER); // REFERER is a global variable that defines the previous page
}




