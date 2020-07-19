<?php 
$this->title .= ' | Produk';
$this->visited = "semua-produk";
?>

<br><br>
<div class="produk-container row">
	<div class="col-sm-12 col-md-8 mx-auto">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-6">
					<img src="<?=$produk->gambar?>" width="100%">
				</div>
				<div class="col-sm-12 col-md-6">
					<h3><?=$produk->nama?></h3>
					<h4 class="text-success">Rp. <?=number_format($produk->harga_normal)?></h4>
					<div>
						<?php 
							$stars = 5;
							for($i=1;$i <= $stars;$i++) : 
						?>
							<span class="fa fa-star star <?= $rating['rating'] >= $i ? 'checked' :'' ?>"></span>
						<?php endfor ?>
					</div>
					<br>
					<form action="<?=base_url()?>/home/beli/<?=$produk->id?>">
						<div class="form-group">
							<label>Jumlah</label>
							<input type="number" name="jumlah" class="form-control" min="1" value="1">
						</div>
						<button class="btn btn-primary">Beli</button>
					</form>
					<br>
					<p><?=$produk->deskripsi?></p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<hr>
					<h2>Ulasan</h2>
					<?php if(empty($ulasan)){ ?>
						<center><i>Tidak ada ulasan</i></center>
					<?php }else{ ?>
					<table class="table table-bordered">
						<tr>
							<th>#</th>
							<th>Customer</th>
							<th>Ulasan</th>
						</tr>
						<?php $no=1; foreach($ulasan as $u): ?>
						<tr>
							<td><?=$no++?></td>
							<td><?=$u->transaksi()->kustomer()->nama?></td>
							<td>
								<p><?=$u->ulasan?></p>
								<br>
								<span>Rating : <?=$u->rating?></span>
							</td>
						</tr>
						<?php endforeach ?>
					</table>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>