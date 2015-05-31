<?php
/**
 * Topbar navigation menu - bootstrap specific
 *
 * @uses $vars['menu']['default']
 * @uses $vars['menu']['alt']
echo"<pre>";
var_dump(elgg_extract('more', $vars['menu']));
echo"</pre>"; 
*/


$default_items = isset($vars['menu']) ?  elgg_extract('default', $vars['menu'], array()) : array();
$alt_items = isset($vars['menu']) ?  elgg_extract('alt', $vars['menu'], array()) : array();
$user = elgg_get_logged_in_user_entity();
$username = $user->name;
if(!$username){
	$username = elgg_echo('login');
}
$site = elgg_get_site_entity();
$site_name = $site->name;
$site_url = $site->url;
$logo_path =  elgg_get_site_url() .'mod/twitter_bootstrap/vendors/bootstrap/';
if($user){
$name = htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8', false);
$size = elgg_extract('size', $vars, DEFAULT_PROFILE_PIC_TOPBAR);
$profile_icon_url = elgg_format_url($user->getIconURL($size));
$profile_icon = elgg_view('output/img', array(
		'src' => $profile_icon_url,
		'alt' => $name,
		'title' => $name,
		'class' => '',
		'style' => "border-radius:50%;",
));}
/*
if(elgg_is_logged_in()){
//required for responsive
echo <<<HTML
		<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
         </a>
HTML;

}


//output site title
echo '<a href="'.$site_url.'" class="brand">'.$site_name.'</a>';

//personal dropdown menu
echo <<<HTML
		<div class="btn-group pull-right"><!--open button group -->
		<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">$username <span class="caret"></span></a>	
HTML;

//dropdown contents
echo '<ul class="dropdown-menu">';

if(elgg_is_logged_in()){
	foreach ($alt_items as $menu_item) {
		echo elgg_view('navigation/menu/elements/item', array('item' => $menu_item));
	}

	if ($more_items) {
		echo elgg_view('navigation/menu/elements/section', array(
			'class' => 'elgg-menu elgg-menu-site elgg-menu-site-more dropdown-menu', 
			'items' => $more_items,
		));
		echo '<li class="divider"></li>';
	}
}else{
	echo '<li class="dropdown" style="padding:10px">';
	echo elgg_view_form('login');
	echo '</li>';
}
echo '</ul>';
echo '</div><!-- /button group -->';

//create the logo and tools menu
echo '<div class="nav-collapse nav-collapse-margin-issue">';
echo '<ul class="nav">';
foreach ($default_items as $menu_item) {
	echo elgg_view('navigation/menu/elements/item', array('item' => $menu_item));
}
echo '</ul>';
echo '</div>';*/

?>

<div class="<?php if(! elgg_is_logged_in()){ ?> nest_wrap <?php } ?> header_cnt_mdl nest_wrap">
	<div id="side_coloumn_logo" class="column_left"><img src="<?php echo $logo_path?>img/stad_logo.png" /></div>
	<?php if(! elgg_is_logged_in()){ ?>
	<div id="side_column_login" class="column_right" align="right">
		<?php// echo elgg_view_form('login');?>
            <a href="" class="mob_login"></a>
	</div>
	<?php  } else { ?>
	<?php 
	$size = elgg_extract('size', $vars, DEFAULT_PROFILE_PIC_TINY);
	$lo_user = elgg_get_logged_in_user_entity();
	$icon_url = elgg_format_url($lo_user->getIconURL($size));
	$icon = elgg_view('output/img', array(
					'src' => DEFAULT_PROFILE_PIC_SPACER_GIF,
					'alt' => $name,
					'title' => $name,
					'class' => 'top_profile_img',
					'style' => "background: url($icon_url) no-repeat;",
			));
	?>
        
        <div class="btn-group pull-right" style="display:none;">
		<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
			<?php echo $icon;echo $username; ?>	<span class="caret"></span>
		</a>
            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"> </a>
            <ul class="dropdown-menu">
            <?php 
            foreach ($alt_items as $menu_item) {
                    echo elgg_view('navigation/menu/elements/item', array('item' => $menu_item));
            }
            ?>
            </ul>
        </div>
        <div class="span8 column_right top_userpannel">
            <ul>
                <li><a href="/action/logout" class="logout">LOGOUT</a></li>
                <li><a href="/user/<?php echo $user->username?>/change_password" class="settings">SETTINGS</a></li>
                <li><a href="" class="alrt"><sup class="circle">2</sup>ALERTS</a></li>
                <li><a href="/user/<?php echo $user->username?>" <?php if(!$profile_icon){?>class="acount" <?php }?> ><span><?php if($profile_icon){
    echo $profile_icon;
}
?></span> ACCOUNT</a></li>
                <li><input type="text" name="" value="<?php echo $_GET['search_content'];?>" id="general_search">
                    <div id="search_results" style="display:none;">
                    </div>
                </li>
            </ul>
        </div>

        <div class="top_userpannel_mob">
             <div><input type="text" name="" value="<?php echo $_GET['search_content'];?>" id="general_search">
                    <div id="search_results" style="display:none;">
                    </div>
                </div>
            <ul>
                <li><a href="/user/<?php echo $user->username?>" class="acount">ACCOUNT</a></li>
                <li><a href="" class="alrt"><sup class="circle">2</sup>ALERTS</a></li>
                 <li><a href="/user/<?php echo $user->username?>/change_password" class="settings">SETTINGS</a></li>
                <li><a href="/action/logout" class="logout">LOGOUT</a></li>
            </ul>
        </div>

	<?php } ?> 
        

</div>


	
	


          		
          	          	
        

        
