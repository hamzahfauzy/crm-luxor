<?php
namespace App\Controllers\Admin;
if (!defined('Z_MVC')) die ("Not Allowed");

use App\Models\Shipping;
use App\Models\ShippingItem;
use App\Helpers\AdminMiddleware;

class ShippingController
{

	function __construct()
	{
		new AdminMiddleware;
	}

	function index()
	{
		$shipping = Shipping::get();
		return view("admin.shipping.index",[
			'shipping' => $shipping
		]);
	}

	function tambah()
	{
		$request = request()->post();
		$msg     = "";
		if($request)
		{
			$shipping = new Shipping;
			$shipping->save([
				'nama' => $request->nama
			]);
			$msg = "Berhasil Menambah Shipping";
		}
		return view("admin.shipping.tambah",[
			"msg" => $msg
		]);
	}

	function edit($id)
	{
		$request  = request()->post();
		$shipping = Shipping::find($id);
		$msg      = "";
		if($request)
		{
			$shipping->save([
				'nama' => $request->nama
			]);

			$shipping = Shipping::find($id);
			$msg = "Berhasil Mengedit Shipping";
		}
		return view("admin.shipping.edit",[
			"msg" => $msg,
			'shipping' => $shipping
		]);
	}

	function hapus($id)
	{
		Shipping::delete($id);
		session()->set('msg','Shipping Berhasil di Hapus');
		redirect(base_url()."/admin/shipping");
	}

	function kurir($id)
	{
		$shipping = Shipping::find($id);
		$kurir    = $shipping->items();
		return view('admin.shipping.kurir.index',[
			'shipping' => $shipping,
			'kurir'    => $kurir
		]);
	}

	function tambahkurir($id)
	{
		$shipping = Shipping::find($id);
		$request  = request()->post();
		$msg      = "";
		if($request)
		{
			$kurir = new ShippingItem;
			$kurir->save([
				'id_shipping' => $request->id_shipping,
				'nama' 		  => $request->nama,
				'harga_kirim' => $request->harga
			]);
			$msg = "Berhasil Menambah Kurir";
		}
		return view("admin.shipping.kurir.tambah",[
			"msg" => $msg,
			"shipping" => $shipping
		]);
	}

	function editkurir($id)
	{
		$kurir    = ShippingItem::find($id);
		$shipping = Shipping::find($kurir->id_shipping);
		$request  = request()->post();
		$msg      = "";
		if($request)
		{
			$kurir->save([
				'id_shipping' => $request->id_shipping,
				'nama' 		  => $request->nama,
				'harga_kirim' => $request->harga
			]);
			$msg   = "Berhasil Mengedit Kurir";
			$kurir = ShippingItem::find($id);
		}
		return view("admin.shipping.kurir.edit",[
			"msg" => $msg,
			"kurir"    => $kurir,
			"shipping" => $shipping
		]);
	}

	function hapuskurir($id)
	{
		$kurir = ShippingItem::find($id);
		ShippingItem::delete($id);
		session()->set('msg','Kurir Berhasil di Hapus');
		redirect(base_url()."/admin/shipping/kurir/".$kurir->id_shipping);
	}
}