<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * This controller is for module settings.
 * @author Bastian Heist - Webdesign Development Hosting - www.beheist.com
 * @version 0.8.8
 */

class Contracts_Settings extends Admin_Controller {

	function display() {

		$this->load->view('settings');

	}

	function save() {

		/*
		 * As per the config file, this function will
		 * execute when the system settings are saved.
		 */
		if ($this->input->post('contracts_show_due')) {

			$this->mdl_mcb_data->save('contracts_show_due', $this->input->post('contracts_show_due'));

		}

		else {

			$this->mdl_mcb_data->save('contracts_show_due', "FALSE");

		}
	}

}

?>