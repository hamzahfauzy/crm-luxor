            <div style="width: 900px;margin:auto;">
                <table width="100%">
                    <tr>
                        <td width="100px">
                            <img src="<?= asset('assets/logo.png') ?>" height="80px" width="100px" style="object-fit: contain;">
                        </td>
                        <td style="text-align: center;">
                            <center>
                            <h1 style="margin:0;padding:0">PT. LUXOR INDONESIA</h1>
                            <h2 style="margin:0;padding:0">STOKIS KISARAN</h2>
                            <p>Dr.Wahidin No.37 Kisaran, Kabupaten Asahan, email: luxorkisaran@gmail.com</p>
                            </center>
                        </td>
                    </tr>
                </table>
                <hr>
                <center>
                <h2>Laporan Transaksi</h2>
                </center>
                <b>Dari Tanggal</b> : <?= $_GET['from'] ?><br>
                <b>Sampai Tanggal</b> : <?= $_GET['to'] ?><br>
                <p></p>
                <table border="1" cellspacing="0" cellpadding="5" width="100%">
                    <thead>
                        <tr>
                            <th width="20px">#</th>
                            <th>Kustomer</th>
                            <th>Tanggal</th>
                            <th>Bukti</th>
                            <th>Total</th>
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
                                <br>
                                <b>
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
                                </b>
                            </td>
                            <td><?= $value->tanggal ?></td>
                            <td>
                                <?php if($value->bukti): ?>
                                <img src="<?= $value->bukti ?>" width="100%">
                                <?php else: ?>
                                Bukti Belum dikirim
                                <?php endif ?>
                                <?php if($value->status == 2): ?>
                                    <?php if($value->resi == ""): ?>
                                    
                                    <?php else: ?>
                                    <br>Resi : <?= $value->resi ?>
                                    <?php endif ?>
                                <?php endif ?>
                            </td>
                            <td>Rp. <?= number_format($value->total()) ?></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <script type="text/javascript">
                window.print()
            </script>