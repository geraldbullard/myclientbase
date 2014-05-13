<?php $this->load->view('dashboard/header'); ?>
<div class="grid_7" id="content_wrapper">

	<div class="section_wrapper">

		<h3 class="title_black"><?php echo $this->lang->line('expenses'); ?><?php $this->load->view('dashboard/btn_add'); ?></h3>

		<?php $this->load->view('dashboard/system_messages'); ?>

		<div class="content toggle no_padding" style="min-height:300px;">

			<?php $this->load->view('table');?>

		</div>

	</div>

</div>
<?php $this->load->view('sidebar');?>
<?php $this->load->view('dashboard/sidebar'); ?>

<?php $this->load->view('dashboard/footer'); ?>