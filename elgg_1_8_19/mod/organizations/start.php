<?php
	elgg_register_event_handler('init', 'system', 'organizations_init');

	elgg_register_action("organizations/save", elgg_get_plugins_path() . "organizations/actions/organizations/save.php");
	elgg_register_action("organizations/delete", elgg_get_plugins_path() . "organizations/actions/organizations/delete.php");

	elgg_register_page_handler('organizations', 'organizations_page_handler');

	// register a library of helper functions
	elgg_register_library('elgg:organizations', elgg_get_plugins_path() . 'organizations/lib/organizations.php');

	function organizations_init() {
		elgg_load_library('elgg:organizations');
		// Add generic new organizations widget
		elgg_register_widget_type('organizations', elgg_echo("organizations:widget"), elgg_echo("organizations:widget:description"));		
	}

	function organizations_page_handler($segments) {
		elgg_load_library('elgg:organizations');
		
		switch ($segments[0]) {
			case 'add':
			   include elgg_get_plugins_path() . 'organizations/pages/organizations/add.php';
			   break;
	 
			case 'edit':
			   include elgg_get_plugins_path() . 'organizations/pages/organizations/edit.php';
			   break;
	 
			case 'all':
			   include elgg_get_plugins_path() . 'organizations/pages/organizations/all.php';
			   break;
	 
			case 'view':
			   include elgg_get_plugins_path() . 'organizations/pages/organizations/view.php';
			   break;
		}
	 
		return true;
	}
?>