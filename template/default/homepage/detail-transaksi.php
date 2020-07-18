<?php 
$this->title .= ' | Detail Transaksi';
$this->visited = "detail-transaksi";
?>
<?php 
if(!empty($transaksi)): 
	$member = $transaksi->kustomer()->id_pengguna == 0 ? false : $transaksi->kustomer()->id_pengguna;
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

                    $shipping = $transaksi->shipping($transaksi->id_kabupaten,$transaksi->kurir);
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
                        <td><?= $value->produk->nama ?></td>
                        <td width="100px"><?=$value->jumlah?></td>
                        <td style="white-space: nowrap;">Rp. <?= number_format($value->jumlah*$harga) ?></td>
                    </tr>
                    <?php endforeach ?>
                    <tr>
                        <td></td>
                        <td width="100px">
                            <b>Shipping</b>
                        </td>
                        <td>
                        	<?= $transaksi->kustomer->alamat ?>, <?= $shipping->city ?>, <?= $shipping->province ?>, <?= $shipping->name ?>
                        </td>
                        <td width="100px"></td>
                        <td>Rp. <?= number_format($transaksi->ongkir) ?></td>
                    </tr>
                    <tr>
                    	<td></td>
                    	<td></td>
                    	<td></td>
                    	<td><b>Total</b></td>
                    	<td>
                    		<b>Rp. <?=number_format($total+$transaksi->ongkir)?></b>
                    	</td>
                    </tr>
                </tbody>
            </table>

            <h2>Kode Transaksi : <?= $transaksi->kode ?></h2>

            <h4>Status Transaksi</h4>
            <p></p>
            <p>
            	<?php if($transaksi->status == 1 && $transaksi->bukti == ""){ ?>
            	<span class="alert alert-warning">Bukti Transfer Belum dikirim</span>
            	<br><br>
                <?php if(($member && session()->get('id') == $member) || !$member): ?>
            	<form method="post" action="<?=base_url()?>/home/simpanBukti" enctype="multipart/form-data">
            		<input type="hidden" name="id_transaksi" value="<?= $transaksi->id ?>">
            		<div class="form-group">
            			<label>Upload Bukti Transaksi</label>
            			<input type="file" name="bukti" class="form-control" style="height: auto;">
            		</div>
            		<button class="btn btn-primary">Upload Bukti</button>
            	</form>
                <?php endif ?>
            	<?php }elseif($transaksi->status == 1 && $transaksi->bukti != ""){ ?>
            	<span class="alert alert-primary">Bukti Transfer Sudah dikirim</span>
            	<?php }elseif($transaksi->status == 2){ ?>
            	<span class="alert alert-success">Pembayaran Sudah Diterima</span>
            	<?php if($transaksi->resi): ?>
            		<br><br>No Resi : <?=$transaksi->resi?>
            		<br>
            		<a href="<?=base_url()?>/home/terima/<?=$transaksi->kode?>" class="btn btn-primary">Terima Barang</a>
            	<?php endif ?>
            	<?php }elseif($transaksi->status == 3){ ?>
                <span class="alert alert-success">Transaksi Selesai</span>
            <?php }elseif($transaksi->status == 4){ ?>
                <span class="alert alert-danger">Pembayaran Di Tolak</span>
                <?php } ?>
            </p>
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
