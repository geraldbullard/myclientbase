<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * This controller manages creating, changing and deleting contract items.
 * @author Bastian Heist - Webdesign Development Hosting - www.beheist.com
 * @version 0.8.8
 */

class Contract_Items extends Admin_Controller {

	function __construct() {

		parent::__construct();

		/* Make sure this module is enabled before letting user access it. */

		if (!$this->mdl_mcb_modules->check_enable('contracts')) {

			redirect('dashboard');

		}

		/* Load the necessary models. */

		$this->load->model('mdl_contract_items');
		$this->load->model('mdl_contracts');

	}

	function index() {
		
	}

	/**
	 * Create a contract item
	 */
	function create() {
		
		$this->_post_handler();

		if (!$this->mdl_contract_items->validate()) {

			/*
			 * The form has not validated, so let's do a few things and
			 * display the form.
			*/

			/* Load the form helper. */

			$this->load->helper('form');

			/* Load the text helper */

			$this->load->helper('text');

			/*
			 * Load the additional models
			*/
			$this->load->model(array(
				'invoice_items/mdl_invoice_items',
				'tax_rates/mdl_tax_rates'));

			$data = array(
				'invoice_items'	=>	$this->mdl_invoice_items->get(),
				'contract'	=>	reset($this->mdl_contracts->get(array('where' => array('contract_id' => uri_assoc('contract_id', 4))))),
				'tax_rates' => $this->mdl_tax_rates->get()
			);

			/* Load the item creation view. */

			$this->load->view('item_form', $data);

		}

		else {

			/* Yippee!  The form has successfully validated, so let's save. */

			$this->mdl_contract_items->save();
		
			$this->session->set_flashdata('tab_index', 1);
			
			$this->redir->redirect('contracts/edit/contract_id/'.uri_assoc('contract_id', 4));
		}

	}

	/**
	 * Edit a contract item
	 */
	function edit() {
		
		$this->_post_handler();

		/* Load the form helper. */
		$this->load->helper('form');

		/* Load the text helper */
		$this->load->helper('text');

		/*
		 * Load the models
		 */
		$this->load->model(array(
			'invoice_items/mdl_invoice_items',
			'tax_rates/mdl_tax_rates'));
		
		$data = array(
			'invoice_items'	=>	$this->mdl_invoice_items->get(),
			'contract'	=>	reset($this->mdl_contracts->get(array('where' => array('contract_id' => uri_assoc('contract_id', 4))))),
			'tax_rates' => $this->mdl_tax_rates->get()
		);
		
		if (!$this->mdl_contract_items->validate()) {

			/*
			 * The form has not validated, so let's do a few things and
			 * display the form.
			*/

			if (!$_POST AND uri_assoc('contract_item_id', 6)) {

				/*
				 * The form has not been submitted, and this is a record edit.
				 * Prepare validation variables to populate the form.
				*/
				$this->mdl_contract_items->prep_validation(uri_assoc('contract_item_id', 6));

			}

			/* Load the view. */

			$this->load->view('item_form', $data);

		}

		else {

			/* Yippee!  The form has successfully validated, so let's save. */

			$this->mdl_contract_items->save();
		
			$this->session->set_flashdata('tab_index', 1);
			
			$this->redir->redirect('contracts/edit/contract_id/'.uri_assoc('contract_id', 4));

		}

	}

	/**
	 * Delete a contract item
	 */
	function delete() {
		
		$this->session->set_flashdata('tab_index', 1);

		/* First make sure a contract item has been specified to delete. */

		if (uri_assoc('contract_item_id', 6)) {

			/* The uri segment variable exists, so delete the item. */

			$this->mdl_contract_items->delete(array('contract_item_id'=>uri_assoc('contract_item_id', 6)));

		}

		$this->redir->redirect('contracts/edit/contract_id/'.uri_assoc('contract_id', 4));

	}

	function _post_handler() {

		/* Has the Cancel button been pressed? */

		if ($this->input->post('btn_cancel')) {

			redirect('contracts/edit/contract_id/'.uri_assoc('contract_id', 4));

		}

	}

}

?>