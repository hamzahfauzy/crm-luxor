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

	function keranjang()
	{
		$shipping = Shipping::orderby('nama','asc')->get();
		return view("homepage.keranjang",[
			'shipping' => $shipping
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
		if(!isset($request->username))
		{
			// customer only
			$kustomer = new Kustomer;
			$id_kustomer = $kustomer->save([
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

		$transaksi = new Transaksi;
		$id_transaksi = $transaksi->save([
			'id_kustomer' => $id_kustomer,
			'status'	  => 1,
			'tanggal'	  => date('Y-m-d'),
			'id_kurir' => $request->id_shipping_item
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
		$rating = 0;
		if(!empty($transaksi_produk))
		{
			$divide_by = 0;
			foreach($transaksi_produk as $p)
			{
				if($p->rating == "") continue;
				$ulasan[] = $p;
				$divide_by++;
				$rating += $p->rating;
			}

			if($divide_by > 0)
				$rating = $rating / $divide_by;
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

	function loadChat()
	{
		$konsultasi = Konsultasi::where('id_user',session()->get('id'))->first();
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
		$konsultasi = Konsultasi::where('id_user',session()->get('id'))->first();
		if(empty($konsultasi))
		{
			$konsultasi    = new Konsultasi;
			$id_konsultasi = $konsultasi->save([
				'id_user'  => session()->get('id'),
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