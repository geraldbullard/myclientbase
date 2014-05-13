<?php foreach ($menu_items as $item) { ?>

<li <?php if (isset($item['class'])) { ?>class="<?php echo $item['class']; ?>"<?php } ?>>
    <?php echo anchor($item['href'], $this->lang->line($item['title'])); ?>
    <?php if (isset($item['submenu'])) { ?>
    <ul>
        <?php foreach ($item['submenu'] as $subitem) { ?>
        <li><?php echo anchor($subitem['href'], $this->lang->line($subitem['title'])); ?></li>
        <?php } ?>
    </ul>
    <?php } ?>
</li>

<?php } ?>

<?php if ($this->session->userdata('global_admin') and $this->mdl_mcb_modules->num_custom_modules_enabled) { ?>

<li><?php echo anchor('mcb_modules', $this->lang->line('custom_modules')); ?>
	<ul>
		<?php $x = 0; foreach ($this->mdl_mcb_modules->custom_modules as $module) {;?>
			<?php if ($module->module_enabled) { $x++;?>
				<li <?php if ($x == $this->mdl_mcb_modules->num_custom_modules_enabled) { ?>class="last"<?php } ?>>
				<?php echo anchor($module->module_path, $module->module_name); ?>
				</li>
			<?php } ?>
		<?php } ?> 

	</ul>
</li>
<?php } ?>

<li><?php echo anchor('sessions/logout', $this->lang->line('log_out')); ?></li>
<li><?php echo anchor('http://www.3g-dev.com/', '<div style="float:left;">3G Home &nbsp;</div><div style="float:left; padding-top:10px;">' . icon('new-window') . '</div>', 'target="_blank"'); ?></li>
<li><?php echo anchor('http://www.3g-dev.com/projects/', '<div style="float:left;">3G Projects &nbsp;</div><div style="float:left; padding-top:10px;">' . icon('new-window') . '</div>', 'target="_blank"'); ?></li>
