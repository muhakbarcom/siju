<!DOCTYPE html>
<html>
<head>
    <title>Tittle</title>
    <style type="text/css" media="print">
    @page {
        margin: 0;  /* this affects the margin in the printer settings */
    }
      table{
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
      }
      table th{
          -webkit-print-color-adjust:exact;
        border: 1px solid;

                padding-top: 11px;
    padding-bottom: 11px;
    background-color: #a29bfe;
      }
   table td{
        border: 1px solid;

   }
        </style>
</head>
<body>
    <h3 align="center">DATA Transaksi</h3>
    <h4>Tanggal Cetak : <?= date("d/M/Y");?> </h4>
    <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Nama Barang</th>
		<th>Harga Barang</th>
		<th>Quantity</th>
		<th>Total Bayar</th>
		<th>Tanggal Penjualan</th>
		<th>Pendapatan</th>
		
            </tr><?php
            foreach ($transaksi_data as $transaksi)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $transaksi->nama_barang ?></td>
		      <td><?php echo $transaksi->harga_barang ?></td>
		      <td><?php echo $transaksi->quantity ?></td>
		      <td><?php echo $transaksi->total_bayar ?></td>
		      <td><?php echo $transaksi->tanggal_penjualan ?></td>
		      <td><?php echo $transaksi->pendapatan ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
</body>
<script type="text/javascript">
      window.print()
    </script>
</html>