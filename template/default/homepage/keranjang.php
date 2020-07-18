<?php 
$this->title .= ' | Keranjang';
$this->visited = "keranjang";
?>
<h2>Keranjang Belanja</h2>
<?php if(session()->get('cart')): ?>
<div class="">
    <div class="row">
        <div class="col-sm-12">
            <?php if($msg = session()->get('msg')): ?>
            <div class="alert alert-success"><?= $msg ?></div>
            <?php session()->reset('msg'); endif ?>
            <table class="table table-bordered table-striped table-kategori">
                <thead>
                    <tr>
                        <th width="20px">#</th>
                        <th></th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    $total = 0;
                    $total_poin = 0;
                    foreach(session()->get('cart') as $key => $value): 
                    	$total_poin += ($value['jumlah']*$value['poin']);
                	endforeach;
                    foreach(session()->get('cart') as $key => $value): 
                    	$harga = ($total_poin >= app()['min_poin']) || session()->get('id') ? $value['harga_member'] : $value['harga_normal'];
                    	$total += ($value['jumlah']*$harga);
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td width="100px">
                        	<img src="<?= $value['gambar'] ?>" width="100%">
                        </td>
                        <td>
                        	<?= $value['nama'] ?><br>
                        	<a href="<?= base_url() ?>/home/cancel/<?=$key?>"><i class="fa fa-trash"></i> Hapus</a>
                        </td>
                        <td width="200px">
                        	<div class="form-group d-flex">
                        		<input type="number" class="form-control" id="jumlah<?=$value['id']?>" name="jumlah" value="<?= $value['jumlah'] ?>">
                        		<span>&nbsp;</span>
                        		<button class="btn btn-success" onclick="location='<?=base_url()?>/home/beli/<?=$value['id']?>?jumlah='+jumlah<?=$value['id']?>.value">Update</button>
                        	</div>
                        </td>
                        <td>Rp. <?= number_format($value['jumlah']*$harga) ?></td>
                    </tr>
                    <?php endforeach ?>
                    <tr>
                    	<td></td>
                    	<td></td>
                    	<td></td>
                    	<td><b>Sub Total</b></td>
                    	<td>
                    		Rp. <?=number_format($total)?>
                    		<span id="sub_total" style="display: none;"><?=$total?></span>
                    	</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-12 col-md-6">
        	<form method="post" action="<?= base_url() ?>/home/selesai">
        	<h2>Kustomer Detail</h2>
        	<?php if(!session()->get('id')): ?>
        	<div class="form-group">
        		<label>Nama Lengkap</label>
        		<input type="text" name="nama" class="form-control" required="">
        	</div>
        	<div class="form-group">
        		<label>Alamat</label>
        		<input type="text" name="alamat" class="form-control" required="">
        	</div>
        	<div class="form-group">
        		<label>Jenis Kelamin</label>
        		<select class="form-control" name="jenis_kelamin" required="">
        			<option value="">- Pilih -</option>
        			<option value="Laki-laki">Laki-laki</option>
        			<option value="Perempuan">Perempuan</option>
        		</select>
        	</div>
        	<div class="form-group">
        		<label>Email</label>
        		<input type="text" name="email" class="form-control" required="">
        	</div>
        	<div class="form-group">
        		<label>No. HP</label>
        		<input type="text" name="no_hp" class="form-control" required="">
        	</div>
        	<?php if($total_poin >= app()['min_poin']): ?>
    		<b>Total poin anda sudah berada pada minimal poin untuk menjadi member. (Harga di atas sudah termasuk harga member)</b><br>
    		<p></p>
    		<div class="form-group">
        		<label>Username</label>
        		<input type="text" name="username" class="form-control" required="">
        	</div>
        	<div class="form-group">
        		<label>Password</label>
        		<input type="password" name="password" class="form-control" required="">
        	</div>
    		<?php endif ?>
    		<?php else: $customer = session()->user()->kustomer(); ?>
    		<div class="form-group">
        		<label>Nama Lengkap</label>
        		<input type="text" class="form-control" value="<?= $customer->nama ?>" disabled="">
        	</div>
        	<div class="form-group">
        		<label>Alamat</label>
        		<input type="text" class="form-control" value="<?= $customer->alamat ?>" disabled="">
        	</div>
        	<div class="form-group">
        		<label>Jenis Kelamin</label>
        		<input type="text" class="form-control" value="<?= $customer->jenis_kelamin ?>" disabled="">
        	</div>
        	<div class="form-group">
        		<label>Email</label>
        		<input type="text" class="form-control" value="<?= $customer->email ?>" disabled="">
        	</div>
        	<div class="form-group">
        		<label>No. HP</label>
        		<input type="text" class="form-control" value="<?= $customer->no_hp ?>" disabled="">
        	</div>
    		<?php endif ?>
        </div>
        <div class="col-sm-12 col-md-6">
        	<h2>Kurir</h2>
        	<div class="form-group">
        		<label>Provinsi</label>
        		<select class="form-control" name="province" id="id_provinsi" required="">
        			<option value="">- Pilih -</option>
        			<?php foreach($provinces as $province): ?>
        			<option value="<?= $province->province_id ?>"><?=$province->province?></option>
        			<?php endforeach ?>
        		</select>
        	</div>
        	<div class="form-group" id="p-city" style="display:none">
        		<label>Kabupaten</label>
        		<select class="form-control" name="city" id="id_kabupaten" required="">
        			<option value="">- Pilih -</option>
        		</select>
        	</div>
        	<div class="form-group" id="p-courier" style="display:none">
        		<label>Kurir</label>
        		<select class="form-control" name="courier" id="courier" required="">
        			<option value="">- Pilih -</option>
        			<option value="jne">JNE</option>
        			<option value="pos">POS</option>
        			<option value="tiki">TIKI</option>
        		</select>
        	</div>
        	<div class="form-group" id="p-service" style="display:none">
        		<label>Servis</label>
        		<select class="form-control" name="service" id="service" required="">
        			<option value="">- Pilih -</option>
        		</select>
        	</div>
			<input type="hidden" name="ongkir" id="ongkir" >
        	<div class="form-group">
        		<label>Harga</label>
        		<input type="text" id="harga" disabled="" class="form-control">
        	</div>
        	<div class="form-group">
        		<label>Total Transaksi</label>
        		<input type="text" id="total_transaksi" disabled="" class="form-control">
        	</div>
        	<div class="form-group">
        		<label>&nbsp;</label><br>
        		<button class="btn btn-primary btn-block">Buat Order</button>
        	</div>
        	</form>
        </div>
    </div>
</div>
<?php else: ?>
<center><i>Tidak ada data</i></center>
<?php endif ?>

<script type="text/javascript">
var provinsi = document.querySelector("#id_provinsi")
var kabupaten = document.querySelector("#id_kabupaten")
var courier = document.querySelector("#courier")
var service = document.querySelector("#service")

var pCity = document.querySelector("#p-city")
var pCourier = document.querySelector("#p-courier")
var pService = document.querySelector("#p-service")

provinsi.onchange = async () => {
	var response = await fetch('<?=base_url()?>/home/get_cities/'+provinsi.value)
	var data     = await response.json()

	pCity.style.display = "block"

	kabupaten.innerHTML = "<option value=''>- Pilih -</option>"
	data.forEach(val => {
		kabupaten.innerHTML += `<option value='${val.city_id}'>${val.city_name}</option>`
	})
}

kabupaten.onchange = () => {
	pCourier.style.display = "block"	
}

courier.onchange = async () => {
	var response = await fetch('<?=base_url()?>/home/get_costs/'+kabupaten.value+"?courier="+courier.value)
	var data     = await response.json()

	pService.style.display = "block";

	service.innerHTML = "<option value=''>- Pilih -</option>"
	data.forEach(val => {
		var price = new Intl.NumberFormat().format(val.cost[0].value)
		var etd = val.cost[0].etd
		service.innerHTML += `<option value='${val.cost[0].value}'>${val.service} ( Rp. ${price} - ${etd} Hari )</option>`
	})
}

service.onchange = () => {
	var harga = new Intl.NumberFormat().format(service.value)
	var sub_total = document.querySelector("#sub_total").innerHTML
	var total_transaksi = parseInt(harga) + parseInt(sub_total)
	total_transaksi = new Intl.NumberFormat().format(total_transaksi)
	document.querySelector("#ongkir").value = service.value
	document.querySelector("#harga").value = "Rp. "+harga
	document.querySelector("#total_transaksi").value = "Rp. "+total_transaksi
}
</script>