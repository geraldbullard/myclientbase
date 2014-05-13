<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Mdl_Taxreport extends CI_Model {

    function get_invoice_amounts() {
		$amount = array();
		
		$start_last_year = mktime(0, 0, 0, 1, 1, date('Y')-1);
		$end_last_year = mktime(0, 0, 0, 1, 0, date('Y'));
		$amount['lastyear'] = $this->_get_total_invoice_amounts($start_last_year, $end_last_year);
		
		$start_this_year = mktime(0, 0, 0, 1, 1, date('Y'));
		$end_this_year = mktime(0, 0, 0, 1, 0, date('Y')+1);
		$amount['thisyear'] = $this->_get_total_invoice_amounts($start_this_year, $end_this_year);
		
		$start_last_month = mktime(0, 0, 0, date('m')-1, 1, date('Y'));
		$end_last_month = mktime(0, 0, 0, date('m'), 0, date('Y'));
		$amount['lastmonth'] = $this->_get_total_invoice_amounts($start_last_month, $end_last_month);
		
		$start_this_month = mktime(0, 0, 0, date('m'), 1, date('Y'));
		$end_this_month = mktime(0, 0, 0, date('m')+1, 0, date('Y'));
		$amount['thismonth'] = $this->_get_total_invoice_amounts($start_this_month, $end_this_month);
		
		$last_quarter = $this->_getQuarter(date('Y').'-'.(date('m')-3).'-'.date('d'));
		$amount['lastquarter'] = $this->_get_total_invoice_amounts($last_quarter['start'], $last_quarter['end']);		
		
		$this_quarter = $this->_getQuarter(date('Y').'-'.date('m').'-'.date('d'));
		$amount['thisquarter'] = $this->_get_total_invoice_amounts($this_quarter['start'], $this_quarter['end']);

		return $amount;
    }
	
	private function _getQuarter($date) {
	
		$q = (int)floor(date('m', strtotime($date)) / 3.1) + 1;
		$quarters = array(
			1 => array('start' => mktime(0,0,0,1,1,date('Y', strtotime($date))), 'end' => mktime(0,0,0,4,0,date('Y', strtotime($date)))),
			2 => array('start' => mktime(0,0,0,4,1,date('Y', strtotime($date))), 'end' => mktime(0,0,0,7,0,date('Y', strtotime($date)))),
			3 => array('start' => mktime(0,0,0,7,1,date('Y', strtotime($date))), 'end' => mktime(0,0,0,10,0,date('Y', strtotime($date)))),
			4 => array('start' => mktime(0,0,0,10,1,date('Y', strtotime($date))), 'end' => mktime(0,0,0,0,0,date('Y', strtotime($date))-1))
		);
		return $quarters[$q];   
	}
	
	private function _get_total_invoice_amounts($from, $until) {
		$this->db->select(
            'SUM(mcb_invoice_amounts.invoice_subtotal) AS subtotal, ' .
            'SUM(mcb_invoice_amounts.invoice_tax) AS tax, ',
            FALSE);

        $this->db->join('mcb_invoice_amounts', 'mcb_invoice_amounts.invoice_id = mcb_invoices.invoice_id');
        $this->db->where('invoice_is_quote', 0);
		$this->db->where('invoice_date_entered >= '.$from.' AND invoice_date_entered <= '.$until);
        $this->db->order_by('invoice_date_entered');
        return $this->db->get('mcb_invoices')->row();
	}

}

?>