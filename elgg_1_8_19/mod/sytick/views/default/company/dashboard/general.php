<?php 
$edit_url ="";
$company = get_company_of_manager(elgg_get_logged_in_user_guid());
$logged_in_users_company = ($company) ? $company->guid :0;
if (elgg_is_admin_logged_in() || ($logged_in_users_company == $vars['entity']->guid ) ) {
	$edit_url = elgg_view('output/url', array(
			'href' => '/company/edit/'.$vars['entity']->name,
			'text' => elgg_echo('dashboard:edit'),
			'is_trusted' => true,
			'class' => 'edit',
	));
}
$file = get_file_by_company_guid($vars['entity']->guid);
if($file && $file[0])
{
	//$vars['file_guid'] = $file[0]->guid;
	$file_icon = elgg_view('output/img', array(
			'src' => $file[0]->getIconUrl('small'),
			'alt' =>  $vars['entity']->title,
			'title' =>  $vars['entity']->title,
			'class' => '',
	));
	//print '<pre>';print_r($file);exit;
} else{
    $company_icon_url = get_image_path("default_company.png");
   $file_icon = elgg_view('output/img', array(
			'src' => $company_icon_url,
			'alt' =>  $vars['entity']->title,
			'title' =>  $vars['entity']->title,
			'class' => '',
	)); 
}

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
    <label class="cntname MT_three"><?php echo $vars['entity']->trading_name;?></label>
    <label><?php echo $vars['entity']->street_address;?></label>
    <label><?php echo $vars['entity']->town;?></label>
    <label><?php echo $vars['entity']->state;?>, <?php echo $vars['entity']->postcode;?>  </label>
    <label><?php echo $vars['entity']->country;?></label>
   