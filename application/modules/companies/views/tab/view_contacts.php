<?php declare(strict_types=1);
if (0 == $i->individual) { ?>
    <!-- Client Contacts -->
 
            <table id="table-client-details-1" class="table table-striped b-t b-light text-sm AppendDataTables">
                <thead>
                <tr>
                    <th><?php echo lang('full_name'); ?></th>
                    <th><?php echo lang('email'); ?></th>
                    <th><?php echo lang('mobile_phone'); ?> </th>
                    <th>Skype</th>
                    <th class="col-date"><?php echo lang('last_login'); ?> </th>
                    <th class="col-options no-sort"><?php echo lang('options'); ?></th>
                </tr> </thead> <tbody>
                <?php foreach (Client::get_client_contacts($company) as $key => $contact) { ?>
                    <tr>
                        <td><a class="thumb-sm avatar">
                                <img src="<?php echo User::avatar_url($contact->user_id); ?>" class="img-circle">
                            <?php echo $contact->fullname; ?>
                            </a>
                            </td>
                        <td class="text-info" ><?php echo $contact->email; ?> </td>
                        <td><a href="tel:<?php echo User::profile_info($contact->user_id)->phone; ?>"><b><i class="fa fa-phone"></i></b> <?php echo User::profile_info($contact->user_id)->phone; ?></a></td>
                        <td><a href="skype:<?php echo User::profile_info($contact->user_id)->skype; ?>?call"><?php echo User::profile_info($contact->user_id)->skype; ?></a></td>
                        <?php
                        if ('0000-00-00 00:00:00' == $contact->last_login) {
                            $login_time = '-';
                        } else {
                            $login_time = strftime(config_item('date_format').' %H:%M:%S', strtotime($contact->last_login));
                        } ?>
                        <td><?php echo $login_time; ?> </td>
                        <td>

                            <a href="<?php echo base_url(); ?>companies/send_invoice/<?php echo $contact->user_id; ?>/<?php echo $i->co_id; ?>" class="btn btn-default btn-xs" title="<?php echo lang('email_invoice'); ?>" data-toggle="ajaxModal">
                                <i class="fa fa-envelope"></i> </a>

                            <a href="<?php echo base_url(); ?>companies/make_primary/<?php echo $contact->user_id; ?>/<?php echo $i->co_id; ?>" class="btn btn-default btn-xs" title="<?php echo lang('primary_contact'); ?>" >
                                <i class="fa fa-chain <?php if ($i->primary_contact == $contact->user_id) {
                            echo 'text-danger';
                        } ?>"></i> </a>
                            <a href="<?php echo base_url(); ?>contacts/update/<?php echo $contact->user_id; ?>" class="btn btn-default btn-xs" title="<?php echo lang('edit'); ?>"  data-toggle="ajaxModal">
                                <i class="fa fa-edit"></i> </a>
                            <a href="<?php echo base_url(); ?>users/account/delete/<?php echo $contact->user_id; ?>" class="btn btn-default btn-xs" title="<?php echo lang('delete'); ?>" data-toggle="ajaxModal">
                                <i class="fa fa-trash-o"></i> </a>
                        </td>
                    </tr>
                <?php } ?>



                </tbody>
            </table> 
<?php } ?>
