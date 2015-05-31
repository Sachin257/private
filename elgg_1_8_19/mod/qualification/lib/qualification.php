<?php
/**
 * get_lesson_of_qualification_type
 * @method
 * @param {object} $qualification_type Parent qualification type of lesson.
 * @return {array} Child lesson of qualification_type, or false if none.
 */
function get_lesson_of_qualification_type($qualification_type) {
	$options = array(
		"relationship" => "lesson_of_qualification_type",
		"inverse_relationship" => true,
		"relationship_guid" => $qualification_type->guid,
		"limit" => ELGG_ENTITIES_NO_VALUE
	);

	// Each qualification type should only have one lesson.
	$lesson_array = elgg_get_entities_from_relationship($options);

	if (count($lesson_array) != 0) {
		return $lesson_array[0];
	} else {
		return false;	
	}
}
?>