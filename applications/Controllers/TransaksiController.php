<?php
namespace App\Controllers;
if (!defined('Z_MVC')) die ("Not Allowed");

use App\Models\Transaksi;

class TransaksiController
{
	function __construct()
	{
		if(!session()->get('id') || session()->user()->level == "admin")
		{
			redirect(base_url());
			die();
		}
	}

	function index()
	{
		$user = session()->user();
		$transaksi = Transaksi::where('id_kustomer',$user->kustomer()->id)->orderby('id','desc')->get();
		return view("transaksi.index",[
			'transaksi' => $transaksi
		]);
	}

}