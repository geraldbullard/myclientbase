<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

$config = array(
	'module_path'			=>	'contracts',
	'module_name'			=>	'Contracts',
	'module_description'	=>	'Enables you to manage contracts and create recurring invoices',
	'module_author'			=>	'Bastian Heist',
	'module_homepage'		=>	'http://www.beheist.com',
	'module_version'		=>	'0.9.3',
	'module_config'			=>	array(
		'dashboard_widget'	=>	'contracts/dashboard_widget',
		'settings_view'		=>	'contracts/contracts_settings/display',
		'settings_save'		=>	'contracts/contracts_settings/save',
		'dashboard_menu'	=>	'contracts/header_menu'
	)
);

?>