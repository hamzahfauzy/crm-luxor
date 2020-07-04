<?php
namespace App\Controllers\Admin;

use App\Helpers\AdminMiddleware;
use App\Models\Konsultasi;
use App\Models\KonsultasiItem;

class KonsultasiController
{
	function __construct()
	{
		new AdminMiddleware;
	}

	function index()
	{
		$konsultasi = Konsultasi::orderby('updated_at','desc')->get();
		return view('admin.konsultasi.index',[
			'konsultasi' => $konsultasi
		]);
	}

	function detail($id)
	{
		return view('admin.konsultasi.detail',[
			'id' => $id
		]);
	}

	function loadChat($id)
	{
		$konsultasi = Konsultasi::find($id);
		if(empty($konsultasi)) return [];
		$konsultasi->user();
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

	function sendChat($id)
	{
		$request = request()->post();
		$konsultasi = Konsultasi::find($id);
		$konsultasi_id = $konsultasi->id;
		$konsultasi->save([
			'belum_dibaca' => 0,
			'tipe'         => 2,
			'updated_at'   => 'CURRENT_TIMESTAMP'
		]);
		$konsultasi_item = new KonsultasiItem;
		$konsultasi_item->save([
			'id_konsultasi' => $konsultasi_id,
			'konten'		=> $request->konten,
			'tipe'			=> 2,
			'tanggal'  => 'CURRENT_TIMESTAMP',
		]);
		return ['success'=>1];
	}
}