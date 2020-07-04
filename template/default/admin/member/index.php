<?php 
$this->title .= " | Member"; 
$this->visited = "member";

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
                <h2>Member</h2>
                <div class="table-panel">
                    <div class="panel-content">
                        <!-- <a href="<?= base_url()?>/admin/shipping/tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a> -->
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
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($users)) : ?>
                        <tr>
                            <td colspan="6"><i>Tidak ada data!</i></td>
                        </tr>
                        <?php endif; $no = 1; ?>
                        <?php 
                        foreach($users as $value): 
                            $customer = $value->kustomer();
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $customer->nama ?></td>
                            <td><?= $customer->alamat ?></td>
                            <td><?= $customer->email ?></td>
                            <td><?= $customer->no_hp ?></td>
                            <td>
                                <a href="<?= base_url() ?>/admin/member/hapus/<?=$value->id?>" onclick="event.preventDefault(); var c=confirm('Apakah anda yakin akan menghapus data ini'); if(c) location=this.href"><i class="fa fa-trash"></i> Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>