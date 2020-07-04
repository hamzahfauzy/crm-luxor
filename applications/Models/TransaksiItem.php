<?php
namespace App\Models;
use Model;

class TransaksiItem extends Model
{
	static $table = "transaksi_item";

	function produk()
	{
		return $this->hasOne(Produk::class, ['id'=>'id_produk']);
	}

	function transaksi()
	{
		return $this->hasOne(Transaksi::class,['id'=>'id_transaksi']);
	}
}