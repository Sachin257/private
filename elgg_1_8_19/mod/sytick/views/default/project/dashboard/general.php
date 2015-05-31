<?php 
$edit_url ="";
$logged_in_users_company = ($company) ? $company->guid :0;
$url = "#";
if (elgg_is_admin_logged_in() || ($logged_in_users_company == $vars['company']->guid ) ) {
	$url = '/project/edit/'.$vars['entity']->project_name;
	$edit_url = elgg_view('output/url', array(
			'href' => $url,
			'text' => elgg_echo('dashboard:edit'),
			'is_trusted' => true,
			'class' => 'edit',
	));
}
   $project_icon_url = get_image_path("default_sitelogo.png");
   $file_icon = elgg_view('output/img', array(
			'src' => $project_icon_url,
			'alt' =>  $vars['entity']->title,
			'title' =>  $vars['entity']->title,
			'class' => '',
	)); 
?>
<h2><span></span><?php echo $vars['entity']->title;?> <?php echo $edit_url;?></h2>
    <span class="dsh_arrow"></span>
    <?php 
        echo elgg_view('output/url', array(
                        'href' => $url,
                        'text' => $file_icon,
                        'is_trusted' => true,
                        'class' => 'elgg-avatar elgg-avatar-small',
        ));
        ?>
    <label class="cntname MT_three"><?php echo $vars['company']->trading_name;?></label>
    <label><?php echo $vars['manager']->name;?></label>
    <label><?php echo $vars['entity']->project_postal_address;?></label>
    <label><?php echo $vars['entity']->project_town;?></label>
    <label><?php echo $vars['entity']->project_state;?>, <?php echo $vars['entity']->project_postcode;?></label>
