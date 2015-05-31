<?php
//print '<pre>';print_r($_POST);print '</pre>';
//print '<pre>';print_r($_FILES);print '</pre>';
// get the form inputs
$user_guid = get_input('user_guid');
$certificate_guid = get_input('guid');
$document_type_guid = get_input('document_type');
$certificate_type = strip_tags(get_sanitised_input('certificate_type'));
$comments = strip_tags(get_sanitised_input('comments'));
$date_of_issue = strtotime(get_input('date_of_issue'));

$existing_certs = get_certificate_by_type(0, $page_user->guid);
$check_if_same = 0;
if(check_entity_relationship($certificate_guid,"certificate_of_document_type",$document_type_guid))
{
	$check_if_same = 1;
}

$flag_cert = 0;
foreach ($existing_certs as $cert)
{
	if(check_entity_relationship($cert['guid'],"certificate_of_document_type",$document_type_guid))
	{
		$flag_cert = 1;
	}

}
//$as[0] = $document_type_guid;
if($flag_cert == 1 && $check_if_same == 0)
{
	$result['output']['error_field'] = "document_type";
	$result['system_messages']['error'] = array(elgg_echo('certificate:error:already_exist'));
	$result['system_messages']['success'] = array();
	$result['status'] = -1;
	echo json_encode($result);
	exit;
}

if($date_of_issue > time())
{	
	$result['output']['error_field'] = "date_of_issue";
	$result['system_messages']['error'] = array(elgg_echo('certificate:error:date_of_issue'));
	$result['system_messages']['success'] = array();
	$result['status'] = -1;
	echo json_encode($result);
	exit;
	//register_error(elgg_echo('certificate:error:date_of_issue'));
	//forward(get_input('forward', REFERER));
}
$date_of_expiry = strtotime(get_input('date_of_expiry'));
if($date_of_expiry < time())
{
	$result['output']['error_field'] = "date_of_expiry";
	$result['system_messages']['error'] = array(elgg_echo('certificate:error:exipired'));
	$result['system_messages']['success'] = array();
	$result['status'] = -1;
	echo json_encode($result);
	exit;
	//register_error(elgg_echo('certificate:error:exipired'));
	//forward(get_input('forward', REFERER));
}
if($date_of_issue > $date_of_expiry)
{
	$result['output']['error_field'] = "date_of_expiry";
	$result['system_messages']['error'] = array(elgg_echo('certificate:error:date_of_expiry'));
	$result['system_messages']['success'] = array();
	$result['status'] = -1;
	echo json_encode($result);
	exit;
	//register_error(elgg_echo('certificate:error:date_of_expiry'));
	//forward(get_input('forward', REFERER));
}
$certificate_id = strip_tags(get_sanitised_input('certificate_id'));
if(! validate_certificate_id($certificate_id, $certificate_guid)){	
	$result['output']['error_field'] = "certificate_id";
	$result['system_messages']['error'] = array(elgg_echo('certificate:error:certificate_id'));
	$result['system_messages']['success'] = array();
	$result['status'] = -1;
	echo json_encode($result);
	exit;
	//register_error(elgg_echo('certificate:error:certificate_id'));
	//forward(get_input('forward', REFERER));
}
//$document = get_input('certificate_upload');
$file_guid = get_input('file_guid');
$file_upload_field = "certificate_upload";
if (!empty($_FILES[$file_upload_field]['name']))
{
	if($_FILES[$file_upload_field]['size'] > SYTICK_MAX_IMG_SIZE ){
		$result['output']['error_field'] = $file_upload_field;
		$result['system_messages']['error'] = array( elgg_echo('certificate:error:image_size' , array(SYTICK_MAX_IMG_SIZE/ (1000*1000)  )) );
		$result['system_messages']['success'] = array();
		$result['status'] = -1;
		echo json_encode($result);
		exit;
		//register_error(elgg_echo('certificate:error:image_size' , array(SYTICK_MAX_IMG_SIZE/ (1000*1000)  )));
		//forward(get_input('forward', REFERER));
	}
}
//die($_FILES['certificate_upload']['type']);
$document_type = get_entity($document_type_guid);
$title = $document_type->title;
$body = $comments;
$old_document_type = 0;
if ($certificate_guid){
	$entity = get_entity($certificate_guid);
	if (elgg_instanceof($entity, 'object', 'certificate') && $entity->canEdit()) {
		$certificate = $entity;
		$old_document_type = $certificate->document_type;
	} else {
		register_error(elgg_echo('certificate:error:not_found'));
		forward(get_input('forward', REFERER));
	}
} else {
	// create a new certificate object
	$certificate = new ElggObject();
}

$certificate->subtype = "certificate";
$certificate->title = $title;
$certificate->description = $body;

// for now make all qualification public
$certificate->access_id = ACCESS_PRIVATE;

// owner is logged in user
$certificate->owner_guid = $user_guid;//elgg_get_logged_in_user_guid();

// save other fields as metadata
$certificate->certificate_type = $certificate_type;
$certificate->document_type = $document_type_guid;
$certificate->certificate_id = $certificate_id;
$certificate->date_of_issue = $date_of_issue;
$certificate->date_of_expiry = $date_of_expiry;
$certificate->is_deleted = 0;
$certificate->status = 1;

$file_guid = get_input('file_guid');
$certificate->document = $document;
// save to database and get id of the new certificate
$certificate_guid = $certificate->save();

if ($certificate->guid && $document_type_guid) {
	add_entity_relationship($certificate->guid, "certificate_of_document_type", $document_type_guid);
	if($certificate->document_type != $old_document_type)
	{
		// delete old document_type and relationship
		remove_entity_relationship($certificate->guid, "certificate_of_document_type", $old_document_type);
	}
}
//
$prefix = "certificate/";
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
		$filestorename = elgg_strtolower(time().$_FILES[$file_upload_field]['name']);
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
			$file->icontime = time();
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
	if ($file->guid && $certificate->guid) {
		add_entity_relationship($file->guid, "file_of_certificate", $certificate->guid);
		if($file_guid && $file->guid != $file_guid)
		{
			$old_file = get_entity($file_guid);
			//echo $old_file->thumbnail;
			$thumb_file = new ElggFile();
			$thumb_file->owner_guid = $old_file->owner_guid;
			$thumb_file->setFilename($old_file->thumbnail);
			$old_thumb_filepath = $thumb_file->getFilenameOnFilestore();
			if (!$thumb_file->delete()) {
				elgg_log("logo thumb file remove failed. Remove $old_thumb_filepath manually, please.", 'WARNING');
			}
			if($old_file) {
				$old_filestorename =  $old_file->originalfilename;
				$old_filepath = $old_file->getFilenameOnFilestore();
				if (!$old_file->delete()) {
					elgg_log("logo file remove failed. Remove $old_filepath manually, please.", 'WARNING');
				}
			}
			remove_entity_relationship($file_guid, "file_of_certificate", $certificate->guid);
		};
	}
}

// if the qualification was saved, we want to display the new qualification
// otherwise, we want to register an error and forward back to the form
if ($certificate->guid) {
	system_message(elgg_echo("certificate:message:saved"));
	forward(REFERER);
} else {
	register_error(elgg_echo("certificate:error:cannot_save"));
	forward(REFERER); // REFERER is a global variable that defines the previous page
}