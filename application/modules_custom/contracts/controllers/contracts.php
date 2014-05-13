<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * This is the main controller of the contracts module.
 * It manages contract creation, change and deletion.
 * @author Bastian Heist - Webdesign Development Hosting - www.beheist.com
 * @version 0.8.8
 */

class Contracts extends Admin_Controller {

	function __construct() {

		parent::__construct();

		/* Make sure this module is enabled before letting user access it. */

		if (!$this->mdl_mcb_modules->check_enable('contracts')) {

			redirect('dashboard');

		}

		/* Load the module's model. */

		$this->load->model('mdl_contracts');

	}

	/**
	 * Displays a list of contracts. Main screen of contract module.
	 */
	function index() {

		/* Check for form submission and handle appropriately. */

		$this->_post_handler();

		/*
		 * Define this as the last index visited for redirection after edit
		 * or delete.
		*/
		$this->redir->set_last_index();

		/* Prepare data for the view. */

		$params = array(
			'limit'		=>	20,
			'paginate'	=>	TRUE,
			'page'		=>	uri_assoc('page', 3)
		);
		
		$contracts = $this->mdl_contracts->get($params);

		$data = array(
			'contracts'					=>	$contracts,
			'show_contract_selector'	=>	TRUE
		);

		/* Load the view. */

		$this->load->view('index', $data);

	}

	/**
	 * Contract creation
	 */
	function create() {

		/* Check for form submission and handle appropriately. */

		$this->_post_handler();	

		if (!$this->mdl_contracts->validate()) {

			/*
			 * The form has not validated, so let's do a few things and
			 * display the form.
			*/

			/* Load the form helper. */

			$this->load->helper('form');

			/* Load the text helper */

			$this->load->helper('text');

			/*
			 * Load the clients model since a list of clients is required
			 * to display on the form.
			*/
			$this->load->model('clients/mdl_clients');

			if (!$_POST AND !uri_assoc('contract_id', 3)) {

				/*
				 * This is a new record, so assign the current date as a
				 * default value for the start date.
				*/
				$this->mdl_contracts->set_form_value('contract_date_start', format_date(time()));

			}

			$data = array(
				'clients'	=>  $this->mdl_clients->get_active(),
				'intervals' =>  $this->mdl_contracts->get_intervals()
			);

			/* Load the view. */

			$this->load->view('form', $data);

		}

		else {

			/* Yippee!  The form has successfully validated, so let's save. */

			$this->mdl_contracts->save();
			
			$this->redir->redirect('contracts');
		}

	}

	/**
	 * Edit a contract
	 */
	function edit() {

		if ($this->session->flashdata('tab_index')) {
			$tab_index = $this->session->flashdata('tab_index');
		} else {
			$tab_index = 0;
		}

		/*
		 * Catch specific post activities with this handler.
		*/
		$this->_post_handler();

		$this->redir->set_last_index();

		/* Load the form helper. */
		$this->load->helper('form');

		/* Load the text helper */
		$this->load->helper('text');

		/*
		 * Load the clients model since a list of clients is required
		 * to display on the form.
		*/
		$this->load->model('clients/mdl_clients');
		$this->load->model('contracts/mdl_contract_items');
		
		$data = array(
			'invoices'			=>	$this->mdl_contracts->get_invoices(uri_assoc('contract_id')),
			'items'				=>	$this->mdl_contract_items->get(array('where' => array('mcb_contract_items.contract_id' => uri_assoc('contract_id')))),
			'clients'			=>	$this->mdl_clients->get_active(),
			'tab_index'			=>	$tab_index,
			'intervals' 		=>	$this->mdl_contracts->get_intervals()
		);
		
		if (!$this->mdl_contracts->validate()) {

			/*
			 * The form has not validated, so let's do a few things and
			 * display the form.
			*/

			if (!$_POST AND uri_assoc('contract_id', 3)) {

				/*
				 * The form has not been submitted, and this is a record edit.
				 * Prepare validation variables to populate the form.
				*/
				$this->mdl_contracts->prep_validation(uri_assoc('contract_id', 3));

			}

			/* Load the view. */

			$this->load->view('form', $data);

		}

		else {

			/* Yippee!  The form has successfully validated, so let's save. */

			$this->mdl_contracts->save();
			
			$this->redir->redirect('contracts');

		}

	}

	/**
	 * Delete a contract
	 */
	function delete() {

		/* First make sure a contract has been specified to delete. */

		if (uri_assoc('contract_id', 3)) {

			/* The uri segment variable exists, so delete the task. */

			$this->mdl_contracts->delete(array('contract_id'=>uri_assoc('contract_id', 3)));

		}

		$this->redir->redirect('contracts');

	}

	/**
	 * Displays a list of due cxontracts on the dashboard if the system setting is true
	 */
	function dashboard_widget() {

		/*
		 * As per the module config file, this function will execute when
		 * the core dashboard calls for it.
		*/

		if ($this->mdl_mcb_data->setting('contracts_show_due') == "TRUE") {
			
			//Since status is calculated at call time, we need to filter manually
			$contracts = $this->mdl_contracts->get(array());
			$contracts_due = array();
			foreach ($contracts as $contract){
				if ($contract->status == 'contract_status_due'){
					array_push($contracts_due, $contract);
				}
			}
			
			$data = array(
				'contracts'	=>	$contracts_due
			);

			$this->load->view('dashboard_widget', $data);

		}

	}

	function _post_handler() {

		/* Has the Add Contracts button been pressed? */

		if ($this->input->post('btn_add')) {

			redirect('contracts/create');

		}

		/* Has the Cancel button been pressed? */

		elseif ($this->input->post('btn_cancel')) {

			redirect('contracts/index');

		}

		/* Has the Add Item to Contract button been pressed? */

		elseif ($this->input->post('btn_add_new_item')) {

			redirect('contracts/contract_items/create/contract_id/'.uri_assoc('contract_id', 3));

		}

		elseif ($this->input->post('btn_create_inv')) {

			$invoice_id = $this->mdl_contracts->create_invoice_from_contract(uri_assoc('contract_id', 3));
			
			//invoice_id is FALSE when invoice generation is forbidden
			if ($invoice_id){
				redirect('invoices/edit/invoice_id/' . $invoice_id);
			} else {
				$this->session->set_flashdata('custom_error',$this->lang->line('contract_no_invoice'));
				redirect('contracts/edit/contract_id/'.uri_assoc('contract_id', 3));
			}

		}

	}

}

?>