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

	function shipping($dest,$courier){
		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "origin=15&destination=$dest&weight=1700&courier=$courier",
		CURLOPT_HTTPHEADER => array(
			"content-type: application/x-www-form-urlencoded",
			"key: e07825fee157e94745b2c7d0e31c5953"
		),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		$results = json_decode($response);

		$results->name = $results->rajaongkir->results[0]->name;
		$results->province = $results->rajaongkir->destination_details->province;
		$results->city = $results->rajaongkir->destination_details->city_name;

		return $results;
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