<?php
/**
 * Sites
 */

elgg_register_event_handler('init', 'system', 'site_init');
elgg_register_page_handler('site', 'site_page_handler');
elgg_register_page_handler('site_qualification', 'site_qualification_page_handler');
elgg_register_page_handler('user_qualification', 'user_qualification_page_handler');
elgg_register_page_handler('site_user', 'site_user_page_handler');

elgg_register_action("site/save", elgg_get_plugins_path() . "site/actions/site/save.php");
elgg_register_action("site/delete", elgg_get_plugins_path() . "site/actions/site/delete.php");
elgg_register_action("site_qualification/save", elgg_get_plugins_path() . "site/actions/site_qualification/save.php");
elgg_register_action("site_qualification/delete", elgg_get_plugins_path() . "site/actions/site_qualification/delete.php");
elgg_register_action("user_qualification/validate", elgg_get_plugins_path() . "site/actions/user_qualification/validate.php");
elgg_register_action("site_user/save", elgg_get_plugins_path() . "site/actions/site_user/save.php");
elgg_register_action("site_user/assign_user_to_site", elgg_get_plugins_path() . "site/actions/site_user/assign_user_to_site.php");
elgg_register_action("site_user/unassign_user_from_site", elgg_get_plugins_path() . "site/actions/site_user/unassign_user_from_site.php");

elgg_register_library('elgg:site', elgg_get_plugins_path() . 'site/lib/site.php');
elgg_register_library('elgg:lesson', elgg_get_plugins_path() . 'lesson/lib/lesson.php');
elgg_register_library('elgg:qualification', elgg_get_plugins_path() . 'qualification/lib/qualification.php');
elgg_register_library('elgg:organizations', elgg_get_plugins_path() . 'organizations/lib/organizations.php');

/**
 * Initialize the site plugin.
 *
 */
function site_init() {

	//$item = new ElggMenuItem('site', elgg_echo('site:sites'), 'site/all');
	//elgg_register_menu_item('site', $item);	
	
	//elgg_register_js('jquery.fancybox', 'vendors/jquery/fancybox/jquery.fancybox-1.3.4.pack.js', 'head');
   	//elgg_register_css('jquery.fancybox', 'vendors/jquery/fancybox/jquery.fancybox-1.3.4.css', 'head');
   	
	elgg_extend_view('css/elgg','site/css'); // adds the content of site/views/default/css.php to the core elgg css
	elgg_register_js('googlemaps', 'https://maps.googleapis.com/maps/api/js?sensor=false', 'head');
	
	
	// Add generic new site widget
	elgg_register_widget_type('site', elgg_echo("site:widget"), elgg_echo("site:widget:description"));
}

function site_page_handler($segments) {
	elgg_load_library("elgg:site");
	elgg_load_library("elgg:lesson");
	elgg_load_library("elgg:qualification");
	elgg_load_library("elgg:organizations");

    switch ($segments[0]) {
        case 'add':
           include elgg_get_plugins_path() . 'site/pages/site/add.php';
           break;

        case 'all':
        default:
           include elgg_get_plugins_path() . 'site/pages/site/all.php';
           break;

      case 'edit':      
      default:
         include elgg_get_plugins_path() . 'site/pages/site/edit.php';
         break;

      case 'view':      
      default:
         include elgg_get_plugins_path() . 'site/pages/site/view.php';
         break;          
    }

    return true;
}

function site_qualification_page_handler($segments) {
    switch ($segments[0]) {
        case 'add':
           include elgg_get_plugins_path() . 'site/pages/site_qualification/add.php';
           break;
    }
    return true;
}

function user_qualification_page_handler($segments) {
    switch ($segments[0]) {
        case 'all':
           include elgg_get_plugins_path() . 'site/pages/user_qualification/all.php';
    }
    return true;
}

function site_user_page_handler($segments) {
	elgg_load_library('elgg:site');
    switch ($segments[0]) {
        case 'add':
           include elgg_get_plugins_path() . 'site/pages/site_user/add.php';
           break;
    }
    switch ($segments[0]) {
        case 'all':
           include elgg_get_plugins_path() . 'site/pages/site_user/all.php';
           break;
    }    
    return true;
}