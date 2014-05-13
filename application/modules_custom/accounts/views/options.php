<?php $this->load->view('dashboard/jquery_date_picker'); ?>
<?php echo form_open('accounts/reports');?>
<div style="padding:5px 5px 5px 10px;background-color:#DDEEFF;border:solid 1px #A4D1FF;font-family:Georgia,Times,serif;">
<?php echo $this->lang->line('from_date');?> : <input class="datepicker" type="text" name="from_date" value="<?php //echo date($this->mdl_mcb_data->default_date_format); ?>" size="10" />
&nbsp;&nbsp;<?php echo $this->lang->line('to_date');?>   : <input class="datepicker" type="text" name="to_date" value="<?php //echo date($this->mdl_mcb_data->default_date_format); ?>" size="10" />
<?php /*?>&nbsp;&nbsp;&nbsp;<label for="all_time">All Time</label><input name="all_time" id="all_time" type="checkbox" value="1" /><?php */?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="btn_generate_report" class="report" value="Generate" />		
</div>   
</form>