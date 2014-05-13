<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Setup extends Admin_Controller {

	function __construct() {

		parent::__construct(TRUE);

	}

	function index() {}

	function install() {

		$queries = array(
		"CREATE TABLE IF NOT EXISTS `mcb_expenses` (
			`expense_id` int(11) NOT NULL auto_increment,
			`expense_date` varchar(25) NOT NULL,
			`amount` decimal(10,2) NOT NULL,
			`expense_for` longtext NOT NULL,
			PRIMARY KEY  (`expense_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;"		
		);

		foreach ($queries as $query) {

			$this->db->query($query);

		}

	}

	function uninstall() {

		$queries = array(
			"DROP TABLE IF EXISTS `mcb_expenses`"
			
		);

		foreach ($queries as $query) {

			$this->db->query($query);

		}

	}

	function upgrade() {

		$accounts_module = $this->mdl_mcb_modules->custom_modules['accounts'];

		if ($accounts_module->module_version < '0.2.6') {

			$this->upgrade_to_026();

		}

	}

	function upgrade_to_026() {
		
		$db_array = array(
			'complete_date'	=>	''
		);

		$this->db->where('complete_date', 0);

		$this->db->update('mcb_expenses', $db_array);

		$db_array = array(
			'due_date'	=>	''
		);

		$this->db->where('due_date', 0);

		$this->db->update('mcb_expenses', $db_array);

		$db_array = array(
			'module_version'	=>	'0.1.3'
		);

		$this->db->where('module_path', 'accounts');
		$this->db->update('mcb_modules', $db_array);

	}

}

?>