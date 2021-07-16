<div class="row">
    <div class="col-xs-12 col-md-6">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= $button;?> Detail_transaksi</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                    <i class="fa fa-minus"></i></button>
                     <button type="button" class="btn btn-box-tool" onclick="location.reload()" title="Collapse">
              <i class="fa fa-refresh"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="int">Id Barang <?php echo form_error('id_barang') ?></label>
            <input type="text" class="form-control" name="id_barang" id="id_barang" placeholder="Id Barang" value="<?php echo $id_barang; ?>" />
        </div>
	    <div class="form-group">
            <label for="char">Id Transaksi <?php echo form_error('id_transaksi') ?></label>
            <input type="text" class="form-control" name="id_transaksi" id="id_transaksi" placeholder="Id Transaksi" value="<?php echo $id_transaksi; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Quantity <?php echo form_error('quantity') ?></label>
            <input type="text" class="form-control" name="quantity" id="quantity" placeholder="Quantity" value="<?php echo $quantity; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Total <?php echo form_error('total') ?></label>
            <input type="text" class="form-control" name="total" id="total" placeholder="Total" value="<?php echo $total; ?>" />
        </div>
	    <input type="hidden" name="id_dtl_transaksi" value="<?php echo $id_dtl_transaksi; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('detail_transaksi') ?>" class="btn btn-default">Cancel</a>
	</form>
         </div>
        </div>
    </div>
</div>