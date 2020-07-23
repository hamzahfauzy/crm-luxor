<?php
namespace App\Controllers\Admin;
if (!defined('Z_MVC')) die ("Not Allowed");

use App\Models\Transaksi;
use App\Models\TransaksiItem;
use App\Models\Produk;

class OrderController
{
	function __construct()
	{
		if(!session()->get('id') || session()->user()->level == "customer")
		{
			redirect(base_url());
			die();
		}
	}

	function laporan()
	{
		$request = request()->get();
		$transaksi = Transaksi::where('tanggal','BETWEEN',$request->from."' AND '".$request->to)->orderby('id','desc')->get();
		// $transaksi = Transaksi::runRaw("SELECT * FROM transaksi WHERE tanggal BETWEEN '".$request->from."' AND '".$request->to."'");
		return partial("admin.order.laporan",[
			'transaksi' => $transaksi
		]);

	}

	function index()
	{
		$request = request()->get();
		if($request)
			$transaksi = Transaksi::where('tanggal','BETWEEN',$request->from."' AND '".$request->to)->orderby('id','desc')->get();
		else
			$transaksi = Transaksi::orderby('id','desc')->get();
		// return view("admin.order.index",[
		// 	'transaksi' => $transaksi
		// ]);
		return view("admin.order.index",[
			'transaksi' => $transaksi
		]);
	}

	function terima($id)
	{
		$transaksi = Transaksi::find($id);
		$transaksi->save([
			'status' => 2
		]);

		$t_item = TransaksiItem::where('id_transaksi',$id)->first();

		$produk = Produk::find($t_item->id_produk);

		$produk->save([
			'jumlah'=>$produk->jumlah - $t_item->jumlah
		]);

		session()->set('msg','Transaksi berhasil di terima');
		redirect(base_url()."/admin/order");
		return false;
	}

	function tolak($id)
	{
		$transaksi = Transaksi::find($id);
		$transaksi->save([
			'status' => 4
		]);

		session()->set('msg','Transaksi berhasil di tolak');
		redirect(base_url()."/admin/order");
		return false;
	}

	function resi()
	{
		$request   = request()->post();
		if($request)
		{
			$transaksi = Transaksi::find($request->id);
			$transaksi->save([
				'resi' => $request->resi
			]);
			session()->set('msg','Resi berhasil di input');
			redirect(base_url()."/admin/order");
			return false;
		}
	}
}