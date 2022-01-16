<div class="box">
    <div class="box-header font-bold">
         </div>
              <div class="box-body">

              <?php if ($this->session->flashdata('message')) { ?>
                    <div class="alert alert-info alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $this->session->flashdata('message'); ?>
                    </div>
                <?php } ?>

                <div class="table-responsive" id="registrars">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="table-templates-2" class="table table-striped b-t b-light text-sm AppendDataTables dataTable no-footer">
                                <thead>
                                    <th><?php echo lang('registrar'); ?></th>
                                    <th><?php echo lang('options'); ?></th>
                                </thead>
                                <tbody>
                                    <?php

                                    $registrars = Plugin::domain_registrars();
                                    foreach ($registrars as $registrar) {?> 
                                    <tr>
                                        <td><?php echo ucfirst($registrar->system_name); ?></td>
                                        <td>
                                        <?php echo modules::run($registrar->system_name.'/admin_options', $registrar->system_name); ?> 
                                        </td>
                                    <?php } ?>
                                </tbody>
                            </table> 
                          </div>                          
                    </div> 
              </div>                          
        </div>
 </div>
    