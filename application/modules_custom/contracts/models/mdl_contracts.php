<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mdl_Contracts extends MY_Model {

	function __construct() {

		/* MY_Model does a lot of legwork for us. */

		parent::__construct();

		/* Define the database table name. */

		$this->table_name = 'mcb_contracts';

		/* Define the primary key of the table. */

		$this->primary_key = 'mcb_contracts.contract_id';

		/* Define SQL_CALC_FOUND_ROWS * as a minimum for pagination. */

		$this->select_fields = "
		SQL_CALC_FOUND_ROWS mcb_contracts.*,
		mcb_clients.client_name,
		mcb_users.last_name AS user_last_name,
		mcb_users.first_name AS user_first_name,
		mcb_contract_intervals.interval_name AS interval_name,
		mcb_contract_intervals.interval_string AS interval_string";

		/* Define the default sort order. */

		$this->order_by = 'mcb_contracts.contract_date_start DESC';

		/* Define the joins. */

		$this->joins = array(
			'mcb_users'					=>	'mcb_users.user_id = mcb_contracts.user_id',
			'mcb_clients'				=>	'mcb_clients.client_id = mcb_contracts.client_id',
			'mcb_contract_intervals'	=>	'mcb_contract_intervals.interval_id = mcb_contracts.interval_id'
		);

	}

	function validate() {

		$this->form_validation->set_rules('client_id', $this->lang->line('client'), 'required');
		$this->form_validation->set_rules('interval_id', $this->lang->line('contract_interval_id'), 'required');
		$this->form_validation->set_rules('contract_date_start', $this->lang->line('start_date'), 'required');
		$this->form_validation->set_rules('contract_date_end', $this->lang->line('contract_date_end'), 'required');
		$this->form_validation->set_rules('contract_name', $this->lang->line('contract_name'), 'required');
		$this->form_validation->set_rules('contract_descr', $this->lang->line('contract_descr'));

		return parent::validate();

	}

	function save() {

		/* Prepare the default $db_array */

		$db_array = parent::db_array();

		if (!uri_assoc('contract_id', 3)) {

			$db_array['user_id'] = $this->session->userdata('user_id');

		}

		/* If contract_date_end exists, convert it to a unix timestamp */

		if (isset($db_array['contract_date_end']) and $db_array['contract_date_end']) {

			$db_array['contract_date_end'] = strtotime(standardize_date($db_array['contract_date_end']));

		}

		/* Convert the required contract_start_date to a unix timestamp */

		$db_array['contract_date_start'] = strtotime(standardize_date($db_array['contract_date_start']));

		parent::save($db_array, uri_assoc('contract_id', 3));

	}

	/**
	 * This will create an invoice for a contract with the according invoice items
	 */
	function create_invoice_from_contract($contract_id) {

		$this->load->model(array(
			'invoices/mdl_invoices',
			'contracts/mdl_contract_items'));
			
		$invoice_api = $this->load->module('invoices/invoice_api');

		/* Retrieve the contract record. */
		$contract = $this->get(array('where'=>array('mcb_contracts.contract_id'=>$contract_id)));
		
		if ($contract->status == 'contract_status_due'){
			
			/* Convert the date to external format, cause thats what the API wants.*/
			$ext_date = format_date($contract->next_invoice_date);
			
			/* Create the invoice */
			$invoice_id = $invoice_api->create_invoice(array(
				'client_id' => $contract->client_id,
				'invoice_date_entered' => $ext_date,
				'invoice_group_id' => 1
			));
			
			/* Create the invoice items */
			$items = $this->mdl_contract_items->get(array('where'=>array('mcb_contract_items.contract_id'=>$contract_id)));
			
			foreach ($items as $item){
					
				$invoice_item_id = $invoice_api->add_invoice_item(array(
					'invoice_id' => $invoice_id,
					'item_name' => $item->item_name,
					'item_description' => $item->item_description,
					'item_qty' => $item->item_qty,
					'item_price' => $item->item_price,
					'tax_rate_id' => $item->tax_rate_id,
					'is_taxable' => $item->is_taxable
				));
			}
			
			/* Populate the array to insert as contract-invoice relation. */
			$db_array = array(
				'contract_id'	=>	$contract_id,
				'invoice_id'	=>	$invoice_id
			);
			$this->db->insert('mcb_contracts_invoices', $db_array);
	
			/*
			 * Return the invoice_id so the controller can redirect to the newly
			 * created invoice page.
			*/
			return $invoice_id;
		}
		return false;

	}

	function prep_validation($key) {

		/* First prepare the default validation */

		parent::prep_validation($key);

		if (!$_POST) {

			if ($this->form_value('contract_date_start')) {

				/* Convert to a human readable date if the unix timestamp exists. */

				$this->set_form_value('contract_date_start',  format_date($this->form_value('contract_date_start')));

			}

			if ($this->form_value('contract_date_end')) {

				/* Convert to a human readable date if the unix timestamp exists. */

				$this->set_form_value('contract_date_end', format_date($this->form_value('contract_date_end')));

			}

		}

	}

	function delete($params) {

		/* Run the standard delete function. */

		parent::delete($params);

		/*
		 * And delete records from other contract tables
		*/

		$this->db->where('contract_id', $params['contract_id']);

		$this->db->delete('mcb_contracts_invoices');

		$this->db->where('contract_id', $params['contract_id']);

		$this->db->delete('mcb_contract_items');

	}
	
	/**
	 * We need an extended get() to set the contract status and invoice dates dynamically
	 */
	function get($params){
		$contracts = parent::get($params);
		if (is_array($contracts)){
			//Contract list display, so loop over contracts, calculate status and next invoice date
			foreach ($contracts as $contract){
				$contract->last_invoice_date = $this->_last_invoice_date($contract);
				$contract->next_invoice_date = $this->_next_invoice_date($contract);
				$contract->status = $this->_status($contract);
			}
		} else {
			//Single contract, one call only
			$contracts->last_invoice_date = $this->_last_invoice_date($contracts);
			$contracts->next_invoice_date = $this->_next_invoice_date($contracts);
			$contracts->status = $this->_status($contracts);
		}
		
		return $contracts;
	}
	
	
	/**
	 * Calculates Contract Status based on interval and existing invoices
	 * and returns appropriate status
	 */
	function _status($contract){
		//Save the current time: today's date with 00:00:00
		$time = strtotime(date('Y-m-d', time()));
		
		//First of all check if contract end is in the past - if so, status is expired anyway
		if ($contract->contract_date_end <= $time) return 'contract_status_expired';
		
		//if the next invoice date is in the future, we know that the status is ok
		if ($contract->contract_date_start > $time) return 'contract_status_wait';
		
		//if we're between invoices, status is running
		if ($contract->last_invoice_date <= $time && $contract->next_invoice_date > $time) {
			if ($contract->next_invoice_date < $contract->contract_date_end){
				return 'contract_status_ok';
			} else {				
				//The current invoice is the last one for this contract - we let the user know this
				return 'contract_status_expiring';
			}
		}
		
		//If all these checks are false, we need an invoice.
		return 'contract_status_due';
	}
	
	/**
	 * Looks up the date of last invoice generation for any given contract.
	 * returns contract start date - 1 interval if no invoice has been generated yet.
	 */
	function _last_invoice_date($contract){
		
		//Get last invoice that was generated from that contract
		$this->db->from('mcb_contracts_invoices')
			->join('mcb_invoices', 'mcb_invoices.invoice_id = mcb_contracts_invoices.invoice_id')
			->where('mcb_contracts_invoices.contract_id',$contract->contract_id)
			->order_by('mcb_invoices.invoice_date_entered DESC')
			->limit(1);
		$lastinvoice = $this->db->get();
		
		//If no result is found, we set the last invoice date to the contract start date minus 1 interval
		$last_invoice_date = 0;
		if ($lastinvoice->num_rows() == 0) {
			$last_invoice_date = strtotime('-'.$contract->interval_string, $contract->contract_date_start);
		} else {
			$last_invoice_date = $lastinvoice->row()->invoice_date_entered;
		}
		return $last_invoice_date;
	}
	
	/**
	 * Calculates the next invoice date (does not take contract end date into account)
	 */
	function _next_invoice_date($contract){
		$next_invoice_date = strtotime($contract->interval_string, $contract->last_invoice_date);
		
		return $next_invoice_date;
	}
	
	/**
	 * Retrieves all contract intervals from the database
	 */
	function get_intervals(){
		$this->db->from('mcb_contract_intervals')
			->order_by('interval_id ASC');
		
		return $this->db->get();
	}
	
	/**
	 * Retrieves all invoices for given contract
	 */
	function get_invoices($contract_id){
		$this->db->select('invoice_id')
			->from('mcb_contracts_invoices')
			->where('contract_id',$contract_id);
		$invoice_ids = $this->db->get();
		
		if ($invoice_ids->num_rows() > 0){
		
			$invoice_ids_flat = array();
			foreach ($invoice_ids->result() as $id){
				array_push($invoice_ids_flat, $id->invoice_id);
			}
			$params = array(
				'where_in' => array(
					'mcb_invoices.invoice_id' => $invoice_ids_flat
			));
			$this->load->model('invoices/mdl_invoices');
			return $this->mdl_invoices->get($params);
		}
	}
}

?>