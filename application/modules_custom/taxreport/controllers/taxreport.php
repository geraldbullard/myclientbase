<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Taxreport extends Admin_Controller {

    function __construct() {

        parent::__construct();

        if (!$this->mdl_mcb_modules->check_enable('taxreport')) {

            redirect('mcb_modules');

        }

        $this->load->model('mdl_taxreport');

        $this->_post_handler();

    }

    function index() {

		$data['invoice_totals'] = $this->mdl_taxreport->get_invoice_amounts();
        $this->load->view('index', $data);

    }

    function _post_handler() {

    }

}

?>