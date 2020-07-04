<?php
namespace App\Controllers\Admin;
if (!defined('Z_MVC')) die ("Not Allowed");

use App\Models\Produk;
use App\Models\Kategori;
use App\Helpers\AdminMiddleware;
use App\Helpers\Uploader;

class ProdukController
{

	function __construct()
	{
		new AdminMiddleware;
	}

	function kategori()
	{
		return Kategori::get();
	}

	function index()
	{
		$produk = Produk::get();
		return view("admin.produk.index",[
			'produk' => $produk
		]);
	}

	function tambah()
	{
		$request = request()->post();
		$file    = request()->file();
		$msg     = "";
		if($request)
		{
			$file_path = Uploader::upload($file->gambar, "public/uploads", strtotime("now"));
			$produk = new Produk;
			$produk->save([
				'id_kategori' => $request->id_kategori,
				'nama'        => $request->nama,
				'deskripsi'   => $request->deskripsi,
				'berat'   	  => $request->berat,
				'harga_normal'=> $request->harga_normal,
				'harga_member'=> $request->harga_member,
				'jumlah'      => $request->jumlah,
				'gambar'      => $file_path,
				'poin'        => $request->poin,
			]);
			$msg = "Berhasil Menambah Produk";
		}
		return view("admin.produk.tambah",[
			"msg" => $msg,
			'kategori' => $this->kategori()
		]);
	}

	function edit($id)
	{
		$request = request()->post();
		$produk  = Produk::find($id);
		$file    = request()->file();
		$msg     = "";
		if($request)
		{
			if(!$file->gambar->error)
			{
				$file_path = Uploader::upload($file->gambar, "public/uploads", strtotime("now"));
				$produk->save([
					'id_kategori' => $request->id_kategori,
					'nama'        => $request->nama,
					'deskripsi'   => $request->deskripsi,
					'berat'   	  => $request->berat,
					'harga_normal'=> $request->harga_normal,
					'harga_member'=> $request->harga_member,
					'jumlah'      => $request->jumlah,
					'gambar'      => $file_path,
					'poin'        => $request->poin,
				]);
			}
			else
			{
				$produk->save([
					'id_kategori' => $request->id_kategori,
					'nama'        => $request->nama,
					'deskripsi'   => $request->deskripsi,
					'berat'   	  => $request->berat,
					'harga_normal'=> $request->harga_normal,
					'harga_member'=> $request->harga_member,
					'jumlah'      => $request->jumlah,
					'poin'        => $request->poin,
				]);
			}

			$produk = Produk::find($id);
			$msg = "Berhasil Mengedit Produk";
		}
		return view("admin.produk.edit",[
			"msg" => $msg,
			'produk' => $produk,
			'kategori' => $this->kategori()
		]);
	}

	function hapus($id)
	{
		Produk::delete($id);
		session()->set('msg','Produk Berhasil di Hapus');
		redirect(base_url()."/admin/produk");
	}
}