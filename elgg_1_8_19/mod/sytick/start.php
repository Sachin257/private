<?php

global $doc_types;
$doc_types[0] = "application/pdf";
$doc_types[1] = "application/msword";

/**
 *
 * global variable array for inventory types
 */
global $inventory_types;
$inventory_types[0] = "Select";
$inventory_types[1] = "aluminium";
$inventory_types[2] = "glass";

/**
 *
 * global variable array for inventory types
 */
global $order_from_types;
$order_from_types[""] = "Select";
$order_from_types[0] = "Bright Ernakulam";
$order_from_types[1] = "Bright Bypass";
$order_from_types[2] = "Bright Kayamkulam";
$order_from_types[3] = "Eternia";
$order_from_types[4] = "Direct";

/**
 *
 * Default Profile Pic Types constants definitions
 */
define('DEFAULT_PROFILE_PIC_TOPBAR', 'topbar');
define('DEFAULT_PROFILE_PIC_TINY', 'tiny');
define('DEFAULT_PROFILE_PIC_SMALL', 'small');
define('DEFAULT_PROFILE_PIC_MEDIUM', 'medium');
define('DEFAULT_PROFILE_PIC_LARGE', 'large');
define('DEFAULT_PROFILE_PIC_MASTER', 'master');
define('DEFAULT_PROFILE_PIC_SPACER_GIF', elgg_get_site_url() . '_graphics/spacer.gif');
define('DEFAULT_THUMB_PIC_WIDTH', 125);
define('DEFAULT_THUMB_PIC_HEIGHT', 125);


/**
 *
 * Certificates Types constants definitions
 */
define('CERTIFICATE_TYPE_TRADE', 1);
define('CERTIFICATE_TYPE_LICENSE', 2);
define('CERTIFICATE_TYPE_INSURANCE', 3);

/**
 *
 * Company Types constants definitions
 */
define('CONSTRUCTION_TYPE_COMPANY', 1);
define('CONTRACTING_TYPE_COMPANY', 2);

define('STAD_MAX_IMG_SIZE', 4500000);

define('STAD_PAGINATION_LIMIT', 10);

define('AUTO_SAVE_MILLI_SECONDS', 60000);

elgg_register_event_handler('init', 'system', 'stad_init');

function stad_init() {

    elgg_register_library('elgg:uservalidationbyemail', elgg_get_plugins_path() . 'uservalidationbyemail/lib/functions.php');
    elgg_load_library('elgg:uservalidationbyemail');
    elgg_register_library('elgg:sytick', elgg_get_plugins_path() . 'sytick/lib/stad.php');
    elgg_load_library('elgg:sytick');

    elgg_register_page_handler('sytick', 'stad_page_handler');
    elgg_register_page_handler('user', 'stad_user_page_handler');

    elgg_register_page_handler('search', 'stad_search_page_handler');

    elgg_register_page_handler('material_type', 'stad_material_type_page_handler');

    elgg_register_page_handler('company', 'stad_company_page_handler');
    elgg_register_page_handler('manager', 'stad_manager_page_handler');
    elgg_register_page_handler('project', 'stad_project_page_handler');
    elgg_register_page_handler('activity', 'stad_activity_page_handler');

    elgg_register_page_handler('paint', 'stad_paint_page_handler');
    elgg_register_page_handler('inventory', 'stad_inventory_page_handler');
    elgg_register_page_handler('items', 'stad_items_page_handler');
    elgg_register_page_handler('painting_project', 'stad_painting_project_page_handler');
    elgg_register_page_handler('employee', 'stad_employee_page_handler');
    elgg_register_page_handler('inductionmanager', 'stad_inductionmanager_page_handler');
    elgg_register_page_handler('security_person', 'stad_security_person_page_handler');
    elgg_register_page_handler('sitemanager', 'stad_sitemanager_page_handler');
    elgg_register_page_handler('project_manager', 'stad_project_manager_page_handler');
    elgg_register_page_handler('paint_used', 'stad_paint_used_page_handler');
    elgg_register_page_handler('material_alerts', 'stad_material_alerts_page_handler');

    elgg_register_action("user/save", elgg_get_plugins_path() . "sytick/actions/user/save.php");
    elgg_register_action("user/emergency", elgg_get_plugins_path() . "sytick/actions/user/emergency.php");
    elgg_register_action("material_type/save", elgg_get_plugins_path() . "sytick/actions/material_type/save.php");
    elgg_register_action('material_type/delete', elgg_get_plugins_path() . "sytick/actions/material_type/delete.php");
    elgg_register_action("user/certification", elgg_get_plugins_path() . "sytick/actions/user/certification.php");
    elgg_register_action("user/certification/delete", elgg_get_plugins_path() . "sytick/actions/user/certification_delete.php");
    elgg_register_action("company/save", elgg_get_plugins_path() . "sytick/actions/company/save.php");
    elgg_register_action("company/delete", elgg_get_plugins_path() . "sytick/actions/company/delete.php");
    elgg_register_action("user/crop", elgg_get_plugins_path() . "sytick/actions/user/crop.php");
    elgg_register_action("user/upload", elgg_get_plugins_path() . "sytick/actions/user/upload.php");
    elgg_register_action("user/webcam_upload", elgg_get_plugins_path() . "sytick/actions/user/webcam_upload.php");
    elgg_register_action("user/change_password", elgg_get_plugins_path() . "sytick/actions/user/change_password.php");
    elgg_register_action("manager/save", elgg_get_plugins_path() . "sytick/actions/manager/save.php");
    elgg_register_action("project/save", elgg_get_plugins_path() . "sytick/actions/project/save.php");
    elgg_register_action("project/delete", elgg_get_plugins_path() . "sytick/actions/project/delete.php");
    elgg_register_action("paint/delete", elgg_get_plugins_path() . "sytick/actions/paint/delete.php");
    elgg_register_action("paint/save", elgg_get_plugins_path() . "sytick/actions/paint/save.php");
    elgg_register_action("paint_used/save", elgg_get_plugins_path() . "sytick/actions/paint_used/save.php");
    elgg_register_action("inventory/delete", elgg_get_plugins_path() . "sytick/actions/inventory/delete.php");
    elgg_register_action("inventory/save", elgg_get_plugins_path() . "sytick/actions/inventory/save.php");
    elgg_register_action("painting_project/delete", elgg_get_plugins_path() . "sytick/actions/painting_project/delete.php");
    elgg_register_action("painting_project/save", elgg_get_plugins_path() . "sytick/actions/painting_project/save.php");

    elgg_register_action("employee/save", elgg_get_plugins_path() . "sytick/actions/employee/save.php");

    elgg_extend_view('js/elgg', 'sytick/js');
    $avatar_cropper = 'mod/twitter_bootstrap/vendors/bootstrap/js/ui.avatar_cropper.js';
    elgg_register_js('elgg.avatar_cropper', $avatar_cropper, 'head', 10);

    elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'stad_public_pages');
}

function stad_page_handler($segments) {
    if (elgg_is_logged_in()) {
        $lo_user = elgg_get_logged_in_user_entity();
        switch ($segments[0]) {
            case 'activateemployee':
                register_error(elgg_echo('RegistrationException:UserAlreadyLogedin', array($lo_user->name)));
                break;
            case 'activatemanager':
                register_error(elgg_echo('RegistrationException:UserAlreadyLogedin', array($lo_user->name)));
                break;
        }
        forward("/user/" . $lo_user->username);
    }
    switch ($segments[0]) {
        case 'activateemployee':
            include elgg_get_plugins_path() . 'sytick/pages/sytick/activate_employee.php';
            break;
        case 'activatemanager':
            include elgg_get_plugins_path() . 'sytick/pages/sytick/activate_manager.php';
            break;
        case 'resetpassword':
            include elgg_get_plugins_path() . 'sytick/pages/sytick/resetpassword.php';
            break;
        case 'forgotpassword':
            include elgg_get_plugins_path() . 'sytick/pages/sytick/forgotpassword.php';
            break;
        case 'welcome':
        default:
            include elgg_get_plugins_path() . 'sytick/pages/sytick/welcome.php';
            break;
    }

    return true;
}

function stad_material_alerts_page_handler($segments){
    include elgg_get_plugins_path() . 'sytick/pages/material_alerts/all.php';
}

function stad_user_page_handler($segments) {
    //print '<pre>';print_r($segments);exit;
    $page_user = null;
    if ($segments[0]) {
        $page_user_name = sanitise_string($segments[0]);
        $page_user = get_user_by_username($page_user_name);
        //die($page_user->username);
    }
    switch ($segments[1]) {
        case 'workhistory':
            include elgg_get_plugins_path() . 'sytick/pages/user/work_history.php';
            break;
        case 'induction':
            $user_profile_type = get_custom_profile_types($page_user->custom_profile_type, 'guid');
            $user_profile_type_label = ($user_profile_type && isset($user_profile_type['label'])) ? $user_profile_type['label'] : "";
            elgg_register_js('twitter_bootstrap.fancybox', 'mod/twitter_bootstrap/vendors/fancybox/jquery.fancybox.js', 'head');
            elgg_register_css('twitter_bootstrap.fancybox', 'mod/twitter_bootstrap/vendors/fancybox/jquery.fancybox.css', 'head');
            elgg_register_js('lessonviewer.bootbox', 'mod/lesson/lessonviewer/js-global/bootbox.js', 'head');
            if ($user_profile_type_label == CONTRACTOR_PROFILE_TYPE) {
                include elgg_get_plugins_path() . 'sytick/pages/user/induction.php';
            } else {
                include elgg_get_plugins_path() . 'sytick/pages/employee/induction.php';
            }
            break;
        case 'certification':
            include elgg_get_plugins_path() . 'sytick/pages/user/certification.php';
            break;
        case 'emergency':
            include elgg_get_plugins_path() . 'sytick/pages/user/emergency.php';
            break;
        case 'medical':
            include elgg_get_plugins_path() . 'sytick/pages/user/medical.php';
            break;
        case 'edit':
            include elgg_get_plugins_path() . 'sytick/pages/user/edit.php';
            break;
        case 'change_password':
            include elgg_get_plugins_path() . 'sytick/pages/user/change_password.php';
            break;
        default:
            if (elgg_is_admin_logged_in() && $page_user->username == "admin") {
                include elgg_get_plugins_path() . 'sytick/pages/admin/dashboard.php';
            } else {
                $user_profile_type = get_custom_profile_types($page_user->custom_profile_type, 'guid');
                $user_profile_type_label = ($user_profile_type && isset($user_profile_type['label'])) ? $user_profile_type['label'] : "";
                include elgg_get_plugins_path() . 'sytick/pages/employee/dashboard.php';
            }
            break;
    }
}

function stad_search_page_handler($segments) {
    include elgg_get_plugins_path() . 'sytick/pages/search/results.php';
}

function stad_paint_page_handler($segments) {
//    print '<pre>';print_r(elgg_get_plugins_path());exit;
    switch ($segments[0]) {
        case 'add':
            include elgg_get_plugins_path() . 'sytick/pages/paint/add.php';
            break;
        case 'all':
        default :
            include elgg_get_plugins_path() . 'sytick/pages/paint/all.php';
            break;
        case 'edit':
            include elgg_get_plugins_path() . 'sytick/pages/paint/edit.php';
            break;
    }
}

function stad_paint_used_page_handler($segments){
    switch ($segments[0]) {
        case 'add':
            include elgg_get_plugins_path() . 'sytick/pages/paint_used/add.php';
            break;
        case 'edit':
            include elgg_get_plugins_path() . 'sytick/pages/paint_used/edit.php';
            break;
        case 'all':
        default :
            include elgg_get_plugins_path() . 'sytick/pages/paint_used/all.php';
            break;
    }    
}

function stad_items_page_handler($segments) {
    switch ($segments[0]) {
        case 'add':
            include elgg_get_plugins_path() . 'sytick/pages/items/add.php';
            break;
    }
}

function stad_inventory_page_handler($segments) {
    switch ($segments[0]) {
        case 'add':
            include elgg_get_plugins_path() . 'sytick/pages/inventory/add.php';
            break;
        case 'all':
        default :
            include elgg_get_plugins_path() . 'sytick/pages/inventory/all.php';
            break;
        case 'edit':
            include elgg_get_plugins_path() . 'sytick/pages/inventory/edit.php';
            break;
    }
}

function stad_painting_project_page_handler($segments) {
    switch ($segments[0]) {
        case 'add':
            include elgg_get_plugins_path() . 'sytick/pages/painting_project/add.php';
            break;
        case 'all':
        default :
            include elgg_get_plugins_path() . 'sytick/pages/painting_project/all.php';
            break;
        case 'employee_all':
            include elgg_get_plugins_path() . 'sytick/pages/painting_project/employee_all.php';
            break;
        case 'edit':
            include elgg_get_plugins_path() . 'sytick/pages/painting_project/edit.php';
            break;
        case 'view':
            include elgg_get_plugins_path() . 'sytick/pages/painting_project/view.php';
            break;
        case 'employee_view':
            include elgg_get_plugins_path() . 'sytick/pages/painting_project/view.php';
            break;
    }
}

function stad_material_type_page_handler($segments) {
    //print '<pre>';print_r($segments);exit;
    switch ($segments[0]) {
        case 'add':
            include elgg_get_plugins_path() . 'sytick/pages/material_type/add.php';
            break;
        case 'all':
        default :
            include elgg_get_plugins_path() . 'sytick/pages/material_type/all.php';
            break;
        case 'edit':
            include elgg_get_plugins_path() . 'sytick/pages/material_type/edit.php';
            break;
    }
}

function stad_activity_page_handler($segments) {
    $page_user = elgg_get_logged_in_user_entity();
    forward("/user/$page_user->username");
}

function stad_company_page_handler($segments) {
    //print '<pre>';print_r($segments);exit;
    switch ($segments[0]) {
        case 'add':
            include elgg_get_plugins_path() . 'sytick/pages/company/add.php';
            break;
        case 'all':
            include elgg_get_plugins_path() . 'sytick/pages/company/all.php';
            break;
        case 'edit':
            include elgg_get_plugins_path() . 'sytick/pages/company/edit.php';
            break;
        case 'view':
            include elgg_get_plugins_path() . 'sytick/pages/company/view.php';
            break;
        default:
            if (isset($segments[0]) && $segments[0] != "") {
                include elgg_get_plugins_path() . 'sytick/pages/company/view.php';
            } else {
                include elgg_get_plugins_path() . 'sytick/pages/company/all.php';
            }
            break;
    }
}

function stad_manager_page_handler($segments) {
    //print '<pre>';print_r($segments);exit;
    switch ($segments[0]) {
        case 'add':
            include elgg_get_plugins_path() . 'sytick/pages/manager/add.php';
            break;
        case 'edit':
            include elgg_get_plugins_path() . 'sytick/pages/manager/edit.php';
            break;
        default:
        case 'all':
            include elgg_get_plugins_path() . 'sytick/pages/manager/all.php';
            break;
    }
}

function stad_project_page_handler($segments) {
    //print '<pre>';print_r($segments);exit;
    switch ($segments[0]) {
        case 'check_in_out':
            elgg_register_js('twitter_bootstrap.bootswitch.js', 'mod/twitter_bootstrap/vendors/bootstrap-switch-master/bootstrap-switch.js', 'footer');
            elgg_register_js('twitter_bootstrap.bootswitch.js1', 'mod/twitter_bootstrap/vendors/bootstrap-switch-master/bootstrap-switch.min.js', 'footer');
            elgg_register_css('twitter_bootstrap.bootswitch.css', 'mod/twitter_bootstrap/vendors/bootstrap-switch-master/bootstrap-switch.min.css', 'head');
            elgg_register_css('twitter_bootstrap.bootswitch.css1', 'mod/twitter_bootstrap/vendors/bootstrap-switch-master/bootstrap-switch.css', 'head');
            include elgg_get_plugins_path() . 'sytick/pages/project/check_in_out.php';
            break;
        case 'add':
            include elgg_get_plugins_path() . 'sytick/pages/project/add.php';
            break;
        case 'edit':
            include elgg_get_plugins_path() . 'sytick/pages/project/edit.php';
            break;
        case 'view':
            include elgg_get_plugins_path() . 'sytick/pages/project/view.php';
            break;
        default:
        case 'all':
            include elgg_get_plugins_path() . 'sytick/pages/project/all.php';
            break;
    }
}

function stad_employee_page_handler($segments) {
    switch ($segments[0]) {
        default:
        case 'add':
            include elgg_get_plugins_path() . 'sytick/pages/employee/add.php';
            break;
        case 'edit':
            include elgg_get_plugins_path() . 'sytick/pages/employee/edit.php';
            break;
        case 'all':
            include elgg_get_plugins_path() . 'sytick/pages/employee/all.php';
            break;
    }
}

function stad_inductionmanager_page_handler($segments) {
    switch ($segments[0]) {
        default:
        case 'all':
            include elgg_get_plugins_path() . 'sytick/pages/inductionmanager/all.php';
            break;
    }
}

function stad_security_person_page_handler($segments) {
    switch ($segments[0]) {
        default:
        case 'all':
            include elgg_get_plugins_path() . 'sytick/pages/security_person/all.php';
            break;
    }
}

function stad_sitemanager_page_handler($segments) {
    switch ($segments[0]) {
        default:
        case 'all':
            include elgg_get_plugins_path() . 'sytick/pages/sitemanager/all.php';
            break;
    }
}

function stad_contractor_page_handler($segments) {
    switch ($segments[0]) {
        default:
        case 'all':
            include elgg_get_plugins_path() . 'sytick/pages/contractor/all.php';
            break;
    }
}

function stad_project_manager_page_handler($segments) {
    switch ($segments[0]) {
        default:
        case 'all':
            include elgg_get_plugins_path() . 'sytick/pages/project_manager/all.php';
            break;
    }
}

function stad_screen_page_handler($segments) {
    //print '<pre>';print_r($segments);exit;
    switch ($segments[1]) {
        case 'add':
            include elgg_get_plugins_path() . 'sytick/pages/screen/edit.php';
            break;
        case 'save':
            include elgg_get_plugins_path() . 'sytick/pages/screen/save.php';
            break;
        case 'update_screen':
            include elgg_get_plugins_path() . 'sytick/pages/screen/update_screen.php';
            break;
        case 'view':
            include elgg_get_plugins_path() . 'sytick/pages/screen/view.php';
            break;
        case 'preview':
            include elgg_get_plugins_path() . 'sytick/pages/screen/preview.php';
            break;
        case 'edit':
            include elgg_get_plugins_path() . 'sytick/pages/screen/edit.php';
            break;
        default:
        case 'all':
            include elgg_get_plugins_path() . 'sytick/pages/screen/all.php';
            break;
    }
}

/**
 *
 * Extend public pages
 * @param unknown_type $hook_name
 * @param unknown_type $entity_type
 * @param unknown_type $return_value
 * @param unknown_type $parameters
 */
function stad_public_pages($hook_name, $entity_type, $return_value, $params) {
    $return = $return_value;
    if (is_array($return)) {
        $return[] = "action/sytick/ajax/home.*";
        $return[] = "sytick/welcome";
        $return[] = "sytick/forgotpassword";
        $return[] = "sytick/resetpassword";
        $return[] = 'sytick/activatemanager';
        $return[] = 'sytick/activateemployee';
        $return[] = 'screen/.*/preview/.*';
        $return[] = 'screen/.*/view/.*';
        //$return[] = 'lesson/media/.*';
    }
    return $return;
}

elgg_register_action("sytick/ajax/home", dirname(__FILE__) . "/actions/ajax/home.php", "public");
