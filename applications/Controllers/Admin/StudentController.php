<?php
namespace App\Controllers\Admin;
if (!defined('Z_MVC')) die ("Not Allowed");

class StudentController
{
	function index()
	{
		return "Hello Student Index";
	}

	function show($name)
	{
		return "Show Student $name";
	}

	function view()
	{
		return ['name'=>'Student 1'];
	}
}