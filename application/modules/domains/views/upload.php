 <div class="box">
     <div class="box-header">
          <h3><?lang('import')?></h3>   
          <p>
          <small><?php echo lang('whmcs_export_domains'); ?><br/> <?php echo lang('select_all_whmcs'); ?></small>
          </p>       
     </div>
                <div class="box-body">
                <div class="container">

                <?php if ($this->session->flashdata('message')) { ?>
                    <div class="alert alert-info alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $this->session->flashdata('message'); ?>
                    </div>
                <?php } ?>
              
                <?php
             $attributes = ['class' => 'bs-example form-horizontal', 'enctype' => 'multipart/form-data'];
          echo form_open(base_url().'domains/upload', $attributes); ?> 
                    
                    <input type="hidden" name="nothing" value="">

                    <div class="form-group"> 
                       <input type="file" name="import">
                   </div>

                   
                   <div class="form-group">
                        <input type="submit" class="btn btn-warning" value="<?php echo lang('upload'); ?>">
                   </div>
                </form>
              </div>                          
         </div>
 </div>
    