<?php 
$this->title .= ' | Profil';
$this->visited = "profil";
$customer = session()->user()->kustomer();
?>

<div class="container">
	<div class="row">
		<div class="col-sm-12 col-md-6 mx-auto">
			<h2>Profil</h2>
			<table class="table table-bordered">
				<tr>
					<td>Nama</td>
					<td>:</td>
					<td><?= $customer->nama ?></td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td>:</td>
					<td><?= $customer->alamat ?></td>
				</tr>
				<tr>
					<td>Jenis Kelamin</td>
					<td>:</td>
					<td><?= $customer->jenis_kelamin ?></td>
				</tr>
				<tr>
					<td>No HP</td>
					<td>:</td>
					<td><?= $customer->no_hp ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>