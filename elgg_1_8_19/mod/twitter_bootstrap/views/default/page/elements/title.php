<?php
/**
 * Elgg title element
 *
 * @uses $vars['title'] The page title
 * @uses $vars['class'] Optional class for heading
 */

$class= '';
if (isset($vars['class'])) {
	$class = " class=\"{$vars['class']}\"";
}

echo '<div class="page-header nest_wrap">';
echo "<div class='span12'><h2{$class}>{$vars['title']}</h2></div>";
echo '</div>';