				<dl>
					<dt><label><?php echo $this->lang->line('client');?>: </label></dt>
					<dd>
						<select name="client_id">
							<?php foreach ($clients as $client) {?>
							<option value="<?php echo $client->client_id;?>" <?php if($this->mdl_contracts->form_value('client_id') == $client->client_id) {?>selected<?php }?>><?php echo $client->client_name;?></option>
							<?php }?>
						</select>
					</dd>
				</dl>
				
				<dl>
					<dt><label><?php echo $this->lang->line('contract_interval_id');?>: </label></dt>
					<dd>
						<select name="interval_id">
							<?php foreach ($intervals->result() as $interval) {?>
							<option value="<?php echo $interval->interval_id;?>" <?php if($this->mdl_contracts->form_value('interval_id') == $interval->interval_id) {?>selected<?php }?>><?php echo $interval->interval_name;?></option>
							<?php }?>
						</select>
					</dd>
				</dl>

				<dl>
					<dt><label><?php echo $this->lang->line('start_date');?>: </label></dt>
					<dd><input class="datepicker" type="text" name="contract_date_start" value="<?php echo $this->mdl_contracts->form_value('contract_date_start');?>" /></dd>
				</dl>

				<dl>
					<dt><label><?php echo $this->lang->line('contract_date_end');?>: </label></dt>
					<dd><input class="datepicker" type="text" name="contract_date_end" value="<?php echo $this->mdl_contracts->form_value('contract_date_end');?>" /></dd>
				</dl>

				<?php 
				//Only show these when editing
				if ($this->mdl_contracts->form_value('status') != ''): ?>
					<dl>
						<dt><label><?php echo $this->lang->line('contract_total_value');?>: </label></dt>
						<dd><?php
							$value = 0;
							foreach ($items as $item){
								$value += $item->item_price * $item->item_qty;
							}
							echo display_currency($value);
						?></dd>
					</dl>
					<dl>
						<dt><label><?php echo $this->lang->line('status');?>: </label></dt>
						<dd><?php echo $this->lang->line($this->mdl_contracts->form_value('status').'_l');?></dd>
					</dl>
					<dl>
						<dt><label><?php echo $this->lang->line('contract_next_invoice');?>: </label></dt>
						<dd><?php if ($this->mdl_contracts->form_value('status') == 'contract_status_ok' || $this->mdl_contracts->form_value('status') == 'contract_status_due'){
							echo format_date(strtotime($this->mdl_contracts->form_value('interval_string'), $this->mdl_contracts->form_value('last_invoice_date')));
						} else {
							echo 'N/A';
						}
						?></dd>
					</dl>
				<?php endif; ?>

				<dl>
					<dt><label><?php echo $this->lang->line('contract_name');?>: </label></dt>
					<dd><input id="title" type="text" name="contract_name" value="<?php echo $this->mdl_contracts->form_value('contract_name');?>" /></dd>
				</dl>

				<dl>
					<dt><label><?php echo $this->lang->line('description');?>: </label></dt>
					<dd><textarea id="description" name="contract_descr" rows="10" cols="50"><?php echo $this->mdl_contracts->form_value('contract_descr');?></textarea></dd>
				</dl>

				<input type="submit" id="btn_submit" name="btn_submit" value="<?php echo $this->lang->line('submit');?>" />
				<input type="submit" id="btn_cancel" name="btn_cancel" value="<?php echo $this->lang->line('cancel');?>" />