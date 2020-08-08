<?php 
$this->title .= " | Order"; 
$this->visited = "order";

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
                <h2>Order</h2>
                <div class="table-panel">
                    <div class="panel-content">
                        <form action="<?=base_url()?>/admin/order">
                        <div class="form-inline">
                            <label>Laporan</label>&nbsp;
                            <input type="date" name="from" id="from" value="<?= @$_GET['from']?>" class="form-control">&nbsp;
                            <input type="date" name="to" id="to" value="<?= @$_GET['to']?>" class="form-control">&nbsp;
                            <button class="btn btn-primary"><i class="fa fa-search"></i> Filter</button>&nbsp;
                            <a href="#" class="btn btn-success" onclick="location='<?=base_url()?>/admin/order/laporan/?from='+from.value+'&to='+to.value"><i class="fa fa-print"></i> Cetak</a>
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
                            <th>Kustomer</th>
                            <th>Tanggal</th>
                            <th>Bukti</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($transaksi)) : ?>
                        <tr>
                            <td colspan="5"><i>Tidak ada data!</i></td>
                        </tr>
                        <?php endif; $no = 1; ?>
                        <?php foreach($transaksi as $value): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <?= $value->kustomer()->nama ?>
                                <br>
                                <?php if($value->status == 1 && $value->bukti == ""){ ?>
                                <span class="badge badge-warning">Bukti Transfer Belum dikirim</span>
                                <?php }elseif($value->status == 1 && $value->bukti != ""){ ?>
                                <span class="badge badge-primary">Bukti Transfer Sudah dikirim</span>
                                <?php }elseif($value->status == 2){ ?>
                                <span class="badge badge-success">Pembayaran Sudah Diterima</span>
                                <?php }elseif($value->status == 3){ ?>
                                <span class="badge badge-success">Transaksi Selesai</span>
                                <?php }elseif($value->status == 4){ ?>
                                <span class="badge badge-danger">Pembayaran Di Tolak</span>
                                <?php } ?>
                            </td>
                            <td><?= $value->tanggal ?></td>
                            <td>
                                <?php if($value->bukti): ?>
                                <a href="<?= $value->bukti ?>" target="_blank">Bukti</a>
                                <?php else: ?>
                                Bukti Belum dikirim
                                <?php endif ?>
                                <?php if($value->status == 2): ?>
                                    <?php if($value->resi == ""): ?>
                                    <form method="post" action="<?=base_url()?>/admin/order/resi">
                                        <input type="hidden" name="id" value="<?=$value->id?>">
                                        <div class="form-group">
                                            <label>Resi</label>
                                            <input type="text" name="resi" class="form-control">
                                        </div>
                                        <button class="btn btn-success">Simpan</button>
                                    </form>
                                    <?php else: ?>
                                    <br>Resi : <?= $value->resi ?>
                                    <?php endif ?>
                                <?php endif ?>
                            </td>
                            <td>Rp. <?= number_format($value->total()) ?></td>
                            <td>
                                <a href="<?= base_url() ?>/home/detailTransaksi/<?=$value->kode?>"><i class="fa fa-eye"></i> Detail</a>
                                <?php if(session()->user()->level == "admin"): ?>
                                <?php if($value->status == 1): ?>
                                |
                                <a href="<?= base_url() ?>/admin/order/terima/<?=$value->id?>"><i class="fa fa-check"></i> Terima</a>
                                |
                                <a href="<?= base_url() ?>/admin/order/tolak/<?=$value->id?>"><i class="fa fa-times"></i> Tolak</a>
                                <?php endif ?>
                                <?php endif ?>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>