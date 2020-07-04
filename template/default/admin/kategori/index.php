<?php 
$this->title .= " | Kategori"; 
$this->visited = "kategori";

$this->js = [
    asset('js/sweetalert2@9.js'),
    asset('js/sweetalert2.min.js'),
];
?>
<link rel="stylesheet" href="<?= asset('css/wordpress-admin.css') ?>">
<div class="">
    <div class="row">
        <div class="col-sm-12">
            <div class="content-wrapper">
                <h2>Kategori</h2>
                <div class="table-panel">
                    <div class="panel-content">
                        <a href="<?= base_url()?>/admin/kategori/tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                    </div>
                    <div class="panel-content not-grow">
                        <form>
                        <div class="form-inline">
                            <input type="text" name="keyword" class="form-control" placeholder="Kata Kunci.." onkeyup="filterKategori(this.value)">
                            &nbsp;
                            <button class="btn btn-success"><i class="fa fa-search"></i> Cari</button>
                        </div>
                        </form>
                    </div>
                </div>
                <?php if($msg = session()->get('msg')): ?>
                <div class="alert alert-success"><?= $msg ?></div>
                <?php session()->reset('msg'); endif ?>
                <table class="table table-bordered table-striped table-kategori">
                    <thead>
                        <tr>
                            <th width="20px">#</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($kategori)) : ?>
                        <tr>
                            <td colspan="3"><i>Tidak ada data!</i></td>
                        </tr>
                        <?php endif; $no = 1; ?>
                        <?php foreach($kategori as $value): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $value->nama ?></td>
                            <td>
                                <a href="<?= base_url() ?>/admin/kategori/edit/<?=$value->id?>"><i class="fa fa-pencil"></i> Edit</a>
                                |
                                <a href="<?= base_url() ?>/admin/kategori/hapus/<?=$value->id?>" onclick="event.preventDefault(); var c=confirm('Apakah anda yakin akan menghapus data ini'); if(c) location=this.href"><i class="fa fa-trash"></i> Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>