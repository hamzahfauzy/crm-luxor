<?php 
$this->title .= " | Edit Produk"; 
$this->visited = "kategori";

$this->js = [
    asset('js/sweetalert2@9.js'),
    asset('js/sweetalert2.min.js'),
];
?>
<link rel="stylesheet" href="<?= asset('css/wordpress-admin.css') ?>">
<div class="">
    <div class="row">
        <div class="col-sm-12 col-md-4 mx-auto">
        	<h2>Edit Produk</h2>
            <form method="post" enctype="multipart/form-data">
            	<?php if($msg): ?>
            	<div class="alert alert-success"><?= $msg ?></div>
            	<?php endif ?>
            	<div class="form-group">
            		<label>Nama Produk</label>
            		<input type="text" name="nama" class="form-control" value="<?=$produk->nama?>" required>
            	</div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select class="form-control" name="id_kategori" required="">
                        <option value="">- Pilih -</option>
                        <?php foreach($kategori as $value): ?>
                        <option value="<?=$value->id?>" <?=$produk->id_kategori == $value->id ? 'selected' : ''?>><?=$value->nama?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea class="form-control" required name="deskripsi"><?=$produk->deskripsi?></textarea>
                </div>
                <div class="form-group">
                    <label>Berat (Kg)</label>
                    <input type="text" name="berat" class="form-control" value="<?=$produk->berat?>" required>
                </div>
                <div class="form-group">
                    <label>Harga Normal</label>
                    <input type="text" name="harga_normal" class="form-control" value="<?=$produk->harga_normal?>" required>
                </div>
                <div class="form-group">
                    <label>Harga Member</label>
                    <input type="text" name="harga_member" class="form-control" value="<?=$produk->harga_member?>" required>
                </div>
                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" min="0" name="jumlah" class="form-control" value="<?=$produk->jumlah?>" required>
                </div>
                <div class="form-group">
                    <label>Poin</label>
                    <input type="number" min="0" name="poin" class="form-control" value="<?=$produk->poin?>" required>
                </div>
                <div class="form-group">
                    <label>Gambar</label>
                    <input type="file" name="gambar" class="form-control" style="height: auto;">
                </div>
            	<button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            	<a href="<?= base_url() ?>/admin/kategori" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Kembali</a>
            </form>
        </div>
    </div>
</div>