<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mdl_Contract_items extends MY_Model {

	function __construct() {

		/* MY_Model does a lot of legwork for us. */

		parent::__construct();

		/* Define the database table name. */

		$this->table_name = 'mcb_contract_items';

		/* Define the primary key of the table. */

		$this->primary_key = 'mcb_contract_items.contract_item_id';

		/* Define SQL_CALC_FOUND_ROWS * as a minimum for pagination. */

		$this->select_fields = "
		SQL_CALC_FOUND_ROWS mcb_contract_items.*,
		mcb_contracts.contract_id as contract_id";

		/* Define the default sort order. */

		$this->order_by = 'mcb_contract_items.contract_item_id ASC';

		/* Define the joins. */

		$this->joins = array(
			'mcb_contracts'	=>	'mcb_contracts.contract_id = mcb_contract_items.contract_id'
		);

	}

	function validate() {

		$this->form_validation->set_rules('item_name', $this->lang->line('item'), 'required');
		$this->form_validation->set_rules('item_description', $this->lang->line('item_description'), 'required');
		$this->form_validation->set_rules('item_qty', $this->lang->line('quantity'), 'required');
		$this->form_validation->set_rules('item_price', $this->lang->line('unit_price'), 'required');
		//Commented out since item API does not work properly yet and we can'z pass tax rates to invoice items
		//$this->form_validation->set_rules('tax_rate_id', $this->lang->line('tax_rate'), 'required');

		return parent::validate();

	}

	function save() {

		/* Prepare the default $db_array */

		$db_array = parent::db_array();
		
		/* Add the contract id */

		if (uri_assoc('contract_id', 4)) {

			$db_array['contract_id'] = uri_assoc('contract_id', 4);

		}
		
		/* Tax flag */
		if ($this->input->post('is_taxable')) {
			$db_array['is_taxable'] = 1;
		} else {
			$db_array['is_taxable'] = 0;
		}
		

		parent::save($db_array, uri_assoc('contract_item_id', 6));

	}

	function prep_validation($key) {

		/* First prepare the default validation */

		parent::prep_validation($key);

	}

	function delete($params) {

		/* Run the standard delete function. */

		parent::delete($params);

		/*
		 * And delete records from other contract tables
		*/

	}
}

?>