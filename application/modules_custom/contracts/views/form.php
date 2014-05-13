<?php $this->load->view('dashboard/header'); ?>

<?php $this->load->view('dashboard/jquery_date_picker'); ?>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/jquery/jquery.relcopy.js"></script>

<script type="text/javascript">
	$(function(){
		var append_to_clone = ' <a class="remove" href="#" onclick="$(this).parent().remove(); return false"><?php echo $this->lang->line('delete'); ?></a>';
		$('a.copy').relCopy({append: append_to_clone});
		$('#tabs').tabs({ selected: <?php echo $tab_index; ?> });
	});
</script>

<div class="grid_10" id="content_wrapper">

	<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('contract_form'); ?>
			<?php if ($this->mdl_contracts->form_value('contract_name') != ''){
				echo ' ('.$this->mdl_contracts->form_value('contract_name').')'; ?>
				<input type="submit" name="btn_add_new_item" style="float: right; margin-top: 10px; margin-right: 10px;" value="<?php echo $this->lang->line('contract_add_item'); ?>" />
				<?php if ($this->mdl_contracts->form_value('status') == 'contract_status_due' && count($items) > 0): ?>
					<input type="submit" name="btn_create_inv" style="float: right; margin-top: 10px; margin-right: 10px;" value="<?php echo $this->lang->line('contract_create_invoice'); ?>" />
				<?php endif; ?>
			<?php } ?> 
			
		</h3>

		<?php $this->load->view('dashboard/system_messages'); ?>

		<div class="content toggle">

				<div id="tabs">
					<ul>
						<li><a href="#tab_general"><?php echo $this->lang->line('summary'); ?></a></li>
						<?php 
						//Only show the other tabs when editing
						if ($this->mdl_contracts->form_value('contract_id') > 0): ?>
							<li><a href="#tab_items"><?php echo $this->lang->line('items'); ?></a></li>
							<li><a href="#tab_invoices"><?php echo $this->lang->line('invoices'); ?></a></li>
						<?php endif; ?>
					</ul>
					<div id="tab_general">
						<?php $this->load->view('tab_general'); ?>
					</div>
					<?php 
					//Only show the other tabs when editing
					if ($this->mdl_contracts->form_value('contract_id') > 0): ?>
						<div id="tab_items">
							<?php $this->load->view('tab_items'); ?>
						</div>
						
						<div id="tab_invoices">
							<?php $this->load->view('tab_invoices'); ?>
						</div>
					<?php endif; ?>

				</div>

			<div style="clear: both;">&nbsp;</div>

			</form>

		</div>

	</div>

</div>

<?php $this->load->view('dashboard/footer'); ?>