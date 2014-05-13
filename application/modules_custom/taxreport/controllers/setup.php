<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Setup extends Admin_Controller {

    function index() {

    }

    function install() {
		// Nothing to install
    }

    function uninstall() {
		// Nothing to remove
    }

    function upgrade() {

		$this->db->where('module_path', 'taxreport');
		$this->db->set('module_version', '0.1.0');
		$this->db->update('mcb_modules');

	}

}

?>