        <?php echo form_open('pages/delete_multi'); ?>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="box">
                    <div class="box-body">
                        <button type="submit" onClick="javascript:return confirm('<?php echo lang('delete_confirm_msg'); ?>');"
                            class="btn btn-danger btn-sm delete_multi"><i class="fa fa-trash"></i>
                            <?php echo lang('delete_selected'); ?></button>
                        <a href="<?php echo base_url(); ?>pages/edit" class="btn btn-sm btn-success pull-right"><i
                                class="fa fa-plus"></i> <?php echo lang('new_page'); ?></a>
                        <table id="pages" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center no-padding no-margin" style="vertical-align: middle;">
                                        <div class="pretty info smooth">
                                            <input type="checkbox" name="checkAll" id="dt-select-all" value="1">
                                        </div>
                                    </th>
                                    <th><?php echo lang('title'); ?></th>
                                    <th><?php echo lang('type'); ?></th>
                                    <th><?php echo lang('status'); ?></th>
                                    <th><span class="nobr"><?php echo lang('action'); ?></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pages as $page) { ?>
                                <tr>
                                    <td class="text-center"><?php echo post_id($page); ?></td>
                                    <td><a href="<?php echo post_url($page); ?>" target="_blank"><?php echo post_title($page); ?></a></td>
                                    <td>
                                    <?php if (1 == $page->faq) {
    echo '<span class="label label-default">'.lang('faq').'</span>';
}?>
                                    <?php if (1 == $page->knowledge) {
    echo '<span class="label label-default">'.lang('knowledgebase').'</span>';
}?>
                                    <?php if (0 == $page->faq && 0 == $page->knowledge) {
    echo '<span class="label label-default">'.lang('page').'</span>';
}?>
                                     </td>
                                    <td><?php echo 1 == post_status($page) ? '<span class="label label-success" data-toggle="tooltip" data-title="'.lang('active').'">'.lang('active').'</span>' : '<span class="label label-danger" data-toggle="tooltip" data-title="'.lang('hidden').'">'.lang('hidden').'</span>'; ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo base_url('pages/edit/'.post_id($page)); ?>"
                                            class="btn btn-info btn-xs" data-toggle="tooltip"
                                            data-title="<?php echo lang('edit'); ?>"><i class="fa fa-pencil"></i>
                                            <?php echo lang('edit'); ?></a>
                                        <a onClick="javascript:return confirm('<?php echo lang('delete_confirm'); ?>');"
                                            href="<?php echo base_url('pages/delete/'.post_id($page)); ?>"
                                            class="btn btn-xs btn-danger" data-toggle="tooltip"
                                            data-title="<?php echo lang('delete'); ?>"><i class="fa fa-trash"></i>
                                            <?php echo lang('delete'); ?></a>
                                    </td>
                                </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>