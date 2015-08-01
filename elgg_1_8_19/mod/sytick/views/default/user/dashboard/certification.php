	<?php 	
	$view_url ="";
	if (elgg_is_admin_logged_in() || ( elgg_get_logged_in_user_guid() == $vars['entity']->guid) ) {
		$edit_url = elgg_view('output/url', array(
				'href' => '/user/'.$vars['entity']->username.'/certification',
				'text' => elgg_echo('dashboard:view:all'),
				'is_trusted' => true,
				'class' => 'edit',
		));
	}
	?>
	<h2><span></span><?php echo elgg_echo('profile:certification:title')?> <?php echo $edit_url;?></h2>
    <span class="dsh_arrow"></span>
   <ul class="list_wrap">
        <?php
		foreach($vars['certificates'] as $certificate)
		{
			?>
			<li><?php echo $certificate['title'];?> - <?php echo $certificate['certificate_id'];?></li>
			<?php
		}
		?>
    </ul>
