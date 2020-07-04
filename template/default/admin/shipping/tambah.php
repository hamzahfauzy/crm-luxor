<?php 
$this->title .= " | Tambah Shipping"; 
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
        	<h2>Tambah Shipping</h2>
            <form method="post">
            	<?php if($msg): ?>
            	<div class="alert alert-success"><?= $msg ?></div>
            	<?php endif ?>
            	<div class="form-group">
            		<label>Nama Shipping</label>
            		<input type="text" name="nama" class="form-control" required>
            	</div>
            	<button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
            	<a href="<?= base_url() ?>/admin/shipping" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Kembali</a>
            </form>
        </div>
    </div>
</div>