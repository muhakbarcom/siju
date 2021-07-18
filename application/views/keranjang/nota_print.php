<div>
    <div><center>TOKO FADJAR COY<br>
Menjual bahan & peralatan tani<br>
Jl.Agussalim n0.37 Padangsidimpuan</center>
</div>
    <div>
        <table class="table">
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td> id_transaksi</td>
                <td>:</td>
                <td><?php echo $id_transaksi?></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td>tanggal_transaksi</td>
                <td>:</td>
                <td><?php echo $tanggal_transaksi?></td>
                <td colspan="2"></td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <th>Nama barang</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
            <?php foreach ($detail as $d):?>
            
                <?php $barang=$this->db->query("select * from barang where id_barang=$d->id_barang")->row(); 
                $nama_barang=$barang->nama_barang;
                $harga_barang=$barang->harga_barang;
                ?>
            <tr>
                <td><?php echo $nama_barang?></td>
                <td><?php echo $d->quantity ?></td>
                <td><?php echo $harga_barang ?></td>
                <td><?php echo $d->total ?></td>
            </tr>
             <?php endforeach; ?>
            <br>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            <td>Total bayar: <?php echo $total_bayar?> </td>
            </tr>
        </table>
         </div>
    
</div>
<script>
    window.print();
</script>