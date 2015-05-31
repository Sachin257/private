<?php
//print '<pre>';print_r($_POST);print '</pre>';die();


$all_jobs = get_input('job_type');

$title = get_sanitised_input('title');
$trading_name = get_sanitised_input('trading_name');
$abn = get_sanitised_input('abn');
$description = $trading_name;
$company_type = get_sanitised_input('company_type');

$street_address = get_sanitised_input('street_address');
$town = get_sanitised_input('town');
$state = get_sanitised_input('state');
$postcode = get_sanitised_input('postcode');
$country= get_sanitised_input('country');

$telephone_area_code = get_sanitised_input('telephone_area_code');
$telephone = get_sanitised_input('telephone');
$fax_area_code = get_sanitised_input('fax_area_code');
$fax = get_sanitised_input('fax');
$mobile_area_code= get_sanitised_input('mobile_area_code');
$mobile = get_sanitised_input('mobile');

$contact = get_sanitised_input('contact');
$contact_email = get_sanitised_input('contact_email');
$contact_postal_address = get_sanitised_input('contact_postal_address');
$contact_town = get_sanitised_input('contact_town');
$contact_state = get_sanitised_input('contact_state');
$contact_postcode = get_sanitised_input('contact_postcode');
$contact_country= get_sanitised_input('contact_country');
$contact_id= get_sanitised_input('contact_id');

$manager_arr['name'] =  $contact;
$manager_arr['email'] =  $contact_email;
$manager_arr['street1'] =  $contact_postal_address;
$manager_arr['town'] =  $contact_town;
$manager_arr['state'] =  $contact_state;
$manager_arr['postcode'] =  $contact_postcode;
$manager_arr['country'] =  $contact_country;

$file_guid = get_input('file_guid');
$file_upload_field = "logo";

$company_guid = get_sanitised_input('guid');
if(!check_unique_company_primary_contact($contact_email, $company_guid))
{
	if ($company_guid){
		$result['output']['error_field'] = "contact_email";
		$result['system_messages']['error'] =array( elgg_echo('company:contact:unique:error') );;
		$result['system_messages']['success'] = array();
		$result['status'] = -1;
		echo json_encode($result);
		exit;
	} else {
		register_error(elgg_echo('company:contact:unique:error'));
		forward(REFERER);
	}
}
if ($company_guid){

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
	
	$entity = get_entity($company_guid);
	$company = $entity;
	if (elgg_instanceof($entity, 'object', 'company')) {
		if (validate_company_abn($abn,$company_guid)) {
			true;
		} else {
			$result['output']['error_field'] = "abn";
			$result['system_messages']['error'] =array( elgg_echo('company:abn:unique:error') );;
			$result['system_messages']['success'] = array();
			$result['status'] = -1;
			echo json_encode($result);
			exit;
			//register_error(elgg_echo('company:abn:unique:error'));
			//forward(get_input('forward', REFERER));
		}		

	} else {
		$result['output']['error_field'] = "entity_name";
		$result['system_messages']['error'] =array( elgg_echo('company:error:company_not_found') );;
		$result['system_messages']['success'] = array();
		$result['status'] = -1;
		echo json_encode($result);
		exit;
		//register_error(elgg_echo('company:error:company_not_found'));
		//forward( REFERER);
	}
        //print '<pre>';print_r($all_jobs);print '</pre>';die();
        $existing_job_types = get_job_type_guids_company($company_guid);
       // print '<pre>';print_r($existing_job_types);print '</pre>';die();
        foreach ($existing_job_types as $serial_num => $guid_job_type)
        {
	remove_entity_relationship($guid_job_type->guid_one, 'job_type_of_company', $company_guid);
        }
        
        
        
        foreach ($all_jobs as $numb => $job_guid)
        {
	if ($job_guid && $company_guid) {
		add_entity_relationship($job_guid, "job_type_of_company", $company_guid);
	}
	 //print '<pre>';print_r($);print '</pre>';die();
        }
        
                                 
} else {
	// create a new lesson object
	$company = new ElggObject();
	$company->subtype = "company";
	$company->owner_guid = elgg_get_logged_in_user_guid();
	$company->status = 0;
	$company->is_deleted = 0;
	$company->access_id = ACCESS_PUBLIC;
}

$company->title = $title;
$company->description = $description;
//$name =  preg_replace("/[^a-zA-Z0-9]/", "", strtolower($title));
$name = get_unique_name($title , $company_guid);
$company->name =$name;
$company->abn = $abn;
$company->trading_name = $trading_name;
$company->company_type = $company_type;

$company->street_address = $street_address;
$company->town = $town;
$company->state = $state;
$company->postcode = $postcode;
$company->country = $country;

$company->telephone_area_code = $telephone_area_code;
$company->telephone = $telephone;
$company->fax_area_code = $fax_area_code;
$company->fax = $fax;
$company->mobile_area_code = $mobile_area_code;
$company->mobile = $mobile;

$company->contact = $contact;
$company->contact_email = $contact_email;
$company->contact_postal_address = $contact_postal_address;
$company->contact_town = $contact_town;
$company->contact_state = $contact_state;
$company->contact_postcode = $contact_postcode;
$company->contact_country = $contact_country;

//print '<pre>';print_r($company);print '</pre>';die();

$c_guid = $company->save();

$prefix = "company/";
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
                $img_time = time();
		//Generate filename
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
	if ($file->guid && $company->guid) {
		add_entity_relationship($file->guid, "file_of_company", $company->guid);
		if($file->guid != $file_guid)
		{
			$old_file = get_entity($file_guid);
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
			remove_entity_relationship($file_guid, "file_of_company", $company->guid);
		}
	}
}

if($company->guid) {
	create_company_manager_as_primary_contact($company, $manager_arr);
	system_message(elgg_echo("company:message:saved"));
	forward("company/all/".$company->company_type);
} else {
	register_error(elgg_echo("company:message:not_saved"));
	forward(REFERER); 
}


