<table style="width: 100%;">

	<tr>
		<th scope="col" class="first" style="width: 25%;"><?php echo $this->lang->line('item_name'); ?></th>
		<th scope="col" style="width: 35%;"><?php echo $this->lang->line('item_description'); ?></th>
		<th scope="col" style="width: 10%;"><?php echo $this->lang->line('quantity'); ?></th>
		<th scope="col"  style="width: 10%;"><?php echo $this->lang->line('unit_price'); ?></th>
		<!--<th scope="col" style="width: 10%;"><?php echo $this->lang->line('taxable'); ?></th>-->
		<th scope="col" class="last" style="width: 10%;"><?php echo $this->lang->line('actions'); ?></th>
	</tr>

	<?php foreach ($items as $item) { ?>
		<tr>
			<td class="first"><?php echo $item->item_name; ?></td>
			<td><?php echo character_limiter($item->item_description, 40); ?></td>
			<td><?php echo number_format($item->item_qty, 2); ?></td>
			<td><?php echo display_currency($item->item_price); ?></td>
			<!--<td><?php if ($item->is_taxable) { echo icon('check'); } ?></td>-->
			<td class="last">
				<a href="<?php echo site_url('contracts/contract_items/edit/contract_id/' . uri_assoc('contract_id') . '/contract_item_id/' . $item->contract_item_id); ?>" title="<?php echo $this->lang->line('edit'); ?>">
					<?php echo icon('edit'); ?>
				</a>
				<a href="<?php echo site_url('contracts/contract_items/delete/contract_id/' . uri_assoc('contract_id') . '/contract_item_id/' . $item->contract_item_id); ?>" title="<?php echo $this->lang->line('delete'); ?>" onclick="javascript:if(!confirm('<?php echo $this->lang->line('confirm_delete'); ?>')) return false">
					<?php echo icon('delete'); ?>
				</a>
			</td>
		</tr>
	<?php } ?>

</table>