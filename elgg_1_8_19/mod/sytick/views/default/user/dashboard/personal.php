<?php
$name = htmlspecialchars($vars['entity']->name, ENT_QUOTES, 'UTF-8', false);
$ful_name = $name;
$middle_name = htmlspecialchars($vars['entity']->middlename, ENT_QUOTES, 'UTF-8', false);
$ful_name .= ($middle_name!= "") ? " ".$middle_name:"";
$last_name = htmlspecialchars($vars['entity']->lastname, ENT_QUOTES, 'UTF-8', false);
$ful_name .= ($last_name!= "") ? " ".$last_name:"";
$street1 = htmlspecialchars($vars['entity']->street1, ENT_QUOTES, 'UTF-8', false);
$street2 = htmlspecialchars($vars['entity']->street2, ENT_QUOTES, 'UTF-8', false);
$town = htmlspecialchars($vars['entity']->town, ENT_QUOTES, 'UTF-8', false);
$state = htmlspecialchars($vars['entity']->state, ENT_QUOTES, 'UTF-8', false);
$postcode = htmlspecialchars($vars['entity']->postcode, ENT_QUOTES, 'UTF-8', false);

$username = $vars['entity']->username;
$size = elgg_extract('size', $vars, DEFAULT_PROFILE_PIC_MEDIUM);
$icon_url = elgg_format_url($vars['entity']->getIconURL($size));
$icon = elgg_view('output/img', array(
		'src' => DEFAULT_PROFILE_PIC_SPACER_GIF,
		'alt' => $name,
		'title' => $name,
		'class' => '',
                "style" => 'margin: 0;',
		
));

$class = "elgg-avatar elgg-avatar-$size";
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}
$url = elgg_extract('href', $vars, get_user_profile_url($vars['entity']) );
$edit_url ="";
if (elgg_is_admin_logged_in() || ( elgg_get_logged_in_user_guid() == $vars['entity']->guid) ) {
	$edit_url = elgg_view('output/url', array(
						'href' => '/user/'.$vars['entity']->username.'/edit',
						'text' => elgg_echo('dashboard:edit'),
						'is_trusted' => true,
						'class' => 'edit',
                                                'style' => "background: url($icon_url) no-repeat;",
						));
}
?>
<div class="MT_two"></div>
<div class="<?php echo $class; ?> span6 dahsboard rounded_corners prs_details">
    <h2><span></span><?php echo elgg_echo('profile:edit:title')?> <?php echo $edit_url;?></h2>
    <span class="dsh_arrow"></span>
   
        <?php 
        echo elgg_view('output/url', array(
                        'href' => $url,
                        'text' => $icon,
                        'is_trusted' => true,
                        'class' => $class,
                        'style' => "background: url($icon_url) no-repeat center center;",
        ));
        ?>
    <label class="cntname MT_three"><?php echo $ful_name;?></label>
    <label><?php echo $street1;?></label>
    <label><?php echo $street2;?></label>
    <label><?php echo $town;?></label>
    <label><?php echo $state;?>, <?php echo $postcode;?></label>

</div>

<div class="<?php echo $class; ?> span6 dahsboard rounded_corners column_right_f alerts">    
	<?php echo elgg_view("user/dashboard/alerts", $vars);?>
</div>
<div class="clear"></div>
<div class="MT_one"></div>
<div class="<?php echo $class; ?> span6 dahsboard rounded_corners certification">    
    <?php echo elgg_view("user/dashboard/certification", $vars);?>
</div>
<div class="<?php echo $class; ?> span6 dahsboard rounded_corners column_right_f sites">
    <?php echo elgg_view("user/dashboard/projects", $vars);?>
</div>
<div class="clear"></div>
<div class="MT_two"></div>
