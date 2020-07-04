<?php 
$this->title .= ' | Detail Transaksi';
$this->visited = "detail-transaksi";
?>
<?php 
if(!empty($transaksi)): 
	$member = $transaksi->kustomer()->id_pengguna == 0 ? false : 1;
?>
<div class="">
    <div class="row">
        <div class="col-sm-6">
        	<h2>Detail Transaksi</h2>
            <table class="table table-bordered table-striped table-kategori">
                <thead>
                    <tr>
                        <th width="20px">#</th>
                        <th></th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    $total = 0;
                    $total_poin = 0;
                    foreach($transaksi->items as $key => $value):
                    	$value->produk(); 
                    	$harga = $member ? $value->produk->harga_member : $value->produk->harga_normal;
                    	$total += ($value->jumlah*$harga);
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td width="100px">
                        	<img src="<?= $value->produk->gambar ?>" width="100%">
                        </td>
                        <td>
                        	<?= $value->produk->nama ?>
                        </td>
                        <td width="100px"><?=$value->jumlah?></td>
                        <td style="white-space: nowrap;">Rp. <?= number_format($value->jumlah*$harga) ?></td>
                    </tr>
                    <tr>
                    	<td></td>
                    	<td colspan="4">
                    		<?php if($value->rating == "" && $value->ulasan == ""){ ?>
                    		<form method="post" action="<?=base_url()?>/home/simpanUlasan">
                        		<input type="hidden" name="id" value="<?=$value->id?>">
                        		<div class="form-group">
                        			<label>Ulasan</label>
                        			<textarea class="form-control" name="ulasan" required=""></textarea>
                        		</div>
                        		<div class="form-group">
                        			<label>Rating</label>
                        			<select class="form-control" name="rating" required="">
                        				<option value="">- Pilih Rating -</option>
                        				<option value="1">1</option>
                        				<option value="2">2</option>
                        				<option value="3">3</option>
                        				<option value="4">4</option>
                        				<option value="5">5</option>
                        			</select>
                        		</div>
                        		<button class="btn btn-primary">Simpan Ulasan</button>
                        	</form>
	                        <?php }else{ ?>
	                        Ulasan : <?= $value->ulasan ?><br>
	                        Rating : <?= $value->rating ?>
	                        <?php } ?>
                    	</td>
                    </tr>
                    <?php endforeach ?>
                    <tr>
                        <td></td>
                        <td width="100px">
                        	<b>Shipping</b>
                        </td>
                        <td>
                        	<?= $transaksi->kustomer->alamat ?>, <?= $transaksi->kurir()->shipping()->nama ?>, <?= $transaksi->kurir->nama ?>
                        </td>
                        <td width="100px"></td>
                        <td>Rp. <?= number_format($transaksi->kurir->harga_kirim) ?></td>
                    </tr>
                    <tr>
                    	<td></td>
                    	<td></td>
                    	<td></td>
                    	<td><b>Total</b></td>
                    	<td>
                    		<b>Rp. <?=number_format($total+$transaksi->kurir->harga_kirim)?></b>
                    	</td>
                    </tr>
                </tbody>
            </table>

            <h2>Kode Transaksi : <?= $transaksi->kode ?></h2>
        </div>
        <div class="col-sm-12 col-md-6">
        	<h2>Kustomer Detail</h2>
        	<div class="form-group">
        		<label>Nama Lengkap</label>
        		<input type="text" readonly="" value="<?= $transaksi->kustomer->nama ?>" class="form-control">
        	</div>
        	<div class="form-group">
        		<label>Alamat</label>
        		<input type="text" readonly="" value="<?= $transaksi->kustomer->alamat ?>" class="form-control">
        	</div>
        	<div class="form-group">
        		<label>Jenis Kelamin</label>
        		<input type="text" readonly="" value="<?= $transaksi->kustomer->jenis_kelamin ?>" class="form-control">
        	</div>
        	<div class="form-group">
        		<label>Email</label>
        		<input type="text" readonly="" value="<?= $transaksi->kustomer->email ?>" class="form-control">
        	</div>
        	<div class="form-group">
        		<label>No. HP</label>
        		<input type="text" readonly="" value="<?= $transaksi->kustomer->no_hp ?>" class="form-control">
        	</div>
        </div>
    </div>
</div>
<?php else: ?>
<center><i>Tidak ada data</i></center>
<?php endif ?>
