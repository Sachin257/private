<?php
$qual_type = get_input('qualification_type');
if (empty($comment_text)) {
	echo "error";
}
else {
	$qualification_type = new ElggObject();
	$qualification_type->subtype = "qualification_type";
	$qualification_type->title = $qual_type;
	$qualification_type->description = $qual_type;
	// for now make all qualification public
	$qualification_type->access_id = ACCESS_PUBLIC;	
	// owner is logged in user
	$qualification_type->owner_guid = elgg_get_logged_in_user_guid();	
	// save other fields as metadata
	$qualification_type->category = 'general';	
	// save to database and get id of the new qualification_type
	$qualification_type_guid = $qualification_type->save();
	if ($qualification_type_guid) {
		echo "success";
	} else {
		echo "error";
	}
}
?>