<?php
namespace App\Models;
use Model;

class Transaksi extends Model
{
	static $table = "transaksi";

	function kustomer()
	{
		return $this->hasOne(Kustomer::class,['id'=>'id_kustomer']);
	}

	function items()
	{
		return $this->hasMany(TransaksiItem::class,['id_transaksi'=>'id']);
	}

	function kurir()
	{
		return $this->hasOne(ShippingItem::class,['id'=>'id_kurir']);
	}

	function total()
	{
		$total = 0;
		$member = $this->kustomer()->id_pengguna == 0 ? false : 1;
		foreach($this->items() as $value)
		{
			$value->produk(); 
        	$harga = $member ? $value->produk->harga_member : $value->produk->harga_normal;
        	$total += ($value->jumlah*$harga);
		}

		$harga_kirim = $this->kurir()->harga_kirim;
		return $total+$harga_kirim;
	}
}