<?php $this->load->view('dashboard/header'); ?>

<div class="container_10" id="center_wrapper">

	<div class="grid_7" id="content_wrapper">

		<div class="section_wrapper">

			<h3 class="title_black"><?php echo $this->lang->line('taxreport');?></h3>

			<?php $this->load->view('dashboard/system_messages'); ?>

			<div class="content toggle no_padding">
				<table>
					<tr>
						<th scope="col" class="first"><?php echo $this->lang->line('invoice_period');?></th>
						<th scope="col"><?php echo $this->lang->line('invoiced');?></th>
						<th scope="col" class="last"><?php echo $this->lang->line('tax_invoiced');?></th>
					</tr>
					</thead>
					<tbody>
				<?php foreach($invoice_totals AS $title => $totals):?>
					<tr>
						<td><?php echo $this->lang->line($title);?></td>
						<td><?php echo display_currency($totals->subtotal);?></td>
						<td><?php echo display_currency($totals->tax);?></td>
					</tr>
				<?php endforeach;?>
					</tbody>
				</table>
			</div>

		</div>

	</div>
</div>

<?php $this->load->view('dashboard/sidebar'); ?>

<?php $this->load->view('dashboard/footer'); ?>