<?php 
$this->title .= ' | Cek';
$this->visited = "cek";
?>

<div class="produk-container row">
	<div class="col-sm-12 col-md-5 mx-auto">
	<h2>Cek Transaksi</h2>
	<div class="form-group">
		<label>Input Kode Transaksi</label>
		<input type="text" name="kode" id="kode" class="form-control">
	</div>
	<button class="btn btn-primary" onclick="location='<?= base_url()?>/home/detailTransaksi/'+kode.value">Cek Transaksi</button>
	</div>
</div>