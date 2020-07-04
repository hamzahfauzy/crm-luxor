<?php 
$this->title .= ' | Produk';
$this->visited = "semua-produk";
?>
<h2>Semua Produk</h2>
<div class="produk-container row">
	<?php foreach ($produk as $key => $value) { ?>
	<div class="col-sm-12 col-md-3">
		<div class="produk-item">
			<div class="produk-img">
				<img src="<?=$value->gambar?>">
			</div>
			<div class="produk-deskripsi">
				<center>
				<b><?= $value->nama ?></b><br>
				<span>Rp. <?=number_format($value->harga_normal)?></span><br>
				<span>Stok : <?=$value->jumlah?></span><br>
				<?php if($value->jumlah): ?>
				<a href="<?=base_url()?>/home/beli/<?=$value->id?>" class="btn btn-success btn-block">Beli</a>
				<?php else: ?>
				<button class="btn btn-default">Barang Tidak Tersedia</button>
				<?php endif ?>
				<a href="<?=base_url()?>/home/detail/<?=$value->id?>" class="btn btn-warning btn-block">Detail</a>
				</center>
			</div>
		</div>
	</div>
	<?php } ?>
</div>