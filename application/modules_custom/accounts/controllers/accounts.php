<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class accounts extends Admin_Controller {

	function __construct() {

		parent::__construct();

		/* Make sure this module is enabled before letting user access it. */

		if (!$this->mdl_mcb_modules->check_enable('accounts')) {

			redirect('dashboard');

		}

		/* Load the module's model. */

		$this->load->model('mdl_accounts');

	}

	function index() {

		$this->_post_handler();
			$this->redir->set_last_index();	

		$params = array(
			'limit'		=>	20,
			'paginate'	=>	TRUE,
			'page'		=>	uri_assoc('page', 3)
		);

		$data = array(
			'accounts' =>	$this->mdl_accounts->get($params)
		);
		$this->load->view('index', $data);

	}

	function reports($from_date='',$to_date='') {

		$this->_post_handler();
		$this->redir->set_last_index();				
	 	$this->load->view('reports');

	}


	function form() {

		/* Check for form submission and handle appropriately. */

		$this->_post_handler();

		if (!$this->mdl_accounts->validate()) {

				$this->load->helper('form');

			/* Load the text helper */

			$this->load->helper('form'); //ITHE2011
			$this->load->helper('text');
			$this->load->model('clients/mdl_clients');

			if (!$_POST AND uri_assoc('expense_id', 3)) {

				$this->mdl_accounts->prep_validation(uri_assoc('expense_id', 3));

			}

			elseif (!$_POST AND !uri_assoc('expense_id', 3)) {
				$this->mdl_accounts->start_date = format_date(time());


			}

			$data = array(
				'clients'	=>	$this->mdl_clients->get()
			);

			/* Load the view. */

			$this->load->view('form', $data);

		}

		else {

			/* Yippee!  The form has successfully validated, so let's save. */

			$this->mdl_accounts->save();			
			$this->redir->redirect('accounts');

		}

	}

	function delete() {

		/* First make sure a task has been specified to delete. */

		if (uri_assoc('expense_id', 3)) {

			/* The uri segment variable exists, so delete the task. */

			$this->mdl_accounts->delete(array('expense_id'=>uri_assoc('expense_id', 3)));

		}

		$this->redir->redirect('accounts');

	}

	function save_settings() {

		/*
		 * As per the config file, this function will
		 * execute when the core system settings are saved.
		*/

		if ($this->input->post('dashboard_show_open_accounts')) {

			$this->mdl_mcb_data->save('dashboard_show_open_accounts', "TRUE");

		}

		else {

			$this->mdl_mcb_data->save('dashboard_show_open_accounts', "FALSE");

		}

	}

	function dashboard_widget() {

		/*
		 * As per the module config file, this function will execute when
		 * the core dashboard calls for it.
		*/

		if ($this->mdl_mcb_data->setting('dashboard_show_open_accounts') == "TRUE") {

			/*
			 * Only execute if the module's custom system setting has been saved
			 * as TRUE.
			*/

			$params = array(
				'limit'	=>	10);

			$data = array(
				'accounts'				=>	$this->mdl_accounts->get($params)
			);

			$this->load->view('dashboard_widget', $data);

		}

	}

	function _post_handler() {

		/* Has the Add Task button been pressed? */

		if ($this->input->post('btn_add')) {

			redirect('accounts/form');

		}

		/* Has the Cancel button been pressed? */

		elseif ($this->input->post('btn_cancel')) {

			redirect('accounts/index');

		}
	
		
		
		

	}

}

?>