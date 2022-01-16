<?php declare(strict_types=1);
$content = $content[0]; ?>
<div class="row">
    <!-- Form start -->
    <?php echo form_open_multipart(); ?>

    <div class="col-md-9 col-sm-12">
        <div class="box">
            <div class="box-body">
                <div class="form-group">
                    <label><?php echo lang('title'); ?></label>
                    <?php echo form_input('title', set_value('title', $content->title ?? ''), ['class' => 'form-control', 'id' => 'titleInput']); ?>
                    <?php echo form_error('title', '<p class="text-danger">', '</p>'); ?>
                </div><!-- /.form-group -->
                <div class="form-group">
                    <label><?php echo lang('slug'); ?></label>
                    <?php echo form_input('slug', set_value('slug', $content->slug ?? ''), ['class' => 'form-control', 'id' => 'slugInput']); ?>
                    <?php echo form_error('slug', '<p class="text-danger">', '</p>'); ?>
                </div><!-- /.form-group -->
                <div class="form-group">
                    <label><?php echo lang('body'); ?></label>
                    <?php echo form_textarea('body', set_value('body', $content->body ?? '', false), ['class' => 'form-control foeditor', 'id' => 'body']); ?>
                    <?php echo form_error('body', '<p class="text-danger">', '</p>'); ?>
                </div><!-- /.form-group -->

                <hr>
                <div class="box collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo lang('page_seo'); ?></h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">

                        <div class="form-group">
                            <label><?php echo lang('meta_title'); ?></label>
                            <?php echo form_input('meta_title', set_value('meta_title', $content->meta_title ?? ''), ['class' => 'form-control', 'placeholder' => lang('use_page_title')]); ?>
                            <?php echo form_error('meta_title', '<p class="text-danger">', '</p>'); ?>
                        </div><!-- /.form-group -->

                        <div class="form-group">
                            <label><?php echo lang('meta_desc'); ?></label>
                            <?php echo form_textarea([
                                'name' => 'meta_desc',
                                'id' => 'notes',
                                'value' => set_value($content->meta_desc ?? ''),
                                'rows' => '3',
                                'class' => 'form-control',
                                'placeholder' => lang('use_site_desc'),
                            ]); ?>
                            <?php echo form_error('meta_desc', '<p class="text-danger">', '</p>'); ?>
                        </div><!-- /.form-group -->
                    </div>
                </div>


            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col-md8 -->

    <div class="col-md-3 col-sm-12">


        <!-- page settings -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo lang('page').' '.lang('settings'); ?></h3>
                <div class="box-tools pull-right">
                    <!-- Buttons, labels, and many other things can be placed here! -->
                    <!-- Here is a label for example -->
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i
                            class="fa fa-minus"></i></button>
                </div><!-- /.box-tools -->
            </div><!-- /.box-header -->
            <div class="box-body">


                <div class="row">
                    <label class="col-md-6"><?php echo lang('publish'); ?></label>
                    <div class="col-md-6">
                        <label class="switch">
                            <input type="hidden" value="off" name="status" />
                            <input type="checkbox" <?php if (isset($content->status) && 1 == $content->status) {
                            echo 'checked="checked"';
                        } ?>
                                name="status">
                            <span></span>
                        </label>
                    </div>
                </div>

                <div class="row">
                    <label class="col-md-6"><?php echo lang('right_sidebar'); ?></label>
                    <div class="col-md-6">
                        <label class="switch">
                            <input type="hidden" value="off" name="sidebar_right" />
                            <input type="checkbox"
                                <?php if (isset($content->sidebar_right) && 1 == $content->sidebar_right) {
                            echo 'checked="checked"';
                        } ?>
                                name="sidebar_right">
                            <span></span>
                        </label>
                    </div>
                </div>


                <div class="row">
                    <label class="col-md-6"><?php echo lang('left_sidebar'); ?></label>
                    <div class="col-md-6">
                        <label class="switch">
                            <input type="hidden" value="off" name="sidebar_left" />
                            <input type="checkbox"
                                <?php if (isset($content->sidebar_left) && 1 == $content->sidebar_left) {
                            echo 'checked="checked"';
                        } ?>
                                name="sidebar_left">
                            <span></span>
                        </label>
                    </div>
                </div>



                <div class="row">
                    <label class="col-md-6"><?php echo lang('show_in_menu'); ?></label>
                    <div class="col-md-6">
                        <select name="menu" class="form-control">
                            <option value="0"><?php echo lang('none'); ?></option>
                            <?php foreach ($menu_groups as $menu) { ?>
                            <option value="<?php echo $menu->id; ?>" <?php echo (isset($content->menu) && $menu->id == $content->menu) ? 'selected' : ''; ?>>
                                <?php echo $menu->title; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

            </div><!-- /.box-body -->
        </div><!-- /.box -->


        <div class="box collapsed-box box-success">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo lang('faq_block'); ?></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i
                            class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="box-body">


                <div class="row">
                    <label class="col-md-6"><?php echo lang('display'); ?></label>
                    <div class="col-md-6">
                        <label class="switch">
                            <input type="hidden" value="off" name="faq" />
                            <input type="checkbox" <?php if (isset($content->faq) && 1 == $content->faq) {
                            echo 'checked="checked"';
                        } ?>
                                name="faq">
                            <span></span>
                        </label>
                    </div>
                </div>


                <label><?php echo lang('category'); ?></label>
                <select name="faq_id" class="form-control">
                    <option value="0"><?php echo lang('none'); ?></option>
                    <?php
                        $categories = $this->db->where('parent', 6)->get('categories')->result();
                        if (!empty($categories)) {
                            foreach ($categories as $key => $c) {  ?>
                               <option value="<?php echo $c->id; ?>" <?php echo (isset($content->faq_id) && $c->id == $content->faq_id) ? 'selected' : ''; ?>>
                        <?php echo $c->cat_name; ?></option>
                      <?php }
                        } ?>
                </select>

            </div><!-- /.box-body -->
        </div><!-- /.box -->




        <div class="box collapsed-box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo lang('knowledgebase'); ?></h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i
                            class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="box-body">


                <div class="row">
                    <label class="col-md-6"><?php echo lang('display'); ?></label>
                    <div class="col-md-6">
                        <label class="switch">
                            <input type="hidden" value="off" name="knowledge" />
                            <input type="checkbox" <?php if (isset($content->knowledge) && 1 == $content->knowledge) {
                            echo 'checked="checked"';
                        } ?>
                                name="knowledge">
                            <span></span>
                        </label>
                    </div>
                </div>

                <label><?php echo lang('category'); ?></label>
                <select name="knowledge_id" class="form-control">
                    <option value="0"><?php echo lang('none'); ?></option>
                    <?php
                        $categories = $this->db->where('parent', 7)->get('categories')->result();
                        if (!empty($categories)) {
                            foreach ($categories as $key => $c) {  ?>
                               <option value="<?php echo $c->id; ?>" <?php echo (isset($content->knowledge_id) && $c->id == $content->knowledge_id) ? 'selected' : ''; ?>>
                        <?php echo $c->cat_name; ?></option>
                      <?php }
                        } ?>
                </select>

                <br/>

                <div class="form-group">
                    <label>Video URL</label>
                    <?php echo form_input('video', set_value('video', $content->video ?? ''), ['class' => 'form-control', 'placeholder' => 'https://www.youtube.com/embed/QJHqLJLQLQ8']); ?> 
                </div><!-- /.form-group -->

            </div><!-- /.box-body -->
        </div><!-- /.box -->



        <!-- Custom options -->
        <div class="box">


            <div class="box-body">
                <hr>
                <button type="submit" class="btn btn-success btn-block"><i class="fa fa-save"></i>
                    <?php echo lang('save'); ?></button>

            </div><!-- /.box-body -->
        </div><!-- /.box -->



    </div><!-- /.col-md-4 -->

    <!-- Form close -->
    <?php echo form_close(); ?>

</div><!-- /.row -->
<script>
$('#titleInput').on('keyup', function() {
    var path = $(this).val();
    path = path.replace(/ /g, "_").replace("/", "_").toLowerCase();
    $('#slugInput').val(path);
});
</script>