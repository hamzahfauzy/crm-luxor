<?php 
$this->title .= " | Tambah Kurir"; 
$this->visited = "shipping";

$this->js = [
    asset('js/sweetalert2@9.js'),
    asset('js/sweetalert2.min.js'),
];
?>
<link rel="stylesheet" href="<?= asset('css/wordpress-admin.css') ?>">
<div class="">
    <div class="row">
        <div class="col-sm-12 col-md-4 mx-auto">
        	<h2>Tambah Kurir</h2>
            <form method="post">
            	<?php if($msg): ?>
            	<div class="alert alert-success"><?= $msg ?></div>
            	<?php endif ?>
                <input type="hidden" name="id_shipping" value="<?=$shipping->id?>">
            	<div class="form-group">
            		<label>Nama Kurir</label>
            		<input type="text" name="nama" class="form-control" required>
            	</div>
                <div class="form-group">
                    <label>Harga</label>
                    <input type="text" name="harga" class="form-control" required>
                </div>
            	<button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            	<a href="<?= base_url() ?>/admin/shipping/kurir/<?=$shipping->id?>" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Kembali</a>
            </form>
        </div>
    </div>
</div>