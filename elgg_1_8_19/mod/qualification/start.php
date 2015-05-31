<?php
/**
 * Qualifications
 */

elgg_register_event_handler('init', 'system', 'qualification_init');
elgg_register_page_handler('qualification', 'qualification_page_handler');
elgg_register_page_handler('qualification_type', 'qualification_type_page_handler');

elgg_register_action("qualification/save", elgg_get_plugins_path() . "qualification/actions/qualification/save.php");
elgg_register_action('qualification/delete', elgg_get_plugins_path() . "qualification/actions/qualification/delete.php");

elgg_register_action("qualification_type/save", elgg_get_plugins_path() . "qualification/actions/qualification_type/save.php");
elgg_register_action('qualification_type/delete', elgg_get_plugins_path() . "qualification/actions/qualification_type/delete.php");

elgg_register_library('elgg:organizations', elgg_get_plugins_path() . 'organizations/lib/organizations.php');

if(elgg_is_admin_logged_in()) {
	elgg_extend_view('css/elgg', 'qualification/css');
	elgg_extend_view('js/elgg', 'qualification/js');
	elgg_register_action('qualification_type/add', elgg_get_plugins_path()."qualification/actions/qualification_type/add.php");
}

/**
 * Initialize the qualification plugin.
 *
 */
function qualification_init() {

	$item = new ElggMenuItem('qualification', elgg_echo('qualification:qualifications'), 'qualification/all');
	elgg_register_menu_item('site', $item);	

	// Add generic new qualification widget
	elgg_register_widget_type('qualification', elgg_echo("qualification:widget"), elgg_echo("qualification:widget:description"));
}

function qualification_page_handler($segments) {
    switch ($segments[0]) {
        case 'add':
           include elgg_get_plugins_path() . 'qualification/pages/qualification/add.php';
           break;

        case 'all':
        default:
           elgg_load_library("elgg:organizations");
           include elgg_get_plugins_path() . 'qualification/pages/qualification/all.php';
           break;

      case 'edit':      
      default:
         include elgg_get_plugins_path() . 'qualification/pages/qualification/edit.php';
         break;

      case 'view':      
      default:
         include elgg_get_plugins_path() . 'qualification/pages/qualification/view.php';
         break;          
    }

    return true;
}

function qualification_type_page_handler($segments) {
    switch ($segments[0]) {
        case 'add':
           include elgg_get_plugins_path() . 'qualification/pages/qualification_type/add.php';
           break;
        case 'all':
        default:
           include elgg_get_plugins_path() . 'qualification/pages/qualification_type/all.php';
           break;
      case 'edit':      
      default:
         include elgg_get_plugins_path() . 'qualification/pages/qualification_type/edit.php';
         break;

      case 'view':      
      default:
         include elgg_get_plugins_path() . 'qualification/pages/qualification_type/view.php';
         break;          
    }

    return true;
}

