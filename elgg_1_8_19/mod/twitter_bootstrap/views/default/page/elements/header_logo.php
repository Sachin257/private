<?php
/**
 * Elgg header logo
 */

$site = elgg_get_site_entity();
$site_name = $site->name;
$site_description = $site->description;
$site_url = elgg_get_site_url();
$logo = '<img src="//29l.superatic.com/L29-logo0B.png" alt="LEVEL29 logo" />';
?>

<h1>
	<a class="" href="<?php echo $site_url; ?>">
		<?php echo $logo; ?>
	</a>
</h1>
