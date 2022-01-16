<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">DomainsCoZa</h4>
		</div> 
		<div class="modal-body">  
		<?php
        $attributes = array('class' => 'bs-example form-horizontal');
        echo form_open('settings/update', $attributes); ?>
                 <input type="hidden" name="settings" value="registrars"> 

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?=lang('domainscoza_live')?></label>
                        <div class="col-lg-8">
                            <label class="switch">
                                <input type="hidden" value="off" name="domainscoza_live" />
                                <input type="checkbox" <?php if(config_item('domainscoza_live') == 'TRUE'){ echo "checked=\"checked\""; } ?> name="domainscoza_live">
                                <span></span>
                            </label>
                        </div>
                    </div>

                      <div class="form-group">
                        <label class="col-lg-4 control-label"><?=lang('domainscoza_apikey')?></label>
                        <div class="col-lg-8">
                            <input type="<?=config_item('demo_mode') == 'TRUE' ? 'password' : 'text';?>" class="form-control" value="<?=config_item('domainscoza_apikey')?>" name="domainscoza_apikey">
                        </div>
                    </div>

                    <div class="line line-dashed line-lg pull-in"></div>
                   
                              
                    <div class="text-center">
                        <button type="submit" class="btn btn-sm btn-<?=config_item('theme_color');?>"><?=lang('save_changes')?></button>
                    </div>
                
        </form>
		</div>
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
