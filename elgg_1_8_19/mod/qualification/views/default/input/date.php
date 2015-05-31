<?php
if (isset($vars['class'])) {
	$vars['class'] = "elgg-input-date popup_calendar {$vars['class']}";
} else {
	$vars['class'] = "elgg-input-date popup_calendar";
}

$defaults = array(
	'value' => '',
	'disabled' => false,
	'timestamp' => false,
);

$vars = array_merge($defaults, $vars);

$timestamp = $vars['timestamp'];
unset($vars['timestamp']);

if ($timestamp) {
	echo elgg_view('input/hidden', array(
		'name' => $vars['name'],
		'value' => $vars['value'],
	));

	$vars['class'] = "{$vars['class']} elgg-input-timestamp";
	$vars['id'] = $vars['name'];
	unset($vars['name']);
	unset($vars['internalname']);
}

// convert timestamps to text for display
if (is_numeric($vars['value'])) {
	$vars['value'] = gmdate('d-m-Y', $vars['value']);
}

$attributes = elgg_format_attributes($vars);
echo "<input type=\"text\" $attributes />";
