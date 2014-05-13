<?php $this->load->view('dashboard/header'); ?>

<?php $this->load->view('dashboard/jquery_date_picker'); ?>

<div class="grid_10" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('expenses_form'); ?></h3>

		<?php $this->load->view('dashboard/system_messages'); ?>

		<div class="content toggle">

			<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">


				<dl>
					<dt><label><?php echo $this->lang->line('expense_date');?>: </label></dt>
					<dd><input class="datepicker" type="text" name="expense_date" value="<?php echo $this->mdl_accounts->form_value('expense_date');?>" /></dd>
				</dl>
				<dl>
					<dt><label><?php echo $this->lang->line('amount');?>: </label></dt>
					<dd><input id="amount" type="text" name="amount" value="<?php echo $this->mdl_accounts->form_value('amount');?>" /></dd>
				</dl>

				<dl>
					<dt><label><?php echo $this->lang->line('expense_for');?>: </label></dt>
					<dd><textarea id="expense_for" name="expense_for" rows="10" cols="50"><?php echo $this->mdl_accounts->form_value('expense_for');?></textarea></dd>
				</dl>

				<input type="submit" id="btn_submit" name="btn_submit" value="<?php echo $this->lang->line('submit');?>" />
				<input type="submit" id="btn_cancel" name="btn_cancel" value="<?php echo $this->lang->line('cancel');?>" />

			</form>

		</div>

	</div>

</div>

<?php $this->load->view('dashboard/footer'); ?>