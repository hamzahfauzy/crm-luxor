<?php
namespace App\Controllers\Admin;

use App\Helpers\AdminMiddleware;
use App\Models\User;

class MemberController
{
	function __construct()
	{
		new AdminMiddleware;
	}

	function index()
	{
		$users = User::where('level','customer')->get();
		return view('admin.member.index',[
			'users' => $users
		]);
	}

	function hapus($id)
	{
		User::delete($id);
		session()->set('msg','Member Berhasil di Hapus');
		redirect(base_url()."/admin/member");
	}
}