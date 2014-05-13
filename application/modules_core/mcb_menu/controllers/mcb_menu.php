<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MCB_Menu extends Admin_Controller {

    function __construct() {

        parent::__construct();

    }

    function generate() {

        $menu_items = $this->config->item('mcb_menu');

        foreach ($menu_items as $key=>$menu_item) {

            if (!$this->session->userdata('global_admin')) {

                if (isset($menu_item['global_admin'])) {

                    unset($menu_items[$key]);

                }

                /*elseif (isset($menu_item['submenu'])) {

                    foreach ($menu_item['submenu'] as $sub_key=>$sub_item) {

                        if (isset($sub_item['global_admin'])) {

                            unset($menu_items[$key]['submenu'][$sub_key]);

                        }

                    }

                } */

            }

        }

        if (isset($menu_items['dashboard']) and (!$this->uri->segment(1) or $this->uri->segment(1) == 'dashboard')) {
            $menu_items['dashboard']['class'] = 'selected';
        }

        elseif (isset($menu_items['clients']) and ($this->uri->segment(1) == 'clients')) {
            $menu_items['clients']['class'] = 'selected';
        }

        elseif (isset($menu_items['invoices']) and ($this->uri->segment(2) <> 'invoice_groups' and ($this->uri->segment(1) == 'invoices' or
                    $this->uri->segment(1) == 'invoice_items' or $this->uri->segment(1) == 'invoice_search' or
                    ($this->uri->segment(1) == 'templates' and $this->uri->segment(4) == 'invoices')))) {
            $menu_items['invoices']['class'] = 'selected';
        }

        elseif (isset($menu_items['payments']) and ($this->uri->segment(1) == 'payments' or
                ($this->uri->segment(1) == 'templates' and $this->uri->segment(4) == 'payment_receipts'))) {
            $menu_items['payments']['class'] = 'selected';
        }

        elseif (isset($menu_items['settings']) and ($this->uri->segment(1) == 'settings' or $this->uri->segment(1) == 'users' or
                $this->uri->segment(1) == 'tax_rates' or $this->uri->segment(1) == 'invoice_statuses' or
                $this->uri->segment(2) == 'invoice_groups' or ($this->uri->segment(1) == 'fields' or
                    $this->uri->segment(1) == 'mcb_modules'))) {
            $menu_items['system']['class'] = 'selected';
        }

        return $menu_items;

    }

    function display($params) {

        $data = array(
            'menu_items'    =>  $this->generate()
        );

        $this->load->view($params['view'], $data);

    }

    function check_permission($uri_string, $global_admin) {

        foreach ($this->config->item('mcb_menu') as $menu_item) {

            if (strpos($menu_item['href'], $uri_string) === 0) {

                if (isset($menu_item['global_admin']) and !$global_admin) {

                    redirect('dashboard');

                }

            }

            /*if (isset($menu_item['submenu'])) {

                foreach ($menu_item['submenu'] as $sub_item) {

                    if (strpos($sub_item['href'], $uri_string) === 0) {

                        if (isset($sub_item['global_admin']) and !$global_admin) {

                            redirect('dashboard');

                        }

                    }


                }

            }*/

        }

    }

}

?>