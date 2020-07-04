<?php 
$this->title .= " | Transaksi"; 
$this->visited = "transaksi";

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
                <h2>Transaksi</h2>

                <?php if($msg = session()->get('msg')): ?>
                <div class="alert alert-success"><?= $msg ?></div>
                <?php session()->reset('msg'); endif ?>
                <table class="table table-bordered table-striped table-kategori">
                    <thead>
                        <tr>
                            <th width="20px">#</th>
                            <th>Bukti</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($transaksi)) : ?>
                        <tr>
                            <td colspan="4"><i>Tidak ada data!</i></td>
                        </tr>
                        <?php endif; $no = 1; ?>
                        <?php foreach($transaksi as $value): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <?php if($value->bukti): ?>
                                <a href="<?= $value->bukti ?>" target="_blank">Bukti</a>
                                <?php else: ?>
                                Bukti Belum dikirim
                                <?php endif ?>
                            </td>
                            <td>Rp. <?= number_format($value->total()) ?></td>
                            <td>
                                <a href="<?= base_url() ?>/home/detailTransaksi/<?=$value->kode?>"><i class="fa fa-eye"></i> Detail</a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>