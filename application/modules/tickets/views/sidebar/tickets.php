<ul class="nav">
<?php foreach ($tickets as $key => $t) {
    if ('open' == $t->status) {
        $s_label = 'danger';
    } elseif ('closed' == $t->status) {
        $s_label = 'success';
    } elseif ('resolved' == $t->status) {
        $s_label = 'primary';
    } else {
        $s_label = 'default';
    } ?>
		<li class="b-b b-light <?php if ($t->id == $this->uri->segment(3)) {
        echo 'bg-light dk';
    } ?>">
			<a href="<?php echo base_url(); ?>tickets/view/<?php echo $t->id; ?>"><?php echo $t->ticket_code; ?>
				<div class="pull-right">

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
                                            // code...
                                            break;
                                    } ?>

					<?php if ('closed' == $t->status) {
                                        $label = 'success';
                                    } else {
                                        $label = 'danger';
                                    } ?>

					<span class="label label-<?php echo $s_label; ?>"><?php echo ucfirst(lang($status_lang)); ?> </span>

					</div> <br>
				<small class="block small text-muted">
				<?php if (null != $t->reporter) { ?>
				<?php echo ucfirst(User::displayName($t->reporter)); ?>
					<?php } else {
                                        echo 'NULL';
                                    } ?>
					<span class="pull-right"><?php echo strtolower(Applib::time_elapsed_string(strtotime($t->created))); ?></span>
				</small>
								</a>
								</li>
		<?php
} ?>
</ul>
