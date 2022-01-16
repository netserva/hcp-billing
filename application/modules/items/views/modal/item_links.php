<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header bg-success"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title"><?php echo lang('links'); ?></h4>
		</div> 
		<div class="modal-body">
		
			 <?php echo base_url(); ?><strong>cart/options?item=<?php echo $id; ?></strong>

			 <hr>		

			 <h5><?php echo lang('add_to_cart'); ?></h5>
			 <textarea class="form-control" readonly><a href="<?php echo base_url(); ?>cart/options?item=<?php echo $id; ?>"><?php echo lang('add_to_cart'); ?></a></textarea>

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></a>
		 
		</form>
	</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->