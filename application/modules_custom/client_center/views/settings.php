<?php $this->load->view('dashboard/header'); ?>

<div class="container_10" id="center_wrapper">

	<div class="grid_10" id="content_wrapper">

		<div class="section_wrapper">

			<h3 class="title_black"><?php echo $this->lang->line('clientcenter_settings'); ?></h3>

			<?php $this->load->view('dashboard/system_messages');
			
			$query = $this->db->query("SELECT * FROM mcb_paypal");  
 				$row = $query->row();
 					$paypal_email = $row->paypal_email;
					$cancel_return_url = $row->cancel_return_url;
					$return_url = $row->return_url;
					$logo_url = $row->logo;
			?>

			<div class="content toggle">

				<form method="post" action="<?php echo site_url($this->uri->uri_string()); ?>">

				<dl>
					<dt><label><?php echo $this->lang->line('paypal_email'); ?>: </label></dt>
					<dd><input type="text" name="pp_email" id="pp_email" value="<?php echo $paypal_email; ?>" /></dd>
				</dl>

				<dl>
					<dt><label><?php echo $this->lang->line('cru'); ?>: </label></dt>
					<dd><input type="text" name="pp_cru" id="pp_cru" value="<?php echo $cancel_return_url; ?>" /></dd>
				</dl>
				
				<dl>
					<dt><label><?php echo $this->lang->line('ru'); ?>: </label></dt>
					<dd><input type="text" name="pp_ru" id="pp_ru" value="<?php echo $return_url; ?>" /></dd>
				</dl>
				
				<dl>
					<dt><label><?php echo $this->lang->line('logo'); ?>: </label></dt>
					<dd><input type="text" name="pp_logo" id="pp_logo" value="<?php echo $logo_url; ?>" /></dd>
				</dl>

				<input type="submit" id="btn_submit" name="btn_submit" value="<?php echo $this->lang->line('submit'); ?>" />
				<input type="submit" id="btn_cancel" name="btn_cancel" value="<?php echo $this->lang->line('cancel'); ?>" />

				</form>

			</div>

		</div>

	</div>
</div>

<?php $this->load->view('dashboard/footer'); ?>