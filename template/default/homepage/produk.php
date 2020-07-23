<?php 
$this->title .= ' | Produk';
$this->visited = "semua-produk";
?>
<h2>Semua Produk</h2>
<div class="produk-container row">
	<?php 
	foreach ($produk as $key => $value) { 
		$rating = [];
		if(!empty($value->transactions()))
		{
			$rating['length'] = 0;
			foreach($value->transactions as $p)
			{
				if($p->rating == "") continue;
				$ulasan[] = $p;
				$rating['rating'] += $p->rating;
				$rating['length'] += 1;
			}

			if($rating['length'] > 0)
				$rating['rating'] /= $rating['length'];

			$rating['rating'] = round($rating['rating']);
		}
	?>
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
				<div>
					<?php 
						$stars = 5;
						for($i=1;$i <= $stars;$i++) : 
					?>
						<span class="fa fa-star star <?= $rating['rating'] >= $i ? 'checked' :'' ?>"></span>
					<?php endfor ?>
				</div>
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