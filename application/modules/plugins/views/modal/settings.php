<div class="modal-dialog modal-md">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title"><?php echo ucfirst($plugin).' '.lang('settings'); ?></h4>
		</div> 
		<div class="modal-body">  
				<?php echo $this->settings->open_form(['action' => '']);
                    $configuration = modules::run($plugin.'/'.$plugin.'_config', unserialize($config->config));

                    $configuration[] = [
                        'id' => 'id',
                        'type' => 'hidden',
                        'value' => $config->plugin_id,
                    ];

                    $configuration[] = [
                        'id' => 'system_name',
                        'type' => 'hidden',
                        'value' => $config->system_name,
                    ];

                    $configuration[] = [
                        'id' => 'submit',
                        'type' => 'submit',
                        'label' => 'Save',
                    ];

                    echo $this->settings->build_form_horizontal($configuration);
                    echo $this->settings->close_form();
              ?>
		</div>
		<div class="modal-footer" style="border-top:none;"></div>		
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
