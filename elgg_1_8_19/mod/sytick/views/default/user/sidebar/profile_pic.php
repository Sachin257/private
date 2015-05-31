<?php
$name = htmlspecialchars($vars['entity']->name, ENT_QUOTES, 'UTF-8', false);
$username = $vars['entity']->username;

$size = elgg_extract('size', $vars, DEFAULT_PROFILE_PIC_LARGE);
$icon_url = elgg_format_url($vars['entity']->getIconURL($size));
$icon = elgg_view('output/img', array(
		'src' => DEFAULT_PROFILE_PIC_SPACER_GIF,
		'alt' => $name,
		'title' => $name,
		'class' => '',
		'style' => "background: url($icon_url) no-repeat 45% 10%; background-size: 105%;",
));

$class = "rounded_corners prf_box_shadow profile_pic_box elgg-avatar-$size";
if (isset($vars['class'])) {
	$class = "$class {$vars['class']}";
}
$url = elgg_extract('href', $vars, get_user_profile_url($vars['entity']) );
?>
<div class="<?php echo $class; ?>" align="center">
    <?php 
    echo elgg_view('output/url', array(
                    'href' => $url,
                    'text' => $icon,
                    'is_trusted' => true,
                    'class' => $class,
    ));
    ?>
    <div class="profile_pic_btn">
        <ul>
            <li class="MR_one">
                    <?php 
                    echo elgg_view('output/url', array(
                        'href' => '#',
                        'text' => elgg_echo('profile:upload:picture'),
                        'is_trusted' => true,
                        'class' => 'upld_pic',
                    ));
					//echo elgg_view_form("user/upload", array('id'=>"frm_profile_pic_upload", "enctype"=>"multipart/form-data"), $vars);
                    ?>			
                </li>
                <li>
                    <?php 
                    echo elgg_view('output/url', array(
                        'href' => '#',
                        'text' => elgg_echo('profile:take:picture'),
                        'is_trusted' => true,
                        'class' => 'take_pic',
                        'guid' => $vars["entity"]->guid,
                    ));
					//echo elgg_view_form("user/crop", array('id'=>"frm_profile_pic_crop", "enctype"=>"multipart/form-data"), $vars);
                    ?>
                </li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<div class="clear"></div>

<div class="modal fade" id="myProfilePicModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none;">
	<div class="modal-dialog">
		 <div class="modal-header">
	        <h1 class="modal-title" id="myModalLabel"><?php echo elgg_echo('profile:pic:upload');?> <?php //echo $vars["entity"]->name;?></h1>
	      </div>
	      <div class="modal-body">
	      	<div id="profile_pic_upld">
	      		<div id="avatar-croppingtool" class="mtl ptm">
					<p>
						<?php echo elgg_echo("avatar:create:instructions"); ?>
					</p>
					<?php echo elgg_view_form('user/crop', array("id"=>"frm_profile_crop"), $vars); ?>
				</div>
	      		<?php 
	      		$user_avatar = elgg_view('output/img', array(
	      				'src' => $vars['entity']->getIconUrl('large'),
	      				'alt' => elgg_echo('avatar'),
	      		));
				$current_label = elgg_echo('avatar:current');
				$form_params = array( 'id'=>'frm_upload_pic', 'enctype' => 'multipart/form-data');
				$upload_form = elgg_view_form('user/upload', $form_params, $vars);
				$image = '<div id="current-user-avatar" class="mrl prl">'.
					'<label>'.$current_label.'</label><br />'.
					$user_avatar
				.'</div>';
				
								
				$body = '<div id="avatar-upload">'.
					$upload_form
				.'</div>';
				
				echo elgg_view_image_block($image, $upload_form);				
	      		?>
	      	</div>
	      </div>
	</div>
</div>
