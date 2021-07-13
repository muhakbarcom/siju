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
            <label for="int">Kode Transaksi <?php echo form_error('kode_transaksi') ?></label>
            <input type="text" class="form-control" name="kode_transaksi" id="kode_transaksi" placeholder="Kode Transaksi" value="<?php echo $kode_transaksi; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Jumlah Transaksi <?php echo form_error('jumlah_transaksi') ?></label>
            <input type="text" class="form-control" name="jumlah_transaksi" id="jumlah_transaksi" placeholder="Jumlah Transaksi" value="<?php echo $jumlah_transaksi; ?>" />
        </div>
	    <div class="form-group">
            <label for="char">Nama Transaksi <?php echo form_error('nama_transaksi') ?></label>
            <input type="text" class="form-control" name="nama_transaksi" id="nama_transaksi" placeholder="Nama Transaksi" value="<?php echo $nama_transaksi; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Kode Dtl Transaksi <?php echo form_error('kode_dtl_transaksi') ?></label>
            <input type="text" class="form-control" name="kode_dtl_transaksi" id="kode_dtl_transaksi" placeholder="Kode Dtl Transaksi" value="<?php echo $kode_dtl_transaksi; ?>" />
        </div>
	    <input type="hidden" name="" value="<?php echo $; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('detail_transaksi') ?>" class="btn btn-default">Cancel</a>
	</form>
         </div>
        </div>
    </div>
</div>