<?php declare(strict_types=1);
$info = Ticket::view_by_id($id); ?>
<!--Start -->
 
                <div class="box">
                    <div class="box-header b-b clearfix hidden-print"> 
        
                    <a href="#t_info" class="btn btn-sm btn-twitter btn-responsive" id="info_btn" data-toggle="class:hide"><i class="fa fa-info-circle"></i></a>
                    <?php if (!User::is_client()) { ?>
                        <a href="<?php echo base_url(); ?>tickets/edit/<?php echo $info->id; ?>" class="btn btn-sm btn-warning btn-responsive">
                        <i class="fa fa-pencil"></i> <?php echo lang('edit_ticket'); ?></a>
                    <?php } ?>

                    <div class="btn-group">
                        <button class="btn btn-sm btn-<?php echo config_item('theme_color'); ?> dropdown-toggle btn-responsive" data-toggle="dropdown">
                                                <?php echo lang('change_status'); ?>
                                                <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                    <?php
                                                    $statuses = $this->db->get('status')->result();
                                                    foreach ($statuses as $key => $s) { ?>
                                                    <li><a href="<?php echo base_url(); ?>tickets/status/<?php echo $info->id; ?>/?status=<?php echo $s->status; ?>"><?php echo lang($s->status); ?></a></li>
                                                    <?php } ?>
                                                </ul>
                    </div>
                    <?php if (User::is_admin()) { ?>
                                            <a href="<?php echo base_url(); ?>tickets/delete/<?php echo $info->id; ?>" class="btn btn-sm btn-danger pull-right btn-responsive" data-toggle="ajaxModal">
                                            <i class="fa fa-trash-o"></i> <?php echo lang('delete_ticket'); ?></a>

                    <?php } ?>
 

                    </div>

                    <div class="box-body">


                    <?php
                    $rep = $this->db->where('ticketid', $info->id)->get('ticketreplies')->num_rows();
                    if (0 == $rep and 'closed' != $info->status) { ?>

                <div class="alert alert-success hidden-print">
                        <button type="button" class="close" data-dismiss="alert">×</button> <i class="fa fa-warning"></i>
                        <?php echo lang('ticket_not_replied'); ?>
                    </div>
                <?php } ?>


                        <!-- Start ticket Details -->
                        <div class="row">
                            <section class="">
                                <div class="col-sm-4" id="t_info">


           <?php if (!User::is_client()) { ?>                                
                      
                        <?php echo form_open(base_url().'tickets/quick_edit'); ?>
                        
                        <input type="hidden" name="id" value="<?php echo $info->id; ?>">
                            <div class="form-group">
                            <label><?php echo lang('ticket_code'); ?></label>
                            <input type="text" class="form-control" value="<?php echo $info->ticket_code; ?>" required="" readonly="readonly"> 
                            </div>

                            <div class="form-group">
                            <label><?php echo lang('created'); ?> </label>
                            <input type="text" class="form-control" value="<?php echo strftime(config_item('date_format').' %H:%M', strtotime($info->created)); ?>" required="" readonly="readonly">
                            </div>

                            <div class="form-group">
                            <label><?php echo lang('reporter'); ?> <span class="text-danger">*</span></label>
                            <div class="m-b"> 
                                        <select class="select2-option form-control" name="reporter" required="">
                                        <?php foreach (User::all_users() as $user) { ?>
                                        <option value="<?php echo $user->id; ?>"<?php echo ($info->reporter == $user->id ? ' selected="selected"' : ''); ?>><?php echo User::displayName($user->id); ?></option>
                                        <?php } ?>
                                        </select> 
                                        </div> 

                            </div>
                            <div class="form-group">
                            <label><?php echo lang('department'); ?> <span class="text-danger">*</span></label>
                            <div class="m-b"> 
                                        <select name="department" class="form-control" required="">
                                        <?php $departments = App::get_by_where('departments', ['deptid >' => '0']);
                                            foreach ($departments as $d) { ?>
                                        <option value="<?php echo $d->deptid; ?>"<?php echo ($info->department == $d->deptid ? ' selected="selected"' : ''); ?>><?php echo ucfirst($d->deptname); ?></option>
                                        <?php }  ?>
                                        </select> 
                                </div> 
                            </div>


                            <div class="form-group">
                            <label><?php echo lang('priority'); ?> <span class="text-danger">*</span></label>
                            <div class="m-b"> 
                                        <select name="priority" class="form-control" required="">
                                        <option value="<?php echo $info->priority; ?>"><?php echo lang(strtolower($info->priority)); ?></option>
                                        <?php $priorities = $this->db->get('priorities')->result();
                                            foreach ($priorities as $p) { ?>
                                        <option value="<?php echo $p->priority; ?>"><?php echo lang(strtolower($p->priority)); ?></option>
                                        <?php } ?>
                                        </select> 
                                        </div> 
                            </div>

                            
                            
                            <button type="submit" class="btn btn-sm btn-dark"><?php echo lang('save_changes'); ?></button>
                        </form>

 
                                <?php } else { ?>






                                    <ul class="list-group no-radius small">
                                        <?php
                                        if ('open' == $info->status) {
                                            $s_label = 'danger';
                                        } elseif ('closed' == $info->status) {
                                            $s_label = 'success';
                                        } elseif ('resolved' == $info->status) {
                                            $s_label = 'primary';
                                        } else {
                                            $s_label = 'default';
                                        }
                                        ?>
                                        <li class="list-group-item"><span class="pull-right">#<?php echo $info->ticket_code; ?></span><?php echo lang('ticket_code'); ?></li>
                                        <li class="list-group-item">
                                            <?php echo lang('reporter'); ?>
                                            <span class="pull-right">
                                                <?php if (null != $info->reporter) { ?>
 
                                                    <?php echo User::displayName($info->reporter); ?>
                                               
                                                <?php } else {
                                            echo 'NULL';
                                        } ?>
                                            </span>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right">
                <?php echo App::get_dept_by_id($info->department); ?>
                                            </span><?php echo lang('department'); ?>
                                        </li>
                                    <li class="list-group-item">
                                    <?php
                                    switch ($info->status) {
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
                                            // code...
                                            break;
                                    }?>
                                            <span class="pull-right"><label class="label label-<?php echo $s_label; ?>">
                                            <?php echo ucfirst(lang($status_lang)); ?></label>
                                        </span><?php echo lang('status'); ?>
                                    </li>


                                    <li class="list-group-item"><span class="pull-right"><?php echo $info->priority; ?></span><?php echo lang('priority'); ?></li>

                                    <li class="list-group-item">
                                    <span class="pull-right label label-success" data-toggle="tooltip" data-title="<?php echo $info->created; ?>" data-placement="left">

                        <?php echo strftime(config_item('date_format').' %H:%M', strtotime($info->created)); ?>

                                    </span><?php echo lang('created'); ?>
                                    </li>


                                    <?php
                                    $additional = json_decode($info->additional, true);
                                    if (is_array($additional)) {
                                        foreach ($additional as $key => $value) {
                                            $result = $this->db->where('uniqid', $key)->where('module', 'tickets')->get(Applib::$custom_fields_table);
                                            $row = $result->row_array();
                                            echo '<li class="list-group-item"><span class="pull-right"></span>'.$row['name'].'</li>';
                                        }
                                    }
                                    ?>

                                </ul>


    <?php } ?>
                            </div>
                            <!-- End ticket details-->


<style>
img { max-width: 100%; height: auto; }
</style>


                            <div class="col-sm-8 ticket_body">
                                <strong><?php echo $info->subject; ?></strong>
                                <div class="line line-dashed line-lg pull-in"></div>
                                <div class=""><?php echo nl2br_except_pre($info->body); ?></div>

                                <?php if (null != $info->attachment) {
                                        echo '<div class="line line-dashed line-lg pull-in"></div>';
                                        $files = '';
                                        if (json_decode($info->attachment)) {
                                            $files = json_decode($info->attachment);
                                            foreach ($files as $f) { ?>
                                <a class="label bg-info" href="<?php echo base_url(); ?>resource/attachments/<?php echo $f; ?>" target="_blank"><?php echo $f; ?></a><br>
                                <?php }
                                        } else { ?>
                                <a class="label bg-info" href="<?php echo base_url(); ?>resource/attachments/<?php echo $info->attachment; ?>" target="_blank"><?php echo $info->attachment; ?></a><br>
                                <?php } ?>

                                <?php
                                    } ?>
                                <div class="line line-dashed line-lg pull-in"></div>
                               
                                <section class="comment-list block">
                                    <!-- ticket replies -->
                                    
                                    <?php if (count(Ticket::view_replies($id)) > 0) {
                                        foreach (Ticket::view_replies($id) as $key => $r) {
                                            $role = User::get_role($r->replierid);
                                            $role_label = ('admin' == $role) ? 'danger' : 'info'; ?>
                                    <article id="comment-id-1" class="comment-item" >
                                        <a class="pull-left thumb-sm avatar">
                                           
            <img src="<?php echo User::avatar_url($r->replierid); ?>" class="img-circle" alt="<?php echo User::displayName($r->replierid); ?>">
                                           
                                        </a>
                                        <span class="arrow left"></span>
                                        <section class="comment-body panel panel-default">
                                            <header class="panel-heading bg-white">
                                                <a href="#"><?php echo User::displayName($r->replierid); ?></a>
                                                <label class="label bg-<?php echo $role_label; ?> m-l-xs">
                                                <?php echo ucfirst(User::get_role($r->replierid)); ?></label>
                                                <span class="text-muted m-l-sm pull-right">
                                                    <i class="fa fa-clock-o"></i>

                    <?php echo strftime(config_item('date_format').' %H:%M:%S', strtotime($r->time)); ?>
                          <?php
                        if ('TRUE' == config_item('show_time_ago')) {
                            echo ' - '.Applib::time_elapsed_string(strtotime($r->time));
                        } ?>

                                                </span>
                                            </header>
                                            <div class="panel-body">
                                                <div class="small m-t-sm activate_links">
                                                <?php echo $r->body; ?>
                                                </div>

                                                <?php if (null != $r->attachment) {
                            echo '<div class="line line-dashed line-lg pull-in"></div>';
                            $replyfiles = '';
                            if (json_decode($r->attachment)) {
                                $replyfiles = json_decode($r->attachment);
                                foreach ($replyfiles as $rf) { ?>
                                                <a class="label bg-info" href="<?php echo base_url(); ?>resource/attachments/<?php echo $rf; ?>" target="_blank"><?php echo $rf; ?></a><br>
                                                <?php }
                            } else { ?>
                                                <a href="<?php echo base_url(); ?>resource/attachments/<?php echo $r->attachment; ?>" target="_blank"><?php echo $r->attachment; ?></a><br>
                                                <?php } ?>

                                                <?php
                        } ?>
                                            </div>
                                        </section>
                                    </article>
                                    <?php
                                        }
                                    } else { ?>
                                    <article id="comment-id-1" class="comment-item">
                                        <section class="comment-body panel panel-default">
                                            <div class="panel-body">
                                                <p><?php echo lang('no_ticket_replies'); ?></p>
                                            </div>
                                        </section>
                                    </article>
                                    <?php } ?>


                                    <!-- comment form -->
                                    <article class="comment-item media" id="comment-form">
                                        <a class="pull-left thumb-sm avatar">
                                           
            <img src="<?php echo User::avatar_url(User::get_id()); ?>" class="img-circle">
                                        
                                        </a>
                                        <section class="media-body">
                                            <section class="panel panel-default">
                                                <?php
                                                $attributes = 'class="m-b-none"';
                                                echo form_open_multipart(base_url().'tickets/reply', $attributes); ?>
                                                <input type="hidden" name="ticketid" value="<?php echo $info->id; ?>">
                                                <input type="hidden" name="ticket_code" value="<?php echo $info->ticket_code; ?>">
                                                <input type="hidden" name="replierid" value="<?php echo User::get_id(); ?>">
                                                <textarea required="required" class="form-control textarea" name="reply" rows="3" placeholder="<?php echo lang('ticket'); ?> <?php echo $info->ticket_code; ?> <?php echo lang('reply'); ?>">
                                                </textarea>

                                                <footer class="panel-footer bg-light lter">
                                                    <div id="file_container">
                                                        <input type="file" class="filestyle" data-buttonText="<?php echo lang('choose_file'); ?>" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s" name="ticketfiles[]">
                                                    </div>
                                                    <div class="line line-dashed line-lg pull-in"></div>
                                                    <a href="#" class="btn btn-default btn-xs" id="add-new-file"><?php echo lang('upload_another_file'); ?></a>
                                                    <a href="#" class="btn btn-default btn-xs" id="clear-files"><?php echo lang('clear_files'); ?></a>
                                                    <div class="line line-dashed line-lg pull-in"></div>
                                                    <button class="btn btn-<?php echo config_item('theme_color'); ?> pull-right btn-sm" type="submit"><?php echo lang('reply_ticket'); ?></button>
                                                    <ul class="nav nav-pills nav-sm">
                                                    </ul>
                                                </footer>
                                            </form>
                                        </section>
                                    </section>
                                </article>

                                <!-- End ticket replies -->
                            </section>
                        </div>
                        <!-- End details -->
                     </div>
                 </div>
                <!-- End display details -->
 
     

            <script type="text/javascript">
                (function($){
    	    	"use strict";
                    $('#clear-files').on('click', function(){
                    $('#file_container').html(
                    "<input type='file' class='filestyle' data-buttonText='<?php echo lang('choose_file'); ?>' data-icon='false' data-classButton='btn btn-default' data-classInput='form-control inline input-s' name='ticketfiles[]'>"
                    );
                    });
                    $('#add-new-file').on('click', function(){
                    $('#file_container').append(
                    "<input type='file' class='filestyle' data-buttonText='<?php echo lang('choose_file'); ?>' data-icon='false' data-classButton='btn btn-default' data-classInput='form-control inline input-s' name='ticketfiles[]'>"
                    );
                    });
                    $('#info_btn').on('click', function(){
                        var st = $( ".ticket_body" ).attr( "class" );

                        if (st == 'col-sm-8 ticket_body' || st == 'ticket_body col-sm-8') {
                            $('.ticket_body').removeClass("col-sm-8");
                            $('.ticket_body').addClass("col-sm-12");
                        }else{
                            $('.ticket_body').addClass("col-sm-8");
                            $('.ticket_body').removeClass("col-sm-12");
                        }
                    });
                })(jQuery);  
            </script>
        