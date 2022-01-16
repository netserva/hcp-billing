<style>
img {max-width: 100%; height: auto;}
  .note-editor.note-frame {
    border: none;
}
</style>
<div class="col-lg-12">
  <section class="panel panel-body">
    <section class="comment-list block">
      <article class="comment-item media" id="comment-form">
          <a class="pull-left thumb-sm avatar">
      <img src="<?php echo User::avatar_url(User::get_id()); ?>" class="img-circle">
      </a>

          <section class="media-body">
            <section class="panel panel-default">
              <?php
              $attributes = 'class="m-b-none"';
              echo form_open(base_url().'companies/comment', $attributes); ?>
                <input type="hidden" name="client_id" value="<?php echo $i->co_id; ?>">
          <textarea class="form-control foeditor-100" name="comment"
          placeholder="<?php echo $i->company_name; ?> <?php echo lang('comment'); ?>" required></textarea>
                <footer class="panel-footer bg-light lter">
                  <button class="btn btn-<?php echo config_item('theme_color'); ?> pull-right btn-sm" type="submit">
                  <i class="fa fa-comments"></i> <?php echo lang('comment'); ?></button>
                  <ul class="nav nav-pills nav-sm">
                  </ul>
                </footer>
              </form>
            </section>
          </section>
      </article>

<?php foreach (Client::has_comments($i->co_id) as $key => $c) {
                  $this->db->where('comment_id', $c->comment_id)->update('comments', ['unread' => 0]); ?>

      <?php $role_label = ('admin' == User::get_role($c->posted_by)) ? 'danger' : 'info'; ?>
        <article id="comment-id-1" class="comment-item">
          <a class="pull-left thumb-sm avatar">

<img src="<?php echo User::avatar_url($c->posted_by); ?>" class="img-circle">

          </a>
          <span class="arrow left"></span>
          <section class="comment-body panel panel-default">
            <header class="panel-heading bg-white">
              <a href="#">
              <?php echo ucfirst(User::displayName($c->posted_by)); ?>
              </a>
              <label class="label bg-<?php echo $role_label; ?> m-l-xs"><?php echo ucfirst(User::get_role($c->posted_by)); ?> </label>
              <span class="text-muted m-l-sm pull-right">
                  <?php echo humanFormat(strtotime($c->date_posted)).' '.lang('ago'); ?>
                <?php
                if ($c->posted_by == User::get_id()) { ?>

                 <a href="<?php echo base_url(); ?>companies/comment/<?php echo $c->comment_id; ?>/delete" data-toggle="ajaxModal" title="<?php echo lang('comment_reply'); ?>"><i class="fa fa-trash-o text-danger"></i>
                 </a>
                <?php } ?>


              </span>
            </header>
            <div class="panel-body">
              <div class="text-dark activate_links"><?php echo nl2br_except_pre($c->message); ?></div>
                <div class="comment-action m-t-sm">



              </div>
            </div>

          </section>
        </article>
      <?php
              } ?>
      <?php if (0 == count(Client::has_comments($i->co_id))) { ?>
        <article id="comment-id-1" class="comment-item">
          <section class="comment-body panel panel-default">
            <div class="panel-body">
              <p><?php echo lang('no_comments_found'); ?></p>
            </div>
          </section>
        </article>
        <?php } ?>
    </section>
  </section>
</div>
