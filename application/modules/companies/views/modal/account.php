<div class="modal-dialog">
    <div class="modal-content">
            <?php if ('hosting' == $type) { ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button> 
            <h4 class="modal-title"><?php echo lang('hosting_account'); ?></h4>
        </div>
        <div class="modal-body">
            <ul class="list-group no-radius">
                <li class="list-group-item">
                    <span class="pull-right">
                        <?php echo $client->hosting_company; ?>
                    </span>
                    <?php echo lang('hosting_company'); ?>
                </li>
                <li class="list-group-item">
                    <span class="pull-right">
                        <?php echo $client->hostname; ?>
                    </span>
                    <?php echo lang('hostname'); ?>
                </li>
                <li class="list-group-item">
                    <span class="pull-right">
                        <?php echo $client->account_username; ?>
                    </span>
                    <?php echo lang('account_username'); ?>
                </li>
                <li class="list-group-item">
                    <span class="pull-right">
                        <?php echo $client->account_password; ?>
                    </span>
                    <?php echo lang('account_password'); ?>
                </li>
                <li class="list-group-item">
                    <span class="pull-right">
                        <?php echo $client->port; ?>
                    </span>
                    <?php echo lang('port'); ?>
                </li>
            </ul>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
        </div>
            <?php } ?>
            <?php if ('bank' == $type) { ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button> 
            <h4 class="modal-title"><?php echo lang('bank_account'); ?></h4>
        </div>
        <div class="modal-body">
            <ul class="list-group no-radius">
                <li class="list-group-item">
                    <span class="pull-right">
                        <?php echo $client->bank; ?>
                    </span>
                    <?php echo lang('bank'); ?>
                </li>
                <li class="list-group-item">
                    <span class="pull-right">
                        <?php echo $client->bic; ?>
                    </span>
                    SWIFT/BIC
                </li>
                <li class="list-group-item">
                    <span class="pull-right">
                        <?php echo $client->sortcode; ?>
                    </span>
                    Sort Code
                </li>
                <li class="list-group-item">
                    <span class="pull-right">
                        <?php echo $client->account_holder; ?>
                    </span>
                    <?php echo lang('account_holder'); ?>
                </li>
                <li class="list-group-item">
                    <span class="pull-right">
                        <?php echo $client->account; ?>
                    </span>
                    <?php echo lang('account'); ?>
                </li>
                <li class="list-group-item">
                    <span class="pull-right">
                        <?php echo $client->iban; ?>
                    </span>
                    IBAN
                </li>
            </ul>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
        </div>
            <?php } ?>
</div>
</div>