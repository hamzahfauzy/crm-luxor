<?php
namespace App\Controllers\Admin;
if (!defined('Z_MVC')) die ("Not Allowed");

use App\Models\Kategori;
use App\Helpers\AdminMiddleware;

class KategoriController
{

	function __construct()
	{
		new AdminMiddleware;
	}

	function index()
	{
		$kategori = Kategori::get();
		return view("admin.kategori.index",[
			'kategori' => $kategori
		]);
	}

	function tambah()
	{
		$request = request()->post();
		$msg     = "";
		if($request)
		{
			$kategori = new Kategori;
			$kategori->save([
				'nama' => $request->nama
			]);
			$msg = "Berhasil Menambah Kategori";
		}
		return view("admin.kategori.tambah",[
			"msg" => $msg
		]);
	}

	function edit($id)
	{
		$request  = request()->post();
		$kategori = Kategori::find($id);
		$msg      = "";
		if($request)
		{
			$kategori->save([
				'nama' => $request->nama
			]);

			$kategori = Kategori::find($id);
			$msg = "Berhasil Mengedit Kategori";
		}
		return view("admin.kategori.edit",[
			"msg" => $msg,
			'kategori' => $kategori
		]);
	}

	function hapus($id)
	{
		Kategori::delete($id);
		session()->set('msg','Kategori Berhasil di Hapus');
		redirect(base_url()."/admin/kategori");
	}
}