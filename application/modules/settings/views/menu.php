               <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs" role="tablist">
                    <li><a class="active" data-toggle="tab" href="#tab-admin"><?php echo lang('admin'); ?></a></li>
                    <li><a data-toggle="tab" href="#tab-staff"><?php echo lang('staff'); ?></a></li>
                    <li><a data-toggle="tab" href="#tab-client"><?php echo lang('client'); ?></a></li>
                </ul>
                <div class="tab-content tab-content-fix">
                    <div class="tab-pane fade in active" id="tab-admin">
                        <div class="table-responsive">
                          <table id="menu-admin" class="table table-striped b-t b-light table-menu sorted_table">
                            <thead>
                                    <tr>
                                    <th></th>
                                    <th class="col-xs-2"><?php echo lang('icon'); ?></th>
                                    <th class="col-xs-8"><?php echo lang('menu'); ?></th>
                                    <th class="col-xs-2"><?php echo lang('visible'); ?></th>
                                    </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($admin as $adm) { ?>
                                <tr class="sortable" data-module="<?php echo $adm->module; ?>" data-access="1">
                                    <td class="drag-handle"><i class="fa fa-reorder"></i></td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-default iconpicker-component" type="button"><i class="fa <?php echo $adm->icon; ?> fa-fw"></i></button>
                                            <button data-toggle="dropdown" data-selected="<?php echo $adm->icon; ?>" class="menu-icon icp icp-dd btn btn-default dropdown-toggle" type="button" aria-expanded="false" data-role="1" data-href="<?php echo base_url(); ?>settings/hook/icon/<?php echo $adm->module; ?>">
                                                <span class="caret"></span>
                                            </button>
                                            <div class="dropdown-menu iconpicker-container"></div>
                                        </div>                                        
                                    </td>
                                    <td><?php echo lang($adm->name); ?></td>
                                    <td>
                                        <a data-rel="tooltip" data-original-title="<?php echo lang('toggle'); ?>" class="menu-view-toggle btn btn-xs btn-<?php echo (1 == $adm->visible ? 'success' : 'default'); ?>" href="#" data-role="1" data-href="<?php echo base_url(); ?>settings/hook/visible/<?php echo $adm->module; ?>"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                          </table>
                        </div>
                    </div>
                    <div class="tab-pane fade in" id="tab-staff">
                        <div class="table-responsive">
                          <table id="menu-staff" class="table table-striped b-t b-light table-menu sorted_table">
                            <thead>
                                    <tr>
                                        <th></th>
                                        <th class="col-xs-2"><?php echo lang('icon'); ?></th>
                                        <th class="col-xs-3"><?php echo lang('menu'); ?></th>
                                        <th class="col-xs-5"><?php echo lang('permission'); ?></th>
                                        <th class="col-xs-2"><?php echo lang('options'); ?></th>
                                    </tr>
                            </thead>
                            <tbody>
                              <?php foreach ($staff as $sta) { ?>
                              <tr class="sortable" data-module="<?php echo $sta->module; ?>" data-access="3">
                                  <td class="drag-handle"><i class="fa fa-reorder"></i></td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-default iconpicker-component" type="button"><i class="fa <?php echo $sta->icon; ?> fa-fw"></i></button>
                                            <button data-toggle="dropdown" data-selected="<?php echo $sta->icon; ?>" class="menu-icon icp icp-dd btn btn-default dropdown-toggle" type="button" aria-expanded="false" data-role="3" data-href="<?php echo base_url(); ?>settings/hook/icon/<?php echo $sta->module; ?>">
                                                <span class="caret"></span>
                                            </button>
                                            <div class="dropdown-menu iconpicker-container"></div>
                                        </div>                                        
                                    </td>
                                    <td><?php echo lang($sta->name); ?></td>
                                    <?php if ('' != $sta->permission) { ?>
                                        <td><?php echo lang('permission_required'); ?></td>
                                    <?php } else { ?>
                                        <td></td>
                                    <?php }?>
                                        <td>
                                            <a data-rel="tooltip" data-original-title="<?php echo lang('toggle'); ?>" class="menu-view-toggle btn btn-xs btn-<?php echo (1 == $sta->visible ? 'success' : 'default'); ?>" href="#" data-role="3" data-href="<?php echo base_url(); ?>settings/hook/visible/<?php echo $sta->module; ?>"><i class="fa fa-eye"></i></a>
                                        </td>
                              </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                    </div>
                    <div class="tab-pane fade in" id="tab-client">
                        <div class="table-responsive">
                            <table id="menu-client" class="table table-striped b-t b-light table-menu sorted_table">
                            <thead>
                                    <tr>
                                        <th></th>
                                        <th class="col-xs-2"><?php echo lang('icon'); ?></th>
                                        <th class="col-xs-3"><?php echo lang('menu'); ?></th>
                                        <th class="col-xs-5"><?php echo lang('permission'); ?></th>
                                        <th class="col-xs-2"><?php echo lang('options'); ?></th>
                                    </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($client as $cli) { ?>
                              <tr class="sortable" data-module="<?php echo $cli->module; ?>" data-access="2">
                                  <td class="drag-handle"><i class="fa fa-reorder"></i></td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-default iconpicker-component" type="button"><i class="fa <?php echo $cli->icon; ?> fa-fw"></i></button>
                                            <button data-toggle="dropdown" data-selected="<?php echo $cli->icon; ?>" class="menu-icon icp icp-dd btn btn-default dropdown-toggle" type="button" aria-expanded="false" data-role="2" data-href="<?php echo base_url(); ?>settings/hook/icon/<?php echo $cli->module; ?>">
                                                <span class="caret"></span>
                                            </button>
                                            <div class="dropdown-menu iconpicker-container"></div>
                                        </div>                                        
                                    </td>
                                    <td><?php echo lang($cli->name); ?></td>
                                    <?php if ('' != $cli->permission) { ?>
                                        <td><?php echo lang('permission_required'); ?></td>
                                    <?php } else { ?>
                                        <td></td>
                                    <?php }?>
                                        <td>
                                            <a data-rel="tooltip" data-original-title="<?php echo lang('toggle'); ?>" class="menu-view-toggle btn btn-xs btn-<?php echo (1 == $cli->visible ? 'success' : 'default'); ?>" href="#" data-role="2" data-href="<?php echo base_url(); ?>settings/hook/visible/<?php echo $cli->module; ?>"><i class="fa fa-eye"></i></a>
                                        </td>
                              </tr>
                                <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                </div>
              </div>
 