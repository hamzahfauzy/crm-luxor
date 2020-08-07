<?php
namespace App\Controllers;
if (!defined('Z_MVC')) die ("Not Allowed");

use App\Models\User;
use App\Models\Produk;
use App\Models\Shipping;
use App\Models\Kustomer;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use App\Models\Konsultasi;
use App\Models\KonsultasiItem;
use App\Helpers\Uploader;

class HomeController
{

	public $apikey = "e07825fee157e94745b2c7d0e31c5953";

	function index()
	{
		$produk = Produk::limit(0,8)->orderby('id','desc')->get();
		return view("homepage.index",[
			'produk' => $produk
		]);
	}

	function produk()
	{
		$produk = Produk::get();
		return view("homepage.produk",[
			'produk' => $produk
		]);
	}
	
	function get_provinces(){
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_SSL_VERIFYHOST=> 0,
			CURLOPT_SSL_VERIFYPEER=>0,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"key: $this->apikey"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		
		if($err)
			print_r($err);

		$results = json_decode($response);
		return $results->rajaongkir->results;
	}

	function get_cities($prov_id){
		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=$prov_id",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_SSL_VERIFYHOST=> 0,
		CURLOPT_SSL_VERIFYPEER=>0,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
			"key: $this->apikey"
		),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		$results = json_decode($response);

		echo json_encode($results->rajaongkir->results);
	}

	function get_costs($dest){
		$curl = curl_init();

		$courier = $_GET['courier'];

		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_SSL_VERIFYHOST=> 0,
		CURLOPT_SSL_VERIFYPEER=>0,
		CURLOPT_POSTFIELDS => "origin=15&destination=$dest&weight=1800&courier=$courier",
		CURLOPT_HTTPHEADER => array(
			"content-type: application/x-www-form-urlencoded",
			"key: $this->apikey"
		),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		$results = json_decode($response);

		echo json_encode($results->rajaongkir->results[0]->costs);
	}

	function keranjang()
	{
		$shipping = Shipping::orderby('nama','asc')->get();

		$results = $this->get_provinces();		
		
		return view("homepage.keranjang",[
			'shipping' => $shipping,
			'provinces' => $results
		]);
	}

	function profil()
	{
		return view("homepage.profil");
	}

	function beli($id)
	{
		$produk = Produk::find($id);
		if(isset($_SESSION['cart']))
		{
			$key = array_search($id, array_column($_SESSION['cart'], 'id'));
			if($key > -1)
			{
				$produk = $_SESSION['cart'][$key];
				$produk['jumlah'] = isset($_GET['jumlah']) ? $_GET['jumlah'] : $produk['jumlah']+1;
				$_SESSION['cart'][$key] = $produk;
			}
			else
			{
				$produk->jumlah = isset($_GET['jumlah']) ? $_GET['jumlah'] : 1;
				$_SESSION['cart'][] = (array) $produk;
			}
		}
		else
		{
			$produk->jumlah = isset($_GET['jumlah']) ? $_GET['jumlah'] : 1;
			$_SESSION['cart'][] = (array) $produk;
		}
		redirect(base_url().'/home/keranjang');
		die();
		return false;
	}

	function cancel($key)
	{
		unset($_SESSION['cart'][$key]);
		$_SESSION['cart'] = array_values($_SESSION['cart']);
		redirect(base_url().'/home/keranjang');
		die();
		return false;
	}

	function shipping($id)
	{
		$shipping = Shipping::find($id);
		return $shipping->items();
	}

	function selesai()
	{
		$request = request()->post();
		if(!session()->get('id'))
		{
			if(!isset($request->username))
			{
				// customer only
				$kustomer = new Kustomer;
				$id_kustomer = $kustomer->save([
					'id_pengguna'	=> 0,
					'nama' 			=> $request->nama,
					'alamat' 		=> $request->alamat,
					'jenis_kelamin' => $request->jenis_kelamin,
					'email' 		=> $request->email,
					'no_hp' 		=> $request->no_hp,
				]);
			}
			else
			{
				$user = new User;
				$id_pengguna = $user->save([
					'nama' => $request->nama,
					'email' => $request->email,
					'username' => $request->username,
					'password' => md5($request->password),
					'level'    => 'customer'
				]);

				session()->set('id',$id_pengguna);

				$kustomer = new Kustomer;
				$id_kustomer = $kustomer->save([
					'id_pengguna' 	=> $id_pengguna,
					'nama' 			=> $request->nama,
					'alamat' 		=> $request->alamat,
					'jenis_kelamin' => $request->jenis_kelamin,
					'email' 		=> $request->email,
					'no_hp' 		=> $request->no_hp,
				]);
			}
		}
		else
			$id_kustomer = session()->user()->kustomer()->id;

		$transaksi = new Transaksi;
		$id_transaksi = $transaksi->save([
			'id_kustomer' => $id_kustomer,
			'status'	  => 1,
			'tanggal'	  => date('Y-m-d'),
			'ongkir' => $request->ongkir,
			'id_provinsi' => $request->province,
			'id_kabupaten' => $request->city,
			'kurir' => $request->courier,
		]);

		$kode = substr(md5($id_transaksi), 0, 8);
		$kode = strtoupper($kode);

		$transaksi = Transaksi::where('id',$id_transaksi)->first();
		$transaksi->save([
			'kode' => $kode
		]);

		foreach(session()->get('cart') as $cart)
		{
			$transaksi_item = new TransaksiItem;
			$transaksi_item->save([
				'id_transaksi' => $id_transaksi,
				'id_produk'    => $cart['id'],
				'jumlah'    => $cart['jumlah'],
			]);
		}
		session()->reset('cart');
		redirect(base_url().'/home/detailTransaksi/'.$kode);
		return false;
	}

	function detailTransaksi($kode)
	{
		$transaksi = Transaksi::where('kode',$kode)->first();
		$transaksi->items();
		return view('homepage.detail-transaksi',[
			'transaksi' => $transaksi
		]);
	}

	function simpanBukti()
	{
		$request = request()->post();
		$file    = request()->file();
		$msg     = "";
		if($request)
		{
			$file_path = Uploader::upload($file->bukti, "public/uploads", strtotime("now"));
			$transaksi = Transaksi::find($request->id_transaksi);
			$kode      = $transaksi->kode;
			$transaksi->save([
				'bukti' => $file_path
			]);

			redirect(base_url().'/home/detailTransaksi/'.$kode);
			return false;
		}
	}

	function terima($kode)
	{
		$transaksi = Transaksi::where('kode',$kode)->first();
		$transaksi->save([
			'status' => 3
		]);

		redirect(base_url().'/home/transaksiSelesai/'.$kode);
		return false;
	}

	function transaksiSelesai($kode)
	{
		$transaksi = Transaksi::where('kode',$kode)->first();
		$transaksi->items();
		return view('homepage.transaksi-selesai',[
			'transaksi' => $transaksi
		]);
	}

	function simpanUlasan()
	{
		$request = request()->post();
		if($request)
		{
			$transaksi_item = TransaksiItem::find($request->id);
			$transaksi = $transaksi_item->transaksi();
			$transaksi_item->save([
				'rating' => $request->rating,
				'ulasan' => $request->ulasan,
			]);
			redirect(base_url().'/home/transaksiSelesai/'.$transaksi->kode);
			return false;
		}
	}

	function detail($id)
	{
		$produk = Produk::find($id);
		$transaksi_produk = TransaksiItem::where('id_produk',$id)->get();
		$ulasan = [];
		$rating = [];
		if(!empty($transaksi_produk))
		{
			$rating['length'] = 0;
			foreach($transaksi_produk as $p)
			{
				if($p->rating == "") continue;
				$ulasan[] = $p;
				$rating['rating'] += $p->rating;
				$rating['length'] += 1;
			}

			if($rating['length'] > 0)
				$rating['rating'] /= $rating['length'];

			$rating['rating'] = round($rating['rating']);
		}

		return view('homepage.detail',[
			'ulasan' => $ulasan,
			'rating' => $rating,
			'produk' => $produk
		]);
	}

	function cek()
	{
		return view('homepage.cek');
	}

	function konsultasi()
	{
		return view('homepage.konsultasi');
	}

	function startChat()
	{
		$request     = request()->post();
		$kustomer    = new Kustomer;
		$kustomer_id = $kustomer->save([
			'nama' => $request->name,
			'no_hp' => $request->phone,
		]);

		return ['id'=>$kustomer_id];
	}

	function loadChat()
	{
		$id 	 = isset($_GET['id']) ? $_GET['id'] : session()->user()->kustomer()->id;
		$konsultasi = Konsultasi::where('id_user',$id)->first();
		if(empty($konsultasi)) return [];
		
		$konsultasi->items();
		return $konsultasi;
	}

	function getChat()
	{
		// $konsultasi = Konsultasi::where('id_user',session()->get('id'))->first();
		// if(!empty($konsultasi))
		// {
		// 	if($konsultasi->belum_dibaca == 0)
		// 	$belum_dibaca = 0;
		// }
		return [];
	}

	function sendChat()
	{
		$request = request()->post();
		$id 	 = isset($_GET['id']) ? $_GET['id'] : session()->user()->kustomer()->id;
		$konsultasi = Konsultasi::where('id_user',$id)->first();
		if(empty($konsultasi))
		{
			$konsultasi    = new Konsultasi;
			$id_konsultasi = $konsultasi->save([
				'id_user'  => $id,
				'tanggal'  => date('Y-m-d'),
				'belum_dibaca' => 1,
				'tipe'         => 1,
				'updated_at'   => 'CURRENT_TIMESTAMP'
			]);

			$konsultasi_item = new KonsultasiItem;
			$konsultasi_item->save([
				'id_konsultasi' => $id_konsultasi,
				'konten'		=> $request->konten,
				'tipe'			=> 1,
				'tanggal'  => date('Y-m-d'),
			]);
		}
		else
		{
			$id_konsultasi = $konsultasi->id;
			$konsultasi->save([
				'belum_dibaca' => $konsultasi->belum_dibaca + 1,
				'tipe'         => 1,
				'updated_at'   => 'CURRENT_TIMESTAMP'
			]);

			$konsultasi_item = new KonsultasiItem;
			$konsultasi_item->save([
				'id_konsultasi' => $id_konsultasi,
				'konten'		=> $request->konten,
				'tipe'			=> 1,
				'tanggal'  => 'CURRENT_TIMESTAMP',
			]);
		}
		return ['success'=>1];
	}

}