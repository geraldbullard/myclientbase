<tr>
	<th colspan="2"><?php echo $this->lang->line('module_settings');?> (Contracts)</th>
</tr>
<tr>
	<td><?php echo $this->lang->line('contracts_show_due');?></td>
	<td>
		<input type="checkbox" name="contracts_show_due" value="TRUE" <?php if($this->mdl_mcb_data->setting('contracts_show_due') == "TRUE"){?>checked="checked"<?php }?> />
	</td>
</tr>