<?php
namespace App\Controllers\Admin;
if (!defined('Z_MVC')) die ("Not Allowed");

class DashboardController
{
	function __construct()
	{
		if(!session()->get('id') || session()->user()->level != "admin")
		{
			redirect(base_url());
			die();
		}
	}

	function index()
	{
		return view("admin.dashboard.index");
	}
}