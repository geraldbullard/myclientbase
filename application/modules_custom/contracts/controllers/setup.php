<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Setup extends Admin_Controller {

	function __construct() {

		parent::__construct(TRUE);

	}

	function index() {

	}

	function install() {

		$queries = array(
			"CREATE TABLE IF NOT EXISTS `mcb_contracts` (
			  `contract_id` int(11) NOT NULL AUTO_INCREMENT,
			  `user_id` int(11) NOT NULL,
			  `client_id` int(11) NOT NULL,
			  `interval_id` int(11) NOT NULL,
			  `status` varchar(20) NOT NULL,
			  `last_invoice_date` varchar(25) NOT NULL,
			  `next_invoice_date` varchar(25) NOT NULL,
			  `contract_name` varchar(255) NOT NULL,
			  `contract_date_start` varchar(25) NOT NULL,
			  `contract_date_end` varchar(25) NOT NULL,
			  `contract_descr` text NOT NULL,
			  PRIMARY KEY (`contract_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

			"CREATE TABLE IF NOT EXISTS `mcb_contracts_invoices` (
			  `contract_id` int(11) NOT NULL,
			  `invoice_id` int(11) NOT NULL,
			  UNIQUE KEY `contract_id` (`contract_id`,`invoice_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

			"CREATE TABLE IF NOT EXISTS `mcb_contract_intervals` (
			  `interval_id` int(11) NOT NULL AUTO_INCREMENT,
			  `interval_name` varchar(20) NOT NULL,
			  `interval_string` varchar(20) NOT NULL,
			  PRIMARY KEY (`interval_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7;",
			
			"INSERT INTO `mcb_contract_intervals` (`interval_id`, `interval_name`, `interval_string`) VALUES
			(1, 'weekly', '1 week'),
			(2, 'monthly', '1 month'),
			(3, 'two-monthly', '2 months'),
			(4, 'quarterly', '4 months'),
			(5, 'biannually', '6 months'),
			(6, 'yearly', '1 year');",
			
			"CREATE TABLE IF NOT EXISTS `mcb_contract_items` (
			  `contract_item_id` int(11) NOT NULL AUTO_INCREMENT,
			  `contract_id` int(11) NOT NULL,
			  `item_name` longtext,
			  `item_description` longtext,
			  `item_qty` decimal(10,2) NOT NULL DEFAULT '0.00',
			  `item_price` decimal(10,2) NOT NULL DEFAULT '0.00',
			  `tax_rate_id` int(11) NOT NULL,
			  `is_taxable` int(1) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`contract_item_id`),
			  KEY `contract_id` (`contract_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;"
		);

		foreach ($queries as $query) {

			$this->db->query($query);

		}

	}

	function uninstall() {

		$queries = array(
			"DROP TABLE IF EXISTS `mcb_contracts`",
			"DROP TABLE IF EXISTS `mcb_contract_items`",
			"DROP TABLE IF EXISTS `mcb_contract_intervals`",
			"DROP TABLE IF EXISTS `mcb_contracts_invoices`"
		);

		foreach ($queries as $query) {

			$this->db->query($query);

		}

	}

	function upgrade() {

		$this->db->where('module_path', 'contracts');
		$this->db->set('module_version', '0.9.3');
		$this->db->update('mcb_modules');

	}

}

?>