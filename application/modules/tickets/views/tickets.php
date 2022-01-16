<!-- Start -->
          <div class="box">
            <div class="box-header">
              <div class="btn-group">

              <button class="btn btn-<?php echo config_item('theme_color'); ?> btn-sm">
              <?php
              $view = $_GET['view'] ?? null;

              switch ($view) {
                case 'pending':
                  echo lang('pending');

                  break;

                case 'closed':
                  echo lang('closed');

                  break;

                case 'open':
                  echo lang('open');

                  break;

                case 'resolved':
                  echo lang('resolved');

                  break;

                default:
                  echo lang('filter');

                  break;
              }
              ?></button>
              <button class="btn btn-<?php echo config_item('theme_color'); ?> btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span>
              </button>
              <ul class="dropdown-menu">

              <li><a href="<?php echo base_url(); ?>tickets?view=pending"><?php echo lang('pending'); ?></a></li>
              <li><a href="<?php echo base_url(); ?>tickets?view=closed"><?php echo lang('closed'); ?></a></li>
              <li><a href="<?php echo base_url(); ?>tickets?view=open"><?php echo lang('open'); ?></a></li>
              <li><a href="<?php echo base_url(); ?>tickets?view=resolved"><?php echo lang('resolved'); ?></a></li>
              <li><a href="<?php echo base_url(); ?>tickets"><?php echo lang('all_tickets'); ?></a></li>

              </ul>
              </div> 

              <div class="btn-group pull-right">
              <a href="<?php echo base_url(); ?>tickets/add" class="btn btn-sm btn-warning"><?php echo lang('create_ticket'); ?></a>

              <?php if (!User::is_client()) { ?>
                  <?php if ($archive) { ?>
                <a href="<?php echo base_url(); ?>tickets" class="btn btn-sm btn-primary"><?php echo lang('view_active'); ?></a>
                <?php } else { ?>
              <a href="<?php echo base_url(); ?>tickets?view=archive" class="btn btn-sm btn-primary"><?php echo lang('view_archive'); ?></a> 
              <?php } ?>
              <?php } ?>

                </div>
              </div>

              <div class="box-body">
              <div class="table-responsive">
                <table id="table-tickets<?php echo ($archive) ? '-archive' : ''; ?>" class="table table-striped b-t b-light AppendDataTables">
                  <thead>
                    <tr>
                    <th class="w_5 hidden"></th>
                   <th><?php echo lang('subject'); ?></th>
                   <?php if (User::is_admin() || User::is_staff()) { ?>
                   <th><?php echo lang('reporter'); ?></th>
                    <?php } ?>
                    <th class="col-date"><?php echo lang('date'); ?></th>
                    <th class="col-options no-sort"><?php echo lang('priority'); ?></th>

                      <th class="col-lg-1"><?php echo lang('department'); ?></th>
                      <th class="col-lg-1"><?php echo lang('status'); ?></th>
                      <th><?php echo lang('options'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        $this->load->helper('text');
                        foreach ($tickets as $key => $t) {
                            $s_label = 'default';
                            if ('open' == $t->status) {
                                $s_label = 'danger';
                            }
                            if ('closed' == $t->status) {
                                $s_label = 'success';
                            }
                            if ('resolved' == $t->status) {
                                $s_label = 'primary';
                            } ?>
                    <tr>
                    <td class="hidden"><?php echo $t->id; ?></td>


              <td style="border-left: 2px solid <?php echo ('closed' == $t->status) ? '#1ab394' : '#F8AC59'; ?>;">

              <?php $rep = $this->db->where('ticketid', $t->id)->get('ticketreplies')->num_rows();
                            if (0 == $rep) { ?>

                <a class="text-info <?php echo ('closed' == $t->status) ? 'text-lt' : ''; ?>" href="<?php echo base_url(); ?>tickets/view/<?php echo $t->id; ?>" data-toggle="tooltip" data-title="<?php echo lang('ticket_not_replied'); ?>">
                     <?php } else { ?>
                <a class="text-info <?php echo ('closed' == $t->status) ? 'text-lt' : ''; ?>" href="<?php echo base_url(); ?>tickets/view/<?php echo $t->id; ?>">
                      <?php } ?>

                     <?php echo word_limiter($t->subject, 8); ?>
                     </a><br>
                     <?php if (0 == $rep && 'closed' != $t->status) { ?>
                     <span class="text-danger">Pending for <?php echo Applib::time_elapsed_string(strtotime($t->created)); ?></span>
                     <?php } ?>

                      </td>
                      <?php if (User::is_admin() || User::is_staff()) { ?>

                      <td>
                      <?php
                      if (null != $t->reporter) { ?>
                        <a class="pull-left thumb-sm avatar" data-toggle="tooltip" title="<?php echo User::login_info($t->reporter)->email; ?>" data-placement="right">
                                <img src="<?php echo User::avatar_url($t->reporter); ?>" class="img-rounded radius_6">
                                <?php echo User::displayName($t->reporter); ?>
                          &nbsp;

                            </a>
                      <?php } else {
                          echo 'NULL';
                      } ?>

                      </td>

                      <?php } ?>



                       <td class=""><?php echo date('D, d M g:i:A', strtotime($t->created)); ?><br/>
                      <span class="text-primary">(<?php echo Applib::time_elapsed_string(strtotime($t->created)); ?>)</span>
                       </td>

                      <td>
                      <span class="label label-<?php if ('Urgent' == $t->priority) {
                          echo 'danger';
                      } elseif ('High' == $t->priority) {
                          echo 'warning';
                      } else {
                          echo 'default';
                      } ?>"> <?php echo $t->priority; ?></span>
                      </td>







                      <td class="">
                      <?php echo App::get_dept_by_id($t->department); ?>
                      </td>

                      <td>
                       <?php
                                    switch ($t->status) {
                                        case 'open':
                                            $status_lang = 'open';

                                            break;

                                        case 'closed':
                                            $status_lang = 'closed';

                                            break;

                                        case 'pending':
                                            $status_lang = 'pending';

                                            break;

                                        case 'resolved':
                                            $status_lang = 'resolved';

                                            break;

                                        default:
                                        $status_lang = 'active';

                                            break;
                                    } ?>
                                    <span class="label label-<?php echo $s_label; ?>"><?php echo ucfirst(lang($status_lang)); ?></span> </td>

                                    <td>
                                    <a data-toggle="tooltip" data-original-title="<?php echo lang('view'); ?>" data-placement="top" class="btn btn-success btn-xs" href="<?php echo base_url(); ?>tickets/view/<?php echo $t->id; ?>"><i class="fa fa-eye"></i></a>

                                    <?php if (User::is_admin()) { ?>

                                    <a data-toggle="tooltip" data-original-title="<?php echo lang('edit'); ?>" data-placement="top" class="btn btn-twitter btn-xs" href="<?php echo base_url(); ?>tickets/edit/<?php echo $t->id; ?>"><i class="fa fa-pencil"></i></a>
                                    <a class="btn btn-google btn-xs" href="<?php echo base_url(); ?>tickets/delete/<?php echo $t->id; ?>" data-toggle="ajaxModal" title="<?php echo lang('delete_ticket'); ?>"><i class="fa fa-trash"></i></a></li>
                                        <?php if ($archive) { ?>
                                        <a data-toggle="tooltip" data-original-title="<?php echo lang('move_to_active'); ?>" data-placement="top" class="btn btn-primary btn-xs" href="<?php echo base_url(); ?>tickets/archive/<?php echo $t->id; ?>/0"><i class="fa fa-sign-in"></i></a>
                                        <?php } else { ?>
                                        <a data-toggle="tooltip" data-original-title="<?php echo lang('archive_ticket'); ?>" data-placement="top" class="btn btn-primary btn-xs" href="<?php echo base_url(); ?>tickets/archive/<?php echo $t->id; ?>/1"><i class="fa fa-archive"></i></a>
                                        <?php } ?>
                                    <?php } ?>
                                     </td>

                    </tr>
                    <?php
                        } ?>
                  </tbody>
                </table>
              </div>
       </div>
</div>
          