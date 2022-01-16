<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Namecheap</h4>
		</div> 
		<div class="modal-body">  
		<?php
        $attributes = array('class' => 'bs-example form-horizontal');
        echo form_open('settings/update', $attributes); ?>
                 <input type="hidden" name="settings" value="registrars"> 

                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?=lang('namecheap_live')?></label>
                        <div class="col-lg-8">
                            <label class="switch">
                                <input type="hidden" value="off" name="namecheap_live" />
                                <input type="checkbox" <?php if(config_item('namecheap_live') == 'TRUE'){ echo "checked=\"checked\""; } ?> name="namecheap_live">
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label">Namecheap <?=lang('username')?></label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" value="<?=config_item('namecheap_username')?>" name="namecheap_username">
                        </div>
                    </div>
 
                    <div class="form-group">
                        <label class="col-lg-4 control-label"><?=lang('namecheap_apikey')?></label>
                        <div class="col-lg-8">
                            <input type="<?=config_item('demo_mode') == 'TRUE' ? 'password' : 'text';?>" class="form-control" value="<?=config_item('namecheap_apikey')?>" name="namecheap_apikey">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label">IP</label>
                        <div class="col-lg-8">
                            <input type="test" class="form-control" value="<?=config_item('namecheap_ip')?>" name="namecheap_ip">
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
