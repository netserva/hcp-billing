<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo lang('signups'); ?></h4>
        </div>
            <div class="modal-body">
            <div class="table-responsive">
                            <table id="table-templates-2" class="table table-striped b-t b-light text-sm AppendDataTables">
                                <thead>
                                    <tr>
                                        <th class="w_5 hidden"></th>
                                        <th class="col-date"><?php echo lang('date'); ?></th>
                                        <th class=""><?php echo lang('products_services'); ?></th>
                                        <th class=""><?php echo lang('amount'); ?></th>
                                        <th class=""><?php echo lang('commission'); ?></th>
                                        <th class=""><?php echo lang('payout'); ?></th>
                                        <th class=""><?php echo lang('status'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?php foreach (Affiliate::account($id) as $key => $aff) { ?>
                                    <tr>
                                        <td class="hidden"></td>
                                        <td><?php echo $aff->date; ?></td>
                                        <td><?php echo $aff->item_name; ?></td>
                                        <td><?php echo Applib::format_currency(config_item('default_currency'), $aff->amount); ?>
                                        </td>
                                        <td><?php echo Applib::format_currency(config_item('default_currency'), $aff->commission); ?>
                                        </td>
                                        <td><?php echo 'once' == $aff->type ? lang('once') : lang('recurring'); ?></td>
                                        <td><?php echo lang($aff->status); ?></td>
                                    </tr>
                                    <?php }  ?>
                                </tbody>
                            </table>
                        </div>
        </div>
		<div class="modal-footer"> <a href="#" class="btn btn-default btn-sm" data-dismiss="modal"><?php echo lang('close'); ?></a>
	</form>
	</div>
</div>
</div>
 