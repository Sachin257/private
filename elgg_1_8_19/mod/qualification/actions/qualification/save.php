<?php
// get the form inputs
$qualification_guid = get_input('guid');
$qualification_type_guid = get_input('title');
$body = get_input('description');
$number = get_input('number');
$granted_date = strtotime(get_input('granted_date'));
$expired_date = strtotime(get_input('expired_date'));
$organization = get_input('organization');
$document = get_input('file');

$qualification_type = get_entity($qualification_type_guid);
$category = $qualification_type->category;

if ($qualification_guid){
	$entity = get_entity($qualification_guid);
	if (elgg_instanceof($entity, 'object', 'qualification') && $entity->canEdit()) {
		$qualification = $entity;
	} else {
		register_error(elgg_echo('qualification:error:post_not_found'));
		forward(get_input('forward', REFERER));
	}
} else {
	// create a new qualification object
	$qualification = new ElggObject();
}

if (elgg_get_entities_from_relationship(array(
	  'types' => 'object',
	  'subtypes' => 'qualification',
	  'limit' => false,
	  'relationship' => 'qualification_of_qualification_type',
	  'relationship_guid' => $qualification_type_guid,
	  'inverse_relationship' => true,			  
	  'metadata_name_value_pairs' => array(
	  		'name' => "number",
		    'value' => $number,
		    'operand' => '='
		),		     
))) {
		register_error(elgg_echo('qualification:error:number_exists'));
		forward(get_input('forward', REFERER));
}

$qualification->subtype = "qualification";
$qualification->title = 'qualification';
$qualification->description = $body;

// for now make all qualification public
$qualification->access_id = ACCESS_PRIVATE;

// owner is logged in user
$qualification->owner_guid = elgg_get_logged_in_user_guid();

// save other fields as metadata
if($number != '')
	$qualification->number = $number;
if($granted_date != 0)
	$qualification->granted_date = $granted_date;
if($expired_date != 0)
	$qualification->expired_date = $expired_date;
$qualification->organization = $organization;
$qualification->document = $document;

if (!empty($_FILES['file']['name']))
{
    //$error = elgg_echo('file:nofile');
    //register_error($error);

	//Make a file
	$file = new FilePluginFile();
	$file->subtype = "file";

	// if no title, grab filename
	if (empty($titolo))
	 $titolo = htmlspecialchars($_FILES['file']['name'], ENT_QUOTES, 'UTF-8');

	$file->title = $titolo;
	$file->description = "description file";
	$file->access_id = ACCESS_PRIVATE;
	$file->owner_guid = elgg_get_logged_in_user_guid();

	// we have a file upload, so process it
	if (isset($_FILES['file']['name']) && !empty($_FILES['file']['name']))
	{
		//Generate filename
		$prefix = "file/";
		$filestorename = elgg_strtolower(time().$_FILES['file']['name']);
		$file->setFilename($prefix . $filestorename);
		//Set Mimetype
		$mime_type = ElggFile::detectMimeType($_FILES['file']['tmp_name'], $_FILES['file']['type']);
		$file->setMimeType($mime_type);
		//Set attributes
		$file->originalfilename = $_FILES['file']['name'];
		$file->simpletype = file_get_simple_type($mime_type);
		// Open the file to guarantee the directory exists
		$file->open("write");
		$file->close();
		//Move file
		move_uploaded_file($_FILES['file']['tmp_name'], $file->getFilenameOnFilestore());
		//Save file
		$guid = $file->save();

		//Make thumbnails
		if ($guid && $file->simpletype == "image")
		{	
		    $file->icontime = time();
		    $thumbnail = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 60, 60, true);
		    if ($thumbnail)
		    {
		        $thumb = new ElggFile();
		        $thumb->setMimeType($_FILES['file']['type']);

		        $thumb->setFilename($prefix."thumb".$filestorename);
		        $thumb->open("write");
		        $thumb->write($thumbnail);
		        $thumb->close();

		        $file->thumbnail = $prefix."thumb".$filestorename;
		        unset($thumbnail);
		    }

		    $thumbsmall = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 153, 153, true);
		    if ($thumbsmall)
		    {
		        $thumb->setFilename($prefix."smallthumb".$filestorename);
		        $thumb->open("write");
		        $thumb->write($thumbsmall);
		        $thumb->close();
		        $file->smallthumb = $prefix."smallthumb".$filestorename;
		        unset($thumbsmall);
		    }

		    $thumblarge = get_resized_image_from_existing_file($file->getFilenameOnFilestore(), 600, 600, false);
		    if ($thumblarge)
		    {
		        $thumb->setFilename($prefix."largethumb".$filestorename);
		        $thumb->open("write");
		        $thumb->write($thumblarge);
		        $thumb->close();
		        $file->largethumb = $prefix."largethumb".$filestorename;
		        unset($thumblarge);
		    }
		}
	}
}

// save to database and get id of the new qualification
$qualification_guid = $qualification->save();

if ($qualification_guid && $qualification_type_guid) {
	add_entity_relationship($qualification_guid, "qualification_of_qualification_type", $qualification_type_guid);			
}

if ($guid && $qualification_guid) {
	add_entity_relationship($file->guid, "image_of_qualification", $qualification_guid);				
}

// if the qualification was saved, we want to display the new qualification
// otherwise, we want to register an error and forward back to the form
if ($qualification_guid) {		
   	system_message(elgg_echo("qualification:message:saved"));
   	forward('qualification/all');
} else {
   register_error(elgg_echo("qualification:error:cannot_save"));
   forward(REFERER); // REFERER is a global variable that defines the previous page
}