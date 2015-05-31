<?php
// convert timestamps to text for display
if (is_numeric($vars['value'])) {
	$vars['value'] = gmdate('d-m-Y', $vars['value']);
}

echo $vars['value'];
