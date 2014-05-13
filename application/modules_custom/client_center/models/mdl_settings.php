<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mdl_Settings extends MY_Model {
	
	function validate() {

		$this->form_validation->set_rules('pp_email', $this->lang->line('paypal_email'), 'required');
		$this->form_validation->set_rules('pp_cru', $this->lang->line('cru'), 'required');
		$this->form_validation->set_rules('pp_ru', $this->lang->line('ru'), 'required');
		$this->form_validation->set_rules('pp_logo', $this->lang->line('logo'));

		return parent::validate($this);

	}

	function save() {

		$new_pp_data = array(
			'paypal_email'			=> $this->input->post('pp_email'),
			'cancel_return_url'		=> $this->input->post('pp_cru'),
			'return_url'			=> $this->input->post('pp_ru'),
			'logo'					=> $this->input->post('pp_logo'),
		);
		
		$insert = $this->db->update('mcb_paypal', $new_pp_data);
		return $insert;

	}

}

?>
