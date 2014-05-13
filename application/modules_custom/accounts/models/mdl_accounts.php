<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
 
class Mdl_accounts extends MY_Model {

	function __construct() {

		/* MY_Model does a lot of legwork for us. */

		parent::__construct();

		/* Define the database table name. */

		$this->table_name = 'mcb_expenses';
        $pending->table_name = 'mcb_invoice_amounts';


		/* Define the primary key of the table. */

		$this->primary_key = 'mcb_expenses.expense_id';

		/* Define SQL_CALC_FOUND_ROWS * as a minimum for pagination. */

		$this->select_fields = "
		SQL_CALC_FOUND_ROWS mcb_expenses.*";

		$this->order_by = 'mcb_expenses.expense_date, mcb_expenses.expense_id DESC';
		$expense_date = 'test';
	}

	function validate() {
		$this->form_validation->set_rules('expense_date', $this->lang->line('expense_date'), 'required');
		$this->form_validation->set_rules('amount', $this->lang->line('amount'), 'required');
		$this->form_validation->set_rules('expense_for', $this->lang->line('expense_for'), 'required');

		return parent::validate();

	}

	function save() {

		/* Prepare the default $db_array */

		$db_array = parent::db_array();

		if (isset($db_array['expense_date']) and $db_array['expense_date']) {

			$db_array['expense_date'] = strtotime(standardize_date($db_array['expense_date']));
		}

		

		parent::save($db_array, uri_assoc('expense_id', 3));

	}

	function prep_validation($key) {

		/* First prepare the default validation */

		parent::prep_validation($key);

		if (!$_POST) {



			if ($this->form_value('expense_date')) {

				/* Convert to a human readable date if the unix timestamp exists. */

				$this->set_form_value('expense_date', format_date($this->form_value('expense_date')));


			} 

		} 

	}

	function delete($params) {

		/* Run the standard delete function. */

		parent::delete($params);

		/*
		 * And delete records from mcb_expenses_invoices as well.
		 * This does NOT delete the actual invoices.
		*/
		

	}
	
	function report(){
		
	}

	function total_payment($from_date='',$to_date=''){
		
		$this->db->select_sum('payment_amount');		
		if($from_date!='')	$this->db->where('payment_date >=',$from_date);
		
		if($to_date!='')	$this->db->where('payment_date <=', $to_date);
		
		$query = $this->db->get('mcb_payments'); 
		$row = $query->row(); 
		return $row->payment_amount;
	}
	
	function total_expense($from_date='',$to_date=''){
	
		$this->db->select_sum('amount'); 
		
		if($from_date!='')	$this->db->where('expense_date >=',$from_date);		
		if($to_date!='')	$this->db->where('expense_date <=', $to_date);
		
		$query = $this->db->get('mcb_expenses'); 
		$row = $query->row(); 
		return ''.$row->amount;
	}
	
	function total_expanse5($from_date,$to_date){

		$this->db->select_sum('amount'); 
		if(($from_date!=FALSE)&&($to_date!=FALSE))
		{
		
			$this->db->where('expense_date >=',strtotime(standardize_date($from_date)));
			$this->db->where('expense_date <=', strtotime(standardize_date($to_date)));
	
			
		}
		$query = $this->db->get('mcb_expenses'); 
		$row = $query->row(); 
		return ''.$row->amount;
	}
		 

	function total_pending(){
		$this->db->select_sum('invoice_balance'); 		
		$query = $this->db->get('mcb_invoice_amounts'); 
		$row = $query->row();
		return $row->invoice_balance; 
	}
	
	function balance($from_date,$to_date){
		$amount = $this->total_payment($from_date,$to_date) - $this->total_expanse($from_date,$to_date);
		return $amount;
	}
	
	
	function custome_total_pending($from_date='',$to_date=''){
		$amount_balance=0;
		$this->db->select('invoice_id'); 	
		//if($from_date!='')	$this->db->where('invoice_date_entered >=',strtotime(standardize_date($from_date)));
		 if($to_date!='')	$this->db->where('invoice_date_entered <=', strtotime(standardize_date($to_date)));
					
		$query = $this->db->get('mcb_invoices'); 		
		

		foreach ($query->result() as $row)
		{
			 
			$this->db->select('invoice_balance'); 
			$this->db->where('invoice_id',$row->invoice_id);	
			$query2 = $this->db->get('mcb_invoice_amounts'); 
			$row2 = $query2->row();
			$amount_balance=$amount_balance+$row2->invoice_balance ;	 			 
			 
		}
		
		return $amount_balance;
	}
	
}

?>