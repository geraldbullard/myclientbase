<?php if ($contracts) {?>

<table style="width: 100%;">
    <tr>
		<?php if (isset($show_contract_selector)) { ?><th scope="col" class="first">&nbsp;</th><?php } ?>
		<th scope="col" <?php if (!isset($show_contract_selector)) { ?>class="first"<?php } ?>><?php echo $this->lang->line('title');?></th>
		<th scope="col"><?php echo $this->lang->line('start_date');?></th>
		<th scope="col"><?php echo $this->lang->line('contract_interval_id');?></th>
		<th scope="col"><?php echo $this->lang->line('client');?></th>
		<th scope="col"><?php echo $this->lang->line('status');?></th>
		<th scope="col" class="last"><?php echo $this->lang->line('actions');?></th>
    </tr>
	<?php foreach ($contracts as $contract) {?>
    <tr>
		<?php if (isset($show_contract_selector)) { ?><td class="first"><input type="checkbox" name="contract_id[]" value="<?php echo $contract->contract_id; ?>" /></td><?php } ?>
		<td><?php echo anchor('contracts/edit/contract_id/' . $contract->contract_id, $contract->contract_name, array('class'=>'edit'));?></td>
		<td><?php if($contract->contract_date_start){echo format_date($contract->contract_date_start);}?></td>
		<td><?php echo $contract->interval_name;?></td>
		<td <?php if (!isset($show_contract_selector)) { ?>class="first"<?php } ?>><?php echo $contract->client_name;?></td>
		<td><?php echo $this->lang->line($contract->status);?></td>
		<td class="last">
			<!--Actions-->
			<?php echo anchor('contracts/edit/contract_id/' . $contract->contract_id, icon('edit'), array('class'=>'edit'));?>
			<?php echo anchor('contracts/delete/contract_id/' . $contract->contract_id, icon('delete'), array('class'=>'delete', 'onclick'=>"javascript:if(!confirm('" . $this->lang->line('confirm_delete') . "')) return false"));?>
		</td>
    </tr>
	<?php }?>
</table>

<?php if ($this->mdl_contracts->page_links) { ?>
<div id="pagination">
	<?php echo $this->mdl_contracts->page_links; ?>
</div>
<?php } ?>

<?php } else {?>
	<p><?php echo $this->lang->line('no_records_found');?>.</p><br />
<?php }?>