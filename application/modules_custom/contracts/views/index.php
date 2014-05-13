<?php $this->load->view('dashboard/header'); ?>

<div class="grid_7" id="content_wrapper">

	<div class="section_wrapper">

		<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>" style="display: inline;">

		<h3 class="title_black"><?php echo $this->lang->line('contracts'); ?>
		
			<input type="submit" name="btn_add" style="float: right; margin-top: 10px; margin-right: 10px;" value="<?php echo $this->lang->line('create_contract'); ?>" />
		
		</h3>

		<?php $this->load->view('dashboard/system_messages'); ?>

		<div class="content toggle no_padding">

			<?php $this->load->view('table');?>

		</div>

		</form>

	</div>

</div>

<?php $this->load->view('dashboard/sidebar', array('side_block'=>'contracts/sidebar')); ?>

<?php $this->load->view('dashboard/footer'); ?>