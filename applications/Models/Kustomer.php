<?php
namespace App\Models;
use Model;

class Kustomer extends Model
{
    static $table = "kustomer";

    function user()
    {
    	return $this->hasOne(User::class,['id'=>'id_pengguna']);
    }
}